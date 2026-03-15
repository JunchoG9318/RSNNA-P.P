<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");

// Obtener el tipo de usuario
$usuario_tipo = $_SESSION['usuario_tipo'];
$usuario_nombre = $_SESSION['usuario_nombre'];

// Determinar la URL de retorno según el tipo de usuario
if ($usuario_tipo == 'fundacion') {
    $back_url = BASE_URL . "views/modules/fundaciones/panel_fundacion.php";
    $back_text = "Volver al Panel de Fundación";
} elseif ($usuario_tipo == 'icbf') {
    $back_url = BASE_URL . "views/modules/ICBF/panel_icbf.php";
    $back_text = "Volver al Panel ICBF";
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
                        <i class="bi bi-building me-2"></i>Internos por Fundación
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        <?php if ($usuario_tipo == 'fundacion'): ?>
                            Estadísticas de tu fundación
                        <?php else: ?>
                            Reporte de internos por fundación
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

            <!-- Mensaje de bienvenida -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                <?php if ($usuario_tipo == 'fundacion'): ?>
                    Aquí puedes ver las estadísticas de los internos registrados en tu fundación.
                <?php else: ?>
                    Reporte de internos agrupados por fundación. Aquí puedes ver la distribución de internos en cada fundación.
                <?php endif; ?>
            </div>

            <?php
            // CONSULTA - Filtrada por fundación del usuario si aplica
            if ($usuario_tipo == 'fundacion') {
                // Para usuarios de fundación, mostrar solo su fundación
                // Asumimos que el nombre de la fundación está relacionado con el nombre del usuario
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
                    WHERE f.nombre LIKE '%$usuario_nombre%' 
                       OR f.nombre IN (SELECT nombre FROM fundaciones WHERE nombre LIKE '%$usuario_nombre%')
                    GROUP BY f.id
                ";
            } else {
                // Mostrar todas las fundaciones (para ICBF)
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
                
                // Calcular total general de internos (solo de las fundaciones mostradas)
                if ($usuario_tipo == 'fundacion') {
                    $query_total = "SELECT COUNT(*) as total FROM ingresos_fundacion WHERE fundacion_nombre LIKE '%$usuario_nombre%'";
                } else {
                    $query_total = "SELECT COUNT(*) as total FROM ingresos_fundacion";
                }
                $result_total = mysqli_query($conexion, $query_total);
                $total_internos_general = $result_total ? mysqli_fetch_assoc($result_total)['total'] : 0;
            ?>
            
            <!-- Resumen -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">
                                        <?php echo ($usuario_tipo == 'fundacion') ? 'Tu Fundación' : 'Total Fundaciones'; ?>
                                    </h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_fundaciones; ?></h3>
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

            <!-- Tabla de resultados -->
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-success text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-columns me-2"></i>
                        <?php echo ($usuario_tipo == 'fundacion') ? 'Detalle de tu Fundación' : 'Detalle por Fundación'; ?>
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
                                if (mysqli_num_rows($result) > 0):
                                    $contador = 1;
                                    while ($row = mysqli_fetch_assoc($result)): 
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
                                        <?php if ($usuario_tipo == 'fundacion'): ?>
                                            <h5>No hay internos registrados en tu fundación</h5>
                                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" class="btn btn-success mt-3">
                                                <i class="bi bi-plus-circle me-2"></i>Registrar primer interno
                                            </a>
                                        <?php else: ?>
                                            <h5>No hay fundaciones registradas</h5>
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

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>