<?php
header('Content-Type: application/json');
require_once 'conexion.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM registro_ingreso_fundacion WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$registro = $result->fetch_assoc();
if ($registro) {
    echo json_encode($registro);
} else {
    echo json_encode(['error' => 'Registro no encontrado']);
}
$stmt->close();
$conn->close();
?>