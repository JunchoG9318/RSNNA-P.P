<?php
include("../../../header.php");
// <!--session_start();-->
?>

<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- CONTENIDO PRINCIPAL -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4">
                <!-- Cabecera del formulario -->
                <div class="card-header bg-success text-white py-3 rounded-top-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                            <i class="bi bi-pencil-square fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Registro de Información del funcionario ICBF</h4>
                            <small class="opacity-75">
                                <i class="bi bi-calendar me-1"></i> <?php echo date('d/m/Y'); ?>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- NAV TABS MEJORADOS -->
                    <ul class="nav nav-pills mb-4 justify-content-center gap-2" id="icbfTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold px-4 py-2 rounded-pill" 
                                    data-bs-toggle="tab"
                                    data-bs-target="#personal"
                                    type="button">
                                <i class="bi bi-person-circle me-2"></i>Información Personal
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold px-4 py-2 rounded-pill" 
                                    data-bs-toggle="tab"
                                    data-bs-target="#laboral"
                                    type="button">
                                <i class="bi bi-briefcase me-2"></i>Información Laboral
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold px-4 py-2 rounded-pill" 
                                    data-bs-toggle="tab"
                                    data-bs-target="#instituto"
                                    type="button">
                                <i class="bi bi-building me-2"></i>Instituto
                            </button>
                        </li>
                    </ul>

                    <!-- CONTENIDO TABS -->
                    <div class="tab-content">

                        <!-- PERSONAL - CON ESTILO ICBF -->
                        <div class="tab-pane fade show active" id="personal">
                            <form method="POST" action="guardar_info_personal.php">
                                
                                <!-- Título de sección -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi-person-lines-fill text-success fs-5"></i>
                                    </div>
                                    <h5 class="text-success fw-bold mb-0">Datos Personales</h5>
                                </div>

                                <!-- Nombres y Apellidos -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-person text-success me-1"></i>Nombres <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-person text-success"></i>
                                            </span>
                                            <input type="text" name="nombres" class="form-control" placeholder="Ingrese nombres" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-person text-success me-1"></i>Apellidos <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-person text-success"></i>
                                            </span>
                                            <input type="text" name="apellidos" class="form-control" placeholder="Ingrese apellidos" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipo Documento, Número y Fecha Nacimiento -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-card-text text-success me-1"></i>Tipo Documento
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-file-text text-success"></i>
                                            </span>
                                            <select name="tipo_documento" class="form-select">
                                                <option>CC - Cédula Ciudadanía</option>
                                                <option>TI - Tarjeta Identidad</option>
                                                <option>CE - Cédula Extranjería</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-123 text-success me-1"></i>Número
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-upc-scan text-success"></i>
                                            </span>
                                            <input type="text" name="numero_documento" class="form-control" placeholder="Número">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-calendar-date text-success me-1"></i>Fecha Nacimiento
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-calendar text-success"></i>
                                            </span>
                                            <input type="date" name="fecha_nacimiento" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha de Expedición y Nacionalidad -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-calendar-check text-success me-1"></i>Fecha de Expedición
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-calendar text-success"></i>
                                            </span>
                                            <input type="date" name="fecha_expedicion" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-flag text-success me-1"></i>Nacionalidad
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-globe text-success"></i>
                                            </span>
                                            <select name="nacionalidad" class="form-select">
                                                <option value="">Seleccione nacionalidad</option>
                                                <option value="Colombiana">Colombiana</option>
                                                <option value="Venezolana">Venezolana</option>
                                                <option value="Ecuatoriana">Ecuatoriana</option>
                                                <option value="Peruana">Peruana</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dirección actual -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-house-door text-success me-1"></i>Dirección actual
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success bg-opacity-10 border-0">
                                            <i class="bi bi-geo-alt-fill text-success"></i>
                                        </span>
                                        <input type="text" name="direccion_actual" class="form-control" placeholder="Dirección completa">
                                    </div>
                                </div>

                                <!-- MUNICIPIO Y DEPARTAMENTO -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-building text-success me-1"></i>Municipio
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-building text-success"></i>
                                            </span>
                                            <input type="text" name="municipio" class="form-control" placeholder="Ingrese municipio">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-map text-success me-1"></i>Departamento
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-map-fill text-success"></i>
                                            </span>
                                            <select name="departamento" class="form-select">
                                                <option value="">Seleccione departamento</option>
                                                <option value="Antioquia">Antioquia</option>
                                                <option value="Cundinamarca">Cundinamarca</option>
                                                <option value="Valle del Cauca">Valle del Cauca</option>
                                                <option value="Atlántico">Atlántico</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Teléfono celular, Sexo y Discapacidad -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-phone text-success me-1"></i>Teléfono celular
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-whatsapp text-success"></i>
                                            </span>
                                            <input type="tel" name="telefono_celular" class="form-control" placeholder="Número de contacto">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-gender-ambiguous text-success me-1"></i>Sexo
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-gender-ambiguous text-success"></i>
                                            </span>
                                            <select name="sexo" class="form-select">
                                                <option value="">Seleccione sexo</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Masculino">Masculino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-heart-pulse text-success me-1"></i>Discapacidad
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-heart-pulse text-success"></i>
                                            </span>
                                            <select name="discapacidad" class="form-select">
                                                <option value="">Seleccione discapacidad</option>
                                                <option value="Ninguna">Ninguna</option>
                                                <option value="Fisica">Física</option>
                                                <option value="Cognitiva">Cognitiva</option>
                                                <option value="Visual">Visual</option>
                                                <option value="Auditiva">Auditiva</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- CONTACTO DE EMERGENCIA -->
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-header bg-success bg-opacity-10 border-0 rounded-top-4">
                                        <h6 class="text-success fw-bold mb-0 py-2">
                                            <i class="bi bi-exclamation-triangle me-2"></i>CONTACTO DE EMERGENCIA
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nombres y Apellidos del contacto -->
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-person text-success me-1"></i>Nombres del contacto
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-person text-success"></i>
                                                    </span>
                                                    <input type="text" name="contacto_nombres" class="form-control" placeholder="Nombres del contacto">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-person text-success me-1"></i>Apellidos del contacto
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-person text-success"></i>
                                                    </span>
                                                    <input type="text" name="contacto_apellidos" class="form-control" placeholder="Apellidos del contacto">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Número de contacto y Parentesco -->
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-phone text-success me-1"></i>Número de contacto
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-telephone text-success"></i>
                                                    </span>
                                                    <input type="tel" name="contacto_numero" class="form-control" placeholder="Teléfono de emergencia">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-diagram-3 text-success me-1"></i>Parentesco
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-people text-success"></i>
                                                    </span>
                                                    <select name="contacto_parentesco" class="form-select">
                                                        <option value="">Seleccione parentesco</option>
                                                        <option value="Madre">Madre</option>
                                                        <option value="Padre">Padre</option>
                                                        <option value="Hermano/a">Hermano/a</option>
                                                        <option value="Abuelo/a">Abuelo/a</option>
                                                        <option value="Tío/a">Tío/a</option>
                                                        <option value="Amigo/a">Amigo/a</option>
                                                        <option value="Otro">Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Correo electrónico -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-envelope text-success me-1"></i>Correo electrónico
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                    <i class="bi bi-envelope-fill text-success"></i>
                                                </span>
                                                <input type="email" name="contacto_correo" class="form-control" placeholder="correo@ejemplo.com">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Guardar y continuar -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill hover-scale">
                                        <i class="bi bi-check-circle me-2"></i>Guardar y continuar
                                        <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- LABORAL -->
                        <div class="tab-pane fade" id="laboral">
                            <form method="POST" action="guardar_info_laboral.php">
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi-briefcase text-success fs-5"></i>
                                    </div>
                                    <h5 class="text-success fw-bold mb-0">Información Laboral</h5>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-person-workspace text-success me-1"></i>Profesión
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-briefcase text-success"></i>
                                            </span>
                                            <input type="text" name="profesion" class="form-control" placeholder="Ingrese profesión">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-building text-success me-1"></i>Universidad/Instituto
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-building text-success"></i>
                                            </span>
                                            <input type="text" name="universidad" class="form-control" placeholder="Nombre de la institución">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-clock-history text-success me-1"></i>Años de experiencia
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-calendar text-success"></i>
                                            </span>
                                            <input type="number" name="anios_experiencia" class="form-control" placeholder="Años de experiencia">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-card-text text-success me-1"></i>Tarjeta profesional
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                <i class="bi bi-upc-scan text-success"></i>
                                            </span>
                                            <input type="text" name="tarjeta_profesional" class="form-control" placeholder="Número de tarjeta profesional">
                                        </div>
                                    </div>
                                </div>

                                <!-- EXPERIENCIA LABORAL -->
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-header bg-success bg-opacity-10 border-0 rounded-top-4">
                                        <h6 class="text-success fw-bold mb-0 py-2">
                                            <i class="bi bi-list-task me-2"></i>EXPERIENCIA LABORAL
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-building text-success me-1"></i>Entidad donde trabajó
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                    <i class="bi bi-building text-success"></i>
                                                </span>
                                                <input type="text" name="entidad_trabajo" class="form-control" placeholder="Nombre de la entidad">
                                            </div>
                                        </div>

                                        <!-- FECHA DE INICIO Y TÉRMINO -->
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-calendar-plus text-success me-1"></i>Fecha de inicio
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-calendar text-success"></i>
                                                    </span>
                                                    <input type="date" name="fecha_inicio" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-calendar-minus text-success me-1"></i>Fecha de término
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-calendar text-success"></i>
                                                    </span>
                                                    <input type="date" name="fecha_termino" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-chat-text text-success me-1"></i>Funciones desarrolladas:
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                    <i class="bi bi-pencil-square text-success"></i>
                                                </span>
                                                <textarea name="funciones" class="form-control" rows="3" placeholder="Describa las funciones"></textarea>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-phone text-success me-1"></i>Contacto jefe anterior
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-telephone text-success"></i>
                                                    </span>
                                                    <input type="tel" name="contacto_jefe_anterior" class="form-control" placeholder="Teléfono">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-person text-success me-1"></i>Nombre jefe inmediato
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0">
                                                        <i class="bi bi-person-circle text-success"></i>
                                                    </span>
                                                    <input type="text" name="nombre_jefe" class="form-control" placeholder="Nombre">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-start">
                                            <button type="button" class="btn btn-outline-success rounded-pill" id="agregarExperiencia">
                                                <i class="bi bi-plus-circle me-2"></i>+ Agregar más experiencia
                                            </button>
                                        </div>
                                        <div id="experienciasAdicionales" class="mt-3"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-danger px-4 py-2 rounded-pill" onclick="location.href='index.php'">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill hover-scale">
                                        <i class="bi bi-check-circle me-2"></i>Siguiente
                                        <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- INSTITUTO -->
                        <div class="tab-pane fade" id="instituto">
                            <form method="POST" action="guardar_instituto.php">
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi-building text-success fs-5"></i>
                                    </div>
                                    <h5 class="text-success fw-bold mb-0">Información de Instituto</h5>
                                </div>

                                <!-- Ingresar institución -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-building text-success me-1"></i>Ingresar institución
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success bg-opacity-10 border-0">
                                            <i class="bi bi-building text-success"></i>
                                        </span>
                                        <input type="text" name="nombre_institucion" class="form-control" placeholder="Nombre de la institución">
                                    </div>
                                </div>

                                <!-- Fecha de ingreso -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-calendar-plus text-success me-1"></i>Fecha de ingreso
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success bg-opacity-10 border-0">
                                            <i class="bi bi-calendar text-success"></i>
                                        </span>
                                        <input type="date" name="fecha_ingreso" class="form-control">
                                    </div>
                                </div>

                                <!-- Cargo -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-person-badge text-success me-1"></i>Cargo
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success bg-opacity-10 border-0">
                                            <i class="bi bi-person-workspace text-success"></i>
                                        </span>
                                        <input type="text" name="cargo" class="form-control" placeholder="Ingrese el cargo">
                                    </div>
                                </div>

                                <!-- Botones Cancelar y Guardar/Salir -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-danger px-4 py-2 rounded-pill" onclick="location.href='index.php'">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill hover-scale">
                                        <i class="bi bi-check-circle me-2"></i>Guardar/Salir
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
.bg-success {
    background-color: #006341 !important;
}
.bg-success.bg-opacity-10 {
    background-color: rgba(0, 99, 65, 0.1) !important;
}
.text-success {
    color: #006341 !important;
}
.btn-success {
    background-color: #006341;
    border-color: #006341;
}
.btn-success:hover {
    background-color: #004d33;
    border-color: #004d33;
}
.hover-scale {
    transition: all 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 99, 65, 0.3);
}
.nav-pills .nav-link {
    color: #6c757d;
    border: 1px solid transparent;
}
.nav-pills .nav-link.active {
    background-color: #006341 !important;
    color: white !important;
}
.nav-pills .nav-link:hover:not(.active) {
    border-color: #006341;
    color: #006341;
}
.input-group-text {
    background-color: rgba(0, 99, 65, 0.1) !important;
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 10px 20px rgba(0, 99, 65, 0.1) !important;
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let contadorExperiencias = 0;
        const btnAgregar = document.getElementById("agregarExperiencia");
        const contenedor = document.getElementById("experienciasAdicionales");

        if (btnAgregar) {
            btnAgregar.addEventListener("click", function() {
                contadorExperiencias++;
                const nuevaExperiencia = document.createElement("div");
                nuevaExperiencia.className = "mt-4 p-3 border rounded-4 bg-light";
                nuevaExperiencia.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-success fw-bold mb-0">
                            <i class="bi bi-briefcase me-2"></i>Experiencia #${contadorExperiencias}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="this.parentElement.parentElement.remove()">
                            <i class="bi bi-trash me-1"></i>Eliminar
                        </button>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-building text-success"></i>
                                </span>
                                <input type="text" name="entidad_${contadorExperiencias}" class="form-control" placeholder="Entidad">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-calendar text-success"></i>
                                </span>
                                <input type="date" name="fecha_ini_${contadorExperiencias}" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-calendar text-success"></i>
                                </span>
                                <input type="date" name="fecha_fin_${contadorExperiencias}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-pencil-square text-success"></i>
                                </span>
                                <textarea name="funciones_${contadorExperiencias}" class="form-control" rows="2" placeholder="Funciones"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-telephone text-success"></i>
                                </span>
                                <input type="tel" name="contacto_${contadorExperiencias}" class="form-control" placeholder="Tel jefe">
                            </div>
                        </div>
                        <div class="col- 6">
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-person-circle text-success"></i>
                                </span>
                                <input type="text" name="nombre_jefe_${contadorExperiencias}" class="form-control" placeholder="Nombre jefe">
                            </div>
                        </div>
                    </div>
                `;
                contenedor.appendChild(nuevaExperiencia);
            }); 
        }
    });
</script>
<?php
include("../../../footer.php");
?>

