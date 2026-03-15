<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['id_fundacion'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

require_once("../../../config/conexion.php");
include("../../../header.php");

/* OBTENER FUNDACION LOGEADA */

$id_fundacion = $_SESSION['id_fundacion'];

$sql = "SELECT * FROM fundaciones WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_fundacion);
$stmt->execute();
$resultado = $stmt->get_result();

$fundacion = $resultado->fetch_assoc();

if (!$fundacion) {
    echo "<div class='alert alert-danger'>Fundación no encontrada</div>";
    exit();
}
?>

<div class="container-fluid py-4">
<div class="row justify-content-center">
<div class="col-12 col-md-10 col-lg-8 col-xl-7">

<div class="card shadow-lg border-0 rounded-4 overflow-hidden">

<div class="card-header bg-success text-white text-center py-4 border-0">
<h4 class="fw-bold mb-0">
<i class="bi bi-building me-2"></i>Información de la Fundación
</h4>
</div>

<div class="card-body p-4">

<form action="actualizar_fundacion.php" method="POST">

<input type="hidden" name="id" value="<?php echo $fundacion['id']; ?>">

<h5 class="text-success border-start border-3 border-success ps-3 py-1 mb-4">
<i class="bi bi-info-circle me-2"></i>Datos Generales
</h5>

<!-- Nombre -->

<div class="mb-4">
<label class="form-label fw-semibold">Nombre de la Fundación</label>
<input type="text" name="nombre" class="form-control campo"
value="<?php echo $fundacion['nombre']; ?>" readonly>
</div>

<!-- NIT -->

<div class="mb-4">
<label class="form-label fw-semibold">NIT</label>
<input type="text" name="nit" class="form-control campo"
value="<?php echo $fundacion['nit']; ?>" readonly>
</div>

<!-- Fecha -->

<div class="mb-4">
<label class="form-label fw-semibold">Fecha de Constitución</label>
<input type="date" name="fecha_constitucion" class="form-control campo"
value="<?php echo $fundacion['fecha_constitucion']; ?>" readonly>
</div>

<!-- Tipo -->

<div class="mb-4">
<label class="form-label fw-semibold">Tipo de Fundación</label>
<input type="text" name="tipo" class="form-control campo"
value="<?php echo $fundacion['tipo']; ?>" readonly>
</div>

<h5 class="text-success border-start border-3 border-success ps-3 py-1 mb-4 mt-5">
<i class="bi bi-person-badge me-2"></i>Datos del Director
</h5>

<!-- Director -->

<div class="mb-4">
<label class="form-label fw-semibold">Nombre del Director</label>
<input type="text" name="nombre_director" class="form-control campo"
value="<?php echo $fundacion['nombre_director']; ?>" readonly>
</div>

<!-- Correo -->

<div class="mb-4">
<label class="form-label fw-semibold">Correo del Director</label>
<input type="email" name="correo_director" class="form-control campo"
value="<?php echo $fundacion['correo_director']; ?>" readonly>
</div>

<!-- Teléfono -->

<div class="mb-4">
<label class="form-label fw-semibold">Teléfono</label>
<input type="text" name="telefono_director" class="form-control campo"
value="<?php echo $fundacion['telefono_director']; ?>" readonly>
</div>

<!-- BOTONES -->

<div class="text-center mt-4">

<button type="button" id="editarBtn"
class="btn btn-warning px-4 py-2 rounded-pill me-2">
<i class="bi bi-pencil-square me-2"></i>Editar información
</button>

<button type="submit" id="guardarBtn"
class="btn btn-success px-4 py-2 rounded-pill d-none">
<i class="bi bi-save me-2"></i>Guardar cambios
</button>

<a href="<?php echo BASE_URL; ?>inicio.php"
class="btn btn-outline-danger px-4 py-2 rounded-pill">
<i class="bi bi-arrow-left me-2"></i>Volver
</a>

</div>

</form>

</div>

</div>

</div>
</div>
</div>

<script>

document.getElementById("editarBtn").addEventListener("click", function(){

let campos = document.querySelectorAll(".campo");

campos.forEach(function(campo){
campo.removeAttribute("readonly");
});

document.getElementById("guardarBtn").classList.remove("d-none");

});

</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>