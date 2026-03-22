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

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="alert alert-success mb-0">
                <h4 class="alert-heading fw-bold">
                    <i class="bi bi-shield-check me-2"></i>¡Bienvenido al sistema!
                </h4>
                <p class="mb-0">Has iniciado sesión como <strong>usuario familiar</strong>.</p>
                <hr class="my-2">
                <p class="mb-0 small">                    
                    <i class="bi bi-envelope me-1"></i> <?php echo $_SESSION['usuario_correo']; ?>
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-success bg-opacity-10 rounded-4 p-3 text-center h-100 d-flex align-items-center justify-content-center">
                <div>
                    <span class="badge bg-success text-white px-3 py-2 mb-2">Tipo de usuario</span>
                    <h5 class="fw-bold text-success mb-0">
                        <i class="bi bi-people me-2"></i>Familia
                    </h5>
                </div>
            </div>
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
                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/listado_registros_familiares.php" class="btn btn-success rounded-pill px-4">
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

        <!-- Consultas -->
        <!-- Consultas -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                <div class="card-body text-center p-4">


                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-search text-primary fs-1"></i>
                    </div>


                    <h4 class="fw-bold mb-2">Consultas</h4>


                    <p class="text-muted mb-4">
                        Consultar información del hijo y la fundación
                    </p>


                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/imprimir_consulta.php"
                        class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-right-circle me-2"></i>Ir a Consultas
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
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    .bg-success {
        background-color: #006341 !important;
    }

    .bg-success.bg-opacity-10 {
        background-color: rgba(0, 99, 65, 0.1) !important;
    }

    .text-success {
        color: #006341 !important;
    }
</style>


<?php include("../../../footer.php"); ?>