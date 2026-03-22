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
        // Si no hay id_fundacion en sesión, buscar por nombre del usuario
        $query_fundacion = "SELECT id, nombre FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%' LIMIT 1";
        $result_fundacion = mysqli_query($conexion, $query_fundacion);
        if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
            $row_fundacion = mysqli_fetch_assoc($result_fundacion);
            $fundacion_id = $row_fundacion['id'];
            $fundacion_nombre = $row_fundacion['nombre'];
            // Guardar en sesión para futuras consultas
            $_SESSION['id_fundacion'] = $fundacion_id;
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
?>

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
            // ===== CORRECCIÓN: Verificar que hay una fundación válida =====
            if ($fundacion_id <= 0 || empty($fundacion_nombre)) {
                echo '<div class="alert alert-warning">';
                echo '<i class="bi bi-exclamation-triangle-fill me-2"></i>';
                echo '<strong>No se ha podido identificar la fundación asociada a tu usuario.</strong>';
                echo '<p class="mt-3 mb-0">Esto puede deberse a que tu usuario no está vinculado a ninguna fundación.</p>';
                
                if ($usuario_tipo == 'fundacion') {
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
                
                // Consulta para obtener todos los internos de la fundación
                $query = "
                    SELECT 
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
                    WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion_nombre) . "'
                    ORDER BY fecha_ingreso DESC, hora_ingreso DESC
                ";
                
                $result = mysqli_query($conexion, $query);
                
                if (!$result) {
                    echo '<div class="alert alert-danger">Error en la consulta: ' . mysqli_error($conexion) . '</div>';
                } else {
                    $total_internos = mysqli_num_rows($result);
            ?>
            
            <!-- Resumen de internos -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Total Internos</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_internos; ?></h3>
                                </div>
                                <i class="bi bi-people-fill fs-1 text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
            </div>

            <!-- Tabla de internos -->
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-success text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-columns me-2"></i>
                        Listado de Internos - <?php echo htmlspecialchars($fundacion_nombre); ?>
                    </h5>
                    <span class="badge bg-white text-success px-3 py-2">
                        Total: <?php echo $total_internos; ?> registros
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($total_internos > 0):
                                    $contador = 1;
                                    while ($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr>
                                    <td class="px-4"><?php echo $contador++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-person-circle text-success"></i>
                                            </div>
                                            <strong><?php echo htmlspecialchars($row['menor_nombres'] ?: 'No registrado'); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $tipo_doc = $row['menor_tipo_doc'] ?: '';
                                        $num_doc = $row['menor_num_doc'] ?: '';
                                        echo htmlspecialchars($tipo_doc . ' ' . $num_doc);
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        echo $row['fecha_ingreso'] 
                                            ? date('d/m/Y', strtotime($row['fecha_ingreso'])) 
                                            : '<span class="text-muted">-</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row['hora_ingreso'] ?: '<span class="text-muted">-</span>'; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $motivo = $row['motivo_ingreso'] ?: 'No especificado';
                                        echo strlen($motivo) > 30 ? substr($motivo, 0, 30) . '...' : $motivo;
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['acudiente_nombres'] ?: 'No registrado'); ?></td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted mb-3">No hay internos registrados en esta fundación</h5>
                                        <?php if ($usuario_tipo == 'fundacion'): ?>
                                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" 
                                               class="btn btn-success">
                                                <i class="bi bi-plus-circle me-2"></i>Registrar primer interno
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
            
            <?php 
                }
            } 
            ?>
            
        </div>
    </div>
</div>

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
    }
    .table td {
        vertical-align: middle;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>