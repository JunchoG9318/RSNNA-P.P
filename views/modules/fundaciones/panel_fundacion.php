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
    // Intentar obtener la fundación del usuario - INCLUIR ESTADO EXPLÍCITAMENTE
    // Primero intentar por nombre
    $query_fundacion = "SELECT id, nombre, nit, estado FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%' LIMIT 1";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);

    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $fundacion = mysqli_fetch_assoc($result_fundacion);
        $fundacion_id = $fundacion['id'];
    } else {
        // Si no encuentra por nombre, intentar por correo
        $query_fundacion = "SELECT id, nombre, nit, estado FROM fundaciones WHERE correo_director = '$usuario_correo' LIMIT 1";
        $result_fundacion = mysqli_query($conexion, $query_fundacion);
        
        if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
            $fundacion = mysqli_fetch_assoc($result_fundacion);
            $fundacion_id = $fundacion['id'];
        }
    }
}

// Determinar el título y tipo de usuario para mostrar
$titulo_panel = ($usuario_tipo == 'icbf') ? 'Panel Funcionario ICBF' : 'Panel de Fundación';
$icono_panel = ($usuario_tipo == 'icbf') ? 'bi-person-badge' : 'bi-people-fill';
$tipo_usuario_texto = ($usuario_tipo == 'icbf') ? 'funcionario ICBF' : 'fundación';
$icono_tipo = ($usuario_tipo == 'icbf') ? 'bi-building' : 'bi-tree';
?>

