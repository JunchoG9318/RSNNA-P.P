<?php
session_start();

function verificarSesion() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: " . BASE_URL . "views/modules/login/login.php");
        exit();
    }
}

function verificarTipoUsuario($tipos_permitidos) {
    if (!in_array($_SESSION['usuario_tipo'], $tipos_permitidos)) {
        header("Location: " . BASE_URL . "dashboard.php?error=acceso_denegado");
        exit();
    }
}
?>