<?php

class EnlacesPaginasModelo
{

    private $paginasPermitidas = [

        // Módulo Principal
        'inicio' => 'RSNNA-P.P/inicio.php',
        'dashboard' => 'modules/Navegacion/dashboard.php',

        // Módulo Login
        'login' => 'modules/login/login.php',
        'registro' => 'modules/login/registro.php',
        'validar_login' => 'modules/login/validar_login.php',
        'procesar_registro' => 'modules/login/procesar_registro.php',
        'logout' => 'modules/login/logout.php',

        // Módulo Fundaciones
        'fundaciones' => 'modules/fundaciones/fundaciones.php',
        'formulario_fundacion' => 'modules/fundaciones/formulario_fundacion.php',
        'RegistrarFundacion' => 'modules/fundaciones/RegistrarFundacion.php',
        'F_R_F_Fundacion' => 'modules/fundaciones/F_R_F_Fundacion.php',
        'procesar_fundacion' => 'modules/fundaciones/procesar_fundacion.php',
        'panel_fundaciones' => 'modules/fundaciones/panel_fundacion.php',
        'internos_por_fundacion'=> 'modules/ICBF/internos_por_fundacion.php',
        'internos_de_cada_fundacion'=> 'modules/fundaciones/internos_de_cada_fundacion.php',
        'informacionFundacion'=> 'modules/fundaciones/informacionFundacion.php',
        'registroMenor' => 'modules/fundaciones/registroMenor.php',
        'consulta_por_fundacion.php'=> 'views/modules/fundaciones/consulta_por_fundacion.php',

        // Módulo ICBF
        'formulario_icbf' => 'modules/ICBF/formulario_icbf.php',
        'registro_icbf' => 'modules/ICBF/registro_icbf.php',
        'ERF' => 'modules/ICBF/ERF.php',
        'admi_fundaciones' => 'modules/ICBF/admin_fundaciones.php',
        'panel_icbf' => 'modules/ICBF/panel_icbf.php',
        'administrar_fundacion'=> 'modules/ICBF/administrar_fundacion.php',
        'funcionarios_por_fundacion'=> 'modules/ICBF/funcionarios_por_fundacion.php',
        'Consultar_Interno' => 'views/modules/ICBF/Consultar_Interno.php',

        // Módulo Familias
        'detalles_ingre_fami' => 'modules/Familias/detalles_ingre_fami.php',
        'documenta_famil' => 'modules/Familias/documenta_famil.php',
        'informacion_interna_fami' => 'modules/Familias/informacion_interna_fami.php',
        'informacion_labor_fami' => 'modules/Familias/informacion_labor_fami.php',
        'registro_familiar' => 'modules/Familias/registro_familiar.php',
        'panel_familia' => 'modules/Familias/panel_familia.php',

              

        // Módulo Internos
        'controlador_registro_interno' => 'modules/fundaciones/controlador_registro_interno.php',
        'detalle_interno' => 'modules/fundaciones/detalle_interno.php',
        'editar_interno' => 'modules/fundaciones/editar_interno.php',

        // Redes de Apoyo
        'redes_de_apoyo' => 'modules/redes/redes_de_apoyo.php',

        // Página de error
        'errorPagina' => 'modules/errorPagina.php'

    ];


    public function enlacesPaginas($enlace, $carpeta = null)
    {
        // Sanitizar enlace
        $enlace = $this->sanearEnlace($enlace);

        // Buscar en carpeta específica
        if ($carpeta) {
            $rutaPersonalizada = "views/modules/{$carpeta}/{$enlace}.php";
            if (file_exists($rutaPersonalizada)) {
                return $rutaPersonalizada;
            }
        }

        // Buscar en lista permitida
        if (array_key_exists($enlace, $this->paginasPermitidas)) {
            $ruta = "views/" . $this->paginasPermitidas[$enlace];
            if (file_exists($ruta)) {
                return $ruta;
            }
        }

        // Página de error
        return "views/modules/errorPagina.php";
    }

    public function obtenerPaginasPermitidas()
    {
        return array_keys($this->paginasPermitidas);
    }

    public function paginaExiste($enlace)
    {
        return array_key_exists($enlace, $this->paginasPermitidas);
    }

    public function sanearEnlace($enlace)
    {
        return preg_replace('/[^a-zA-Z0-9_\-]/', '', $enlace);
    }

}