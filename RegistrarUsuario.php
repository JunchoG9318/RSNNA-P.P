<?php
include("header.php");
?>
    <!--parte1-->
    <div class="container-registros">
      <div class="row m-5 mb-5">
        <div class="col d-flex justify-content-center text-center">
          <div class="card">
            <h5
              class="card-title text-center"
              style="
                background: linear-gradient(to right, rgb(0, 255, 0), green);
              "
            >
              FUNCIONARIO ICBF
            </h5>
            <img
              src="imagenes/funICBF.jpg"
              class="card-img-center"
              alt="..."
              style="height: 200px; left: auto"
            />
            <div class="card-body">
              <p class="card-text text-center">
                Si eres funcionario del ICBF, ingresa en esta seccion y realiza
                el correspondiente registro personal, sigue el paso a paso y
                envia el Formulario.
              </p>
              <a href="##" class="btn btn-primary">registrarse</a>
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center text-center">
          <div class="card">
            <h5
              class="card-title"
              style="
                background: linear-gradient(to right, rgb(0, 255, 0), green);
              "
            >
              FUNCIONARIO FUNDACIÓN
            </h5>
            <img
              src="imagenes/TSFUN.jpg"
              class="card-img-center"
              alt="..."
              style="height: 200px; left: auto"
            />
            <div class="card-body">
              <p class="card-text">
                Si eres funcionario de alguna fundacion, ingresa en esta seccion
                y realiza el correspondiente registro personal, sigue el paso a
                paso y envia el Formulario.
              </p>
              <a href="ERF.php" class="btn btn-primary"
                >registrarse</a
              >
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center text-center">
          <div class="card">
            <h5
              class="card-title"
              style="
                background: linear-gradient(to right, rgb(0, 255, 0), green);
              "
            >
              FAMILIAR
            </h5>
            <img
              src="imagenes/FAMILIA.jpg"
              class="card-img-center"
              alt="..."
              style="height: 200px; left: auto"
            />
            <div class="card-body">
              <p class="card-text-justify">
                Ingresa a esta sección para registrarte como el representante
                legal de un NNA que pertenesca a este sistema de protección
                infantil.
              </p>
              <a href="#" class="btn btn-primary">registrarse</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php
  include("footer.php");
  ?>


