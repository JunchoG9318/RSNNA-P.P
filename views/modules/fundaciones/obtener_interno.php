<?php
session_start();
include("../../../config/conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'icbf') {
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM ingresos_fundacion WHERE id = $id";
$result = mysqli_query($conexion, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode(['error' => 'Registro no encontrado']);
    exit();
}

$data = mysqli_fetch_assoc($result);
echo json_encode($data);
?>