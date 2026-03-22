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
                                    <!-- CAMBIADO A SELECT -->
                                    <select name="nacionalidad" id="nacionalidad" class="form-select" required>
                                        <option value="" disabled selected>Seleccione nacionalidad</option>
                                        <option value="Colombiana">Colombiana</option>
                                        <option value="Venezolana">Venezolana</option>
                                        <option value="Peruana">Peruana</option>
                                        <option value="Ecuatoriana">Ecuatoriana</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Chilena">Chilena</option>
                                        <option value="Brasileña">Brasileña</option>
                                        <option value="Mexicana">Mexicana</option>
                                        <option value="Española">Española</option>
                                        <option value="Estadounidense">Estadounidense</option>
                                        <option value="Otra">Otra</option>
                                    </select>
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
                                    <label>País</label>
                                    <!-- CAMBIADO A SELECT -->
                                    <select name="pais" id="pais" class="form-select" required>
                                        <option value="">Seleccione un país</option>
                                        <option value="Colombia" selected>Colombia</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Perú">Perú</option>
                                        <option value="Chile">Chile</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Departamento</label>
                                    <!-- CAMBIADO A SELECT -->
                                    <select name="departamento" id="departamento" class="form-select" required>
                                        <option value="">Seleccione un departamento</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Ciudad</label>
                                    <!-- CAMBIADO A SELECT -->
                                    <select name="ciudad" id="ciudad" class="form-select" required>
                                        <option value="">Seleccione una ciudad</option>
                                    </select>
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

