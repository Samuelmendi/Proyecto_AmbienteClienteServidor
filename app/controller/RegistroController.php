<?php
require_once '../modelos/RegistroDB.php';
require_once '../modelos/PacienteDB.php';
require_once '../modelos/MedicoDB.php';

header('Content-Type: application/json');

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

        // Encriptar contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Registrar en tabla usuarios
        $usuarioId = RegistroDB::add($nombre, $apellido, $telefono, $correo, $contrasenaHash, $tipo);

        if ($usuarioId) {
            echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente', 'usuarioId' => $usuarioId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
        }
        break;

    case "paciente":
        $usuarioId = $data['usuarioId'] ?? '';
        $fechaNacimiento = $data['fechaNacimiento'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $genero = $data['genero'] ?? '';

        if (empty($usuarioId) || empty($fechaNacimiento) || empty($direccion) || empty($genero)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de paciente']);
            exit();
        }

        if (PacienteDB::add($usuarioId, $fechaNacimiento, $direccion, $genero)) {
            echo json_encode(['success' => true, 'message' => 'Paciente registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar paciente']);
        }
        break;

    case "medico":
        $usuarioId = $data['usuarioId'] ?? '';
        $especialidad = $data['especialidad'] ?? '';
        $numeroLicencia = $data['licencia'] ?? '';
        $Exp = $data['Exp'] ?? '';
        $horaInicio = $data['horaInicio'] ?? '';
        $horaFinal = $data['horaFinal'] ?? '';
        $DiasHabiles = $data['DiasHabiles'] ?? '';

        if (empty($usuarioId) || empty($especialidad) || empty($numeroLicencia) || empty($Exp) || empty($horaInicio) || empty($horaFinal) || empty($DiasHabiles)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de médico']);
            exit();
        }

        if (MedicoDB::add($usuarioId, $especialidad, $numeroLicencia, $Exp, $horaInicio, $horaFinal, $DiasHabiles)) {
            echo json_encode(['success' => true, 'message' => 'Médico registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar médico']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>
