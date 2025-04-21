<?php
// Suppress errors in the response (log them instead)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once '../modelos/RegistroDB.php';
require_once '../modelos/PacienteDB.php';
require_once '../modelos/MedicoDB.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
error_log("Datos recibidos en RegistroController.php: " . print_r($data, true));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit();
}

$action = $data['action'] ?? '';
error_log("Acción recibida: " . $action);

switch ($action) {
    case "usuario":
        $nombre = $data['nombre'] ?? '';
        $apellido = $data['apellido'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $correo = $data['correo'] ?? '';
        $contrasena = $data['contrasena'] ?? '';
        $tipo = $data['tipo'] ?? '';

        if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($contrasena) || empty($tipo)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para la creación de usuario']);
            exit();
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Correo electrónico no válido']);
            exit();
        }

        if (!in_array($tipo, ['paciente', 'medico', 'admin'])) {
            echo json_encode(['success' => false, 'message' => 'Tipo de usuario no válido']);
            exit();
        }

        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $usuarioId = RegistroDB::add($nombre, $apellido, $telefono, $correo, $contrasenaHash, $tipo);

        if ($usuarioId) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'usuarioId' => $usuarioId,
                'tipo' => $tipo
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar usuario, posiblemente el correo ya está registrado']);
        }
        break;

    case "paciente":
        $usuarioId = (int)($data['usuarioId'] ?? 0);
        $fechaNacimiento = $data['fechaNacimiento'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $genero = $data['genero'] ?? '';
        $numeroSeguro = $data['numeroSeguro'] ?? '';
        $historialMedico = $data['historialMedico'] ?? '';

        error_log("Datos de paciente: " . print_r($data, true));

        if ($usuarioId <= 0 || empty($fechaNacimiento) || empty($direccion) || empty($genero) || empty($numeroSeguro)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios para el registro de paciente deben estar completos']);
            exit();
        }

        $result = PacienteDB::add($usuarioId, $fechaNacimiento, $direccion, $genero, $numeroSeguro, $historialMedico);
        error_log("Resultado de PacienteDB::add: " . ($result ? 'true' : 'false'));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Paciente registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar paciente']);
        }
        break;

    case "medico":
        $usuarioId = (int)($data['usuarioId'] ?? 0);
        $especialidad = $data['especialidad'] ?? '';
        $numeroLicencia = $data['licencia'] ?? '';
        $anosExperiencia = $data['Exp'] ?? '';
        $horaInicio = $data['horaInicio'] ?? '';
        $horaFinal = $data['horaFinal'] ?? '';
        $diasLaborables = $data['DiasHabiles'] ?? '';
        $biografia = $data['biografia'] ?? '';

        error_log("Datos de médico: " . print_r($data, true));

        if ($usuarioId <= 0 || empty($especialidad) || empty($numeroLicencia) || empty($anosExperiencia) || empty($horaInicio) || empty($horaFinal) || empty($diasLaborables)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de médico']);
            exit();
        }

        $result = MedicoDB::add($usuarioId, $especialidad, $numeroLicencia, $anosExperiencia, $horaInicio, $horaFinal, $diasLaborables, $biografia);
        error_log("Resultado de MedicoDB::add: " . ($result ? 'true' : 'false'));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Médico registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar médico']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>