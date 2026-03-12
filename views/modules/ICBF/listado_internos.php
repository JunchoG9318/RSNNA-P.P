<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'icbf') {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">
                        <i class="bi bi-people-fill me-2"></i>Internos por Fundación
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-building me-2"></i>
                        Listado completo de internos registrados en todas las fundaciones
                    </p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border">
                        <i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y'); ?>
                    </span>
                    <a href="<?php echo BASE_URL; ?>views/modules/ICBF/panel_icbf.php" class="btn btn-outline-success ms-3">
                        <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                    </a>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                A continuación se muestran todas las fundaciones con sus respectivos internos registrados.
            </div>

            <!-- PANEL FILTROS -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-funnel me-2"></i>Filtrar Internos
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" id="filtroFundacion" class="form-control" placeholder="Buscar por fundación">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="filtroInterno" class="form-control" placeholder="Buscar por nombre del interno">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="filtroDocumento" class="form-control" placeholder="Buscar por documento">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-secondary w-100" onclick="limpiarFiltrosInternos()">X</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Consulta de fundaciones (solo las que tienen internos o todas)
            $query_fundaciones = "
                SELECT f.*,
                    (SELECT COUNT(*) FROM ingresos_fundacion WHERE fundacion_nombre = f.nombre) as total_internos
                FROM fundaciones f
                ORDER BY f.nombre ASC
            ";
            $result_fundaciones = mysqli_query($conexion, $query_fundaciones);

            if (!$result_fundaciones) {
                echo '<div class="alert alert-danger">Error al cargar fundaciones: ' . mysqli_error($conexion) . '</div>';
            } else {
                while ($fundacion = mysqli_fetch_assoc($result_fundaciones)):
                    $query_internos = "
                        SELECT * FROM ingresos_fundacion
                        WHERE fundacion_nombre = '" . mysqli_real_escape_string($conexion, $fundacion['nombre']) . "'
                        ORDER BY fecha_ingreso DESC
                    ";
                    $result_internos = mysqli_query($conexion, $query_internos);
                    $total = ($result_internos) ? mysqli_num_rows($result_internos) : 0;
            ?>

                    <div class="card border-0 shadow-lg rounded-4 mb-5">
                        <div class="card-header bg-success text-white py-3 d-flex justify-content-between">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-building me-2"></i>
                                    <?php echo htmlspecialchars($fundacion['nombre']); ?>
                                </h5>
                                <small class="text-white-50">
                                    NIT: <?php echo htmlspecialchars($fundacion['nit']); ?>
                                </small>
                            </div>
                            <span class="badge bg-white text-success px-3 py-2">
                                <?php echo $total; ?> interno(s)
                            </span>
                        </div>

                        <div class="card-body p-0">
                            <?php if ($total > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Documento</th>
                                                <th>Fecha Ingreso</th>
                                                <th>Motivo</th>
                                                <th>Acudiente</th>
                                                <th>Edad</th>
                                                <th>Sexo</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 1;
                                            while ($interno = mysqli_fetch_assoc($result_internos)):
                                            ?>
                                                <tr data-fundacion="<?php echo strtolower($fundacion['nombre']); ?>">
                                                    <td><?php echo $contador++; ?></td>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($interno['menor_nombres'] ?? 'No registrado'); ?></strong>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo htmlspecialchars($interno['menor_tipo_doc'] ?? '');
                                                        echo " ";
                                                        echo htmlspecialchars($interno['menor_num_doc'] ?? '');
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo $interno['fecha_ingreso']
                                                            ? date("d/m/Y", strtotime($interno['fecha_ingreso']))
                                                            : "-";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $motivo = $interno['motivo_ingreso'] ?? '';
                                                        echo strlen($motivo) > 20 ? substr($motivo, 0, 20) . '...' : $motivo;
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($interno['acudiente_nombres'] ?? ''); ?></td>
                                                    <td class="text-center"><?php echo $interno['edad'] ?? '-'; ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $sexo = $interno['sexo'] ?? '';
                                                        if ($sexo == "M") {
                                                            echo '<span class="badge bg-info">M</span>';
                                                        } elseif ($sexo == "F") {
                                                            echo '<span class="badge bg-warning">F</span>';
                                                        } else {
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-success" onclick='verInfoInterno(<?php echo json_encode($interno); ?>)' data-bs-toggle="modal" data-bs-target="#modalInfoInterno">
                                                            <i class="bi bi-eye"></i> Ver
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-person-slash fs-1 text-muted"></i>
                                    <h6 class="text-muted">Esta fundación no tiene internos registrados</h6>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

            <?php
                endwhile;
            }
            ?>

        </div>
    </div>
</div>

<!-- Modal para mostrar información detallada del interno -->
<div class="modal fade" id="modalInfoInterno" tabindex="-1" aria-labelledby="modalInfoInternoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalInfoInternoLabel">
                    <i class="bi bi-person-badge me-2"></i>Información completa del interno
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detalleInterno" class="row">
                    <!-- Los datos se cargarán dinámicamente con JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para mostrar detalles del interno en el modal
    function verInfoInterno(interno) {
        let html = '';

        // Información personal del menor
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-info text-white"><i class="bi bi-person me-2"></i>Datos del Menor</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Nombre:</strong> ' + (interno.menor_nombres || '') + '</p>';
        html += '<p><strong>Fecha Nacimiento:</strong> ' + (interno.menor_fecha_nac ? new Date(interno.menor_fecha_nac).toLocaleDateString('es-CO') : '') + '</p>';
        html += '<p><strong>Edad:</strong> ' + (interno.edad || '') + ' años</p>';
        html += '<p><strong>Sexo:</strong> ' + (interno.sexo == 'M' ? 'Masculino' : (interno.sexo == 'F' ? 'Femenino' : 'Otro')) + '</p>';
        html += '<p><strong>Tipo Documento:</strong> ' + (interno.menor_tipo_doc || '') + '</p>';
        html += '<p><strong>Número Documento:</strong> ' + (interno.menor_num_doc || '') + '</p>';
        html += '<p><strong>Lugar Nacimiento:</strong> ' + (interno.menor_lugar_nac || '') + '</p>';
        html += '<p><strong>Dirección:</strong> ' + (interno.menor_direccion || '') + '</p>';
        html += '<p><strong>Teléfono:</strong> ' + (interno.menor_tel || '') + '</p>';
        html += '<p><strong>Email:</strong> ' + (interno.menor_email || '') + '</p>';
        html += '<p><strong>EPS:</strong> ' + (interno.menor_eps || '') + '</p>';
        html += '</div></div></div>';

        // Acudiente
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-success text-white"><i class="bi bi-person-check me-2"></i>Acudiente</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Nombre:</strong> ' + (interno.acudiente_nombres || '') + '</p>';
        html += '<p><strong>Tipo Documento:</strong> ' + (interno.acudiente_tipo_doc || '') + '</p>';
        html += '<p><strong>Número Documento:</strong> ' + (interno.acudiente_num_doc || '') + '</p>';
        html += '<p><strong>Parentesco:</strong> ' + (interno.acudiente_parentesco || '') + '</p>';
        html += '<p><strong>Dirección:</strong> ' + (interno.acudiente_direccion || '') + '</p>';
        html += '<p><strong>Teléfono:</strong> ' + (interno.acudiente_tel || '') + '</p>';
        html += '<p><strong>Email:</strong> ' + (interno.acudiente_email || '') + '</p>';
        html += '<p><strong>Ocupación:</strong> ' + (interno.acudiente_ocupacion || '') + '</p>';
        html += '<p><strong>Responsable Legal:</strong> ' + (interno.responsable_legal == '1' ? 'Sí' : 'No') + '</p>';
        html += '</div></div></div>';

        // Padre
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-primary text-white"><i class="bi bi-person-badge me-2"></i>Padre</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Nombre:</strong> ' + (interno.padre_nombres || '') + '</p>';
        html += '<p><strong>Tipo Documento:</strong> ' + (interno.padre_tipo_doc || '') + '</p>';
        html += '<p><strong>Número Documento:</strong> ' + (interno.padre_num_doc || '') + '</p>';
        html += '<p><strong>Dirección:</strong> ' + (interno.padre_direccion || '') + '</p>';
        html += '<p><strong>Teléfono:</strong> ' + (interno.padre_tel || '') + '</p>';
        html += '<p><strong>Email:</strong> ' + (interno.padre_email || '') + '</p>';
        html += '<p><strong>Ocupación:</strong> ' + (interno.padre_ocupacion || '') + '</p>';
        html += '<p><strong>Contacto:</strong> ' + (interno.padre_contacto == '1' ? 'Sí' : 'No') + '</p>';
        html += '</div></div></div>';

        // Madre
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-warning text-dark"><i class="bi bi-person-badge me-2"></i>Madre</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Nombre:</strong> ' + (interno.madre_nombres || '') + '</p>';
        html += '<p><strong>Tipo Documento:</strong> ' + (interno.madre_tipo_doc || '') + '</p>';
        html += '<p><strong>Número Documento:</strong> ' + (interno.madre_num_doc || '') + '</p>';
        html += '<p><strong>Dirección:</strong> ' + (interno.madre_direccion || '') + '</p>';
        html += '<p><strong>Teléfono:</strong> ' + (interno.madre_tel || '') + '</p>';
        html += '<p><strong>Email:</strong> ' + (interno.madre_email || '') + '</p>';
        html += '<p><strong>Ocupación:</strong> ' + (interno.madre_ocupacion || '') + '</p>';
        html += '<p><strong>Contacto:</strong> ' + (interno.madre_contacto == '1' ? 'Sí' : 'No') + '</p>';
        html += '</div></div></div>';

        // Escolaridad
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-secondary text-white"><i class="bi bi-book me-2"></i>Escolaridad</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Nivel Escolar:</strong> ' + (interno.escolaridad || '') + '</p>';
        html += '<p><strong>Institución:</strong> ' + (interno.institucion || '') + '</p>';
        html += '<p><strong>Último Grado:</strong> ' + (interno.ultimo_grado || '') + '</p>';
        html += '</div></div></div>';

        // Observaciones
        html += '<div class="col-md-6 mb-3">';
        html += '<div class="card h-100">';
        html += '<div class="card-header bg-dark text-white"><i class="bi bi-chat me-2"></i>Observaciones</div>';
        html += '<div class="card-body">';
        html += '<p><strong>Psicológicas:</strong> ' + (interno.obs_psicologicas || '') + '</p>';
        html += '<p><strong>Sociales:</strong> ' + (interno.obs_sociales || '') + '</p>';
        html += '</div></div></div>';

        // Ingreso y responsables
        html += '<div class="col-md-12 mb-3">';
        html += '<div class="card">';
        html += '<div class="card-header bg-info text-white"><i class="bi bi-calendar me-2"></i>Información de Ingreso</div>';
        html += '<div class="card-body">';
        html += '<div class="row">';
        html += '<div class="col-md-4"><p><strong>Fecha Ingreso:</strong> ' + (interno.fecha_ingreso ? new Date(interno.fecha_ingreso).toLocaleDateString('es-CO') : '') + '</p></div>';
        html += '<div class="col-md-4"><p><strong>Motivo Ingreso:</strong> ' + (interno.motivo_ingreso || '') + '</p></div>';
        html += '<div class="col-md-4"><p><strong>Funcionario Recibe:</strong> ' + (interno.funcionario_recibe || '') + '</p></div>';
        html += '<div class="col-md-4"><p><strong>Remitente Final:</strong> ' + (interno.remitente_final || '') + '</p></div>';
        html += '<div class="col-md-4"><p><strong>Fecha Registro:</strong> ' + (interno.fecha_registro ? new Date(interno.fecha_registro).toLocaleString('es-CO') : '') + '</p></div>';
        html += '<div class="col-md-4"><p><strong>Última Actualización:</strong> ' + (interno.fecha_actualizacion ? new Date(interno.fecha_actualizacion).toLocaleString('es-CO') : '') + '</p></div>';
        html += '</div>';
        html += '</div></div></div>';

        document.getElementById('detalleInterno').innerHTML = html;
    }

    // Filtros
    const filtroFundacion = document.getElementById("filtroFundacion");
    const filtroInterno = document.getElementById("filtroInterno");
    const filtroDocumento = document.getElementById("filtroDocumento");

    function aplicarFiltrosInternos() {
        let fundacion = filtroFundacion.value.toLowerCase();
        let interno = filtroInterno.value.toLowerCase();
        let documento = filtroDocumento.value.toLowerCase();

        let tarjetas = document.querySelectorAll(".card.border-0.shadow-lg.rounded-4.mb-5"); // más específico

        tarjetas.forEach(card => {
            let nombreFundacionElem = card.querySelector(".card-header h5");
            if (!nombreFundacionElem) return;
            let textoFundacion = nombreFundacionElem.innerText.toLowerCase();
            let mostrarFundacion = true;
            if (fundacion && !textoFundacion.includes(fundacion)) {
                mostrarFundacion = false;
            }

            let filas = card.querySelectorAll("tbody tr");
            let algunaVisible = false;

            filas.forEach(fila => {
                let celdas = fila.querySelectorAll("td");
                if (celdas.length < 3) return;
                let nombre = celdas[1]?.innerText.toLowerCase() || "";
                let doc = celdas[2]?.innerText.toLowerCase() || "";

                let visible = true;
                if (interno && !nombre.includes(interno)) visible = false;
                if (documento && !doc.includes(documento)) visible = false;

                fila.style.display = visible ? "" : "none";
                if (visible) algunaVisible = true;
            });

            if (!mostrarFundacion || !algunaVisible) {
                card.style.display = "none";
            } else {
                card.style.display = "";
            }
        });
    }

    filtroFundacion.addEventListener("keyup", aplicarFiltrosInternos);
    filtroInterno.addEventListener("keyup", aplicarFiltrosInternos);
    filtroDocumento.addEventListener("keyup", aplicarFiltrosInternos);

    function limpiarFiltrosInternos() {
        filtroFundacion.value = "";
        filtroInterno.value = "";
        filtroDocumento.value = "";
        aplicarFiltrosInternos();
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>