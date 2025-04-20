<?php
require_once '../../config/database.php';

class RegistroDB
{
    public static function add($nombre, $apellido, $telefono, $correo, $password, $tipo)
    {
        global $conn;

        $contrasena = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, tipo) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Error en prepare: " . $conn->error);
            return 0;
        }

        $stmt->bind_param("ssssss", $nombre, $apellido, $correo, $contrasena, $telefono, $tipo);

        if ($stmt->execute()) {
            $usuarioId = $conn->insert_id;   // <<< Aquí obtienes el ID autogenerado
            return $usuarioId;
        } else {
            error_log("Error en execute: " . $stmt->error);
            return 0;
        }
    }
}
?>
