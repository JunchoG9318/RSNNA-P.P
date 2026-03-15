<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
include("../../../header.php");
?>

<div class="container py-5">
    <div class="row align-items-center min-vh-80 g-4">

        <!-- ================================================ -->
        <!-- COLUMNA IZQUIERDA: DESCRIPCIÓN DEL SISTEMA      -->
        <!-- ================================================ -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100">
                
                <!-- Cabecera -->
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2"></i>Bienvenido al Sistema RSNNA
                    </h4>
                    <small class="text-white-50">Red de Seguimiento de NNA - ICBF</small>
                </div>

                <!-- Cuerpo de la tarjeta -->
                <div class="card-body p-4">

                    <!-- Descripción principal -->
                    <div class="bg-light p-4 rounded-4 mb-4 border-start border-success border-4">
                        <p class="mb-0 text-secondary fst-italic">
                            <i class="bi bi-quote text-success fs-4 me-2"></i>
                            Este sistema está diseñado para garantizar la protección integral
                            de los NNA mediante un trabajo coordinado entre el ICBF,
                            fundaciones aliadas y las familias.
                        </p>
                    </div>

                    <!-- Cards: ¿Quiénes participan? -->
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-people-fill text-success me-2"></i>¿Quiénes participan?
                    </h5>

                    <div class="row g-3 mb-4">
                        <!-- ICBF -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                                        <i class="bi bi-building text-success fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">ICBF</h6>
                                    <small class="text-muted d-block">Funcionarios del ICBF</small>
                                </div>
                            </div>
                        </div>

                        <!-- Fundación -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                                        <i class="bi bi-tree text-success fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Fundaciones</h6>
                                    <small class="text-muted d-block">Entidades aliadas</small>
                                </div>
                            </div>
                        </div>

                        <!-- Familia -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                                        <i class="bi bi-people text-success fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Familias</h6>
                                    <small class="text-muted d-block">Acudientes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Beneficios del sistema -->
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-star-fill text-success me-2"></i>Beneficios del sistema
                    </h5>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <!-- Beneficio 1 -->
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-check-lg text-success"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block">Seguimiento en tiempo real</span>
                                <small class="text-muted">Monitoreo continuo de NNA</small>
                            </div>
                        </div>

                        <!-- Beneficio 2 -->
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-check-lg text-success"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block">Coordinación interinstitucional</span>
                                <small class="text-muted">ICBF, Fundaciones y Familias</small>
                            </div>
                        </div>

                        <!-- Beneficio 3 -->
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-check-lg text-success"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block">Protección de datos</span>
                                <small class="text-muted">Ley 1581 de 2012</small>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje motivacional -->
                    <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center">
                        <i class="bi bi-heart-fill text-success me-2"></i>
                        <span class="text-dark">"Trabajando juntos por el bienestar de la niñez"</span>
                    </div>
                </div>

                <!-- Pie de tarjeta -->
                <div class="card-footer bg-light py-3 text-center border-0">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Sistema certificado ICBF - 2025
                    </small>
                </div>
            </div>
        </div>

        <!-- ================================================ -->
        <!-- COLUMNA DERECHA: FORMULARIO DE REGISTRO          -->
        <!-- ================================================ -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Cabecera -->
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-person-plus me-2"></i>Registro de Nuevo Usuario
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>

                <div class="card-body p-4">

                    <!-- ========== MENSAJES DE ERROR ========== -->
                    <?php if (isset($_GET["error"])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php
                            if ($_GET["error"] == 1) echo "Las contraseñas no coinciden";
                            if ($_GET["error"] == 2) echo "El correo ya está registrado";
                            if ($_GET["error"] == 3) echo "Error al registrar usuario";
                            if ($_GET["error"] == 4) echo "Debe seleccionar un tipo de usuario";
                            if ($_GET["error"] == 5) echo "Error de conexión con la base de datos";
                            if ($_GET["error"] == 6) echo "La tabla de usuarios no existe. Debe crearla primero.";
                            if (isset($_GET["detalle"])) echo "<br><small>" . htmlspecialchars($_GET["detalle"]) . "</small>";
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>

                    <!-- ========== MENSAJE DE ÉXITO ========== -->
                    <?php if (isset($_GET["success"])) { ?>
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>¡Cuenta creada con éxito!</strong><br>
                            Ahora puedes <a href="<?php echo BASE_URL; ?>views/modules/login/login.php" class="alert-link">iniciar sesión</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>

                    <!-- ========== FORMULARIO ========== -->
                    <form action="<?php echo BASE_URL; ?>views/modules/login/procesar_registro.php" method="POST">

                        <!-- SECCIÓN: TIPO DE USUARIO -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-success mb-3">
                                <i class="bi bi-people-fill me-2"></i>¿Qué tipo de usuario eres?
                            </label>

                            <div class="row g-3">
                                <!-- Opción ICBF -->
                                <div class="col-md-4">
                                    <div class="form-check card-option p-3 text-center border rounded-3">
                                        <input class="form-check-input d-none" type="radio" name="tipo_usuario"
                                            id="tipo_icbf" value="icbf" required>
                                        <label class="form-check-label w-100" for="tipo_icbf">
                                            <i class="bi bi-building fs-1 d-block text-success mb-2"></i>
                                            <span class="fw-bold">ICBF</span>
                                            <small class="d-block text-muted">Funcionario</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Opción Fundación -->
                                <div class="col-md-4">
                                    <div class="form-check card-option p-3 text-center border rounded-3">
                                        <input class="form-check-input d-none" type="radio" name="tipo_usuario"
                                            id="tipo_fundacion" value="fundacion" required>
                                        <label class="form-check-label w-100" for="tipo_fundacion">
                                            <i class="bi bi-tree fs-1 d-block text-success mb-2"></i>
                                            <span class="fw-bold">Fundación</span>
                                            <small class="d-block text-muted">Entidad aliada</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Opción Familia -->
                                <div class="col-md-4">
                                    <div class="form-check card-option p-3 text-center border rounded-3">
                                        <input class="form-check-input d-none" type="radio" name="tipo_usuario"
                                            id="tipo_familia" value="familia" required>
                                        <label class="form-check-label w-100" for="tipo_familia">
                                            <i class="bi bi-people-fill fs-1 d-block text-success mb-2"></i>
                                            <span class="fw-bold">Familia</span>
                                            <small class="d-block text-muted">Acudiente</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN: DATOS PERSONALES -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-circle text-success me-1"></i>Nombre Completo
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-person text-success"></i>
                                </span>
                                <input type="text" name="nombre_completo" class="form-control form-control-lg"
                                    placeholder="Ingrese su nombre completo" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope-fill text-success me-1"></i>Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-envelope text-success"></i>
                                </span>
                                <input type="email" name="correo" class="form-control form-control-lg"
                                    placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-telephone-fill text-success me-1"></i>Teléfono de Contacto
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-telephone text-success"></i>
                                </span>
                                <input type="tel" name="telefono" class="form-control form-control-lg"
                                    placeholder="3001234567" required>
                            </div>
                        </div>

                        <!-- SECCIÓN: CONTRASEÑA -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-lock-fill text-success me-1"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-lock text-success"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg" placeholder="Mínimo 6 caracteres" minlength="6"
                                    required>
                                <button class="btn btn-outline-success" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-lock-fill text-success me-1"></i>Confirmar Contraseña
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-lock text-success"></i>
                                </span>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control form-control-lg" placeholder="Repita la contraseña"
                                    minlength="6" required>
                            </div>
                            <small id="passwordHelp" class="text-muted"></small>
                        </div>

                        <!-- SECCIÓN: TÉRMINOS Y CONDICIONES -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terminos" required>
                            <label class="form-check-label small" for="terminos">
                                Acepto los <a href="#" class="text-success">términos y condiciones</a> y la
                                <a href="#" class="text-success">política de tratamiento de datos</a> del ICBF
                            </label>
                        </div>

                        <!-- SECCIÓN: BOTONES -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3" id="btnRegistro">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Crear cuenta
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <span class="text-muted">¿Ya tienes cuenta?</span>
                            <a href="<?php echo BASE_URL; ?>views/modules/login/login.php"
                                class="text-success fw-bold ms-1">Inicia sesión aquí</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional debajo del formulario -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Tus datos están protegidos según la Ley 1581 de 2012
                </small>
            </div>
        </div>
    </div>
</div>

<!-- ================================================ -->
<!-- ESTILOS PERSONALIZADOS                           -->
<!-- ================================================ -->
<style>
    .card-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .card-option:hover {
        border-color: #006341 !important;
        background-color: rgba(0, 99, 65, 0.05);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 99, 65, 0.2);
    }
    .card-option.selected {
        border-color: #006341 !important;
        background-color: rgba(0, 99, 65, 0.1);
    }
    .bg-success {
        background-color: #006341 !important;
    }
    .text-success {
        color: #006341 !important;
    }
    .btn-success {
        background-color: #006341;
        border-color: #006341;
    }
    .btn-success:hover {
        background-color: #004d33;
        border-color: #004d33;
    }
    .min-vh-80 {
        min-height: 80vh;
    }
</style>

<!-- ================================================ -->
<!-- SCRIPTS DE FUNCIONALIDAD                          -->
<!-- ================================================ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Mostrar/ocultar contraseña
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // 2. Validar que las contraseñas coincidan
        const confirmPassword = document.getElementById('confirm_password');
        const passwordHelp = document.getElementById('passwordHelp');
        const btnRegistro = document.getElementById('btnRegistro');

        function validarContraseñas() {
            if (confirmPassword.value === '') {
                passwordHelp.textContent = '';
                btnRegistro.disabled = false;
            } else if (password.value === confirmPassword.value) {
                passwordHelp.textContent = '✓ Las contraseñas coinciden';
                passwordHelp.style.color = '#006341';
                btnRegistro.disabled = false;
            } else {
                passwordHelp.textContent = '✗ Las contraseñas no coinciden';
                passwordHelp.style.color = '#dc3545';
                btnRegistro.disabled = true;
            }
        }

        password.addEventListener('keyup', validarContraseñas);
        confirmPassword.addEventListener('keyup', validarContraseñas);

        // 3. Selección de tipo de usuario con estilo visual
        const opciones = document.querySelectorAll('.card-option');
        opciones.forEach(opcion => {
            opcion.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;

                opciones.forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
    });
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php
include("../../../footer.php");
?>