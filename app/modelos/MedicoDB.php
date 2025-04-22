<?php
require_once __DIR__ . '/../../config/database.php';

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

    /**
     * Obtiene información de todos los médicos, con filtro opcional por especialidad
     */
    public static function getMedicos($especialidad = null) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in MedicoDB::getMedicos");
            return false;
        }

        $sql = "SELECT m.medico_id, m.especialidad, m.biografia, m.anos_experiencia, 
                       m.horario_inicio, m.horario_fin, m.dias_laborables,
                       u.nombre, u.apellidos
                FROM medicos m
                JOIN usuarios u ON m.usuario_id = u.usuario_id
                WHERE u.activo = 1";
        
        $params = [];
        $types = "";
        
        if (!empty($especialidad)) {
            $sql .= " AND m.especialidad LIKE ?";
            $params[] = "%$especialidad%";
            $types .= "s";
        }
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Error en prepare de MedicoDB::getMedicos - " . $conn->error);
            return false;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            error_log("Error en get_result de MedicoDB::getMedicos - " . $stmt->error);
            return false;
        }

        $medicos = [];
        while ($row = $result->fetch_assoc()) {
            $row['nombre_completo'] = $row['nombre'] . ' ' . $row['apellidos'];
            $medicos[] = $row;
        }

        return $medicos;
    }

    /**
     * Obtiene las especialidades disponibles en el sistema
     */
    public static function getEspecialidades() {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in MedicoDB::getEspecialidades");
            return false;
        }

        $sql = "SELECT DISTINCT especialidad FROM medicos ORDER BY especialidad";
        $result = $conn->query($sql);

        if (!$result) {
            error_log("Error en query de MedicoDB::getEspecialidades - " . $conn->error);
            return false;
        }

        $especialidades = [];
        while ($row = $result->fetch_assoc()) {
            $especialidades[] = $row['especialidad'];
        }

        return $especialidades;
    }

    /**
     * Obtiene la información de un médico específico
     */
    public static function getMedicoById($medicoId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in MedicoDB::getMedicoById");
            return false;
        }

        $stmt = $conn->prepare("SELECT m.*, u.nombre, u.apellidos, u.correo, u.telefono
                                FROM medicos m
                                JOIN usuarios u ON m.usuario_id = u.usuario_id
                                WHERE m.medico_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de MedicoDB::getMedicoById - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $medicoId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("Error en get_result de MedicoDB::getMedicoById - " . $stmt->error);
            return false;
        }

        return $result->fetch_assoc();
    }

    /**
     * Obtiene el ID de médico basado en el ID de usuario
     */
    public static function getMedicoIdByUsuarioId($usuarioId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in MedicoDB::getMedicoIdByUsuarioId");
            return false;
        }

        $stmt = $conn->prepare("SELECT medico_id FROM medicos WHERE usuario_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de MedicoDB::getMedicoIdByUsuarioId - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("No se encontró médico con usuario_id: " . $usuarioId);
            return false;
        }

        $row = $result->fetch_assoc();
        return $row['medico_id'];
    }
}
?>