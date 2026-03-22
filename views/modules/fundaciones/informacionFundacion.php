<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");

// ===== INICIO - CÓDIGO INDEPENDIENTE PARA OBTENER FUNDACIÓN =====
// Obtener información del usuario logueado desde la sesión
$usuario_id     = $_SESSION['usuario_id'];
$usuario_tipo   = $_SESSION['usuario_tipo'];
$usuario_nombre = $_SESSION['usuario_nombre'] ?? '';
$usuario_correo = $_SESSION['usuario_correo'] ?? '';

// Datos complementarios del usuario
$usuario_tipo_documento = $_SESSION['usuario_tipo_documento'] ?? '';
$usuario_documento      = $_SESSION['usuario_documento'] ?? '';
$usuario_celular        = $_SESSION['usuario_celular'] ?? '';

// ID de la fundación asociada al usuario
$id_fundacion = 0;

// ===== LÓGICA INDEPENDIENTE PARA OBTENER EL ID DE FUNDACIÓN =====
if ($usuario_tipo == 'fundacion') {
    // 1. Intentar obtener de la sesión primero
    if (isset($_SESSION['id_fundacion']) && $_SESSION['id_fundacion'] > 0) {
        $id_fundacion = $_SESSION['id_fundacion'];
    } else {
        // 2. Buscar en la tabla usuarios
        $query_usuario = "SELECT id_fundacion FROM usuarios WHERE id = $usuario_id";
        $result_usuario = mysqli_query($conexion, $query_usuario);
        
        if ($result_usuario && mysqli_num_rows($result_usuario) > 0) {
            $row_usuario = mysqli_fetch_assoc($result_usuario);
            if (!empty($row_usuario['id_fundacion'])) {
                $id_fundacion = $row_usuario['id_fundacion'];
                $_SESSION['id_fundacion'] = $id_fundacion;
            }
        }
        
        // 3. Si aún no se encuentra, buscar por nombre
        if (empty($id_fundacion) || $id_fundacion <= 0) {
            $query_fundacion = "SELECT id FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%' LIMIT 1";
            $result_fundacion = mysqli_query($conexion, $query_fundacion);
            if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
                $row_fundacion = mysqli_fetch_assoc($result_fundacion);
                $id_fundacion = $row_fundacion['id'];
                $_SESSION['id_fundacion'] = $id_fundacion;
            }
        }
        
        // 4. Buscar por correo
        if (empty($id_fundacion) || $id_fundacion <= 0) {
            $query_fundacion = "SELECT id FROM fundaciones WHERE correo_director = '$usuario_correo' LIMIT 1";
            $result_fundacion = mysqli_query($conexion, $query_fundacion);
            if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
                $row_fundacion = mysqli_fetch_assoc($result_fundacion);
                $id_fundacion = $row_fundacion['id'];
                $_SESSION['id_fundacion'] = $id_fundacion;
            }
        }
    }
}
// ===== FIN - CÓDIGO INDEPENDIENTE PARA OBTENER FUNDACIÓN =====

// Variable para almacenar datos de la fundación
$fundacion_data = [];

