<?php
// Activar visualización de errores para depuración (QUITAR EN PRODUCCIÓN)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Incluir conexión - AJUSTA LA RUTA SEGÚN SEA NECESARIO
$ruta_conexion = "../../../config/conexion.php";
if (!file_exists($ruta_conexion)) {
    $ruta_conexion = "config/conexion.php";
    if (!file_exists($ruta_conexion)) {
        die("Error: No se encontró el archivo de conexión");
    }
}
require_once($ruta_conexion);

// Verificar conexión
if (!isset($conexion) || $conexion->connect_error) {
    header("Location: registro.php?error=5");
    exit();
}

// Verificar que se envió por POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registro.php");
    exit();
}

// Obtener y limpiar datos
$tipo_usuario = isset($_POST['tipo_usuario']) ? trim($_POST['tipo_usuario']) : '';
$nombre_completo = isset($_POST['nombre_completo']) ? trim($_POST['nombre_completo']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validaciones básicas
if (empty($tipo_usuario)) {
    header("Location: registro.php?error=4");
    exit();
}

if (empty($nombre_completo) || empty($correo) || empty($telefono) || empty($password)) {
    header("Location: registro.php?error=3");
    exit();
}

if ($password !== $confirm_password) {
    header("Location: registro.php?error=1");
    exit();
}

if (strlen($password) < 6) {
    header("Location: registro.php?error=1");
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: registro.php?error=3");
    exit();
}

// Verificar si la tabla existe
$check_table = $conexion->query("SHOW TABLES LIKE 'usuarios'");
if ($check_table->num_rows == 0) {
    header("Location: registro.php?error=6");
    exit();
}

// Escapar datos para evitar inyección SQL
$tipo_usuario = $conexion->real_escape_string($tipo_usuario);
$nombre_completo = $conexion->real_escape_string($nombre_completo);
$correo = $conexion->real_escape_string($correo);
$telefono = $conexion->real_escape_string($telefono);

// Verificar si el correo ya existe
$check_query = "SELECT id FROM usuarios WHERE correo = '$correo'";
$check_result = $conexion->query($check_query);

if ($check_result && $check_result->num_rows > 0) {
    header("Location: registro.php?error=2");
    exit();
}

// Encriptar contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$query = "INSERT INTO usuarios (correo, password, tipo_usuario, nombre_completo, telefono) 
          VALUES ('$correo', '$password_hash', '$tipo_usuario', '$nombre_completo', '$telefono')";

if ($conexion->query($query)) {
    // Registro exitoso
    header("Location: registro.php?success=1");
    exit();
} else {
    // Error en la inserción
    $error = $conexion->error;
    header("Location: registro.php?error=3&detalle=" . urlencode($error));
    exit();
}
?>