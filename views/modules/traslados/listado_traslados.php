<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Traslados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Traslados</h4>
                            <a href="index.php?action=traslado_form" class="btn btn-light">
                                <i class="fas fa-plus"></i> Nuevo Traslado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Filtros -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border-secondary">
                                    <div class="card-header bg-secondary text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="GET" action="index.php" class="row g-3">
                                            <input type="hidden" name="action" value="ver_traslados">
                                            
                                            <div class="col-md-3">
                                                <label class="form-label">Fecha Inicio</label>
                                                <input type="date" class="form-control" name="fecha_inicio" 
                                                       value="<?php echo $_GET['fecha_inicio'] ?? ''; ?>">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label class="form-label">Fecha Fin</label>
                                                <input type="date" class="form-control" name="fecha_fin" 
                                                       value="<?php echo $_GET['fecha_fin'] ?? ''; ?>">
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">Fundación</label>
                                                <select class="form-select" name="fundacion_id">
                                                    <option value="">Todas las fundaciones</option>
                                                    <?php foreach ($fundaciones as $fundacion): ?>
                                                        <option value="<?php echo $fundacion['id']; ?>"
                                                            <?php echo (isset($_GET['fundacion_id']) && $_GET['fundacion_id'] == $fundacion['id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($fundacion['nombre']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-search"></i> Filtrar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de traslados -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tablaTraslados">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Interno</th>
                                        <th>Fundación Origen</th>
                                        <th>Fundación Destino</th>
                                        <th>Lugar</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($traslados)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No hay traslados registrados</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($traslados as $traslado): ?>
                                            <tr>
                                                <td><?php echo $traslado['id']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($traslado['fecha_traslado'])); ?></td>
                                                <td>
                                                    <?php echo htmlspecialchars($traslado['interno_nombre'] . ' ' . $traslado['interno_apellido']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($traslado['fundacion_origen_nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($traslado['fundacion_destino_nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($traslado['lugar_traslado']); ?></td>
                                                <td>
                                                    <?php 
                                                    $badgeClass = '';
                                                    switch($traslado['estado']) {
                                                        case 'completado':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'pendiente':
                                                            $badgeClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'cancelado':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $badgeClass; ?>">
                                                        <?php echo ucfirst($traslado['estado']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info" 
                                                            onclick="verDetalle(<?php echo $traslado['id']; ?>)"
                                                            title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if ($traslado['estado'] == 'pendiente'): ?>
                                                        <button type="button" class="btn btn-sm btn-success"
                                                                onclick="completarTraslado(<?php echo $traslado['id']; ?>)"
                                                                title="Completar traslado">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div class="modal fade" id="modalDetalle" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Detalles del Traslado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detalleTraslado">
                    <!-- Contenido cargado vía AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#tablaTraslados').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[1, 'desc']]
            });
        });

        function verDetalle(id) {
            // Aquí implementarías la llamada AJAX para obtener los detalles
            $.ajax({
                url: 'index.php?action=detalle_traslado',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    $('#detalleTraslado').html(response);
                    $('#modalDetalle').modal('show');
                }
            });
        }

        function completarTraslado(id) {
            if (confirm('¿Está seguro de marcar este traslado como completado?')) {
                $.ajax({
                    url: 'index.php?action=completar_traslado',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>