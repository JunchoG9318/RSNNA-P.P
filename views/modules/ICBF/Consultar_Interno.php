<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
require_once("../../../config/conexion.php");

$resultado_busqueda = [];
$busqueda_realizada = false;
$termino_busqueda = '';
$tipo_busqueda = '';

// Obtener la fundación del usuario para filtrar resultados
$id_fundacion = $_SESSION['id_fundacion'] ?? 0;
$usuario_tipo = $_SESSION['usuario_tipo'] ?? '';

// Obtener el NOMBRE de la fundación del usuario (NO el ID)
$nombre_fundacion_usuario = '';
if ($usuario_tipo == 'fundacion' && $id_fundacion > 0) {
    $query_fundacion = "SELECT nombre, nit, ciudad FROM fundaciones WHERE id = $id_fundacion";
    $result_fundacion = mysqli_query($conexion, $query_fundacion);
    if ($result_fundacion && mysqli_num_rows($result_fundacion) > 0) {
        $fundacion_data = mysqli_fetch_assoc($result_fundacion);
        $nombre_fundacion_usuario = $fundacion_data['nombre'];
        $fundacion_usuario = $fundacion_data;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termino_busqueda = trim($_POST['termino_busqueda'] ?? '');
    $tipo_busqueda = $_POST['tipo_busqueda'] ?? 'documento';
    $busqueda_realizada = true;

    if (!empty($termino_busqueda)) {
        // Tabla correcta: ingresos_fundacion
        $tabla_internos = "ingresos_fundacion";

        // Construir la consulta según el tipo de búsqueda
        if ($tipo_busqueda === 'documento') {
            // Búsqueda por número de documento del menor
            if ($usuario_tipo == 'fundacion' && !empty($nombre_fundacion_usuario)) {
                // Si es fundación, filtrar por NOMBRE de fundación
                $sql = "SELECT i.*, f.nombre as fundacion_nombre, f.nit as fundacion_nit, f.ciudad as fundacion_ciudad,
                               f.direccion as fundacion_direccion, f.telefono_director as fundacion_telefono
                        FROM $tabla_internos i 
                        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre 
                        WHERE i.menor_num_doc LIKE ? AND i.fundacion_nombre = ?
                        ORDER BY i.menor_nombres ASC";
                $param = "%$termino_busqueda%";
                $filtro_fundacion = $nombre_fundacion_usuario;
            } else {
                $sql = "SELECT i.*, f.nombre as fundacion_nombre, f.nit as fundacion_nit, f.ciudad as fundacion_ciudad,
                               f.direccion as fundacion_direccion, f.telefono_director as fundacion_telefono
                        FROM $tabla_internos i 
                        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre 
                        WHERE i.menor_num_doc LIKE ? 
                        ORDER BY i.menor_nombres ASC";
                $param = "%$termino_busqueda%";
            }
        } else {
            // Búsqueda por nombre del menor
            if ($usuario_tipo == 'fundacion' && !empty($nombre_fundacion_usuario)) {
                $sql = "SELECT i.*, f.nombre as fundacion_nombre, f.nit as fundacion_nit, f.ciudad as fundacion_ciudad,
                               f.direccion as fundacion_direccion, f.telefono_director as fundacion_telefono
                        FROM $tabla_internos i 
                        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre 
                        WHERE i.menor_nombres LIKE ? AND i.fundacion_nombre = ?
                        ORDER BY i.menor_nombres ASC";
                $param = "%$termino_busqueda%";
                $filtro_fundacion = $nombre_fundacion_usuario;
            } else {
                $sql = "SELECT i.*, f.nombre as fundacion_nombre, f.nit as fundacion_nit, f.ciudad as fundacion_ciudad,
                               f.direccion as fundacion_direccion, f.telefono_director as fundacion_telefono
                        FROM $tabla_internos i 
                        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre 
                        WHERE i.menor_nombres LIKE ? 
                        ORDER BY i.menor_nombres ASC";
                $param = "%$termino_busqueda%";
            }
        }

        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            echo "<div class='alert alert-danger'>Error en la consulta: " . $conexion->error . "</div>";
        } else {
            // Vincular parámetros según el caso
            if ($tipo_busqueda === 'documento') {
                if ($usuario_tipo == 'fundacion' && !empty($nombre_fundacion_usuario)) {
                    $stmt->bind_param("ss", $param, $filtro_fundacion);
                } else {
                    $stmt->bind_param("s", $param);
                }
            } else {
                if ($usuario_tipo == 'fundacion' && !empty($nombre_fundacion_usuario)) {
                    $stmt->bind_param("ss", $param, $filtro_fundacion);
                } else {
                    $stmt->bind_param("s", $param);
                }
            }

            $stmt->execute();
            $resultado_busqueda = $stmt->get_result();
        }
    }
}
?>

