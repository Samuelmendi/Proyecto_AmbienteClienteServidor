<?php

$host = "localhost";
$user = "root";
$password = "1234";
$database = "medicare";

try{
    $conn = new mysqli($host, $user, $password, $database);
}catch(mysqli_sql_exception $e){
    die ("Error de conexion: " . $e->getMessage());
}