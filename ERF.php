<?php
include("header.php");
?>
<div class="container-fluid mt-10">
  <div class="row">
    <!-- Perfil lateral -->
    <div class="col 9">
      <div class="container mt-1">
        <h2 class="mb-8 text-center">
          Formulario de Registro - Funcionario
        </h2>
        <form>
          <!-- Datos personales -->
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              Datos Personales
            </div>
            <div class="card-body row g-3">
              <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  required />
              </div>
              <div class="col-md-6">
                <label for="tipodocumento" class="form-label">Tipo de documento</label>
                <select id="nivelEscolar" class="form-select">
                  <option selected disabled>Seleccione</option>
                  <option>TI</option>
                  <option>REGISRO CIVIL</option>
                  <option>CEDULA</option>
                  <option>PASAPORTE</option>
                  <option>VISA</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="documento" class="form-label">Documento de Identidad</label>
                <input
                  type="text"
                  class="form-control"
                  id="documento"
                  required />
              </div>
              <div class="col-md-6">
                <label for="celular" class="form-label">Número de Celular</label>
                <input type="tel" class="form-control" id="celular" />
              </div>
              <div class="col-md-6">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" />
              </div>
              <div class="col-md-6">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" />
              </div>
              <div class="col-md-6">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" />
              </div>
              <div class="col-md-6">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                <input
                  type="date"
                  class="form-control"
                  id="fechaNacimiento" />
              </div>
            </div>
          </div>

          <!-- Escolaridad -->
          <div class="card mb-4">
            <div class="card-header bg-success text-white">Escolaridad</div>
            <div class="card-body row g-3">
              <div class="col-md-6">
                <label for="nivelEscolar" class="form-label">Nivel Educativo</label>
                <select id="nivelEscolar" class="form-select">
                  <option selected disabled>Seleccione</option>
                  <option>Bachillerato</option>
                  <option>Técnico</option>
                  <option>Tecnólogo</option>
                  <option>Universitario</option>
                  <option>Postgrado</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="institucion" class="form-label">Institución Educativa</label>
                <input type="text" class="form-control" id="institucion" />
              </div>
              <div class="col-md-12">
                <label for="tituloObtenido" class="form-label">Título Obtenido</label>
                <input
                  type="text"
                  class="form-control"
                  id="tituloObtenido" />
              </div>
            </div>
          </div>

          <!-- Experiencia Laboral -->
          <div class="card mb-4">
            <div class="card-header bg-warning">
              Último Lugar de Trabajo
            </div>
            <div class="card-body row g-3">
              <div class="col-md-6">
                <label for="empresa" class="form-label">Nombre de la Empresa</label>
                <input type="text" class="form-control" id="empresa" />
              </div>
              <div class="col-md-6">
                <label for="cargo" class="form-label">Cargo Ocupado</label>
                <input type="text" class="form-control" id="cargo" />
              </div>
              <div class="col-md-6">
                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fechaInicio" />
              </div>
              <div class="col-md-6">
                <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                <input type="date" class="form-control" id="fechaFin" />
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="reset" class="btn btn-secondary">Limpiar</button>            
            <a href="login.php"><button type="submit" class="btn btn-primary">Registrar</button></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
include("footer.php");
?>