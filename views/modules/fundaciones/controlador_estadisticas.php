<?php
include("../../../config/conexion.php");
header('Content-Type: application/json');

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if ($accion == 'estadisticas') {
    
    // Total de internos
    $queryTotal = "SELECT COUNT(*) as total FROM ingresos_fundacion";
    $resultTotal = mysqli_query($conexion, $queryTotal);
    $total = mysqli_fetch_assoc($resultTotal)['total'];
    
    // Internos activos (consideramos activos los que tienen fecha de ingreso en los últimos 30 días)
    $queryActivos = "SELECT COUNT(*) as activos FROM ingresos_fundacion WHERE fecha_ingreso >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
    $resultActivos = mysqli_query($conexion, $queryActivos);
    $activos = mysqli_fetch_assoc($resultActivos)['activos'];
    
    // Ingresos del mes actual
    $queryMes = "SELECT COUNT(*) as ingresos_mes FROM ingresos_fundacion WHERE MONTH(fecha_ingreso) = MONTH(CURDATE()) AND YEAR(fecha_ingreso) = YEAR(CURDATE())";
    $resultMes = mysqli_query($conexion, $queryMes);
    $ingresos_mes = mysqli_fetch_assoc($resultMes)['ingresos_mes'];
    
    // Programas únicos (contar programas distintos de escolaridad)
    $queryProgramas = "SELECT COUNT(DISTINCT escolaridad) as programas FROM ingresos_fundacion WHERE escolaridad IS NOT NULL AND escolaridad != ''";
    $resultProgramas = mysqli_query($conexion, $queryProgramas);
    $programas = mysqli_fetch_assoc($resultProgramas)['programas'];
    
    echo json_encode([
        'total' => $total,
        'activos' => $activos,
        'ingresos_mes' => $ingresos_mes,
        'programas' => $programas ?: 0
    ]);
}
?>