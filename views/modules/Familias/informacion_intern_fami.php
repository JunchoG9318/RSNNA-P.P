<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("../../../header.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="bg-light">
<div class="container-fluid py-4">
    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-success text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-success text-decoration-none">Familias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Información del Interno</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- SIDEBAR - Estilo consistente -->
        <div class="col-lg-3 col-xl-2">
            <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px; background: white;">
                <div class="card-body p-3">
                    <!-- Perfil/Logo superior -->
                    <div class="text-center mb-4">
                        <div class="bg-success bg-opacity-10 p-3 d-inline-block mb-2 rounded-3">
                            <i class="bi bi-people-fill text-success fs-1"></i>
                        </div>
                        <h6 class="fw-bold text-success mb-0">Módulo Familias</h6>
                        <small class="text-muted">Registro de familiares</small>
                    </div>

                    <!-- Menú de navegación -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary text-start py-3 px-3" 
                                type="button"
                                onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/registro_familiar.php'">
                            <i class="bi bi-person-circle me-2"></i>
                            INFORMACION PERSONAL
                        </button>

                        <button class="btn btn-outline-secondary text-start py-3 px-3" 
                                type="button"
                                onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/informacion_labor_fami.php'">
                            <i class="bi bi-briefcase me-2"></i>
                            INFORMACION LABORAL
                        </button>

                        <button class="btn btn-success text-start py-3 px-3" 
                                type="button"
                                onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/informacion_intern_fami.php'">
                            <i class="bi bi-people me-2"></i>
                            INFORMACION DEL INTERNO
                        </button>

                        <button class="btn btn-outline-secondary text-start py-3 px-3" 
                                type="button"
                                onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/detalles_ingre_fami.php'">
                            <i class="bi bi-door-open me-2"></i>
                            DETALLES INGRESO
                        </button>

                        <button class="btn btn-outline-secondary text-start py-3 px-3" 
                                type="button"
                                onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/documenta_famil.php'">
                            <i class="bi bi-file-text me-2"></i>
                            REGISTRO DOCUMENTACION
                        </button>
                    </div>

                    <!-- Separador -->
                    <hr class="my-4">

                    <!-- Estadísticas rápidas -->
                    <div class="row g-2 text-center mb-3">
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Pasos</small>
                                <span class="fw-bold text-success">3/5</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Completado</small>
                                <span class="fw-bold text-success">60%</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Estado</small>
                                <span class="fw-bold text-success">Activo</span>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen de perfil -->
                    <div class="text-center">
                        <div class="d-inline-block">
                            <div class="border border-2 border-success rounded-3 overflow-hidden mx-auto" 
                                 style="width: 100px; height: 100px;">
                                <img src="<?php echo BASE_URL; ?>imagenes/familia2.jpg"
                                     class="w-100 h-100"
                                     style="object-fit: cover;"
                                     alt="Perfil">
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p class="text-muted small mb-2">ID: FAM-2024-001</p>
                            <button class="btn btn-sm btn-outline-success rounded-3 px-3" 
                                    onclick="location.href='<?php echo BASE_URL; ?>views/modules/Perfil/ver_perfil.php'">
                                <i class="bi bi-eye me-1"></i> Ver perfil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMULARIO PRINCIPAL -->
        <div class="col-lg-9 col-xl-10">
            <div class="card shadow-sm border-0 rounded-3">
                <!-- Cabecera del formulario -->
                <div class="card-header bg-success text-white py-3 rounded-top-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                            <i class="bi bi-people-fill fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">INFORMACIÓN DEL INTERNO</h4>
                            <small class="opacity-75">
                                <i class="bi bi-calendar me-1"></i> <?php echo date('d/m/Y'); ?>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Barra de progreso -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success fw-bold">Progreso del registro</span>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-3">
                                60% completado
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 60%;"></div>
                        </div>
                    </div>

                    <!-- Alerta informativa -->
                    <div class="alert alert-success bg-opacity-10 border-success mb-4 py-3" role="alert">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-success me-3"></i>
                            <small>Complete todos los campos obligatorios marcados con <span class="text-danger">*</span></small>
                        </div>
                    </div>

                    <form class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- SECCIÓN 1: DATOS PERSONALES -->
                            <div class="col-12">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-person-badge me-2"></i>DATOS PERSONALES
                                    <span class="ms-3 badge bg-light text-success fw-normal rounded-3">Paso 3 de 5</span>
                                </h6>
                            </div>

                            <!-- Nombres y Apellidos -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person text-success me-1"></i>NOMBRES <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-person text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese nombres" required>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese los nombres</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person text-success me-1"></i>APELLIDOS <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-person text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese apellidos" required>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese los apellidos</div>
                            </div>

                            <!-- Fechas -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-date text-success me-1"></i>FECHA DE NACIMIENTO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-calendar text-success"></i>
                                    </span>
                                    <input type="date" class="form-control">
                                </div>
                                <small class="text-muted">Formato: DD/MM/AAAA</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-check text-success me-1"></i>FECHA DE EXPEDICIÓN
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-calendar text-success"></i>
                                    </span>
                                    <input type="date" class="form-control">
                                </div>
                            </div>

                            <!-- Tipo y Número de documento -->
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-text text-success me-1"></i>TIPO DE DOCUMENTO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-file-text text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option value="" disabled selected>Seleccione tipo</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="RC">Registro Civil</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PA">Pasaporte</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-123 text-success me-1"></i>NÚMERO DE DOCUMENTO <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-upc-scan text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese número de documento" required>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese el número de documento</div>
                            </div>

                            <!-- SECCIÓN 2: INFORMACIÓN FAMILIAR -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-diagram-3 me-2"></i>INFORMACIÓN FAMILIAR
                                </h6>
                            </div>

                            <!-- Nacionalidad y Parentesco -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-flag text-success me-1"></i>NACIONALIDAD
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-globe text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option value="" disabled selected>Seleccione nacionalidad</option>
                                        <option value="Colombiana">Colombiana</option>
                                        <option value="Venezolana">Venezolana</option>
                                        <option value="Ecuatoriana">Ecuatoriana</option>
                                        <option value="Peruana">Peruana</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-diagram-3 text-success me-1"></i>PARENTESCO <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-people text-success"></i>
                                    </span>
                                    <select class="form-select" required>
                                        <option value="" disabled selected>Seleccione parentesco</option>
                                        <option value="Hijo/a">Hijo/a</option>
                                        <option value="Nieto/a">Nieto/a</option>
                                        <option value="Sobrino/a">Sobrino/a</option>
                                        <option value="Hermano/a">Hermano/a</option>
                                        <option value="Primo/a">Primo/a</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Por favor seleccione el parentesco</div>
                            </div>

                            <!-- SECCIÓN 3: INFORMACIÓN DE SALUD -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-heart-pulse me-2"></i>INFORMACIÓN DE SALUD
                                </h6>
                            </div>

                            <!-- Género y Discapacidad -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-gender-ambiguous text-success me-1"></i>GÉNERO <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-gender-ambiguous text-success"></i>
                                    </span>
                                    <select class="form-select" required>
                                        <option value="" disabled selected>Seleccione género</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Por favor seleccione el género</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-heart-pulse text-success me-1"></i>DISCAPACIDAD
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-heart-pulse text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option value="" disabled selected>Seleccione discapacidad</option>
                                        <option value="Ninguna">Ninguna</option>
                                        <option value="Física">Física</option>
                                        <option value="Cognitiva">Cognitiva</option>
                                        <option value="Visual">Visual</option>
                                        <option value="Auditiva">Auditiva</option>
                                        <option value="Múltiple">Múltiple</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECCIÓN 4: OBSERVACIONES -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-pencil-square me-2"></i>OBSERVACIONES
                                </h6>
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-chat-text text-success me-1"></i>OBSERVACIONES ADICIONALES
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-chat-dots text-success"></i>
                                    </span>
                                    <textarea class="form-control" rows="3" placeholder="Ingrese observaciones adicionales sobre el interno..."></textarea>
                                </div>
                                <small class="text-muted">Información relevante sobre el estado, comportamiento o necesidades del interno</small>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mt-4 mb-3">
                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                            <label class="form-check-label small" for="termsCheck">
                                Confirmo que la información del interno es verídica y autorizo su tratamiento según la política de datos <span class="text-danger">*</span>
                            </label>
                            <div class="invalid-feedback">Debe aceptar los términos para continuar</div>
                        </div>

                        <!-- BOTONES DE ACCIÓN -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted small">
                                <i class="bi bi-shield-check text-success me-1"></i>
                                Datos protegidos - Ley 1581 de 2012
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger px-4 py-2" 
                                        onclick="location.href='<?php echo BASE_URL; ?>views/modules/ICBF/RegistrarUsuario.php'">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </button>
                                
                                <button type="button" class="btn btn-success px-4 py-2" 
                                        onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/detalles_ingre_fami.php'">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Siguiente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Validación de formularios mejorada -->
<script>
    (function() {
        'use strict';
        
        // Validación de formularios
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Mostrar mensaje de error general
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
                    alertDiv.setAttribute('role', 'alert');
                    alertDiv.innerHTML = `
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Por favor complete todos los campos requeridos correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const formCard = form.closest('.card-body');
                    const existingAlert = formCard.querySelector('.alert-danger');
                    if (!existingAlert) {
                        formCard.insertBefore(alertDiv, form);
                        
                        // Auto-cerrar después de 5 segundos
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.classList.remove('show');
                                setTimeout(() => alertDiv.remove(), 300);
                            }
                        }, 5000);
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    })();
</script>

<!-- Script original mantenido -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById("btnPersonal");
        if (btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                let tabTrigger = document.querySelector('[data-bs-target="#laboral"]');
                if (tabTrigger) {
                    let tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            });
        }
    });
</script>

</body>
</html>

<?php
include("../../../footer.php");
?>