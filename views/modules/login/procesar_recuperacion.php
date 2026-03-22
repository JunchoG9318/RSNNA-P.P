<?php
session_start();
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");

require_once("../../../config/conexion.php");

// ============================================
// VALIDAR MÉTODO POST
// ============================================
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: recuperar_password.php");
    exit();
}

// ============================================
// RECIBIR CORREO
// ============================================
$correo = trim($_POST['correo'] ?? '');

if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: recuperar_password.php?error=1");
    exit();
}

// ============================================
// VERIFICAR SI EL CORREO EXISTE
// ============================================
$stmt = $conexion->prepare("SELECT id, nombre_completo FROM usuarios WHERE correo = ? AND estado = 1");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: recuperar_password.php?error=1");
    exit();
}

$usuario = $result->fetch_assoc();
$stmt->close();

// ============================================
// GENERAR TOKEN ÚNICO
// ============================================
$token = bin2hex(random_bytes(50));
$expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

// ============================================
// GUARDAR TOKEN EN BASE DE DATOS
// ============================================
// Primero, verificar si la tabla existe, si no, crearla
$conexion->query("CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiracion DATETIME NOT NULL,
    usado TINYINT DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)");

// Eliminar tokens anteriores del usuario
$delete = $conexion->prepare("DELETE FROM password_resets WHERE usuario_id = ?");
$delete->bind_param("i", $usuario['id']);
$delete->execute();
$delete->close();

// Insertar nuevo token
$insert = $conexion->prepare("INSERT INTO password_resets (usuario_id, token, expiracion) VALUES (?, ?, ?)");
$insert->bind_param("iss", $usuario['id'], $token, $expiracion);

if (!$insert->execute()) {
    header("Location: recuperar_password.php?error=2");
    exit();
}
$insert->close();

// ============================================
// ENVIAR CORREO (VERSIÓN SIMPLIFICADA)
// ============================================
$enlace = BASE_URL . "views/modules/login/restablecer_password.php?token=" . $token;

// Para desarrollo, mostramos el enlace en pantalla (en producción se enviaría por correo)
// COMENTAR ESTAS LÍNEAS EN PRODUCCIÓN Y USAR LA FUNCIÓN MAIL
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Enlace de recuperación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Enlace de recuperación generado</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Modo desarrollo:</strong> Copia este enlace para restablecer tu contraseña:
                        </div>
                        <div class="p-3 bg-light rounded">
                            <a href="<?php echo $enlace; ?>"><?php echo $enlace; ?></a>
                        </div>
                        <hr>
                        <p class="text-muted small">Este enlace expirará en 1 hora.</p>
                        <a href="login.php" class="btn btn-success">Ir al Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
exit();
?>