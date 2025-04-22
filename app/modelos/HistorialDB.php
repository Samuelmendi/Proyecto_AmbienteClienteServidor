<?php
require_once __DIR__ . '/../../config/database.php';

class HistorialDB {
    /**
     * Agregar una entrada al historial médico del paciente
     */
    public static function agregarEntrada($pacienteId, $medicoId, $diagnostico, $tratamiento, $observaciones = '') {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in HistorialDB::agregarEntrada");
            return false;
        }

        $fecha = date('Y-m-d');
        
        // Usamos la tabla historial_medico ya que es la que está en la DB actual
        $stmt = $conn->prepare("INSERT INTO historial_medico (paciente_id, medico_id, fecha, diagnostico, tratamiento, observaciones) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de HistorialDB::agregarEntrada - " . $conn->error);
            return false;
        }

        $stmt->bind_param("iissss", $pacienteId, $medicoId, $fecha, $diagnostico, $tratamiento, $observaciones);

        if ($stmt->execute()) {
            return $conn->insert_id;
        } else {
            error_log("Error en execute de HistorialDB::agregarEntrada - " . $stmt->error);
            return false;
        }
    }

    /**
     * Obtener el historial médico de un paciente
     */
    public static function getHistorialPaciente($pacienteId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in HistorialDB::getHistorialPaciente");
            return false;
        }

        $sql = "SELECT h.*, 
                       m.especialidad,
                       u.nombre as medico_nombre, u.apellidos as medico_apellidos
                FROM historial_medico h
                JOIN medicos m ON h.medico_id = m.medico_id
                JOIN usuarios u ON m.usuario_id = u.usuario_id
                WHERE h.paciente_id = ?
                ORDER BY h.fecha DESC";

        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Error en prepare de HistorialDB::getHistorialPaciente - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $pacienteId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            error_log("Error en get_result de HistorialDB::getHistorialPaciente - " . $stmt->error);
            return false;
        }

        $historial = [];
        while ($row = $result->fetch_assoc()) {
            $row['medico_nombre_completo'] = $row['medico_nombre'] . ' ' . $row['medico_apellidos'];
            $historial[] = $row;
        }

        return $historial;
    }
}
?>