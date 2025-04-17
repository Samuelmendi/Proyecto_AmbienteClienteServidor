<?php
require_once '../../config/database.php';

class PacienteDB
{
    public static function add($usuarioId, $fechaNacimiento, $genero, $direccion, $seguro): bool
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO pacientes (usuario_id, fecha_nacimiento, genero, direccion, numero_seguro) VALUES ( ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $usuarioId, $fechaNacimiento, $genero, $direccion, $seguro);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }
}
?>
