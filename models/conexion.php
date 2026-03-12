<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rsnna";

$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>