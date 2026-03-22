<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include("../../../header.php");

// Obtener información del usuario logueado
$usuario_nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
$usuario_tipo = $_SESSION['usuario_tipo'] ?? '';
$usuario_correo = $_SESSION['usuario_correo'] ?? '';

// Determinar el texto del rol según el tipo de usuario
switch ($usuario_tipo) {
    case 'icbf':
        $rol_texto = 'Funcionario ICBF';
        $icono_rol = 'bi-building';
        break;
    case 'fundacion':
        $rol_texto = 'Fundación';
        $icono_rol = 'bi-tree';
        break;
    case 'familia':
        $rol_texto = 'Familia / Acudiente';
        $icono_rol = 'bi-people-fill';
        break;
    default:
        $rol_texto = 'Usuario';
        $icono_rol = 'bi-person';
}
?>

<body style="background-color: white;">
    <div class="container-fluid bg-success bg-opacity-10 p-4">
        <!-- ENCABEZADO CON INFORMACIÓN DEL USUARIO LOGEADO - MEJORADO PARA VISIBILIDAD -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="background-color: #006341; color: white; padding: 15px; border-radius: 10px;">
            <div>
                <h2 class="fw-bold mb-1" style="color: white;">
                    <i class="bi bi-people-fill me-2"></i>Internos por Fundación
                </h2>
                <p class="mb-0" style="color: rgba(255,255,255,0.9);">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong><?php echo htmlspecialchars($usuario_nombre); ?></strong> 
                    <span class="badge bg-white text-success ms-2">
                        <i class="bi <?php echo $icono_rol; ?> me-1"></i>
                        <?php echo $rol_texto; ?>
                    </span>
                </p>
                <p class="small mt-1" style="color: rgba(255,255,255,0.8);">
                    <i class="bi bi-people-fill me-2"></i>
                    Información del familiar y documentación
                </p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-success px-3 py-2 border">
                    <i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y'); ?>
                </span>
                <a href="<?php echo BASE_URL; ?>views/modules/Familias/panel_familia.php" class="btn btn-light ms-3">
                    <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                </a>
            </div>
        </div>

        <!-- FORMULARIO PRINCIPAL (UNA SOLA PÁGINA) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <!-- Cabecera del formulario -->
                    <div class="card-header bg-success text-white py-3 rounded-top-3 border-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                                <i class="bi bi-person-badge fs-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">REGISTRO COMPLETO DE FAMILIA</h4>
                                <small class="opacity-75">
                                    <i class="bi bi-calendar me-1"></i> <?php echo date('d/m/Y'); ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Alerta informativa -->
                        <div class="alert alert-success bg-opacity-10 border-success mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle-fill text-success me-3 fs-5"></i>
                                <small>Complete todos los campos obligatorios marcados con <span class="text-danger">*</span></small>
                            </div>
                        </div>

                        <!-- FORMULARIO CON NAMES AGREGADOS -->
                        <form class="needs-validation" novalidate method="POST" action="guardar_registro_familiar.php" enctype="multipart/form-data">
                            
                            <!-- SECCIÓN 1: DATOS BÁSICOS -->
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-info-circle me-2"></i>DATOS BÁSICOS
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-person text-success me-1"></i>NOMBRE <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese nombres" required>
                                        <div class="invalid-feedback">Por favor ingrese el nombre</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-person text-success me-1"></i>APELLIDOS <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="apellidos" class="form-control" placeholder="Ingrese apellidos" required>
                                        <div class="invalid-feedback">Por favor ingrese los apellidos</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-card-text text-success me-1"></i>TIPO DE DOCUMENTO
                                        </label>
                                        <select class="form-select" name="tipo_documento">
                                            <option disabled selected>Seleccione tipo</option>
                                            <option value="CC">CC - Cédula Ciudadanía</option>
                                            <option value="CE">CE - Cédula Extranjería</option>
                                            <option value="PAS">PAS - Pasaporte</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-123 text-success me-1"></i>NUMERO DE DOCUMENTO <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="numero_documento" class="form-control" placeholder="Ingrese número de documento" required>
                                        <div class="invalid-feedback">Por favor ingrese el número de documento</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-calendar-date text-success me-1"></i>FECHA DE NACIMIENTO <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-calendar-check text-success me-1"></i>FECHA DE EXPEDICIÓN
                                        </label>
                                        <input type="date" name="fecha_expedicion" class="form-control">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-diagram-3 text-success me-1"></i>PARENTESCO
                                        </label>
                                        <select class="form-select" name="parentesco">
                                            <option disabled selected>Seleccione parentesco</option>
                                            <option value="Madre">Madre</option>
                                            <option value="Padre">Padre</option>
                                            <option value="Tío/a">Tío/a</option>
                                            <option value="Abuelo/a">Abuelo/a</option>
                                            <option value="Hermano/a">Hermano/a</option>
                                            <option value="Representante Legal">Representante Legal</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-flag text-success me-1"></i>NACIONALIDAD <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" name="nacionalidad" required>
                                            <option disabled selected>Seleccione país</option>
                                            <option value="Afganistán">Afganistán</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Alemania">Alemania</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                            <option value="Arabia Saudita">Arabia Saudita</option>
                                            <option value="Argelia">Argelia</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaiyán">Azerbaiyán</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bangladés">Bangladés</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Baréin">Baréin</option>
                                            <option value="Bélgica">Bélgica</option>
                                            <option value="Belice">Belice</option>
                                            <option value="Benín">Benín</option>
                                            <option value="Bielorrusia">Bielorrusia</option>
                                            <option value="Birmania">Birmania</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option>
                                            <option value="Botsuana">Botsuana</option>
                                            <option value="Brasil">Brasil</option>
                                            <option value="Brunéi">Brunéi</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Bután">Bután</option>
                                            <option value="Cabo Verde">Cabo Verde</option>
                                            <option value="Camboya">Camboya</option>
                                            <option value="Camerún">Camerún</option>
                                            <option value="Canadá">Canadá</option>
                                            <option value="Catar">Catar</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Chipre">Chipre</option>
                                            <option value="Colombia" selected>Colombia</option>
                                            <option value="Comoras">Comoras</option>
                                            <option value="Corea del Norte">Corea del Norte</option>
                                            <option value="Corea del Sur">Corea del Sur</option>
                                            <option value="Costa de Marfil">Costa de Marfil</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Croacia">Croacia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Dinamarca">Dinamarca</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egipto">Egipto</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Eslovaquia">Eslovaquia</option>
                                            <option value="Eslovenia">Eslovenia</option>
                                            <option value="España">España</option>
                                            <option value="Estados Unidos">Estados Unidos</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Esuatini">Esuatini</option>
                                            <option value="Etiopía">Etiopía</option>
                                            <option value="Filipinas">Filipinas</option>
                                            <option value="Finlandia">Finlandia</option>
                                            <option value="Fiyi">Fiyi</option>
                                            <option value="Francia">Francia</option>
                                            <option value="Gabón">Gabón</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Granada">Granada</option>
                                            <option value="Grecia">Grecia</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bisáu">Guinea-Bisáu</option>
                                            <option value="Guinea Ecuatorial">Guinea Ecuatorial</option>
                                            <option value="Haití">Haití</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hungría">Hungría</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Irak">Irak</option>
                                            <option value="Irán">Irán</option>
                                            <option value="Irlanda">Irlanda</option>
                                            <option value="Islandia">Islandia</option>
                                            <option value="Islas Marshall">Islas Marshall</option>
                                            <option value="Islas Salomón">Islas Salomón</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italia">Italia</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japón">Japón</option>
                                            <option value="Jordania">Jordania</option>
                                            <option value="Kazajistán">Kazajistán</option>
                                            <option value="Kenia">Kenia</option>
                                            <option value="Kirguistán">Kirguistán</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Lesoto">Lesoto</option>
                                            <option value="Letonia">Letonia</option>
                                            <option value="Líbano">Líbano</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libia">Libia</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lituania">Lituania</option>
                                            <option value="Luxemburgo">Luxemburgo</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malasia">Malasia</option>
                                            <option value="Malaui">Malaui</option>
                                            <option value="Maldivas">Maldivas</option>
                                            <option value="Malí">Malí</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marruecos">Marruecos</option>
                                            <option value="Mauricio">Mauricio</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="México">México</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldavia">Moldavia</option>
                                            <option value="Mónaco">Mónaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montenegro">Montenegro</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Níger">Níger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Noruega">Noruega</option>
                                            <option value="Nueva Zelanda">Nueva Zelanda</option>
                                            <option value="Omán">Omán</option>
                                            <option value="Países Bajos">Países Bajos</option>
                                            <option value="Pakistán">Pakistán</option>
                                            <option value="Palaos">Palaos</option>
                                            <option value="Palestina">Palestina</option>
                                            <option value="Panamá">Panamá</option>
                                            <option value="Papúa Nueva Guinea">Papúa Nueva Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Perú">Perú</option>
                                            <option value="Polonia">Polonia</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Reino Unido">Reino Unido</option>
                                            <option value="República Centroafricana">República Centroafricana</option>
                                            <option value="República Checa">República Checa</option>
                                            <option value="República del Congo">República del Congo</option>
                                            <option value="República Democrática del Congo">República Democrática del Congo</option>
                                            <option value="República Dominicana">República Dominicana</option>
                                            <option value="Ruanda">Ruanda</option>
                                            <option value="Rumanía">Rumanía</option>
                                            <option value="Rusia">Rusia</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Cristóbal y Nieves">San Cristóbal y Nieves</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="San Vicente y las Granadinas">San Vicente y las Granadinas</option>
                                            <option value="Santa Lucía">Santa Lucía</option>
                                            <option value="Santo Tomé y Príncipe">Santo Tomé y Príncipe</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leona">Sierra Leona</option>
                                            <option value="Singapur">Singapur</option>
                                            <option value="Siria">Siria</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Suazilandia">Suazilandia</option>
                                            <option value="Sudáfrica">Sudáfrica</option>
                                            <option value="Sudán">Sudán</option>
                                            <option value="Sudán del Sur">Sudán del Sur</option>
                                            <option value="Suecia">Suecia</option>
                                            <option value="Suiza">Suiza</option>
                                            <option value="Surinam">Surinam</option>
                                            <option value="Tailandia">Tailandia</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Tayikistán">Tayikistán</option>
                                            <option value="Timor Oriental">Timor Oriental</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad y Tobago">Trinidad y Tobago</option>
                                            <option value="Túnez">Túnez</option>
                                            <option value="Turkmenistán">Turkmenistán</option>
                                            <option value="Turquía">Turquía</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Ucrania">Ucrania</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistán">Uzbekistán</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vaticano">Vaticano</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Yibuti">Yibuti</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabue">Zimbabue</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione su nacionalidad</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- SECCIÓN 2: UBICACIÓN Y CONTACTO -->
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>UBICACIÓN Y CONTACTO
                                </h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-house-door text-success me-1"></i>DIRECCIÓN ACTUAL
                                        </label>
                                        <input type="text" name="direccion_actual" class="form-control" placeholder="Ingrese dirección completa">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-map text-success me-1"></i>DEPARTAMENTO
                                        </label>
                                        <select class="form-select" name="departamento" id="departamento" required>
                                            <option disabled selected>Seleccione departamento</option>
                                            <option value="Amazonas">Amazonas</option>
                                            <option value="Antioquia">Antioquia</option>
                                            <option value="Arauca">Arauca</option>
                                            <option value="Atlántico">Atlántico</option>
                                            <option value="Bolívar">Bolívar</option>
                                            <option value="Boyacá">Boyacá</option>
                                            <option value="Caldas">Caldas</option>
                                            <option value="Caquetá">Caquetá</option>
                                            <option value="Casanare">Casanare</option>
                                            <option value="Cauca">Cauca</option>
                                            <option value="Cesar">Cesar</option>
                                            <option value="Chocó">Chocó</option>
                                            <option value="Córdoba">Córdoba</option>
                                            <option value="Cundinamarca">Cundinamarca</option>
                                            <option value="Guainía">Guainía</option>
                                            <option value="Guaviare">Guaviare</option>
                                            <option value="Huila">Huila</option>
                                            <option value="La Guajira">La Guajira</option>
                                            <option value="Magdalena">Magdalena</option>
                                            <option value="Meta">Meta</option>
                                            <option value="Nariño">Nariño</option>
                                            <option value="Norte de Santander">Norte de Santander</option>
                                            <option value="Putumayo">Putumayo</option>
                                            <option value="Quindío">Quindío</option>
                                            <option value="Risaralda">Risaralda</option>
                                            <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                                            <option value="Santander">Santander</option>
                                            <option value="Sucre">Sucre</option>
                                            <option value="Tolima">Tolima</option>
                                            <option value="Valle del Cauca">Valle del Cauca</option>
                                            <option value="Vaupés">Vaupés</option>
                                            <option value="Vichada">Vichada</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione el departamento</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-building text-success me-1"></i>CIUDAD
                                        </label>
                                        <select class="form-select" name="ciudad" id="ciudad" required>
                                            <option disabled selected>Seleccione ciudad</option>
                                            <!-- Las ciudades se cargarán dinámicamente según el departamento -->
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione la ciudad</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-phone text-success me-1"></i>TELÉFONO CELULAR <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" name="telefono_celular" class="form-control" placeholder="300 123 4567" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-telephone text-success me-1"></i>TELÉFONO FIJO
                                        </label>
                                        <input type="tel" name="telefono_fijo" class="form-control" placeholder="(604) 123 4567">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-gender-ambiguous text-success me-1"></i>GÉNERO
                                        </label>
                                        <select class="form-select" name="genero">
                                            <option disabled selected>Seleccione género</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-briefcase text-success me-1"></i>OCUPACIÓN
                                        </label>
                                        <input type="text" name="ocupacion" class="form-control" placeholder="Ej: Independiente">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-envelope text-success me-1"></i>CORREO ELECTRÓNICO
                                        </label>
                                        <input type="email" name="correo_electronico" class="form-control" placeholder="ejemplo@correo.com">
                                        <small class="text-muted">Opcional, para notificaciones</small>
                                    </div>
                                </div>
                            </div>

                            <!-- SECCIÓN 3: INFORMACIÓN LABORAL -->
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-briefcase me-2"></i>INFORMACIÓN LABORAL
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">EMPRESA / LUGAR DE TRABAJO</label>
                                        <input type="text" name="empresa_laboral" class="form-control" placeholder="Nombre de la empresa">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">CARGO</label>
                                        <input type="text" name="cargo_laboral" class="form-control" placeholder="Cargo que desempeña">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">TELÉFONO LABORAL</label>
                                        <input type="tel" name="telefono_laboral" class="form-control" placeholder="Teléfono de contacto">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">DIRECCIÓN LABORAL</label>
                                        <input type="text" name="direccion_laboral" class="form-control" placeholder="Dirección del trabajo">
                                    </div>
                                </div>
                            </div>

                            <!-- SECCIÓN 4: INFORMACIÓN DEL INTERNO -->
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-people me-2"></i>INFORMACIÓN DEL INTERNO
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NOMBRE DEL INTERNO</label>
                                        <input type="text" name="interno_nombre" class="form-control" placeholder="Nombre completo">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">PARENTESCO</label>
                                        <select class="form-select" name="interno_parentesco">
                                            <option disabled selected>Seleccione parentesco</option>
                                            <option value="Hijo">Hijo</option>
                                            <option value="Sobrino">Sobrino</option>
                                            <option value="Nieto">Nieto</option>
                                            <option value="Representado">Representado</option>
                                            <option value="Hermano/a">Hermano/a</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">TIPO DE DOCUMENTO</label>
                                        <select class="form-select" name="interno_tipo_documento">
                                            <option disabled selected>Seleccione tipo</option>
                                            <option value="TI">TI - Tarjeta Identidad</option>
                                            <option value="RC">RC - Registro Civil</option>
                                            <option value="CC">CC - Cédula Ciudadanía</option>
                                            <option value="CE">CE - Cédula Extranjería</option>
                                            <option value="PAS">PAS - Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">NÚMERO DE DOCUMENTO</label>
                                        <input type="text" name="interno_numero_documento" class="form-control" placeholder="Número de documento">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">FECHA DE NACIMIENTO</label>
                                        <input type="date" name="interno_fecha_nacimiento" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- SECCIÓN 5: DOCUMENTACIÓN -->
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-file-text me-2"></i>DOCUMENTACIÓN ADJUNTA
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">DOCUMENTO DE IDENTIDAD DEL FAMILIAR</label>
                                        <input type="file" name="doc_familiar" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">DOCUMENTO DE IDENTIDAD DEL INTERNO</label>
                                        <input type="file" name="doc_interno" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Términos y condiciones -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="termsCheck" id="termsCheck" required>
                                <label class="form-check-label small" for="termsCheck">
                                    Confirmo que la información proporcionada es verídica y autorizo su tratamiento según la Ley 1581 de 2012 <span class="text-danger">*</span>
                                </label>
                                <div class="invalid-feedback">Debe aceptar los términos</div>
                            </div>

                            <!-- BOTONES DE ACCIÓN -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="text-muted small">
                                    <i class="bi bi-shield-check text-success me-1"></i>
                                    Datos protegidos - Ley 1581 de 2012
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?php echo BASE_URL; ?>views/modules/Familias/panel_familia.php" class="btn btn-outline-secondary px-4 py-2">
                                        <i class="bi bi-arrow-left me-2"></i>Cancelar
                                    </a>

                                    <button type="submit" class="btn btn-success px-4 py-2">
                                        <i class="bi bi-save me-2"></i>Guardar Registro
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para cargar ciudades según departamento -->
    <script>
        // Datos de ciudades por departamento
        const ciudadesPorDepartamento = {
            'Amazonas': ['Leticia', 'Puerto Nariño'],
            'Antioquia': ['Medellín', 'Bello', 'Itagüí', 'Envigado', 'Rionegro', 'Apartadó', 'Turbo', 'Santa Fe de Antioquia', 'Caucasia', 'Carepa', 'Chigorodó', 'Yarumal', 'Marinilla', 'La Ceja', 'El Carmen de Viboral'],
            'Arauca': ['Arauca', 'Tame', 'Saravena'],
            'Atlántico': ['Barranquilla', 'Soledad', 'Malambo', 'Puerto Colombia', 'Sabanagrande', 'Sabanalarga', 'Galapa'],
            'Bolívar': ['Cartagena', 'Magangué', 'Turbaco', 'El Carmen de Bolívar', 'Arjona'],
            'Boyacá': ['Tunja', 'Duitama', 'Sogamoso', 'Chiquinquirá', 'Puerto Boyacá', 'Moniquirá'],
            'Caldas': ['Manizales', 'Villamaría', 'Chinchiná', 'Riosucio', 'La Dorada'],
            'Caquetá': ['Florencia', 'San Vicente del Caguán', 'Puerto Rico'],
            'Casanare': ['Yopal', 'Aguazul', 'Villanueva'],
            'Cauca': ['Popayán', 'Santander de Quilichao', 'Puerto Tejada', 'Piendamó', 'Silvia'],
            'Cesar': ['Valledupar', 'Aguachica', 'Codazzi', 'La Paz'],
            'Chocó': ['Quibdó', 'Istmina', 'Riosucio', 'Tadó'],
            'Córdoba': ['Montería', 'Cereté', 'Lorica', 'Sahagún', 'Montelíbano'],
            'Cundinamarca': ['Bogotá', 'Soacha', 'Zipaquirá', 'Facatativá', 'Chía', 'Cajicá', 'Girardot', 'Fusagasugá', 'Madrid', 'Mosquera'],
            'Guainía': ['Inírida'],
            'Guaviare': ['San José del Guaviare'],
            'Huila': ['Neiva', 'Pitalito', 'Garzón', 'La Plata'],
            'La Guajira': ['Riohacha', 'Maicao', 'Uribia', 'Manaure'],
            'Magdalena': ['Santa Marta', 'Ciénaga', 'Fundación', 'El Banco', 'Plato'],
            'Meta': ['Villavicencio', 'Acacías', 'Granada', 'Puerto López'],
            'Nariño': ['Pasto', 'Tumaco', 'Ipiales', 'Tuquerres', 'La Unión'],
            'Norte de Santander': ['Cúcuta', 'Ocaña', 'Pamplona', 'Villa del Rosario', 'Los Patios'],
            'Putumayo': ['Mocoa', 'Puerto Asís', 'Orito'],
            'Quindío': ['Armenia', 'Calarcá', 'Montenegro', 'Quimbaya'],
            'Risaralda': ['Pereira', 'Dosquebradas', 'Santa Rosa de Cabal', 'La Virginia'],
            'San Andrés y Providencia': ['San Andrés', 'Providencia'],
            'Santander': ['Bucaramanga', 'Floridablanca', 'Girón', 'Piedecuesta', 'Barrancabermeja', 'San Gil', 'Socorro'],
            'Sucre': ['Sincelejo', 'Corozal', 'San Marcos', 'Sampués'],
            'Tolima': ['Ibagué', 'Espinal', 'Melgar', 'Líbano', 'Honda'],
            'Valle del Cauca': ['Cali', 'Palmira', 'Buenaventura', 'Tuluá', 'Cartago', 'Buga', 'Yumbo', 'Jamundí', 'Candelaria', 'Florida'],
            'Vaupés': ['Mitú'],
            'Vichada': ['Puerto Carreño']
        };

        // Elementos del DOM
        const departamentoSelect = document.getElementById('departamento');
        const ciudadSelect = document.getElementById('ciudad');

        // Evento cuando cambia el departamento
        departamentoSelect.addEventListener('change', function() {
            const departamento = this.value;
            const ciudades = ciudadesPorDepartamento[departamento] || [];

            // Limpiar el select de ciudades
            ciudadSelect.innerHTML = '<option disabled selected>Seleccione ciudad</option>';

            // Agregar las nuevas ciudades
            ciudades.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                ciudadSelect.appendChild(option);
            });

            // Habilitar el select de ciudades
            ciudadSelect.disabled = false;
        });

        // Inicializar el select de ciudades deshabilitado
        ciudadSelect.disabled = true;
    </script>

    <!-- Validación de formularios -->
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

</body>

</html>

<?php
include("../../../footer.php");
?>