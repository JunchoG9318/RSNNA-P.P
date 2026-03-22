<?php
session_start();
require_once("../../../config/conexion.php");

// Definir la URL base para redireccionamientos
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");

// Verificar si se enviaron los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener datos con validación (evita errores de array key)
    $id_fundacion = isset($_POST['id_fundacion']) ? (int)$_POST['id_fundacion'] : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
    $tipo_documento = isset($_POST['tipo_documento']) ? trim($_POST['tipo_documento']) : '';
    $documento = isset($_POST['documento']) ? trim($_POST['documento']) : '';
    
    // Manejo de fechas: si vienen vacías, asignar null
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : null;
    if ($fecha_nacimiento === '') {
        $fecha_nacimiento = null;
    }
    
    $nacionalidad = isset($_POST['nacionalidad']) ? trim($_POST['nacionalidad']) : '';
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $departamento = isset($_POST['departamento']) ? trim($_POST['departamento']) : '';
    $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : '';
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $pais = isset($_POST['pais']) ? trim($_POST['pais']) : '';
    
    // FALTABAN ESTOS CAMPOS EN TU FORMULARIO
    $nivel_escolar = isset($_POST['nivel_escolar']) ? trim($_POST['nivel_escolar']) : '';
    $institucion = isset($_POST['institucion']) ? trim($_POST['institucion']) : '';
    $titulo_obtenido = isset($_POST['titulo_obtenido']) ? trim($_POST['titulo_obtenido']) : '';
    $empresa = isset($_POST['empresa']) ? trim($_POST['empresa']) : '';
    $cargo = isset($_POST['cargo']) ? trim($_POST['cargo']) : '';
    
    // Manejo de fechas de experiencia laboral
    $fecha_inicio = isset($_POST['fecha_inicio']) ? trim($_POST['fecha_inicio']) : null;
    if ($fecha_inicio === '') {
        $fecha_inicio = null;
    }
    
    $fecha_fin = isset($_POST['fecha_fin']) ? trim($_POST['fecha_fin']) : null;
    if ($fecha_fin === '') {
        $fecha_fin = null;
    }

    // Validar campos obligatorios
    if (empty($id_fundacion) || empty($nombre) || empty($apellidos) || empty($celular)) {
        die("Error: Faltan campos obligatorios (fundación, nombre, apellidos, celular)");
    }

    // Validar género (solo M, F, O)
    if (!in_array($genero, ['M', 'F', 'O'])) {
        $genero = 'O'; // Por defecto Otro si no es válido
    }

    // Validar formato de fecha (solo si no son null)
    if ($fecha_nacimiento !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento)) {
        $fecha_nacimiento = null;
    }
    if ($fecha_inicio !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_inicio)) {
        $fecha_inicio = null;
    }
    if ($fecha_fin !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_fin)) {
        $fecha_fin = null;
    }

    // Usar sentencias preparadas para evitar SQL Injection
    $sql = "INSERT INTO funcionarios(
        id_fundacion,
        nombre,
        apellidos,
        tipo_documento,
        documento,
        fecha_nacimiento,
        nacionalidad,
        genero,
        direccion,
        departamento,
        ciudad,
        pais,
        celular,
        correo,
        nivel_escolar,
        institucion,
        titulo_obtenido,
        empresa,
        cargo,
        fecha_inicio,
        fecha_fin
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        // Vincular parámetros (i = integer, s = string)
        $stmt->bind_param(
            "issssssssssssssssssss",
            $id_fundacion,
            $nombre,
            $apellidos,
            $tipo_documento,
            $documento,
            $fecha_nacimiento,
            $nacionalidad,
            $genero,
            $direccion,
            $departamento,
            $ciudad,
            $pais,
            $celular,
            $correo,
            $nivel_escolar,
            $institucion,
            $titulo_obtenido,
            $empresa,
            $cargo,
            $fecha_inicio,
            $fecha_fin
        );

        if ($stmt->execute()) {
            // Redirigir a la página de origen con mensaje de éxito
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'registro_funcionario.php';
            header("Location: $referer?success=1");
            exit();
        } else {
            // Error al ejecutar
            echo "<h3>Error al guardar el funcionario:</h3>";
            echo "<p>" . $stmt->error . "</p>";
            echo "<p><a href='javascript:history.back()'>Volver al formulario</a></p>";
        }
        $stmt->close();
    } else {
        echo "<h3>Error al preparar la consulta:</h3>";
        echo "<p>" . $conexion->error . "</p>";
        echo "<p><a href='javascript:history.back()'>Volver al formulario</a></p>";
    }

} else {
    // Si no es POST, redirigir al formulario
    header("Location: registro_funcionario.php");
    exit();
}

// Cerrar conexión
$conexion->close();
?>