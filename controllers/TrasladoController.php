<?php
require_once 'config/conexion.php';

class TrasladoModelo {
    
    private $conexion;
    
    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }
    
    // Obtener todas las fundaciones activas
    public function obtenerFundaciones() {
        $query = "SELECT id, nombre_fundacion, direccion, telefono, representante_legal 
                  FROM fundaciones 
                  WHERE estado = 1 
                  ORDER BY nombre_fundacion";
        $resultado = $this->conexion->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener internos activos de una fundación específica
    public function obtenerInternosPorFundacion($fundacion_id) {
        $query = "SELECT id, CONCAT(menor_nombres, ' - ', menor_tipo_doc, ' ', menor_num_doc) as nombre_completo 
                  FROM internos 
                  WHERE id_fundacion = ? AND estado = 'activo'
                  ORDER BY menor_nombres";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $fundacion_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    // Registrar un nuevo traslado
    public function registrarTraslado($datos) {
        // Iniciar transacción
        $this->conexion->begin_transaction();
        
        try {
            // Insertar el traslado
            $query = "INSERT INTO traslados (
                interno_id, fundacion_origen_id, fundacion_destino_id, 
                fecha_traslado, hora_traslado, lugar_traslado, motivo_traslado,
                responsable_traslado, observaciones, estado, fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'completado', NOW())";
            
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param(
                "iiissssss",
                $datos['interno_id'],
                $datos['fundacion_origen_id'],
                $datos['fundacion_destino_id'],
                $datos['fecha_traslado'],
                $datos['hora_traslado'],
                $datos['lugar_traslado'],
                $datos['motivo_traslado'],
                $datos['responsable_traslado'],
                $datos['observaciones']
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Error al registrar el traslado: " . $stmt->error);
            }
            
            $traslado_id = $stmt->insert_id;
            
            // Actualizar la fundación del interno
            $query_update = "UPDATE internos SET 
                            id_fundacion = ?, 
                            estado = 'activo',
                            fecha_actualizacion = NOW() 
                            WHERE id = ?";
            $stmt_update = $this->conexion->prepare($query_update);
            $stmt_update->bind_param("ii", $datos['fundacion_destino_id'], $datos['interno_id']);
            
            if (!$stmt_update->execute()) {
                throw new Exception("Error al actualizar el interno: " . $stmt_update->error);
            }
            
            // Confirmar transacción
            $this->conexion->commit();
            
            return [
                'success' => true,
                'message' => 'Traslado registrado exitosamente',
                'id' => $traslado_id
            ];
            
        } catch (Exception $e) {
            // Revertir cambios en caso de error
            $this->conexion->rollback();
            return [
                'success' => false,
                'message' => 'Error al registrar el traslado: ' . $e->getMessage()
            ];
        }
    }
    
    // Obtener listado de traslados con filtros
    public function obtenerTraslados($filtros = []) {
        $query = "SELECT t.*, 
                         i.menor_nombres, i.menor_tipo_doc, i.menor_num_doc,
                         fo.nombre_fundacion as fundacion_origen_nombre,
                         fd.nombre_fundacion as fundacion_destino_nombre,
                         CONCAT(i.menor_nombres, ' - ', i.menor_tipo_doc, ' ', i.menor_num_doc) as interno_info
                  FROM traslados t
                  INNER JOIN internos i ON t.interno_id = i.id
                  INNER JOIN fundaciones fo ON t.fundacion_origen_id = fo.id
                  INNER JOIN fundaciones fd ON t.fundacion_destino_id = fd.id
                  WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Aplicar filtros
        if (!empty($filtros['fecha_inicio'])) {
            $query .= " AND DATE(t.fecha_traslado) >= ?";
            $params[] = $filtros['fecha_inicio'];
            $types .= "s";
        }
        
        if (!empty($filtros['fecha_fin'])) {
            $query .= " AND DATE(t.fecha_traslado) <= ?";
            $params[] = $filtros['fecha_fin'];
            $types .= "s";
        }
        
        if (!empty($filtros['fundacion_id'])) {
            $query .= " AND (t.fundacion_origen_id = ? OR t.fundacion_destino_id = ?)";
            $params[] = $filtros['fundacion_id'];
            $params[] = $filtros['fundacion_id'];
            $types .= "ii";
        }
        
        $query .= " ORDER BY t.fecha_traslado DESC, t.hora_traslado DESC";
        
        $stmt = $this->conexion->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener un traslado específico por ID
    public function obtenerTrasladoPorId($id) {
        $query = "SELECT t.*, 
                         i.menor_nombres, i.menor_tipo_doc, i.menor_num_doc, i.fecha_nacimiento,
                         fo.nombre_fundacion as fundacion_origen_nombre,
                         fo.direccion as direccion_origen,
                         fo.telefono as telefono_origen,
                         fd.nombre_fundacion as fundacion_destino_nombre,
                         fd.direccion as direccion_destino,
                         fd.telefono as telefono_destino
                  FROM traslados t
                  INNER JOIN internos i ON t.interno_id = i.id
                  INNER JOIN fundaciones fo ON t.fundacion_origen_id = fo.id
                  INNER JOIN fundaciones fd ON t.fundacion_destino_id = fd.id
                  WHERE t.id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    
    // Anular un traslado (cambiar estado)
    public function anularTraslado($id, $motivo = '') {
        $query = "UPDATE traslados SET 
                  estado = 'anulado', 
                  motivo_anulacion = ?,
                  fecha_anulacion = NOW() 
                  WHERE id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("si", $motivo, $id);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Traslado anulado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al anular el traslado: ' . $stmt->error
            ];
        }
    }
    
    // Obtener estadísticas de traslados
    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total_traslados,
                    SUM(CASE WHEN estado = 'completado' THEN 1 ELSE 0 END) as traslados_completados,
                    SUM(CASE WHEN estado = 'anulado' THEN 1 ELSE 0 END) as traslados_anulados,
                    COUNT(DISTINCT interno_id) as internos_trasladados,
                    COUNT(DISTINCT fundacion_origen_id) as fundaciones_origen,
                    COUNT(DISTINCT fundacion_destino_id) as fundaciones_destino
                  FROM traslados";
        
        $resultado = $this->conexion->query($query);
        return $resultado->fetch_assoc();
    }
}
?>