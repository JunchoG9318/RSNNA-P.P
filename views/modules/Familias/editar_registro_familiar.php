<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

require_once("../../../config/conexion.php");

$usuario_nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
$usuario_tipo   = $_SESSION['usuario_tipo']   ?? '';
$id_usuario     = $_SESSION['usuario_id'];

// Verificar ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: listar_registros_familiar.php");
    exit();
}

// Obtener registro (solo del usuario logueado)
$stmt = $conexion->prepare("SELECT * FROM registro_familiar WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: listar_registros_familiar.php");
    exit();
}
$r = $result->fetch_assoc();
$stmt->close();

// ============================================
// PROCESAR POST — ANTES DE CUALQUIER HTML
// ============================================
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre              = trim($_POST['nombre']            ?? '');
    $apellidos           = trim($_POST['apellidos']         ?? '');
    $tipo_documento      = trim($_POST['tipo_documento']    ?? '');
    $numero_documento    = trim($_POST['numero_documento']  ?? '');
    $fecha_nacimiento    = !empty($_POST['fecha_nacimiento'])  ? $_POST['fecha_nacimiento']  : null;
    $fecha_expedicion    = !empty($_POST['fecha_expedicion'])  ? $_POST['fecha_expedicion']  : null;
    $parentesco          = trim($_POST['parentesco']        ?? '');
    $nacionalidad        = trim($_POST['nacionalidad']      ?? 'Colombia');
    $direccion_actual    = trim($_POST['direccion_actual']   ?? '');
    $departamento        = trim($_POST['departamento']       ?? '');
    $ciudad              = trim($_POST['ciudad']             ?? '');
    $telefono_celular    = trim($_POST['telefono_celular']   ?? '');
    $telefono_fijo       = trim($_POST['telefono_fijo']      ?? '');
    $genero              = trim($_POST['genero']             ?? '');
    $ocupacion           = trim($_POST['ocupacion']          ?? '');
    $correo_electronico  = trim($_POST['correo_electronico'] ?? '');
    $empresa_laboral     = trim($_POST['empresa_laboral']   ?? '');
    $cargo_laboral       = trim($_POST['cargo_laboral']     ?? '');
    $telefono_laboral    = trim($_POST['telefono_laboral']  ?? '');
    $direccion_laboral   = trim($_POST['direccion_laboral'] ?? '');
    $interno_nombre           = trim($_POST['interno_nombre']           ?? '');
    $interno_parentesco       = trim($_POST['interno_parentesco']       ?? '');
    $interno_tipo_documento   = trim($_POST['interno_tipo_documento']   ?? '');
    $interno_numero_documento = trim($_POST['interno_numero_documento'] ?? '');
    $interno_fecha_nacimiento = !empty($_POST['interno_fecha_nacimiento']) ? $_POST['interno_fecha_nacimiento'] : null;

    // Validaciones
    if (empty($nombre))           $errores[] = "El nombre es obligatorio.";
    if (empty($apellidos))        $errores[] = "Los apellidos son obligatorios.";
    if (empty($numero_documento)) $errores[] = "El número de documento es obligatorio.";
    if (empty($fecha_nacimiento)) $errores[] = "La fecha de nacimiento es obligatoria.";
    if (empty($telefono_celular)) $errores[] = "El teléfono celular es obligatorio.";
    if (!empty($correo_electronico) && !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no tiene un formato válido.";
    }

    // // Verificar duplicado excluyendo el registro actual
    // $chk = $conexion->prepare("SELECT id FROM registro_familiar WHERE numero_documento = ? AND id != ?");
    // $chk->bind_param("si", $numero_documento, $id);
    // $chk->execute();
    // $chk->store_result();
    // if ($chk->num_rows > 0) {
    //     $errores[] = "El número de documento ya pertenece a otro registro.";
    // }
    // $chk->close();

    // Archivos
    $ruta_doc_familiar = $r['doc_familiar'];
    $ruta_doc_interno  = $r['doc_interno'];
    $tipos_permitidos  = ['pdf', 'jpg', 'jpeg', 'png'];
    $upload_dir        = "../../../uploads/documentos_familiares/";
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0755, true);

    if (isset($_FILES['doc_familiar']) && $_FILES['doc_familiar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['doc_familiar']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $tipos_permitidos))            $errores[] = "Tipo de archivo no permitido para documento del familiar.";
        elseif ($_FILES['doc_familiar']['size'] > 5242880) $errores[] = "El documento del familiar supera 5 MB.";
        else {
            $nf = "familiar_" . time() . "_" . preg_replace('/[^a-zA-Z0-9]/', '', $numero_documento) . "." . $ext;
            if (move_uploaded_file($_FILES['doc_familiar']['tmp_name'], $upload_dir . $nf))
                $ruta_doc_familiar = "uploads/documentos_familiares/" . $nf;
        }
    }

    if (isset($_FILES['doc_interno']) && $_FILES['doc_interno']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['doc_interno']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $tipos_permitidos))            $errores[] = "Tipo de archivo no permitido para documento del interno.";
        elseif ($_FILES['doc_interno']['size'] > 5242880)  $errores[] = "El documento del interno supera 5 MB.";
        else {
            $nf = "interno_" . time() . "_" . preg_replace('/[^a-zA-Z0-9]/', '', $numero_documento) . "." . $ext;
            if (move_uploaded_file($_FILES['doc_interno']['tmp_name'], $upload_dir . $nf))
                $ruta_doc_interno = "uploads/documentos_familiares/" . $nf;
        }
    }

    // Guardar si no hay errores
    if (empty($errores)) {
        $sql_upd = "UPDATE registro_familiar SET
            nombre=?, apellidos=?, tipo_documento=?, numero_documento=?,
            fecha_nacimiento=?, fecha_expedicion=?, parentesco=?, nacionalidad=?,
            direccion_actual=?, departamento=?, ciudad=?, telefono_celular=?, telefono_fijo=?,
            genero=?, ocupacion=?, correo_electronico=?,
            empresa_laboral=?, cargo_laboral=?, telefono_laboral=?, direccion_laboral=?,
            interno_nombre=?, interno_parentesco=?, interno_tipo_documento=?,
            interno_numero_documento=?, interno_fecha_nacimiento=?,
            doc_familiar=?, doc_interno=?
            WHERE id=? AND id_usuario=?";

        $upd = $conexion->prepare($sql_upd);
        if ($upd) {
            $upd->bind_param(
                "sssssssssssssssssssssssssssii",
                $nombre, $apellidos, $tipo_documento, $numero_documento,
                $fecha_nacimiento, $fecha_expedicion, $parentesco, $nacionalidad,
                $direccion_actual, $departamento, $ciudad, $telefono_celular, $telefono_fijo,
                $genero, $ocupacion, $correo_electronico,
                $empresa_laboral, $cargo_laboral, $telefono_laboral, $direccion_laboral,
                $interno_nombre, $interno_parentesco, $interno_tipo_documento,
                $interno_numero_documento, $interno_fecha_nacimiento,
                $ruta_doc_familiar, $ruta_doc_interno,
                $id, $id_usuario
            );
            try {
                $upd->execute();
                $upd->close();
                $conexion->close();
                // ✅ header() ANTES de cualquier HTML — aquí sí funciona
                header("Location: listado_registros_familiares.php?success=1");
                exit();
            } catch (mysqli_sql_exception $e) {
                $upd->close();
                $errores[] = $e->getCode() === 1062
                    ? "El número de documento ya está registrado en otro familiar."
                    : "Error al guardar: " . htmlspecialchars($e->getMessage());
            }
        } else {
            $errores[] = "Error al preparar la consulta: " . $conexion->error;
        }
    }

    // Repoblar $r con los datos del POST para que el formulario no pierda lo escrito
    $r = array_merge($r, compact(
        'nombre','apellidos','tipo_documento','numero_documento',
        'fecha_nacimiento','fecha_expedicion','parentesco','nacionalidad',
        'direccion_actual','departamento','ciudad','telefono_celular','telefono_fijo',
        'genero','ocupacion','correo_electronico',
        'empresa_laboral','cargo_laboral','telefono_laboral','direccion_laboral',
        'interno_nombre','interno_parentesco','interno_tipo_documento',
        'interno_numero_documento','interno_fecha_nacimiento'
    ));
}

