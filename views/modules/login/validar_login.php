<?php

session_start();
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");

require_once("../../../config/conexion.php");

/* VALIDAR METODO */

if($_SERVER["REQUEST_METHOD"] != "POST"){
header("Location: login.php");
exit();
}

/* RECIBIR DATOS */

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if(empty($correo) || empty($password)){
header("Location: login.php?error=1");
exit();
}

/* CONSULTA */

$stmt = $conexion->prepare("
SELECT 
id,
correo,
password,
tipo_usuario,
nombre_completo,
estado,
id_fundacion
FROM usuarios
WHERE correo = ?
");

$stmt->bind_param("s",$correo);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
header("Location: login.php?error=1");
exit();
}

$usuario = $result->fetch_assoc();

/* USUARIO INACTIVO */

if($usuario['estado'] != 1){
header("Location: login.php?error=2");
exit();
}

/* VERIFICAR PASSWORD */

if(!password_verify($password,$usuario['password'])){
header("Location: login.php?error=1");
exit();
}

/* GUARDAR SESION */

$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_correo'] = $usuario['correo'];
$_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
$_SESSION['usuario_tipo'] = $usuario['tipo_usuario'];

/* FUNDACION (IMPORTANTE) */

$_SESSION['id_fundacion'] = $usuario['id_fundacion'] ?? null;

/* ACTUALIZAR ULTIMO ACCESO */

$conexion->query("
UPDATE usuarios 
SET ultimo_acceso = NOW()
WHERE id = ".$usuario['id']);

/* REDIRECCION */

switch($usuario['tipo_usuario']){

case 'icbf':

header("Location: ".BASE_URL."views/modules/ICBF/panel_icbf.php");
break;

case 'fundacion':

header("Location: ".BASE_URL."views/modules/fundaciones/panel_fundacion.php");
break;

case 'familia':

header("Location: ".BASE_URL."views/modules/Familias/panel_familia.php");
break;

default:

header("Location: ".BASE_URL."views/modules/Navegacion/dashboard.php");

}

exit();

?>