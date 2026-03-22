<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/Navegacion/dashboard.php");
    exit();
}

include("../../../header.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Cabecera -->
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>

                <div class="card-body p-4">

                    <!-- Mensaje de restablecimiento exitoso -->
                    <?php if (isset($_SESSION['mensaje_reset'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo $_SESSION['mensaje_reset']; unset($_SESSION['mensaje_reset']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>

                    <!-- Mensajes de error -->
                    <?php if (isset($_GET["error"])) { ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php 
                            if($_GET["error"] == 1) echo "Correo o contraseña incorrectos";
                            if($_GET["error"] == 2) echo "Usuario inactivo. Contacte al administrador";
                            if($_GET["error"] == 3) echo "Error de conexión con la base de datos";
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>

                    <!-- Mensaje de sesión cerrada -->
                    <?php if (isset($_GET["logout"])) { ?>
                    <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Has cerrado sesión correctamente
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>

                    <!-- Mensaje de registro exitoso -->
                    <?php if (isset($_GET["registro"])) { ?>
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        ¡Registro exitoso! Ahora puedes iniciar sesión
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>

                    <form action="validar_login.php" method="POST">

                        <!-- Correo Electrónico -->
                        <div class="mb-4">
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

                        <!-- Contraseña -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-lock-fill text-success me-1"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-lock text-success"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg" placeholder="Ingrese su contraseña" required>
                                <button class="btn btn-outline-success" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botón de login -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Ingresar al Sistema
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <span class="text-muted">¿No tienes cuenta?</span>
                            <a href="<?php echo BASE_URL; ?>views/modules/login/registro.php"
                                class="text-success fw-bold ms-1">Regístrate aquí</a>
                        </div>

                        <div class="text-center mt-2">
                            <a href="recuperar_password.php" class="text-muted small">¿Olvidaste tu contraseña?</a>
                        </div>

                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light text-center py-3 border-0">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Instituto Colombiano de Bienestar Familiar
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    }
});
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php
include("../../../footer.php");
?>