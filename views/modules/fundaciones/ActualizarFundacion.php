<?php
include("conexion.php");

$id = $_GET['id']; // ID de la fundación

$sql = "SELECT * FROM fundaciones WHERE id = '$id'";
$resultado = mysqli_query($conexion, $sql);

$fila = mysqli_fetch_assoc($resultado);
?>
<?php
include ("header.php");
?>
<br>
<?php
include("conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM fundaciones WHERE id = '$id'";
$resultado = mysqli_query($conexion, $sql);

$fila = mysqli_fetch_assoc($resultado);
?> 

<body>

<div class="main-content">

  <div class="container mt-5 mb-5">

    <div class="row justify-content-center">

      <div class="col-12 col-md-10 col-lg-8">

        <div class="card shadow">

          <div class="card-header bg-warning text-white text-center">
            <h4>Actualizar Fundación</h4>
          </div>

          <div class="card-body">

            <!-- FORMULARIO ACTUALIZAR -->
            <form action="actualizar_fundacion.php" method="POST">

              <!-- ID OCULTO -->
              <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

              <!-- Datos Generales -->
              <h5 class="mb-3">Datos Generales</h5>

              <div class="mb-3">
                <label class="form-label">Nombre</label>

                <input type="text"
                  name="nombre"
                  class="form-control"
                  value="<?php echo $fila['nombre']; ?>"
                  required>
              </div>

              <div class="mb-3">
                <label class="form-label">NIT</label>

                <input type="text"
                  name="nit"
                  class="form-control"
                  value="<?php echo $fila['nit']; ?>"
                  required>
              </div>

              <div class="mb-3">
                <label class="form-label">Fecha</label>

                <input type="date"
                  name="fecha_constitucion"
                  class="form-control"
                  value="<?php echo $fila['fecha_constitucion']; ?>"
                  required>
              </div>

              <div class="mb-3">
                <label class="form-label">Tipo</label>

                <select name="tipo" class="form-select" required>

                  <option value="">Seleccione</option>

                  <option value="social"
                    <?php if($fila['tipo']=="social") echo "selected"; ?>>
                    Social
                  </option>

                  <option value="educativa"
                    <?php if($fila['tipo']=="educativa") echo "selected"; ?>>
                    Educativa
                  </option>

                  <option value="ambiental"
                    <?php if($fila['tipo']=="ambiental") echo "selected"; ?>>
                    Ambiental
                  </option>

                  <option value="salud"
                    <?php if($fila['tipo']=="salud") echo "selected"; ?>>
                    Salud
                  </option>

                  <option value="otra"
                    <?php if($fila['tipo']=="otra") echo "selected"; ?>>
                    Otra
                  </option>

                </select>
              </div>

              <div class="mb-4">
                <label class="form-label">Descripción</label>

                <textarea name="descripcion"
                  class="form-control"
                  rows="3"
                  required><?php echo $fila['descripcion']; ?></textarea>
              </div>

              <!-- BOTONES -->
              <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">

                <button type="submit"
                  class="btn btn-success flex-fill me-sm-2">
                  Actualizar
                </button>

                <a href="inicio.php"
                  class="btn btn-secondary flex-fill ms-sm-2">
                  Cancelar
                </a>

              </div>

            </form>

          </div>
        </div>

      </div>
    </div>

  </div>

</div>

</body>

<?php include("footer.php"); ?>