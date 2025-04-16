<?php
require_once '../Model/RegistroDB.php';
require_once '../Model/PacienteDB.php';
require_once '../Model/MedicoDB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
        exit;
    }

    // Datos generales
    $nombre = $data['nombre'] ?? '';
    $apellido = $data['apellido'] ?? '';
    $telefono = $data['telefono'] ?? '';
    $correo = $data['correo'] ?? '';
    $contrasena = $data['contrasena'] ?? '';
    $tipo = $data['tipo'] ?? '';

    // Validación mínima
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($contrasena) || empty($tipo)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Registrar en tabla usuarios
    $usuarioId = RegistroDB::add($nombre, $apellido, $telefono, $correo, $contrasena, $tipo);

    if ($usuarioId > 0) {
        // Si el usuario es paciente, registrar en tabla pacientes
        if (strtolower($tipo) === 'paciente') {
            $direccion = $data['direccion'] ?? '';
            $seguro = $data['seguro'] ?? '';
            $fechaNacimiento = $data['fechaNacimiento'] ?? '';

            $pacienteAgregado = PacienteDB::add($usuarioId, $direccion, $seguro, $fechaNacimiento);

            if (!$pacienteAgregado) {
                echo json_encode(['success' => false, 'message' => 'Usuario creado, pero ocurrió un error al registrar los datos del paciente']);
                exit;
            }
        }

        // Si el usuario es médico, registrar en tabla medicos
        if (strtolower($tipo) === 'medico') {
            $especialidad = $data['especialidad'] ?? '';
            $numeroLicencia = $data['numeroLicencia'] ?? '';
            $horarioTrabajo = $data['horarioTrabajo'] ?? '';

            $medicoAgregado = MedicoDB::add($usuarioId, $especialidad, $numeroLicencia, $horarioTrabajo);

            if (!$medicoAgregado) {
                echo json_encode(['success' => false, 'message' => 'Usuario creado, pero ocurrió un error al registrar los datos del médico']);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
    }
}
?>
