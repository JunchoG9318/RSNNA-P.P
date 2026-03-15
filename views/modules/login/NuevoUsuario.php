<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
connection_status();
include("../../../header.php");
// session_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Cabecera -->
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-person-plus me-2"></i>Registro de Nuevo Usuario
                    </h4>
                    <small class="text-white-50">Sistema RSNNA</small>
                </div>

                <div class="card-body p-4">

                    <!-- Mensajes de error -->
                    <?php if (isset($_GET["error"])) { ?>
                    <div class="alert alert-danger text-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php 
                                if($_GET["error"] == 1) echo "Las contraseñas no coinciden";
                                if($_GET["error"] == 2) echo "El correo ya está registrado";
                                if($_GET["error"] == 3) echo "Error al registrar usuario";
                                if($_GET["error"] == 4) echo "Debe seleccionar un tipo de usuario";
                            ?>
                    </div>
                    <?php } ?>

                    <!-- Mensaje de éxito -->
                    <?php if (isset($_GET["success"])) { ?>
                    <div class="alert alert-success text-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        ¡Registro exitoso! Ahora puedes <a href="login.php" class="alert-link">iniciar sesión</a>
                    </div>
                    <?php } ?>

                    <form action="procesar_registro.php" method="POST">

                        <!-- TIPO DE USUARIO - Opciones en tarjetas -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-success mb-3">
                                <i class="bi bi-people-fill me-2"></i>¿Qué tipo de usuario eres?
                            </label>

                            <div class="row g-3">
                                <!-- Opción ICBF -->
                                <div class="col-md-4">
                                    <div
                                        class="form-check card-option p-3 text-center border rounded-3 <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'icbf') ? 'border-success bg-success bg-opacity-10' : ''; ?>">
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
                                    <div
                                        class="form-check card-option p-3 text-center border rounded-3 <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'fundacion') ? 'border-success bg-success bg-opacity-10' : ''; ?>">
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
                                    <div
                                        class="form-check card-option p-3 text-center border rounded-3 <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'familia') ? 'border-success bg-success bg-opacity-10' : ''; ?>">
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

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope-fill text-success me-1"></i>Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-envelope text-success"></i>
                                </span>
                                <input type="email" name="correo" class="form-control form-control-lg"
                                    placeholder="ejemplo@correo.com"
                                    value="<?php echo isset($_GET['correo']) ? htmlspecialchars($_GET['correo']) : ''; ?>"
                                    required>
                            </div>
                        </div>

                        <!-- Contraseña -->
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

                        <!-- Confirmar Contraseña -->
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

                        <!-- Términos y condiciones -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terminos" required>
                            <label class="form-check-label small" for="terminos">
                                Acepto los <a href="#" class="text-success">términos y condiciones</a> y la
                                <a href="#" class="text-success">política de tratamiento de datos</a> del ICBF
                            </label>
                        </div>

                        <!-- Botón de registro -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3" id="btnRegistro">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Crear cuenta
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <span class="text-muted">¿Ya tienes cuenta?</span>
                            <a href="<?php echo BASE_URL; ?>views\modules\login\login.php"
                                class="text-success fw-bold ms-1">Inicia sesión
                                aquí</a>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Tus datos están protegidos según la Ley 1581 de 2012
                </small>
            </div>

        </div>
    </div>
</div>

<!-- Estilos personalizados -->
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

.card-option input:checked+label {
    color: #006341;
}

input:checked+label i {
    transform: scale(1.1);
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
</style>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    // Validar contraseñas
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

    // Selección de tipo de usuario con estilo
    const opciones = document.querySelectorAll('.card-option');
    opciones.forEach(opcion => {
        opcion.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            opciones.forEach(opt => {
                opt.classList.remove('border-success', 'bg-success', 'bg-opacity-10');
            });
            this.classList.add('border-success', 'bg-success', 'bg-opacity-10');
        });
    });
});
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php
include("../../../footer.php");
?>