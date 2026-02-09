<?php
require_once '../models/modelo.php';

class registrarFundacion
{
    public function registrarFundacionController($datos)
    {
        $tabla = "fundacion";

        $respuesta = modelo::registrarFundacionModelo($tabla, $datos);

        return $respuesta;
    }
}
?>