<!DOCTYPE html>

<html>

<head>
    <title>MediCare - Registro Paciente</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/registroPacienteScript.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <a href="../index.php" id="LogoContainer">
            <img src="../assets/img/logo.png" alt="MediCare Logo" id="LogoMedicare">
        </a>
        <div id="loginout">
            <a href="Log-in.php" id="Login">Log-in</a>
        </div>
    </div>

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="RegistroPaciente">Registro Paciente</h1>
            <br>
            <div id="errorMessage" style="display:none; color: red;"></div>
            <br>
            <form class="RegistroForm">

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="PacienteCorreo" class="form-control" name="correo" />
                    <label class="form-label" for="PacienteCorreo">Confirmar correo Electrónico</label>
                </div>

                <!-- Date input -->
                <div>
                    <input type="date" id="birthday" name="birthday">
                    <label class="form-label" for="birthday">Fecha de nacimiento</label>
                </div>

                <br>

                <!-- genero input -->
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select class="form-control" id="genero">
                        <option>Masculino</option>
                        <option>Femenino</option>
                        <option>Otro</option>
                    </select>
                </div>

                <br>
                <br>

                <!-- Direccion input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="RegistroDireccion" class="form-control" />
                    <label class="form-label" for="RegistroDireccion">Dirección</label>
                </div>

                <!-- Numero de seguro input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="RegistroSeguro" class="form-control" />
                    <label class="form-label" for="RegistroSeguro">Número de seguro</label>
                </div>

                <!-- Historial médico - campo opcional -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea id="historialMedico" class="form-control"></textarea>
                    <label class="form-label" for="historialMedico">Historial médico (opcional)</label>
                </div>

                <!-- Register button -->
                <button id="RegistroPacienteBtn" type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4">Terminar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>
</body>

</html>