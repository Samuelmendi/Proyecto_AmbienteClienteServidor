$(function () {

    function redirect(tipo) {
        if (tipo === "paciente") {
            location.href = "Paciente.php";
        } else if (tipo === "medico") {
            location.href = "Medico.php";
        }
    }

    async function sendRequest(action, nombre, apellido, telefono, correo, contrasena, tipo) {
        try {
            const response = await fetch("../app/controller/RegistroController.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action, nombre, apellido, telefono, correo, contrasena, tipo })
            });

            const result = await response.json();

            if (result.success) {
                alert("Registro exitoso: " + result.message);
                redirect(tipo); // solo redirige si fue exitoso
            } else {
                alert("Error: " + result.message);
            }

        } catch (error) {
            console.error("Error en la solicitud:", error);
            alert("Ocurrió un error al registrar. Intenta nuevamente.");
        }
    }

    $("#RegistrarBtn").on("click", function () {
        let $tipo = $("#RadioPaciente").is(':checked') ? $("#RadioPaciente").val() : $("#RadioMedico").val();

        let $nombre = $("#registroNombre").val().trim();
        let $apellido = $("#registroApellido").val().trim();
        let $telefono = $("#registroTelefono").val().trim();
        let $correo = $("#RegistroCorreo").val().trim();
        let $contrasena = $("#RegistroContraseña").val().trim();
        let $ConfirmaContrasena = $("#ConfirmaContraseña").val().trim();

        if (!$nombre || !$apellido || !$telefono || !$correo || !$contrasena || !$ConfirmaContrasena) {
            alert("Por favor llena todos los campos.");
            return;
        }

        if ($contrasena !== $ConfirmaContrasena) {
            alert("Las contraseñas no coinciden.");
            return;
        }

        sendRequest("usuario", $nombre, $apellido, $telefono, $correo, $contrasena, $tipo);
    });

});
