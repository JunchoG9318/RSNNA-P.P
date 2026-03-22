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

// Variables para la fundación
$fundacion_id = 0;
$fundacion_nombre = '';

// ===== CORRECCIÓN: Obtener fundación del usuario =====
if ($usuario_tipo == 'fundacion') {
    // Buscar si el usuario tiene id_fundacion en la sesión
    if (isset($_SESSION['id_fundacion']) && $_SESSION['id_fundacion'] > 0) {
        $fundacion_id = $_SESSION['id_fundacion'];
        // Obtener nombre de la fundación
        $query_fundacion = "SELECT nombre FROM fundaciones WHERE id = $fundacion_id";
        $result_fundacion = mysqli_query($conexion, $query_fundacion);
        if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
            $row_fundacion = mysqli_fetch_assoc($result_fundacion);
            $fundacion_nombre = $row_fundacion['nombre'];
        }
    } else {
        // ===== SOLUCIÓN: Buscar la fundación por el correo del usuario =====
        // Primero intentar buscar en la tabla usuarios para obtener el id_fundacion
        $query_usuario = "SELECT id_fundacion FROM usuarios WHERE id = $usuario_id";
        $result_usuario = mysqli_query($conexion, $query_usuario);

        if ($result_usuario && mysqli_num_rows($result_usuario) > 0) {
            $row_usuario = mysqli_fetch_assoc($result_usuario);
            if (!empty($row_usuario['id_fundacion'])) {
                $fundacion_id = $row_usuario['id_fundacion'];

                // Obtener nombre de la fundación
                $query_fundacion = "SELECT nombre FROM fundaciones WHERE id = $fundacion_id";
                $result_fundacion = mysqli_query($conexion, $query_fundacion);
                if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
                    $row_fundacion = mysqli_fetch_assoc($result_fundacion);
                    $fundacion_nombre = $row_fundacion['nombre'];

                    // Guardar en sesión para futuras consultas
                    $_SESSION['id_fundacion'] = $fundacion_id;

                    if (isset($_GET['debug'])) {
                        echo '<div class="alert alert-success">¡Fundación encontrada por ID en tabla usuarios! ID: ' . $fundacion_id . '</div>';
                    }
                }
            }
        }

        // Si aún no se encuentra, buscar por nombre del usuario en fundaciones
        if (empty($fundacion_id) || $fundacion_id <= 0) {
            $query_fundacion = "SELECT id, nombre FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%' LIMIT 1";
            $result_fundacion = mysqli_query($conexion, $query_fundacion);
            if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
                $row_fundacion = mysqli_fetch_assoc($result_fundacion);
                $fundacion_id = $row_fundacion['id'];
                $fundacion_nombre = $row_fundacion['nombre'];
                // Guardar en sesión para futuras consultas
                $_SESSION['id_fundacion'] = $fundacion_id;

                if (isset($_GET['debug'])) {
                    echo '<div class="alert alert-success">¡Fundación encontrada por nombre! ID: ' . $fundacion_id . '</div>';
                }
            }
        }

        // Si aún no se encuentra, buscar por correo en la tabla fundaciones
        if (empty($fundacion_id) || $fundacion_id <= 0) {
            $query_fundacion = "SELECT id, nombre FROM fundaciones WHERE correo_director = '$usuario_correo' LIMIT 1";
            $result_fundacion = mysqli_query($conexion, $query_fundacion);
            if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
                $row_fundacion = mysqli_fetch_assoc($result_fundacion);
                $fundacion_id = $row_fundacion['id'];
                $fundacion_nombre = $row_fundacion['nombre'];
                // Guardar en sesión para futuras consultas
                $_SESSION['id_fundacion'] = $fundacion_id;

                if (isset($_GET['debug'])) {
                    echo '<div class="alert alert-success">¡Fundación encontrada por correo! ID: ' . $fundacion_id . '</div>';
                }
            }
        }
    }
}
// Si es ICBF y viene un ID por GET, mostrar esa fundación específica
else if ($usuario_tipo == 'icbf' && isset($_GET['id']) && intval($_GET['id']) > 0) {
    $fundacion_id = intval($_GET['id']);
    $query_fundacion = "SELECT nombre FROM fundaciones WHERE id = $fundacion_id";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);
    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $row_fundacion = mysqli_fetch_assoc($result_fundacion);
        $fundacion_nombre = $row_fundacion['nombre'];
    }
}

