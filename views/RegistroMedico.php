<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Médico - MediCare</title>
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
            <h1 id="RegistroMedico">Registro de Médico</h1>
            <div id="errorMessage" style="display:none;"></div>
            <form id="registroMedicoForm" class="RegistroForm">
                <!-- Email confirmation input -->
                <div class="form-group">
                    <label for="MedicoCorreo">Confirmar Correo Electrónico</label>
                    <input type="email" id="MedicoCorreo" name="correo" aria-describedby="errorMessage" />
                </div>

                <!-- Especialidad input -->
                <div class="form-group">
                    <label for="RegistroEspecialidad">Especialidad</label>
                    <input type="text" id="RegistroEspecialidad" aria-describedby="errorMessage" />
                </div>

                <!-- Licencia input -->
                <div class="form-group">
                    <label for="RegistroLicencia">Número de Licencia</label>
                    <input type="text" id="RegistroLicencia" aria-describedby="errorMessage" />
                </div>

                <!-- Años de experiencia input -->
                <div class="form-group">
                    <label for="anosExp">Años de Experiencia</label>
                    <input type="number" id="anosExp" aria-describedby="errorMessage" />
                </div>

                <!-- Horario Laboral input -->
                <div class="form-group">
                    <label>Horario Laboral</label><br>
                    <label for="horaInicio" style="margin-right: 10px;">Hora Inicio:</label>
                    <input type="time" id="horaInicio" name="horaInicio" style="margin-right: 20px;">
                    <label for="horaFin" style="margin-right: 10px;">Hora Fin:</label>
                    <input type="time" id="horaFin" name="horaFin">
                </div>

                <!-- Rango de días hábiles input -->
                <div class="form-group">
                    <label for="RegistroDiasHabiles">Días Laborables (ej. Lun-Vie)</label>
                    <input type="text" id="RegistroDiasHabiles" aria-describedby="errorMessage" />
                </div>

                <!-- Biografía input -->
                <div class="form-group">
                    <label for="biografia">Biografía</label>
                    <textarea id="biografia" aria-describedby="errorMessage" rows="4" style="width: 100%;"></textarea>
                </div>

                <!-- Register button -->
                <button id="RegistroMedicoBtn" type="button" class="btn">Terminar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/registroMedicoScript.js"></script>
</body>
</html>