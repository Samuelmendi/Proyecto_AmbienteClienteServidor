<?php
// Suppress errors in the response (log them instead)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Include database connection (assuming RegistroDB.php includes the connection)
require_once '../modelos/RegistroDB.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Parse the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);
error_log("Datos recibidos en LoginController.php: " . print_r($data, true));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit();
}

$action = $data['action'] ?? '';
error_log("Acción recibida: " . $action);

if ($action !== 'login') {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    exit();
}

// Extract email and password from the request
$correo = $data['correo'] ?? '';
$contrasena = $data['contrasena'] ?? '';

if (empty($correo) || empty($contrasena)) {
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son obligatorios']);
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Correo electrónico no válido']);
    exit();
}

// Fetch user from the database
global $conn;
$stmt = $conn->prepare("SELECT usuario_id, contrasena, tipo, activo FROM usuarios WHERE correo = ?");
if (!$stmt) {
    error_log("Error en prepare de LoginController - " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
    exit();
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Correo o contraseña incorrectos']);
    exit();
}

$user = $result->fetch_assoc();

// Check if the user account is active
if (!$user['activo']) {
    echo json_encode(['success' => false, 'message' => 'Cuenta desactivada. Contacta al administrador']);
    exit();
}

// Verify the password
if (!password_verify($contrasena, $user['contrasena'])) {
    echo json_encode(['success' => false, 'message' => 'Correo o contraseña incorrectos']);
    exit();
}

// Determine redirect URL based on user type
$redirect = '';
switch ($user['tipo']) {
    case 'paciente':
        $redirect = 'panelPaciente.php';
        break;
    case 'medico':
        $redirect = 'panelMedico.php';
        break;
    case 'admin':
        $redirect = 'panelAdmin.php'; // Adjust if you have a different admin panel
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Tipo de usuario no válido']);
        exit();
}

// Start session and store user data
session_start();
$_SESSION['usuario_id'] = $user['usuario_id'];
$_SESSION['tipo'] = $user['tipo'];

error_log("Usuario autenticado: " . $user['usuario_id'] . ", tipo: " . $user['tipo']);
echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso', 'redirect' => $redirect]);
?>