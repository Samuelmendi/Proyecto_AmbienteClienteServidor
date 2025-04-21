<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
    <div id="WebHeader">
        <h1><a href="../index.php" id="TitulodePagina">MediCare</a></h1>
        <div id="loginout">
            <a href="Log-in.php" id="Login">Log-in</a>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="agendarCita.php">Agendar Cita</a></li>
            <li><a href="gestionUsuarios.php">Gestión de Usuarios</a></li>
            <li><a href="panelMedico.php">Panel Médico</a></li>
            <li><a href="panelPaciente.php">Panel Paciente</a></li>
        </ul>
    </nav>

    <section id="LogInSection">
        <div class="container">
            <h1 id="BienvenidoLogin">Registro</h1>
            <div id="errorMessage" style="display:none;"></div>
            <form id="registroForm" class="RegistroForm">
                <!-- Name input -->
                <div class="form-group">
                    <label for="registroNombre">Nombre</label>
                    <input type="text" id="registroNombre" aria-describedby="errorMessage" />
                </div>

                <!-- Apellido input -->
                <div class="form-group">
                    <label for="registroApellido">Apellido</label>
                    <input type="text" id="registroApellido" aria-describedby="errorMessage" />
                </div>

                <!-- Telefono input -->
                <div class="form-group">
                    <label for="registroTelefono">Teléfono</label>
                    <input type="text" id="registroTelefono" aria-describedby="errorMessage" />
                </div>

                <!-- Email input -->
                <div class="form-group">
                    <label for="RegistroCorreo">Correo Electrónico</label>
                    <input type="email" id="RegistroCorreo" name="correo" aria-describedby="errorMessage" />
                </div>

                <!-- Password input -->
                <div class="form-group">
                    <label for="RegistroContraseña">Contraseña</label>
                    <input type="password" id="RegistroContraseña" aria-describedby="errorMessage" />
                </div>

                <!-- Password confirmation input -->
                <div class="form-group">
                    <label for="ConfirmaContraseña">Confirma Contraseña</label>
                    <input type="password" id="ConfirmaContraseña" aria-describedby="errorMessage" />
                </div>

                <section class="RadioButtons form-group">
                    <label>Tipo de Usuario</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioOpcion" id="RadioPaciente" value="paciente" checked>
                        <label class="form-check-label" for="RadioPaciente">Paciente</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioOpcion" id="RadioMedico" value="medico">
                        <label class="form-check-label" for="RadioMedico">Médico</label>
                    </div>
                </section>

                <!-- Register button -->
                <button id="RegistrarBtn" type="button" class="btn">Registrar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/registroScript.js"></script>
</body>
</html>