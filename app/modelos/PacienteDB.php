<?php
require_once '../../config/database.php';

class PacienteDB {
    public static function add($usuarioId, $fechaNacimiento, $direccion, $genero, $numeroSeguro, $historialMedico) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in PacienteDB::add");
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO pacientes (usuario_id, fecha_nacimiento, direccion, genero, numero_seguro, historial_medico) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            error_log("Error en prepare de PacienteDB::add - " . $conn->error);
            return false;
        }

        $stmt->bind_param("isssss", $usuarioId, $fechaNacimiento, $direccion, $genero, $numeroSeguro, $historialMedico);

        if ($stmt->execute()) {
            error_log("Paciente registrado con ID: " . $conn->insert_id);
            return true;
        } else {
            error_log("Error en execute de PacienteDB::add - " . $stmt->error);
            return false;
        }
    }
}
?>