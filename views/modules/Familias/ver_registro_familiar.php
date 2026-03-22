<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

require_once("../../../config/conexion.php");

$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success = isset($_GET['success']) ? (int)$_GET['success'] : 0;

if ($id <= 0) {
    header("Location: listado_registros_familiares.php");
    exit();
}

$sql  = "SELECT rf.*, u.nombre_completo AS usuario_nombre
         FROM registro_familiar rf
         INNER JOIN usuarios u ON rf.id_usuario = u.id
         WHERE rf.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: listado_registros_familiares.php");
    exit();
}

$registro = $result->fetch_assoc();
$stmt->close();
$conexion->close();

// Helper fecha segura
function fechaSegura($val, $formato = 'd/m/Y') {
    if (empty($val) || $val === '0000-00-00') return 'N/A';
    $ts = strtotime($val);
    return $ts ? date($formato, $ts) : 'N/A';
}

include("../../../header.php");
?>
<body class="bg-light">
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-file-text me-2"></i>Detalle del Registro Familiar
        </h2>
        <div>
            <a href="listado_registros_familiares.php" class="btn btn-outline-success me-2">
                <i class="bi bi-list me-2"></i>Ver Listado
            </a>
            <a href="panel_familia.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver al Panel
            </a>
        </div>
    </div>

    <?php if ($success == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>Registro guardado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-person-badge me-2"></i>INFORMACIÓN COMPLETA — ID #<?php echo $id; ?>
            </h5>
            <a href="editar_registro_familiar.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm">
                <i class="bi bi-pencil-fill me-1"></i>Editar
            </a>
        </div>
        <div class="card-body p-4">

            <!-- DATOS BÁSICOS -->
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="text-success fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>DATOS BÁSICOS</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro['nombre'] . ' ' . $registro['apellidos']); ?></p>
                        <p><strong>Tipo Documento:</strong> <?php echo htmlspecialchars($registro['tipo_documento'] ?: 'N/A'); ?></p>
                        <p><strong>Número Documento:</strong> <?php echo htmlspecialchars($registro['numero_documento']); ?></p>
                        <p><strong>Parentesco:</strong> <?php echo htmlspecialchars($registro['parentesco'] ?: 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha Nacimiento:</strong> <?php echo fechaSegura($registro['fecha_nacimiento']); ?></p>
                        <p><strong>Fecha Expedición:</strong> <?php echo fechaSegura($registro['fecha_expedicion']); ?></p>
                        <p><strong>Nacionalidad:</strong> <?php echo htmlspecialchars($registro['nacionalidad'] ?: 'N/A'); ?></p>
                    </div>
                </div>
            </div>

            <!-- UBICACIÓN Y CONTACTO -->
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="text-success fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>UBICACIÓN Y CONTACTO</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($registro['direccion_actual'] ?: 'N/A'); ?></p>
                        <p><strong>Departamento:</strong> <?php echo htmlspecialchars($registro['departamento'] ?: 'N/A'); ?></p>
                        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($registro['ciudad'] ?: 'N/A'); ?></p>
                        <p><strong>Género:</strong> <?php echo htmlspecialchars($registro['genero'] ?: 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Celular:</strong> <?php echo htmlspecialchars($registro['telefono_celular']); ?></p>
                        <p><strong>Teléfono Fijo:</strong> <?php echo htmlspecialchars($registro['telefono_fijo'] ?: 'N/A'); ?></p>
                        <p><strong>Ocupación:</strong> <?php echo htmlspecialchars($registro['ocupacion'] ?: 'N/A'); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($registro['correo_electronico'] ?: 'N/A'); ?></p>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN LABORAL -->
            <?php if (!empty($registro['empresa_laboral']) || !empty($registro['cargo_laboral'])): ?>
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="text-success fw-bold mb-3"><i class="bi bi-briefcase me-2"></i>INFORMACIÓN LABORAL</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Empresa:</strong> <?php echo htmlspecialchars($registro['empresa_laboral'] ?: 'N/A'); ?></p>
                        <p><strong>Cargo:</strong> <?php echo htmlspecialchars($registro['cargo_laboral'] ?: 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Teléfono Laboral:</strong> <?php echo htmlspecialchars($registro['telefono_laboral'] ?: 'N/A'); ?></p>
                        <p><strong>Dirección Laboral:</strong> <?php echo htmlspecialchars($registro['direccion_laboral'] ?: 'N/A'); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- INFORMACIÓN DEL INTERNO -->
            <?php if (!empty($registro['interno_nombre'])): ?>
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="text-success fw-bold mb-3"><i class="bi bi-people me-2"></i>INFORMACIÓN DEL INTERNO</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro['interno_nombre']); ?></p>
                        <p><strong>Parentesco:</strong> <?php echo htmlspecialchars($registro['interno_parentesco'] ?: 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Documento:</strong> <?php echo htmlspecialchars(trim($registro['interno_tipo_documento'] . ' ' . $registro['interno_numero_documento']) ?: 'N/A'); ?></p>
                        <p><strong>Fecha Nacimiento:</strong> <?php echo fechaSegura($registro['interno_fecha_nacimiento']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- DOCUMENTACIÓN -->
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="text-success fw-bold mb-3"><i class="bi bi-file-text me-2"></i>DOCUMENTACIÓN</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Doc. Familiar:</strong>
                        <?php if (!empty($registro['doc_familiar'])): ?>
                            <a href="<?php echo BASE_URL . $registro['doc_familiar']; ?>" target="_blank" class="btn btn-sm btn-outline-success ms-2">
                                <i class="bi bi-file-earmark me-1"></i>Ver archivo
                            </a>
                        <?php else: ?> <span class="text-muted">No adjunto</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Doc. Interno:</strong>
                        <?php if (!empty($registro['doc_interno'])): ?>
                            <a href="<?php echo BASE_URL . $registro['doc_interno']; ?>" target="_blank" class="btn btn-sm btn-outline-success ms-2">
                                <i class="bi bi-file-earmark me-1"></i>Ver archivo
                            </a>
                        <?php else: ?> <span class="text-muted">No adjunto</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- METADATOS -->
            <div class="text-muted small border-top pt-3">
                <p class="mb-1"><i class="bi bi-person me-1"></i>Registrado por: <?php echo htmlspecialchars($registro['usuario_nombre']); ?></p>
                <p class="mb-0">
                    <i class="bi bi-calendar me-1"></i>Fecha registro: <?php echo fechaSegura($registro['fecha_registro'], 'd/m/Y H:i'); ?>
                    <?php if (!empty($registro['fecha_actualizacion']) && $registro['fecha_actualizacion'] !== $registro['fecha_registro']): ?>
                        | Última actualización: <?php echo fechaSegura($registro['fecha_actualizacion'], 'd/m/Y H:i'); ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
<?php include("../../../footer.php"); ?>