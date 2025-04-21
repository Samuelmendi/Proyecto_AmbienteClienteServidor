$(function () {
    console.log("loginScript.js loaded successfully");

    function showError(message) {
        console.log("Showing error: " + message);
        $("#errorMessage").text(message).show();
    }

    async function sendRequest(correo, contrasena) {
        console.log("Sending login request with data:", { correo, contrasena });
        try {
            const response = await fetch("../app/controller/LoginController.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "login",
                    correo,
                    contrasena
                })
            });

            const rawResponse = await response.text();
            console.log("Raw server response:", rawResponse);

            const result = JSON.parse(rawResponse);
            console.log("Parsed server response:", result);

            if (result.success) {
                console.log("Login successful, redirecting to:", result.redirect);
                window.location.href = result.redirect;
            } else {
                showError("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            showError("Ocurrió un error al iniciar sesión. Intenta nuevamente.");
        }
    }

    console.log("Attaching click event to loginBtn");
    const $loginBtn = $("#loginBtn");
    if (!$loginBtn.length) {
        console.error("loginBtn not found in the DOM");
        return;
    }

    $loginBtn.on("click", function () {
        console.log("loginBtn clicked");

        const correo = $("#loginCorreo").val().trim();
        const contrasena = $("#loginPassword").val().trim();

        console.log("Form data:", { correo, contrasena });

        if (!correo || !contrasena) {
            showError("Por favor llena todos los campos.");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            showError("Por favor ingresa un correo electrónico válido.");
            return;
        }

        sendRequest(correo, contrasena);
    });
});