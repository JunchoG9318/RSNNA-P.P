<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Determinar la URL de retorno según el tipo de usuario
$back_url = BASE_URL . "views/modules/ICBF/panel_icbf.php"; // Por defecto
$back_text = "Volver al Panel ICBF";

if (isset($_SESSION['usuario_tipo'])) {
    if ($_SESSION['usuario_tipo'] == 'fundacion') {
        $back_url = BASE_URL . "views/modules/fundaciones/panel_fundacion.php";
        $back_text = "Volver al Panel de Fundación";
    }
}

include("../../../header.php");
include("../../../config/conexion.php");
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            <!-- Encabezado con botón de volver -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="<?php echo $back_url; ?>" class="btn btn-outline-success me-3">
                        <i class="bi bi-arrow-left me-2"></i><?php echo $back_text; ?>
                    </a>
                    <h2 class="fw-bold text-dark mb-0">
                        <i class="bi bi-building me-2"></i>Administración de Fundaciones
                    </h2>
                </div>
                <span class="badge bg-light text-dark px-3 py-2 border"><?php echo date('d/m/Y'); ?></span>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Buscar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-search text-success"></i>
                                </span>
                                <input type="text" class="form-control" id="busqueda" placeholder="Nombre o NIT...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tipo</label>
                            <select class="form-select" id="filtroTipo">
                                <option value="">Todos</option>
                                <option value="social">Social</option>
                                <option value="educativa">Educativa</option>
                                <option value="ambiental">Ambiental</option>
                                <option value="salud">Salud</option>
                                <option value="otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Estado</label>
                            <select class="form-select" id="filtroEstado">
                                <option value="">Todos</option>
                                <option value="1">Activas</option>
                                <option value="0">Inactivas</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success w-100" onclick="aplicarFiltros()">
                                <i class="bi bi-funnel me-2"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de fundaciones -->
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-list-columns text-success me-2"></i>Listado de Fundaciones
                    </h5>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2" id="totalRegistros">Cargando...</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Fundación</th>
                                    <th>NIT</th>
                                    <th>Tipo</th>
                                    <th>Director</th>
                                    <th>Contacto</th>
                                    <th>Fecha Registro</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaFundaciones">
                                <!-- Los datos se cargarán vía AJAX -->
                                <tr>
                                    <td colspan="9" class="text-center">Cargando datos...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center" id="paginacion"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles -->
<div class="modal fade" id="modalVer" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Detalles de la Fundación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleFundacion">
                <!-- Contenido cargado vía AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Fundación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                        <i class="bi bi-info-circle me-2"></i>Datos Generales
                    </h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">NIT</label>
                            <input type="text" class="form-control" name="nit" id="edit_nit" required>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha Constitución</label>
                            <input type="date" class="form-control" name="fecha_constitucion" id="edit_fecha_constitucion" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipo</label>
                            <select class="form-select" name="tipo" id="edit_tipo" required>
                                <option value="social">Social</option>
                                <option value="educativa">Educativa</option>
                                <option value="ambiental">Ambiental</option>
                                <option value="salud">Salud</option>
                                <option value="otra">Otra</option>
                            </select>
                        </div>
                    </div>
                    
                    <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3 mt-4">
                        <i class="bi bi-person-badge me-2"></i>Datos del Director
                    </h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre del Director</label>
                            <input type="text" class="form-control" name="nombre_director" id="edit_nombre_director" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo</label>
                            <input type="email" class="form-control" name="correo_director" id="edit_correo_director" required>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono_director" id="edit_telefono_director" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado</label>
                            <select class="form-select" name="estado" id="edit_estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="guardarEdicion()">
                    <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para aprobar/rechazar -->
