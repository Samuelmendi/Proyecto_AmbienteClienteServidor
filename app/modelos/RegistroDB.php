<?php
require_once '../../config/database.php';

class RegistroDB {
    public static function add($nombre, $apellido, $telefono, $correo, $contrasenaHash, $tipo) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in RegistroDB::add");
            return false;
        }

        $fechaRegistro = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, telefono, correo, contrasena, fecha_registro, tipo) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de RegistroDB::add - " . $conn->error);
            return false;
        }

        $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $correo, $contrasenaHash, $fechaRegistro, $tipo);

        if ($stmt->execute()) {
            return $conn->insert_id;
        } else {
            error_log("Error en execute de RegistroDB::add - " . $stmt->error);
            return false;
        }
    }
}
?>