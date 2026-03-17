<?php
session_start();
include("../config/conexion.php");

if(isset($_POST['guardar_familiar'])){

$interno_id = $_POST['interno_id'];
$nombres = $_POST['nombres']." ".$_POST['apellidos'];



$tipo_documento = $_POST['tipo_documento'];
$numero_documento = $_POST['numero_documento'];
$parentesco = $_POST['parentesco'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$ocupacion = $_POST['ocupacion'];
$responsable = isset($_POST['responsable_legal']) ? 1 : 0;

$sql = "INSERT INTO familiares(
interno_id,
nombres,
tipo_documento,
numero_documento,
parentesco,
telefono,
email,
direccion,
ocupacion,
responsable_legal
) VALUES(
'$interno_id',
'$nombres',
'$tipo_documento',
'$numero_documento',
'$parentesco',
'$telefono',
'$email',
'$direccion',
'$ocupacion',
'$responsable'
)";

mysqli_query($conexion,$sql);

header("Location: ../views/modules/Familias/panel_familia.php?ok=1");
exit();

}
?>