<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../modelos/RegistroDB.php';
require_once '../modelos/PacienteDB.php';
require_once '../modelos/MedicoDB.php';

header('Content-Type: application/json');
// Allow CORS if the front end is on a different domain (adjust as needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit();
}

$action = $data['action'] ?? '';

switch ($action) {
    case "usuario":
        // Datos generales
        $nombre = $data['nombre'] ?? '';
        $apellido = $data['apellido'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $correo = $data['correo'] ?? '';
        $contrasena = $data['contrasena'] ?? '';
        $tipo = $data['tipo'] ?? '';

        // Validación
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

        // Encriptar contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Registrar en tabla usuarios
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
        $usuarioId = $data['usuarioId'] ?? '';
        $fechaNacimiento = $data['fechaNacimiento'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $genero = $data['genero'] ?? '';
        $numeroSeguro = $data['numeroSeguro'] ?? '';
        $historialMedico = $data['historialMedico'] ?? '';

        if (empty($usuarioId) || empty($fechaNacimiento) || empty($direccion) || empty($genero) || empty($numeroSeguro) || empty($historialMedico)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de paciente']);
            exit();
        }

        if (PacienteDB::add($usuarioId, $fechaNacimiento, $direccion, $genero, $numeroSeguro, $historialMedico)) {
            echo json_encode(['success' => true, 'message' => 'Paciente registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar paciente']);
        }
        break;

    case "medico":
        $usuarioId = $data['usuarioId'] ?? '';
        $especialidad = $data['especialidad'] ?? '';
        $numeroLicencia = $data['licencia'] ?? '';
        $anosExperiencia = $data['Exp'] ?? ''; // Renombrado para consistencia
        $horaInicio = $data['horaInicio'] ?? '';
        $horaFinal = $data['horaFinal'] ?? '';
        $diasLaborables = $data['DiasHabiles'] ?? ''; // Renombrado para consistencia
        $biografia = $data['biografia'] ?? '';

        if (empty($usuarioId) || empty($especialidad) || empty($numeroLicencia) || empty($anosExperiencia) || empty($horaInicio) || empty($horaFinal) || empty($diasLaborables)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de médico']);
            exit();
        }

        if (MedicoDB::add($usuarioId, $especialidad, $numeroLicencia, $anosExperiencia, $horaInicio, $horaFinal, $diasLaborables, $biografia)) {
            echo json_encode(['success' => true, 'message' => 'Médico registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar médico']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>