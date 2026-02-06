<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/prototipo_proyecto/');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/css/bootstrap-icons.min.css">
    <script src="<?php echo BASE_URL ?>views/js/sweetalert2.js"></script>
    <title>Proyecto curso PHP</title>
</head>

<body>
    <header>
        <?php
        include("header.php");
        ?>
    </header>

    <section>
        <?php
        $controlador = new Controlador();
        $controlador->enlacesPaginasControlador();

        ?>

    </section>

    <footer>
        <?php
        include("footer.php")
        ?>
    </footer>


    <script src="<?php echo BASE_URL ?>js/popper.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/buscar_interno.js"></script>

    
    
</body>

</html>