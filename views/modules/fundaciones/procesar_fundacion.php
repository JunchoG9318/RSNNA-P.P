<?php
// Activar visualización de errores (solo para desarrollo, quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../../../config/conexion.php"); // Ajusta la ruta según tu estructura

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar que todos los campos POST existen
    $campos_requeridos = [
        'nombre',
        'nit',
        'fecha_constitucion',
        'tipo',
        'nombre_director',
        'correo_director',
        'telefono_director',
        'direccion',
        'pais',
        'departamento',
        'ciudad'
    ];

    foreach ($campos_requeridos as $campo) {
        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
            header("Location: RegistrarFundacion.php?error=campos_vacios");
            exit();
        }
    }

    // Obtener y limpiar los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $nit = mysqli_real_escape_string($conexion, trim($_POST['nit']));
    $fecha_constitucion = mysqli_real_escape_string($conexion, $_POST['fecha_constitucion']);
    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $nombre_director = mysqli_real_escape_string($conexion, trim($_POST['nombre_director']));
    $correo_director = mysqli_real_escape_string($conexion, trim($_POST['correo_director']));
    $telefono_director = mysqli_real_escape_string($conexion, trim($_POST['telefono_director']));

    // NUEVOS CAMPOS DE DIRECCIÓN
    $direccion = mysqli_real_escape_string($conexion, trim($_POST['direccion']));
    $pais = mysqli_real_escape_string($conexion, $_POST['pais']);
    $departamento = mysqli_real_escape_string($conexion, $_POST['departamento']);
    $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);

    // Validar formato de correo
    if (!filter_var($correo_director, FILTER_VALIDATE_EMAIL)) {
        header("Location: RegistrarFundacion.php?error=correo_invalido");
        exit();
    }

    // Verificar conexión a la base de datos
    if (!$conexion) {
        header("Location: RegistrarFundacion.php?error=registro_fallido&detalle=" . urlencode("Error de conexión a la base de datos"));
        exit();
    }

    // Verificar si el NIT ya existe
    $check_nit = mysqli_query($conexion, "SELECT id, nombre FROM fundaciones WHERE nit = '$nit'");

    if (!$check_nit) {
        // Error en la consulta
        header("Location: RegistrarFundacion.php?error=registro_fallido&detalle=" . urlencode(mysqli_error($conexion)));
        exit();
    }

    if (mysqli_num_rows($check_nit) > 0) {
        $row = mysqli_fetch_assoc($check_nit);
        // Redirigir con información del registro existente
        header("Location: RegistrarFundacion.php?error=nit_existe&id=" . $row['id'] . "&nombre=" . urlencode($row['nombre']));
        exit();
    }

    // Insertar los datos en la tabla fundaciones con los nuevos campos
    $query = "INSERT INTO fundaciones (
        nombre, 
        nit, 
        fecha_constitucion, 
        tipo, 
        nombre_director, 
        correo_director, 
        telefono_director,
        direccion,
        pais,
        departamento,
        ciudad
    ) VALUES (
        '$nombre', 
        '$nit', 
        '$fecha_constitucion', 
        '$tipo', 
        '$nombre_director', 
        '$correo_director', 
        '$telefono_director',
        '$direccion',
        '$pais',
        '$departamento',
        '$ciudad'
    )";

    if (mysqli_query($conexion, $query)) {
        // Registro exitoso - Redirigir con éxito
        header("Location: RegistrarFundacion.php?success=1");
        exit();
    } else {
        // Error en la inserción
        $error_detalle = mysqli_error($conexion);
        header("Location: RegistrarFundacion.php?error=registro_fallido&detalle=" . urlencode($error_detalle));
        exit();
    }
} else {
    // Si alguien intenta acceder directamente sin enviar el formulario
    header("Location: RegistrarFundacion.php");
    exit();
}
