<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/proyectoclon/RSNNA-P.P/');
}

// Incluir conexión a la base de datos UNA SOLA VEZ y al principio
include(__DIR__ . '/config/conexion.php');

// Incluir header después de la conexión
include("header.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Sistema RSNNA</title>

    <!-- CSS locales -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/flatpickr.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid py-2">
        <div class="container py-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <main class="text-center my-4">
                        <h1 class="display-4 text-success fw-bold">Bienvenido al Sistema RSNNA</h1>
                        <p class="lead">Registro y Seguimiento de Niños, Niñas y Adolescentes</p>
                    </main>

                    <!-- Tarjeta principal -->
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <!-- Cabecera -->
                        <div class="bg-success py-3 px-4 text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                        <i class="bi bi-building fs-4 text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold">Municipio de Girardot</h5>
                                        <small class="opacity-75"><i class="bi bi-geo-alt me-1"></i>Cundinamarca, Colombia</small>
                                    </div>
                                </div>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="bi bi-shield me-1"></i>RSNNA
                                </span>
                            </div>
                        </div>

                        <!-- Carrusel -->
                        <div class="position-relative">
                            <div id="carouselGirardot" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselGirardot" data-bs-slide-to="0" class="active bg-success" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselGirardot" data-bs-slide-to="1" class="bg-success" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselGirardot" data-bs-slide-to="2" class="bg-success" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo BASE_URL; ?>imagenes/municipio/images.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Girardot">
                                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
                                            <h6 class="text-white">Bienvenidos a Girardot</h6>
                                            <p class="small text-white-50">Ciudad turística</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo BASE_URL; ?>imagenes/municipio/letrero.jpeg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Letrero Girardot">
                                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
                                            <h6 class="text-white">Letrero Turístico</h6>
                                            <p class="small text-white-50">Patrimonio cultural</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo BASE_URL; ?>imagenes/municipio/parque.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Parque Girardot">
                                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
                                            <h6 class="text-white">Parque Principal</h6>
                                            <p class="small text-white-50">Corazón de la ciudad</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselGirardot" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-success rounded-circle p-3" style="background-size:60%;"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselGirardot" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-success rounded-circle p-3" style="background-size:60%;"></span>
                                </button>
                            </div>
                            <div class="position-absolute top-0 end-0 m-3 z-1">
                                <span class="badge bg-warning text-dark px-4 py-2 rounded-pill shadow">
                                    <i class="bi bi-heart-fill me-2"></i>ICBF Presente
                                </span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="card-body p-4">
                            <!-- Logo y título -->
                            <div class="text-center mb-4">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                                    <img src="<?php echo BASE_URL; ?>imagenes/logo.png" alt="RSNNA" width="120" class="img-fluid">
                                </div>
                                <h2 class="text-success fw-bold mb-2"><i class="bi bi-shield-check me-2"></i>Sistema RSNNA</h2>
                                <h5 class="text-muted">Girardot - Cundinamarca</h5>
                                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-people me-1"></i>Niñez
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-shield me-1"></i>Protección
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-graph-up me-1"></i>Seguimiento
                                    </span>
                                </div>
                            </div>

                            <!-- Texto institucional -->
                            <div class="bg-light p-3 rounded-4 mb-4">
                                <p class="lead text-success fw-semibold mb-2">
                                    <i class="bi bi-quote me-2"></i>Registro y Seguimiento de Niños, Niñas y Adolescentes
                                </p>
                                <p class="small">El sistema <strong class="text-success">RSNNA</strong> de Girardot garantiza la protección y seguimiento integral de la población infantil en situación de vulnerabilidad.</p>

                                <div class="row g-2 mt-3">
                                    <div class="col-6"><i class="bi bi-check-circle-fill text-success me-2"></i>Registro Actualizado</div>
                                    <div class="col-6"><i class="bi bi-check-circle-fill text-success me-2"></i>Monitoreo Continuo</div>
                                    <div class="col-6"><i class="bi bi-check-circle-fill text-success me-2"></i>Toma de Decisiones</div>
                                    <div class="col-6"><i class="bi bi-check-circle-fill text-success me-2"></i>Derechos Fundamentales</div>
                                </div>
                            </div>

                            <?php
                            if (isset($conexion) && $conexion) {
                                $total_niños = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM ingresos_fundacion"))['total'] ?? 0;
                                $total_fundaciones = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM fundaciones WHERE estado = 1"))['total'] ?? 0;
                                $cobertura = $total_fundaciones > 0 ? min(round(($total_niños / ($total_fundaciones * 10)) * 100), 100) : 0;
                            } else {
                                $total_niños = $total_fundaciones = $cobertura = 0;
                            }
                            ?>

                            <!-- Estadísticas -->
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="bg-success bg-opacity-10 rounded-4 p-2 text-center">
                                        <h4 class="text-success fw-bold mb-0"><?php echo $total_niños; ?></h4><small class="text-muted">Niños</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-success bg-opacity-10 rounded-4 p-2 text-center">
                                        <h4 class="text-success fw-bold mb-0"><?php echo $total_fundaciones; ?></h4><small class="text-muted">Fundaciones</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-success bg-opacity-10 rounded-4 p-2 text-center">
                                        <h4 class="text-success fw-bold mb-0"><?php echo $cobertura; ?>%</h4><small class="text-muted">Cobertura</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="text-center small text-success border-top pt-3">
                                <i class="bi bi-geo-alt-fill me-1"></i>Girardot, Cundinamarca - <i class="bi bi-calendar ms-2 me-1"></i><?php echo date('d/m/Y'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL - Tarjetas de opciones -->
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <!-- REGISTRAR USUARIO -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i>REGISTRAR USUARIO
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-3 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/registrarse2.png" width="120" alt="Registrarse" class="img-fluid">
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Si eres funcionario del ICBF, fundación o familiar,
                            regístrate en el sistema.
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>views/modules/login/registro.php" class="btn btn-success btn-lg rounded-pill px-4">
                            <i class="bi bi-person-check me-2"></i>Registrarse
                        </a>
                    </div>
                </div>
            </div>

            <!-- REGISTRAR FUNDACIÓN -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-building-add me-2"></i>REGISTRAR FUNDACIÓN
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-3 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/institucion.png" width="120" alt="Fundación" class="img-fluid">
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Registra tu fundación y solicita afiliación.
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/RegistrarFundacion.php" class="btn btn-success btn-lg rounded-pill px-4">
                            <i class="bi bi-building-add me-2"></i>Inscribir
                        </a>
                    </div>
                </div>
            </div>

            <!-- REDES DE APOYO -->
            <div class="col-md-4 col-sm-12">
                <div class="card h-100 shadow-lg border-0 rounded-4 text-center hover-card">
                    <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-share-fill me-2"></i>REDES DE APOYO
                        </h5>
                    </div>
                    <div class="text-center mt-4">
                        <div class="bg-success bg-opacity-10 p-3 d-inline-block rounded-circle">
                            <img src="<?php echo BASE_URL; ?>imagenes/red de apoyo.png" width="120" alt="Redes de apoyo" class="img-fluid">
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Información de entidades de protección infantil.
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4">
                        <a href="<?php echo BASE_URL; ?>Redes_de_apoyo.php" class="btn btn-success btn-lg rounded-pill px-4">
                            <i class="bi bi-eye me-2"></i>Ver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGETS - HORA Y FECHA -->
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-2 border-0">
                        <h5 class="mb-0 fw-bold text-center">
                            <i class="bi bi-clock-history me-2"></i>Fecha y Hora
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-6 text-center">
                                <div class="d-inline-block p-2 rounded-circle bg-success bg-opacity-10 mb-2">
                                    <i class="bi bi-calendar text-success" style="font-size: 1.8rem;"></i>
                                </div>
                                <h5 class="text-success fw-bold" id="fecha" style="font-size: 1.1rem;"></h5>
                                <small class="text-muted">Fecha</small>
                            </div>
                            <div class="col-6 text-center">
                                <div class="d-inline-block p-2 rounded-circle bg-success bg-opacity-10 mb-2">
                                    <i class="bi bi-clock text-success" style="font-size: 1.8rem;"></i>
                                </div>
                                <div id="clock" class="fw-bold text-success" style="font-size: 1.8rem;"></div>
                                <small class="text-muted">Hora</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center py-1">
                        <small class="text-muted">
                            <i class="bi bi-geo-alt-fill me-1 text-success" style="font-size: 0.8rem;"></i>
                            Hora colombiana
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Información adicional fuera de la tarjeta principal -->
        <div class="row mt-4 g-3">
            <div class="col-md-6">
                <div class="card border-0 bg-light rounded-4 p-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-3">
                            <i class="bi bi-telephone fs-4 text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Línea de Atención ICBF</h6>
                            <p class="mb-0 text-success fw-bold">01 8000 91 80 80</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 bg-light rounded-4 p-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-3">
                            <i class="bi bi-envelope fs-4 text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Correo ICBF Girardot</h6>
                            <p class="mb-0 text-success fw-bold small">girardot@icbf.gov.co</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos personalizados adicionales -->
    <style>
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
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #006341;
            border-radius: 50%;
            padding: 1rem;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 30px 40px rgba(0, 99, 65, 0.15) !important;
        }

        .carousel-caption {
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
        }

        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
        }

        #clock {
            font-family: 'Courier New', monospace;
            line-height: 1.2;
        }

        #fecha {
            line-height: 1.2;
            margin-bottom: 0.2rem;
        }
    </style>

    <!-- Scripts -->
    <script>
        function actualizarHoraFecha() {
            const now = new Date();
            let hora = now.toLocaleTimeString('es-CO', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            let fecha = now.toLocaleDateString('es-CO', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            fecha = fecha.charAt(0).toUpperCase() + fecha.slice(1);
            document.getElementById("clock").innerHTML = hora;
            document.getElementById("fecha").innerHTML = fecha;
        }
        setInterval(actualizarHoraFecha, 1000);
        actualizarHoraFecha();
    </script>

    <!-- Scripts locales -->
    <script src="<?php echo BASE_URL; ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>js/flatpickr.min.js"></script>
</body>

</html>
<?php include("footer.php"); ?>