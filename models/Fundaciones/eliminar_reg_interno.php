<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'error' => 'ID no válido']);
    exit;
}

$sql = "DELETE FROM registro_ingreso_fundacion WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>