<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/Navegacion/dashboard.php");
    exit();
}

// Incluir la conexión PRIMERO, antes de cualquier salida
require_once("../../../config/conexion.php");

$token = $_GET['token'] ?? '';
$valido = false;
$mensaje = '';
$usuario_id = 0;

// Validar token
if (!empty($token)) {
    $stmt = $conexion->prepare("SELECT usuario_id, expiracion FROM password_resets WHERE token = ? AND usado = 0 AND expiracion > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usuario_id = $row['usuario_id'];
        $valido = true;
    }
    $stmt->close();
}

// Procesar cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valido) {
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';
    
    if (empty($password_nueva) || empty($password_confirmar)) {
        $mensaje = 'Todos los campos son obligatorios';
    } elseif ($password_nueva !== $password_confirmar) {
        $mensaje = 'Las contraseñas no coinciden';
    } elseif (strlen($password_nueva) < 6) {
        $mensaje = 'La contraseña debe tener al menos 6 caracteres';
    } else {
        // Actualizar contraseña
        $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
        
        $conexion->begin_transaction();
        
        try {
            $update = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $update->bind_param("si", $password_hash, $usuario_id);
            $update->execute();
            
            $marcar_usado = $conexion->prepare("UPDATE password_resets SET usado = 1 WHERE token = ?");
            $marcar_usado->bind_param("s", $token);
            $marcar_usado->execute();
            
            $conexion->commit();
            
            // AHORA incluimos el header después de la redirección
            header("Location: login.php?reset=1");
            exit();
            
        } catch (Exception $e) {
            $conexion->rollback();
            $mensaje = 'Error al actualizar la contraseña';
        }
    }
}

// AHORA incluimos el header SOLO si no hubo redirección
include("../../../header.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-key me-2"></i>Restablecer Contraseña
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if (!$valido): ?>
                        <div class="alert alert-danger text-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            El enlace no es válido o ha expirado.
                        </div>
                        <div class="text-center">
                            <a href="recuperar_password.php" class="btn btn-success">
                                Solicitar nuevo enlace
                            </a>
                        </div>
                    <?php else: ?>
                        
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-key-fill text-success me-1"></i>Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-key text-success"></i>
                                    </span>
                                    <input type="password" name="password_nueva" class="form-control form-control-lg" 
                                           minlength="6" required>
                                    <button class="btn btn-outline-success" type="button" onclick="togglePassword(this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-check-circle-fill text-success me-1"></i>Confirmar Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </span>
                                    <input type="password" name="password_confirmar" class="form-control form-control-lg" 
                                           minlength="6" required>
                                    <button class="btn btn-outline-success" type="button" onclick="togglePassword(this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3">
                                    <i class="bi bi-check-circle me-2"></i>Cambiar Contraseña
                                </button>
                            </div>
                            
                        </form>
                    <?php endif; ?>
                    
                </div>
                
                <div class="card-footer bg-light text-center py-3 border-0">
                    <a href="login.php" class="text-success">Volver al Login</a>
                </div>
                
            </div>
            
        </div>
    </div>
</div>

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