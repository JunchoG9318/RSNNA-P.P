<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
include("../../../header.php");
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">

            <!-- Mensajes de éxito/error -->
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <!-- Alerta de éxito (en lugar de modal) -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-3 me-3 text-success"></i>
                        <div>
                            <h5 class="alert-heading fw-bold mb-1">¡Registro Exitoso!</h5>
                            <p class="mb-0">La fundación ha sido registrada correctamente en el sistema.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                
                <!-- Script para ocultar la alerta después de 5 segundos (opcional) -->
                <script>
                    setTimeout(function() {
                        let alert = document.querySelector('.alert-success');
                        if (alert) {
                            let bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, 5000);
                </script>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php 
                    if ($_GET['error'] == 'campos_vacios') {
                        echo "Todos los campos son obligatorios";
                    } elseif ($_GET['error'] == 'correo_invalido') {
                        echo "El correo electrónico no es válido";
                    } elseif ($_GET['error'] == 'nit_existe') {
                        if (isset($_GET['id']) && isset($_GET['nombre'])) {
                            echo "El NIT ya está registrado por la fundación: <strong>" . htmlspecialchars($_GET['nombre']) . "</strong> (ID: " . $_GET['id'] . ")";
                        } else {
                            echo "El NIT ya está registrado en el sistema";
                        }
                    } elseif ($_GET['error'] == 'registro_fallido') {
                        echo "Error al registrar: " . (isset($_GET['detalle']) ? htmlspecialchars($_GET['detalle']) : "Error desconocido");
                    } else {
                        echo "Error desconocido";
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Tarjeta principal -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Cabecera -->
                <div class="card-header bg-success text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-building me-2"></i>Registro de Fundación
                    </h4>
                    <small class="text-white-50">Complete los datos de la fundación</small>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="card-body p-4">

                    <form action="<?php echo BASE_URL; ?>views/modules/fundaciones/procesar_fundacion.php" method="POST">

                        <!-- Título de sección -->
                        <h5 class="text-success border-start border-3 border-success ps-3 py-1 mb-4">
                            <i class="bi bi-info-circle me-2"></i>Datos Generales
                        </h5>

                        <!-- Nombre de la Fundación -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building text-success me-1"></i>Nombre de la Fundación <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-building text-success"></i>
                                </span>
                                <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre completo" required>
                            </div>
                        </div>

                        <!-- NIT -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-upc-scan text-success me-1"></i>NIT <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-upc-scan text-success"></i>
                                </span>
                                <input type="text" name="nit" class="form-control" placeholder="Ej: 123456789-0" required>
                            </div>
                        </div>

                        <!-- Fecha de Constitución -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-date text-success me-1"></i>Fecha de Constitución <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-calendar text-success"></i>
                                </span>
                                <input type="date" name="fecha_constitucion" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tipo de Fundación -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tag text-success me-1"></i>Tipo de Fundación <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-tag text-success"></i>
                                </span>
                                <select name="tipo" class="form-select" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="social">Social</option>
                                    <option value="educativa">Educativa</option>
                                    <option value="ambiental">Ambiental</option>
                                    <option value="salud">Salud</option>
                                    <option value="otra">Otra</option>
                                </select>
                            </div>
                        </div>

                        <!-- Título sección director -->
                        <h5 class="text-success border-start border-3 border-success ps-3 py-1 mb-4 mt-5">
                            <i class="bi bi-person-badge me-2"></i>Datos del Director
                        </h5>

                        <!-- Nombre del Director -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-circle text-success me-1"></i>Nombre del Director <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-person-circle text-success"></i>
                                </span>
                                <input type="text" name="nombre_director" class="form-control" placeholder="Nombre completo del director" required>
                            </div>
                        </div>

                        <!-- Correo electronico -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope text-success me-1"></i>Correo Electrónico del Director <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-envelope text-success"></i>
                                </span>
                                <input type="email" name="correo_director" class="form-control" placeholder="correo@ejemplo.com" required>
                            </div>
                        </div>

                        <!-- Teléfono de contacto -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-telephone text-success me-1"></i>Número de contacto <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-telephone text-success"></i>
                                </span>
                                <input type="tel" name="telefono_director" class="form-control" placeholder="Teléfono fijo" required>
                            </div>
                        </div>

                        <!-- Título sección dirección -->
                        <h5 class="text-success border-start border-3 border-success ps-3 py-1 mb-4 mt-5">
                            <i class="bi bi-geo-alt me-2"></i>Dirección de la Fundación
                        </h5>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo text-success me-1"></i>Dirección <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-geo text-success"></i>
                                </span>
                                <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 123 #45-67" required>
                            </div>
                        </div>

                        <!-- País -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-globe text-success me-1"></i>País <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-globe text-success"></i>
                                </span>
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
                        </div>

                        <!-- Departamento -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-map text-success me-1"></i>Departamento <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-map text-success"></i>
                                </span>
                                <select name="departamento" id="departamento" class="form-select" required>
                                    <option value="">Seleccione un departamento</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ciudad -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt text-success me-1"></i>Ciudad <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-geo-alt text-success"></i>
                                </span>
                                <select name="ciudad" id="ciudad" class="form-select" required>
                                    <option value="">Seleccione una ciudad</option>
                                </select>
                            </div>
                        </div>

                        <!-- BOTONES -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 pt-3 border-top">

                            <div class="text-muted small">
                                <i class="bi bi-shield-check text-success me-1"></i>
                                Datos protegidos
                            </div>

                            <div class="d-flex gap-3">

                                <a href="<?php echo BASE_URL; ?>inicio.php" class="btn btn-outline-danger px-4 py-2 rounded-pill">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </a>

                                <button type="submit" class="btn btn-success px-5 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-building-add me-2"></i>Registrar
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- Footer simple -->
                <div class="card-footer bg-light text-center py-3 border-0">
                    <small class="text-muted">
                        <i class="bi bi-building me-1"></i>
                        Sistema RSNNA - ICBF
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

        // Si hay departamento seleccionado, llenar ciudades
        if (departamentoSeleccionado && colombiaData[departamentoSeleccionado]) {
            const ciudades = colombiaData[departamentoSeleccionado];
            ciudades.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                selectCiudad.appendChild(option);
            });
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
        });

        // Cuando cambia el departamento
        selectDepartamento.addEventListener('change', function() {
            llenarCiudades();
        });

        // Inicializar departamentos al cargar
        llenarDepartamentos();
    });
</script>