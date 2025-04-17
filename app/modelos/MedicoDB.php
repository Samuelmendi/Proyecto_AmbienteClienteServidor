<?php
require_once '../../config/database.php';

class MedicoDB
{
    public static function add($usuarioId, $especialidad, $numeroLicencia, $exp, $horaInicio, $horaFinal, $diasHabiles)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO medicos (usuario_id, especialidad, numero_licencia, anos_experiencia, horario_inicio, horario_fin, dias_laborables) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $usuarioId, $especialidad, $numeroLicencia, $exp, $horaInicio, $horaFinal, $diasHabiles);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
