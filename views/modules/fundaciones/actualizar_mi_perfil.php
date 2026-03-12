<?php
session_start();
require_once("../../../config/conexion.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario_id = intval($_SESSION['usuario_id']);
    
    // Obtener y sanitizar datos
    $tipo_documento = mysqli_real_escape_string($conexion, $_POST['tipo_documento'] ?? '');
    $documento = mysqli_real_escape_string($conexion, $_POST['documento'] ?? '');
    $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento'] ?? '');
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion'] ?? '');
    $celular = mysqli_real_escape_string($conexion, $_POST['celular'] ?? '');
    $correo_alternativo = mysqli_real_escape_string($conexion, $_POST['correo_alternativo'] ?? '');
    $nacionalidad = mysqli_real_escape_string($conexion, $_POST['nacionalidad'] ?? '');
    $genero = mysqli_real_escape_string($conexion, $_POST['genero'] ?? '');
    $pais = mysqli_real_escape_string($conexion, $_POST['pais'] ?? '');
    $departamento = mysqli_real_escape_string($conexion, $_POST['departamento'] ?? '');
    $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad'] ?? '');
    $cargo = mysqli_real_escape_string($conexion, $_POST['cargo'] ?? '');
    
    // Actualizar en la tabla usuarios (solo campos que existen)
    $query = "UPDATE usuarios SET 
                telefono = '$celular'
              WHERE id = $usuario_id";
    
    if (mysqli_query($conexion, $query)) {
        // Actualizar también en tabla funcionarios si existe
        $check_funcionario = mysqli_query($conexion, "SELECT id FROM funcionarios WHERE id_usuario = $usuario_id");
        
        if (mysqli_num_rows($check_funcionario) > 0) {
            // Actualizar funcionario existente
            $query_func = "UPDATE funcionarios SET 
                tipo_documento = '$tipo_documento',
                documento = '$documento',
                fecha_nacimiento = '$fecha_nacimiento',
                direccion = '$direccion',
                celular = '$celular',
                nacionalidad = '$nacionalidad',
                genero = '$genero',
                pais = '$pais',
                departamento = '$departamento',
                ciudad = '$ciudad',
                cargo = '$cargo'
                WHERE id_usuario = $usuario_id";
        } else {
            // Insertar nuevo funcionario
            $query_func = "INSERT INTO funcionarios (
                id_usuario, id_fundacion, nombre, apellidos, 
                tipo_documento, documento, fecha_nacimiento,
                nacionalidad, genero, direccion, departamento,
                ciudad, pais, celular, correo, cargo
            ) VALUES (
                $usuario_id, 
                " . ($_SESSION['id_fundacion'] ?? 'NULL') . ",
                '" . explode(' ', $_SESSION['usuario_nombre'] ?? '')[0] . "',
                '" . (isset(explode(' ', $_SESSION['usuario_nombre'] ?? '')[1]) ? explode(' ', $_SESSION['usuario_nombre'])[1] : '') . "',
                '$tipo_documento', '$documento', '$fecha_nacimiento',
                '$nacionalidad', '$genero', '$direccion', '$departamento',
                '$ciudad', '$pais', '$celular', '$correo_alternativo', '$cargo'
            )";
        }
        
        if (isset($query_func)) {
            mysqli_query($conexion, $query_func);
        }
        
        $_SESSION['mensaje'] = "Perfil actualizado correctamente";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el perfil";
        $_SESSION['tipo_mensaje'] = "danger";
    }
    
    header("Location: mi_perfil.php");
    exit();
}
?>