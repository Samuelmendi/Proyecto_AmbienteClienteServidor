$(function () {
    function showError(message) {
        $("#errorMessage").text(message).show();
    }

    async function sendRequest(action, usuarioId, especialidad, licencia, anosExperiencia, horaInicio, horaFin, diasLaborables, biografia) {
        try {
            const response = await fetch("../app/controller/RegistroController.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action,
                    usuarioId,
                    especialidad,
                    licencia,
                    Exp: anosExperiencia, // Matches the key expected by RegistroController.php
                    horaInicio,
                    horaFinal: horaFin, // Matches the key expected by RegistroController.php
                    DiasHabiles: diasLaborables, // Matches the key expected by RegistroController.php
                    biografia
                })
            });

            const result = await response.json();

            if (result.success) {
                // Clear sessionStorage after successful registration
                sessionStorage.removeItem("usuarioId");
                sessionStorage.removeItem("tipoUsuario");

                // Redirect to the doctor's panel
                window.location.href = "panelMedico.php";
            } else {
                showError("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            showError("Ocurrió un error al registrar. Intenta nuevamente.");
        }
    }

    $("#RegistroMedicoBtn").on("click", function () {
        const usuarioId = sessionStorage.getItem("usuarioId");
        const tipoUsuario = sessionStorage.getItem("tipoUsuario");

        if (!usuarioId || tipoUsuario !== "medico") {
            showError("Error: No se encontró el ID de usuario o el tipo es incorrecto. Por favor, regístrese nuevamente.");
            setTimeout(() => {
                window.location.href = "registro.php";
            }, 2000);
            return;
        }

        const correo = $("#MedicoCorreo").val().trim();
        const especialidad = $("#RegistroEspecialidad").val().trim();
        const licencia = $("#RegistroLicencia").val().trim();
        const anosExperiencia = $("#anosExp").val().trim();
        const horaInicio = $("#horaInicio").val().trim();
        const horaFin = $("#horaFin").val().trim();
        const diasLaborables = $("#RegistroDiasHabiles").val().trim();
        const biografia = $("#biografia").val().trim();

        if (!correo || !especialidad || !licencia || !anosExperiencia || !horaInicio || !horaFin || !diasLaborables) {
            showError("Por favor llena todos los campos obligatorios.");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            showError("Por favor ingresa un correo electrónico válido.");
            return;
        }

        if (anosExperiencia < 0) {
            showError("Los años de experiencia no pueden ser negativos.");
            return;
        }

        // Validate that horaFin is after horaInicio
        if (horaInicio && horaFin && horaInicio >= horaFin) {
            showError("La hora de fin debe ser posterior a la hora de inicio.");
            return;
        }

        // Send the request to the server
        sendRequest("medico", usuarioId, especialidad, licencia, anosExperiencia, horaInicio, horaFin, diasLaborables, biografia);
    });
});