<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'icbf') {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
include("../../../config/conexion.php");

// Consulta para contar funcionarios por fundación
$query_funcionarios = "SELECT COUNT(DISTINCT u.id) as total FROM usuarios u WHERE u.tipo_usuario = 'fundacion'";
$result_funcionarios = mysqli_query($conexion, $query_funcionarios);
$total_funcionarios = mysqli_fetch_assoc($result_funcionarios)['total'];

// Consulta para contar fundaciones con funcionarios
$query_fundaciones_con_funcionarios = "SELECT COUNT(DISTINCT u.id_fundacion) as total FROM usuarios u WHERE u.tipo_usuario = 'fundacion' AND u.id_fundacion IS NOT NULL";
$result_fundaciones_con_funcionarios = mysqli_query($conexion, $query_fundaciones_con_funcionarios);
$fundaciones_con_funcionarios = mysqli_fetch_assoc($result_fundaciones_con_funcionarios)['total'];
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Identificación de usuario y botón cerrar sesión (MEJORADA) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">
                        <i class="bi bi-person-badge me-2"></i>Panel Funcionario ICBF
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

            <!-- Mensaje de bienvenida mejorado con estadísticas -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="alert alert-success mb-0">
                        <h4 class="alert-heading fw-bold">
                            <i class="bi bi-shield-check me-2"></i>¡Bienvenido al sistema!
                        </h4>
                        <p class="mb-0">Has iniciado sesión como <strong>funcionario ICBF</strong>.</p>
                        <hr class="my-2">
                        <p class="mb-0 small">
                            <i class="bi bi-person-circle me-1"></i> ID: <?php echo $_SESSION['usuario_id']; ?> |
                            <i class="bi bi-envelope me-1"></i> <?php echo $_SESSION['usuario_correo']; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-success bg-opacity-10 rounded-4 p-3 text-center h-100 d-flex align-items-center justify-content-center">
                        <div>
                            <span class="badge bg-success text-white px-3 py-2 mb-2">Tipo de usuario</span>
                            <h5 class="fw-bold text-success mb-0">
                                <i class="bi bi-building me-2"></i>ICBF
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de opciones principales (MEJORADAS) - AHORA CON 4 TARJETAS -->
            <div class="row g-4">
                <!-- Tarjeta 1: Fundaciones -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="bi bi-building text-success fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Fundaciones</h4>
                            <p class="text-muted mb-4">Administra y revisa todas las fundaciones registradas en el sistema</p>
                            <div class="d-grid">
                                <a href="<?php echo BASE_URL; ?>views/modules/ICBF/admin_fundaciones.php" class="btn btn-success btn-lg rounded-pill">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Ver Fundaciones
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM fundaciones WHERE estado = 1";
                                $result = mysqli_query($conexion, $query);
                                $total = mysqli_fetch_assoc($result)['total'];
                                echo $total . ' fundaciones activas';
                                ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2: Internos -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="bi bi-people-fill text-primary fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Internos En Fundaciones</h4>
                            <p class="text-muted mb-4">listado de internos registrados en las fundaciones</p>
                            <div class="d-grid">
                                <a href="<?php echo BASE_URL; ?>views/modules/ICBF/listado_internos.php" class="btn btn-primary btn-lg rounded-pill">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Ver Internos
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM ingresos_fundacion";
                                $result = mysqli_query($conexion, $query);
                                $total = mysqli_fetch_assoc($result)['total'];
                                echo $total . ' internos registrados';
                                ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3: Funcionarios por Fundación (NUEVA) -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="bi bi-people text-info fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Funcionarios por Fundación</h4>
                            <p class="text-muted mb-4">Visualiza los funcionarios registrados en cada fundación</p>
                            <div class="d-grid">
                                <a href="<?php echo BASE_URL; ?>views/modules/ICBF/funcionarios_por_fundacion.php" class="btn btn-info btn-lg rounded-pill">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Ver Funcionarios
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                <?php echo $total_funcionarios . ' funcionarios en ' . $fundaciones_con_funcionarios . ' fundaciones'; ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 4: Reportes -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-lg rounded-4 h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="bi bi-graph-up text-warning fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Reportes Institucionales</h4>
                            <p class="text-muted mb-4">Genera reportes estadísticos del sistema de registros</p>
                            <div class="d-grid">
                                <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/internos_por_fundacion.php" class="btn btn-warning btn-lg rounded-pill">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Ver Reportes
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Reportes disponibles
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fila adicional de estadísticas rápidas -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-header bg-success text-white py-3 border-0">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>Estadísticas Generales
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <?php
                                // Total fundaciones
                                $query = "SELECT COUNT(*) as total FROM fundaciones";
                                $result = mysqli_query($conexion, $query);
                                $totalFundaciones = mysqli_fetch_assoc($result)['total'];

                                // Total internos
                                $query = "SELECT COUNT(*) as total FROM ingresos_fundacion";
                                $result = mysqli_query($conexion, $query);
                                $totalInternos = mysqli_fetch_assoc($result)['total'];

                                // Internos este mes
                                $query = "SELECT COUNT(*) as total FROM ingresos_fundacion WHERE MONTH(fecha_ingreso) = MONTH(CURDATE()) AND YEAR(fecha_ingreso) = YEAR(CURDATE())";
                                $result = mysqli_query($conexion, $query);
                                $internosMes = mysqli_fetch_assoc($result)['total'];

                                // Fundaciones activas
                                $query = "SELECT COUNT(*) as total FROM fundaciones WHERE estado = 1";
                                $result = mysqli_query($conexion, $query);
                                $fundacionesActivas = mysqli_fetch_assoc($result)['total'];
                                
                                // Total funcionarios de fundación
                                $query = "SELECT COUNT(*) as total FROM usuarios WHERE tipo_usuario = 'fundacion'";
                                $result = mysqli_query($conexion, $query);
                                $totalFuncionarios = mysqli_fetch_assoc($result)['total'];
                                ?>

                                <div class="col-md-3">
                                    <div class="bg-light rounded-4 p-3 text-center">
                                        <h3 class="fw-bold text-success mb-1"><?php echo $totalFundaciones; ?></h3>
                                        <small class="text-muted">Total Fundaciones</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-light rounded-4 p-3 text-center">
                                        <h3 class="fw-bold text-primary mb-1"><?php echo $fundacionesActivas; ?></h3>
                                        <small class="text-muted">Fundaciones Activas</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-light rounded-4 p-3 text-center">
                                        <h3 class="fw-bold text-warning mb-1"><?php echo $totalInternos; ?></h3>
                                        <small class="text-muted">Total Internos</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-light rounded-4 p-3 text-center">
                                        <h3 class="fw-bold text-info mb-1"><?php echo $internosMes; ?></h3>
                                        <small class="text-muted">Internos este mes</small>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="bg-light rounded-4 p-3 text-center">
                                        <h3 class="fw-bold text-secondary mb-1"><?php echo $totalFuncionarios; ?></h3>
                                        <small class="text-muted">Funcionarios de Fundación</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
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

    .btn-success {
        background-color: #006341;
        border-color: #006341;
    }

    .btn-success:hover {
        background-color: #004d33;
        border-color: #004d33;
    }

    .btn-primary {
        background-color: #0d6efd;
    }

    .btn-warning {
        background-color: #ffc107;
    }
    
    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #000;
    }
    
    .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
        color: #000;
    }
    
    .bg-info {
        background-color: #0dcaf0 !important;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("../../../footer.php"); ?>