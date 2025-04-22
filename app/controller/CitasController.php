<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once '../modelos/CitasDB.php';
require_once '../modelos/MedicoDB.php';
require_once '../modelos/PacienteDB.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
error_log("Datos recibidos en CitasController.php: " . print_r($data, true));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit();
}

$action = $data['action'] ?? '';
error_log("Acción recibida: " . $action);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$requiresAuth = ['crear', 'modificar', 'cancelar', 'getCitasMedico', 'getCitasPaciente'];
if (in_array($action, $requiresAuth) && !isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Se requiere iniciar sesión']);
    exit();
}

switch ($action) {
    case 'crear':
        $pacienteId = (int)($data['pacienteId'] ?? 0);
        $medicoId = (int)($data['medicoId'] ?? 0);
        $fechaHora = $data['fechaHora'] ?? '';
        $motivo = $data['motivo'] ?? '';
        
        if ($pacienteId <= 0 || $medicoId <= 0 || empty($fechaHora) || empty($motivo)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
            exit();
        }
        
        $result = CitasDB::crear($pacienteId, $medicoId, $fechaHora, $motivo);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Cita creada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear la cita']);
        }
        break;
    
    case 'modificar':
        $citaId = (int)($data['citaId'] ?? 0);
        $estado = $data['estado'] ?? '';
        $notas = $data['notas'] ?? '';
        
        if ($citaId <= 0 || empty($estado)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos para modificar la cita']);
            exit();
        }
        
        $result = CitasDB::actualizarEstado($citaId, $estado, $notas);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Estado de cita actualizado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado de la cita']);
        }
        break;
    
    case 'cancelar':
        $citaId = (int)($data['citaId'] ?? 0);
        
        if ($citaId <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID de cita no válido']);
            exit();
        }
        
        $result = CitasDB::actualizarEstado($citaId, 'cancelada');
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Cita cancelada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al cancelar la cita']);
        }
        break;
    
    case 'getCitasMedico':
        $medicoId = (int)($data['medicoId'] ?? 0);
        
        if ($medicoId <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID de médico no válido']);
            exit();
        }
        
        $citas = CitasDB::getCitasByMedico($medicoId);
        
        if ($citas !== false) {
            echo json_encode(['success' => true, 'citas' => $citas]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener las citas']);
        }
        break;
    
    case 'getCitasPaciente':
        $pacienteId = (int)($data['pacienteId'] ?? 0);
        
        if ($pacienteId <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID de paciente no válido']);
            exit();
        }
        
        $citas = CitasDB::getCitasByPaciente($pacienteId);
        
        if ($citas !== false) {
            echo json_encode(['success' => true, 'citas' => $citas]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener las citas']);
        }
        break;
    
    case 'getMedicos':
        $especialidad = $data['especialidad'] ?? '';
        
        $medicos = MedicoDB::getMedicos($especialidad);
        
        if ($medicos !== false) {
            echo json_encode(['success' => true, 'medicos' => $medicos]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener la lista de médicos']);
        }
        break;
    
    case 'getHorariosDisponibles':
        $medicoId = (int)($data['medicoId'] ?? 0);
        $fecha = $data['fecha'] ?? '';
        
        if ($medicoId <= 0 || empty($fecha)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos para obtener horarios']);
            exit();
        }
        
        $horarios = CitasDB::getHorariosDisponibles($medicoId, $fecha);
        
        if ($horarios !== false) {
            echo json_encode(['success' => true, 'horarios' => $horarios]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener los horarios disponibles']);
        }
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>