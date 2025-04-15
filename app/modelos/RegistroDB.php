<?php
require_once '../../config/database.php';

class RegistroDB
{

    public static function add($nombre, $apellido, $telefono, $correo, $password, $tipo)
    {
        global $conn;

        $contrasena = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, tipo) VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$contrasena', '$tipo')";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
}