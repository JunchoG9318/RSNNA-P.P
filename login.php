<?php
include("header.php");
session_start();
?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-success text-white text-center">
                    <h4>Iniciar Sesión</h4>
                </div>

                <div class="card-body">

                    <?php if (isset($_GET["error"])) { ?>

                        <div class="alert alert-danger text-center">
                            Usuario o contraseña incorrectos
                        </div>

                    <?php } ?>


                    <form action="validar_login.php" method="POST">

                        <!-- CORREO -->
                        <div class="mb-3">

                            <label>Correo</label>

                            <input type="email"
                                name="correo"
                                class="form-control"
                                required>

                        </div>


                        <!-- CONTRASEÑA -->
                        <div class="mb-3">

                            <label>Contraseña</label>

                            <input type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>


                        <!-- BOTÓN -->
                        <div class="d-grid">

                            <button type="submit" class="btn btn-success">
                                Ingresar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include("footer.php");
?>