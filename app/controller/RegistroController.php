<?php
require_once '../modelos/RegistroDB.php';
require_once '../modelos/PacienteDB.php';
require_once '../modelos/MedicoDB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $action = $data['action'] ?? '';

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
        exit();
    } elseif ($action === "usuario") {
        // Datos generales
        $nombre = $data['nombre'] ?? '';
        $apellido = $data['apellido'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $correo = $data['correo'] ?? '';
        $contrasena = $data['contrasena'] ?? '';
        $tipo = $data['tipo'] ?? '';

        // Validación mínima
        if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($contrasena) || empty($tipo)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para la creacion de usuario']);
            exit();
        } else {
            // Registrar en tabla usuarios
            RegistroDB::add($nombre, $apellido, $telefono, $correo, $contrasena, $tipo);
            exit();
        }
    } elseif ($action === "paciente"){
        $usuarioId = $data['usuarioId'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $seguro = $data['seguro'] ?? '';
        $genero = $data['genero'] ?? '';
        $fechaNacimiento = $data['fechaNacimiento'] ?? '';

        // Validación mínima
        if (empty($usuarioId) || empty($direccion) || empty($seguro) || empty($genero) || empty($fechaNacimiento)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de paciente']);
            exit();
        } else {
            // Registrar en tabla usuarios
            PacienteDB::add($usuarioId, $fechaNacimiento, $genero, $direccion, $seguro);
            exit();
        }
    } elseif ($action === "medico"){
        $usuarioId = $data['usuarioId'] ?? '';
        $especialidad = $data['especialidad'] ?? '';
        $numeroLicencia = $data['licencia'] ?? '';
        $Exp = $data['Exp'] ?? '';
        $horaInicio = $data['horaInicio'] ?? '';
        $horaFinal = $data['horaFinal'] ?? '';
        $DiasHabiles = $data['DiasHabiles'] ?? '';

        // Validación mínima
        if (empty($usuarioId) || empty($especialidad) || empty($numeroLicencia) || empty($Exp) || empty($horaInicio) || empty($horaFinal) || empty($DiasHabiles)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios para el registro de medico']);
            exit();
        } else {
            // Registrar en tabla usuarios
            MedicoDB::add($usuarioId, $especialidad, $numeroLicencia, $Exp, $horaInicio, $horaFinal, $DiasHabiles);
            exit();
        }
    }
}
?>