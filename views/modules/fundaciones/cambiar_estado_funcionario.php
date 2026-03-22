<?php
session_start();
require_once("../../../config/conexion.php");

$id = (int)($_GET['id'] ?? 0);

// Obtener estado actual
$sql = "SELECT estado FROM funcionarios WHERE id = $id";
$result = $conexion->query($sql);
$func = $result->fetch_assoc();

$nuevo_estado = $func['estado'] == 1 ? 0 : 1;

$update = "UPDATE funcionarios SET estado = $nuevo_estado WHERE id = $id";
$conexion->query($update);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>