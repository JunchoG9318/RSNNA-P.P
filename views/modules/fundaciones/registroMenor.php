<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start(); // Asegurarse de que la sesión está iniciada
include("../../../config/conexion.php");
include("../../../header.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-11">

            <!-- BOTÓN DE ATRÁS SEGÚN EL USUARIO (SOLO UNA VEZ) -->
            <div class="mb-3">
                <?php
                // Determinar la ruta de retorno según el tipo de usuario
                $back_url = BASE_URL . 'inicio.php'; // Por defecto
                $back_text = 'Volver al Inicio';

                if (isset($_SESSION['usuario_tipo'])) {
                    switch ($_SESSION['usuario_tipo']) {
                        case 'icbf':
                            $back_url = BASE_URL . 'views/modules/ICBF/panel_icbf.php';
                            $back_text = 'Volver al Panel ICBF';
                            break;
                        case 'fundacion':
                            $back_url = BASE_URL . 'views/modules/fundaciones/panel_fundacion.php';
                            $back_text = 'Volver al Panel de Fundación';
                            break;
                        case 'familia':
                            $back_url = BASE_URL . 'views/modules/Familias/panel_familia.php';
                            $back_text = 'Volver al Panel Familiar';
                            break;
                    }
                }
                ?>
                <a href="<?php echo $back_url; ?>" class="btn btn-outline-success">
                    <i class="fas fa-arrow-left me-2"></i><?php echo $back_text; ?>
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-building me-2"></i>Registro completo de ingreso · Fundación
                    </h4>
                    <small class="text-white-50">Sistema RSNNA - ICBF</small>
                </div>
                <div class="card-body p-4">
                    <!-- Navegación por pestañas mejorada -->
                    <ul class="nav nav-pills justify-content-center mb-4 gap-2" id="registroTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold px-4 rounded-pill" id="fundacion-tab" data-bs-toggle="tab" data-bs-target="#fundacion" type="button" role="tab">
                                <i class="fas fa-building me-2"></i>Fundación e Ingreso
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold px-4 rounded-pill" id="menor-tab" data-bs-toggle="tab" data-bs-target="#menor" type="button" role="tab">
                                <i class="fas fa-child me-2"></i>Datos del Menor
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold px-4 rounded-pill" id="padres-tab" data-bs-toggle="tab" data-bs-target="#padres" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>Padre / Madre / Acudiente
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold px-4 rounded-pill" id="psico-tab" data-bs-toggle="tab" data-bs-target="#psico" type="button" role="tab">
                                <i class="fas fa-brain me-2"></i>Psicosocial y Acuerdo
                            </button>
                        </li>
                    </ul>

                    <!-- Formulario único con atributos name adaptados a la tabla -->
                    <form id="formCompleto">
                        <div class="tab-content">
                            <!-- PESTAÑA 1: FUNDACIÓN E INGRESO -->
                            <div class="tab-pane fade show active" id="fundacion" role="tabpanel">
                                <h5 class="text-success mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-building me-2"></i>Datos de la Fundación
                                </h5>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-building text-success me-1"></i>Nombre de la Fundación
                                        </label>
                                        <select class="form-select" id="fundacion_nombre" name="fundacion_nombre">
                                            <option selected disabled>Seleccione una fundación</option>
                                            <?php
                                            // Consultar fundaciones desde la base de datos
                                            $query_fundaciones = "SELECT id, nombre FROM fundaciones WHERE estado = 1 ORDER BY nombre";
                                            $result_fundaciones = mysqli_query($conexion, $query_fundaciones);

                                            if ($result_fundaciones && mysqli_num_rows($result_fundaciones) > 0) {
                                                while ($fundacion = mysqli_fetch_assoc($result_fundaciones)) {
                                                    echo '<option value="' . htmlspecialchars($fundacion['nombre']) . '">'
                                                        . htmlspecialchars($fundacion['nombre']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No hay fundaciones registradas</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt text-success me-1"></i>Dirección
                                        </label>
                                        <input type="text" class="form-control" id="fundacion_direccion" name="fundacion_direccion" placeholder="Ingrese la dirección">
                                    </div>
                                </div>

                                <h6 class="text-success fw-semibold mb-3">
                                    <i class="fas fa-user-tie me-2"></i>Responsable del ingreso
                                </h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-phone text-success me-1"></i>Teléfono
                                        </label>
                                        <input type="tel" class="form-control" id="resp_telefono" name="resp_telefono" placeholder="Número de contacto">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-envelope text-success me-1"></i>Correo electrónico
                                        </label>
                                        <input type="email" class="form-control" id="resp_email" name="resp_email" placeholder="correo@ejemplo.com">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-briefcase text-success me-1"></i>Cargo
                                        </label>
                                        <input type="text" class="form-control" id="resp_cargo" name="resp_cargo" placeholder="Cargo del responsable">
                                    </div>
                                </div>

                                <h5 class="text-success mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-calendar-alt me-2"></i>Datos del Ingreso
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar text-success me-1"></i>Fecha de ingreso <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-clock text-success me-1"></i>Hora de ingreso
                                        </label>
                                        <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-question-circle text-success me-1"></i>Motivo de ingreso
                                        </label>
                                        <select class="form-select" id="motivo_ingreso" name="motivo_ingreso">
                                            <option selected disabled>Seleccione motivo</option>
                                            <option>Emergencia social</option>
                                            <option>Remisión ICBF</option>
                                            <option>Abandono</option>
                                            <option>Violencia intrafamiliar</option>
                                            <option>Medida de protección</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4 align-items-center">
                                    <div class="col-auto">
                                        <label class="form-label fw-semibold mb-0">
                                            <i class="fas fa-tag text-success me-1"></i>Tipo de ingreso:
                                        </label>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_ingreso" id="voluntario" value="Voluntario">
                                            <label class="form-check-label" for="voluntario">Voluntario</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_ingreso" id="proteccion" value="Protección">
                                            <label class="form-check-label" for="proteccion">Protección</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_ingreso" id="judicial" value="Judicial">
                                            <label class="form-check-label" for="judicial">Judicial</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user text-success me-1"></i>Responsable que remite
                                        </label>
                                        <input type="text" class="form-control" id="responsable_remite" name="responsable_remite" placeholder="Nombre del responsable">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-building text-success me-1"></i>Entidad
                                        </label>
                                        <input type="text" class="form-control" id="entidad_remite" name="entidad_remite" placeholder="Entidad que remite">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-id-card text-success me-1"></i>Documento identidad (tipo)
                                        </label>
                                        <select class="form-select" id="doc_tipo" name="doc_tipo">
                                            <option value="">Seleccione tipo</option>
                                            <option>Cédula de Ciudadanía</option>
                                            <option>Cédula de Extranjería</option>
                                            <option>Tarjeta de Identidad</option>
                                            <option>Registro Civil</option>
                                            <option>Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-hashtag text-success me-1"></i>Número de documento
                                        </label>
                                        <input type="text" class="form-control" id="doc_numero" name="doc_numero" placeholder="Número">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-folder-open text-success me-1"></i>N° proceso / expediente
                                        </label>
                                        <input type="text" class="form-control" id="numero_proceso" name="numero_proceso" placeholder="Número de proceso">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar-alt text-success me-1"></i>Fecha de remisión
                                        </label>
                                        <input type="date" class="form-control" id="fecha_remision" name="fecha_remision">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-success px-4 rounded-pill" onclick="siguienteTab('menor-tab')">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- PESTAÑA 2: DATOS DEL MENOR -->
                            <div class="tab-pane fade" id="menor" role="tabpanel">
                                <h5 class="text-success mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-child me-2"></i>Datos del Menor
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user text-success me-1"></i>Nombres y apellidos <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="menor_nombres" name="menor_nombres" placeholder="Nombres completos" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-id-card text-success me-1"></i>Tipo doc.
                                        </label>
                                        <select class="form-select" id="menor_tipo_doc" name="menor_tipo_doc">
                                            <option>RC</option>
                                            <option>TI</option>
                                            <option>CC</option>
                                            <option>CE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-hashtag text-success me-1"></i>N° documento
                                        </label>
                                        <input type="text" class="form-control" id="menor_num_doc" name="menor_num_doc" placeholder="Número">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar text-success me-1"></i>Fecha nacimiento
                                        </label>
                                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-sort-numeric-up-alt text-success me-1"></i>Edad
                                        </label>
                                        <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad en años">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-venus-mars text-success me-1"></i>Sexo
                                        </label>
                                        <select class="form-select" id="sexo" name="sexo">
                                            <option value="">Seleccione</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-flag text-success me-1"></i>Nacionalidad
                                        </label>
                                        <select class="form-select" id="nacionalidad" name="nacionalidad">
                                            <option value="" disabled selected>Seleccione una nacionalidad</option>
                                            <option value="Colombiana">Colombiana</option>
                                            <option value="Venezolana">Venezolana</option>
                                            <option value="Ecuatoriana">Ecuatoriana</option>
                                            <option value="Peruana">Peruana</option>
                                            <option value="Brasileña">Brasileña</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Chilena">Chilena</option>
                                            <option value="Mexicana">Mexicana</option>
                                            <option value="Española">Española</option>
                                            <option value="Estadounidense">Estadounidense</option>
                                            <option value="Otro">Otra nacionalidad</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt text-success me-1"></i>Lugar de nacimiento
                                        </label>
                                        <input type="text" class="form-control" id="lugar_nacimiento" name="lugar_nacimiento" placeholder="Ciudad / Departamento">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-home text-success me-1"></i>Dirección de domicilio
                                        </label>
                                        <input type="text" class="form-control" id="direccion_domicilio" name="direccion_domicilio" placeholder="Dirección completa">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-phone text-success me-1"></i>EPS / Seguro médico
                                        </label>
                                        <input type="text" class="form-control" id="eps" name="eps" placeholder="EPS">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-heartbeat text-success me-1"></i>Estado de salud general
                                        </label>
                                        <input type="text" class="form-control" id="salud_general" name="salud_general" placeholder="Bueno, regular, etc.">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-allergies text-success me-1"></i>Alergias / condiciones
                                        </label>
                                        <input type="text" class="form-control" id="alergias" name="alergias" placeholder="Si aplica">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-wheelchair text-success me-1"></i>Discapacidad
                                        </label>
                                        <div class="d-flex">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="discapacidad" id="disc_si" value="Sí">
                                                <label class="form-check-label" for="disc_si">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="discapacidad" id="disc_no" value="No" checked>
                                                <label class="form-check-label" for="disc_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-question-circle text-success me-1"></i>¿Cuál discapacidad?
                                        </label>
                                        <input type="text" class="form-control" id="cual_discapacidad" name="cual_discapacidad" placeholder="Especifique tipo de discapacidad">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-secondary me-2 rounded-pill px-4" onclick="anteriorTab('fundacion-tab')">
                                        <i class="fas fa-arrow-left me-2"></i>Anterior
                                    </button>
                                    <button type="button" class="btn btn-success rounded-pill px-4" onclick="siguienteTab('padres-tab')">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- PESTAÑA 3: PADRE / MADRE / ACUDIENTE -->
                            <div class="tab-pane fade" id="padres" role="tabpanel">
                                <h5 class="text-success mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-user-tie me-2"></i>Acudiente principal
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user text-success me-1"></i>Nombres y apellidos
                                        </label>
                                        <input type="text" class="form-control" id="acudiente_nombres" name="acudiente_nombres" placeholder="Nombre completo">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-id-card text-success me-1"></i>Tipo doc.
                                        </label>
                                        <select class="form-select" id="acudiente_tipo_doc" name="acudiente_tipo_doc">
                                            <option>CC</option>
                                            <option>CE</option>
                                            <option>TI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-hashtag text-success me-1"></i>N° documento
                                        </label>
                                        <input type="text" class="form-control" id="acudiente_num_doc" name="acudiente_num_doc" placeholder="Número">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-people-arrows text-success me-1"></i>Parentesco
                                        </label>
                                        <input type="text" class="form-control" id="acudiente_parentesco" name="acudiente_parentesco" placeholder="Parentesco">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt text-success me-1"></i>Dirección
                                        </label>
                                        <input type="text" class="form-control" id="acudiente_direccion" name="acudiente_direccion" placeholder="Dirección">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-phone text-success me-1"></i>Teléfono
                                        </label>
                                        <input type="tel" class="form-control" id="acudiente_tel" name="acudiente_tel" placeholder="Teléfono">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-envelope text-success me-1"></i>Correo
                                        </label>
                                        <input type="email" class="form-control" id="acudiente_email" name="acudiente_email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-briefcase text-success me-1"></i>Ocupación
                                        </label>
                                        <input type="text" class="form-control" id="acudiente_ocupacion" name="acudiente_ocupacion" placeholder="Ocupación">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold me-3">
                                            <i class="fas fa-gavel text-success me-1"></i>Responsable legal
                                        </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="responsable_legal" id="resp_legal_si" value="Sí">
                                            <label class="form-check-label" for="resp_legal_si">SÍ</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="responsable_legal" id="resp_legal_no" value="No" checked>
                                            <label class="form-check-label" for="resp_legal_no">NO</label>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-success mt-4 mb-3">
                                    <i class="fas fa-male me-2"></i>Padre
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombres y apellidos</label>
                                        <input type="text" class="form-control" id="padre_nombres" name="padre_nombres" placeholder="Nombre del padre">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Tipo</label>
                                        <select class="form-select" id="padre_tipo_doc" name="padre_tipo_doc">
                                            <option>CC</option>
                                            <option>CE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">N° documento</label>
                                        <input type="text" class="form-control" id="padre_num_doc" name="padre_num_doc" placeholder="Número">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Parentesco</label>
                                        <input type="text" class="form-control" id="padre_parentesco" name="padre_parentesco" value="Padre" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Dirección</label>
                                        <input type="text" class="form-control" id="padre_direccion" name="padre_direccion" placeholder="Dirección">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Teléfono</label>
                                        <input type="tel" class="form-control" id="padre_tel" name="padre_tel" placeholder="Teléfono">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Correo</label>
                                        <input type="email" class="form-control" id="padre_email" name="padre_email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Ocupación</label>
                                        <input type="text" class="form-control" id="padre_ocupacion" name="padre_ocupacion" placeholder="Ocupación">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">N. de contacto</label>
                                        <input type="text" class="form-control" id="padre_contacto" name="padre_contacto" placeholder="Contacto alterno">
                                    </div>
                                </div>

                                <h5 class="text-danger mt-4 mb-3">
                                    <i class="fas fa-female me-2"></i>Madre
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombres y apellidos</label>
                                        <input type="text" class="form-control" id="madre_nombres" name="madre_nombres" placeholder="Nombre de la madre">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Tipo</label>
                                        <select class="form-select" id="madre_tipo_doc" name="madre_tipo_doc">
                                            <option>CC</option>
                                            <option>CE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">N° documento</label>
                                        <input type="text" class="form-control" id="madre_num_doc" name="madre_num_doc" placeholder="Número">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Parentesco</label>
                                        <input type="text" class="form-control" id="madre_parentesco" name="madre_parentesco" value="Madre" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Dirección</label>
                                        <input type="text" class="form-control" id="madre_direccion" name="madre_direccion" placeholder="Dirección">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Teléfono</label>
                                        <input type="tel" class="form-control" id="madre_tel" name="madre_tel" placeholder="Teléfono">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Correo</label>
                                        <input type="email" class="form-control" id="madre_email" name="madre_email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Ocupación</label>
                                        <input type="text" class="form-control" id="madre_ocupacion" name="madre_ocupacion" placeholder="Ocupación">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">N. de contacto</label>
                                        <input type="text" class="form-control" id="madre_contacto" name="madre_contacto" placeholder="Contacto alterno">
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-outline-secondary me-2 rounded-pill px-4" onclick="anteriorTab('menor-tab')">
                                        <i class="fas fa-arrow-left me-2"></i>Anterior
                                    </button>
                                    <button type="button" class="btn btn-success rounded-pill px-4" onclick="siguienteTab('psico-tab')">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- PESTAÑA 4: PSICOSOCIAL Y ACUERDO -->
                            <div class="tab-pane fade" id="psico" role="tabpanel">
                                <h5 class="text-success mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-brain me-2"></i>Información psicosocial
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-graduation-cap text-success me-1"></i>Escolaridad actual
                                        </label>
                                        <input type="text" class="form-control" id="escolaridad" name="escolaridad" placeholder="Grado actual">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-school text-success me-1"></i>Institución educativa
                                        </label>
                                        <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Nombre institución">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-history text-success me-1"></i>Último grado cursado
                                        </label>
                                        <input type="text" class="form-control" id="ultimo_grado" name="ultimo_grado" placeholder="Último grado">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-brain text-success me-1"></i>Observaciones psicológicas
                                    </label>
                                    <textarea class="form-control" id="obs_psicologicas" name="obs_psicologicas" rows="2" placeholder="Observaciones del área psicológica"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-users text-success me-1"></i>Observaciones sociales
                                    </label>
                                    <textarea class="form-control" id="obs_sociales" name="obs_sociales" rows="2" placeholder="Observaciones del área social"></textarea>
                                </div>

                                <h5 class="text-success mt-4 mb-3 border-start border-3 border-success ps-3 py-1">
                                    <i class="fas fa-handshake me-2"></i>Acuerdo
                                </h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user-tie text-success me-1"></i>Funcionario que recibe
                                        </label>
                                        <input type="text" class="form-control" id="funcionario_recibe" name="funcionario_recibe" placeholder="Nombre del funcionario">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user-check text-success me-1"></i>Remitente
                                        </label>
                                        <input type="text" class="form-control" id="remitente_final" name="remitente_final" placeholder="Persona que remite">
                                    </div>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="acuerdo_check" required>
                                    <label class="form-check-label fw-semibold" for="acuerdo_check">
                                        Declaro que los datos son verídicos y autorizo el tratamiento de información según la Ley 1581 de 2012.
                                    </label>
                                    <div class="invalid-feedback">Debe aceptar los términos para guardar</div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="anteriorTab('padres-tab')">
                                        <i class="fas fa-arrow-left me-2"></i>Anterior
                                    </button>
                                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2">
                                        <i class="fas fa-save me-2"></i>Guardar registro completo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- TABLA DE REGISTROS DESDE BD -->
                    <h5 class="mb-3">
                        <i class="fas fa-database me-2 text-success"></i>Registros almacenados
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha ingreso</th>
                                    <th>Menor</th>
                                    <th>Documento</th>
                                    <th>Acudiente</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaRegistros">
                                <tr>
                                    <td colspan="7" class="text-center">Cargando registros...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el formulario - CORREGIDO CON RUTAS ABSOLUTAS -->
<script>
    let idEdicion = null;
    const BASE_URL = '<?php echo BASE_URL; ?>';

    document.addEventListener('DOMContentLoaded', function() {
        cargarRegistros();
    });

    function cargarRegistros() {
        fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php?accion=listar')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                const tbody = document.getElementById('tablaRegistros');
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay registros</td></tr>';
                } else {
                    data.forEach(r => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${r.id}</td>
                                <td>${r.fecha_ingreso || ''}</td>
                                <td>${r.menor_nombres || ''}</td>
                                <td>${r.menor_tipo_doc || ''} ${r.menor_num_doc || ''}</td>
                                <td>${r.acudiente_nombres || ''}</td>
                                <td>${r.motivo_ingreso || ''}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm me-1" onclick="editarRegistro(${r.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(${r.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error('Error cargando registros:', error);
                document.getElementById('tablaRegistros').innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar los registros: ' + error.message + '</td></tr>';
            });
    }

    document.getElementById('formCompleto').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!document.getElementById('acuerdo_check').checked) {
            alert('Debe aceptar los términos y condiciones');
            return;
        }

        // Validar campos obligatorios
        const fechaIngreso = document.getElementById('fecha_ingreso').value;
        const menorNombres = document.getElementById('menor_nombres').value;

        if (!fechaIngreso || !menorNombres) {
            alert('Los campos Fecha de ingreso y Nombres del menor son obligatorios');
            return;
        }

        const formData = new FormData(this);
        formData.append('accion', idEdicion ? 'actualizar' : 'guardar');
        if (idEdicion) formData.append('id', idEdicion);

        // Mostrar indicador de carga
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        submitBtn.disabled = true;

        fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    alert('Registro guardado correctamente');

                    // Redirigir después de guardar exitosamente
                    window.location.href = BASE_URL + 'views/modules/fundaciones/panel_fundacion.php';
                } else {
                    alert('Error: ' + (result.error || 'Error desconocido'));
                    // Restaurar botón
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                alert('Error al conectar con el servidor: ' + error.message);
                // Restaurar botón
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });

    function editarRegistro(id) {
        fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php?accion=obtener&id=' + id)
            .then(response => response.json())
            .then(r => {
                if (r.error) {
                    alert(r.error);
                    return;
                }
                idEdicion = id;

                // Función para asignar valor a un campo
                const setVal = (idCampo, valor) => {
                    const campo = document.getElementById(idCampo);
                    if (campo) {
                        if (campo.type === 'radio') {
                            const radio = document.querySelector(`input[name="${campo.name}"][value="${valor}"]`);
                            if (radio) radio.checked = true;
                        } else if (campo.type === 'checkbox' && campo.name.includes('contacto')) {
                            campo.checked = valor === 'on' || valor === '1' || valor === true;
                        } else {
                            campo.value = valor || '';
                        }
                    }
                };

                // Lista de todos los campos del formulario
                const campos = [
                    'fundacion_nombre', 'fundacion_direccion', 'resp_telefono', 'resp_email', 'resp_cargo',
                    'fecha_ingreso', 'hora_ingreso', 'motivo_ingreso', 'tipo_ingreso', 'responsable_remite',
                    'entidad_remite', 'doc_tipo', 'doc_numero', 'numero_proceso', 'fecha_remision',
                    'menor_nombres', 'menor_tipo_doc', 'menor_num_doc', 'fecha_nacimiento', 'edad', 'sexo',
                    'nacionalidad', 'lugar_nacimiento', 'direccion_domicilio', 'eps', 'salud_general', 'alergias',
                    'discapacidad', 'cual_discapacidad', 'acudiente_nombres', 'acudiente_tipo_doc', 'acudiente_num_doc',
                    'acudiente_parentesco', 'acudiente_direccion', 'acudiente_tel', 'acudiente_email', 'acudiente_ocupacion',
                    'responsable_legal', 'padre_nombres', 'padre_tipo_doc', 'padre_num_doc', 'padre_direccion',
                    'padre_tel', 'padre_email', 'padre_ocupacion', 'padre_contacto', 'madre_nombres',
                    'madre_tipo_doc', 'madre_num_doc', 'madre_direccion', 'madre_tel', 'madre_email',
                    'madre_ocupacion', 'madre_contacto', 'escolaridad', 'institucion', 'ultimo_grado',
                    'obs_psicologicas', 'obs_sociales', 'funcionario_recibe', 'remitente_final'
                ];

                campos.forEach(campo => setVal(campo, r[campo]));

                // Ir a la primera pestaña
                document.querySelector('#fundacion-tab').click();
            })
            .catch(error => {
                console.error('Error al obtener registro:', error);
                alert('Error al cargar los datos del registro');
            });
    }

    function eliminarRegistro(id) {
        if (confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.')) {
            fetch(BASE_URL + 'views/modules/fundaciones/controlador_registro_interno.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'accion=eliminar&id=' + id
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Registro eliminado correctamente');
                        cargarRegistros();
                    } else {
                        alert('Error al eliminar: ' + (result.error || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar:', error);
                    alert('Error al conectar con el servidor');
                });
        }
    }

    function siguienteTab(tabId) {
        const tabElement = document.getElementById(tabId);
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }

    function anteriorTab(tabId) {
        const tabElement = document.getElementById(tabId);
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }
</script>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
include("../../../footer.php");
?>