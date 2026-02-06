<?php 
class Conexion{

    public function conectar(){
        $pdo = new PDO("mysql:host=localhost;dbname=prototipo_proyecto","root","");
        return $pdo;
    }
}




?>