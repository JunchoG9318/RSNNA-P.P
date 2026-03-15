<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");

// Obtener información del usuario logueado desde la sesión
$usuario_id     = $_SESSION['usuario_id'];
$usuario_tipo   = $_SESSION['usuario_tipo'];
$usuario_nombre = $_SESSION['usuario_nombre'] ?? '';
$usuario_correo = $_SESSION['usuario_correo'] ?? '';

// Datos complementarios del usuario (pueden venir de funcionarios si se cargaron en sesión)
$usuario_tipo_documento = $_SESSION['usuario_tipo_documento'] ?? '';
$usuario_documento      = $_SESSION['usuario_documento'] ?? '';
$usuario_celular        = $_SESSION['usuario_celular'] ?? '';

// ID de la fundación asociada al usuario (debe estar en sesión)
$id_fundacion = $_SESSION['id_fundacion'] ?? 0;

// Variable para almacenar datos de la fundación
$fundacion_data = [];

// Si el usuario es de tipo fundación, obtener información completa de su fundación
if ($usuario_tipo == 'fundacion' && !empty($id_fundacion)) {
    $query_fundacion = "SELECT nombre, nit, direccion, telefono_director, correo_director, 
                               nombre_director, fecha_registro, estado
                        FROM fundaciones 
                        WHERE id = $id_fundacion";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);
    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $fundacion_data = mysqli_fetch_assoc($result_fundacion);
    }
}

// Función para obtener el representante legal
function obtenerRepresentanteLegal($conexion, $id_fundacion, $fundacion_data, $usuario_nombre, $usuario_correo, $usuario_tipo_documento, $usuario_documento, $usuario_celular) {
    // 1. Buscar en funcionarios un cargo directivo
    $query = "SELECT nombre, apellidos, tipo_documento, documento, cargo, correo, celular, 
                     fecha_inicio, fecha_registro, estado
              FROM funcionarios
              WHERE id_fundacion = $id_fundacion
                AND cargo IN ('Director', 'Representante Legal', 'Coordinador General', 'Administrador')
              LIMIT 1";
    $result = mysqli_query($conexion, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $row['nombre_completo'] = trim($row['nombre'] . ' ' . $row['apellidos']);
        // Usar fecha_inicio si está disponible, si no, fecha_registro
        $row['fecha_desde'] = $row['fecha_inicio'] ?? $row['fecha_registro'];
        return $row;
    }

    // 2. Si no hay funcionario directivo, usar datos de fundaciones (nombre_director, correo_director, telefono_director)
    if (!empty($fundacion_data['nombre_director'])) {
        return [
            'nombre_completo'    => $fundacion_data['nombre_director'],
            'tipo_documento'     => 'N/A',
            'documento'          => 'N/A',
            'cargo'              => 'Director',
            'correo'             => $fundacion_data['correo_director'] ?? 'N/A',
            'celular'            => $fundacion_data['telefono_director'] ?? 'N/A',
            'fecha_desde'        => $fundacion_data['fecha_registro'] ?? date('Y-m-d'),
            'estado'             => $fundacion_data['estado'] ?? 1
        ];
    }

    // 3. Último recurso: datos del usuario logueado (sesión)
    return [
        'nombre_completo'    => $usuario_nombre,
        'tipo_documento'     => $usuario_tipo_documento ?: 'N/A',
        'documento'          => $usuario_documento ?: 'N/A',
        'cargo'              => 'Representante',
        'correo'             => $usuario_correo ?: 'N/A',
        'celular'            => $usuario_celular ?: 'N/A',
        'fecha_desde'        => date('Y-m-d'),
        'estado'             => 1
    ];
}

$representante = obtenerRepresentanteLegal($conexion, $id_fundacion, $fundacion_data, $usuario_nombre, $usuario_correo, $usuario_tipo_documento, $usuario_documento, $usuario_celular);

