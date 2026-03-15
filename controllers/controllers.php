<?php

class Controlador
{
    // Cargar plantilla principal
    public function cargarTemplate()
    {
        $templatePath = __DIR__ . '/../template.php';
        if (file_exists($templatePath)) {
            include $templatePath;
        }
    }

    // Método para gestionar los enlaces
    public function enlacesPaginasControlador()
    {
        // Obtener parámetros
        $enlace = isset($_GET['action']) ? $_GET['action'] : 'inicio';
        $carpeta = isset($_GET['dato']) ? $_GET['dato'] : null;

        // Verificar si es una acción de traslado (manejo especial)
        $accionesTraslado = ['traslado_form', 'procesar_traslado', 'ver_traslados', 'obtener_internos_ajax'];
        
        if (in_array($enlace, $accionesTraslado)) {
            $this->manejadorTraslados($enlace);
            return;
        }

        // Para las demás acciones, usar el modelo existente
        try {
            // Instanciar modelo (verificar que existe la clase)
            if (class_exists('EnlacesPaginasModelo')) {
                $modelo = new EnlacesPaginasModelo();
                // Obtener ruta desde el modelo
                $rutaVista = $modelo->enlacesPaginas($enlace, $carpeta);
                
                // Construir ruta completa
                $rutaCompleta = __DIR__ . '/../../' . $rutaVista;
                
                // Limpiar posibles duplicados en la ruta
                $rutaCompleta = str_replace('//', '/', $rutaCompleta);
                $rutaCompleta = str_replace('/inicio.php', '', $rutaCompleta) . '.php';
                
                // Verificar existencia
                if (file_exists($rutaCompleta)) {
                    include_once $rutaCompleta;
                } else {
                    // Intentar con ruta alternativa
                    $rutaAlternativa = __DIR__ . '/../views/' . $enlace . '.php';
                    if (file_exists($rutaAlternativa)) {
                        include_once $rutaAlternativa;
                    } else {
                        echo "Error: No existe la vista: " . $rutaCompleta;
                    }
                }
            } else {
                // Si no existe el modelo, usar enrutamiento simple
                $this->enrutamientoSimple($enlace);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Manejador especial para las acciones de traslados
     */
    private function manejadorTraslados($accion)
    {
        // Incluir el controlador de traslados
        $trasladoControllerPath = __DIR__ . '/TrasladoController.php';
        
        if (file_exists($trasladoControllerPath)) {
            require_once $trasladoControllerPath;
            
            if (class_exists('TrasladoController')) {
                $trasladoController = new TrasladoController();
                
                switch($accion) {
                    case 'traslado_form':
                        $trasladoController->mostrarFormulario();
                        break;
                    case 'procesar_traslado':
                        $trasladoController->registrarTraslado();
                        break;
                    case 'ver_traslados':
                        $trasladoController->verTraslados();
                        break;
                    case 'obtener_internos_ajax':
                        $trasladoController->obtenerInternosAjax();
                        break;
                }
            } else {
                echo "Error: No se encontró la clase TrasladoController";
            }
        } else {
            echo "Error: No existe el controlador de traslados";
        }
    }
    
    /**
     * Enrutamiento simple por si no existe el modelo
     */
    private function enrutamientoSimple($enlace)
    {
        $basePath = __DIR__ . '/../';
        
        switch($enlace) {
            case 'fundaciones':
                $ruta = $basePath . "Fundaciones.php";
                break;
            case 'redes':
                $ruta = $basePath . "Redes_de_apoyo.php";
                break;
            case 'registro':
                $ruta = $basePath . "views/modules/login/registro.php";
                break;
            case 'login':
                $ruta = $basePath . "views/modules/login/login.php";
                break;
            case 'registrar_fundacion':
                $ruta = $basePath . "views/modules/fundaciones/RegistrarFundacion.php";
                break;
            default:
                $ruta = $basePath . "inicio.php";
        }
        
        if (file_exists($ruta)) {
            include_once $ruta;
        } else {
            echo "Error: No existe la vista para la acción '$enlace'";
        }
    }
}
?>