<?php
include "../../../config/conexion.php";

$sql = "SELECT 
internos.id,
internos.menor_nombres,
internos.menor_tipo_doc,
internos.menor_num_doc,
internos.fecha_nacimiento,
internos.sexo,
internos.eps,
internos.escolaridad,
internos.institucion,

fundaciones.nombre AS fundacion,
fundaciones.nit,
fundaciones.direccion,
fundaciones.telefono_director,
fundaciones.correo_director

FROM internos
INNER JOIN fundaciones 
ON internos.id_fundacion = fundaciones.id";

$resultado = mysqli_query($conexion,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Consultas del Hijo</title>

<style>

body{
font-family: Arial;
background:#f4f6f9;
margin:0;
padding:30px;
}

.titulo{
font-size:28px;
margin-bottom:20px;
}

.contenedor{
display:flex;
flex-wrap:wrap;
gap:20px;
}

.tarjeta{
background:white;
width:400px;
padding:20px;
border-radius:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.tarjeta h3{
border-bottom:2px solid #eee;
padding-bottom:5px;
}

.tarjeta p{
margin:5px 0;
}

.boton{
display:inline-block;
margin-top:15px;
background:#007bff;
color:white;
padding:10px 15px;
border-radius:5px;
text-decoration:none;
}

</style>

</head>

<body>

<h2 class="titulo">Consultas del Hijo</h2>

<div class="contenedor">

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<div class="tarjeta">

<h3>Datos del Menor</h3>

<p><b>Nombre:</b> <?php echo $fila['menor_nombres']; ?></p>

<p><b>Documento:</b>
<?php echo $fila['menor_tipo_doc']." ".$fila['menor_num_doc']; ?>
</p>

<p><b>Fecha Nacimiento:</b> <?php echo $fila['fecha_nacimiento']; ?></p>

<p><b>Sexo:</b> <?php echo $fila['sexo']; ?></p>

<p><b>EPS:</b> <?php echo $fila['eps']; ?></p>


<h3>Fundación</h3>

<p><b>Nombre:</b> <?php echo $fila['fundacion']; ?></p>

<p><b>NIT:</b> <?php echo $fila['nit']; ?></p>

<p><b>Dirección:</b> <?php echo $fila['direccion']; ?></p>

<p><b>Teléfono:</b> <?php echo $fila['telefono_director']; ?></p>

<p><b>Email:</b> <?php echo $fila['correo_director']; ?></p>

<button onclick="window.print()" class="boton">
Imprimir
</button>

</div>

<?php } ?>

</div>

</body>
</html>