<!-- Bootstrap Icons - MOVIDO AL INICIO PARA ASEGURAR QUE CARGUE -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Identificación de usuario y botón cerrar sesión (COMO EN LA IMAGEN) -->
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
                <div class="d-flex align-items-center gap-3">
                    <!-- FECHA (como en la imagen) -->
                    <div class="text-end">
                        <div class="fw-bold"><?php echo date('d/m/Y'); ?></div>
                    </div>

                    <!-- TIPO DE USUARIO (como en la imagen) -->
                    <div class="text-end">
                        <div class="small text-muted">Tipo de usuario</div>
                        <div class="fw-bold text-success"><?php echo strtoupper($usuario_tipo); ?></div>
                    </div>

                    <!-- BOTÓN CERRAR SESIÓN -->
                    <a href="<?php echo BASE_URL; ?>views/modules/login/logout.php" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>

            <!-- Mensaje de bienvenida mejorado con estadísticas (ADAPTADO) -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-success mb-0">
                        <h4 class="alert-heading fw-bold">
                            <i class="bi bi-shield-check me-2"></i>¡Bienvenido al sistema!
                        </h4>
                        <p class="mb-0">Has iniciado sesión como <strong><?php echo $tipo_usuario_texto; ?></strong>.</p>
                        <hr class="my-2">
                        <p class="mb-0 small">
                            <i class="bi bi-envelope me-1"></i> <?php echo $usuario_correo; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== NUEVA TARJETA INFORMATIVA CON VENTANA EMERGENTE ===== -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info rounded-circle p-3 me-3">
                                        <i class="bi bi-question-circle-fill text-white fs-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">¿Cómo utilizar este panel?</h5>
                                        <p class="text-muted mb-0">Haz clic en el botón para ver una guía rápida de todas las funcionalidades disponibles.</p>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info btn-lg rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalGuiaPanel">
                                    <i class="bi bi-lightbulb me-2"></i>Ver Guía Rápida
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL - VENTANA EMERGENTE CON LA GUÍA DEL PANEL -->
            <div class="modal fade" id="modalGuiaPanel" tabindex="-1" aria-labelledby="modalGuiaPanelLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title fw-bold" id="modalGuiaPanelLabel">
                                <i class="bi bi-compass me-2"></i>
                                Guía Rápida - Panel de <?php echo $titulo_panel; ?>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Introducción -->
                            <div class="alert alert-info bg-opacity-10 mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Este panel te permite gestionar toda la información relacionada con la fundación y los internos. A continuación, te explicamos cada sección:
                            </div>

                            <!-- Tarjetas de funcionalidades - CON ICONOS MEJORADOS -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-building-add text-info fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Registrar información personal</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Permite registrar los datos de la fundación, incluyendo información de contacto, NIT y datos del director.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-plus-fill text-success fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Registrar Interno</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Ingresa un nuevo interno al sistema con todos sus datos personales, familiares y de ingreso.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-building text-primary fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Información de la Fundación</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Consulta los datos generales de la fundación, el representante legal y el listado de funcionarios.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-search-heart text-secondary fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Consultar Interno</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Busca información detallada de un interno específico por nombre, documento u otros criterios.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-bar-chart-fill text-warning fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Reporte Internos</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Visualiza estadísticas y reportes detallados de internos agrupados por fundación.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-box-arrow-right text-danger fs-4"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0">Cerrar Sesión</h6>
                                            </div>
                                            <p class="text-muted small mb-0">Finaliza tu sesión de forma segura cuando termines de trabajar en el sistema.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Consejos adicionales -->
                            <div class="bg-light p-3 rounded-3">
                                <h6 class="fw-bold mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Consejos útiles:</h6>
                                <ul class="mb-0 small">
                                    <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Todas las tarjetas tienen el mismo tamaño y son completamente responsivas.</li>
                                    <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Pasa el cursor sobre cualquier tarjeta para ver un efecto de elevación.</li>
                                    <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Los reportes muestran estadísticas en tiempo real de todos los internos.</li>
                                    <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Puedes imprimir cualquier reporte usando el botón "Imprimir" disponible en las tablas.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-2"></i>Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de acciones principales (TODAS DEL MISMO TAMAÑO) -->
            <!-- Primera fila de tarjetas - 3 por fila -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

                <!-- Tarjeta 1: Registrar información personal - CON NUEVOS ICONOS -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-info position-relative rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(13, 202, 240, 0.15) !important;">
                                    <i class="bi bi-file-earmark-person-fill text-info" style="font-size: 4rem;"></i>
                                    <i class="bi bi-pencil-fill text-info position-absolute" style="font-size: 1.8rem; bottom: 15px; right: 15px;"></i>
                                </div>
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

                <!-- Tarjeta 2: Registro de Interno - CON NUEVOS ICONOS -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-success position-relative rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(0, 99, 65, 0.15) !important;">
                                    <i class="bi bi-person-fill-add text-success" style="font-size: 4rem;"></i>
                                    <i class="bi bi-house-heart-fill text-success position-absolute" style="font-size: 1.8rem; top: 15px; right: 15px;"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-2">Registrar Interno</h4>
                            <p class="text-muted mb-4 flex-grow-1">Ingresa un nuevo interno al sistema</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" class="btn btn-success btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-plus-circle me-2"></i>Nuevo Interno
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3: Información de la Fundación -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(13, 110, 253, 0.15) !important;">
                                    <i class="bi bi-building text-primary" style="font-size: 4rem;"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-2">Información de la Fundación</h4>
                            <p class="text-muted mb-4 flex-grow-1">Características Institucionales</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/informacionFundacion.php" class="btn btn-primary btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-list-columns me-2"></i>Ver Información
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda fila de tarjetas - 3 por fila -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

                <!-- Tarjeta 4: Consultar Interno - CON NUEVOS ICONOS -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-secondary position-relative rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(108, 117, 125, 0.15) !important;">
                                    <i class="bi bi-person-standing-dress text-secondary" style="font-size: 4rem;"></i>
                                    <i class="bi bi-search text-secondary position-absolute" style="font-size: 2rem; bottom: 10px; right: 10px;"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-2">Consultar Interno</h4>
                            <p class="text-muted mb-4 flex-grow-1">Busca información de un interno específico por nombre o documento</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/consulta_por_fundacion.php" class="btn btn-secondary btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-search me-2"></i>Buscar Interno
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 5: Reporte Internos -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(255, 193, 7, 0.15) !important;">
                                    <i class="bi bi-bar-chart-fill text-warning" style="font-size: 4rem;"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-2">Reporte Internos</h4>
                            <p class="text-muted mb-4 flex-grow-1">Estadísticas por fundación</p>
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/internos_de_cada_fundacion.php" class="btn btn-warning btn-lg rounded-pill w-100 mt-auto">
                                <i class="bi bi-graph-up me-2"></i>Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 6: Próximamente -->
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card opacity-50">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: rgba(248, 249, 250, 0.15) !important;">
                                    <i class="bi bi-hourglass-split text-muted" style="font-size: 4rem;"></i>
                                </div>
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
                // Mostrar solo la fundación del usuario - INCLUIR ESTADO
                $query = "
                    SELECT 
                        f.id,
                        f.nombre as fundacion_nombre,
                        f.nit,
                        f.estado,
                        COUNT(i.id) as total_internos,
                        SUM(CASE WHEN MONTH(i.fecha_ingreso) = MONTH(CURDATE()) AND YEAR(i.fecha_ingreso) = YEAR(CURDATE()) THEN 1 ELSE 0 END) as internos_mes,
                        MAX(i.fecha_ingreso) as ultimo_ingreso
                    FROM fundaciones f
                    LEFT JOIN ingresos_fundacion i ON f.nombre = i.fundacion_nombre
                    WHERE f.id = $fundacion_id
                    GROUP BY f.id, f.nombre, f.nit, f.estado
                    ORDER BY total_internos DESC
                ";
            } else {
                // Mostrar todas las fundaciones (para ICBF o si no hay fundación específica)
                $query = "
                    SELECT 
                        f.id,
                        f.nombre as fundacion_nombre,
                        f.nit,
                        f.estado,
                        COUNT(i.id) as total_internos,
                        SUM(CASE WHEN MONTH(i.fecha_ingreso) = MONTH(CURDATE()) AND YEAR(i.fecha_ingreso) = YEAR(CURDATE()) THEN 1 ELSE 0 END) as internos_mes,
                        MAX(i.fecha_ingreso) as ultimo_ingreso
                    FROM fundaciones f
                    LEFT JOIN ingresos_fundacion i ON f.nombre = i.fundacion_nombre
                    GROUP BY f.id, f.nombre, f.nit, f.estado
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

                <!-- Resumen - TARJETA CORREGIDA con verificaciones de estado -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <?php
                        // Determinar el color de fondo según el estado
                        $estado_fundacion = isset($fundacion) && isset($fundacion['estado']) ? $fundacion['estado'] : null;
                        $color_fondo = '#006341'; // Verde por defecto (activa)
                        
                        if ($estado_fundacion === null) {
                            $color_fondo = '#6c757d'; // Gris si no disponible
                        } elseif ($estado_fundacion == 0) {
                            $color_fondo = '#dc3545'; // Rojo si inactiva
                        }
                        ?>
                        <div class="card text-white shadow-lg border-0 rounded-4" style="background-color: <?php echo $color_fondo; ?> !important;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 mb-2">Fundación</h6>
                                        <h4 class="fw-bold mb-0 text-white">
                                            <?php echo isset($fundacion) && isset($fundacion['nombre']) ? htmlspecialchars($fundacion['nombre']) : 'No disponible'; ?>
                                        </h4>
                                        <div class="mt-2">
                                            <?php if ($estado_fundacion !== null): ?>
                                                <?php if ($estado_fundacion == 1): ?>
                                                    <span class="badge bg-white text-success px-3 py-2">
                                                        <i class="bi bi-check-circle-fill me-1"></i>ACTIVA
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-white text-danger px-3 py-2">
                                                        <i class="bi bi-x-circle-fill me-1"></i>INACTIVA
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-white text-secondary px-3 py-2">
                                                    <i class="bi bi-question-circle-fill me-1"></i>NO DISPONIBLE
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <i class="bi bi-building fs-1 text-white-50 d-block mb-2"></i>
                                        <?php if (isset($fundacion) && isset($fundacion['nit'])): ?>
                                            <small class="text-white-50">NIT: <?php echo htmlspecialchars($fundacion['nit']); ?></small>
                                        <?php endif; ?>
                                    </div>
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
                                        <h3 class="fw-bold mb-0 text-white"><?php echo $total_internos_general; ?></h3>
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
                                        <h3 class="fw-bold mb-0 text-white">
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

                <!-- TABLA DE RESULTADOS MODIFICADA - Incluye estado -->
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
                                        <th class="py-3 text-center">Estado</th>
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
                                            
                                            // Determinar badge de estado
                                            $estado_badge = '';
                                            if (isset($row['estado'])) {
                                                if ($row['estado'] == 1) {
                                                    $estado_badge = '<span class="badge bg-success">Activa</span>';
                                                } else {
                                                    $estado_badge = '<span class="badge bg-danger">Inactiva</span>';
                                                }
                                            } else {
                                                $estado_badge = '<span class="badge bg-secondary">No definido</span>';
                                            }
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
                                                <td class="text-center"><?php echo $estado_badge; ?></td>
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
                                            <td colspan="8" class="text-center py-4">
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

    /* Asegurar que el texto de los badges sea blanco */
    .badge.bg-success.text-white,
    .badge.bg-info.text-white,
    .badge.bg-warning.text-white,
    .badge.bg-primary.text-white,
    .badge.bg-secondary.text-white {
        color: #ffffff !important;
    }

    /* Asegurar que el texto de los contadores en tarjetas sea blanco */
    .card.bg-success .card-body .fw-bold,
    .card.bg-primary .card-body .fw-bold,
    .card.bg-warning .card-body .fw-bold,
    .card.bg-success .card-body h3,
    .card.bg-primary .card-body h3,
    .card.bg-warning .card-body h3,
    .card.bg-success .card-body h4,
    .card.bg-primary .card-body h4,
    .card.bg-warning .card-body h4 {
        color: #ffffff !important;
    }

    /* Estilo para el modal */
    .modal-header.bg-info {
        background-color: #0dcaf0 !important;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }
</style>

<!-- Bootstrap JS (necesario para el modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("../../../footer.php"); ?>