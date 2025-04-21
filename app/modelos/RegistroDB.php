<?php
require_once '../../config/database.php';

class RegistroDB {
    public static function add($nombre, $apellido, $telefono, $correo, $contrasenaHash, $tipo) {
        global $conn;

        $fechaRegistro = date('Y-m-d');
        $activo = 1; // Por defecto, el usuario está activo

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, telefono, correo, contrasena, fecha_registro, tipo, activo) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de RegistroDB::add - " . $conn->error);
            return false;
        }

        $stmt->bind_param("sssssssi", $nombre, $apellido, $telefono, $correo, $contrasenaHash, $fechaRegistro, $tipo, $activo);

        if ($stmt->execute()) {
            return $conn->insert_id; // Devuelve el ID del usuario recién creado
        } else {
            error_log("Error en execute de RegistroDB::add - " . $stmt->error);
            return false;
        }
    }
}
?>