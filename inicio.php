<!--encabezado principal-->

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Inicio - Sistema ICBF</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<?php
include("header.php");
?>



  <!-- CONTENIDO PRINCIPAL -->
  <div class="container py-5">

    <div class="row g-4 justify-content-center">

      <!-- REGISTRAR USUARIO -->
      <div class="col-md-4 col-sm-12">

        <div class="card h-100 shadow text-center">

          <h5 class="card-header bg-primary text-white">
            REGISTRAR USUARIO
          </h5>

          <img src="imagenes/registrarse2.png" class="mx-auto mt-3" width="180">

          <div class="card-body">

            <p>
              Si eres funcionario del ICBF, fundación o familiar,
              regístrate en el sistema.
            </p>
          </div>
          <a href="REGISTRARUSUARIO.php" class="btn btn-success">
            Registrarse
          </a>
        </div>

      </div>


      <!-- REGISTRAR FUNDACIÓN -->
      <div class="col-md-4 col-sm-12">

        <div class="card h-100 shadow text-center">

          <h5 class="card-header bg-success text-white">
            REGISTRAR FUNDACIÓN
          </h5>

          <img src="imagenes/institucion.png" class="mx-auto mt-3" width="180">

          <div class="card-body">

            <p>
              Registra tu fundación y solicita afiliación.
            </p>
          </div>
          <a href="#" class="btn btn-success">
            Inscribir
          </a>
        </div>
      </div>


      <!-- REDES -->
      <div class="col-md-4 col-sm-12">

        <div class="card h-100 shadow text-center">

          <h5 class="card-header bg-success text-white">
            REDES DE APOYO
          </h5>

          <img src="imagenes/red de apoyo.png" class="mx-auto mt-3" width="180">

          <div class="card-body">

            <p>
              Información de entidades de protección infantil.
            </p>
          </div>
          <a href="Redes de apoyo.php" class="btn btn-success">
            Ver
          </a>

        </div>

      </div>

    </div>



    <!-- SEGUNDO BLOQUE -->
    <div class="row justify-content-center mt-5">

      <div class="col-md-6 col-sm-12">

        <div class="card shadow text-center">

          <h5 class="card-header bg-success text-white">
            CONSULTAR INFORMACIÓN
          </h5>

          <img src="imagenes/consultar.png" class="mx-auto mt-3" width="180">

          <div class="card-body">

            <p>
              Ingresa al motor de búsqueda.
            </p>

          </div>
          <a href="resultados.php" class="btn btn-success">
            Consultar
          </a>
        </div>

      </div>

    </div>


  </div>



  <!-- WIDGETS -->
  <div class="container mb-5">

    <div class="row text-center g-4">

      <!-- CALENDARIO -->
      <div class="col-md-6 col-sm-12">

        <div class="card p-3 bg-success text-white shadow">

          <h5>Calendario</h5>

          <input type="date" class="form-control">

        </div>

      </div>


      <!-- RELOJ -->
      <div class="col-md-6 col-sm-12">

        <div class="card p-3 bg-success text-white shadow">

          <h5>Reloj</h5>

          <div id="clock" class="fs-4"></div>

        </div>

      </div>

    </div>

  </div>


  <!-- FOOTER -->
  <footer class="text-center py-3 bg-dark text-white">

    <?php
    echo "Sistema ICBF © " . date("Y");
    ?>

  </footer>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


  <!-- RELOJ -->
  <script>
    function reloj() {

      const now = new Date();

      let hora = now.toLocaleTimeString();

      document.getElementById("clock").innerHTML = hora;
    }
    setInterval(reloj, 1000);
  </script>


</body>

<?php
include("footer.php");
?>