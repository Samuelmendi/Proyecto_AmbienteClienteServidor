document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('../controllers/LoginController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Bienvenido a MediCare");
            window.location.href = "panel_paciente.php"; // Cambiá esto si tenés otro panel
        } else {
            alert("Usuario o contraseña incorrectos");
        }
    })
    .catch(error => {
        console.error("Error en el login:", error);
    });
});
