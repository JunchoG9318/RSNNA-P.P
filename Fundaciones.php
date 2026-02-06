<?php
include("header.php");
?>
  <body>
    <!--parte1-->
    <div class="container-registros">
      <div class="row m-5 mb-5">
        <div class="col d-flex justify-content-center text-center">
          <div
            id="carouselExampleDark"
            class="carousel carousel-dark slide"
            data-bs-ride="carousel"
          >
            <div class="carousel-indicators">
              <button
                type="button"
                data-bs-target="#carouselExampleDark"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleDark"
                data-bs-slide-to="1"
                aria-label="Slide 2"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleDark"
                data-bs-slide-to="2"
                aria-label="Slide 3"
              ></button>
            </div>
            <div
              class="carousel-inner"
              style="width: auto; height: 600px; margin: 5px"
            >
              <div class="carousel-item active" data-bs-interval="10000">
                <h5 style="background-color: green; border-bottom: 10px">
                  FUNDACION CERES
                </h5>
                <br />
                <img
                  src="imagenes/fundaciones/fun ceres.png"
                  class="d-block w-100"
                  alt="..."
                /><br />
                <a
                  href="https://www.facebook.com/profile.php?id=61553745144337"
                >
                  <button>Más información</button></a
                >
                <div class="carousel-caption d-none d-md-block"><br /></div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <h5 style="background-color: green; border-bottom: 10px">
                  FUNDACION MANANTIAL DE VIDA
                </h5>
                <br />
                <img
                  src="imagenes/fundaciones/Manantial de vida.jpg"
                  class="d-block w-100"
                  alt="..."
                /><br />
                <a href="https://manantialdevidagirardot.blogspot.com/">
                  <button>Más información</button></a
                >
                <div class="carousel-caption d-none d-md-block"><br /></div>
              </div>
              <div class="carousel-item">
                <h5 style="background-color: green; border-bottom: 10px">
                  FUNDACION SANTA MARIA
                </h5>
                <br />
                <img
                  src="imagenes/fundaciones/santa maria.png"
                  class="d-block w-100"
                  alt="..."
                /><br />
                <a href="https://fundacionsantamaria.co/">
                  <button>Más información</button></a
                >
                <div class="carousel-caption d-none d-md-block"></div>
              </div>
            </div>
            <button
              class="carousel-control-prev"
              type="button"
              data-bs-target="#carouselExampleDark"
              data-bs-slide="prev"
            >
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button
              class="carousel-control-next"
              type="button"
              data-bs-target="#carouselExampleDark"
              data-bs-slide="next"
            >
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>

  <!-- Footer -->
  <?php
  include("footer.php");
  ?>