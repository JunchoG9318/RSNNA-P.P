<?php
session_start();
include("../../../config/conexion.php"); // Ajusta la ruta según tu estructura

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    // Consulta para verificar el usuario (ajusta según tu BD)
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($resultado) == 1) {
        $_SESSION['usuario'] = $usuario;
        header("Location: dashboard.php"); // Redirige al panel principal
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>