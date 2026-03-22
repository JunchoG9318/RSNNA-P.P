<?php
session_start();
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");

require_once("../../../config/conexion.php");

// ============================================
// VALIDAR MÉTODO POST
// ============================================
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

// ============================================
// RECIBIR Y SANITIZAR DATOS
// ============================================
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($correo) || empty($password)) {
    header("Location: login.php?error=1");
    exit();
}

// ============================================
// CONSULTA SEGURA CON PREPARED STATEMENT
// ============================================
$stmt = $conexion->prepare("SELECT 
                                id, 
                                correo, 
                                password, 
                                tipo_usuario, 
                                nombre_completo, 
                                estado, 
                                id_fundacion 
                            FROM usuarios 
                            WHERE correo = ? 
                            LIMIT 1");

if (!$stmt) {
    error_log("Error en prepare: " . $conexion->error);
    header("Location: login.php?error=3");
    exit();
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

// ============================================
// VERIFICAR SI EXISTE EL USUARIO
// ============================================
if ($result->num_rows == 0) {
    $stmt->close();
    header("Location: login.php?error=1");
    exit();
}

$usuario = $result->fetch_assoc();
$stmt->close();

// ============================================
// VERIFICAR SI EL USUARIO ESTÁ ACTIVO
// ============================================
if ($usuario['estado'] != 1) {
    header("Location: login.php?error=2");
    exit();
}

// ============================================
// VERIFICAR CONTRASEÑA
// ============================================
if (!password_verify($password, $usuario['password'])) {
    header("Location: login.php?error=1");
    exit();
}

// ============================================
// GUARDAR DATOS EN SESIÓN (COMBINANDO AMBOS FORMATOS)
// ============================================
// Formato del primer código (para compatibilidad)
$_SESSION['id_usuario'] = $usuario['id'];
$_SESSION['usuario'] = $usuario['correo'];
$_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

// Formato del segundo código (más descriptivo)
$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_correo'] = $usuario['correo'];
$_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
$_SESSION['usuario_tipo'] = $usuario['tipo_usuario'];

// Guardar id_fundacion (MUY IMPORTANTE - línea adaptada del primer código)
$_SESSION['id_fundacion'] = $usuario['id_fundacion'] ?? null;
$_SESSION['id'] = $usuario['id']; // Para compatibilidad adicional

// ============================================
// ACTUALIZAR ÚLTIMO ACCESO
// ============================================
$updateStmt = $conexion->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
if ($updateStmt) {
    $updateStmt->bind_param("i", $usuario['id']);
    $updateStmt->execute();
    $updateStmt->close();
}

// ============================================
// REDIRECCIONAR SEGÚN TIPO DE USUARIO
// ============================================
switch ($usuario['tipo_usuario']) {
    case 'icbf':
        header("Location: " . BASE_URL . "views/modules/ICBF/panel_icbf.php");
        break;
        
    case 'fundacion':
        header("Location: " . BASE_URL . "views/modules/fundaciones/panel_fundacion.php");
        break;
        
    case 'familia':
        header("Location: " . BASE_URL . "views/modules/Familias/panel_familia.php");
        break;
        
    default:
        header("Location: " . BASE_URL . "views/modules/Navegacion/dashboard.php");
}

exit();
?>