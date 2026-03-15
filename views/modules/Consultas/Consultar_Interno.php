<?php
// Consultar Interno.php - Versión corregida
session_start();

// Incluir archivos necesarios
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../config/conexion.php';

// Verificar conexión
if (!isset($conexion) || $conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si se ha enviado un ID para consultar
$id_interno = isset($_GET['id']) ? intval($_GET['id']) : 0;
$interno = null;
$error = '';

// Buscar el interno
if ($id_interno > 0) {

    $query = "SELECT i.*, 
                     f.nombre AS nombre_fundacion,
                     f.direccion AS direccion_fundacion,
                     f.telefono AS telefono_fundacion,
                     f.correo AS correo_fundacion,
                     f.representante_legal AS representante_fundacion,
                     TIMESTAMPDIFF(YEAR, i.fecha_nacimiento, CURDATE()) AS edad
              FROM internos i
              LEFT JOIN fundaciones f ON i.id_fundacion = f.id
              WHERE i.id = ?";

    $stmt = $conexion->prepare($query);

    if ($stmt) {

        $stmt->bind_param("i", $id_interno);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $interno = $resultado->fetch_assoc();
        } else {
            $error = "No se encontró el interno con ID: " . $id_interno;
        }

        $stmt->close();

    } else {
        $error = "Error en la consulta: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consulta de Interno - RSNNA</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

@media print {

.no-print{
display:none!important;
}

.print-only{
display:block!important;
}

body{
background:white;
font-size:12pt;
}

.card{
border:1px solid #000!important;
box-shadow:none!important;
}

.bg-success{
background:#333!important;
color:white!important;
print-color-adjust:exact;
}

.text-success{
color:#000!important;
}

}

.print-only{
display:none;
}

.info-label{
font-weight:bold;
color:#006341;
}

.info-value{
margin-bottom:10px;
padding:5px;
border-bottom:1px dashed #ddd;
}

</style>

</head>

<body class="bg-light">

<div class="container py-4">

<div class="row mb-4 no-print">

<div class="col-12">

<div class="card shadow-sm">

<div class="card-body">

<h5 class="card-title text-success">

<i class="bi bi-search"></i> Consultar Interno

</h5>

<form method="GET" class="row g-3">

<div class="col-md-8">

<label class="form-label">ID del Interno</label>

<input
type="number"
class="form-control"
name="id"
value="<?php echo htmlspecialchars($id_interno); ?>"
placeholder="Ingrese el ID"
required
>

</div>

<div class="col-md-4 d-flex align-items-end">

<button class="btn btn-success me-2">

<i class="bi bi-search"></i> Consultar

</button>

<?php if($interno){ ?>

<button
type="button"
class="btn btn-outline-success"
onclick="window.print()">

<i class="bi bi-printer"></i> Imprimir

</button>

<?php } ?>

</div>

</form>

<?php if($error){ ?>

<div class="alert alert-danger mt-3">

<i class="bi bi-exclamation-triangle"></i>
<?php echo htmlspecialchars($error); ?>

</div>

<?php } ?>

<div class="mt-3">

<a
href="<?php echo BASE_URL; ?>views/modules/Consultas/"
class="btn btn-outline-secondary btn-sm">

<i class="bi bi-arrow-left"></i> Volver

</a>

</div>

</div>

</div>

</div>

</div>

<?php if($interno){ ?>

<div class="row justify-content-center">

<div class="col-lg-10">

<div class="card shadow-lg border-0">

<div class="bg-success text-white py-3 px-4 no-print">

<div class="d-flex align-items-center">

<i class="bi bi-person-badge fs-1 me-3"></i>

<div>

<h4 class="mb-0">Información del Interno</h4>

<small>ID: <?php echo htmlspecialchars($interno['id']); ?></small>

</div>

</div>

</div>

<div class="card-body p-4">

<div class="text-center mb-4">

<h2 class="text-success fw-bold">INFORME DE INTERNO</h2>

<p class="text-muted">Datos personales</p>

</div>

<div class="row">

<div class="col-md-6">

<div class="info-label">Nombre completo</div>

<div class="info-value">

<?php echo htmlspecialchars($interno['menor_nombres'] ?? ''); ?>

</div>

</div>

<div class="col-md-3">

<div class="info-label">Documento</div>

<div class="info-value">

<?php
echo htmlspecialchars(($interno['menor_tipo_doc'] ?? '') . " " . ($interno['menor_num_doc'] ?? ''));
?>

</div>

</div>

<div class="col-md-3">

<div class="info-label">Edad</div>

<div class="info-value">

<?php echo intval($interno['edad'] ?? 0); ?> años

</div>

</div>

<div class="col-md-6">

<div class="info-label">Fundación</div>

<div class="info-value">

<?php echo htmlspecialchars($interno['nombre_fundacion'] ?? ''); ?>

</div>

</div>

<div class="col-md-6">

<div class="info-label">Teléfono Fundación</div>

<div class="info-value">

<?php echo htmlspecialchars($interno['telefono_fundacion'] ?? ''); ?>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded",function(){

document.querySelector("input[name='id']").focus();

});

</script>

</body>

</html>

<?php
if(isset($conexion)){
$conexion->close();
}
?>