<?php
include("header.php");
session_start();
?> 
<div class="container">
    <form action="fortmato de registro de fundacion" method="post">
        <div class="mb-3">
            <label for="nombreFundacion" class="form-label">Nombre de la Fundación</label>
            <input type="text" class="form-control" id="nombreFundacion" name="nombreFundacion" required>
        </div>
        <div class="mb-3">
            <label for="direccionFundacion" class="form-label">Dirección de la Fundación</label>
            <input type="text" class="form-control" id="direccionFundacion" name="direccionFundacion" required>
        </div>
        <div class="mb-3">
            <label for="telefonoFundacion" class="form-label">Teléfono de la Fundación</label>
            <input type="text" class="form-control" id="telefonoFundacion" name="telefonoFundacion" required>
        </div>
    </form>
</div>
<?php
include("footer.php");
?>