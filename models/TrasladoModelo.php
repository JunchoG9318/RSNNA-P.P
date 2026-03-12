<?php
require_once 'models/conexion.php';

class TrasladoModelo {

    private $conexion;

    public function __construct(){
        global $conexion;
        $this->conexion = $conexion;
    }

    // Obtener todas las fundaciones
    public function obtenerFundaciones(){

        try{

            $sql = "SELECT id, nombre, ciudad
                    FROM fundaciones
                    ORDER BY nombre";

            $result = $this->conexion->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);

        }catch(Exception $e){
            return [];
        }
    }

    // Obtener internos por fundación
    public function obtenerInternosPorFundacion($fundacion_id){

        try{

            $sql = "SELECT
                        id,
                        nombre,
                        apellido,
                        documento
                    FROM internos
                    WHERE fundacion_id = ?
                    AND estado = 'activo'
                    ORDER BY nombre";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $fundacion_id);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);

        }catch(Exception $e){
            return [];
        }
    }

    // Registrar traslado
    public function registrarTraslado($datos){

        try{

            $this->conexion->begin_transaction();

            $sql = "INSERT INTO traslados(
                        interno_id,
                        fundacion_origen_id,
                        fundacion_destino_id,
                        fecha_traslado,
                        lugar_traslado,
                        motivo_traslado,
                        responsable_traslado,
                        observaciones,
                        estado
                    )
                    VALUES(
                        ?,?,?,?,?,?,?,?,'pendiente'
                    )";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param(
                "iiisssss",
                $datos['interno_id'],
                $datos['fundacion_origen_id'],
                $datos['fundacion_destino_id'],
                $datos['fecha_traslado'],
                $datos['lugar_traslado'],
                $datos['motivo_traslado'],
                $datos['responsable_traslado'],
                $datos['observaciones'] ?? null
            );
            $stmt->execute();

            $traslado_id = $this->conexion->insert_id;

            // historial salida
            $sqlSalida = "INSERT INTO historial_internos(
                            interno_id,
                            fundacion_id,
                            fecha_salida,
                            traslado_id
                        )
                        VALUES(
                            ?,?,?,?
                        )";

            $stmtSalida = $this->conexion->prepare($sqlSalida);
            $stmtSalida->bind_param(
                "iisi",
                $datos['interno_id'],
                $datos['fundacion_origen_id'],
                $datos['fecha_traslado'],
                $traslado_id
            );
            $stmtSalida->execute();

            // historial ingreso
            $sqlIngreso = "INSERT INTO historial_internos(
                            interno_id,
                            fundacion_id,
                            fecha_ingreso,
                            traslado_id
                        )
                        VALUES(
                            ?,?,?,?
                        )";

            $stmtIngreso = $this->conexion->prepare($sqlIngreso);
            $stmtIngreso->bind_param(
                "iisi",
                $datos['interno_id'],
                $datos['fundacion_destino_id'],
                $datos['fecha_traslado'],
                $traslado_id
            );
            $stmtIngreso->execute();

            // actualizar interno
            $sqlUpdate = "UPDATE internos
                          SET fundacion_id = ?
                          WHERE id = ?";

            $stmtUpdate = $this->conexion->prepare($sqlUpdate);
            $stmtUpdate->bind_param(
                "ii",
                $datos['fundacion_destino_id'],
                $datos['interno_id']
            );
            $stmtUpdate->execute();

            $this->conexion->commit();

            return [
                "success"=>true,
                "id"=>$traslado_id
            ];

        }catch(Exception $e){

            $this->conexion->rollback();

            return [
                "success"=>false,
                "error"=>$e->getMessage()
            ];
        }
    }
}
