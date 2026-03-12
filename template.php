<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/proyectoclon/RSNNA-P.P/');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/flatpickr.min.css">
    <script src="<?php echo BASE_URL ?>views/js/sweetalert2.js"></script>
    <title>Proyecto curso PHP</title>
</head>

<body>
    <body>
        <?php
        include("inicio.php");
        ?>
    </body>


    <section>
        <?php
        $controlador = new Controlador();
        $controlador->enlacesPaginasControlador();

        ?>

    </section>



    <script src="<?php echo BASE_URL ?>js/popper.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/buscar_interno.js"></script>
    <script src="<?php echo BASE_URL ?>js/sweetalert2.js"></script>
    <script src="<?php echo BASE_URL ?>js/flatpickr.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.bundle.min.js"></script>



</body>

</html>