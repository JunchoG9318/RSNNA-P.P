<?php
session_start();
include("../../../config/conexion.php");
header('Content-Type: application/json');

$accion = isset($_GET['accion']) ? $_GET['accion'] : (isset($_POST['accion']) ? $_POST['accion'] : '');

switch ($accion) {
    
    case 'listar':
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';
        $tipo = isset($_GET['tipo']) ? mysqli_real_escape_string($conexion, $_GET['tipo']) : '';
        $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conexion, $_GET['estado']) : '';
        
        $registros_por_pagina = 10;
        $offset = ($pagina - 1) * $registros_por_pagina;
        
        // Construir WHERE dinámico
        $where = [];
        if (!empty($busqueda)) {
            $where[] = "(nombre LIKE '%$busqueda%' OR nit LIKE '%$busqueda%')";
        }
        if (!empty($tipo)) {
            $where[] = "tipo = '$tipo'";
        }
        if ($estado !== '') {
            $where[] = "estado = '$estado'";
        }
        
        $where_sql = empty($where) ? "" : "WHERE " . implode(" AND ", $where);
        
        // Total de registros
        $query_total = "SELECT COUNT(*) as total FROM fundaciones $where_sql";
        $result_total = mysqli_query($conexion, $query_total);
        $total_registros = mysqli_fetch_assoc($result_total)['total'];
        $total_paginas = ceil($total_registros / $registros_por_pagina);
        
        // Obtener registros paginados
        $query = "SELECT * FROM fundaciones $where_sql ORDER BY fecha_registro DESC LIMIT $offset, $registros_por_pagina";
        $result = mysqli_query($conexion, $query);
        
        $datos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $datos[] = $row;
        }
        
        echo json_encode([
            'datos' => $datos,
            'total' => $total_registros,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas
        ]);
        break;
        
    case 'ver':
        $id = intval($_GET['id']);
        $query = "SELECT * FROM fundaciones WHERE id = $id";
        $result = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo json_encode(mysqli_fetch_assoc($result));
        } else {
            echo json_encode(['error' => 'Fundación no encontrada']);
        }
        break;
        
    case 'actualizar':
        $id = intval($_POST['id']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $nit = mysqli_real_escape_string($conexion, $_POST['nit']);
        $fecha_constitucion = mysqli_real_escape_string($conexion, $_POST['fecha_constitucion']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        $nombre_director = mysqli_real_escape_string($conexion, $_POST['nombre_director']);
        $correo_director = mysqli_real_escape_string($conexion, $_POST['correo_director']);
        $telefono_director = mysqli_real_escape_string($conexion, $_POST['telefono_director']);
        $estado = intval($_POST['estado']);
        
        // Verificar si el NIT ya existe en otro registro
        $check = mysqli_query($conexion, "SELECT id FROM fundaciones WHERE nit = '$nit' AND id != $id");
        if (mysqli_num_rows($check) > 0) {
            echo json_encode(['success' => false, 'error' => 'El NIT ya está registrado en otra fundación']);
            break;
        }
        
        $query = "UPDATE fundaciones SET 
            nombre = '$nombre',
            nit = '$nit',
            fecha_constitucion = '$fecha_constitucion',
            tipo = '$tipo',
            nombre_director = '$nombre_director',
            correo_director = '$correo_director',
            telefono_director = '$telefono_director',
            estado = $estado
            WHERE id = $id";
        
        if (mysqli_query($conexion, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
        }
        break;
        
    case 'aprobar':
        $id = intval($_POST['id']);
        $query = "UPDATE fundaciones SET estado = 1 WHERE id = $id";
        
        if (mysqli_query($conexion, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
        }
        break;
        
    case 'eliminar':
        $id = intval($_POST['id']);
        $query = "DELETE FROM fundaciones WHERE id = $id";
        
        if (mysqli_query($conexion, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
        }
        break;
        //controlador_busqueda
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
        case 'por_fundacion':
    $fundacion_id = intval($_GET['id']);
    
    // Asumiendo que tienes una relación entre internos y fundaciones
    // Puede ser por un campo id_fundacion en la tabla ingresos_fundacion
    $query = "SELECT id, menor_nombres, menor_tipo_doc, menor_num_doc, fecha_ingreso, motivo_ingreso 
              FROM ingresos_fundacion 
              WHERE id_fundacion = $fundacion_id 
              ORDER BY fecha_ingreso DESC";
    
    $result = mysqli_query($conexion, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
    break;
}
?>