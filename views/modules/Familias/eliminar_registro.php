<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

require_once("../../../config/conexion.php");

$id         = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_usuario = $_SESSION['usuario_id'];

if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM registro_familiar WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $id_usuario);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();
header("Location: listar_registros_familiar.php?deleted=1");
exit();
?>
 //poner una alerta.//