<!-- Bootstrap Icons (necesarios para el estilo, ya incluidos en header pero se agregan por si acaso) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Script para departamentos y ciudades de Colombia -->
<script>
    // Datos de departamentos y ciudades de Colombia
    const colombiaData = {
        "Amazonas": ["Leticia", "Puerto Asís", "Puerto Nariño", "Mirití-Paraná"],
        "Antioquia": ["Medellín", "Bello", "Envigado", "Itagüí", "Rionegro", "Sabaneta", "Buenaventura", "Turbo", "Caucasia", "Apartadó"],
        "Arauca": ["Arauca", "Saravena", "Tame", "Fortul", "Cravo Norte"],
        "Atlántico": ["Barranquilla", "Soledad", "Malambo", "Baranoa", "Galapa", "Palmar de Varela"],
        "Bolívar": ["Cartagena", "Mompós", "Magangué", "Turbaco", "Zambrano", "Tiquisio"],
        "Boyacá": ["Tunja", "Duitama", "Sogamoso", "Villanueva", "Chiquinquirá", "Paipa", "Moniquirá"],
        "Caldas": ["Manizales", "Pereira", "Armenia", "Villamaría", "La Dorada", "Salamina"],
        "Caquetá": ["Florencia", "San Vicente del Caguán", "Solano", "San José del Fragua"],
        "Casanare": ["Yopal", "Aguazul", "Tauramena", "Villanueva", "Hato Corozal"],
        "Cauca": ["Popayán", "Santander de Quilichao", "Piendamó", "Buenos Aires", "Santander de Quilichao"],
        "Cesar": ["Valledupar", "Aguachica", "Gamarra", "La Paz", "Becerril"],
        "Chocó": ["Quibdó", "Istmina", "Bojayá", "Riosucio", "Lloró"],
        "Córdoba": ["Montería", "Cereté", "Tierralta", "Los Córdobas", "Moñitos"],
        "Cundinamarca": ["Bogotá", "Zipaquirá", "Chía", "Cajicá", "Soacha", "Facatativá", "Girardot"],
        "Guainía": ["Inírida", "Mapiripana", "San Fernando de Guainía"],
        "Guaviare": ["San José del Guaviare", "Calamar", "El Retorno"],
        "Huila": ["Neiva", "Pitalito", "Garzón", "Páez", "Santa María"],
        "La Guajira": ["Riohacha", "Maicao", "Uribia", "San Juan del Cesar", "Albania"],
        "Magdalena": ["Santa Marta", "Ciénaga", "Fundación", "Plato", "Mompós"],
        "Meta": ["Villavicencio", "Granada", "Acacías", "Puerto López", "Puerto Carreño"],
        "Nariño": ["Pasto", "Santander de Quilichao", "Ipiales", "Tumaco", "Pasto"],
        "Norte de Santander": ["Cúcuta", "Los Patios", "Ocaña", "Villa del Rosario", "Pamplona"],
        "Putumayo": ["Mocoa", "Sibundoy", "San Miguel", "Orito", "Colón"],
        "Quindío": ["Armenia", "Pereira", "Montenegro", "Salento", "Circasia"],
        "Risaralda": ["Pereira", "Dosquebradas", "Santa Rosa de Cabal", "La Virginia", "Marsella"],
        "San Andrés y Providencia": ["San Andrés", "Providencia", "Santa Catalina"],
        "Santander": ["Bucaramanga", "Floridablanca", "Girón", "Barbosa", "Villanueva"],
        "Sucre": ["Sincelejo", "Corozal", "San Onofre", "Los Palmitos", "Buenavista"],
        "Tolima": ["Ibagué", "Honda", "Mariquita", "Alpujarra", "Cajibío"],
        "Valle del Cauca": ["Cali", "Buenaventura", "Palmira", "Tuluá", "Buga"],
        "Vaupés": ["Mitú", "Yavaraté", "Taraira", "Carurú"],
        "Vichada": ["Puerto Carreño", "La Primavera", "Santa Rosalía", "Cumaribo"]
    };

    // Función para llenar el select de departamentos
    function llenarDepartamentos() {
        const selectDepartamento = document.getElementById('departamento');
        const selectPais = document.getElementById('pais');

        // Limpiar opciones anteriores
        selectDepartamento.innerHTML = '<option value="">Seleccione un departamento</option>';

        // Obtener el país seleccionado
        const paisSeleccionado = selectPais.value;

        // Si es Colombia, llenar departamentos
        if (paisSeleccionado === 'Colombia') {
            selectDepartamento.disabled = false;
            for (let departamento in colombiaData) {
                const option = document.createElement('option');
                option.value = departamento;
                option.textContent = departamento;
                selectDepartamento.appendChild(option);
            }
        } else {
            // Si no es Colombia, deshabilitar departamento
            selectDepartamento.disabled = true;
            selectDepartamento.innerHTML = '<option value="">Seleccione un departamento</option>';
            // También limpiar ciudades
            const selectCiudad = document.getElementById('ciudad');
            selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';
            selectCiudad.disabled = true;
        }
    }

    // Función para llenar el select de ciudades
    function llenarCiudades() {
        const selectCiudad = document.getElementById('ciudad');
        const selectDepartamento = document.getElementById('departamento');

        // Limpiar opciones anteriores
        selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';

        // Obtener el departamento seleccionado
        const departamentoSeleccionado = selectDepartamento.value;

        // Si hay departamento seleccionado y no está deshabilitado, llenar ciudades
        if (departamentoSeleccionado && !selectDepartamento.disabled && colombiaData[departamentoSeleccionado]) {
            selectCiudad.disabled = false;
            const ciudades = colombiaData[departamentoSeleccionado];
            ciudades.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                selectCiudad.appendChild(option);
            });
        } else {
            selectCiudad.disabled = true;
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const selectPais = document.getElementById('pais');
        const selectDepartamento = document.getElementById('departamento');
        const selectCiudad = document.getElementById('ciudad');

        // Cuando cambia el país
        selectPais.addEventListener('change', function() {
            llenarDepartamentos();
            // Limpiar ciudades cuando cambia el país
            selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';
            selectCiudad.disabled = true;
        });

        // Cuando cambia el departamento
        selectDepartamento.addEventListener('change', function() {
            llenarCiudades();
        });

        // Inicializar departamentos al cargar
        llenarDepartamentos();
    });
</script>

<?php include("../../../footer.php"); ?>