// Si el usuario es de tipo fundación y tiene id_fundacion, obtener información completa de su fundación
if ($usuario_tipo == 'fundacion' && !empty($id_fundacion)) {
    $query_fundacion = "SELECT nombre, nit, direccion, telefono_director, correo_director, 
                               nombre_director, tipo_documento_director, documento_director,
                               fecha_constitucion, tipo, fecha_registro, estado
                        FROM fundaciones 
                        WHERE id = $id_fundacion";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);
    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $fundacion_data = mysqli_fetch_assoc($result_fundacion);
    } else {
        $error_consulta = mysqli_error($conexion);
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
        $row['fecha_desde'] = $row['fecha_inicio'] ?? $row['fecha_registro'];
        return $row;
    }

    // 2. Si no hay funcionario directivo, usar datos de fundaciones
    if (!empty($fundacion_data['nombre_director'])) {
        return [
            'nombre_completo'    => $fundacion_data['nombre_director'],
            'tipo_documento'     => $fundacion_data['tipo_documento_director'] ?? 'N/A',
            'documento'          => $fundacion_data['documento_director'] ?? 'N/A',
            'cargo'              => 'Director',
            'correo'             => $fundacion_data['correo_director'] ?? 'N/A',
            'celular'            => $fundacion_data['telefono_director'] ?? 'N/A',
            'fecha_desde'        => $fundacion_data['fecha_constitucion'] ?? date('Y-m-d'),
            'estado'             => $fundacion_data['estado'] ?? 1
        ];
    }

    // 3. Último recurso: datos del usuario logueado
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
                
                <!-- ENCABEZADO CON BOTÓN VOLVER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-0">
                            <i class="bi bi-building me-3"></i>FUNDACIÓN Y FUNCIONARIOS
                        </h2>
                        <p class="text-muted mt-2">Información completa de la fundación y su personal</p>
                    </div>
                    <div>
                        <span class="badge bg-primary text-white px-3 py-2 me-2">
                            <i class="bi bi-calendar3 me-2"></i><?php echo date('d/m/Y'); ?>
                        </span>
                        <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/panel_fundacion.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                        </a>
                    </div>
                </div>

                <!-- Mostrar error de depuración si es necesario -->
                <?php if(isset($error_consulta) && $error_consulta): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Error en consulta: <?php echo $error_consulta; ?>
                </div>
                <?php endif; ?>

                <!-- Mensaje si no hay fundación -->
                <?php if ($usuario_tipo == 'fundacion' && empty($id_fundacion)): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>No se ha podido identificar la fundación asociada a tu usuario.</strong>
                    <p class="mt-3 mb-0">Esto puede deberse a que tu usuario no está vinculado a ninguna fundación.</p>
                    <div class="mt-4">
                        <h6 class="fw-bold">Posibles soluciones:</h6>
                        <ul class="mt-2">
                            <li>Asegúrate de que tu usuario tenga un <code>id_fundacion</code> en la tabla <strong>usuarios</strong></li>
                            <li>Ejecuta esta consulta en la base de datos: <code>UPDATE usuarios SET id_fundacion = (SELECT id FROM fundaciones WHERE nombre LIKE "%<?php echo $usuario_nombre; ?>%" LIMIT 1) WHERE id = <?php echo $usuario_id; ?>;</code></li>
                            <li>O vincúlalo manualmente desde el panel de administración</li>
                        </ul>
                        <div class="mt-3">
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registro_fundacion.php" class="btn btn-success me-2">
                                <i class="bi bi-building-add me-2"></i>Registrar Fundación
                            </a>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/panel_fundacion.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

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
                                        <th width="15%">NOMBRE</th>
                                        <th width="10%">NIT</th>
                                        <th width="15%">DIRECCIÓN</th>
                                        <th width="10%">TELÉFONO</th>
                                        <th width="15%">CORREO</th>
                                        <th width="10%">FECHA CONST.</th>
                                        <th width="10%">TIPO</th>
                                        <th width="15%">FECHA REGISTRO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($usuario_tipo == 'fundacion' && !empty($fundacion_data)): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo htmlspecialchars($fundacion_data['nombre'] ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['nit'] ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['direccion'] ?? 'No registrada'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['telefono_director'] ?? 'No registrado'); ?></td>
                                            <td><?php echo htmlspecialchars($fundacion_data['correo_director'] ?? 'No registrado'); ?></td>
                                            <td>
                                                <?php 
                                                if (!empty($fundacion_data['fecha_constitucion'])) {
                                                    echo date('d/m/Y', strtotime($fundacion_data['fecha_constitucion']));
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($fundacion_data['tipo'] ?? 'No especificado'); ?></td>
                                            <td>
                                                <?php 
                                                if (!empty($fundacion_data['fecha_registro'])) {
                                                    echo date('d/m/Y', strtotime($fundacion_data['fecha_registro']));
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <?php 
                                                if ($usuario_tipo != 'fundacion') {
                                                    echo 'Debe ser una fundación para ver esta información';
                                                } elseif (empty($id_fundacion)) {
                                                    echo 'No hay ID de fundación asociado al usuario';
                                                } else {
                                                    echo 'No hay información detallada de la fundación';
                                                }
                                                ?>
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
                                        <td class="fw-bold"><?php echo htmlspecialchars($representante['nombre_completo'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($representante['tipo_documento'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($representante['documento'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($representante['cargo'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($representante['correo'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($representante['celular'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php 
                                            if (!empty($representante['fecha_desde'])) {
                                                echo date('d/m/Y', strtotime($representante['fecha_desde']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (($representante['estado'] ?? 0) == 1): ?>
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

                <!-- TABLA 3: FUNCIONARIOS DE LA FUNDACIÓN -->
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
                                        <th width="12%">NOMBRE COMPLETO</th>
                                        <th width="8%">DOCUMENTO</th>
                                        <th width="12%">CARGO</th>
                                        <th width="12%">CORREO</th>
                                        <th width="8%">CELULAR</th>
                                        <th width="8%">GÉNERO</th>
                                        <th width="10%">FECHA INICIO</th>
                                        <th width="10%">FECHA FIN</th>
                                        <th width="8%">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($usuario_tipo == 'fundacion' && !empty($id_fundacion)) {
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
                                                fecha_fin,
                                                fecha_registro, 
                                                estado
                                            FROM funcionarios 
                                            WHERE id_fundacion = $id_fundacion
                                            ORDER BY estado DESC, nombre, apellidos";
                                        $result_funcionarios = mysqli_query($conexion, $query_funcionarios);
                                        
                                        if ($result_funcionarios && mysqli_num_rows($result_funcionarios) > 0) {
                                            $contador = 1;
                                            while ($func = mysqli_fetch_assoc($result_funcionarios)) {
                                                $nombre_completo = trim($func['nombre'] . ' ' . $func['apellidos']);
                                                
                                                $genero = '';
                                                if (isset($func['genero'])) {
                                                    $genero = match($func['genero']) {
                                                        'M' => 'Masculino',
                                                        'F' => 'Femenino',
                                                        'O' => 'Otro',
                                                        default => 'No especificado'
                                                    };
                                                } else {
                                                    $genero = 'No especificado';
                                                }
                                                
                                                $fecha_inicio = $func['fecha_inicio'] ?? $func['fecha_registro'] ?? null;
                                                $fecha_fin = $func['fecha_fin'] ?? null;
                                                $estado_func = $func['estado'] ?? 1;
                                                $badge_class = $estado_func == 1 ? 'bg-success' : 'bg-danger';
                                                $estado_texto = $estado_func == 1 ? 'Activo' : 'Inactivo';
                                                ?>
                                                <tr>
                                                    <td><?php echo $contador++; ?></td>
                                                    <td class="fw-bold"><?php echo htmlspecialchars($nombre_completo); ?></td>
                                                    <td><?php echo htmlspecialchars(($func['tipo_documento'] ?? '') . ' ' . ($func['documento'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars($func['cargo'] ?? 'No asignado'); ?></td>
                                                    <td><?php echo htmlspecialchars($func['correo'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($func['celular'] ?? 'N/A'); ?></td>
                                                    <td><?php echo $genero; ?></td>
                                                    <td><?php echo $fecha_inicio ? date('d/m/Y', strtotime($fecha_inicio)) : 'N/A'; ?></td>
                                                    <td><?php echo $fecha_fin ? date('d/m/Y', strtotime($fecha_fin)) : 'N/A'; ?></td>
                                                    <td><span class="badge <?php echo $badge_class; ?>"><?php echo $estado_texto; ?></span></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="10" class="text-center py-4 text-muted"><i class="bi bi-people me-2"></i>No hay funcionarios registrados</td></tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="10" class="text-center py-4 text-muted"><i class="bi bi-building me-2"></i>Debe ser una fundación para ver sus funcionarios</td></tr>';
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