<h2>Documentación del Interno</h2>

<table border="1">
<tr>
<th>Documento</th>
<th>Fecha</th>
<th>Acción</th>
</tr>

<?php
include "../../../config/conexion.php";

$sql="SELECT * FROM documentos";
$result=mysqli_query($conexion,$sql);

while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['nombre_documento']; ?></td>
<td><?php echo $row['fecha']; ?></td>
<td><a href="<?php echo $row['ruta']; ?>">Ver</a></td>
</tr>

<?php } ?>
</table>