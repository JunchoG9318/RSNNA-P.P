<?php
// Desactivar muestra de errores en pantalla (se capturarán)
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Verificar que el archivo de conexión existe
    $conexion_path = __DIR__ . '/../../../config/conexion.php';
    if (!file_exists($conexion_path)) {
        throw new Exception('Archivo de configuración no encontrado');
    }
    require_once $conexion_path;

    // Validar conexión
    if (!isset($conexion) || !$conexion instanceof mysqli || $conexion->connect_error) {
        throw new Exception('Error de conexión a la base de datos: ' . ($conexion->connect_error ?? 'desconocido'));
    }

    $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

    switch ($accion) {
        case 'guardar':
            guardarRegistro($conexion);
            break;
        case 'actualizar':
            actualizarRegistro($conexion);
            break;
        case 'eliminar':
            eliminarRegistro($conexion);
            break;
        case 'listar':
            listarRegistros($conexion);
            break;
        case 'obtener':
            obtenerRegistro($conexion);
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

function guardarRegistro($conexion) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        return;
    }

    if (empty($_POST['fecha_ingreso']) || empty($_POST['menor_nombres'])) {
        echo json_encode(['success' => false, 'error' => 'Campos obligatorios faltantes']);
        return;
    }

    $fields = [
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

    $placeholders = implode(',', array_fill(0, count($fields), '?'));
    $sql = "INSERT INTO ingresos_fundacion (" . implode(',', $fields) . ") VALUES ($placeholders)";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
        return;
    }

    $types = str_repeat('s', count($fields));
    $params = [];
    foreach ($fields as $field) {
        $params[] = $_POST[$field] ?? null;
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'id' => mysqli_insert_id($conexion)]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
}

function actualizarRegistro($conexion) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        return;
    }

    $id = intval($_POST['id']);

    $fields = [
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

    $set = implode('=?, ', $fields) . '=?';
    $sql = "UPDATE ingresos_fundacion SET $set WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
        return;
    }

    $types = str_repeat('s', count($fields)) . 'i';
    $params = [];
    foreach ($fields as $field) {
        $params[] = $_POST[$field] ?? null;
    }
    $params[] = $id;

    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
}

function eliminarRegistro($conexion) {
    if (empty($_POST['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        return;
    }

    $id = intval($_POST['id']);
    $sql = "DELETE FROM ingresos_fundacion WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
        return;
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
}

function listarRegistros($conexion) {
    $sql = "SELECT id, fecha_ingreso, menor_nombres, menor_tipo_doc, menor_num_doc, acudiente_nombres, motivo_ingreso 
            FROM ingresos_fundacion 
            ORDER BY fecha_ingreso DESC";
    $result = mysqli_query($conexion, $sql);
    if (!$result) {
        echo json_encode(['error' => mysqli_error($conexion)]);
        return;
    }
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function obtenerRegistro($conexion) {
    if (empty($_GET['id'])) {
        echo json_encode(['error' => 'ID no proporcionado']);
        return;
    }

    $id = intval($_GET['id']);
    $sql = "SELECT * FROM ingresos_fundacion WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
        return;
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Registro no encontrado']);
    }
    mysqli_stmt_close($stmt);
}
?>