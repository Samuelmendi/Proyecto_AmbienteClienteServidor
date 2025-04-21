<?php
$host = 'localhost';
$dbname = 'medicare';
$username = 'root';
$password = ' ';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexion a la base de datos']);
    exit();
}
?>
