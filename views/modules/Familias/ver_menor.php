<?php
include("../../../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT internos.*, fundaciones.nombre AS fundacion
        FROM internos
        INNER JOIN fundaciones ON internos.id_fundacion = fundaciones.id
        WHERE internos.id = '$id'";

$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);

// calcular edad
$fecha = new DateTime($row['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fecha)->y;

echo json_encode([
    "id" => $row['id'],
    "nombre" => $row['menor_nombres'] . " " . $row['menor_apellidos'],
    "documento" => $row['menor_tipo_doc'] . " - " . $row['menor_num_doc'],
    "edad" => $edad,
    "sexo" => $row['sexo'],
    "fundacion" => $row['fundacion'],
    "estado" => $row['estado']
]);