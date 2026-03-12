<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'error' => 'ID no válido']);
    exit;
}

$campos = [ /* misma lista que en guardar */ ];
$set = [];
$types = '';
$values = [];
foreach ($campos as $c) {
    $set[] = "$c = ?";
    $types .= 's';
    $values[] = isset($_POST[$c]) ? $_POST[$c] : null;
}
$types .= 'i';
$values[] = $id;

$sql = "UPDATE registro_ingreso_fundacion SET " . implode(', ', $set) . " WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$values);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>