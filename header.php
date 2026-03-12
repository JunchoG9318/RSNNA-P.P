<?php
if (!defined('BASE_URL')) {
    define("BASE_URL", "http://localhost/proyectoclon/RSNNA-P.P/");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema ICBF Colombia</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <header>
        <!-- Navbar principal con estilo ICBF -->
        <nav class="navbar navbar-expand-lg navbar-dark py-3 shadow-lg"
            style="background: linear-gradient(135deg, #006341 0%, #00A651 100%);">

            <div class="container">
                <!-- LOGO IZQUIERDA - CORREGIDO -->
                <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>inicio.php">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                        <img src="<?php echo BASE_URL; ?>imagenes/logo.png"
                            width="200"
                            height="auto"
                            class="img-fluid"
                            alt="ICBF Colombia">
                    </div>
                    <div>
                        <span class="fw-bold fs-4 d-block">RSNNA</span>
                        <small class="text-white-50">Registro y Seguimiento de Niños,<br> Niñas y Adolescentes</small>
                    </div>
                </a>

                <!-- BOTÓN MÓVIL MEJORADO -->
                <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuNavbar"
                    aria-controls="menuNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- CONTENIDO DEL MENÚ -->
                <div class="collapse navbar-collapse" id="menuNavbar">
                    <!-- MENÚ CENTRAL - Diseño mejorado -->
                    <!-- MENÚ CENTRAL - Diseño mejorado -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-1">
                            <a class="nav-link px-4 py-2 rounded-3 fw-semibold text-white hover-effect"
                                href="<?php echo BASE_URL; ?>inicio.php">
                                <i class="bi bi-house-door me-2"></i>INICIO
                            </a>
                        </li>

                        <li class="nav-item mx-1">
                            <a class="nav-link px-4 py-2 rounded-3 fw-semibold text-white hover-effect"
                                href="<?php echo BASE_URL; ?>Fundaciones.php">
                                <i class="bi bi-building me-2"></i>FUNDACIONES
                            </a>
                        </li>

                        <li class="nav-item mx-1">
                            <a class="nav-link px-4 py-2 rounded-3 fw-semibold text-white hover-effect"
                                href="<?php echo BASE_URL; ?>Redes_de_apoyo.php">
                                <i class="bi bi-share me-2"></i>REDES DE APOYO
                            </a>
                        </li>
                    </ul>

                    <!-- BOTONES DE ACCIÓN DERECHA - Mejorados -->
                    <!-- BOTONES DE ACCIÓN DERECHA - Mejorados -->
                    <div class="d-flex flex-wrap gap-2">
                        <!-- Botón Iniciar Sesión -->
                        <a href="<?php echo BASE_URL; ?>views/modules/login/login.php"
                            class="btn btn-outline-light px-4 py-2 rounded-pill d-flex align-items-center hover-scale">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            <span>INICIAR SESIÓN</span>
                        </a>

                        <!-- Botón Registrarse con estilo destacado - CORREGIDO -->
                        <a href="<?php echo BASE_URL; ?>views/modules/login/registro.php"
                            class="btn btn-warning px-4 py-2 rounded-pill d-flex align-items-center text-dark fw-bold hover-scale"
                            style="background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%); border: none;">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            <span>REGISTRARSE</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Barra inferior decorativa con lema ICBF -->
        <div class="bg-success py-2" style="background-color: #004d33 !important;">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center text-white small">
                    <span>
                        <i class="bi bi-heart-fill me-2 text-warning"></i>
                        "Por una niñez y adolescencia feliz y protegida"
                    </span>
                    <span class="d-none d-md-block">
                        <i class="bi bi-telephone me-2"></i>
                        Línea Gratuita: 01 8000 91 80 80
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Estilos personalizados para efectos y hover -->
    <style>
        /* Color institucional ICBF */
        .bg-success {
            background-color: #006341 !important;
        }

        .text-success {
            color: #006341 !important;
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #fff;
        }

        /* Efectos hover para los items del menú */
        .hover-effect {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .hover-effect:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hover-effect::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background-color: #FFC107;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .hover-effect:hover::after {
            width: 80%;
        }

        /* Efecto de escala para botones */
        .hover-scale {
            transition: all 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Efecto para el logo */
        .navbar-brand {
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
        }

        /* Responsive para móviles */
        @media (max-width: 991px) {
            .navbar-nav {
                margin-top: 1rem;
            }

            .nav-item {
                margin: 0.25rem 0;
            }

            .navbar-nav .nav-link {
                background-color: rgba(255, 255, 255, 0.1) !important;
                border-radius: 8px !important;
                padding: 0.75rem 1rem !important;
            }

            .navbar-nav .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.2) !important;
            }

            .d-flex {
                margin-top: 1rem;
                justify-content: center;
            }
        }

        /* Animación de pulsación para el botón de registro */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        .btn-warning {
            animation: pulse 2s infinite;
        }

        .btn-warning:hover {
            animation: none;
        }

        /* Decoración adicional */
        .navbar {
            border-bottom: 4px solid #FFC107;
        }
    </style>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para cerrar menú al hacer clic en enlace (mejora UX móvil) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cerrar menú al hacer clic en enlaces en móvil
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const navbarToggler = document.querySelector('.navbar-toggler');
            const menuNavbar = document.getElementById('menuNavbar');

            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        const bsCollapse = bootstrap.Collapse.getInstance(menuNavbar);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                });
            });

            // Tooltips para elementos con título
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>