// Determinar la URL de retorno según el tipo de usuario
if ($usuario_tipo == 'fundacion') {
    $back_url = BASE_URL . "views/modules/fundaciones/panel_fundacion.php";
    $back_text = "Volver al Panel de Fundación";
} elseif ($usuario_tipo == 'icbf') {
    $back_url = BASE_URL . "views/modules/fundaciones/internos_por_fundacion.php";
    $back_text = "Volver al Reporte";
} else {
    $back_url = BASE_URL . "views/modules/ICBF/panel_icbf.php";
    $back_text = "Volver";
}

// ===== MOTOR DE BÚSQUEDA =====
$search_term = '';
$search_type = 'todos';
$filter_date_from = '';
$filter_date_to = '';

// Procesar la búsqueda si se envió el formulario
if (isset($_GET['search']) || isset($_GET['search_term']) || isset($_GET['search_type'])) {
    $search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : (isset($_GET['search']) ? trim($_GET['search']) : '');
    $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'todos';
    $filter_date_from = isset($_GET['filter_date_from']) ? $_GET['filter_date_from'] : '';
    $filter_date_to = isset($_GET['filter_date_to']) ? $_GET['filter_date_to'] : '';
}

// Escapar el término de búsqueda para evitar inyección SQL
$search_term_escaped = mysqli_real_escape_string($conexion, $search_term);
?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Estilos para el modal de ver detalles -->
<style>
    .modal-detalles .modal-header {
        background: linear-gradient(135deg, #006341 0%, #00a86b 100%);
        color: white;
        border-bottom: none;
    }

    .modal-detalles .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-detalles .modal-body {
        padding: 1.5rem;
    }

    .modal-detalles .info-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #006341;
    }

    .modal-detalles .info-section h6 {
        color: #006341;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-detalles .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .modal-detalles .info-item {
        background: white;
        padding: 0.8rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .modal-detalles .info-item .label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .modal-detalles .info-item .value {
        font-weight: 600;
        color: #212529;
        word-break: break-word;
    }

    .modal-detalles .loading-spinner {
        text-align: center;
        padding: 3rem;
    }

    .modal-detalles .loading-spinner .spinner {
        width: 3rem;
        height: 3rem;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #006341;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Encabezado con botón de retorno dinámico -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">
                        <i class="bi bi-building me-2"></i>Internos de la Fundación
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        <?php if (!empty($fundacion_nombre)): ?>
                            Fundación: <strong><?php echo htmlspecialchars($fundacion_nombre); ?></strong>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border">
                        <i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y'); ?>
                    </span>
                    <a href="<?php echo $back_url; ?>" class="btn btn-outline-success ms-3">
                        <i class="bi bi-arrow-left me-2"></i><?php echo $back_text; ?>
                    </a>
                </div>
            </div>

            <!-- Mensaje informativo -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                Listado detallado de todos los internos registrados en esta fundación. Puedes ver la información completa de cada registro.
            </div>

            <?php
            // ===== Verificar que hay una fundación válida =====
            if ($fundacion_id <= 0 || empty($fundacion_nombre)) {
                echo '<div class="alert alert-warning">';
                echo '<i class="bi bi-exclamation-triangle-fill me-2"></i>';
                echo '<strong>No se ha podido identificar la fundación asociada a tu usuario.</strong>';
                echo '<p class="mt-3 mb-0">Esto puede deberse a que tu usuario no está vinculado a ninguna fundación.</p>';

                if ($usuario_tipo == 'fundacion') {
                    echo '<div class="mt-4">';
                    echo '<h6 class="fw-bold">Posibles soluciones:</h6>';
                    echo '<ul class="mt-2">';
                    echo '<li>Asegúrate de que tu usuario tenga un <code>id_fundacion</code> en la tabla <strong>usuarios</strong></li>';
                    echo '<li>Ejecuta esta consulta en la base de datos: <code>UPDATE usuarios SET id_fundacion = (SELECT id FROM fundaciones WHERE nombre LIKE "%' . $usuario_nombre . '%" LIMIT 1) WHERE id = ' . $usuario_id . ';</code></li>';
                    echo '<li>O vincúlalo manualmente desde el panel de administración</li>';
                    echo '</ul>';

                    echo '<div class="mt-3">';
                    echo '<a href="' . BASE_URL . 'views/modules/fundaciones/registro_fundacion.php" class="btn btn-success me-2">';
                    echo '<i class="bi bi-building-add me-2"></i>Registrar Fundación';
                    echo '</a>';
                    echo '<a href="' . BASE_URL . 'views/modules/fundaciones/panel_fundacion.php" class="btn btn-outline-secondary">';
                    echo '<i class="bi bi-arrow-left me-2"></i>Volver al Panel';
                    echo '</a>';
                    echo '</div>';
                }

                echo '</div>';
            } else {

                // ===== CONSTRUIR LA CONSULTA CON FILTROS =====
                $where_conditions = ["fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion_nombre) . "'"];

                // Aplicar filtros de búsqueda
                if (!empty($search_term_escaped)) {
                    if ($search_type == 'todos') {
                        $where_conditions[] = "(menor_nombres LIKE '%$search_term_escaped%' 
                                              OR menor_num_doc LIKE '%$search_term_escaped%' 
                                              OR acudiente_nombres LIKE '%$search_term_escaped%' 
                                              OR motivo_ingreso LIKE '%$search_term_escaped%')";
                    } elseif ($search_type == 'nombre') {
                        $where_conditions[] = "menor_nombres LIKE '%$search_term_escaped%'";
                    } elseif ($search_type == 'documento') {
                        $where_conditions[] = "menor_num_doc LIKE '%$search_term_escaped%'";
                    } elseif ($search_type == 'acudiente') {
                        $where_conditions[] = "acudiente_nombres LIKE '%$search_term_escaped%'";
                    } elseif ($search_type == 'motivo') {
                        $where_conditions[] = "motivo_ingreso LIKE '%$search_term_escaped%'";
                    }
                }

                // Aplicar filtros de fecha
                if (!empty($filter_date_from)) {
                    $where_conditions[] = "fecha_ingreso >= '$filter_date_from'";
                }
                if (!empty($filter_date_to)) {
                    $where_conditions[] = "fecha_ingreso <= '$filter_date_to'";
                }

                // Construir la consulta completa
                $where_clause = implode(' AND ', $where_conditions);
                $query = "SELECT 
                            id,
                            menor_nombres,
                            menor_tipo_doc,
                            menor_num_doc,
                            fecha_ingreso,
                            hora_ingreso,
                            motivo_ingreso,
                            acudiente_nombres,
                            escolaridad,
                            fecha_registro
                          FROM ingresos_fundacion 
                          WHERE $where_clause
                          ORDER BY fecha_ingreso DESC, hora_ingreso DESC";

                $result = mysqli_query($conexion, $query);

                if (!$result) {
                    echo '<div class="alert alert-danger">Error en la consulta: ' . mysqli_error($conexion) . '</div>';
                } else {
                    $total_internos = mysqli_num_rows($result);

                    // Consulta para el total sin filtros (estadísticas)
                    $query_total = "SELECT COUNT(*) as total FROM ingresos_fundacion 
                                    WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion_nombre) . "'";
                    $result_total = mysqli_query($conexion, $query_total);
                    $total_general = $result_total ? mysqli_fetch_assoc($result_total)['total'] : 0;
            ?>

                    <!-- ===== MOTOR DE BÚSQUEDA ===== -->
                    <div class="card border-0 shadow-lg rounded-4 mb-4">
                        <div class="card-header bg-success text-white py-3 border-0">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-search me-2"></i>
                                Buscar Internos
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="GET" action="" class="row g-3">
                                <!-- Campo de búsqueda principal -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Término de búsqueda</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control form-control-lg"
                                            name="search_term"
                                            value="<?php echo htmlspecialchars($search_term); ?>"
                                            placeholder="Escribe para buscar...">
                                    </div>
                                </div>

                                <!-- Tipo de búsqueda -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Buscar por</label>
                                    <select class="form-select form-select-lg" name="search_type">
                                        <option value="todos" <?php echo $search_type == 'todos' ? 'selected' : ''; ?>>Todos los campos</option>
                                        <option value="nombre" <?php echo $search_type == 'nombre' ? 'selected' : ''; ?>>Nombre del menor</option>
                                        <option value="documento" <?php echo $search_type == 'documento' ? 'selected' : ''; ?>>Documento</option>
                                        <option value="acudiente" <?php echo $search_type == 'acudiente' ? 'selected' : ''; ?>>Acudiente</option>
                                        <option value="motivo" <?php echo $search_type == 'motivo' ? 'selected' : ''; ?>>Motivo de ingreso</option>
                                    </select>
                                </div>

                                <!-- Filtro fecha desde -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Fecha desde</label>
                                    <input type="date" class="form-control form-control-lg"
                                        name="filter_date_from" value="<?php echo $filter_date_from; ?>">
                                </div>

                                <!-- Filtro fecha hasta -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Fecha hasta</label>
                                    <input type="date" class="form-control form-control-lg"
                                        name="filter_date_to" value="<?php echo $filter_date_to; ?>">
                                </div>

                                <!-- Botones de acción -->
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        <i class="bi bi-filter"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- Mostrar filtros activos -->
                            <?php if (!empty($search_term) || !empty($filter_date_from) || !empty($filter_date_to)): ?>
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold text-success">Filtros activos:</span>

                                        <?php if (!empty($search_term)): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border py-2 px-3">
                                                <i class="bi bi-search me-1"></i>
                                                <?php
                                                $tipo_texto = [
                                                    'todos' => 'Todos',
                                                    'nombre' => 'Nombre',
                                                    'documento' => 'Documento',
                                                    'acudiente' => 'Acudiente',
                                                    'motivo' => 'Motivo'
                                                ];
                                                echo $tipo_texto[$search_type] ?? 'Búsqueda'; ?>: "<?php echo htmlspecialchars($search_term); ?>"
                                                <a href="?<?php
                                                            $params = $_GET;
                                                            unset($params['search_term']);
                                                            unset($params['search_type']);
                                                            echo http_build_query($params);
                                                            ?>" class="text-success ms-2">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            </span>
                                        <?php endif; ?>

                                        <?php if (!empty($filter_date_from)): ?>
                                            <span class="badge bg-info bg-opacity-10 text-info border py-2 px-3">
                                                <i class="bi bi-calendar me-1"></i>Desde: <?php echo date('d/m/Y', strtotime($filter_date_from)); ?>
                                                <a href="?<?php
                                                            $params = $_GET;
                                                            unset($params['filter_date_from']);
                                                            echo http_build_query($params);
                                                            ?>" class="text-info ms-2">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            </span>
                                        <?php endif; ?>

                                        <?php if (!empty($filter_date_to)): ?>
                                            <span class="badge bg-info bg-opacity-10 text-info border py-2 px-3">
                                                <i class="bi bi-calendar me-1"></i>Hasta: <?php echo date('d/m/Y', strtotime($filter_date_to)); ?>
                                                <a href="?<?php
                                                            $params = $_GET;
                                                            unset($params['filter_date_to']);
                                                            echo http_build_query($params);
                                                            ?>" class="text-info ms-2">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            </span>
                                        <?php endif; ?>

                                        <!-- Botón para limpiar todos los filtros -->
                                        <?php if (!empty($search_term) || !empty($filter_date_from) || !empty($filter_date_to)): ?>
                                            <a href="?" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eraser me-1"></i>Limpiar filtros
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Resumen de internos con contador de resultados -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-2">Resultados</h6>
                                            <h3 class="fw-bold mb-0"><?php echo $total_internos; ?></h3>
                                            <small>de <?php echo $total_general; ?> totales</small>
                                        </div>
                                        <i class="bi bi-search-heart fs-1 text-white-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-2">Internos (Mes)</h6>
                                            <?php
                                            $query_mes = "SELECT COUNT(*) as total FROM ingresos_fundacion 
                                                  WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion_nombre) . "'
                                                  AND MONTH(fecha_ingreso) = MONTH(CURDATE()) 
                                                  AND YEAR(fecha_ingreso) = YEAR(CURDATE())";
                                            $result_mes = mysqli_query($conexion, $query_mes);
                                            $internos_mes = $result_mes ? mysqli_fetch_assoc($result_mes)['total'] : 0;
                                            ?>
                                            <h3 class="fw-bold mb-0"><?php echo $internos_mes; ?></h3>
                                        </div>
                                        <i class="bi bi-calendar-check fs-1 text-white-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-2">Último Ingreso</h6>
                                            <?php
                                            $query_ultimo = "SELECT MAX(fecha_ingreso) as ultimo FROM ingresos_fundacion 
                                                     WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion_nombre) . "'";
                                            $result_ultimo = mysqli_query($conexion, $query_ultimo);
                                            $ultimo_ingreso = $result_ultimo ? mysqli_fetch_assoc($result_ultimo)['ultimo'] : null;
                                            ?>
                                            <h5 class="fw-bold mb-0">
                                                <?php echo $ultimo_ingreso ? date('d/m/Y', strtotime($ultimo_ingreso)) : 'N/A'; ?>
                                            </h5>
                                        </div>
                                        <i class="bi bi-clock-history fs-1 text-white-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white shadow-lg border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-2">Fundación</h6>
                                            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($fundacion_nombre); ?></h5>
                                        </div>
                                        <i class="bi bi-building fs-1 text-white-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de internos con resultados de búsqueda -->
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-header bg-success text-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-list-columns me-2"></i>
                                Listado de Internos - <?php echo htmlspecialchars($fundacion_nombre); ?>
                            </h5>
                            <span class="badge bg-white text-success px-3 py-2">
                                <i class="bi bi-<?php echo !empty($search_term) ? 'filter' : 'people'; ?> me-2"></i>
                                <?php echo $total_internos; ?> registros encontrados
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4 py-3">#</th>
                                            <th class="py-3">Nombre del Menor</th>
                                            <th class="py-3">Documento</th>
                                            <th class="py-3">Fecha Ingreso</th>
                                            <th class="py-3">Hora</th>
                                            <th class="py-3">Motivo</th>
                                            <th class="py-3">Acudiente</th>
                                            <th class="py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($total_internos > 0):
                                            $contador = 1;
                                            while ($row = mysqli_fetch_assoc($result)):

                                                // Resaltar el término de búsqueda en los resultados
                                                $nombre_destacado = htmlspecialchars($row['menor_nombres'] ?: 'No registrado');
                                                $documento_destacado = htmlspecialchars(($row['menor_tipo_doc'] ?: '') . ' ' . ($row['menor_num_doc'] ?: ''));
                                                $acudiente_destacado = htmlspecialchars($row['acudiente_nombres'] ?: 'No registrado');
                                                $motivo_destacado = htmlspecialchars($row['motivo_ingreso'] ?: 'No especificado');

                                                if (!empty($search_term)) {
                                                    $search_term_destacado = preg_quote($search_term, '/');
                                                    $nombre_destacado = preg_replace("/($search_term_destacado)/i", '<span class="bg-warning bg-opacity-25 p-1 rounded">$1</span>', $nombre_destacado);
                                                    $documento_destacado = preg_replace("/($search_term_destacado)/i", '<span class="bg-warning bg-opacity-25 p-1 rounded">$1</span>', $documento_destacado);
                                                    $acudiente_destacado = preg_replace("/($search_term_destacado)/i", '<span class="bg-warning bg-opacity-25 p-1 rounded">$1</span>', $acudiente_destacado);
                                                    $motivo_destacado = preg_replace("/($search_term_destacado)/i", '<span class="bg-warning bg-opacity-25 p-1 rounded">$1</span>', $motivo_destacado);
                                                }
                                        ?>
                                                <tr>
                                                    <td class="px-4"><?php echo $contador++; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                                <i class="bi bi-person-circle text-success"></i>
                                                            </div>
                                                            <strong><?php echo $nombre_destacado; ?></strong>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $documento_destacado ?: '<span class="text-muted">-</span>'; ?></td>
                                                    <td>
                                                        <?php
                                                        echo $row['fecha_ingreso']
                                                            ? date('d/m/Y', strtotime($row['fecha_ingreso']))
                                                            : '<span class="text-muted">-</span>';
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['hora_ingreso'] ?: '<span class="text-muted">-</span>'; ?></td>
                                                    <td>
                                                        <?php
                                                        echo strlen($motivo_destacado) > 40 ? substr($motivo_destacado, 0, 40) . '...' : $motivo_destacado;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $acudiente_destacado; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-info" onclick="verDetalles(<?php echo $row['id']; ?>)" title="Ver detalles completos">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning" onclick="editarRegistro(<?php echo $row['id']; ?>)" title="Editar información">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(<?php echo $row['id']; ?>)" title="Eliminar">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php
                                            endwhile;
                                        else:
                                            ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                                                    <h5 class="text-muted mb-3">
                                                        <?php if (!empty($search_term) || !empty($filter_date_from) || !empty($filter_date_to)): ?>
                                                            No se encontraron resultados para tu búsqueda
                                                        <?php else: ?>
                                                            No hay internos registrados en esta fundación
                                                        <?php endif; ?>
                                                    </h5>
                                                    <?php if (empty($search_term) && empty($filter_date_from) && empty($filter_date_to) && $usuario_tipo == 'fundacion'): ?>
                                                        <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php"
                                                            class="btn btn-success">
                                                            <i class="bi bi-plus-circle me-2"></i>Registrar primer interno
                                                        </a>
                                                    <?php elseif (!empty($search_term) || !empty($filter_date_from) || !empty($filter_date_to)): ?>
                                                        <a href="?" class="btn btn-outline-secondary">
                                                            <i class="bi bi-arrow-left me-2"></i>Limpiar búsqueda
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Mostrando <?php echo $total_internos; ?> de <?php echo $total_general; ?> registros totales
                                </span>
                                <div>
                                    <button class="btn btn-sm btn-outline-success me-2" onclick="window.print()">
                                        <i class="bi bi-printer me-2"></i>Imprimir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                }
            }
            ?>

        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLES DEL INTERNO -->
