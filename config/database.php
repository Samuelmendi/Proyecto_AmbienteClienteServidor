<?php

$host = "localhost";
$user = "root";
$password = "123";
$database = "medicare";

try{
    $conn = new mysqli($host, $user, $password, $database);
}catch(mysqli_sql_exception $e){
    die ("Error de conexion: " . $e->getMessage());
}