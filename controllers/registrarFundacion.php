<?php
class regisrtrarFundacion
{
    public function registrarFundacionController($datos)
    {
        $tabla = "fundacion";

        $respuesta = Modelo::registrarFundacionModelo($tabla, $datos);

        return $respuesta;
    }
}