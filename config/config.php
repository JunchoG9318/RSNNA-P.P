<?php
// config/config.php - Configuración general del sistema

// Ruta base del proyecto (directorio raíz)
define('BASE_PATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);

// Ruta a la carpeta de vistas
define('VIEWS_PATH', BASE_PATH . 'views' . DIRECTORY_SEPARATOR);

// URL base del proyecto (para enlaces web)
// Ajusta esto a tu URL local (ej: http://localhost/RSNNA-P.P/)
define('BASE_URL', 'http://localhost/proyectoclon/RSNNA-P.P/');