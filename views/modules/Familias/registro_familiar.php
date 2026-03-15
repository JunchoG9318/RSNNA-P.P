<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("../../../header.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="bg-light">
<div class="container-fluid bg-success bg-opacity-10 p-4 rounded-top-4">
    <!-- Breadcrumb de navegación -->
    <div class="row g-4">
        <!-- SIDEBAR - Estilo limpio sin animaciones -->
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

                    <!-- Menú de navegación sin efectos -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-success text-start py-3 px-3" 
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

                        <button class="btn btn-outline-secondary text-start py-3 px-3" 
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
                                <span class="fw-bold text-success">1/5</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Completado</small>
                                <span class="fw-bold text-success">20%</span>
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
                        
                        <!-- Información del perfil -->
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
                            <i class="bi bi-person-badge fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">REGISTRO DE INFORMACIÓN PERSONAL</h4>
                            <small class="opacity-75">
                                <i class="bi bi-calendar me-1"></i> <?php echo date('d/m/Y'); ?>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Barra de progreso simple -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success fw-bold">Progreso del registro</span>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-3">
                                20% completado
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 20%;"></div>
                        </div>
                    </div>

                    <!-- Alerta informativa simple -->
                    <div class="alert alert-success bg-opacity-10 border-success mb-4 py-3" role="alert">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-success me-3"></i>
                            <small>Complete todos los campos obligatorios marcados con <span class="text-danger">*</span></small>
                        </div>
                    </div>

                    <form class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- SECCIÓN: DATOS BÁSICOS -->
                            <div class="col-12">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-info-circle me-2"></i>DATOS BÁSICOS
                                    <span class="ms-3 badge bg-light text-success fw-normal rounded-3">Paso 1 de 5</span>
                                </h6>
                            </div>

                            <!-- Nombre y Apellidos -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person text-success me-1"></i>NOMBRE <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-person text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese nombres" required>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese el nombre</div>
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

                            <!-- Documento -->
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-text text-success me-1"></i>TIPO DE DOCUMENTO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-file-text text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione tipo</option>
                                        <option>CC - Cédula Ciudadanía</option>
                                        <option>TI - Tarjeta Identidad</option>
                                        <option>RC - Registro Civil</option>
                                        <option>CE - Cédula Extranjería</option>
                                        <option>PAS - Pasaporte</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-123 text-success me-1"></i>NUMERO DE DOCUMENTO <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-upc-scan text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese número de documento" required>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese el número de documento</div>
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

                            <!-- NACIONALIDAD / PARENTESCO -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-flag text-success me-1"></i>NACIONALIDAD
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-globe text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione nacionalidad</option>
                                        <option>Colombiana</option>
                                        <option>Venezolana</option>
                                        <option>Ecuatoriana</option>
                                        <option>Peruana</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-diagram-3 text-success me-1"></i>PARENTESCO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-people text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione parentesco</option>
                                        <option>Madre</option>
                                        <option>Padre</option>
                                        <option>Tío/a</option>
                                        <option>Abuelo/a</option>
                                        <option>Hermano/a</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECCIÓN: UBICACIÓN Y CONTACTO -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>UBICACIÓN Y CONTACTO
                                    <span class="ms-3 badge bg-light text-success fw-normal rounded-3">Paso 2 de 5</span>
                                </h6>
                            </div>

                            <!-- Dirección -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-house-door text-success me-1"></i>DIRECCIÓN ACTUAL
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-geo-alt-fill text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ingrese dirección completa">
                                </div>
                            </div>

                            <!-- Departamento / Ciudad -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-map text-success me-1"></i>DEPARTAMENTO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-map-fill text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione departamento</option>
                                        <option>Antioquia</option>
                                        <option>Cundinamarca</option>
                                        <option>Valle del Cauca</option>
                                        <option>Atlántico</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-building text-success me-1"></i>CIUDAD
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-building text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione ciudad</option>
                                        <option>Medellín</option>
                                        <option>Bogotá</option>
                                        <option>Cali</option>
                                        <option>Barranquilla</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Teléfono / Género -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-phone text-success me-1"></i>TELÉFONO CELULAR <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-whatsapp text-success"></i>
                                    </span>
                                    <input type="tel" class="form-control" placeholder="300 123 4567" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-gender-ambiguous text-success me-1"></i>GÉNERO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-gender-ambiguous text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option disabled selected>Seleccione género</option>
                                        <option>Femenino</option>
                                        <option>Masculino</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-success me-1"></i>CORREO ELECTRÓNICO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-envelope-fill text-success"></i>
                                    </span>
                                    <input type="email" class="form-control" placeholder="ejemplo@correo.com">
                                </div>
                                <small class="text-muted">Opcional, para notificaciones</small>
                            </div>

                            <!-- Teléfono fijo -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-telephone text-success me-1"></i>TELÉFONO FIJO
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-telephone-fill text-success"></i>
                                    </span>
                                    <input type="tel" class="form-control" placeholder="(604) 123 4567">
                                </div>
                            </div>

                            <!-- Ocupación -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-briefcase text-success me-1"></i>OCUPACIÓN
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-briefcase-fill text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Ej: Independiente">
                                </div>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mt-4 mb-3">
                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                            <label class="form-check-label small" for="termsCheck">
                                Confirmo que la información es verídica <span class="text-danger">*</span>
                            </label>
                            <div class="invalid-feedback">Debe aceptar los términos</div>
                        </div>

                        <!-- BOTONES DE ACCIÓN -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted small">
                                <i class="bi bi-shield-check text-success me-1"></i>
                                Datos protegidos
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger px-4 py-2" 
                                        onclick="location.href='<?php echo BASE_URL; ?>views/modules/ICBF/RegistrarUsuario.php'">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </button>
                                
                                <button type="button" class="btn btn-success px-4 py-2" 
                                        onclick="location.href='<?php echo BASE_URL; ?>views/modules/Familias/informacion_labor_fami.php'">
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

<!-- Validación de formularios -->
<script>
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

</body>
</html>

<?php
include("../../../footer.php");
?>