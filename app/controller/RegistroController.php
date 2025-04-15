<?php
require_once '../models/RegistroDB.php';

header('Content-Type: application/json');

try{
    if($_SERVER['Request_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents("php://input"), true);
        $action = $data['action'] ?? '';

        if($action === 'add' && !empty($data['correo'])){

            echo json_encode(RegistroDB::add($data['nombre'], $data['apellido'], $data['telefono'], $data['correo'], $data['contrasena'], $data['tipo']));

        } else {
            throw new Exception("Acción no válida o parámetros incorrectos.");
        }
    } 
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

?>