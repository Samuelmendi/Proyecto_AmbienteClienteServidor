$(function () {
    function showError(message) {
        $("#errorMessage").text(message).show();
    }

    async function sendRequest(action, usuarioId, fechaNacimiento, direccion, genero, numeroSeguro, historialMedico) {
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

            if (result.success) {
                // Clear sessionStorage after successful registration
                sessionStorage.removeItem("usuarioId");
                sessionStorage.removeItem("tipoUsuario");

                // Redirect to the patient's panel
                window.location.href = "panelPaciente.php";
            } else {
                showError("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            showError("Ocurrió un error al registrar. Intenta nuevamente.");
        }
    }

    $("#RegistroPacienteBtn").on("click", function () {
        const usuarioId = sessionStorage.getItem("usuarioId");
        const tipoUsuario = sessionStorage.getItem("tipoUsuario");

        if (!usuarioId || tipoUsuario !== "paciente") {
            showError("Error: No se encontró el ID de usuario o el tipo es incorrecto. Por favor, regístrese nuevamente.");
            setTimeout(() => {
                window.location.href = "registro.php";
            }, 2000);
            return;
        }

        const correo = $("#PacienteCorreo").val().trim();
        const fechaNacimiento = $("#birthday").val().trim();
        const genero = $("#genero").val().trim();
        const direccion = $("#RegistroDireccion").val().trim();
        const numeroSeguro = $("#RegistroSeguro").val().trim();
        const historialMedico = $("#historialMedico").val().trim();

        if (!correo || !fechaNacimiento || !genero || !direccion || !numeroSeguro) {
            showError("Por favor llena todos los campos obligatorios.");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            showError("Por favor ingresa un correo electrónico válido.");
            return;
        }

        // Validate date of birth (not in the future)
        const today = new Date();
        const birthDate = new Date(fechaNacimiento);
        if (birthDate > today) {
            showError("La fecha de nacimiento no puede ser futura.");
            return;
        }

        // Send the request to the server
        sendRequest("paciente", usuarioId, fechaNacimiento, direccion, genero, numeroSeguro, historialMedico);
    });
});