<div class="modal fade" id="modalAprobar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Aprobar Fundación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <input type="hidden" id="aprobar_id">
                <div class="my-3">
                    <i class="bi bi-building-check text-success" style="font-size: 4rem;"></i>
                </div>
                <h5 id="aprobar_nombre" class="fw-bold mb-3"></h5>
                <p class="text-muted mb-4">¿Estás seguro de aprobar esta fundación?</p>
                <p class="small">Al aprobar, la fundación quedará activa en el sistema.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success px-5" onclick="confirmarAprobacion()">
                    <i class="bi bi-check-circle me-2"></i>Aprobar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Eliminar Fundación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <input type="hidden" id="eliminar_id">
                <div class="my-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 id="eliminar_nombre" class="fw-bold mb-3"></h5>
                <p class="text-muted mb-4">¿Estás seguro de eliminar esta fundación?</p>
                <p class="small text-danger">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger px-5" onclick="confirmarEliminacion()">
                    <i class="bi bi-trash me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let paginaActual = 1;
let totalPaginas = 1;
const BASE_URL = '<?php echo BASE_URL; ?>';

document.addEventListener('DOMContentLoaded', function() {
    cargarFundaciones();
});

function cargarFundaciones(pagina = 1) {
    const busqueda = document.getElementById('busqueda').value;
    const tipo = document.getElementById('filtroTipo').value;
    const estado = document.getElementById('filtroEstado').value;
    
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php?accion=listar&pagina=' + pagina + '&busqueda=' + encodeURIComponent(busqueda) + '&tipo=' + tipo + '&estado=' + estado)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tablaFundaciones');
            tbody.innerHTML = '';
            
            if (data.datos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center">No hay fundaciones registradas</td></tr>';
            } else {
                data.datos.forEach(f => {
                    const estadoBadge = f.estado == 1 ? 
                        '<span class="badge bg-success">Activa</span>' : 
                        '<span class="badge bg-secondary">Inactiva</span>';
                    
                    tbody.innerHTML += `
                        <tr>
                            <td>${f.id}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="bi bi-building text-success"></i>
                                    </div>
                                    <span>${f.nombre}</span>
                                </div>
                            </td>
                            <td>${f.nit}</td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">${f.tipo}</span></td>
                            <td>${f.nombre_director}</td>
                            <td>
                                <i class="bi bi-telephone me-1"></i>${f.telefono_director}<br>
                                <small class="text-muted">${f.correo_director}</small>
                            </td>
                            <td>${f.fecha_registro ? new Date(f.fecha_registro).toLocaleDateString() : ''}</td>
                            <td>${estadoBadge}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1" onclick="verFundacion(${f.id})" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning me-1" onclick="editarFundacion(${f.id})" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success me-1" onclick="aprobarFundacion(${f.id}, '${f.nombre}')" title="Aprobar">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="eliminarFundacion(${f.id}, '${f.nombre}')" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            
            document.getElementById('totalRegistros').textContent = `Total: ${data.total} registros`;
            actualizarPaginacion(data.pagina_actual, data.total_paginas);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tablaFundaciones').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar datos</td></tr>';
        });
}

function actualizarPaginacion(pagina, total) {
    paginaActual = pagina;
    totalPaginas = total;
    
    let html = '';
    if (total > 1) {
        html += `<li class="page-item ${pagina === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="cargarFundaciones(${pagina - 1}); return false;">Anterior</a>
        </li>`;
        
        for (let i = 1; i <= total; i++) {
            if (i === pagina) {
                html += `<li class="page-item active"><span class="page-link bg-success border-success">${i}</span></li>`;
            } else {
                html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarFundaciones(${i}); return false;">${i}</a></li>`;
            }
        }
        
        html += `<li class="page-item ${pagina === total ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="cargarFundaciones(${pagina + 1}); return false;">Siguiente</a>
        </li>`;
    }
    
    document.getElementById('paginacion').innerHTML = html;
}

function aplicarFiltros() {
    cargarFundaciones(1);
}