// ============================================
// RECIÉN AQUÍ incluimos el header (HTML)
// ============================================
switch ($usuario_tipo) {
    case 'icbf':      $rol_texto = 'Funcionario ICBF';   $icono_rol = 'bi-building';    break;
    case 'fundacion': $rol_texto = 'Fundación';           $icono_rol = 'bi-tree';        break;
    case 'familia':   $rol_texto = 'Familia / Acudiente'; $icono_rol = 'bi-people-fill'; break;
    default:          $rol_texto = 'Usuario';             $icono_rol = 'bi-person';
}

include("../../../header.php");

// Helpers
function sel($val, $comp) { return $val == $comp ? 'selected' : ''; }
function val($r, $k)      { return htmlspecialchars($r[$k] ?? ''); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Familiar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background-color:#f8f9fa;">
<div class="container-fluid p-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4"
         style="background-color:#006341;color:white;padding:15px;border-radius:10px;">
        <div>
            <h2 class="fw-bold mb-1" style="color:white;">
                <i class="bi bi-pencil-square me-2"></i>Editar Familiar
            </h2>
            <p class="mb-0" style="color:rgba(255,255,255,.9);">
                <strong><?php echo htmlspecialchars($usuario_nombre); ?></strong>
                <span class="badge bg-white text-success ms-2">
                    <i class="bi <?php echo $icono_rol; ?> me-1"></i><?php echo $rol_texto; ?>
                </span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-white text-success px-3 py-2">
                <i class="bi bi-calendar me-1"></i><?php echo date('d/m/Y'); ?>
            </span>
            <a href="listado_registros_familiares.php" class="btn btn-light">
                <i class="bi bi-arrow-left me-1"></i>Volver al listado
            </a>
        </div>
    </div>

    <!-- ERRORES -->
    <?php if (!empty($errores)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Corrija los siguientes errores:</strong>
        <ul class="mb-0 mt-1">
            <?php foreach ($errores as $e): ?>
            <li><?php echo $e; ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white py-3">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                    <i class="bi bi-person-badge fs-4 text-white"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">EDITAR REGISTRO DE FAMILIAR</h4>
                    <small class="opacity-75">ID #<?php echo $id; ?> — Modifique los campos y guarde los cambios</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form class="needs-validation" novalidate method="POST"
                  action="editar_registro_familiar.php?id=<?php echo $id; ?>"
                  enctype="multipart/form-data">

                <!-- SECCIÓN 1: DATOS BÁSICOS -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="text-success fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>DATOS BÁSICOS</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person text-success me-1"></i>NOMBRE <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo val($r,'nombre'); ?>" required>
                            <div class="invalid-feedback">Por favor ingrese el nombre</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person text-success me-1"></i>APELLIDOS <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" class="form-control" value="<?php echo val($r,'apellidos'); ?>" required>
                            <div class="invalid-feedback">Por favor ingrese los apellidos</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-card-text text-success me-1"></i>TIPO DE DOCUMENTO</label>
                            <select class="form-select" name="tipo_documento">
                                <option disabled <?php echo empty($r['tipo_documento']) ? 'selected' : ''; ?>>Seleccione tipo</option>
                                <option value="CC"  <?php echo sel($r['tipo_documento'],'CC');  ?>>CC - Cédula Ciudadanía</option>
                                <option value="CE"  <?php echo sel($r['tipo_documento'],'CE');  ?>>CE - Cédula Extranjería</option>
                                <option value="PAS" <?php echo sel($r['tipo_documento'],'PAS'); ?>>PAS - Pasaporte</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-123 text-success me-1"></i>NÚMERO DE DOCUMENTO <span class="text-danger">*</span></label>
                            <input type="text" name="numero_documento" class="form-control" value="<?php echo val($r,'numero_documento'); ?>" required>
                            <div class="invalid-feedback">Por favor ingrese el número de documento</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-date text-success me-1"></i>FECHA DE NACIMIENTO <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo val($r,'fecha_nacimiento'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-check text-success me-1"></i>FECHA DE EXPEDICIÓN</label>
                            <input type="date" name="fecha_expedicion" class="form-control" value="<?php echo val($r,'fecha_expedicion'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-diagram-3 text-success me-1"></i>PARENTESCO</label>
                            <select class="form-select" name="parentesco">
                                <option disabled <?php echo empty($r['parentesco']) ? 'selected' : ''; ?>>Seleccione parentesco</option>
                                <?php foreach(['Madre','Padre','Tío/a','Abuelo/a','Hermano/a','Representante Legal'] as $p): ?>
                                <option value="<?php echo $p; ?>" <?php echo sel($r['parentesco'],$p); ?>><?php echo $p; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-flag text-success me-1"></i>NACIONALIDAD <span class="text-danger">*</span></label>
                            <select class="form-select" name="nacionalidad" required>
                                <option disabled>Seleccione país</option>
                                <?php
                                $paises = ['Afganistán','Albania','Alemania','Angola','Argentina','Armenia','Australia','Austria','Bolivia','Bosnia y Herzegovina','Brasil','Bulgaria','Canadá','Chile','China','Colombia','Costa Rica','Croacia','Cuba','Dinamarca','Ecuador','Egipto','El Salvador','España','Estados Unidos','Etiopía','Filipinas','Finlandia','Francia','Ghana','Grecia','Guatemala','Haití','Honduras','Hungría','India','Indonesia','Irak','Irán','Irlanda','Israel','Italia','Jamaica','Japón','Kenia','Marruecos','México','Nicaragua','Nigeria','Noruega','Nueva Zelanda','Países Bajos','Pakistán','Panamá','Paraguay','Perú','Polonia','Portugal','Reino Unido','República Dominicana','Rumanía','Rusia','Senegal','Sudáfrica','Suecia','Suiza','Tailandia','Tanzania','Turquía','Ucrania','Uruguay','Venezuela','Vietnam'];
                                foreach($paises as $pais): ?>
                                <option value="<?php echo $pais; ?>" <?php echo sel($r['nacionalidad'],$pais); ?>><?php echo $pais; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: UBICACIÓN Y CONTACTO -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="text-success fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>UBICACIÓN Y CONTACTO</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="bi bi-house-door text-success me-1"></i>DIRECCIÓN ACTUAL</label>
                            <input type="text" name="direccion_actual" class="form-control" value="<?php echo val($r,'direccion_actual'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-map text-success me-1"></i>DEPARTAMENTO</label>
                            <select class="form-select" name="departamento" id="departamento">
                                <option disabled <?php echo empty($r['departamento']) ? 'selected' : ''; ?>>Seleccione departamento</option>
                                <?php
                                $dptos = ['Amazonas','Antioquia','Arauca','Atlántico','Bolívar','Boyacá','Caldas','Caquetá','Casanare','Cauca','Cesar','Chocó','Córdoba','Cundinamarca','Guainía','Guaviare','Huila','La Guajira','Magdalena','Meta','Nariño','Norte de Santander','Putumayo','Quindío','Risaralda','San Andrés y Providencia','Santander','Sucre','Tolima','Valle del Cauca','Vaupés','Vichada'];
                                foreach($dptos as $d): ?>
                                <option value="<?php echo $d; ?>" <?php echo sel($r['departamento'],$d); ?>><?php echo $d; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-building text-success me-1"></i>CIUDAD</label>
                            <select class="form-select" name="ciudad" id="ciudad">
                                <option disabled>Seleccione ciudad</option>
                                <?php if (!empty($r['ciudad'])): ?>
                                <option value="<?php echo val($r,'ciudad'); ?>" selected><?php echo val($r,'ciudad'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-phone text-success me-1"></i>TELÉFONO CELULAR <span class="text-danger">*</span></label>
                            <input type="tel" name="telefono_celular" class="form-control" value="<?php echo val($r,'telefono_celular'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-telephone text-success me-1"></i>TELÉFONO FIJO</label>
                            <input type="tel" name="telefono_fijo" class="form-control" value="<?php echo val($r,'telefono_fijo'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-gender-ambiguous text-success me-1"></i>GÉNERO</label>
                            <select class="form-select" name="genero">
                                <option disabled <?php echo empty($r['genero']) ? 'selected' : ''; ?>>Seleccione género</option>
                                <?php foreach(['Femenino','Masculino','Otro'] as $g): ?>
                                <option value="<?php echo $g; ?>" <?php echo sel($r['genero'],$g); ?>><?php echo $g; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-briefcase text-success me-1"></i>OCUPACIÓN</label>
                            <input type="text" name="ocupacion" class="form-control" value="<?php echo val($r,'ocupacion'); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="bi bi-envelope text-success me-1"></i>CORREO ELECTRÓNICO</label>
                            <input type="email" name="correo_electronico" class="form-control" value="<?php echo val($r,'correo_electronico'); ?>">
                            <small class="text-muted">Opcional, para notificaciones</small>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: INFORMACIÓN LABORAL -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="text-success fw-bold mb-3"><i class="bi bi-briefcase me-2"></i>INFORMACIÓN LABORAL</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">EMPRESA / LUGAR DE TRABAJO</label>
                            <input type="text" name="empresa_laboral" class="form-control" value="<?php echo val($r,'empresa_laboral'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CARGO</label>
                            <input type="text" name="cargo_laboral" class="form-control" value="<?php echo val($r,'cargo_laboral'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">TELÉFONO LABORAL</label>
                            <input type="tel" name="telefono_laboral" class="form-control" value="<?php echo val($r,'telefono_laboral'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DIRECCIÓN LABORAL</label>
                            <input type="text" name="direccion_laboral" class="form-control" value="<?php echo val($r,'direccion_laboral'); ?>">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: INFORMACIÓN DEL INTERNO -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="text-success fw-bold mb-3"><i class="bi bi-people me-2"></i>INFORMACIÓN DEL INTERNO</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NOMBRE DEL INTERNO</label>
                            <input type="text" name="interno_nombre" class="form-control" value="<?php echo val($r,'interno_nombre'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">PARENTESCO</label>
                            <select class="form-select" name="interno_parentesco">
                                <option disabled <?php echo empty($r['interno_parentesco']) ? 'selected' : ''; ?>>Seleccione parentesco</option>
                                <?php foreach(['Hijo','Sobrino','Nieto','Representado','Hermano/a','Otro'] as $p): ?>
                                <option value="<?php echo $p; ?>" <?php echo sel($r['interno_parentesco'],$p); ?>><?php echo $p; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">TIPO DE DOCUMENTO</label>
                            <select class="form-select" name="interno_tipo_documento">
                                <option disabled <?php echo empty($r['interno_tipo_documento']) ? 'selected' : ''; ?>>Seleccione tipo</option>
                                <?php foreach(['TI'=>'TI - Tarjeta Identidad','RC'=>'RC - Registro Civil','CC'=>'CC - Cédula Ciudadanía','CE'=>'CE - Cédula Extranjería','PAS'=>'PAS - Pasaporte'] as $v=>$l): ?>
                                <option value="<?php echo $v; ?>" <?php echo sel($r['interno_tipo_documento'],$v); ?>><?php echo $l; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">NÚMERO DE DOCUMENTO</label>
                            <input type="text" name="interno_numero_documento" class="form-control" value="<?php echo val($r,'interno_numero_documento'); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">FECHA DE NACIMIENTO</label>
                            <input type="date" name="interno_fecha_nacimiento" class="form-control" value="<?php echo val($r,'interno_fecha_nacimiento'); ?>">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 5: DOCUMENTACIÓN -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="text-success fw-bold mb-3"><i class="bi bi-file-text me-2"></i>DOCUMENTACIÓN ADJUNTA</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DOCUMENTO DEL FAMILIAR</label>
                            <?php if (!empty($r['doc_familiar'])): ?>
                            <div class="mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-file-earmark-check me-1"></i>Archivo actual guardado
                                </span>
                            </div>
                            <?php endif; ?>
                            <input type="file" name="doc_familiar" class="form-control">
                            <small class="text-muted">Deje vacío para conservar el archivo actual. PDF, JPG o PNG, máx 5 MB.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DOCUMENTO DEL INTERNO</label>
                            <?php if (!empty($r['doc_interno'])): ?>
                            <div class="mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-file-earmark-check me-1"></i>Archivo actual guardado
                                </span>
                            </div>
                            <?php endif; ?>
                            <input type="file" name="doc_interno" class="form-control">
                            <small class="text-muted">Deje vacío para conservar el archivo actual. PDF, JPG o PNG, máx 5 MB.</small>
                        </div>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        <i class="bi bi-shield-check text-success me-1"></i>Datos protegidos - Ley 1581 de 2012
                    </div>
                    <div class="d-flex gap-2">
                        <a href="listado_registros_familiares.php" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-success px-4 py-2">
                            <i class="bi bi-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const ciudadesPorDepartamento = {
    'Amazonas':['Leticia','Puerto Nariño'],
    'Antioquia':['Medellín','Bello','Itagüí','Envigado','Rionegro','Apartadó','Turbo','Santa Fe de Antioquia','Caucasia','Carepa','Chigorodó','Yarumal','Marinilla','La Ceja','El Carmen de Viboral'],
    'Arauca':['Arauca','Tame','Saravena'],
    'Atlántico':['Barranquilla','Soledad','Malambo','Puerto Colombia','Sabanagrande','Sabanalarga','Galapa'],
    'Bolívar':['Cartagena','Magangué','Turbaco','El Carmen de Bolívar','Arjona'],
    'Boyacá':['Tunja','Duitama','Sogamoso','Chiquinquirá','Puerto Boyacá','Moniquirá'],
    'Caldas':['Manizales','Villamaría','Chinchiná','Riosucio','La Dorada'],
    'Caquetá':['Florencia','San Vicente del Caguán','Puerto Rico'],
    'Casanare':['Yopal','Aguazul','Villanueva'],
    'Cauca':['Popayán','Santander de Quilichao','Puerto Tejada','Piendamó','Silvia'],
    'Cesar':['Valledupar','Aguachica','Codazzi','La Paz'],
    'Chocó':['Quibdó','Istmina','Riosucio','Tadó'],
    'Córdoba':['Montería','Cereté','Lorica','Sahagún','Montelíbano'],
    'Cundinamarca':['Bogotá','Soacha','Zipaquirá','Facatativá','Chía','Cajicá','Girardot','Fusagasugá','Madrid','Mosquera'],
    'Guainía':['Inírida'],
    'Guaviare':['San José del Guaviare'],
    'Huila':['Neiva','Pitalito','Garzón','La Plata'],
    'La Guajira':['Riohacha','Maicao','Uribia','Manaure'],
    'Magdalena':['Santa Marta','Ciénaga','Fundación','El Banco','Plato'],
    'Meta':['Villavicencio','Acacías','Granada','Puerto López'],
    'Nariño':['Pasto','Tumaco','Ipiales','Tuquerres','La Unión'],
    'Norte de Santander':['Cúcuta','Ocaña','Pamplona','Villa del Rosario','Los Patios'],
    'Putumayo':['Mocoa','Puerto Asís','Orito'],
    'Quindío':['Armenia','Calarcá','Montenegro','Quimbaya'],
    'Risaralda':['Pereira','Dosquebradas','Santa Rosa de Cabal','La Virginia'],
    'San Andrés y Providencia':['San Andrés','Providencia'],
    'Santander':['Bucaramanga','Floridablanca','Girón','Piedecuesta','Barrancabermeja','San Gil','Socorro'],
    'Sucre':['Sincelejo','Corozal','San Marcos','Sampués'],
    'Tolima':['Ibagué','Espinal','Melgar','Líbano','Honda'],
    'Valle del Cauca':['Cali','Palmira','Buenaventura','Tuluá','Cartago','Buga','Yumbo','Jamundí','Candelaria','Florida'],
    'Vaupés':['Mitú'],
    'Vichada':['Puerto Carreño']
};

const deptoSel    = document.getElementById('departamento');
const ciudadSel   = document.getElementById('ciudad');
const ciudadGuardada = "<?php echo addslashes($r['ciudad'] ?? ''); ?>";

function cargarCiudades(depto, seleccionar) {
    const ciudades = ciudadesPorDepartamento[depto] || [];
    ciudadSel.innerHTML = '<option disabled>Seleccione ciudad</option>';
    ciudades.forEach(c => {
        const o = document.createElement('option');
        o.value = c; o.textContent = c;
        if (c === seleccionar) o.selected = true;
        ciudadSel.appendChild(o);
    });
    ciudadSel.disabled = ciudades.length === 0;
}

if (deptoSel.value) cargarCiudades(deptoSel.value, ciudadGuardada);
deptoSel.addEventListener('change', function() { cargarCiudades(this.value, ''); });

// Validación Bootstrap
(function() {
    'use strict';
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
            form.classList.add('was-validated');
        });
    });
})();
</script>
</body>
</html>
<?php
if (isset($conexion) && $conexion) $conexion->close();
include("../../../footer.php");
?>
//corregir//