<div class="modal fade modal-detalles" id="modalVerInterno" tabindex="-1" aria-labelledby="modalVerInternoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalVerInternoLabel">
                    <i class="bi bi-person-badge me-2"></i>
                    DETALLES COMPLETOS DEL INTERNO
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body" id="modalInternoContent">
                <!-- Contenido cargado vía AJAX -->
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    <p class="text-muted">Cargando información...</p>
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <span class="text-muted small" id="fechaRegistroInfo"></span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let idEdicion = null;
    const BASE_URL = '<?php echo BASE_URL; ?>';

    // Función para ver detalles en modal
    function verDetalles(id) {
        const modalContent = document.getElementById('modalInternoContent');
        const fechaRegistroInfo = document.getElementById('fechaRegistroInfo');

        // Mostrar loading
        modalContent.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner"></div>
                <p class="text-muted">Cargando información del interno...</p>
            </div>
        `;
        fechaRegistroInfo.textContent = '';

        // Abrir el modal
        const modal = new bootstrap.Modal(document.getElementById('modalVerInterno'));
        modal.show();

        // Petición AJAX para obtener los datos completos
        fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php?accion=obtener&id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    modalContent.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-1 mb-3"></i>
                            <h5 class="text-danger">Error al cargar los datos</h5>
                            <p class="text-muted">${data.error}</p>
                        </div>
                    `;
                    return;
                }

                const f = data;

                // Formatear fechas
                const fechaNacimiento = f.fecha_nacimiento ? new Date(f.fecha_nacimiento).toLocaleDateString('es-CO') : 'No especificada';
                const fechaIngreso = f.fecha_ingreso ? new Date(f.fecha_ingreso).toLocaleDateString('es-CO') : 'No especificada';
                const fechaRegistro = f.fecha_registro ? new Date(f.fecha_registro).toLocaleString('es-CO') : 'No disponible';

                // Construir HTML con la información
                let html = `
                    <!-- INFORMACIÓN DEL MENOR -->
                    <div class="info-section">
                        <h6><i class="bi bi-person-fill text-success"></i> DATOS DEL MENOR</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Nombre Completo</div>
                                <div class="value">${escapeHtml(f.menor_nombres || 'No registrado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Tipo Documento</div>
                                <div class="value">${escapeHtml(f.menor_tipo_doc || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Número Documento</div>
                                <div class="value">${escapeHtml(f.menor_num_doc || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Fecha Nacimiento</div>
                                <div class="value">${fechaNacimiento}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Edad</div>
                                <div class="value">${escapeHtml(f.edad || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Sexo</div>
                                <div class="value">${escapeHtml(f.sexo === 'M' ? 'Masculino' : f.sexo === 'F' ? 'Femenino' : 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Nacionalidad</div>
                                <div class="value">${escapeHtml(f.nacionalidad || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Lugar de Nacimiento</div>
                                <div class="value">${escapeHtml(f.lugar_nacimiento || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Dirección de Domicilio</div>
                                <div class="value">${escapeHtml(f.direccion_domicilio || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">EPS / Seguro Médico</div>
                                <div class="value">${escapeHtml(f.eps || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Estado de Salud</div>
                                <div class="value">${escapeHtml(f.salud_general || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Alergias / Condiciones</div>
                                <div class="value">${escapeHtml(f.alergias || 'No especificadas')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Discapacidad</div>
                                <div class="value">${escapeHtml(f.discapacidad || 'No')} ${f.cual_discapacidad ? '- ' + escapeHtml(f.cual_discapacidad) : ''}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- INFORMACIÓN DEL ACUDIENTE -->
                    <div class="info-section">
                        <h6><i class="bi bi-people-fill text-success"></i> ACUDIENTE PRINCIPAL</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Nombre Completo</div>
                                <div class="value">${escapeHtml(f.acudiente_nombres || 'No registrado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Tipo Documento</div>
                                <div class="value">${escapeHtml(f.acudiente_tipo_doc || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Número Documento</div>
                                <div class="value">${escapeHtml(f.acudiente_num_doc || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Parentesco</div>
                                <div class="value">${escapeHtml(f.acudiente_parentesco || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Dirección</div>
                                <div class="value">${escapeHtml(f.acudiente_direccion || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Teléfono</div>
                                <div class="value">${escapeHtml(f.acudiente_tel || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Correo Electrónico</div>
                                <div class="value">${escapeHtml(f.acudiente_email || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Ocupación</div>
                                <div class="value">${escapeHtml(f.acudiente_ocupacion || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Responsable Legal</div>
                                <div class="value">${escapeHtml(f.responsable_legal || 'No')}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- INFORMACIÓN DE PADRES -->
                    <div class="info-section">
                        <h6><i class="bi bi-person-fill text-success"></i> PADRE</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Nombre Completo</div>
                                <div class="value">${escapeHtml(f.padre_nombres || 'No registrado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Documento</div>
                                <div class="value">${escapeHtml(f.padre_tipo_doc || '')} ${escapeHtml(f.padre_num_doc || '')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Dirección</div>
                                <div class="value">${escapeHtml(f.padre_direccion || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Teléfono</div>
                                <div class="value">${escapeHtml(f.padre_tel || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Correo</div>
                                <div class="value">${escapeHtml(f.padre_email || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Ocupación</div>
                                <div class="value">${escapeHtml(f.padre_ocupacion || 'No especificada')}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h6><i class="bi bi-person-fill text-success"></i> MADRE</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Nombre Completo</div>
                                <div class="value">${escapeHtml(f.madre_nombres || 'No registrado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Documento</div>
                                <div class="value">${escapeHtml(f.madre_tipo_doc || '')} ${escapeHtml(f.madre_num_doc || '')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Dirección</div>
                                <div class="value">${escapeHtml(f.madre_direccion || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Teléfono</div>
                                <div class="value">${escapeHtml(f.madre_tel || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Correo</div>
                                <div class="value">${escapeHtml(f.madre_email || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Ocupación</div>
                                <div class="value">${escapeHtml(f.madre_ocupacion || 'No especificada')}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- INFORMACIÓN DE INGRESO -->
                    <div class="info-section">
                        <h6><i class="bi bi-calendar-check-fill text-success"></i> INFORMACIÓN DE INGRESO</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Fecha de Ingreso</div>
                                <div class="value">${fechaIngreso}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Hora de Ingreso</div>
                                <div class="value">${escapeHtml(f.hora_ingreso || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Motivo de Ingreso</div>
                                <div class="value">${escapeHtml(f.motivo_ingreso || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Tipo de Ingreso</div>
                                <div class="value">${escapeHtml(f.tipo_ingreso || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Responsable que Remite</div>
                                <div class="value">${escapeHtml(f.responsable_remite || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Entidad</div>
                                <div class="value">${escapeHtml(f.entidad_remite || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Documento del Responsable</div>
                                <div class="value">${escapeHtml(f.doc_tipo || '')} ${escapeHtml(f.doc_numero || '')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">N° Proceso/Expediente</div>
                                <div class="value">${escapeHtml(f.numero_proceso || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Fecha de Remisión</div>
                                <div class="value">${f.fecha_remision ? new Date(f.fecha_remision).toLocaleDateString('es-CO') : 'No especificada'}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- INFORMACIÓN PSICOSOCIAL Y ACUERDO -->
                    <div class="info-section">
                        <h6><i class="bi bi-brain-fill text-success"></i> INFORMACIÓN PSICOSOCIAL</h6>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Escolaridad</div>
                                <div class="value">${escapeHtml(f.escolaridad || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Institución Educativa</div>
                                <div class="value">${escapeHtml(f.institucion || 'No especificada')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Último Grado</div>
                                <div class="value">${escapeHtml(f.ultimo_grado || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Observaciones Psicológicas</div>
                                <div class="value">${escapeHtml(f.obs_psicologicas || 'No hay observaciones')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Observaciones Sociales</div>
                                <div class="value">${escapeHtml(f.obs_sociales || 'No hay observaciones')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Funcionario que Recibe</div>
                                <div class="value">${escapeHtml(f.funcionario_recibe || 'No especificado')}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Remitente</div>
                                <div class="value">${escapeHtml(f.remitente_final || 'No especificado')}</div>
                            </div>
                        </div>
                    </div>
                `;

                modalContent.innerHTML = html;
                fechaRegistroInfo.textContent = `Registrado: ${fechaRegistro}`;
            })
            .catch(error => {
                console.error('Error:', error);
                modalContent.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-3"></i>
                        <h5 class="text-danger">Error al cargar los datos</h5>
                        <p class="text-muted">Ocurrió un problema al obtener la información del interno.</p>
                    </div>
                `;
            });
    }

    // Función para editar registro - MODIFICADA para enviar a registroMenor.php
    function editarRegistro(id) {
        window.location.href = 'registroMenor.php?id=' + id;
    }

    // Función para eliminar registro
    function eliminarRegistro(id) {
        if (confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.')) {
            fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'accion=eliminar&id=' + id
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Registro eliminado correctamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar: ' + (result.error || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar:', error);
                    alert('Error al conectar con el servidor');
                });
        }
    }

    // Función para escapar HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Estilos personalizados -->
<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
    }

    .bg-success {
        background-color: #006341 !important;
    }

    .bg-success.bg-opacity-10 {
        background-color: rgba(0, 99, 65, 0.1) !important;
    }

    .text-success {
        color: #006341 !important;
    }

    .btn-success {
        background-color: #006341;
        border-color: #006341;
    }

    .btn-success:hover {
        background-color: #004d33;
        border-color: #004d33;
    }

    .table th {
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-select-lg,
    .form-control-lg {
        border-radius: 8px;
    }

    .badge a {
        text-decoration: none;
    }

    .badge a:hover {
        opacity: 0.8;
    }
</style>

<?php include("../../../footer.php"); ?>