$(function () {
    console.log("registroPacienteScript.js loaded successfully");

    function showError(message) {
        console.log("Showing error: " + message);
        $("#errorMessage").text(message).show();
    }

    async function sendRequest(action, usuarioId, fechaNacimiento, direccion, genero, numeroSeguro, historialMedico) {
        console.log("Sending request with data:", { action, usuarioId, fechaNacimiento, direccion, genero, numeroSeguro, historialMedico });
        try {
            const response = await fetch("../app/controller/RegistroController.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action,
                    usuarioId,
                    fechaNacimiento,
                    direccion,
                    genero,
                    numeroSeguro,
                    historialMedico
                })
            });

            const result = await response.json();
            console.log("Server response:", result);

            if (result.success) {
                sessionStorage.removeItem("usuarioId");
                sessionStorage.removeItem("tipoUsuario");
                console.log("Redirecting to panelPaciente.php");
                window.location.href = "panelPaciente.php";
            } else {
                showError("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            showError("Ocurrió un error al registrar. Intenta nuevamente.");
        }
    }

    console.log("Attaching click event to RegistroPacienteBtn");
    const $registroPacienteBtn = $("#RegistroPacienteBtn");
    if (!$registroPacienteBtn.length) {
        console.error("RegistroPacienteBtn not found in the DOM");
        return;
    }

    $registroPacienteBtn.on("click", function () {
        console.log("RegistroPacienteBtn clicked");

        const usuarioId = sessionStorage.getItem("usuarioId");
        const tipoUsuario = sessionStorage.getItem("tipoUsuario");
        console.log("Session data:", { usuarioId, tipoUsuario });

        if (!usuarioId || tipoUsuario !== "paciente") {
            showError("Error: No se encontró el ID de usuario o el tipo es incorrecto. Por favor, regístrese nuevamente.");
            setTimeout(() => {
                console.log("Redirecting to registro.php due to missing session data");
                window.location.href = "registro.php";
            }, 2000);
            return;
        }

        // Check for each element before accessing its value
        const $pacienteCorreo = $("#PacienteCorreo");
        const $birthday = $("#birthday");
        const $genero = $("#genero");
        const $registroDireccion = $("#RegistroDireccion");
        const $registroSeguro = $("#RegistroSeguro");
        const $historialMedico = $("#historialMedico");

        // Debugging: Log if elements are not found
        if (!$pacienteCorreo.length) console.error("PacienteCorreo not found in the DOM");
        if (!$birthday.length) console.error("birthday not found in the DOM");
        if (!$genero.length) console.error("genero not found in the DOM");
        if (!$registroDireccion.length) console.error("RegistroDireccion not found in the DOM");
        if (!$registroSeguro.length) console.error("RegistroSeguro not found in the DOM");
        if (!$historialMedico.length) console.error("historialMedico not found in the DOM");

        // Safely get values with fallback to empty string
        const correo = $pacienteCorreo.length ? $pacienteCorreo.val().trim() : "";
        const fechaNacimiento = $birthday.length ? $birthday.val().trim() : "";
        const genero = $genero.length ? $genero.val().trim() : "";
        const direccion = $registroDireccion.length ? $registroDireccion.val().trim() : "";
        const numeroSeguro = $registroSeguro.length ? $registroSeguro.val().trim() : "";
        const historialMedico = $historialMedico.length ? $historialMedico.val().trim() : ""; // Optional field

        console.log("Form data:", { correo, fechaNacimiento, genero, direccion, numeroSeguro, historialMedico });

        if (!correo || !fechaNacimiento || !genero || !direccion || !numeroSeguro) {
            showError("Por favor llena todos los campos obligatorios.");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            showError("Por favor ingresa un correo electrónico válido.");
            return;
        }

        const today = new Date();
        const birthDate = new Date(fechaNacimiento);
        if (birthDate > today) {
            showError("La fecha de nacimiento no puede ser futura.");
            return;
        }

        sendRequest("paciente", usuarioId, fechaNacimiento, direccion, genero, numeroSeguro, historialMedico);
    });
});