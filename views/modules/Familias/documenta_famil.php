<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("../../../header.php");
?>

<body class="bg-light">
<div class="container-fluid py-4">
    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-success text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-success text-decoration-none">Familias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registro Documentación</li>
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

                        <button class="btn btn-success text-start py-3 px-3" 
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
                                <span class="fw-bold text-success">5/5</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Completado</small>
                                <span class="fw-bold text-success">100%</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light p-2 rounded-3">
                                <small class="text-muted d-block">Estado</small>
                                <span class="fw-bold text-success">Final</span>
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
                            <i class="bi bi-file-text fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">REGISTRO DE DOCUMENTACIÓN</h4>
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
                                100% completado
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
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
                            <!-- SECCIÓN: DOCUMENTOS DE IDENTIDAD -->
                            <div class="col-12">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-file-earmark-text me-2"></i>DOCUMENTOS DE IDENTIDAD
                                    <span class="ms-3 badge bg-light text-success fw-normal rounded-3">Paso 5 de 5</span>
                                </h6>
                            </div>

                            <!-- Documento identidad padres o responsables -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-earmark-person text-success me-1"></i>DOCUMENTO IDENTIDAD PADRES O RESPONSABLES <span class="text-danger">*</span>
                                </label>
                                <input type="file" id="doc_padres" class="d-none">
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-file-earmark text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Seleccione archivo" readonly id="doc_padres_text" required>
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('doc_padres').click();">
                                        <i class="bi bi-upload me-2"></i>Subir o adjuntar
                                    </button>
                                </div>
                                <div class="invalid-feedback">Por favor suba el documento de identidad</div>
                                <small class="text-muted">Formatos permitidos: PDF, JPG, PNG (Máx. 5MB)</small>
                            </div>

                            <!-- SECCIÓN: DOCUMENTOS CIVILES -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-file-earmark-text me-2"></i>DOCUMENTOS CIVILES
                                </h6>
                            </div>

                            <!-- Registro civil -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-earmark-text text-success me-1"></i>REGISTRO CIVIL <span class="text-danger">*</span>
                                </label>
                                <input type="file" id="reg_civil" class="d-none">
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-file-earmark-text text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Seleccione archivo" readonly id="reg_civil_text" required>
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('reg_civil').click();">
                                        <i class="bi bi-upload me-2"></i>Subir o adjuntar
                                    </button>
                                </div>
                                <div class="invalid-feedback">Por favor suba el registro civil</div>
                                <small class="text-muted">Formatos permitidos: PDF, JPG, PNG (Máx. 5MB)</small>
                            </div>

                            <!-- SECCIÓN: INFORMACIÓN COMPLEMENTARIA -->
                            <div class="col-12 mt-3">
                                <h6 class="text-success border-start border-3 border-success ps-3 py-1 mb-3">
                                    <i class="bi bi-info-circle me-2"></i>INFORMACIÓN COMPLEMENTARIA
                                </h6>
                            </div>

                            <!-- Estado de salud -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-heart-pulse text-success me-1"></i>ESTADO DE SALUD
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-heart text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option value="" disabled selected>Seleccione estado</option>
                                        <option value="Saludable">Saludable</option>
                                        <option value="En tratamiento">En tratamiento</option>
                                        <option value="Enfermedad">Enfermedad</option>
                                        <option value="Discapacidad">Discapacidad</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Institución -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-building text-success me-1"></i>INSTITUCIÓN
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-bank text-success"></i>
                                    </span>
                                    <select class="form-select">
                                        <option value="" disabled selected>Seleccione institución</option>
                                        <option value="ICBF">ICBF</option>
                                        <option value="Comisaria">Comisaría</option>
                                        <option value="Policia">Policía</option>
                                        <option value="Fiscalia">Fiscalía</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campo adicional: Documentos adicionales -->
                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-files text-success me-1"></i>DOCUMENTOS ADICIONALES
                                </label>
                                <input type="file" id="doc_adicionales" class="d-none" multiple>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-files text-success"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Seleccione archivos adicionales" readonly id="doc_adicionales_text">
                                    <button type="button" class="btn btn-outline-success" onclick="document.getElementById('doc_adicionales').click();">
                                        <i class="bi bi-upload me-2"></i>Adjuntar
                                    </button>
                                </div>
                                <small class="text-muted">Puede seleccionar múltiples archivos (Opcional)</small>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mt-4 mb-3">
                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                            <label class="form-check-label small" for="termsCheck">
                                Confirmo que la documentación adjunta es verídica y autorizo su tratamiento según la política de datos <span class="text-danger">*</span>
                            </label>
                            <div class="invalid-feedback">Debe aceptar los términos para finalizar</div>
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
                                        onclick="location.href='<?php echo BASE_URL; ?>finalizar.php'">
                                    <i class="bi bi-check-circle me-2"></i>Finalizar
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
<link rel="stylesheet" href="CSS/bootstrap-icons.min.css">

<!-- Bootstrap 5 JS -->
<script src="js/bootstrap.bundle.min.js"></script>

<!-- Script para manejo de archivos -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Documento padres
        document.getElementById('doc_padres').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('doc_padres_text').value = fileName;
            
            // Validar campo requerido
            if (this.files.length > 0) {
                document.getElementById('doc_padres_text').classList.remove('is-invalid');
            }
        });

        // Registro civil
        document.getElementById('reg_civil').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('reg_civil_text').value = fileName;
            
            // Validar campo requerido
            if (this.files.length > 0) {
                document.getElementById('reg_civil_text').classList.remove('is-invalid');
            }
        });

        // Documentos adicionales (múltiples)
        document.getElementById('doc_adicionales').addEventListener('change', function() {
            let fileNames = [];
            for (let i = 0; i < this.files.length; i++) {
                fileNames.push(this.files[i].name);
            }
            document.getElementById('doc_adicionales_text').value = fileNames.join(', ') || '';
        });
    });
</script>

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
                    
                    // Validar campos de archivo requeridos
                    const docPadres = document.getElementById('doc_padres');
                    const regCivil = document.getElementById('reg_civil');
                    
                    if (docPadres.files.length === 0) {
                        document.getElementById('doc_padres_text').classList.add('is-invalid');
                    }
                    
                    if (regCivil.files.length === 0) {
                        document.getElementById('reg_civil_text').classList.add('is-invalid');
                    }
                    
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
    })();
</script>

</body>


<?php
include("../../../footer.php");
?>