// Contar total de funcionarios activos
$total_funcionarios = 0;
if ($usuario_tipo == 'fundacion' && !empty($id_fundacion)) {
    $query_count = "SELECT COUNT(*) as total FROM funcionarios WHERE id_fundacion = $id_fundacion AND estado = 1";
    $result_count = mysqli_query($conexion, $query_count);
    if ($result_count) {
        $count = mysqli_fetch_assoc($result_count);
        $total_funcionarios = $count['total'];
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                
                <!-- ENCABEZADO -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-0">
                            <i class="bi bi-building me-3"></i>FUNDACIÓN Y FUNCIONARIOS
                        </h2>
                        <p class="text-muted mt-2">Información completa de la fundación y su personal</p>
                    </div>
                    <span class="badge bg-primary text-white px-3 py-2">
                        <i class="bi bi-calendar3 me-2"></i><?php echo date('d/m/Y'); ?>
                    </span>
                </div>

                <!-- TABLA 1: INFORMACIÓN DE LA FUNDACIÓN -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-building fs-4 text-success me-3"></i>
                            <h5 class="fw-bold text-success mb-0">DATOS GENERALES DE LA FUNDACIÓN</h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">NOMBRE DE LA FUNDACIÓN</th>
                                        <th width="15%">NIT</th>
                                        <th width="15%">DIRECCIÓN</th>
                                        <th width="15%">TELÉFONO</th>
                                        <th width="15%">CORREO ELECTRÓNICO</th>
                                        <th width="20%">FECHA DE REGISTRO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($usuario_tipo == 'fundacion' && !empty($fundacion_data)): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo htmlspecialchars($fundacion_data['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['nit']); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['direccion'] ?? 'No registrada'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['telefono_director'] ?? 'No registrado'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['correo_director'] ?? 'No registrado'); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($fundacion_data['fecha_registro'])); ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <?php echo ($usuario_tipo != 'fundacion') ? 'Debe ser una fundación para ver esta información' : 'No hay información detallada de la fundación'; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TABLA 2: REPRESENTANTE LEGAL / DIRECTOR -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-badge fs-4 text-info me-3"></i>
                            <h5 class="fw-bold text-info mb-0">REPRESENTANTE LEGAL / DIRECTOR</h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%">NOMBRE COMPLETO</th>
                                        <th width="10%">TIPO DOC.</th>
                                        <th width="10%">DOCUMENTO</th>
                                        <th width="15%">CARGO</th>
                                        <th width="15%">CORREO</th>
                                        <th width="10%">CELULAR</th>
                                        <th width="10%">FECHA INICIO</th>
                                        <th width="15%">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold"><?php echo htmlspecialchars($representante['nombre_completo']); ?></td>
                                        <td><?php echo htmlspecialchars($representante['tipo_documento']); ?></td>
                                        <td><?php echo htmlspecialchars($representante['documento']); ?></td>
                                        <td><?php echo htmlspecialchars($representante['cargo']); ?></td>
                                        <td><?php echo htmlspecialchars($representante['correo']); ?></td>
                                        <td><?php echo htmlspecialchars($representante['celular']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($representante['fecha_desde'])); ?></td>
                                        <td>
                                            <?php if ($representante['estado'] == 1): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TABLA 3: FUNCIONARIOS DE LA FUNDACIÓN (VERSIÓN MEJORADA) -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people fs-4 text-primary me-3"></i>
                            <h5 class="fw-bold text-primary mb-0">FUNCIONARIOS DE LA FUNDACIÓN</h5>
                        </div>
                        <div>
                            <span class="badge bg-primary text-white px-3 py-2">
                                <i class="bi bi-person me-2"></i><?php echo $total_funcionarios; ?> funcionarios activos
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">NOMBRE COMPLETO</th>
                                        <th width="10%">DOCUMENTO</th>
                                        <th width="15%">CARGO</th>
                                        <th width="15%">CORREO</th>
                                        <th width="10%">CELULAR</th>
                                        <th width="10%">GÉNERO</th>
                                        <th width="10%">FECHA INGRESO</th>
                                        <th width="10%">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($usuario_tipo == 'fundacion' && !empty($id_fundacion)) {
                                        // Consulta con los campos exactos de la tabla funcionarios
                                        $query_funcionarios = "SELECT 
                                                id, 
                                                nombre, 
                                                apellidos, 
                                                tipo_documento, 
                                                documento, 
                                                cargo, 
                                                correo, 
                                                celular, 
                                                genero, 
                                                fecha_inicio, 
                                                fecha_registro, 
                                                estado
                                            FROM funcionarios 
                                            WHERE id_fundacion = $id_fundacion
                                            ORDER BY nombre, apellidos";
                                        $result_funcionarios = mysqli_query($conexion, $query_funcionarios);
                                        
                                        if ($result_funcionarios && mysqli_num_rows($result_funcionarios) > 0) {
                                            $contador = 1;
                                            while ($func = mysqli_fetch_assoc($result_funcionarios)) {
                                                $nombre_completo = trim($func['nombre'] . ' ' . $func['apellidos']);
                                                
                                                // Mapeo del género (enum: M, F, O)
                                                $genero = match($func['genero'] ?? '') {
                                                    'M' => 'Masculino',
                                                    'F' => 'Femenino',
                                                    'O' => 'Otro',
                                                    default => 'No especificado'
                                                };
                                                
                                                // Fecha de ingreso: se prefiere fecha_inicio, si no, se usa fecha_registro
                                                $fecha_ingreso = $func['fecha_inicio'] ?? $func['fecha_registro'] ?? date('Y-m-d');
                                                
                                                // Estado del funcionario (1 = activo, otro = inactivo)
                                                $estado_func = $func['estado'] ?? 1;
                                                $badge_class = $estado_func == 1 ? 'bg-success' : 'bg-danger';
                                                $estado_texto = $estado_func == 1 ? 'Activo' : 'Inactivo';
                                                ?>
                                                <tr>
                                                    <td><?php echo $contador++; ?></td>
                                                    <td class="fw-bold"><?php echo htmlspecialchars($nombre_completo); ?></td>
                                                    <td><?php echo htmlspecialchars(($func['tipo_documento'] ?? '') . ' ' . ($func['documento'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars($func['cargo'] ?? 'No asignado'); ?></td>
                                                    <td><?php echo htmlspecialchars($func['correo']); ?></td>
                                                    <td><?php echo htmlspecialchars($func['celular'] ?? 'N/A'); ?></td>
                                                    <td><?php echo $genero; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($fecha_ingreso)); ?></td>
                                                    <td><span class="badge <?php echo $badge_class; ?>"><?php echo $estado_texto; ?></span></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-people me-2"></i>No hay funcionarios registrados</td></tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-building me-2"></i>Debe ser una fundación para ver sus funcionarios</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="bi bi-info-circle me-1"></i>Total de funcionarios (activos): <?php echo $total_funcionarios; ?></span>
                            <button class="btn btn-sm btn-outline-primary" onclick="window.print()"><i class="bi bi-printer me-2"></i>Imprimir reporte</button>
                        </div>
                    </div>
                </div>

                <!-- ESTADÍSTICAS -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                                <h3 class="fw-bold"><?php echo $total_funcionarios; ?></h3>
                                <p class="text-muted mb-0">Funcionarios Activos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-person-badge fs-1 text-success mb-3"></i>
                                <h3 class="fw-bold">1</h3>
                                <p class="text-muted mb-0">Representante Legal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check fs-1 text-info mb-3"></i>
                                <h3 class="fw-bold"><?php echo date('Y'); ?></h3>
                                <p class="text-muted mb-0">Año en curso</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-shield-check fs-1 text-warning mb-3"></i>
                                <h3 class="fw-bold">Activa</h3>
                                <p class="text-muted mb-0">Estado Fundación</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- BOTONES -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/panel_fundacion.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver al Panel</a>
                    <a href="agregar_funcionario.php" class="btn btn-success"><i class="bi bi-person-plus me-2"></i>Agregar Funcionario</a>
                </div>

            </div>
        </div>
    </div>

    <style>
        .table { font-size: 0.95rem; }
        .table thead th { background-color: #f8f9fa; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6; }
        .table tbody tr:hover { background-color: rgba(0,123,255,0.05); }
        .card { border-radius: 10px; overflow: hidden; }
        .card-header { border-bottom: 2px solid #e9ecef; }
        .badge { font-size: 0.85rem; padding: 0.5rem 0.8rem; }
        .table td, .table th { vertical-align: middle; }
        .btn { border-radius: 8px; padding: 0.6rem 1.2rem; }
    </style>
</body>

<?php include("../../../footer.php"); ?>