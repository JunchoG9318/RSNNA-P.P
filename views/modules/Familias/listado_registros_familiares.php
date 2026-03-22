<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

require_once("../../../config/conexion.php");

$usuario_id   = $_SESSION['usuario_id'];
$usuario_tipo = $_SESSION['usuario_tipo'] ?? '';

// Búsqueda y paginación — ANTES del include header
$busqueda   = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$param      = "%" . $busqueda . "%";
$por_pagina = 10;
$pagina     = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset     = ($pagina - 1) * $por_pagina;

// Contar total
if ($usuario_tipo === 'icbf') {
    $sc = $conexion->prepare("SELECT COUNT(*) FROM registro_familiar WHERE nombre LIKE ? OR apellidos LIKE ? OR numero_documento LIKE ?");
    $sc->bind_param("sss", $param, $param, $param);
} else {
    $sc = $conexion->prepare("SELECT COUNT(*) FROM registro_familiar WHERE id_usuario = ? AND (nombre LIKE ? OR apellidos LIKE ? OR numero_documento LIKE ?)");
    $sc->bind_param("isss", $usuario_id, $param, $param, $param);
}
$sc->execute();
$sc->bind_result($total);
$sc->fetch();
$sc->close();
$total_paginas = max(1, ceil($total / $por_pagina));

// Obtener registros
if ($usuario_tipo === 'icbf') {
    $stmt = $conexion->prepare(
        "SELECT rf.id, rf.nombre, rf.apellidos, rf.tipo_documento, rf.numero_documento,
                rf.parentesco, rf.telefono_celular, rf.interno_nombre,
                rf.fecha_registro, rf.estado,
                u.nombre_completo AS usuario_nombre
         FROM registro_familiar rf
         INNER JOIN usuarios u ON rf.id_usuario = u.id
         WHERE (rf.nombre LIKE ? OR rf.apellidos LIKE ? OR rf.numero_documento LIKE ?)
         ORDER BY rf.fecha_registro DESC LIMIT ? OFFSET ?"
    );
    $stmt->bind_param("sssii", $param, $param, $param, $por_pagina, $offset);
} else {
    $stmt = $conexion->prepare(
        "SELECT rf.id, rf.nombre, rf.apellidos, rf.tipo_documento, rf.numero_documento,
                rf.parentesco, rf.telefono_celular, rf.interno_nombre,
                rf.fecha_registro, rf.estado,
                u.nombre_completo AS usuario_nombre
         FROM registro_familiar rf
         INNER JOIN usuarios u ON rf.id_usuario = u.id
         WHERE rf.id_usuario = ? AND (rf.nombre LIKE ? OR rf.apellidos LIKE ? OR rf.numero_documento LIKE ?)
         ORDER BY rf.fecha_registro DESC LIMIT ? OFFSET ?"
    );
    $stmt->bind_param("isssii", $usuario_id, $param, $param, $param, $por_pagina, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Mensajes de sesión
$msg = '';
if (isset($_SESSION['msg'])) { $msg = $_SESSION['msg']; unset($_SESSION['msg']); }

include("../../../header.php");
?>
<body class="bg-light">
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-list-columns me-2"></i>Registros Familiares
        </h2>
        <div>
            <a href="registro_familiar.php" class="btn btn-success me-2">
                <i class="bi bi-plus-circle me-2"></i>Nuevo Registro
            </a>
            <a href="panel_familia.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    <?php if ($msg === 'updated'): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>Registro actualizado correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif ($msg === 'deleted'): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-trash-fill me-2"></i>Registro eliminado correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>Registro guardado correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill me-2"></i>Listado de Registros
                    <span class="badge bg-white text-success ms-2"><?php echo $total; ?></span>
                </h5>
                <form method="GET" class="d-flex gap-2" style="min-width:300px">
                    <input type="text" name="buscar" class="form-control form-control-sm"
                           placeholder="Nombre, apellido o documento..."
                           value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" class="btn btn-light btn-sm px-3"><i class="bi bi-search"></i></button>
                    <?php if ($busqueda): ?>
                    <a href="listado_registros_familiares.php" class="btn btn-outline-light btn-sm"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">#</th>
                            <th>Familiar</th>
                            <th>Documento</th>
                            <th>Parentesco</th>
                            <th>Celular</th>
                            <th>Interno</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $n = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-3 text-muted"><?php echo $n++; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']); ?></strong>
                                <?php if ($usuario_tipo === 'icbf'): ?>
                                <br><small class="text-muted"><?php echo htmlspecialchars($row['usuario_nombre']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted d-block"><?php echo htmlspecialchars($row['tipo_documento']); ?></small>
                                <?php echo htmlspecialchars($row['numero_documento']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['parentesco'] ?: '—'); ?></td>
                            <td><?php echo htmlspecialchars($row['telefono_celular']); ?></td>
                            <td>
                                <?php if (!empty($row['interno_nombre'])): ?>
                                    <?php echo htmlspecialchars(mb_strimwidth($row['interno_nombre'], 0, 22, '...')); ?>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted">
                                <?php
                                $ts = strtotime($row['fecha_registro'] ?? '');
                                echo $ts ? date('d/m/Y', $ts) : '—';
                                ?>
                            </td>
                            <td>
                                <?php if (($row['estado'] ?? '') === 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="ver_registro_familiar.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-sm btn-outline-info" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($usuario_tipo !== 'icbf'): ?>
                                    <a href="editar_registro_familiar.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                            onclick="confirmarEliminar(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars(addslashes($row['nombre'] . ' ' . $row['apellidos'])); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_paginas > 1): ?>
            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top">
                <small class="text-muted">
                    Mostrando <?php echo $offset + 1; ?>–<?php echo min($offset + $por_pagina, $total); ?> de <?php echo $total; ?>
                </small>
                <nav>
                    <ul class="pagination pagination-sm mb-0 gap-1">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?php echo $i === $pagina ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <?php if ($busqueda): ?>
                    No hay resultados para <strong>"<?php echo htmlspecialchars($busqueda); ?>"</strong>
                <?php else: ?>
                    No hay registros familiares.
                    <div class="mt-3">
                        <a href="registro_familiar.php" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>Crear primer registro
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que desea eliminar el registro de <strong id="nombreEliminar"></strong>?
                <p class="text-danger small mt-2 mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="btnEliminar" href="#" class="btn btn-danger">
                    <i class="bi bi-trash-fill me-1"></i>Eliminar
                </a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarEliminar(id, nombre) {
    document.getElementById('nombreEliminar').textContent = nombre;
    document.getElementById('btnEliminar').href = 'eliminar_registro_familiar.php?id=' + id;
    new bootstrap.Modal(document.getElementById('modalEliminar')).show();
}
</script>
</body>
<?php
$stmt->close();
include("../../../footer.php");
?>