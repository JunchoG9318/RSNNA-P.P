<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Banner de título -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-success text-white p-5 rounded-4 text-center shadow-lg"
                    style="background: linear-gradient(135deg, #006341 0%, #00A651 100%);">
                    <div class="position-relative">
                        <!-- Elementos decorativos -->
                        <div class="position-absolute top-0 start-0 opacity-25">
                            <i class="bi bi-heart-fill fs-1"></i>
                        </div>
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>

                        <h1 class="display-4 fw-bold mb-3">
                            <i class="bi bi-share me-3"></i>Redes de Apoyo
                        </h1>
                        <p class="lead mb-0">
                            <i class="bi bi-quote me-2"></i>
                            Conoce las organizaciones y entidades que brindan protección y cuidado
                            a la niñez y adolescencia en Colombia.
                        </p>

                        <!-- Badges decorativos y botón para agregar -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                                <i class="bi bi-shield-check me-2"></i>Protección
                            </span>
                            <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                                <i class="bi bi-heart me-2"></i>Cuidado
                            </span>
                            <span class="badge bg-white text-success px-4 py-2 rounded-pill">
                                <i class="bi bi-people me-2"></i>Niñez
                            </span>
                            <button class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAgregarRed">
                                <i class="bi bi-plus-circle me-2"></i>Agregar Red de Apoyo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENEDOR DE TARJETAS DINÁMICAS -->
        <div id="contenedorTarjetas">
            <!-- FILA 1: Aldeas Infantiles, Fiscalía, Fundación CINDE -->
            <div class="container mb-5">
                <div class="row g-4" id="fila1">
                    <!-- Aldeas Infantiles -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-tree me-2"></i>ALDEAS INFANTILES
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/aldeas infantiles.png"
                                        alt="Aldeas Infantiles"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Aldeas'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Organización dedicada a la protección y bienestar de la niñez
                                    en situación de vulnerabilidad.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Infancia</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Familia</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.aldeasinfantiles.org.co/nosotros/participa/contactanos"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Fiscalía -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-shield me-2"></i>FISCALÍA
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/LogoFiscalia.jpg"
                                        alt="Fiscalía"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Fiscalia'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Entidad encargada de investigar y acusar los delitos que afectan
                                    a niños, niñas y adolescentes.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Justicia</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Protección</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.fiscalia.gov.co/colombia/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Fundación CINDE -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-building me-2"></i>FUNDACIÓN CINDE
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/fundacin_cinde_logo.jpeg"
                                        alt="Fundación CINDE"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=CINDE'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Centro de investigación y desarrollo en niñez, juventud y familia
                                    con enfoque en derechos.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Investigación</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Desarrollo</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://cinde.org.co/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILA 2: UNICEF, Defensoría, Procuraduría -->
            <div class="container mb-5">
                <div class="row g-4" id="fila2">
                    <!-- UNICEF -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-globe2 me-2"></i>UNICEF
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/uniceflogo.png"
                                        alt="UNICEF"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=UNICEF'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Fondo de las Naciones Unidas para la Infancia, trabaja por los derechos
                                    de los niños en Colombia.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Internacional</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Derechos</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.unicef.org/colombia/que-hace-unicef"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Defensoría del Pueblo -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-shield me-2"></i>DEFENSORÍA DEL PUEBLO
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/Logo_defensoria_del_Pueblo.png"
                                        alt="Defensoría del Pueblo"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Defensoria'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Vela por la promoción y protección de los derechos humanos,
                                    especialmente de la niñez.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Derechos Humanos</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Protección</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.defensoria.gov.co/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Procuraduría -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-shield me-2"></i>PROCURADURÍA
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/Logo_Procuraduria_Colombia.png"
                                        alt="Procuraduría"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Procuraduria'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Vigila el cumplimiento de las políticas públicas de protección
                                    a la infancia y adolescencia.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Vigilancia</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Control</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.procuraduria.gov.co/Pages/Inicio.aspx"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILA 3: Personería de Girardot, ICBF, Plan Internacional -->
            <div class="container mb-5">
                <div class="row g-4" id="fila3">
                    <!-- Personería de Girardot -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-building me-2"></i>PERSONERÍA DE GIRARDOT
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/personeria.jpeg"
                                        alt="Personería de Girardot"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Personeria'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Entidad municipal que protege los derechos de los niños, niñas
                                    y adolescentes en Girardot.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Municipal</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Girardot</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.girardot-cundinamarca.gov.co/NuestraAlcaldia/Paginas/Personeria.aspx"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ICBF -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-heart me-2"></i>ICBF
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/ICBF.jpeg"
                                        alt="ICBF"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=ICBF'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Instituto Colombiano de Bienestar Familiar, entidad rectora de la
                                    protección integral a la niñez.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Bienestar</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Familia</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.icbf.gov.co/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Internacional -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-globe2 me-2"></i>PLAN INTERNACIONAL
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/plan.png"
                                        alt="Plan Internacional"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Plan'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Organización que trabaja por los derechos de la niñez y la igualdad
                                    de las niñas en el mundo.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Internacional</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Igualdad</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://plan-international.org/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILA 4: Policía Nacional (centrada) -->
            <div class="container mb-5">
                <div class="row justify-content-center" id="fila4">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                            <div class="card-header bg-success text-white py-3 border-0 text-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-shield me-2"></i>POLICÍA NACIONAL
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                    <img src="<?php echo BASE_URL; ?>imagenes/redes de apoyo/escudo_policia_nacional_de_colombia.jpg"
                                        alt="Policía Nacional"
                                        style="height: 120px; width: 120px; object-fit: contain;"
                                        onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=Policia'; this.onerror=null;">
                                </div>
                                <p class="text-muted">
                                    Institución que protege y sirve, con unidades especializadas en
                                    infancia y adolescencia.
                                </p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">Protección</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">Infancia</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                                <a href="https://www.policia.gov.co/"
                                    class="btn btn-success px-4 rounded-pill" target="_blank">
                                    <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILA PARA NUEVAS TARJETAS (se agregarán aquí dinámicamente) -->
            <div id="nuevasFilas"></div>
        </div>

        <!-- Línea de atención flotante -->
        <div class="position-fixed bottom-0 end-0 m-4 z-3">
            <a href="tel:018000918080" class="btn btn-success btn-lg rounded-circle shadow-lg p-3"
                data-bs-toggle="tooltip" title="Línea ICBF 01 8000 91 80 80">
                <i class="bi bi-telephone-fill fs-4"></i>
            </a>
        </div>
    </div>

    <!-- MODAL PARA AGREGAR NUEVA RED DE APOYO (MODIFICADO CON CHECKBOXES) -->
    <div class="modal fade" id="modalAgregarRed" tabindex="-1" aria-labelledby="modalAgregarRedLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modalAgregarRedLabel">
                        <i class="bi bi-plus-circle me-2"></i>Agregar Nueva Red de Apoyo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formNuevaRed">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building text-success me-1"></i>Nombre de la Organización
                            </label>
                            <input type="text" class="form-control" id="redNombre" placeholder="Ej: Cruz Roja Colombiana" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-chat-text text-success me-1"></i>Descripción
                            </label>
                            <textarea class="form-control" id="redDescripcion" rows="3" placeholder="Describe la organización..." required></textarea>
                        </div>

                        <!-- NUEVO: Categorías con checkboxes (5 opciones) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tags text-success me-1"></i>Categorías (selecciona hasta 3)
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="redCategorias" id="catProteccion" value="Protección">
                                        <label class="form-check-label" for="catProteccion">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-shield me-1"></i>Protección
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="redCategorias" id="catInfancia" value="Infancia">
                                        <label class="form-check-label" for="catInfancia">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-people me-1"></i>Infancia
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="redCategorias" id="catFamilia" value="Familia">
                                        <label class="form-check-label" for="catFamilia">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-house-heart me-1"></i>Familia
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="redCategorias" id="catEducacion" value="Educación">
                                        <label class="form-check-label" for="catEducacion">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-book me-1"></i>Educación
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="redCategorias" id="catSalud" value="Salud">
                                        <label class="form-check-label" for="catSalud">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-heart-pulse me-1"></i>Salud
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted" id="categoriasSeleccionadas">Categorías seleccionadas: <span class="text-muted">Ninguna</span></small>
                            </div>
                            <input type="hidden" id="redCategoriasValue" name="redCategoriasValue">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-link-45deg text-success me-1"></i>Enlace Web
                            </label>
                            <input type="url" class="form-control" id="redEnlace" placeholder="https://www.ejemplo.org" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-image text-success me-1"></i>Imagen del Header
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-0">
                                    <i class="bi bi-image text-success"></i>
                                </span>
                                <input type="file" class="form-control" id="redImagenHeader" accept="image/*" onchange="previewHeaderImage(event)">
                                <button class="btn btn-outline-success" type="button" onclick="clearHeaderImage()">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <small class="text-muted">Selecciona una imagen para el encabezado de la tarjeta (formatos: JPG, PNG, GIF)</small>

                            <!-- Vista previa de la imagen -->
                            <div id="headerImagePreview" class="mt-2 text-center" style="display: none;">
                                <img id="headerImagePreviewImg" src="#" alt="Vista previa" style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 2px solid #006341;">
                                <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeHeaderImage()">
                                    <i class="bi bi-trash"></i> Quitar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="agregarNuevaRed()">
                        <i class="bi bi-plus-circle me-2"></i>Agregar Red
                    </button>
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
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 99, 65, 0.2) !important;
        }

        .card-header {
            background: linear-gradient(135deg, #006341 0%, #00A651 100%) !important;
        }

        .btn-success {
            transition: all 0.3s ease;
        }

        .hover-card:hover .btn-success {
            transform: scale(1.05);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para agregar nuevas tarjetas con imágenes (MODIFICADO) -->
    <script>
        let contadorFilas = 5; // Empezamos después de la fila 4
        let contadorTarjetas = 0;
        let headerImageBase64 = null;

        function previewHeaderImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    headerImageBase64 = e.target.result;
                    document.getElementById('headerImagePreviewImg').src = e.target.result;
                    document.getElementById('headerImagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function clearHeaderImage() {
            document.getElementById('redImagenHeader').value = '';
            document.getElementById('headerImagePreview').style.display = 'none';
            document.getElementById('headerImagePreviewImg').src = '#';
            headerImageBase64 = null;
        }

        function removeHeaderImage() {
            clearHeaderImage();
        }

        // NUEVA FUNCIÓN: Actualizar el campo oculto con las categorías seleccionadas
        function actualizarCategorias() {
            const checkboxes = document.querySelectorAll('input[name="redCategorias"]:checked');
            const categorias = Array.from(checkboxes).map(cb => cb.value);
            document.getElementById('redCategoriasValue').value = categorias.join(', ');
            
            // Actualizar el texto de las categorías seleccionadas
            const texto = document.getElementById('categoriasSeleccionadas');
            if (categorias.length > 0) {
                let badges = '';
                categorias.forEach(cat => {
                    badges += `<span class="badge bg-success bg-opacity-10 text-success me-1">${cat}</span>`;
                });
                texto.innerHTML = 'Categorías seleccionadas: ' + badges;
            } else {
                texto.innerHTML = 'Categorías seleccionadas: <span class="text-muted">Ninguna</span>';
            }
        }

        // Agregar event listeners a los checkboxes después de que el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="redCategorias"]').forEach(checkbox => {
                checkbox.addEventListener('change', actualizarCategorias);
            });
        });

        // FUNCIÓN MODIFICADA: agregarNuevaRed para usar las categorías seleccionadas
        function agregarNuevaRed() {
            // Obtener valores del formulario
            const nombre = document.getElementById('redNombre').value.trim();
            const descripcion = document.getElementById('redDescripcion').value.trim();
            const categoriasRaw = document.getElementById('redCategoriasValue').value;
            const enlace = document.getElementById('redEnlace').value.trim();

            // Validar campos
            if (!nombre || !descripcion || !categoriasRaw || !enlace) {
                alert('Por favor completa todos los campos y selecciona al menos una categoría');
                return;
            }

            // Procesar categorías
            const categorias = categoriasRaw.split(',').map(cat => cat.trim());

            // Crear badges HTML
            let badgesHTML = '';
            categorias.forEach(cat => {
                if (cat) {
                    badgesHTML += `<span class="badge bg-success bg-opacity-10 text-success me-1">${cat}</span>`;
                }
            });

            // Determinar el contenido del header
            let headerContent = '';
            if (headerImageBase64) {
                // Usar la imagen subida
                headerContent = `<img src="${headerImageBase64}" alt="${nombre}" style="height: 30px; width: 30px; object-fit: contain; border-radius: 4px;" class="me-2">`;
            } else {
                // Usar icono por defecto
                headerContent = `<i class="bi bi-plus-circle me-2"></i>`;
            }

            // Obtener el contenedor de nuevas filas
            const contenedor = document.getElementById('nuevasFilas');

            // Verificar si necesitamos crear una nueva fila (cada 3 tarjetas)
            if (contadorTarjetas % 3 === 0) {
                const nuevaFila = document.createElement('div');
                nuevaFila.className = 'container mb-5';
                nuevaFila.id = `filaNueva${contadorFilas}`;
                nuevaFila.innerHTML = `<div class="row g-4" id="rowNueva${contadorFilas}"></div>`;
                contenedor.appendChild(nuevaFila);
                contadorFilas++;
            }

            // Determinar en qué fila agregar la tarjeta
            const filaActual = Math.floor(contadorTarjetas / 3) + (contadorFilas - 1);
            const rowElement = document.getElementById(`rowNueva${filaActual}`);

            if (rowElement) {
                // Crear la nueva tarjeta
                const nuevaTarjeta = document.createElement('div');
                nuevaTarjeta.className = 'col-md-4';
                nuevaTarjeta.innerHTML = `
                    <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden hover-card">
                        <div class="card-header bg-success text-white py-3 border-0 text-center d-flex align-items-center justify-content-center">
                            ${headerContent}
                            <h5 class="mb-0 fw-bold ms-2">${nombre.toUpperCase()}</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                                <img src="https://via.placeholder.com/120x120/006341/ffffff?text=${nombre.substring(0,3)}"
                                     alt="${nombre}"
                                     style="height: 120px; width: 120px; object-fit: contain;"
                                     onerror="this.src='https://via.placeholder.com/120x120/006341/ffffff?text=${nombre.substring(0,3)}';">
                            </div>
                            <p class="text-muted">
                                ${descripcion}
                            </p>
                            <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                                ${badgesHTML}
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="${enlace}"
                               class="btn btn-success px-4 rounded-pill" target="_blank">
                                <i class="bi bi-eye me-2"></i>VER INFORMACIÓN
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                `;

                rowElement.appendChild(nuevaTarjeta);
                contadorTarjetas++;

                // Cerrar modal y limpiar formulario
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarRed'));
                modal.hide();
                document.getElementById('formNuevaRed').reset();
                clearHeaderImage();
                
                // Limpiar checkboxes
                document.querySelectorAll('input[name="redCategorias"]').forEach(cb => {
                    cb.checked = false;
                });
                actualizarCategorias();
            }
        }

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

</body>

</html>

<br />
<?php include("footer.php"); ?>