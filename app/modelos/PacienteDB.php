<?php
require_once __DIR__ . '/../../config/database.php';

class PacienteDB {
    public static function add($usuarioId, $fechaNacimiento, $direccion, $genero, $numeroSeguro, $historialMedico = '') {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in PacienteDB::add");
            return false;
        }

        // Usamos 'historial' en lugar de 'historial_medico' para coincidir con la estructura de la BD
        $stmt = $conn->prepare("INSERT INTO pacientes (usuario_id, fecha_nacimiento, genero, direccion, numero_seguro, historial) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de PacienteDB::add - " . $conn->error);
            return false;
        }

        $stmt->bind_param("isssss", $usuarioId, $fechaNacimiento, $genero, $direccion, $numeroSeguro, $historialMedico);

        if ($stmt->execute()) {
            error_log("Paciente registrado con ID: " . $conn->insert_id);
            return true;
        } else {
            error_log("Error en execute de PacienteDB::add - " . $stmt->error);
            return false;
        }
    }

    public static function getPacienteIdByUsuarioId($usuarioId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in PacienteDB::getPacienteIdByUsuarioId");
            return false;
        }

        $stmt = $conn->prepare("SELECT paciente_id FROM pacientes WHERE usuario_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de PacienteDB::getPacienteIdByUsuarioId - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("No se encontró paciente con usuario_id: " . $usuarioId);
            return false;
        }

        $row = $result->fetch_assoc();
        return $row['paciente_id'];
    }
    
    /**
     * Obtener información completa de un paciente por su ID
     */
    public static function getPacienteById($pacienteId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in PacienteDB::getPacienteById");
            return false;
        }

        $stmt = $conn->prepare("SELECT p.*, u.nombre, u.apellidos, u.correo, u.telefono
                               FROM pacientes p
                               JOIN usuarios u ON p.usuario_id = u.usuario_id
                               WHERE p.paciente_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de PacienteDB::getPacienteById - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $pacienteId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("No se encontró paciente con ID: " . $pacienteId);
            return false;
        }

        return $result->fetch_assoc();
    }
}
?>