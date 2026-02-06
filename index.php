<?php

// Iniciar buffer de salida
ob_start();

// Cargar configuración principal
require_once 'models/conexion.php';

// Cargar modelos
require_once 'models/modelo.php';
require_once 'models/paginasModelo.php';

// Cargar controladores
require_once 'controllers/controllers.php';
require_once 'controllers/registrarFundacion.php';

// Crear instancia del controlador principal
$controlador = new Controlador();

// Cargar plantilla principal
$controlador->cargarTemplate();

// Enviar salida al navegador
ob_end_flush();

?>
