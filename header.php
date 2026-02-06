<head>
  <meta charset="UTF-8">
  <title>Inicio - Sistema ICBF</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<header>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #007d38;">

      <div class="container">

        <!-- LOGO (IZQUIERDA) -->
        <a class="navbar-brand d-flex align-items-center" href="inicio.php">

          <img src="imagenes/logo.png" width="70" class="me-2">

          <span>ICBF</span>

        </a>


        <!-- BOTÓN MÓVIL -->
        <button class="navbar-toggler" type="button"
          data-bs-toggle="collapse"
          data-bs-target="#menuNavbar">

          <span class="navbar-toggler-icon"></span>
        </button>


        <!-- CONTENIDO -->
        <div class="collapse navbar-collapse" id="menuNavbar">

          <!-- MENÚ (CENTRO) -->
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a class="nav-link text-white" href="inicio.php">
                Inicio
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white" href="Fundaciones.php">
                Fundaciones
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white" href="Redes_de_apoyo.php">
                Redes
              </a>
            </li>

          </ul>


          <!-- LOGIN (DERECHA) -->
          <div class="d-flex">

            <a href="login.php" class="btn btn-outline-light me-2">
              Iniciar sesión
            </a>

            <a href="registro.php" class="btn btn-light text-success">
              Registrarse
            </a>

          </div>

        </div>

      </div>

    </nav>

  </header>