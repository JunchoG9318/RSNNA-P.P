<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
include("..//..//header.php");
?>

<div class="container my-5">

    <!-- Bienvenida -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-bold">
                Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋
            </h4>
            <p class="text-muted mb-0">
                Has iniciado sesión correctamente en el sistema.
            </p>
        </div>
    </div>

    <!-- Opciones principales -->
    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Formulario</h5>
                    <p class="card-text">
                        Registrar información personal y laboral.
                    </p>
                    <a href="<?php echo BASE_URL; ?>modulos/formulario/index.php" class="btn btn-success">
                        Ir al formulario
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Perfil</h5>
                    <p class="card-text">
                        Ver o editar tu información.
                    </p>
                    <a href="<?php echo BASE_URL; ?>perfil.php" class="btn btn-primary">
                        Ver perfil
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Cerrar sesión</h5>
                    <p class="card-text">
                        Salir del sistema de manera segura.
                    </p>
                    <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-danger">
                        Cerrar sesión
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include("..//..//footer.php"); ?>