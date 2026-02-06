<?php
class controlador
{
    public function cargarTemplate()
    {
        include 'template.php';
        include 'Primer_prototipo.php';
    }
    #METODO PARA GESTIONAR LOS ENLACES
    public function enlacesPaginasControlador()
    {
        $enlace = isset($_GET['action']) ? $_GET['action'] :'inicio';
        $carpeta = isset($_GET['dato']) ? $_GET ['dato'] : null;

        $modelo = new EnlacesPaginasModelo();
        $rutaVista = $modelo->enlacesPaginas($enlace, $carpeta);
        // print($rutaVista);

        include $rutaVista;
    }
} 