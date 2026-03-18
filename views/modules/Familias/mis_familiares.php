<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();
include("../../../config/conexion.php");
include("../../../header.php");

$busqueda = "";

$sql = "SELECT internos.*, fundaciones.nombre AS nombre_fundacion
        FROM internos
        INNER JOIN fundaciones ON internos.id_fundacion = fundaciones.id";

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $sql .= " WHERE internos.menor_num_doc = '$busqueda'";
}

$resultado = mysqli_query($conexion, $sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid py-4 px-4">

    <!-- TITULO -->
    <h2 class="mb-3">
        <i class="bi bi-people-fill"></i> Mis Familiares
    </h2>

    <!-- BUSCADOR (MISMO DISEÑO) -->
    <form method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="buscar" class="form-control"
                placeholder="Buscar por documento..."
                value="<?php echo $busqueda; ?>">

            <button class="btn btn-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- TABLA -->
    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <h5 class="mb-3">Listado de NNA</h5>

            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Fundación</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>

                            <td><?php echo $row['id']; ?></td>

                            <td>
                                <?php echo $row['menor_nombres'] . " " . $row['menor_apellidos']; ?>
                            </td>

                            <td>
                                <?php echo $row['menor_tipo_doc'] . " - " . $row['menor_num_doc']; ?>
                            </td>

                            <td>
                                <?php
                                $fecha = new DateTime($row['fecha_nacimiento']);
                                $hoy = new DateTime();
                                echo $hoy->diff($fecha)->y . " años";
                                ?>
                            </td>

                            <td><?php echo $row['sexo']; ?></td>

                            <td><?php echo $row['nombre_fundacion']; ?></td>

                            <td class="text-center">

                                <!-- SOLO BOTON OJO (MISMO ESTILO DE TU IMAGEN) -->
                                <button onclick="verMenor(<?php echo $row['id']; ?>)"
                                    class="btn btn-sm"
                                    style="border:1px solid #0d6efd; color:#0d6efd; border-radius:8px;">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- MODAL (NO CAMBIA DISEÑO GENERAL) -->
<div class="modal fade" id="modalVerMenor" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-eye"></i> Detalles del Menor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="detalleMenor">
                Cargando...
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
function verMenor(id) {

    fetch("<?php echo BASE_URL; ?>views/modules/Familias/ver_menor.php?id=" + id)
    .then(res => res.json())
    .then(data => {

        document.getElementById("detalleMenor").innerHTML = `
            <div class="row">

                <div class="col-md-6">
                    <h6 class="text-success">Datos del Menor</h6>
                    <p><b>ID:</b> ${data.id}</p>
                    <p><b>Nombre:</b> ${data.nombre}</p>
                    <p><b>Documento:</b> ${data.documento}</p>
                    <p><b>Edad:</b> ${data.edad} años</p>
                    <p><b>Sexo:</b> ${data.sexo}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-success">Fundación</h6>
                    <p><b>Nombre:</b> ${data.fundacion}</p>
                    <p><b>Estado:</b> ${data.estado}</p>
                </div>

            </div>
        `;

        let modal = new bootstrap.Modal(document.getElementById('modalVerMenor'));
        modal.show();
    })
    .catch(err => {
        console.error(err);
        alert("Error al cargar datos");
    });
}
</script>

<?php include("../../../footer.php"); ?>