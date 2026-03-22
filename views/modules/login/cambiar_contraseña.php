<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Verificar que el usuario está logueado para cambiar contraseña
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
require_once("../../../config/conexion.php");

$mensaje = '';
$tipo_mensaje = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';
    
    // Validaciones básicas
    if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
        $mensaje = 'Todos los campos son obligatorios';
        $tipo_mensaje = 'danger';
    } elseif ($password_nueva !== $password_confirmar) {
        $mensaje = 'Las contraseñas nuevas no coinciden';
        $tipo_mensaje = 'danger';
    } elseif (strlen($password_nueva) < 6) {
        $mensaje = 'La nueva contraseña debe tener al menos 6 caracteres';
        $tipo_mensaje = 'danger';
    } else {
        // Verificar contraseña actual
        $usuario_id = $_SESSION['usuario_id'];
        $query = "SELECT password FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        
        if (password_verify($password_actual, $usuario['password'])) {
            // Actualizar contraseña
            $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            $update = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt_update = $conexion->prepare($update);
            $stmt_update->bind_param("si", $password_hash, $usuario_id);
            
            if ($stmt_update->execute()) {
                $mensaje = 'Contraseña actualizada exitosamente';
                $tipo_mensaje = 'success';
            } else {
                $mensaje = 'Error al actualizar la contraseña';
                $tipo_mensaje = 'danger';
            }
        } else {
            $mensaje = 'La contraseña actual no es correcta';
            $tipo_mensaje = 'danger';
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-key me-2"></i>Cambiar Contraseña
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-<?php echo $tipo_mensaje == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill me-2"></i>
                            <?php echo $mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="bg-light p-3 rounded-3 mb-4 text-center">
                        <i class="bi bi-person-circle fs-1 text-success"></i>
                        <h6 class="fw-bold mt-2"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?></h6>
                        <small class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario_correo'] ?? ''); ?></small>
                    </div>
                    
                    <!-- CORREGIDO: action apunta al mismo archivo -->
                    <form method="POST" action="">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-lock-fill text-success me-1"></i>Contraseña Actual
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-lock text-success"></i>
                                </span>
                                <input type="password" name="password_actual" class="form-control form-control-lg" required>
                                <button class="btn btn-outline-success" type="button" onclick="togglePassword(this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-key-fill text-success me-1"></i>Nueva Contraseña
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-key text-success"></i>
                                </span>
                                <input type="password" name="password_nueva" class="form-control form-control-lg" minlength="6" required>
                                <button class="btn btn-outline-success" type="button" onclick="togglePassword(this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>Confirmar Nueva Contraseña
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-check-circle text-success"></i>
                                </span>
                                <input type="password" name="password_confirmar" class="form-control form-control-lg" minlength="6" required>
                                <button class="btn btn-outline-success" type="button" onclick="togglePassword(this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-check-circle me-2"></i>Cambiar Contraseña
                            </button>
                            
                            <a href="<?php echo BASE_URL; ?>views/modules/Navegacion/dashboard.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver al Dashboard
                            </a>
                        </div>
                        
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center py-3 border-0">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Recomendamos usar una contraseña segura
                    </small>
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseñas -->
<script>
function togglePassword(button) {
    const input = button.previousElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>