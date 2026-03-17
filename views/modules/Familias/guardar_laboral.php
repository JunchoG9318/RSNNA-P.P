<?php

include("../../../config/conexion.php");

$profesion = $_POST['profesion'];
$lugar = $_POST['lugar_trabajo'];
$jefe = $_POST['jefe'];
$telefono = $_POST['telefono_jefe'];
$interno = $_POST['interno'];
$funciones = $_POST['funciones'];

$sql = "INSERT INTO informacion_laboral 
(profesion, lugar_trabajo, jefe, telefono_jefe, interno, funciones)
VALUES 
('$profesion','$lugar','$jefe','$telefono','$interno','$funciones')";

if ($conexion->query($sql)) {

    header("Location: informacion_intern_fami.php");
    exit();

} else {

    echo "Error al guardar: " . $conexion->error;

}

?>