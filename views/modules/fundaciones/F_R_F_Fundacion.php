<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

$back_url = BASE_URL . "views/modules/ICBF/panel_icbf.php";
$back_text = "Volver al Panel ICBF";

if (isset($_SESSION['usuario_tipo'])) {
    if ($_SESSION['usuario_tipo'] == 'fundacion') {
        $back_url = BASE_URL . "views/modules/fundaciones/panel_fundacion.php";
        $back_text = "Volver al Panel de Fundación";
    } elseif ($_SESSION['usuario_tipo'] == 'familia') {
        $back_url = BASE_URL . "views/modules/Familias/panel_familia.php";
        $back_text = "Volver al Panel Familiar";
    }
}

include("../../../header.php");
require_once("../../../config/conexion.php");

/* FUNDACION DE LA SESION */
$id_fundacion = (int) ($_SESSION['id_fundacion'] ?? 0);

// Consulta para obtener todas las fundaciones para el desplegable
$sql_fundaciones = "SELECT id, nombre, nit FROM fundaciones ORDER BY nombre ASC";
$resultado_fundaciones = $conexion->query($sql_fundaciones);
?>

<body>

    <form method="POST" action="guardar_funcionario.php">

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <!-- ENCABEZADO -->
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="d-flex align-items-center">

                            <a href="<?php echo $back_url; ?>" class="btn btn-outline-success me-3">
                                <i class="bi bi-arrow-left me-2"></i><?php echo $back_text; ?>
                            </a>

                            <h2 class="fw-bold text-dark mb-0">
                                REGISTRO DE INFORMACIÓN PERSONAL
                            </h2>

                        </div>

                        <span class="badge bg-light text-dark px-3 py-2 border">
                            <?php echo date('d/m/Y'); ?>
                        </span>

                    </div>

                    <!-- INFORMACION PERSONAL -->

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white">
                            <h5 class="text-primary fw-bold">INFORMACIÓN PERSONAL</h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control" required>
                                </div>

                            </div>

                            <div class="row g-3 mb-3">

                                <div class="col-md-4">
                                    <label>Tipo Documento</label>

                                    <select name="tipo_documento" class="form-select">

                                        <option value="">Seleccione</option>
                                        <option>TI</option>
                                        <option>REGISTRO CIVIL</option>
                                        <option>CÉDULA</option>
                                        <option>PASAPORTE</option>
                                        <option>VISA</option>

                                    </select>

                                </div>

                                <div class="col-md-4">
                                    <label>Número Documento</label>
                                    <input type="text" name="documento" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Fecha Nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control">
                                </div>

                            </div>

                            <div class="mb-3">
                                <label>Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Celular</label>
                                    <input type="tel" name="celular" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Correo</label>
                                    <input type="email" name="correo" class="form-control">
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- ESCOLARIDAD -->

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white">
                            <h5 class="text-success fw-bold">ESCOLARIDAD</h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Nivel Educativo</label>

                                    <select name="nivel_escolar" class="form-select">

                                        <option>Bachillerato</option>
                                        <option>Técnico</option>
                                        <option>Tecnólogo</option>
                                        <option>Universitario</option>
                                        <option>Postgrado</option>

                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <label>Institución</label>
                                    <input type="text" name="institucion" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label>Título Obtenido</label>
                                    <input type="text" name="titulo_obtenido" class="form-control">
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- EXPERIENCIA LABORAL -->

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white">
                            <h5 class="text-warning fw-bold">ÚLTIMO LUGAR DE TRABAJO</h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Empresa</label>
                                    <input type="text" name="empresa" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Cargo</label>
                                    <input type="text" name="cargo" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="fecha_fin" class="form-control">
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- DATOS DE UBICACIÓN Y PERSONALES -->
                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white">
                            <h5 class="text-info fw-bold">DATOS DE UBICACIÓN Y PERSONALES</h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label>Nacionalidad</label>
                                    <input type="text" name="nacionalidad" class="form-control" placeholder="Ej: Colombiana">
                                </div>

                                <div class="col-md-4">
                                    <label>Género</label>
                                    <select name="genero" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        <option value="O">Otro</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Pais</label>
                                    <input type="text" name="pais" class="form-control" placeholder="Ej: Colombia">
                                </div>

                                <div class="col-md-6">
                                    <label>Departamento</label>
                                    <input type="text" name="departamento" class="form-control" placeholder="Ej: Antioquia">
                                </div>

                                <div class="col-md-6">
                                    <label>Ciudad</label>
                                    <input type="text" name="ciudad" class="form-control" placeholder="Ej: Medellín">
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- FUNDACION AUTOMATICA -->
                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white">
                            <h5 class="text-success fw-bold">FUNDACIÓN</h5>
                        </div>

                        <div class="card-body">

                            <label class="form-label">Seleccione la Fundación</label>

                            <select name="id_fundacion" class="form-select" required>
                                <option value="">Seleccione una fundación</option>

                                <?php
                                if ($resultado_fundaciones && $resultado_fundaciones->num_rows > 0) {
                                    while ($fundacion = $resultado_fundaciones->fetch_assoc()):
                                ?>
                                        <option value="<?php echo $fundacion['id']; ?>"
                                            <?php echo ($fundacion['id'] == $id_fundacion) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($fundacion['nombre']) . ' (NIT: ' . htmlspecialchars($fundacion['nit']) . ')'; ?>
                                        </option>
                                <?php
                                    endwhile;
                                }
                                ?>
                            </select>

                        </div>

                    </div>

                    <!-- BOTONES -->

                    <div class="d-flex justify-content-end gap-2">

                        <button type="reset" class="btn btn-secondary">
                            Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Registrar
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </form>

</body>

<?php include("../../../footer.php"); ?>