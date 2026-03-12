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
                        <i class="bi bi-people-fill me-2"></i>Funcionarios por Fundación
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-building me-2"></i>
                        Listado de funcionarios registrados en cada fundación
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

            <!-- Mensaje informativo -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                A continuación se muestran todas las fundaciones con sus respectivos funcionarios registrados.
                Cada fundación tiene su propia tabla con los datos completos de cada funcionario.
            </div>

            <!-- PANEL DE FILTROS (adaptado de internos, sin botón) -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-funnel me-2"></i>Filtrar Funcionarios
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" id="filtroFundacion" class="form-control" placeholder="Buscar por fundación">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="filtroNombre" class="form-control" placeholder="Buscar por nombre del funcionario">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="filtroDocumento" class="form-control" placeholder="Buscar por documento">
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> Los resultados se actualizan automáticamente al escribir.
                    </small>
                </div>
            </div>

            <?php
            // Obtener todas las fundaciones activas
            $query_fundaciones = "SELECT f.*, 
                                  (SELECT COUNT(*) FROM funcionarios WHERE id_fundacion = f.id) as total_funcionarios
                                  FROM fundaciones f 
                                  WHERE f.estado = 1 
                                  ORDER BY f.nombre ASC";
            $result_fundaciones = mysqli_query($conexion, $query_fundaciones);

            if (!$result_fundaciones) {
                echo '<div class="alert alert-danger">Error al cargar las fundaciones: ' . mysqli_error($conexion) . '</div>';
            } else {
                $total_fundaciones = mysqli_num_rows($result_fundaciones);

                if ($total_fundaciones == 0) {
                    echo '<div class="alert alert-warning text-center py-5">
                            <i class="bi bi-building fs-1 text-muted d-block mb-3"></i>
                            <h5>No hay fundaciones registradas</h5>
                            <p class="text-muted">Espera a que se registren fundaciones en el sistema</p>
                          </div>';
                } else {

                    while ($fundacion = mysqli_fetch_assoc($result_fundaciones)):

                        $query_funcionarios = "SELECT * FROM funcionarios 
                                              WHERE id_fundacion = " . $fundacion['id'] . " 
                                              ORDER BY apellidos, nombre ASC";
                        $result_funcionarios = mysqli_query($conexion, $query_funcionarios);
                        $total_funcionarios_fundacion = mysqli_num_rows($result_funcionarios);
            ?>

            <!-- Tarjeta para cada fundación -->
            <div class="card fundacion-card border-0 shadow-lg rounded-4 mb-5" data-fundacion-nombre="<?php echo htmlspecialchars(strtolower($fundacion['nombre'])); ?>">
                <div class="card-header bg-success text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-building me-2"></i><?php echo htmlspecialchars($fundacion['nombre']); ?>
                        </h5>
                        <small class="text-white-50">
                            NIT: <?php echo htmlspecialchars($fundacion['nit']); ?> | 
                            Director: <?php echo htmlspecialchars($fundacion['nombre_director']); ?>
                        </small>
                    </div>
                    <span class="badge bg-white text-success px-3 py-2 total-funcionarios-badge">
                        <i class="bi bi-people-fill me-1"></i>
                        <?php echo $total_funcionarios_fundacion; ?> funcionario(s)
                    </span>
                </div>

                <div class="card-body p-0">

                    <?php if ($total_funcionarios_fundacion > 0): ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="py-3">Nombre Completo</th>
                                    <th class="py-3">Tipo Doc.</th>
                                    <th class="py-3">N° Documento</th>
                                    <th class="py-3">Cargo</th>
                                    <th class="py-3">Correo Electrónico</th>
                                    <th class="py-3">Teléfono/Celular</th>
                                    <th class="py-3">Género</th>
                                    <th class="py-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 1;
                                while ($funcionario = mysqli_fetch_assoc($result_funcionarios)):
                                ?>
                                <tr class="funcionario-fila">
                                    <td class="px-4"><?php echo $contador++; ?></td>

                                    <td class="col-nombre">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-person-circle text-success"></i>
                                            </div>
                                            <strong><?php echo htmlspecialchars($funcionario['nombre'] . ' ' . $funcionario['apellidos']); ?></strong>
                                        </div>
                                    </td>

                                    <td><?php echo htmlspecialchars($funcionario['tipo_documento'] ?: 'N/A'); ?></td>

                                    <td class="col-documento"><?php echo htmlspecialchars($funcionario['documento'] ?: 'N/A'); ?></td>

                                    <td class="col-cargo">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            <?php echo htmlspecialchars($funcionario['cargo'] ?: 'No especificado'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if (!empty($funcionario['correo'])): ?>
                                            <a href="mailto:<?php echo htmlspecialchars($funcionario['correo']); ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope text-success me-1"></i>
                                                <?php echo htmlspecialchars($funcionario['correo']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($funcionario['celular'])): ?>
                                            <a href="tel:<?php echo htmlspecialchars($funcionario['celular']); ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone text-success me-1"></i>
                                                <?php echo htmlspecialchars($funcionario['celular']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $genero = $funcionario['genero'] ?? 'O';
                                        if ($genero == 'M') {
                                            echo '<span class="badge bg-info bg-opacity-10 text-info px-3 py-2">Masculino</span>';
                                        } elseif ($genero == 'F') {
                                            echo '<span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">Femenino</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">Otro</span>';
                                        }
                                        ?>
                                    </td>

                                    <td class="col-estado">
                                        <?php if ($funcionario['estado'] == 1): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php else: ?>
                    <div class="text-center py-5 mensaje-sin-funcionarios">
                        <i class="bi bi-person-slash fs-1 text-muted d-block mb-3"></i>
                        <h6 class="text-muted">Esta fundación no tiene funcionarios registrados</h6>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="card-footer bg-light py-2 px-4 text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    Última actualización: <?php echo date('d/m/Y H:i', strtotime($fundacion['fecha_actualizacion'])); ?>
                </div>
            </div>

            <?php
                    endwhile;
                }
            }
            ?>

        </div>
    </div>
</div>

<!-- SCRIPT DE FILTRADO (fundación, nombre, documento) - sin botón -->
<script>
(function() {
    // Elementos del filtro
    const filtroFundacion = document.getElementById('filtroFundacion');
    const filtroNombre = document.getElementById('filtroNombre');
    const filtroDocumento = document.getElementById('filtroDocumento');

    function aplicarFiltros() {
        const textoFundacion = filtroFundacion.value.trim().toLowerCase();
        const textoNombre = filtroNombre.value.trim().toLowerCase();
        const textoDocumento = filtroDocumento.value.trim().toLowerCase();

        // Seleccionar todas las tarjetas de fundación
        const tarjetas = document.querySelectorAll('.fundacion-card');

        tarjetas.forEach(tarjeta => {
            // Nombre de la fundación (en minúsculas) almacenado en data-fundacion-nombre
            const nombreFundacion = tarjeta.dataset.fundacionNombre || '';

            // Verificar si la fundación coincide con el filtro
            const coincideFundacion = textoFundacion === '' || nombreFundacion.includes(textoFundacion);

            // Filas de funcionarios dentro de esta tarjeta
            const filas = tarjeta.querySelectorAll('tbody tr');
            const mensajeVacio = tarjeta.querySelector('.mensaje-sin-funcionarios');

            // Si no hay filas, la tarjeta se muestra solo si coincide la fundación (y no hay otros filtros)
            if (filas.length === 0) {
                tarjeta.style.display = coincideFundacion ? '' : 'none';
                return;
            }

            let algunaVisible = false;

            filas.forEach(fila => {
                // Obtener texto de las celdas específicas
                const nombreTexto = fila.querySelector('.col-nombre')?.innerText.toLowerCase() || '';
                const documentoTexto = fila.querySelector('.col-documento')?.innerText.toLowerCase() || '';

                let visible = true;

                // Filtro por nombre de funcionario
                if (textoNombre && !nombreTexto.includes(textoNombre)) {
                    visible = false;
                }

                // Filtro por documento
                if (textoDocumento && !documentoTexto.includes(textoDocumento)) {
                    visible = false;
                }

                // Mostrar u ocultar la fila
                fila.style.display = visible ? '' : 'none';
                if (visible) algunaVisible = true;
            });

            // Mostrar u ocultar la tarjeta completa:
            // - Debe coincidir el filtro de fundación
            // - Debe haber al menos una fila visible (si hay filas)
            tarjeta.style.display = (coincideFundacion && algunaVisible) ? '' : 'none';
        });
    }

    // Asignar eventos en tiempo real
    filtroFundacion.addEventListener('keyup', aplicarFiltros);
    filtroNombre.addEventListener('keyup', aplicarFiltros);
    filtroDocumento.addEventListener('keyup', aplicarFiltros);

    // Aplicar filtros al cargar la página (por si hay valores por defecto)
    aplicarFiltros();
})();
</script>

<!-- Estilos personalizados -->
<style>
    .bg-success {
        background-color: #006341 !important;
    }
    .bg-success.bg-opacity-10 {
        background-color: rgba(0, 99, 65, 0.1) !important;
    }
    .text-success {
        color: #006341 !important;
    }
    /* Transición suave al ocultar tarjetas */
    .fundacion-card {
        transition: opacity 0.2s ease;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>