function verFundacion(id) {
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php?accion=ver&id=' + id)
        .then(response => response.json())
        .then(f => {
            const html = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-success">Datos Generales</h6>
                        <table class="table table-sm">
                            <tr><th>ID:</th><td>${f.id}</td></tr>
                            <tr><th>Nombre:</th><td>${f.nombre}</td></tr>
                            <tr><th>NIT:</th><td>${f.nit}</td></tr>
                            <tr><th>Fecha Constitución:</th><td>${f.fecha_constitucion}</td></tr>
                            <tr><th>Tipo:</th><td><span class="badge bg-info">${f.tipo}</span></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-success">Datos del Director</h6>
                        <table class="table table-sm">
                            <tr><th>Nombre:</th><td>${f.nombre_director}</td></tr>
                            <tr><th>Correo:</th><td>${f.correo_director}</td></tr>
                            <tr><th>Teléfono:</th><td>${f.telefono_director}</td></tr>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
                        <h6 class="fw-bold text-success">Información del Sistema</h6>
                        <table class="table table-sm">
                            <tr><th>Fecha Registro:</th><td>${f.fecha_registro}</td></tr>
                            <tr><th>Última Actualización:</th><td>${f.fecha_actualizacion}</td></tr>
                            <tr><th>Estado:</th><td>${f.estado == 1 ? '<span class="badge bg-success">Activa</span>' : '<span class="badge bg-secondary">Inactiva</span>'}</td></tr>
                        </table>
                    </div>
                </div>
            `;
            document.getElementById('detalleFundacion').innerHTML = html;
            new bootstrap.Modal(document.getElementById('modalVer')).show();
        });
}

function editarFundacion(id) {
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php?accion=ver&id=' + id)
        .then(response => response.json())
        .then(f => {
            document.getElementById('edit_id').value = f.id;
            document.getElementById('edit_nombre').value = f.nombre;
            document.getElementById('edit_nit').value = f.nit;
            document.getElementById('edit_fecha_constitucion').value = f.fecha_constitucion;
            document.getElementById('edit_tipo').value = f.tipo;
            document.getElementById('edit_nombre_director').value = f.nombre_director;
            document.getElementById('edit_correo_director').value = f.correo_director;
            document.getElementById('edit_telefono_director').value = f.telefono_director;
            document.getElementById('edit_estado').value = f.estado;
            
            new bootstrap.Modal(document.getElementById('modalEditar')).show();
        });
}

function guardarEdicion() {
    const formData = new FormData(document.getElementById('formEditar'));
    formData.append('accion', 'actualizar');
    
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
            cargarFundaciones(paginaActual);
            Swal.fire('¡Éxito!', 'Fundación actualizada correctamente', 'success');
        } else {
            Swal.fire('Error', result.error || 'Error al actualizar', 'error');
        }
    });
}

function aprobarFundacion(id, nombre) {
    document.getElementById('aprobar_id').value = id;
    document.getElementById('aprobar_nombre').textContent = nombre;
    new bootstrap.Modal(document.getElementById('modalAprobar')).show();
}

function confirmarAprobacion() {
    const id = document.getElementById('aprobar_id').value;
    
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'accion=aprobar&id=' + id
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalAprobar')).hide();
            cargarFundaciones(paginaActual);
            Swal.fire('¡Aprobada!', 'Fundación aprobada correctamente', 'success');
        } else {
            Swal.fire('Error', result.error || 'Error al aprobar', 'error');
        }
    });
}

function eliminarFundacion(id, nombre) {
    document.getElementById('eliminar_id').value = id;
    document.getElementById('eliminar_nombre').textContent = nombre;
    new bootstrap.Modal(document.getElementById('modalEliminar')).show();
}

function confirmarEliminacion() {
    const id = document.getElementById('eliminar_id').value;
    
    fetch(BASE_URL + 'views/modules/ICBF/controlador_fundaciones.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'accion=eliminar&id=' + id
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEliminar')).hide();
            cargarFundaciones(paginaActual);
            Swal.fire('¡Eliminada!', 'Fundación eliminada correctamente', 'success');
        } else {
            Swal.fire('Error', result.error || 'Error al eliminar', 'error');
        }
    });
}
</script>

<!-- SweetAlert2 para alertas bonitas -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>