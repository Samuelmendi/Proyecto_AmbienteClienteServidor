<?php
require_once '../../config/database.php';

class PacienteDB
{
    public static function add($usuarioId, $direccion, $seguro, $fechaNacimiento)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO pacientes (usuario_id, direccion, seguro_medico, fecha_nacimiento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $usuarioId, $direccion, $seguro, $fechaNacimiento);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
