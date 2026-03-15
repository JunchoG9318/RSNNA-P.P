<?php
// views/modules/errorPagina.php
// Página de error personalizada para el sistema RSNNA

// Si no se definieron, usar valores por defecto
$error_code = $error_code ?? '500';
$error_message = $error_message ?? 'Error interno del servidor';
$error_description = $error_description ?? 'Ha ocurrido un error inesperado. Por favor, intente más tarde o contacte al administrador.';

// Si BASE_URL no está definida, intentamos obtenerla del servidor (fallback)
if (!defined('BASE_URL')) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $base = rtrim(dirname($scriptName), '/\\') . '/';
    define('BASE_URL', $protocol . $host . $base);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?php echo htmlspecialchars($error_code); ?> - RSNNA Girardot</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <!-- Fuente Poppins para el código de error -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@900&display=swap" rel="stylesheet">
    <style>
        :root {
            --verde-icbf: #006341;
            --verde-claro: #00A651;
            --amarillo-icbf: #FDB913;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 15px;
        }
        .error-card {
            max-width: 600px;
            width: 100%;
            border: none;
            border-radius: 20px;
            box-shadow: 0 30px 50px rgba(0,99,65,0.2);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .error-card:hover {
            transform: translateY(-5px);
        }
        .error-header {
            background: linear-gradient(135deg, var(--verde-icbf) 0%, var(--verde-claro) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 900;
            line-height: 1;
            text-shadow: 3px 3px 0 rgba(0,0,0,0.1);
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
            word-break: break-word;
        }
        .error-body {
            padding: 40px 30px;
            background: white;
            position: relative;
        }
        .error-icon {
            font-size: 4rem;
            color: rgba(255,255,255,0.2);
            position: absolute;
            top: 20px;
            right: 20px;
        }
        @media (max-width: 576px) {
            .error-code {
                font-size: 4rem;
            }
            .error-icon {
                font-size: 3rem;
                top: 10px;
                right: 10px;
            }
            .error-body {
                padding: 30px 20px;
            }
        }
        .btn-home {
            background: var(--verde-icbf);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,99,65,0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-home:hover {
            background: var(--verde-claro);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,99,65,0.4);
            color: white;
        }
        .btn-home i {
            margin-right: 8px;
        }
        .btn-outline-success-custom {
            background: transparent;
            border: 2px solid var(--verde-icbf);
            color: var(--verde-icbf);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .btn-outline-success-custom:hover {
            background: var(--verde-icbf);
            color: white;
        }
        .contact-link {
            color: var(--verde-icbf);
            text-decoration: none;
            font-weight: 500;
        }
        .contact-link:hover {
            text-decoration: underline;
            color: var(--verde-claro);
        }
        .footer-note {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .footer-note i {
            color: var(--verde-icbf);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card error-card">
                    <div class="error-header">
                        <i class="bi bi-exclamation-triangle-fill error-icon" aria-hidden="true"></i>
                        <div class="error-code"><?php echo htmlspecialchars($error_code); ?></div>
                        <h2 class="h4 fw-light mb-0"><?php echo htmlspecialchars($error_message); ?></h2>
                    </div>
                    <div class="error-body text-center">
                        <div class="mb-4">
                            <i class="bi bi-shield-fill-check" style="font-size: 3rem; color: var(--verde-icbf); opacity: 0.8;"></i>
                        </div>
                        <p class="lead mb-4"><?php echo htmlspecialchars($error_description); ?></p>
                        
                        <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
                            <a href="<?php echo BASE_URL; ?>inicio.php" class="btn-home">
                                <i class="bi bi-house-door-fill"></i> Volver al inicio
                            </a>
                            <button onclick="window.history.back();" class="btn-outline-success-custom">
                                <i class="bi bi-arrow-left"></i> Página anterior
                            </button>
                        </div>

                        <div class="alert alert-light border-0 bg-light" role="alert">
                            <i class="bi bi-info-circle-fill" style="color: var(--verde-icbf); margin-right: 8px;"></i>
                            Si el problema persiste, contacta a soporte técnico: 
                            <a href="mailto:soporte@rsnna-girardot.gov.co" class="contact-link">
                                <i class="bi bi-envelope-fill"></i> soporte@rsnna-girardot.gov.co
                            </a>
                        </div>
                    </div>
                    <div class="footer-note">
                        <i class="bi bi-building me-1"></i> Municipio de Girardot - Sistema RSNNA 
                        <span class="mx-2">|</span> 
                        <i class="bi bi-telephone-fill me-1"></i> Línea ICBF: 01 8000 91 80 80
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional para algunos componentes) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>