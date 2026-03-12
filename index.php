<?php
// Iniciar buffer de salida
ob_start();

// Cargar configuración principal (incluye VIEWS_PATH y BASE_URL)
require_once 'config/config.php';

// Cargar conexión a la base de datos
require_once 'config/conexion.php';

// Cargar controlador de errores (para que esté disponible en el catch)
require_once 'controllers/ErrorController.php';

// Cargar modelos
require_once 'models/modelo.php';
require_once 'models/paginasModelo.php';

// Cargar controladores
require_once 'controllers/controllers.php';

try {
    // Crear instancia del controlador principal
    $controlador = new Controlador();

    // Cargar plantilla principal
    $controlador->cargarTemplate();

    // Enviar salida al navegador
    ob_end_flush();

} catch (Throwable $e) {
    // Limpiar el buffer de salida
    if (ob_get_level()) {
        ob_clean();
    }

    // Asegurar que ErrorController está cargado (por si el error ocurrió antes)
    if (!class_exists('ErrorController')) {
        require_once 'controllers/ErrorController.php';
    }

    // Mostrar página de error
    $errorController = new ErrorController();
    $errorController->showError('500', 'Error interno del servidor', $e->getMessage());
}
?>