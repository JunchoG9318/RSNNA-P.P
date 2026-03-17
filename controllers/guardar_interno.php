<?php
session_start();
include("../config/conexion.php");

if(!isset($_SESSION['id_fundacion'])){
    die("Error: sesión no válida");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

$id_usuario = $_SESSION['id_usuario'];

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$fecha = $_POST['fecha_nacimiento'];
$lugar = $_POST['lugar_nacimiento'];
$tipo_doc = $_POST['tipo_doc'];
$num_doc = $_POST['num_doc'];
$sexo = $_POST['sexo'];
$discapacidad = $_POST['discapacidad'];

$sql = "INSERT INTO internos(
id_fundacion,
menor_nombres,
menor_apellidos,
fecha_nacimiento,
lugar_nacimiento,
menor_tipo_doc,
menor_num_doc,
sexo,
discapacidad,
fecha_ingreso
) VALUES(
'$id_fundacion',
'$nombres',
'$apellidos',
'$fecha',
'$lugar',
'$tipo_doc',
'$num_doc',
'$sexo',
'$discapacidad',
NOW()
)";

mysqli_query($conexion,$sql);

header("Location: ../views/modules/Familias/informacion_intern_fami.php?ok=1");
exit();

}
?>