<?php

class EnlacesPaginasModelo
{

    // Método para gestionar los enlaces
    public function enlacesPaginas($enlace, $carpeta = null)
    {

        // Rutas permitidas
        $paginasPermitidas = [
            'inicio',
            'fundaciones',
            'redes'
        ];


        // Validar si existe en el arreglo
        if (in_array($enlace, $paginasPermitidas)) {

            $ruta = "views/modules/" . $enlace . ".php";

        } else {

            $ruta = "views/modules/errorPagina.php";

        }

        return $ruta;
    }

}

