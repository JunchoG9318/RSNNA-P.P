<?php
include("../../../header.php");
// <!--session_start();-->
?>
<hr>
<!--parte1-->
<div class="container-registros">
  <div class="row m-5 align-items-center">

    <!-- COLUMNA TEXTO -->
    <div class="col-md-6 mb-4">

      <div class="card shadow-sm h-100">

        <div class="card-body text-center text-md-start">

          <h4 class="card-title mb-3 text-success">
            Bienvenido al Registro ICBF
          </h4>

          <p class="card-text">
            En esta sección podrás realizar tu proceso de inscripción como
            funcionario del ICBF. Sigue cuidadosamente cada paso y completa
            el formulario con información verídica.
          </p>

          <p class="card-text">
            Este registro es obligatorio para continuar con los procesos
            institucionales.
          </p>

        </div>

      </div>

    </div>

    <!-- COLUMNA TARJETA -->
    <div class="col-md-6 d-flex justify-content-center">

      <div class="card" style="width: 20rem;">

        <h5
          class="card-title text-center text-white p-2"
          style="background: linear-gradient(to right, #007d38);">
          FUNCIONARIO ICBF
        </h5>

        <img
          src="/proyectoclon/RSNNA-P.P/imagenes/funICBF.jpg"
          class="card-img-top"
          alt="Funcionario ICBF"
          style="height: 200px; object-fit: cover;" />

        <div class="card-body">

          <p class="card-text text-center">
            Si eres funcionario del ICBF, ingresa en esta sección y realiza
            el registro personal.
          </p>

          <div class="text-center">
            <a href="registro_icbf.php" class="btn btn-primary">
              Registrarse
            </a>
          </div>

        </div>

      </div>

    </div>

  </div>
</div>
<hr>

<div class="container-registros">
  <div class="row m-5 align-items-center">

    <!-- COLUMNA TEXTO -->
    <div class="col-md-6 mb-4">

      <div class="card shadow-sm h-100 border-success border-2">

        <div class="card-body text-center text-md-start">

          <h4 class="card-title mb-3 text-success">
            Registro Fundación
          </h4>

          <p class="card-text">
            En esta sección los funcionarios de fundaciones podrán realizar
            su proceso de inscripción de manera segura y organizada.
          </p>

          <p class="card-text">
            Recuerda completar todos los campos correctamente antes de enviar
            el formulario.
          </p>

        </div>

      </div>

    </div>


    <!-- COLUMNA TARJETA -->
    <div class="col-md-6 d-flex justify-content-center">

      <div class="card" style="width: 20rem;">

        <h5
          class="card-title text-center text-white p-2"
          style="background: linear-gradient(to right, #007d38);">
          FUNCIONARIO FUNDACIÓN
        </h5>

        <img
          src="/proyectoclon/RSNNA-P.P/imagenes/TSFUN.jpg"
          class="card-img-top"
          alt="Funcionario Fundación"
          style="height: 200px; object-fit: cover;" />

        <div class="card-body">

          <p class="card-text text-center">
            Si eres funcionario de alguna fundación, ingresa y realiza
            el registro correspondiente.
          </p>

          <div class="text-center">
            <a href="/proyectoclon/RSNNA-P.P/ERF.php" class="btn btn-primary">
              Registrarse
            </a>
          </div>

        </div>

      </div>

    </div>

  </div>
</div>
<hr>
<div class="container-registros">
  <div class="row m-5 align-items-center">

    <!-- COLUMNA TEXTO -->
    <div class="col-md-6 mb-4">

      <div class="card shadow-sm h-100 border-success border-2">

        <div class="card-body text-center text-md-start">

          <h4 class="card-title mb-3 text-success">
            Registro Familiar
          </h4>

          <p class="card-text">
            Esta sección está dirigida a los familiares o representantes
            legales de niños, niñas y adolescentes vinculados al sistema
            de protección infantil.
          </p>

          <p class="card-text">
            Aquí podrás realizar el proceso de registro de forma segura,
            responsable y confiable.
          </p>

          <p class="card-text">
            Asegúrate de contar con la documentación necesaria antes de
            iniciar el formulario.
          </p>

        </div>

      </div>

    </div>
    <!-- COLUMNA TARJETA -->
    <div class="col-md-6 d-flex justify-content-center">

      <div class="card" style="width: 20rem;">

        <h5
          class="card-title text-center text-white p-2"
          style="background: linear-gradient(to right, #007d38);">
          FAMILIAR
        </h5>

        <img
          src="/proyectoclon/RSNNA-P.P/imagenes/FAMILIA.jpg"
          class="card-img-top"
          alt="Registro Familiar"
          style="height: 200px; object-fit: cover;" />

        <div class="card-body">

          <p class="card-text text-center">
            Ingresa para registrarte como representante legal de un NNA
            dentro del sistema de protección infantil.
          </p>

          <div class="text-center">
            <a href="<?php echo BASE_URL; ?>views/modules/Familias/registro_familiar.php" class="btn btn-primary">
              Registrarse
            </a>

          </div>

        </div>

      </div>

    </div>

  </div>
</div>

<!-- Clock Script -->
<script>
  function updateClock() {
    const now = new Date();
    document.getElementById("clock").textContent = now.toLocaleTimeString();
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>

<script src="js/bootstrap.bundle.min.js"></script>
<?php
include("../../../footer.php");
?>