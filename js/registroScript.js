$(function () {
    function redirect(tipo) {
        if (tipo === "paciente") {
            location.href = "RegistroPaciente.php";
        } else if (tipo === "medico") {
            location.href = "RegistroMedico.php";
        }
    }

    function showError(message) {
        $("#errorMessage").text(message).show();
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
                // 💾 Guardar usuarioId y tipo para usarlos en la siguiente página
                sessionStorage.setItem("usuarioId", result.usuarioId);
                sessionStorage.setItem("tipoUsuario", tipo);

                // Redirige al siguiente formulario (paciente o médico)
                redirect(tipo);
            } else {
                showError("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            showError("Ocurrió un error al registrar. Intenta nuevamente.");
        }
    }

    $("#RegistrarBtn").on("click", function () {
        let tipo = null;
        if ($("#RadioPaciente").is(':checked')) {
            tipo = $("#RadioPaciente").val();
        } else if ($("#RadioMedico").is(':checked')) {
            tipo = $("#RadioMedico").val();
        }

        if (!tipo) {
            showError("Por favor selecciona un tipo de usuario (paciente o médico).");
            return;
        }

        let nombre = $("#registroNombre").val().trim();
        let apellido = $("#registroApellido").val().trim();
        let telefono = $("#registroTelefono").val().trim();
        let correo = $("#RegistroCorreo").val().trim();
        let contrasena = $("#RegistroContraseña").val().trim();
        let confirmaContrasena = $("#ConfirmaContraseña").val().trim();

        if (!nombre || !apellido || !telefono || !correo || !contrasena || !confirmaContrasena) {
            showError("Por favor llena todos los campos.");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^\d{10}$/;
        const minPasswordLength = 8;

        if (!emailRegex.test(correo)) {
            showError("Por favor ingresa un correo electrónico válido.");
            return;
        }

        if (!phoneRegex.test(telefono)) {
            showError("Por favor ingresa un número de teléfono válido (10 dígitos).");
            return;
        }

        if (contrasena.length < minPasswordLength) {
            showError(`La contraseña debe tener al menos ${minPasswordLength} caracteres.`);
            return;
        }

        if (contrasena !== confirmaContrasena) {
            showError("Las contraseñas no coinciden.");
            return;
        }

        // Llama al servidor para registrar usuario
        sendRequest("usuario", nombre, apellido, telefono, correo, contrasena, tipo);
    });
});