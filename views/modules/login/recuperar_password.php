<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/Navegacion/dashboard.php");
    exit();
}

include("../../../header.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-key me-2"></i>Recuperar Contraseña
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>
                
                <div class="card-body p-4">
                    
                    <!-- Mensajes -->
                    <?php if (isset($_GET["success"])) { ?>
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Se ha enviado un enlace a tu correo electrónico
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    
                    <?php if (isset($_GET["error"])) { ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php 
                            if($_GET["error"] == 1) echo "El correo no está registrado";
                            if($_GET["error"] == 2) echo "Error al procesar la solicitud";
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </div>
                    
                    <form action="procesar_recuperacion.php" method="POST">
                        
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
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-send me-2"></i>Enviar Enlace
                            </button>
                            
                            <a href="login.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver al Login
                            </a>
                        </div>
                        
                    </form>
                </div>
                
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

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>