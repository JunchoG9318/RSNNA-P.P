<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autorizado - Sesión no iniciada']);
    exit();
}

require_once("../../../config/conexion.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(['error' => 'ID no válido']);
    exit();
}

// Obtener datos del interno con información de la fundación
// CORREGIDO: Usamos fundacion_nombre para el JOIN con fundaciones.nombre
$sql = "SELECT i.*, f.nombre as fundacion_nombre, f.nit as fundacion_nit, f.ciudad as fundacion_ciudad,
               f.direccion as fundacion_direccion, f.telefono_director as fundacion_telefono,
               f.nombre_director as fundacion_director, f.correo_director as fundacion_correo
        FROM ingresos_fundacion i 
        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre 
        WHERE i.id = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conexion->error]);
    exit();
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Formatear fechas para mejor presentación
    if (!empty($row['fecha_nacimiento'])) {
        $row['fecha_nacimiento_formateada'] = date('d/m/Y', strtotime($row['fecha_nacimiento']));
    }
    if (!empty($row['fecha_ingreso'])) {
        $row['fecha_ingreso_formateada'] = date('d/m/Y', strtotime($row['fecha_ingreso']));
    }
    if (!empty($row['fecha_remision'])) {
        $row['fecha_remision_formateada'] = date('d/m/Y', strtotime($row['fecha_remision']));
    }
    if (!empty($row['fecha_registro'])) {
        $row['fecha_registro_formateada'] = date('d/m/Y H:i', strtotime($row['fecha_registro']));
    }
    
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Interno no encontrado']);
}

$stmt->close();
$conexion->close();
?>