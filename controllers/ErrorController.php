<?php
/**
 * Controlador de errores
 * Maneja la visualización de páginas de error personalizadas.
 */
class ErrorController {

    /**
     * Muestra una página de error genérica.
     *
     * @param string $code        Código de error (ej: 404, 500)
     * @param string $message     Mensaje corto del error
     * @param string $description Descripción detallada del error
     */
    public function showError($code = '500', $message = 'Error interno del servidor', $description = 'Ha ocurrido un error inesperado.') {
        // Pasar variables a la vista
        $error_code = $code;
        $error_message = $message;
        $error_description = $description;

        // Incluir la vista de error (usando VIEWS_PATH si está definida)
        $viewPath = defined('VIEWS_PATH') ? VIEWS_PATH : dirname(__DIR__) . '/views/';
        $viewFile = $viewPath . 'modules/errorPagina.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // Si la vista no existe, mostrar un error por defecto en texto plano
            die("Error $code: $message - $description (Vista de error no encontrada)");
        }
        exit; // Detener la ejecución después de mostrar el error
    }

    /**
     * Muestra error 404 (Página no encontrada)
     */
    public function notFound() {
        http_response_code(404);
        $this->showError(
            '404',
            'Página no encontrada',
            'Lo sentimos, la página que buscas no existe o ha sido movida.'
        );
    }

    /**
     * Muestra error 403 (Acceso prohibido)
     */
    public function forbidden() {
        http_response_code(403);
        $this->showError(
            '403',
            'Acceso prohibido',
            'No tienes permisos para acceder a esta página.'
        );
    }

    /**
     * Muestra error 500 (Error interno del servidor)
     */
    public function internalServerError() {
        http_response_code(500);
        $this->showError(
            '500',
            'Error interno del servidor',
            'Ha ocurrido un error inesperado. Por favor, intente más tarde.'
        );
    }
}