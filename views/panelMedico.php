<!DOCTYPE html>
<html>

<head>
    <title>Panel Médico - MediCare</title>
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
        <h2>Panel Médico</h2>
        <p>Aquí puedes gestionar tus citas y revisar la información de tus pacientes.</p>

        <h3>📅 Citas Programadas</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Cita</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>101</td>
                    <td>Carlos Ramírez</td>
                    <td>2024-03-15</td>
                    <td>10:00 AM</td>
                    <td>Pendiente</td>
                    <td>
                        <button>Ver Detalles</button>
                        <button>Cancelar</button>
                    </td>
                </tr>
                <tr>
                    <td>102</td>
                    <td>Andrea López</td>
                    <td>2024-03-16</td>
                    <td>2:00 PM</td>
                    <td>Confirmada</td>
                    <td>
                        <button>Ver Detalles</button>
                        <button>Cancelar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3>🩺 Pacientes Asignados</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Paciente</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Condición</th>
                    <th>Historial</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>201</td>
                    <td>María Fernández</td>
                    <td>35</td>
                    <td>Hipertensión</td>
                    <td><button>Ver Historial</button></td>
                </tr>
                <tr>
                    <td>202</td>
                    <td>Pedro Gómez</td>
                    <td>42</td>
                    <td>Diabetes Tipo 2</td>
                    <td><button>Ver Historial</button></td>
                </tr>
            </tbody>
        </table>
    </main>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
