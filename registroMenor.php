<?php
include("header.php");
?>
<div class="container my-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>Registro de Ingreso del Menor</h4>
    </div>

    <div class="card-body">
      <!-- FORMULARIO -->
      <form id="formRegistro">
        <input type="hidden" id="index">

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Fecha de ingreso</label>
            <input type="date" id="fecha" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Nombre del menor</label>
            <input type="text" id="menor" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Tipo de ingreso</label>
            <select id="tipo" class="form-select">
              <option>Voluntario</option>
              <option>Judicial</option>
              <option>Protección</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Acudiente</label>
            <input type="text" id="acudiente" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Observaciones</label>
            <input type="text" id="obs" class="form-control">
          </div>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success px-4">Guardar</button>
        </div>
      </form>

      <hr>

      <!-- TABLA -->
      <table class="table table-bordered table-striped text-center">
        <thead class="table-primary">
          <tr>
            <th>Fecha</th>
            <th>Menor</th>
            <th>Tipo</th>
            <th>Acudiente</th>
            <th>Observaciones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tabla"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
let registros = JSON.parse(localStorage.getItem("registros")) || [];

function mostrar() {
  const tabla = document.getElementById("tabla");
  tabla.innerHTML = "";

  registros.forEach((r, i) => {
    tabla.innerHTML += `
      <tr>
        <td>${r.fecha}</td>
        <td>${r.menor}</td>
        <td>${r.tipo}</td>
        <td>${r.acudiente}</td>
        <td>${r.obs}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="editar(${i})">Editar</button>
          <button class="btn btn-danger btn-sm" onclick="eliminar(${i})">Eliminar</button>
        </td>
      </tr>
    `;
  });
}

document.getElementById("formRegistro").addEventListener("submit", e => {
  e.preventDefault();

  const data = {
    fecha: fecha.value,
    menor: menor.value,
    tipo: tipo.value,
    acudiente: acudiente.value,
    obs: obs.value
  };

  if (index.value === "") {
    registros.push(data);
  } else {
    registros[index.value] = data;
    index.value = "";
  }

  localStorage.setItem("registros", JSON.stringify(registros));
  e.target.reset();
  mostrar();
});

function editar(i) {
  const r = registros[i];
  fecha.value = r.fecha;
  menor.value = r.menor;
  tipo.value = r.tipo;
  acudiente.value = r.acudiente;
  obs.value = r.obs;
  index.value = i;
}

function eliminar(i) {
  if (confirm("¿Eliminar registro?")) {
    registros.splice(i, 1);
    localStorage.setItem("registros", JSON.stringify(registros));
    mostrar();
  }
}

mostrar();
</script>
<?php
include("footer.php");
?>
