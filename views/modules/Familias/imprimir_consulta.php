<?php
include "../../../config/conexion.php";

$sql = "SELECT 

internos.menor_nombres,
internos.menor_num_doc,
internos.fecha_nacimiento,

fundaciones.nombre,
fundaciones.direccion,
fundaciones.ciudad,
fundaciones.nombre_director,
fundaciones.telefono_director

FROM internos

INNER JOIN fundaciones 
ON internos.id_fundacion = fundaciones.id";

$resultado = mysqli_query($conexion,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Imprimir Información</title>

<script>
window.onload=function(){
window.print();
}
</script>

<style>

body{
font-family:Arial;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid black;
padding:8px;
text-align:left;
}

</style>

</head>

<body>

<h2>Información del Hijo y Fundación</h2>

<table>

<tr>

<th>Nombre</th>
<th>Documento</th>
<th>Fecha Nacimiento</th>
<th>Fundación</th>
<th>Dirección</th>
<th>Ciudad</th>
<th>Director</th>
<th>Teléfono</th>

</tr>

<?php while($row=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?php echo $row['menor_nombres']; ?></td>
<td><?php echo $row['menor_num_doc']; ?></td>
<td><?php echo $row['fecha_nacimiento']; ?></td>
<td><?php echo $row['nombre']; ?></td>
<td><?php echo $row['direccion']; ?></td>
<td><?php echo $row['ciudad']; ?></td>
<td><?php echo $row['nombre_director']; ?></td>
<td><?php echo $row['telefono_director']; ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>