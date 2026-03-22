<?php
session_start();
require_once("../../../config/conexion.php");
 
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
 
// ============================================
// VERIFICAR SESIÓN
// ============================================
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}
 
// ============================================
// VERIFICAR MÉTODO POST
// ============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registro_familiar.php");
    exit();
}
 
// ============================================
// RECIBIR DATOS DEL FORMULARIO
// ============================================
$id_usuario = $_SESSION['usuario_id'];
 
$nombre              = isset($_POST['nombre'])           ? trim($_POST['nombre'])           : '';
$apellidos           = isset($_POST['apellidos'])        ? trim($_POST['apellidos'])        : '';
$tipo_documento      = isset($_POST['tipo_documento'])   ? trim($_POST['tipo_documento'])   : '';
$numero_documento    = isset($_POST['numero_documento']) ? trim($_POST['numero_documento']) : '';
$fecha_nacimiento    = isset($_POST['fecha_nacimiento'])  && !empty($_POST['fecha_nacimiento'])  ? $_POST['fecha_nacimiento']  : null;
$fecha_expedicion    = isset($_POST['fecha_expedicion'])  && !empty($_POST['fecha_expedicion'])  ? $_POST['fecha_expedicion']  : null;
$parentesco          = isset($_POST['parentesco'])       ? trim($_POST['parentesco'])       : '';
$nacionalidad        = isset($_POST['nacionalidad'])     ? trim($_POST['nacionalidad'])     : 'Colombia';
 
$direccion_actual    = isset($_POST['direccion_actual'])   ? trim($_POST['direccion_actual'])   : '';
$departamento        = isset($_POST['departamento'])       ? trim($_POST['departamento'])       : '';
$ciudad              = isset($_POST['ciudad'])             ? trim($_POST['ciudad'])             : '';
$telefono_celular    = isset($_POST['telefono_celular'])   ? trim($_POST['telefono_celular'])   : '';
$telefono_fijo       = isset($_POST['telefono_fijo'])      ? trim($_POST['telefono_fijo'])      : '';
$genero              = isset($_POST['genero'])             ? trim($_POST['genero'])             : '';
$ocupacion           = isset($_POST['ocupacion'])          ? trim($_POST['ocupacion'])          : '';
$correo_electronico  = isset($_POST['correo_electronico']) ? trim($_POST['correo_electronico']) : '';
 
$empresa_laboral     = isset($_POST['empresa_laboral'])   ? trim($_POST['empresa_laboral'])   : '';
$cargo_laboral       = isset($_POST['cargo_laboral'])     ? trim($_POST['cargo_laboral'])     : '';
$telefono_laboral    = isset($_POST['telefono_laboral'])  ? trim($_POST['telefono_laboral'])  : '';
$direccion_laboral   = isset($_POST['direccion_laboral']) ? trim($_POST['direccion_laboral']) : '';
 
$interno_nombre           = isset($_POST['interno_nombre'])           ? trim($_POST['interno_nombre'])           : '';
$interno_parentesco       = isset($_POST['interno_parentesco'])       ? trim($_POST['interno_parentesco'])       : '';
$interno_tipo_documento   = isset($_POST['interno_tipo_documento'])   ? trim($_POST['interno_tipo_documento'])   : '';
$interno_numero_documento = isset($_POST['interno_numero_documento']) ? trim($_POST['interno_numero_documento']) : '';
$interno_fecha_nacimiento = isset($_POST['interno_fecha_nacimiento']) && !empty($_POST['interno_fecha_nacimiento']) ? $_POST['interno_fecha_nacimiento'] : null;
 
$acepta_terminos = isset($_POST['termsCheck']) ? 1 : 0;
 
// ============================================
// VALIDAR CAMPOS OBLIGATORIOS
// ============================================
$errores = [];
 
if (empty($nombre))           $errores[] = "El nombre es obligatorio.";
if (empty($apellidos))        $errores[] = "Los apellidos son obligatorios.";
if (empty($numero_documento)) $errores[] = "El número de documento es obligatorio.";
if (empty($fecha_nacimiento)) $errores[] = "La fecha de nacimiento es obligatoria.";
if (empty($telefono_celular)) $errores[] = "El teléfono celular es obligatorio.";
if ($acepta_terminos != 1)    $errores[] = "Debe aceptar los términos y condiciones.";
 
if (!empty($correo_electronico) && !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no tiene un formato válido.";
}
 
if (!empty($errores)) {
    mostrarError("<strong>Por favor corrija los siguientes campos:</strong><ul style='margin-top:8px'>" .
        implode('', array_map(fn($e) => "<li>$e</li>", $errores)) . "</ul>");
}
 
// ============================================
// PROCESAR ARCHIVOS SUBIDOS
// ============================================
$ruta_doc_familiar = null;
$ruta_doc_interno  = null;
$tipos_permitidos  = ['pdf', 'jpg', 'jpeg', 'png'];
 
