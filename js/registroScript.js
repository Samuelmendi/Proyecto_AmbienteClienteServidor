$(function () {

    function redirect(tipo) {

        if (tipo == "paciente") {
            location.href = "Paciente.php";
        } else if (tipo == "medico") {
            location.href = "Medico.php"
        }

    }

    function sendRequest(action, nombre, apellido, telefono, correo, contrasena, tipo) {

        fetch("../app/controller/RegistroController.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action, nombre, apellido, telefono, correo, contrasena, tipo })
        });

    }

    $("#RegistrarBtn").on("click", function () {
        let $tipo = "";
        let $nombre = $("#registroNombre").val();
        let $apellido = $("#registroApellido").val();
        let $telefono = $("#registroTelefono").val();
        let $correo = $("#RegistroCorreo").val();
        let $contrasena = $("#RegistroContraseña").val();
        let $ConfirmaContrasena = $("#ConfirmaContraseña").val()

        if ($("#RadioPaciente").is(':checked')) {
            $tipo = $("#RadioPaciente").val();
        } else {
            $tipo = $("#RadioMedico").val();
        }

        if ($contrasena === $ConfirmaContrasena) {
            sendRequest("usuario", $nombre, $apellido, $telefono, $correo, $contrasena, $tipo); 
        }else{
            alert("Las contraseñas no coinciden");
            return;
        }

        //setTimeout(function(){redirect($tipo)}, 200);


    })



})