<?php
session_start();
require_once("../../../config/conexion.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cambiar_password.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$password_actual = $_POST['password_actual'] ?? '';
$password_nueva = $_POST['password_nueva'] ?? '';
$password_confirmar = $_POST['password_confirmar'] ?? '';

// Validaciones
if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
    header("Location: cambiar_password.php?error=campos_vacios");
    exit();
}

if ($password_nueva !== $password_confirmar) {
    header("Location: cambiar_password.php?error=no_coinciden");
    exit();
}

if (strlen($password_nueva) < 6) {
    header("Location: cambiar_password.php?error=longitud_minima");
    exit();
}

// Verificar contraseña actual
$query = "SELECT password FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!password_verify($password_actual, $usuario['password'])) {
    header("Location: cambiar_password.php?error=password_incorrecta");
    exit();
}

// Actualizar contraseña
$password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
$update = "UPDATE usuarios SET password = ? WHERE id = ?";
$stmt_update = $conexion->prepare($update);
$stmt_update->bind_param("si", $password_hash, $usuario_id);

if ($stmt_update->execute()) {
    header("Location: cambiar_password.php?success=1");
} else {
    header("Location: cambiar_password.php?error=error_actualizacion");
}
exit();
?>