$upload_dir = "../../../uploads/documentos_familiares/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}
 
if (isset($_FILES['doc_familiar']) && $_FILES['doc_familiar']['error'] === UPLOAD_ERR_OK) {
    $extension = strtolower(pathinfo($_FILES['doc_familiar']['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $tipos_permitidos)) {
        mostrarError("Tipo de archivo no permitido para el documento del familiar. Use PDF, JPG o PNG.");
    }
    if ($_FILES['doc_familiar']['size'] > 5 * 1024 * 1024) {
        mostrarError("El documento del familiar supera el tamaño máximo de 5 MB.");
    }
    $nombre_archivo = "familiar_" . time() . "_" . preg_replace('/[^a-zA-Z0-9]/', '', $numero_documento) . "." . $extension;
    if (move_uploaded_file($_FILES['doc_familiar']['tmp_name'], $upload_dir . $nombre_archivo)) {
        $ruta_doc_familiar = "uploads/documentos_familiares/" . $nombre_archivo;
    }
}
 
if (isset($_FILES['doc_interno']) && $_FILES['doc_interno']['error'] === UPLOAD_ERR_OK) {
    $extension = strtolower(pathinfo($_FILES['doc_interno']['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $tipos_permitidos)) {
        mostrarError("Tipo de archivo no permitido para el documento del interno. Use PDF, JPG o PNG.");
    }
    if ($_FILES['doc_interno']['size'] > 5 * 1024 * 1024) {
        mostrarError("El documento del interno supera el tamaño máximo de 5 MB.");
    }
    $nombre_archivo = "interno_" . time() . "_" . preg_replace('/[^a-zA-Z0-9]/', '', $numero_documento) . "." . $extension;
    if (move_uploaded_file($_FILES['doc_interno']['tmp_name'], $upload_dir . $nombre_archivo)) {
        $ruta_doc_interno = "uploads/documentos_familiares/" . $nombre_archivo;
    }
}
 
// ============================================
// INSERTAR EN LA BASE DE DATOS
// ============================================
$sql = "INSERT INTO registro_familiar (
    id_usuario, nombre, apellidos, tipo_documento, numero_documento,
    fecha_nacimiento, fecha_expedicion, parentesco, nacionalidad,
    direccion_actual, departamento, ciudad, telefono_celular, telefono_fijo,
    genero, ocupacion, correo_electronico, empresa_laboral, cargo_laboral,
    telefono_laboral, direccion_laboral, interno_nombre, interno_parentesco,
    interno_tipo_documento, interno_numero_documento, interno_fecha_nacimiento,
    doc_familiar, doc_interno, acepta_terminos
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 
$stmt = $conexion->prepare($sql);
 
if (!$stmt) {
    mostrarError("Error al preparar la consulta: " . htmlspecialchars($conexion->error));
}
 
$stmt->bind_param(
    "isssssssssssssssssssssssssssi",
    $id_usuario,
    $nombre, $apellidos, $tipo_documento, $numero_documento,
    $fecha_nacimiento, $fecha_expedicion, $parentesco, $nacionalidad,
    $direccion_actual, $departamento, $ciudad, $telefono_celular, $telefono_fijo,
    $genero, $ocupacion, $correo_electronico,
    $empresa_laboral, $cargo_laboral, $telefono_laboral, $direccion_laboral,
    $interno_nombre, $interno_parentesco,
    $interno_tipo_documento, $interno_numero_documento, $interno_fecha_nacimiento,
    $ruta_doc_familiar, $ruta_doc_interno,
    $acepta_terminos
);
 
try {
    $stmt->execute();
    $id_registro = $stmt->insert_id;
    $stmt->close();
    $conexion->close();
    header("Location: ver_registro_familiar.php?id=" . $id_registro . "&success=1");
    exit();
 
} catch (mysqli_sql_exception $e) {
    $stmt->close();
    $conexion->close();
 
    // Código 1062 = Duplicate entry
    if ($e->getCode() === 1062) {
        mostrarError(
            "El número de documento <strong>" . htmlspecialchars($numero_documento) . "</strong> ya está registrado en el sistema.<br><br>" .
            "Si necesita actualizar la información de este familiar, comuníquese con un administrador."
        );
    }
 
    // Cualquier otro error de BD
    mostrarError("No se pudo guardar el registro. Por favor intente de nuevo.<br><small style='color:#999'>Detalle técnico: " . htmlspecialchars($e->getMessage()) . "</small>");
}
 
// ============================================
// FUNCIÓN HELPER: MOSTRAR ERROR CON ESTILO
// ============================================
function mostrarError(string $mensaje): void {
    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error en el registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="card shadow-sm border-0 rounded-3" style="max-width:540px;width:100%">
        <div class="card-header bg-danger text-white py-3">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Error en el registro</h5>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-danger border-0 mb-3">' . $mensaje . '</div>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver al formulario
            </a>
        </div>
    </div>
</body>
</html>';
    exit();
}
?>