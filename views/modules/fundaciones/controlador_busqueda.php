<?php
include("../../../config/conexion.php");
header('Content-Type: application/json');

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

switch ($accion) {
    
    case 'recientes':
        $query = "SELECT id, menor_nombres, menor_tipo_doc, menor_num_doc, fecha_ingreso, motivo_ingreso, escolaridad 
                  FROM ingresos_fundacion 
                  WHERE fecha_ingreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                  ORDER BY fecha_ingreso DESC, hora_ingreso DESC
                  LIMIT 10";
        break;
        
    case 'todos':
        $query = "SELECT id, menor_nombres, menor_tipo_doc, menor_num_doc, fecha_ingreso, motivo_ingreso, escolaridad 
                  FROM ingresos_fundacion 
                  ORDER BY fecha_ingreso DESC, hora_ingreso DESC
                  LIMIT 20";
        break;
        
    case 'buscar':
        $termino = isset($_GET['termino']) ? mysqli_real_escape_string($conexion, $_GET['termino']) : '';
        
        if (empty($termino)) {
            echo json_encode([]);
            exit;
        }
        
        // Buscar por nombre o por número de documento
        $query = "SELECT id, menor_nombres, menor_tipo_doc, menor_num_doc, fecha_ingreso, motivo_ingreso, escolaridad 
                  FROM ingresos_fundacion 
                  WHERE menor_nombres LIKE '%$termino%' 
                     OR menor_num_doc LIKE '%$termino%'
                  ORDER BY fecha_ingreso DESC
                  LIMIT 20";
        break;
        
    default:
        echo json_encode(['error' => 'Acción no válida']);
        exit;
}

$result = mysqli_query($conexion, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>