<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'familia') {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">
                <i class="bi bi-people-fill me-2"></i>Panel Familia
            </h2>
            <p class="text-muted mb-0">
                <i class="bi bi-person-circle me-2"></i>
                Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 border">
                <i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y'); ?>
            </span>
            <a href="<?php echo BASE_URL; ?>views/modules/login/logout.php" class="btn btn-outline-danger ms-3">
                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Mis Familiares -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-people-fill text-success fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Mis Familiares</h4>
                    <p class="text-muted mb-4">Ver información de los NNA a cargo</p>
                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/mis_familiares.php" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-arrow-right-circle me-2"></i>Ver Familiares
                    </a>
                </div>
            </div>
        </div>

        <!-- Información Personal -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-person-circle text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Información Personal</h4>
                    <p class="text-muted mb-4">Actualizar mis datos personales</p>
                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/registro_familiar.php" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-right-circle me-2"></i>Actualizar
                    </a>
                </div>
            </div>
        </div>

        <!-- Documentación -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                <div class="card-body text-center p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-file-text text-warning fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Documentación</h4>
                    <p class="text-muted mb-4">Gestionar documentos de los NNA</p>
                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/documenta_famil.php" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-arrow-right-circle me-2"></i>Ver Documentos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
}
</style>

<?php include("../../../footer.php"); ?>