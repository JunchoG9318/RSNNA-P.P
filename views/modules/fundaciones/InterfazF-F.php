<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
?>
<?php
include("../../../header.php");
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <!-- Encabezado con fecha -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">PANEL DEL FUNCIONARIO</h2>
                <span class="badge bg-light text-dark px-3 py-2 border"><?php echo date('d/m/Y'); ?></span>
            </div>

            <!-- Título del módulo -->
            <div class="mb-4">
                <h5 class="text-success fw-semibold">
                    <i class="bi bi-building me-2"></i>Módulo Fundación · Gestión de Internos
                </h5>
            </div>

            <!-- FILA DE TARJETAS DE ESTADÍSTICAS (MÓDULOS RÁPIDOS) -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Total Internos</h6>
                                <h3 class="fw-bold mb-0">156</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-person-check-fill text-success fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Activos</h6>
                                <h3 class="fw-bold mb-0">124</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-calendar-plus-fill text-warning fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Ingresos (mes)</h6>
                                <h3 class="fw-bold mb-0">23</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-building text-info fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Programas</h6>
                                <h3 class="fw-bold mb-0">8</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILA DE MÓDULOS PRINCIPALES (Registro y Búsqueda) -->
            <div class="row g-4">
                <!-- MÓDULO REGISTRO DE INTERNO -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-person-plus-fill text-primary fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Registro de Interno</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                        <div class="d-grid">
                            <a href="<?php echo BASE_URL; ?>views/modules/fundaciones/registroMenor.php" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Registrar Interno
                            </a>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- MÓDULO BÚSQUEDA DE INTERNOS -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-search text-success fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Búsqueda de Internos</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" placeholder="Buscar por nombre o documento...">
                                <button class="btn btn-success" type="button">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="#" class="text-decoration-none">Ver todos los internos <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MÓDULO DE INGRESOS RECIENTES (Tarjeta adicional) -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-clock-history text-warning fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Ingresos Recientes</h5>
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">Últimos 7 días</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Fecha ingreso</th>
                                            <th>Programa</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ana Martínez</td>
                                            <td>CC 1012345678</td>
                                            <td>03/03/2026</td>
                                            <td>Acompañamiento psicológico</td>
                                            <td><span class="badge bg-success">Activo</span></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jorge Ramírez</td>
                                            <td>TI 12349876</td>
                                            <td>02/03/2026</td>
                                            <td>Taller educativo</td>
                                            <td><span class="badge bg-warning text-dark">En proceso</span></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Luisa Fernanda Díaz</td>
                                            <td>CE 987654321</td>
                                            <td>28/02/2026</td>
                                            <td>Residencia</td>
                                            <td><span class="badge bg-success">Activo</span></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons (si no están incluidos en header) -->
<link rel="stylesheet" href="css/font/bootstrap-icons.min.css">
<script src="js/bootstrap.bundle.min.js"></script>

<?php
include("../../../footer.php");
?>