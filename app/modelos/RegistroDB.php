<?php
require_once '../../config/database.php';

class RegistroDB{

    public static function add($nombre, $apellido, $telefono, $correo, $contrasena, $tipo){
        global $conn;

        $sql = "INSERT INTO usuarios VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$contrasena', '$tipo')";

        if($conn->query($sql) === TRUE){
            return 1;
        }else{
            return 0;
        }
    }
}