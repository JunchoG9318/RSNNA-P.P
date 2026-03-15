<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">

            <div class="alert alert-success">

                <h4>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></h4>

                <p><strong>Tipo de usuario:</strong> <?php echo $_SESSION['usuario_tipo']; ?></p>
                <p><strong>ID:</strong> <?php echo $_SESSION['usuario_id']; ?></p>
                <p><strong>Correo:</strong> <?php echo $_SESSION['usuario_correo']; ?></p>

                <hr>

                <h5>Gestión de Funcionarios</h5>

                <!-- Registrar funcionario -->
                <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/F_R_F_Fundacion.php"
                   class="btn btn-primary me-2">
                   Registrar Funcionario
                </a>

                <!-- Ver funcionarios -->
                <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/listar_funcionarios.php"
                   class="btn btn-success me-2">
                   Ver Funcionarios
                </a>

                <!-- Ver información de la fundación -->
                <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/administrar_fundacion.php"
                   class="btn btn-warning me-2">
                   Ver Información de la Fundación
                </a>

                <!-- Cerrar sesión -->
                <a href="<?php echo BASE_URL; ?>views/modules/login/logout.php"
                   class="btn btn-danger">
                   Cerrar Sesión
                </a>

            </div>

        </div>
    </div>
</div>

<?php include("../../../footer.php"); ?>