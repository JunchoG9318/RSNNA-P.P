<?php

class PaginasModelo
{
    //METODO PARA GESTIONAR LOS ENLACES
    public function enlacesPaginas($enlace,$carpeta=null)
    {
        //ruta base de las views//
        $basepath = 'views/modules/';
        $ruta="{$basepath}{$enlace}";

        // verificar si existe carpeta
        if(isset($carpeta)){
            $ruta .= "/{$carpeta}";
        }
        $ruta .= '.php';
        // verificar si existe el archivo
        if(!file_exists($ruta)){
            $ruta = $basepath."errorPagina.php";
        }
        return $ruta;
    }
}
?>
