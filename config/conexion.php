<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rsnna";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

// Para usar en cualquier archivo
if (!isset($conexion)) {
    die("Error: No se pudo establecer la conexión con la base de datos");
}
?>