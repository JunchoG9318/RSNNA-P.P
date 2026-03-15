<?php
include("header.php");
?>
<div class="container-fluid py-4">

    <div class="container my-4">
        <!-- Título de sección -->
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center mb-3">
                <div class="bg-success bg-opacity-10 rounded-circle p-4">
                    <i class="bi bi-building fs-1 text-success"></i>
                </div>
            </div>
            <h2 class="text-success fw-bold mb-2">
                <i class="bi bi-tree me-2"></i>Fundaciones Aliadas
            </h2>
            <p class="lead text-muted">
                Conoce las fundaciones que trabajan en red con el ICBF para la protección de la niñez
            </p>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                    <i class="bi bi-heart me-1"></i>Aliadas
                </span>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                    <i class="bi bi-shield me-1"></i>Protección
                </span>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                    <i class="bi bi-people me-1"></i>Infancia
                </span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <!-- Carrusel rediseñado con estilo ICBF -->
                <div id="carouselFundaciones" 
                     class="carousel slide shadow-lg rounded-4 overflow-hidden"
                     data-bs-ride="carousel"
                     data-bs-interval="5000">

                    <!-- Indicadores mejorados -->
                    <div class="carousel-indicators">
                        <button type="button"
                            data-bs-target="#carouselFundaciones"
                            data-bs-slide-to="0"
                            class="active bg-success"
                            aria-current="true"
                            aria-label="Fundación Ceres"></button>

                        <button type="button"
                            data-bs-target="#carouselFundaciones"
                            data-bs-slide-to="1"
                            class="bg-success"
                            aria-label="Fundación Manantial de Vida"></button>

                        <button type="button"
                            data-bs-target="#carouselFundaciones"
                            data-bs-slide-to="2"
                            class="bg-success"
                            aria-label="Fundación Santa María"></button>
                    </div>

                    <div class="carousel-inner bg-white">

                        <!-- Slide 1 - Fundación Ceres -->
                        <div class="carousel-item active">
                            <div class="text-center p-5">
                                <!-- Etiqueta de fundación aliada -->
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                                    <i class="bi bi-star-fill me-1"></i>Fundación Aliada ICBF
                                </span>

                                <h3 class="bg-success text-white py-3 rounded-3 mb-4 shadow-sm">
                                    <i class="bi bi-tree me-2"></i>FUNDACIÓN CERES
                                </h3>

                                <div class="position-relative mb-4">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-4">
                                        <div class="ratio ratio-16x9">
                                            <img src="imagenes/fundaciones/fun ceres.png"
                                                class="img-fluid rounded-3 object-fit-cover shadow"
                                                alt="Fundación Ceres"
                                                style="border: 3px solid #006341;">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-muted">
                                        <i class="bi bi-quote me-2 text-success"></i>
                                        Trabajando por el bienestar de la niñez en Girardot
                                    </p>
                                </div>

                                <a href="https://www.facebook.com/profile.php?id=61553745144337"
                                    target="_blank"
                                    class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale">
                                    <i class="bi bi-eye me-2"></i>
                                    Más información
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Slide 2 - Fundación Manantial de Vida -->
                        <div class="carousel-item">
                            <div class="text-center p-5">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                                    <i class="bi bi-star-fill me-1"></i>Fundación Aliada ICBF
                                </span>

                                <h3 class="bg-success text-white py-3 rounded-3 mb-4 shadow-sm">
                                    <i class="bi bi-droplet me-2"></i>FUNDACIÓN MANANTIAL DE VIDA
                                </h3>

                                <div class="position-relative mb-4">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-4">
                                        <div class="ratio ratio-16x9">
                                            <img src="imagenes/fundaciones/Manantial de vida.jpg"
                                                class="img-fluid rounded-3 object-fit-cover shadow"
                                                alt="Fundación Manantial de Vida"
                                                style="border: 3px solid #006341;">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-muted">
                                        <i class="bi bi-quote me-2 text-success"></i>
                                        Transformando vidas con amor y esperanza
                                    </p>
                                </div>

                                <a href="https://manantialdevidagirardot.blogspot.com/"
                                    target="_blank"
                                    class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale">
                                    <i class="bi bi-eye me-2"></i>
                                    Más información
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Slide 3 - Fundación Santa María -->
                        <div class="carousel-item">
                            <div class="text-center p-5">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                                    <i class="bi bi-star-fill me-1"></i>Fundación Aliada ICBF
                                </span>

                                <h3 class="bg-success text-white py-3 rounded-3 mb-4 shadow-sm">
                                    <i class="bi bi-heart me-2"></i>FUNDACIÓN SANTA MARÍA
                                </h3>

                                <div class="position-relative mb-4">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-4">
                                        <div class="ratio ratio-16x9">
                                            <img src="imagenes/fundaciones/santa maria.png"
                                                class="img-fluid rounded-3 object-fit-cover shadow"
                                                alt="Fundación Santa María"
                                                style="border: 3px solid #006341;">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-muted">
                                        <i class="bi bi-quote me-2 text-success"></i>
                                        Construyendo un futuro mejor para los niños
                                    </p>
                                </div>

                                <a href="https://fundacionsantamaria.co/"
                                    target="_blank"
                                    class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale">
                                    <i class="bi bi-eye me-2"></i>
                                    Más información
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Controles mejorados -->
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselFundaciones" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-success rounded-circle p-3" 
                              style="background-size: 60%;"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselFundaciones" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-success rounded-circle p-3"
                              style="background-size: 60%;"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>

                <!-- Información adicional -->
                <div class="row mt-5 g-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-telephone fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Línea de Atención ICBF</h6>
                                    <p class="mb-0 text-success fw-bold">01 8000 91 80 80</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-envelope fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Correo ICBF</h6>
                                    <p class="mb-0 text-success fw-bold small">atencion@icbf.gov.co</p>
                                </div>
                            </div>
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
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: #006341;
    border-radius: 50%;
    padding: 1rem;
}
.hover-scale {
    transition: all 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 99, 65, 0.3) !important;
}
.carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
    opacity: 0.7;
}
.carousel-indicators .active {
    opacity: 1;
    transform: scale(1.2);
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 99, 65, 0.1) !important;
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Footer -->
<?php
include("footer.php");
?>