<!-- Modal para ver detalles completos -->
<div class="modal fade" id="modalDetalleInterno" tabindex="-1" aria-labelledby="modalDetalleInternoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalDetalleInternoLabel">
                    <i class="bi bi-person-badge me-2"></i>DETALLES COMPLETOS DEL INTERNO
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenidoDetalleInterno">
                <div class="text-center py-4">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando información...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">

                <!-- ENCABEZADO -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-0">
                            <i class="bi bi-search-heart me-3"></i>CONSULTAR INTERNOS
                        </h2>
                        <p class="text-muted mt-2">Busque internos por número de documento o nombre completo</p>
                        <?php if (!empty($fundacion_usuario)): ?>
                            <p class="text-success small mt-1">
                                <i class="bi bi-building me-1"></i>
                                Fundación: <?php echo htmlspecialchars($fundacion_usuario['nombre']); ?>
                                (NIT: <?php echo htmlspecialchars($fundacion_usuario['nit']); ?>)
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <span class="badge bg-primary text-white px-3 py-2">
                            <i class="bi bi-calendar3 me-2"></i><?php echo date('d/m/Y'); ?>
                        </span>
                        <!-- BOTÓN ATRÁS CON RUTA ESPECÍFICA A PANEL FUNDACIÓN -->
                        <a href="<?php echo BASE_URL; ?>views/modules/ICBF/panel_icbf.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                        </a>
                    </div>
                </div>

                <!-- FORMULARIO DE BÚSQUEDA -->
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-search me-2"></i>BUSCAR INTERNO
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="" class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Tipo de búsqueda:</label>
                                <select name="tipo_busqueda" id="tipo_busqueda" class="form-select">
                                    <option value="documento" <?php echo ($tipo_busqueda == 'documento') ? 'selected' : ''; ?>>
                                        Por número de documento
                                    </option>
                                    <option value="nombre" <?php echo ($tipo_busqueda == 'nombre') ? 'selected' : ''; ?>>
                                        Por nombre completo
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold" id="label_busqueda">
                                    <?php echo ($tipo_busqueda == 'documento') ? 'Número de documento:' : 'Nombre completo:'; ?>
                                </label>
                                <input type="text"
                                    name="termino_busqueda"
                                    class="form-control"
                                    value="<?php echo htmlspecialchars($termino_busqueda); ?>"
                                    placeholder="<?php echo ($tipo_busqueda == 'documento') ? 'Ej: 12345678' : 'Ej: Juan Pérez'; ?>"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100 py-2">
                                    <i class="bi bi-search me-2"></i>Buscar
                                </button>
                            </div>
                        </form>
                        <?php if ($usuario_tipo == 'fundacion'): ?>
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Mostrando solo internos de tu fundación
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- RESULTADOS DE LA BÚSQUEDA -->
                <?php if ($busqueda_realizada): ?>
                    <div class="card border-0 shadow-lg mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-list-columns me-2"></i>RESULTADOS DE LA BÚSQUEDA
                                </h5>
                                <span class="badge bg-white text-primary px-3 py-2">
                                    <?php
                                    if (isset($resultado_busqueda) && $resultado_busqueda) {
                                        echo $resultado_busqueda->num_rows . ' resultado(s) encontrado(s)';
                                    } else {
                                        echo '0 resultados';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php if (isset($resultado_busqueda) && $resultado_busqueda && $resultado_busqueda->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="15%">NOMBRES</th>
                                                <th width="12%">DOCUMENTO</th>
                                                <th width="8%">EDAD</th>
                                                <th width="8%">SEXO</th>
                                                <th width="15%">ACUDIENTE</th>
                                                <th width="12%">FECHA INGRESO</th>
                                                <th width="15%">FUNDACIÓN</th>
                                                <th width="10%">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 1;
                                            while ($interno = $resultado_busqueda->fetch_assoc()):
                                                $sexo = match ($interno['sexo'] ?? '') {
                                                    'M' => 'Masculino',
                                                    'F' => 'Femenino',
                                                    default => 'No especificado'
                                                };

                                                // Mostrar fundación con más detalles
                                                $fundacion_mostrar = $interno['fundacion_nombre'] ?? 'No asignada';
                                                if (!empty($interno['fundacion_ciudad'])) {
                                                    $fundacion_mostrar .= ' - ' . $interno['fundacion_ciudad'];
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $contador++; ?></td>
                                                    <td class="fw-bold"><?php echo htmlspecialchars($interno['menor_nombres'] ?? ''); ?></td>
                                                    <td>
                                                        <small class="text-muted d-block"><?php echo htmlspecialchars($interno['menor_tipo_doc'] ?? ''); ?></small>
                                                        <?php echo htmlspecialchars($interno['menor_num_doc'] ?? ''); ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($interno['edad'] ?? 'N/A'); ?></td>
                                                    <td><?php echo $sexo; ?></td>
                                                    <td><?php echo htmlspecialchars($interno['acudiente_nombres'] ?? 'No registrado'); ?></td>
                                                    <td>
                                                        <?php
                                                        echo $interno['fecha_ingreso']
                                                            ? date('d/m/Y', strtotime($interno['fecha_ingreso']))
                                                            : 'N/A';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold"><?php echo htmlspecialchars($fundacion_mostrar); ?></span>
                                                        <?php if (!empty($interno['fundacion_nit'])): ?>
                                                            <br><small class="text-muted">NIT: <?php echo htmlspecialchars($interno['fundacion_nit']); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-outline-info"
                                                                onclick="verDetalle(<?php echo $interno['id']; ?>)"
                                                                title="Ver detalles completos">
                                                                <i class="bi bi-eye"></i> Ver detalles
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-emoji-frown fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No se encontraron internos</h5>
                                    <p class="text-muted mb-0">
                                        No hay internos que coincidan con "<strong><?php echo htmlspecialchars($termino_busqueda); ?></strong>"
                                    </p>
                                    <p class="text-muted small mt-3">
                                        Verifique que el término de búsqueda sea correcto
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($resultado_busqueda) && $resultado_busqueda && $resultado_busqueda->num_rows > 0): ?>
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Mostrando <?php echo $resultado_busqueda->num_rows; ?> interno(s)
                                    </span>
                                    <button class="btn btn-sm btn-outline-success" onclick="window.print()">
                                        <i class="bi bi-printer me-2"></i>Imprimir resultados
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- CONSEJOS DE BÚSQUEDA -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold text-success mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Consejos de búsqueda
                                </h6>
                                <ul class="small text-muted mb-0">
                                    <li>Para búsqueda por nombre, puede escribir nombre completo o parcial</li>
                                    <li>Ejemplo: "Juan" encontrará todos los internos con "Juan" en el nombre</li>
                                    <li>La búsqueda por documento es más precisa</li>
                                    <li>Los documentos se buscan con coincidencias parciales (ej: "123" encuentra "123456")</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }

        .btn-outline-success {
            border-color: #006341;
            color: #006341;
        }

        .btn-outline-success:hover {
            background-color: #006341;
            color: white;
        }

        .text-success {
            color: #006341 !important;
        }

        .bg-success {
            background-color: #006341 !important;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
        }

        .modal-xl {
            max-width: 90%;
        }

        .detalle-card {
            border-left: 4px solid #006341;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #f8f9fa;
        }

        .detalle-titulo {
            font-weight: bold;
            color: #006341;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
    </style>

    <script>
        // Cambiar el placeholder según el tipo de búsqueda seleccionado
        document.getElementById('tipo_busqueda').addEventListener('change', function() {
            const label = document.getElementById('label_busqueda');
            const input = document.querySelector('input[name="termino_busqueda"]');

            if (this.value === 'documento') {
                label.textContent = 'Número de documento:';
                input.placeholder = 'Ej: 12345678';
            } else {
                label.textContent = 'Nombre completo:';
                input.placeholder = 'Ej: Juan Pérez';
            }
        });

        // Función para ver detalles completos en modal
        function verDetalle(id) {
            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetalleInterno'));
            modal.show();

            // Mostrar carga
            document.getElementById('contenidoDetalleInterno').innerHTML =
                '<div class="text-center py-4">' +
                '<div class="spinner-border text-success" role="status">' +
                '<span class="visually-hidden">Cargando...</span>' +
                '</div>' +
                '<p class="mt-2">Cargando información...</p>' +
                '</div>';

            // Cargar datos
            fetch('<?php echo BASE_URL; ?>views/modules/fundaciones/obtener_interno.php?id=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        document.getElementById('contenidoDetalleInterno').innerHTML =
                            '<div class="alert alert-danger">Error: ' + data.error + '</div>';
                        return;
                    }

                    // Generar HTML con todos los detalles
                    let html = '<div class="row">';

                    // Información personal
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-person-circle me-2"></i>INFORMACIÓN PERSONAL</div>';
                    html += '<p><strong>Nombres:</strong> ' + (data.menor_nombres || '') + '</p>';
                    html += '<p><strong>Tipo Documento:</strong> ' + (data.menor_tipo_doc || '') + '</p>';
                    html += '<p><strong>Número Documento:</strong> ' + (data.menor_num_doc || '') + '</p>';
                    html += '<p><strong>Fecha Nacimiento:</strong> ' + (data.fecha_nacimiento ? new Date(data.fecha_nacimiento).toLocaleDateString('es-CO') : '') + '</p>';
                    html += '<p><strong>Edad:</strong> ' + (data.edad || '') + ' años</p>';
                    html += '<p><strong>Sexo:</strong> ' + (data.sexo == 'M' ? 'Masculino' : (data.sexo == 'F' ? 'Femenino' : 'No especificado')) + '</p>';
                    html += '<p><strong>Nacionalidad:</strong> ' + (data.nacionalidad || '') + '</p>';
                    html += '<p><strong>Lugar Nacimiento:</strong> ' + (data.lugar_nacimiento || '') + '</p>';
                    html += '<p><strong>Dirección Domicilio:</strong> ' + (data.direccion_domicilio || '') + '</p>';
                    html += '</div></div>';

                    // Información de ingreso
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-calendar-check me-2"></i>INFORMACIÓN DE INGRESO</div>';
                    html += '<p><strong>Fundación:</strong> ' + (data.fundacion_nombre || 'No asignada') + '</p>';
                    html += '<p><strong>Fecha Ingreso:</strong> ' + (data.fecha_ingreso ? new Date(data.fecha_ingreso).toLocaleDateString('es-CO') : '') + '</p>';
                    html += '<p><strong>Hora Ingreso:</strong> ' + (data.hora_ingreso || '') + '</p>';
                    html += '<p><strong>Motivo Ingreso:</strong> ' + (data.motivo_ingreso || '') + '</p>';
                    html += '<p><strong>Tipo Ingreso:</strong> ' + (data.tipo_ingreso || '') + '</p>';
                    html += '<p><strong>Responsable Remite:</strong> ' + (data.responsable_remite || '') + '</p>';
                    html += '<p><strong>Entidad Remite:</strong> ' + (data.entidad_remite || '') + '</p>';
                    html += '<p><strong>Número Proceso:</strong> ' + (data.numero_proceso || '') + '</p>';
                    html += '</div></div>';

                    // Acudiente
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-person-badge me-2"></i>ACUDIENTE</div>';
                    html += '<p><strong>Nombre:</strong> ' + (data.acudiente_nombres || '') + '</p>';
                    html += '<p><strong>Tipo Documento:</strong> ' + (data.acudiente_tipo_doc || '') + '</p>';
                    html += '<p><strong>Número Documento:</strong> ' + (data.acudiente_num_doc || '') + '</p>';
                    html += '<p><strong>Parentesco:</strong> ' + (data.acudiente_parentesco || '') + '</p>';
                    html += '<p><strong>Dirección:</strong> ' + (data.acudiente_direccion || '') + '</p>';
                    html += '<p><strong>Teléfono:</strong> ' + (data.acudiente_tel || '') + '</p>';
                    html += '<p><strong>Email:</strong> ' + (data.acudiente_email || '') + '</p>';
                    html += '<p><strong>Ocupación:</strong> ' + (data.acudiente_ocupacion || '') + '</p>';
                    html += '<p><strong>Responsable Legal:</strong> ' + (data.responsable_legal == '1' ? 'Sí' : 'No') + '</p>';
                    html += '</div></div>';

                    // Información de salud
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-heart-pulse me-2"></i>SALUD</div>';
                    html += '<p><strong>EPS:</strong> ' + (data.eps || '') + '</p>';
                    html += '<p><strong>Salud General:</strong> ' + (data.salud_general || '') + '</p>';
                    html += '<p><strong>Alergias:</strong> ' + (data.alergias || '') + '</p>';
                    html += '<p><strong>Discapacidad:</strong> ' + (data.discapacidad || '') + '</p>';
                    html += '<p><strong>Cuál Discapacidad:</strong> ' + (data.cual_discapacidad || '') + '</p>';
                    html += '</div></div>';

                    // Escolaridad
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-book me-2"></i>ESCOLARIDAD</div>';
                    html += '<p><strong>Escolaridad:</strong> ' + (data.escolaridad || '') + '</p>';
                    html += '<p><strong>Institución:</strong> ' + (data.institucion || '') + '</p>';
                    html += '<p><strong>Último Grado:</strong> ' + (data.ultimo_grado || '') + '</p>';
                    html += '</div></div>';

                    // Observaciones
                    html += '<div class="col-md-6">';
                    html += '<div class="detalle-card">';
                    html += '<div class="detalle-titulo"><i class="bi bi-chat-dots me-2"></i>OBSERVACIONES</div>';
                    html += '<p><strong>Psicológicas:</strong> ' + (data.obs_psicologicas || '') + '</p>';
                    html += '<p><strong>Sociales:</strong> ' + (data.obs_sociales || '') + '</p>';
                    html += '</div></div>';

                    html += '</div>';

                    document.getElementById('contenidoDetalleInterno').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('contenidoDetalleInterno').innerHTML =
                        '<div class="alert alert-danger">Error al cargar los datos: ' + error.message + '</div>';
                });
        }
    </script>

    <!-- Bootstrap JS (necesario para el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

<?php include("../../../footer.php"); ?>