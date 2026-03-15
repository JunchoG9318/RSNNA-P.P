<?php
session_start();
require_once("../../../config/conexion.php");

// Verificar si se enviaron los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener datos con validación (evita errores de array key)
    $id_fundacion = isset($_POST['id_fundacion']) ? $_POST['id_fundacion'] : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
    $tipo_documento = isset($_POST['tipo_documento']) ? trim($_POST['tipo_documento']) : '';
    $documento = isset($_POST['documento']) ? trim($_POST['documento']) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '';
    $nacionalidad = isset($_POST['nacionalidad']) ? trim($_POST['nacionalidad']) : '';
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $departamento = isset($_POST['departamento']) ? trim($_POST['departamento']) : '';
    $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : '';
    $pais = isset($_POST['pais']) ? trim($_POST['pais']) : '';
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $cargo = isset($_POST['cargo']) ? trim($_POST['cargo']) : '';

    // Validar género (solo M, F, O)
    if (!in_array($genero, ['M', 'F', 'O'])) {
        $genero = 'O';
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
        cargo
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        // Vincular parámetros (s = string, i = integer)
        $stmt->bind_param(
            "issssssssssssss",
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
            $cargo
        );

        if ($stmt->execute()) {
            header("Location: panel_fundacion.php?ok=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }

} else {
    echo "Método no permitido";
}
?>