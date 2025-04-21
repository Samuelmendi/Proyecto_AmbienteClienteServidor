<?php
require_once '../../config/database.php';

class UsuarioDB {
    public static function create($nombre, $apellidos, $correo, $contrasena, $telefono, $tipo) {
        global $conn;

        $fecha_registro = date('Y-m-d');
        $activo = 1; // Por defecto, el usuario está activo

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, fecha_registro, tipo, activo) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de UsuarioDB::create - " . $conn->error);
            return false;
        }

        $stmt->bind_param("sssssssi", $nombre, $apellidos, $correo, $contrasena, $telefono, $fecha_registro, $tipo, $activo);

        if ($stmt->execute()) {
            return $conn->insert_id; // Devuelve el ID del usuario recién creado
        } else {
            error_log("Error en execute de UsuarioDB::create - " . $stmt->error);
            return false;
        }
    }

    public static function readAll() {
        global $conn;

        $query = "SELECT * FROM usuarios";
        $result = $conn->query($query);

        if (!$result) {
            error_log("Error en query de UsuarioDB::readAll - " . $conn->error);
            return false;
        }

        return $result;
    }

    public static function update($id, $nombre, $apellidos, $correo, $telefono, $tipo) {
        global $conn;

        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = ?, tipo = ? WHERE usuario_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de UsuarioDB::update - " . $conn->error);
            return false;
        }

        $stmt->bind_param("sssssi", $nombre, $apellidos, $correo, $telefono, $tipo, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error en execute de UsuarioDB::update - " . $stmt->error);
            return false;
        }
    }

    public static function delete($id) {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM usuarios WHERE usuario_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de UsuarioDB::delete - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error en execute de UsuarioDB::delete - " . $stmt->error);
            return false;
        }
    }
}
?>