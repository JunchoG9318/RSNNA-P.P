<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$sql = "SELECT id, fecha_ingreso, menor_nombres, menor_tipo_doc, menor_num_doc, acudiente_nombres, motivo_ingreso FROM registro_ingreso_fundacion ORDER BY id DESC";
$result = $conn->query($sql);
$registros = [];
while ($row = $result->fetch_assoc()) {
    $registros[] = $row;
}
echo json_encode($registros);
$conn->close();
?>