<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");

// Obtener información del usuario logueado
$usuario_id = $_SESSION['usuario_id'];
$usuario_tipo = $_SESSION['usuario_tipo'];
$usuario_nombre = $_SESSION['usuario_nombre'];
$usuario_correo = $_SESSION['usuario_correo'];

// Variable para almacenar la fundación del usuario (INICIALIZADA)
$fundacion = null;
$fundacion_id = null;

// Si el usuario es de tipo fundación, buscar su fundación asociada
if ($usuario_tipo == 'fundacion') {
    // Intentar obtener la fundación del usuario por nombre (como fallback)
    $query_fundacion = "SELECT * FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%' LIMIT 1";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);

    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $fundacion = mysqli_fetch_assoc($result_fundacion);
        $fundacion_id = $fundacion['id'];
    }
}

// Determinar el título y tipo de usuario para mostrar
$titulo_panel = ($usuario_tipo == 'icbf') ? 'Panel Funcionario ICBF' : 'Panel de Fundación';
$icono_panel = ($usuario_tipo == 'icbf') ? 'bi-person-badge' : 'bi-people-fill';
$tipo_usuario_texto = ($usuario_tipo == 'icbf') ? 'funcionario ICBF' : 'fundación';
$icono_tipo = ($usuario_tipo == 'icbf') ? 'bi-building' : 'bi-tree';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Identificación de usuario y botón cerrar sesión (MEJORADA Y ADAPTADA) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">
                        <i class="<?php echo $icono_panel; ?> me-2"></i><?php echo $titulo_panel; ?>
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Bienvenido, <strong><?php echo htmlspecialchars($usuario_nombre); ?></strong>
                    </p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border">
                        <i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y'); ?>
                    </span>
                    <a href="<?php echo BASE_URL; ?>views/modules/login/logout.php" class="btn btn-outline-danger ms-3">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>

            <!-- Mensaje de bienvenida mejorado con estadísticas (ADAPTADO) -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="alert alert-success mb-0">
                        <h4 class="alert-heading fw-bold">
                            <i class="bi bi-shield-check me-2"></i>¡Bienvenido al sistema!
                        </h4>
                        <p class="mb-0">Has iniciado sesión como <strong><?php echo $tipo_usuario_texto; ?></strong>.</p>
                        <hr class="my-2">
                        <p class="mb-0 small">
                            <i class="bi bi-person-circle me-1"></i> ID: <?php echo $usuario_id; ?> |
                            <i class="bi bi-envelope me-1"></i> <?php echo $usuario_correo; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-success bg-opacity-10 rounded-4 p-3 text-center h-100 d-flex align-items-center justify-content-center">
                        <div>
                            <span class="badge bg-success text-white px-3 py-2 mb-2">Tipo de usuario</span>
                            <h5 class="fw-bold text-success mb-0">
                                <i class="<?php echo $icono_tipo; ?> me-2"></i><?php echo strtoupper($usuario_tipo); ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de acciones principales (TODAS DEL MISMO TAMAÑO) -->
            <!-- Primera fila de tarjetas - 3 por fila -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

                <!-- Tarjeta 1: Registrar información personal -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-building-add text-info fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Registrar información personal</h4>
                            <p class="text-muted mb-4 flex-grow-1">Información personal</p>
                            <a href="<?php echo BASE_URL ?>views/modules/fundaciones/F_R_F_Fundacion.php"
                                class="btn btn-info btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-plus-circle me-2"></i>Registrar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2: Registro de Interno -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-person-plus-fill text-success fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Registrar Interno</h4>
                            <p class="text-muted mb-4 flex-grow-1">Ingresa un nuevo interno al sistema</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" class="btn btn-success btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-plus-circle me-2"></i>Nuevo Interno
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3: Ver Fundaciones -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-building text-primary fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Informacion de la Fundacion</h4>
                            <p class="text-muted mb-4 flex-grow-1">Caracteristicas Institucionales</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/informacionFundacion.php" class="btn btn-primary btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-list-columns me-2"></i>Ver Informacion
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda fila de tarjetas - 3 por fila -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

                <!-- Tarjeta 4: Consultar Interno -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-secondary bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-search-heart text-secondary fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Consultar Interno</h4>
                            <p class="text-muted mb-4 flex-grow-1">Busca información de un interno específico por nombre o documento</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/Consultas/Consultar Interno.php" class="btn btn-secondary btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-search me-2"></i>Buscar Interno
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 5: Reporte de Internos -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-bar-chart-fill text-warning fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Reporte Internos</h4>
                            <p class="text-muted mb-4 flex-grow-1">Estadísticas por fundación</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/internos_de_cada_fundacion.php" class="btn btn-warning btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-graph-up me-2"></i>Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 6: Espacio para futuras funcionalidades -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card opacity-50">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="bg-light bg-opacity-10 rounded-circle p-4 d-inline-block mx-auto mb-3">
                                <i class="bi bi-plus-circle text-muted fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2 text-muted">Próximamente</h4>
                            <p class="text-muted mb-4 flex-grow-1">Nuevas funcionalidades estarán disponibles pronto</p>
                            <button class="btn btn-outline-secondary btn-lg rounded-pill w-100 mt-auto" disabled>
                                <i class="bi bi-clock me-2"></i>En desarrollo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje informativo -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                Reporte detallado de internos agrupados por fundación. Aquí puedes ver la distribución de internos en cada fundación.
            </div>

            <?php
            // CONSULTA MODIFICADA - Filtrar por fundación del usuario si es necesario
            if ($usuario_tipo == 'fundacion' && $fundacion_id) {
                // Mostrar solo la fundación del usuario
                $query = "
                    SELECT 
                        f.id,
                        f.nombre as fundacion_nombre,
                        f.nit,
                        COUNT(i.id) as total_internos,
                        SUM(CASE WHEN MONTH(i.fecha_ingreso) = MONTH(CURDATE()) AND YEAR(i.fecha_ingreso) = YEAR(CURDATE()) THEN 1 ELSE 0 END) as internos_mes,
                        MAX(i.fecha_ingreso) as ultimo_ingreso
                    FROM fundaciones f
                    LEFT JOIN ingresos_fundacion i ON f.nombre = i.fundacion_nombre
                    WHERE f.id = $fundacion_id
                    GROUP BY f.id
                    ORDER BY total_internos DESC
                ";
            } else {
                // Mostrar todas las fundaciones (para ICBF o si no hay fundación específica)
                $query = "
                    SELECT 
                        f.id,
                        f.nombre as fundacion_nombre,
                        f.nit,
                        COUNT(i.id) as total_internos,
                        SUM(CASE WHEN MONTH(i.fecha_ingreso) = MONTH(CURDATE()) AND YEAR(i.fecha_ingreso) = YEAR(CURDATE()) THEN 1 ELSE 0 END) as internos_mes,
                        MAX(i.fecha_ingreso) as ultimo_ingreso
                    FROM fundaciones f
                    LEFT JOIN ingresos_fundacion i ON f.nombre = i.fundacion_nombre
                    GROUP BY f.id
                    ORDER BY total_internos DESC
                ";
            }

            $result = mysqli_query($conexion, $query);

            if (!$result) {
                echo '<div class="alert alert-danger">Error en la consulta: ' . mysqli_error($conexion) . '</div>';
            } else {
                $total_fundaciones = mysqli_num_rows($result);

                // Calcular total general de internos según el tipo de usuario
                if ($usuario_tipo == 'fundacion' && $fundacion_id && isset($fundacion['nombre'])) {
                    $query_total = "SELECT COUNT(*) as total FROM ingresos_fundacion WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion['nombre']) . "'";
                } else {
                    $query_total = "SELECT COUNT(*) as total FROM ingresos_fundacion";
                }
                $result_total = mysqli_query($conexion, $query_total);
                $total_internos_general = $result_total ? mysqli_fetch_assoc($result_total)['total'] : 0;
            ?>

                <!-- Resumen - TARJETA CORREGIDA con verificaciones -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 mb-2">Fundación Activa</h6>
                                        <h4 class="fw-bold mb-0">
                                            <?php echo isset($fundacion) && isset($fundacion['nombre']) ? htmlspecialchars($fundacion['nombre']) : 'No disponible'; ?>
                                        </h4>
                                        <?php if (isset($fundacion) && isset($fundacion['nit'])): ?>
                                            <small class="text-white-50">NIT: <?php echo htmlspecialchars($fundacion['nit']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <i class="bi bi-building fs-1 text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 mb-2">Total Internos</h6>
                                        <h3 class="fw-bold mb-0"><?php echo $total_internos_general; ?></h3>
                                    </div>
                                    <i class="bi bi-people-fill fs-1 text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 mb-2">Promedio x Fundación</h6>
                                        <h3 class="fw-bold mb-0">
                                            <?php
                                            echo $total_fundaciones > 0
                                                ? round($total_internos_general / $total_fundaciones, 1)
                                                : 0;
                                            ?>
                                        </h3>
                                    </div>
                                    <i class="bi bi-bar-chart-fill fs-1 text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE RESULTADOS MODIFICADA - Solo muestra la fundación del usuario logueado -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-success text-white py-3 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-list-columns me-2"></i>
                            <?php echo (isset($usuario_tipo) && $usuario_tipo == 'fundacion') ? 'Detalle de tu Fundación' : 'Detalle por Fundación'; ?>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">#</th>
                                        <th class="py-3">Fundación</th>
                                        <th class="py-3">NIT</th>
                                        <th class="py-3 text-center">Total Internos</th>
                                        <th class="py-3 text-center">Internos (Mes)</th>
                                        <th class="py-3 text-center">% del Total</th>
                                        <th class="py-3">Último Ingreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($result) && mysqli_num_rows($result) > 0):
                                        $contador = 1;
                                        while ($row = mysqli_fetch_assoc($result)):
                                            // Calcular porcentaje correctamente
                                            $porcentaje = $total_internos_general > 0
                                                ? round(($row['total_internos'] / $total_internos_general) * 100, 1)
                                                : 0;
                                    ?>
                                            <tr>
                                                <td class="px-4"><?php echo $contador++; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                            <i class="bi bi-building text-success"></i>
                                                        </div>
                                                        <strong><?php echo htmlspecialchars($row['fundacion_nombre']); ?></strong>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nit']); ?></td>
                                                <td class="text-center">
                                                    <span class="fw-bold fs-5"><?php echo $row['total_internos']; ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                                        <?php echo $row['internos_mes']; ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress w-100" style="height: 8px;">
                                                            <div class="progress-bar bg-success" style="width: <?php echo $porcentaje; ?>%;"></div>
                                                        </div>
                                                        <span class="ms-2 small"><?php echo $porcentaje; ?>%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $row['ultimo_ingreso']
                                                        ? date('d/m/Y', strtotime($row['ultimo_ingreso']))
                                                        : '<span class="text-muted">-</span>';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        endwhile;
                                        
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="bi bi-building fs-1 text-muted d-block mb-3"></i>
                                                <?php if (isset($usuario_tipo) && $usuario_tipo == 'fundacion'): ?>
                                                    <h5>No se encontró tu fundación</h5>
                                                    <p class="text-muted">No hay una fundación asociada a tu usuario</p>
                                                    <?php if ($fundacion_id): ?>
                                                        <p class="text-muted">Tu fundación no tiene internos registrados aún.</p>
                                                        <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" class="btn btn-success mt-3">
                                                            <i class="bi bi-plus-circle me-2"></i>Registrar primer interno
                                                        </a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <h5>No hay fundaciones registradas</h5>
                                                    <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/F_R_F_Fundacion.php" class="btn btn-success mt-3">
                                                        <i class="bi bi-plus-circle me-2"></i>Registrar primera fundación
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .hover-card {
        transition: all 0.3s ease;
        height: 100%;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
    }

    .bg-success {
        background-color: #006341 !important;
    }

    .bg-info {
        background-color: #0dcaf0 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #000;
    }

    .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
        color: #000;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5c636a;
        border-color: #565e64;
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .flex-grow-1 {
        flex-grow: 1;
    }

    .mt-auto {
        margin-top: auto;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>