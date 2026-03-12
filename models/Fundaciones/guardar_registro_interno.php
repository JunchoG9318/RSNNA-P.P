<?php
session_start();
include("../../../config/conexion.php"); // Ajusta la ruta según tu estructura

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Función para limpiar y obtener valores
    function getPost($campo, $default = '') {
        return isset($_POST[$campo]) ? mysqli_real_escape_string($GLOBALS['conexion'], trim($_POST[$campo])) : $default;
    }
    
    // Obtener todos los valores del formulario
    $fundacion_nombre = getPost('fundacion_nombre');
    $fundacion_direccion = getPost('fundacion_direccion');
    $resp_telefono = getPost('resp_telefono');
    $resp_email = getPost('resp_email');
    $resp_cargo = getPost('resp_cargo');
    $fecha_ingreso = getPost('fecha_ingreso');
    $hora_ingreso = getPost('hora_ingreso');
    $motivo_ingreso = getPost('motivo_ingreso');
    $tipo_ingreso = getPost('tipo_ingreso');
    $responsable_remite = getPost('responsable_remite');
    $entidad_remite = getPost('entidad_remite');
    $doc_tipo = getPost('doc_tipo');
    $doc_numero = getPost('doc_numero');
    $numero_proceso = getPost('numero_proceso');
    $fecha_remision = getPost('fecha_remision');
    $menor_nombres = getPost('menor_nombres');
    $menor_tipo_doc = getPost('menor_tipo_doc');
    $menor_num_doc = getPost('menor_num_doc');
    $fecha_nacimiento = getPost('fecha_nacimiento');
    $edad = getPost('edad') ?: '0';
    $sexo = getPost('sexo') ? substr(getPost('sexo'), 0, 1) : '';
    $nacionalidad = getPost('nacionalidad');
    $lugar_nacimiento = getPost('lugar_nacimiento');
    $direccion_domicilio = getPost('direccion_domicilio');
    $eps = getPost('eps');
    $salud_general = getPost('salud_general');
    $alergias = getPost('alergias');
    $discapacidad = isset($_POST['discapacidad']) && $_POST['discapacidad'] == 'Sí' ? 1 : 0;
    $cual_discapacidad = getPost('cual_discapacidad');
    $acudiente_nombres = getPost('acudiente_nombres');
    $acudiente_tipo_doc = getPost('acudiente_tipo_doc');
    $acudiente_num_doc = getPost('acudiente_num_doc');
    $acudiente_parentesco = getPost('acudiente_parentesco');
    $acudiente_direccion = getPost('acudiente_direccion');
    $acudiente_tel = getPost('acudiente_tel');
    $acudiente_email = getPost('acudiente_email');
    $acudiente_ocupacion = getPost('acudiente_ocupacion');
    $responsable_legal = getPost('responsable_legal') == 'Sí' ? 1 : 0;
    $padre_nombres = getPost('padre_nombres');
    $padre_tipo_doc = getPost('padre_tipo_doc');
    $padre_num_doc = getPost('padre_num_doc');
    $padre_direccion = getPost('padre_direccion');
    $padre_tel = getPost('padre_tel');
    $padre_email = getPost('padre_email');
    $padre_ocupacion = getPost('padre_ocupacion');
    $padre_contacto = isset($_POST['padre_contacto']) && $_POST['padre_contacto'] == 'on' ? 1 : 0;
    $madre_nombres = getPost('madre_nombres');
    $madre_tipo_doc = getPost('madre_tipo_doc');
    $madre_num_doc = getPost('madre_num_doc');
    $madre_direccion = getPost('madre_direccion');
    $madre_tel = getPost('madre_tel');
    $madre_email = getPost('madre_email');
    $madre_ocupacion = getPost('madre_ocupacion');
    $madre_contacto = isset($_POST['madre_contacto']) && $_POST['madre_contacto'] == 'on' ? 1 : 0;
    $escolaridad = getPost('escolaridad');
    $institucion = getPost('institucion');
    $ultimo_grado = getPost('ultimo_grado');
    $obs_psicologicas = getPost('obs_psicologicas');
    $obs_sociales = getPost('obs_sociales');
    $funcionario_recibe = getPost('funcionario_recibe');
    $remitente_final = getPost('remitente_final');
    
    // Validar campos obligatorios
    if (empty($menor_nombres) || empty($fecha_ingreso)) {
        echo json_encode(['success' => false, 'error' => 'Los campos obligatorios no pueden estar vacíos']);
        exit();
    }
    
    // Construir la consulta SQL
    $query = "INSERT INTO ingresos_fundacion (
        fundacion_nombre, fundacion_direccion, resp_telefono, resp_email, resp_cargo,
        fecha_ingreso, hora_ingreso, motivo_ingreso, tipo_ingreso, responsable_remite,
        entidad_remite, doc_tipo, doc_numero, numero_proceso, fecha_remision,
        menor_nombres, menor_tipo_doc, menor_num_doc, fecha_nacimiento, edad, sexo,
        nacionalidad, lugar_nacimiento, direccion_domicilio, eps, salud_general, alergias,
        discapacidad, cual_discapacidad, acudiente_nombres, acudiente_tipo_doc, acudiente_num_doc,
        acudiente_parentesco, acudiente_direccion, acudiente_tel, acudiente_email, acudiente_ocupacion,
        responsable_legal, padre_nombres, padre_tipo_doc, padre_num_doc, padre_direccion,
        padre_tel, padre_email, padre_ocupacion, padre_contacto, madre_nombres,
        madre_tipo_doc, madre_num_doc, madre_direccion, madre_tel, madre_email,
        madre_ocupacion, madre_contacto, escolaridad, institucion, ultimo_grado,
        obs_psicologicas, obs_sociales, funcionario_recibe, remitente_final
    ) VALUES (
        '$fundacion_nombre', '$fundacion_direccion', '$resp_telefono', '$resp_email', '$resp_cargo',
        '$fecha_ingreso', '$hora_ingreso', '$motivo_ingreso', '$tipo_ingreso', '$responsable_remite',
        '$entidad_remite', '$doc_tipo', '$doc_numero', '$numero_proceso', '$fecha_remision',
        '$menor_nombres', '$menor_tipo_doc', '$menor_num_doc', '$fecha_nacimiento', '$edad', '$sexo',
        '$nacionalidad', '$lugar_nacimiento', '$direccion_domicilio', '$eps', '$salud_general', '$alergias',
        '$discapacidad', '$cual_discapacidad', '$acudiente_nombres', '$acudiente_tipo_doc', '$acudiente_num_doc',
        '$acudiente_parentesco', '$acudiente_direccion', '$acudiente_tel', '$acudiente_email', '$acudiente_ocupacion',
        '$responsable_legal', '$padre_nombres', '$padre_tipo_doc', '$padre_num_doc', '$padre_direccion',
        '$padre_tel', '$padre_email', '$padre_ocupacion', '$padre_contacto', '$madre_nombres',
        '$madre_tipo_doc', '$madre_num_doc', '$madre_direccion', '$madre_tel', '$madre_email',
        '$madre_ocupacion', '$madre_contacto', '$escolaridad', '$institucion', '$ultimo_grado',
        '$obs_psicologicas', '$obs_sociales', '$funcionario_recibe', '$remitente_final'
    )";
    
    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'id' => mysqli_insert_id($conexion)]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>