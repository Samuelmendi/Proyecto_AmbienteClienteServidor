<?php
require_once '../../config/database.php';

class MedicoDB
{
    public static function add($usuarioId, $especialidad, $numeroLicencia, $exp, $horaInicio, $horaFinal, $diasHabiles, $biografia = '')
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO medicos (usuario_id, especialidad, numero_licencia, anos_experiencia, horario_inicio, horario_fin, dias_laborables, biografia) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            error_log("Error en prepare de MedicoDB::add - " . $conn->error);
            return false;
        }

        $stmt->bind_param("isssssss", $usuarioId, $especialidad, $numeroLicencia, $exp, $horaInicio, $horaFinal, $diasHabiles, $biografia);

        if ($stmt->execute()) {
            return true;  // Éxito al insertar médico
        } else {
            error_log("Error en execute de MedicoDB::add - " . $stmt->error);
            return false;
        }
    }
}
?>