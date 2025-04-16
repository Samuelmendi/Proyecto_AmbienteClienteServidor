<?php
require_once '../../config/database.php';

class MedicoDB
{
    public static function add($usuarioId, $especialidad, $numeroLicencia, $horarioTrabajo)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO medicos (usuario_id, especialidad, numero_licencia, horario_trabajo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $usuarioId, $especialidad, $numeroLicencia, $horarioTrabajo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
