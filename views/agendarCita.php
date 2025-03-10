<!DOCTYPE html>
<html>

<head>
    <title>Agendar Cita - MediCare</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <h1>MediCare</h1>
        <div id="loginout">
            <a href="../Login-registro/Log-in.php" id="Login">Log-in</a>
            <a href="../Login-registro/registro.php" id="Registro">Registro</a>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="agendarCita.php">Agendar Cita</a></li>
            <li><a href="gestionUsuario.php">Gestión de Usuarios</a></li>
            <li><a href="panelMedico.php">Panel Médico</a></li>
            <li><a href="panelPaciente.php">Panel Paciente</a></li>
        </ul>
    </nav>

    <main>
        <h2>Agendar una Cita Médica</h2>
        <form action="#" method="POST">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" required>

            <label for="medico">Selecciona un médico:</label>
            <select id="medico" name="medico">
                <option value="1">Dr. Pérez</option>
                <option value="2">Dra. Gómez</option>
            </select>

            <button type="submit">Agendar Cita</button>
        </form>
    </main>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
