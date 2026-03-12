<?php
// Verificar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Traslado de Interno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Registrar Traslado de Interno</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($_SESSION['mensaje'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show">
                                <?php 
                                echo $_SESSION['mensaje'];
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?action=procesar_traslado" method="POST" id="formTraslado">
                            
                            <!-- Fundación de Origen -->
                            <div class="mb-3">
                                <label for="fundacion_origen" class="form-label required-field">Fundación de Origen</label>
                                <select class="form-select" id="fundacion_origen" name="fundacion_origen_id" required>
                                    <option value="">Seleccione fundación de origen</option>
                                    <?php foreach ($fundaciones as $fundacion): ?>
                                        <option value="<?php echo $fundacion['id']; ?>">
                                            <?php echo htmlspecialchars($fundacion['nombre'] . ' - ' . $fundacion['ciudad']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Interno a trasladar -->
                            <div class="mb-3">
                                <label for="interno" class="form-label required-field">Interno a Trasladar</label>
                                <select class="form-select" id="interno" name="interno_id" required disabled>
                                    <option value="">Primero seleccione fundación de origen</option>
                                </select>
                                <div id="loadingInternos" style="display: none;" class="text-info mt-1">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando internos...
                                </div>
                            </div>

                            <!-- Fundación de Destino -->
                            <div class="mb-3">
                                <label for="fundacion_destino" class="form-label required-field">Fundación que Recibe</label>
                                <select class="form-select" id="fundacion_destino" name="fundacion_destino_id" required>
                                    <option value="">Seleccione fundación destino</option>
                                    <?php foreach ($fundaciones as $fundacion): ?>
                                        <option value="<?php echo $fundacion['id']; ?>">
                                            <?php echo htmlspecialchars($fundacion['nombre'] . ' - ' . $fundacion['ciudad']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Fecha y Lugar de Traslado -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_traslado" class="form-label required-field">Fecha de Traslado</label>
                                    <input type="date" class="form-control" id="fecha_traslado" 
                                           name="fecha_traslado" required 
                                           value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lugar_traslado" class="form-label required-field">Lugar de Traslado</label>
                                    <input type="text" class="form-control" id="lugar_traslado" 
                                           name="lugar_traslado" required 
                                           placeholder="Ej: Sede Principal, Centro de la ciudad">
                                </div>
                            </div>

                            <!-- Motivo y Responsable -->
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="motivo_traslado" class="form-label">Motivo del Traslado</label>
                                    <input type="text" class="form-control" id="motivo_traslado" 
                                           name="motivo_traslado" 
                                           placeholder="Ej: Traslado por reubicación familiar">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="responsable_traslado" class="form-label">Responsable</label>
                                    <input type="text" class="form-control" id="responsable_traslado" 
                                           name="responsable_traslado" 
                                           placeholder="Nombre del responsable">
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" 
                                          name="observaciones" rows="3" 
                                          placeholder="Información adicional relevante..."></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?action=ver_traslados" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Registrar Traslado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Cargar internos cuando se selecciona fundación de origen
            $('#fundacion_origen').change(function() {
                var fundacionId = $(this).val();
                
                if (fundacionId) {
                    $('#interno').prop('disabled', true);
                    $('#loadingInternos').show();
                    
                    $.ajax({
                        url: 'index.php?action=obtener_internos_ajax',
                        type: 'POST',
                        data: { fundacion_id: fundacionId },
                        dataType: 'json',
                        success: function(data) {
                            $('#interno').empty();
                            $('#interno').append('<option value="">Seleccione interno a trasladar</option>');
                            
                            $.each(data, function(index, interno) {
                                $('#interno').append('<option value="' + interno.id + '">' + 
                                    interno.nombre + ' ' + interno.apellido + ' - ' + 
                                    interno.documento + '</option>');
                            });
                            
                            $('#interno').prop('disabled', false);
                            $('#loadingInternos').hide();
                        },
                        error: function() {
                            alert('Error al cargar los internos');
                            $('#loadingInternos').hide();
                        }
                    });
                } else {
                    $('#interno').empty();
                    $('#interno').append('<option value="">Primero seleccione fundación de origen</option>');
                    $('#interno').prop('disabled', true);
                }
            });

            // Validar que la fundación destino sea diferente a la origen
            $('#fundacion_destino').change(function() {
                var origen = $('#fundacion_origen').val();
                var destino = $(this).val();
                
                if (origen && destino && origen === destino) {
                    alert('La fundación de destino debe ser diferente a la de origen');
                    $(this).val('');
                }
            });

            $('#fundacion_origen').change(function() {
                var origen = $(this).val();
                var destino = $('#fundacion_destino').val();
                
                if (origen && destino && origen === destino) {
                    $('#fundacion_destino').val('');
                }
            });

            // Validación del formulario
            $('#formTraslado').submit(function(e) {
                var origen = $('#fundacion_origen').val();
                var destino = $('#fundacion_destino').val();
                
                if (origen === destino) {
                    e.preventDefault();
                    alert('La fundación de destino no puede ser la misma que la de origen');
                }
            });
        });
    </script>
</body>
</html>