<?php
session_start();
include("../../../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {

        $datos = mysqli_fetch_assoc($resultado);

        $_SESSION['tipo_usuario'] = $datos['tipo_usuario'];
        $_SESSION['usuario'] = $datos['usuario'];
        $_SESSION['id_usuario'] = $datos['id'];
        $_SESSION['id_fundacion'] = $datos['id_fundacion']; // ESTA LINEA ES LA IMPORTANTE
        $_SESSION['id'] = $datos['id'];

        header("Location: ../login/dashboard.php");
        exit();
    } else {

        header("Location: ../login/login.php?error=1");
        exit();
    }
}
