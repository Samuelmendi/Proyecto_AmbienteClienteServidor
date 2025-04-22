<?php
require_once __DIR__ . '/../../config/database.php';

class CitasDB {
    /**
     * Crear una nueva cita
     */
    public static function crear($pacienteId, $medicoId, $fechaHora, $motivo, $estado = 'pendiente') {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::crear");
            return false;
        }

        // Notar que aquí notas es '' ya que en la DB actual no permite NULL
        $notas = '';
        $stmt = $conn->prepare("INSERT INTO citas (paciente_id, medico_id, fecha_hora, estado, motivo, notas, fecha_creacion) 
                                VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::crear - " . $conn->error);
            return false;
        }

        $stmt->bind_param("iissss", $pacienteId, $medicoId, $fechaHora, $estado, $motivo, $notas);

        if ($stmt->execute()) {
            error_log("Cita creada con ID: " . $conn->insert_id);
            return $conn->insert_id;
        } else {
            error_log("Error en execute de CitasDB::crear - " . $stmt->error);
            return false;
        }
    }

    /**
     * Actualizar el estado de una cita
     */
    public static function actualizarEstado($citaId, $estado, $notas = null) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::actualizarEstado");
            return false;
        }

        $sql = "UPDATE citas SET estado = ?";
        $params = [$estado];
        $types = "s";

        if ($notas !== null) {
            $sql .= ", notas = ?";
            $params[] = $notas;
            $types .= "s";
        }

        $sql .= " WHERE cita_id = ?";
        $params[] = $citaId;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::actualizarEstado - " . $conn->error);
            return false;
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error en execute de CitasDB::actualizarEstado - " . $stmt->error);
            return false;
        }
    }

    /**
     * Obtener las citas de un médico
     */
    public static function getCitasByMedico($medicoId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::getCitasByMedico");
            return false;
        }

        $sql = "SELECT c.cita_id, c.fecha_hora, c.estado, c.motivo, c.notas, 
                       u.nombre as paciente_nombre, u.apellidos as paciente_apellidos
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.paciente_id
                JOIN usuarios u ON p.usuario_id = u.usuario_id
                WHERE c.medico_id = ?
                ORDER BY c.fecha_hora";

        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::getCitasByMedico - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $medicoId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            error_log("Error en get_result de CitasDB::getCitasByMedico - " . $stmt->error);
            return false;
        }

        $citas = [];
        while ($row = $result->fetch_assoc()) {
            // Formato fecha para mostrar
            $fecha = new DateTime($row['fecha_hora']);
            $row['fecha'] = $fecha->format('Y-m-d');
            $row['hora'] = $fecha->format('H:i');
            $row['paciente_nombre_completo'] = $row['paciente_nombre'] . ' ' . $row['paciente_apellidos'];
            
            $citas[] = $row;
        }

        return $citas;
    }

    /**
     * Obtener las citas de un paciente
     */
    public static function getCitasByPaciente($pacienteId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::getCitasByPaciente");
            return false;
        }

        $sql = "SELECT c.cita_id, c.fecha_hora, c.estado, c.motivo, c.notas,
                       u.nombre as medico_nombre, u.apellidos as medico_apellidos,
                       m.especialidad
                FROM citas c
                JOIN medicos m ON c.medico_id = m.medico_id
                JOIN usuarios u ON m.usuario_id = u.usuario_id
                WHERE c.paciente_id = ?
                ORDER BY c.fecha_hora";

        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::getCitasByPaciente - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $pacienteId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            error_log("Error en get_result de CitasDB::getCitasByPaciente - " . $stmt->error);
            return false;
        }

        $citas = [];
        while ($row = $result->fetch_assoc()) {
            // Formato fecha para mostrar
            $fecha = new DateTime($row['fecha_hora']);
            $row['fecha'] = $fecha->format('Y-m-d');
            $row['hora'] = $fecha->format('H:i');
            $row['medico_nombre_completo'] = $row['medico_nombre'] . ' ' . $row['medico_apellidos'];
            
            $citas[] = $row;
        }

        return $citas;
    }

    /**
     * Obtener horarios disponibles de un médico en una fecha específica
     */
    public static function getHorariosDisponibles($medicoId, $fecha) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::getHorariosDisponibles");
            return false;
        }

        // Primero obtenemos la información de horario del médico
        $stmt = $conn->prepare("SELECT horario_inicio, horario_fin, dias_laborables FROM medicos WHERE medico_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::getHorariosDisponibles (1) - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $medicoId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("Error en get_result de CitasDB::getHorariosDisponibles (1) - " . $stmt->error);
            return false;
        }

        $infoMedico = $result->fetch_assoc();
        
        // Verificar si la fecha seleccionada es un día laborable para el médico
        $diaSemana = date('w', strtotime($fecha)); // 0 (domingo) a 6 (sábado)
        $diasLaborables = $infoMedico['dias_laborables'];
        
        // Mapeo simple para verificar días laborables
        $diasMap = [
            'Lun' => 1, 'Mar' => 2, 'Mie' => 3, 'Jue' => 4, 'Vie' => 5, 'Sab' => 6, 'Dom' => 0
        ];
        
        $esDiaLaborable = false;
        
        // Si el formato es "Lun-Vie"
        if (strpos($diasLaborables, '-') !== false) {
            list($inicio, $fin) = explode('-', $diasLaborables);
            if (isset($diasMap[$inicio]) && isset($diasMap[$fin])) {
                $inicioNum = $diasMap[$inicio];
                $finNum = $diasMap[$fin];
                
                if ($inicioNum <= $finNum) {
                    $esDiaLaborable = ($diaSemana >= $inicioNum && $diaSemana <= $finNum);
                } else {
                    // Para casos como "Vie-Lun" que incluye el fin de semana
                    $esDiaLaborable = ($diaSemana >= $inicioNum || $diaSemana <= $finNum);
                }
            }
        } 
        // Si el formato es "Lun,Mie,Vie"
        else if (strpos($diasLaborables, ',') !== false) {
            $dias = explode(',', $diasLaborables);
            foreach ($dias as $dia) {
                $dia = trim($dia);
                if (isset($diasMap[$dia]) && $diasMap[$dia] == $diaSemana) {
                    $esDiaLaborable = true;
                    break;
                }
            }
        }
        // Si el formato solo menciona un día "Lun"
        else {
            $dia = trim($diasLaborables);
            if (isset($diasMap[$dia]) && $diasMap[$dia] == $diaSemana) {
                $esDiaLaborable = true;
            }
        }
        
        if (!$esDiaLaborable) {
            return []; // No hay horarios disponibles en este día
        }
        
        // Generar franjas horarias cada 30 minutos desde horario_inicio hasta horario_fin
        $horaInicio = new DateTime($infoMedico['horario_inicio']);
        $horaFin = new DateTime($infoMedico['horario_fin']);
        $intervalo = new DateInterval('PT30M'); // 30 minutos
        
        $franjas = [];
        $current = clone $horaInicio;
        
        while ($current < $horaFin) {
            $franjas[] = $current->format('H:i');
            $current->add($intervalo);
        }
        
        // Obtener citas ya programadas para esta fecha y médico
        $fechaCompleta = $fecha . ' 00:00:00';
        $fechaFinDia = $fecha . ' 23:59:59';
        
        $stmt = $conn->prepare("SELECT DATE_FORMAT(fecha_hora, '%H:%i') as hora 
                                FROM citas 
                                WHERE medico_id = ? 
                                AND fecha_hora BETWEEN ? AND ?
                                AND estado != 'cancelada'");
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::getHorariosDisponibles (2) - " . $conn->error);
            return $franjas; // Retornamos todas las franjas si no podemos consultar las citas
        }

        $stmt->bind_param("iss", $medicoId, $fechaCompleta, $fechaFinDia);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            error_log("Error en get_result de CitasDB::getHorariosDisponibles (2) - " . $stmt->error);
            return $franjas; // Retornamos todas las franjas si hay error
        }
        
        // Eliminar las horas ya reservadas
        $horasOcupadas = [];
        while ($row = $result->fetch_assoc()) {
            $horasOcupadas[] = $row['hora'];
        }
        
        $horasDisponibles = array_diff($franjas, $horasOcupadas);
        
        return array_values($horasDisponibles); // Reindexar el array
    }

    /**
     * Obtener detalles de una cita específica
     */
    public static function getCitaById($citaId) {
        global $conn;

        if (!$conn) {
            error_log("Error: No database connection in CitasDB::getCitaById");
            return false;
        }

        $stmt = $conn->prepare("SELECT c.*, 
                                 p.paciente_id, 
                                 m.medico_id,
                                 up.nombre as paciente_nombre, up.apellidos as paciente_apellidos,
                                 um.nombre as medico_nombre, um.apellidos as medico_apellidos,
                                 m.especialidad
                                FROM citas c
                                JOIN pacientes p ON c.paciente_id = p.paciente_id
                                JOIN medicos m ON c.medico_id = m.medico_id
                                JOIN usuarios up ON p.usuario_id = up.usuario_id
                                JOIN usuarios um ON m.usuario_id = um.usuario_id
                                WHERE c.cita_id = ?");
        
        if (!$stmt) {
            error_log("Error en prepare de CitasDB::getCitaById - " . $conn->error);
            return false;
        }

        $stmt->bind_param("i", $citaId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            error_log("Error en get_result de CitasDB::getCitaById - " . $stmt->error);
            return false;
        }

        return $result->fetch_assoc();
    }
}
?>