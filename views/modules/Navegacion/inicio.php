<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("../../../header.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="bg-light">
<div class="container-fluid py-4">
    <!-- Breadcrumb de navegación con estilo ICBF -->
    <!-- Banner de bienvenida institucional ICBF -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="position-relative overflow-hidden rounded-4 bg-success text-white p-5 text-center" 
                 style="background: linear-gradient(135deg, #006341 0%, #00A651 100%);">
                <!-- Elementos decorativos ICBF -->
                <div class="position-absolute top-0 start-0 p-3">
                    <i class="bi bi-heart-fill text-white opacity-25 fs-1"></i>
                </div>
                <div class="position-absolute bottom-0 end-0 p-3">
                    <i class="bi bi-people-fill text-white opacity-25 fs-1"></i>
                </div>
                
                <!-- Logo ICBF y título -->
                <div class="position-relative">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="bg-white bg-opacity-25 rounded-circle p-4">
                            <img src="<?php echo BASE_URL; ?>imagenes/icbf.jpeg" 
                                 alt="ICBF Colombia" 
                                 width="80" 
                                 height="80"
                                 class="img-fluid"
                                 onerror="this.src='https://www.icbf.gov.co/themes/custom/icbf/logo.png'; this.onerror=null;">
                        </div>
                    </div>
                    <h1 class="display-5 fw-bold mb-3">
                        Bienvenido al Sistema de Información
                    </h1>
                    <h2 class="display-6 mb-3 text-warning">
                        Instituto Colombiano de Bienestar Familiar
                    </h2>
                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-shield-check me-2"></i>Protección Infantil
                        </span>
                        <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-people me-2"></i>Familia
                        </span>
                        <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-heart me-2"></i>Bienestar
                        </span>
                    </div>
                    <p class="lead opacity-90 mb-0">
                        <i class="bi bi-quote me-2"></i>Explora recursos y servicios para la protección infantil en Colombia
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL - TARJETAS CON ESTILO ICBF -->
    <div class="container py-4">
        <!-- Título de sección -->
        <div class="text-center mb-5">
            <h3 class="text-success fw-bold">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                SERVICIOS Y REGISTROS
            </h3>
            <div class="d-flex justify-content-center">
                <div class="bg-success" style="width: 80px; height: 4px;"></div>
            </div>
        </div>

        <!-- PRIMER BLOQUE - 3 TARJETAS -->
        <div class="row g-4 justify-content-center mb-5">
            <!-- REGISTRAR USUARIO -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-plus fs-4 me-2"></i>
                            REGISTRAR USUARIO
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-4 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/registrarse2.png" 
                                 width="100" 
                                 alt="Registrarse"
                                 class="img-fluid"
                                 onerror="this.src='https://via.placeholder.com/100x100/00A651/ffffff?text=ICBF'; this.onerror=null;">
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <p class="text-muted">
                            Si eres funcionario del ICBF, fundación o familiar, 
                            regístrate en el sistema para acceder a todos los servicios.
                        </p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success">Funcionarios</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Fundaciones</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Familias</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>views/modules/Navegacion/RegistrarUsuario.php" 
                           class="btn btn-success btn-lg px-5 rounded-pill">
                            <i class="bi bi-person-check me-2"></i>Registrarse
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- REGISTRAR FUNDACIÓN -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-building fs-4 me-2"></i>
                            REGISTRAR FUNDACIÓN
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-4 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/institucion.png" 
                                 width="100" 
                                 alt="Fundación"
                                 class="img-fluid"
                                 onerror="this.src='https://via.placeholder.com/100x100/00A651/ffffff?text=ICBF'; this.onerror=null;">
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <p class="text-muted">
                            Registra tu fundación y solicita afiliación al sistema 
                            ICBF para trabajar en red por la niñez colombiana.
                        </p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success">Afiliación</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Red ICBF</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/RegistrarFundacion.php" 
                           class="btn btn-success btn-lg px-5 rounded-pill">
                            <i class="bi bi-building-add me-2"></i>Inscribir
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- REDES DE APOYO -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-share fs-4 me-2"></i>
                            REDES DE APOYO
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-4 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/red de apoyo.png" 
                                 width="100" 
                                 alt="Redes de apoyo"
                                 class="img-fluid"
                                 onerror="this.src='https://via.placeholder.com/100x100/00A651/ffffff?text=ICBF'; this.onerror=null;">
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <p class="text-muted">
                            Información de entidades de protección infantil y 
                            redes de apoyo del ICBF en todo el territorio nacional.
                        </p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success">Entidades</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Protección</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Nacional</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>Redes_de_apoyo.php" 
                           class="btn btn-success btn-lg px-5 rounded-pill">
                            <i class="bi bi-eye me-2"></i>Ver Redes
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEGUNDO BLOQUE - 1 TARJETA CENTRADA -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 col-sm-12">
                <div class="card shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-warning text-dark py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-search fs-4 me-2"></i>
                            CONSULTAR INFORMACIÓN
                        </h5>
                    </div>
                    <div class="row g-0">
                        <div class="col-md-5">
                            <div class="text-center mt-4">
                                <div class="bg-warning bg-opacity-10 p-4 d-inline-block rounded-circle">
                                    <img src="<?php echo BASE_URL; ?>imagenes/consultar.png" 
                                         width="120" 
                                         alt="Consultar"
                                         class="img-fluid"
                                         onerror="this.src='https://via.placeholder.com/120x120/FFC107/000000?text=ICBF'; this.onerror=null;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body text-start">
                                <p class="text-muted">
                                    Accede al motor de búsqueda para consultar información 
                                    sobre procesos, beneficiarios y servicios del ICBF.
                                </p>
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-warning bg-opacity-10 text-warning-dark">Búsqueda</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning-dark">Información</span>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-warning bg-opacity-10 border-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Buscar información...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>views/modules/resultados.php" 
                           class="btn btn-warning btn-lg px-5 rounded-pill">
                            <i class="bi bi-search me-2"></i>Iniciar Búsqueda
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WIDGETS - CALENDARIO Y RELOJ ESTILO ICBF -->
<div class="container-fluid py-5">
    <div class="row g-12 justify-content-center align-items-stretch">
        
        <!-- CALENDARIO -->
        <div class="col-md-5 col-sm-12 d-flex">
            <div class="card bg-success text-white shadow-lg border-0 rounded-4 overflow-hidden h-100 w-100">
                <div class="card-body p-5 d-flex flex-column">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="bi bi-calendar-week fs-2 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Calendario ICBF</h4>
                            <p class="text-white-50 mb-0">Eventos y actividades</p>
                        </div>
                    </div>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white bg-opacity-25 border-0 text-white">
                            <i class="bi bi-calendar"></i>
                        </span>
                        <input type="date" class="form-control form-control-lg bg-white bg-opacity-10 text-white border-0">
                    </div>
                    <div class="mt-3 mt-auto">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-white text-success">Próximo evento</span>
                            <span class="text-white-50">Día del Niño: 27 Abr</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RELOJ CON FECHA -->
        <div class="col-md-5 col-sm-12 d-flex">
            <div class="card bg-success text-white shadow-lg border-0 rounded-4 overflow-hidden h-100 w-100">
                <div class="card-body p-5 d-flex flex-column">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="bi bi-clock fs-2 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Hora Oficial</h4>
                            <p class="text-white-50 mb-0">Colombia</p>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <div id="clock" class="display-4 fw-bold mb-2"></div>
                        <div id="date" class="fs-4 text-white-50"></div>
                    </div>
                    <div class="mt-3 mt-auto text-center">
                        <span class="badge bg-white text-success">
                            <i class="bi bi-geo-alt me-2"></i>Hora legal colombiana
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<!-- Estilos personalizados para hover y efectos -->
<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
}
.hover-card .btn {
    transition: all 0.3s ease;
}
.hover-card:hover .btn {
    transform: scale(1.05);
}
.bg-success {
    background-color: #006341 !important;
}
.bg-success.bg-opacity-10 {
    background-color: rgba(0, 99, 65, 0.1) !important;
}
.btn-success {
    background-color: #006341;
    border-color: #006341;
}
.btn-success:hover {
    background-color: #004d33;
    border-color: #004d33;
}
.text-success {
    color: #006341 !important;
}
.border-success {
    border-color: #006341 !important;
}
.badge.bg-success.bg-opacity-10 {
    background-color: rgba(0, 99, 65, 0.1) !important;
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script del reloj y fecha -->
<script>
    function actualizarReloj() {
        const now = new Date();
        
        // Formato hora colombiana
        let hora = now.toLocaleTimeString('es-CO', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });
        
        // Formato fecha colombiana
        let fecha = now.toLocaleDateString('es-CO', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Capitalizar primera letra
        fecha = fecha.charAt(0).toUpperCase() + fecha.slice(1);
        
        document.getElementById("clock").innerHTML = hora;
        document.getElementById("date").innerHTML = fecha;
    }
    
    setInterval(actualizarReloj, 1000);
    actualizarReloj(); // Ejecutar inmediatamente
</script>

</body>
</html>

<?php
include("../../../footer.php");
?>