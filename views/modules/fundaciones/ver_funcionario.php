<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();
include("../../../header.php");
require_once("../../../config/conexion.php");

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT * FROM funcionarios WHERE id = $id";
$result = $conexion->query($sql);
$funcionario = $result->fetch_assoc();
?>

<div class="container py-4">
    <h2>Detalles del Funcionario</h2>
    <pre><?php print_r($funcionario); ?></pre>
    <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
</div>

<?php include("../../../footer.php"); ?>