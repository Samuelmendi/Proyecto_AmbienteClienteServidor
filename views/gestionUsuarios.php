<!DOCTYPE html>
<html>

<head>
    <title>Gestión de Usuarios - MediCare</title>
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
        <h2>Gestión de Usuarios</h2>
        <p>Administra los perfiles de pacientes y médicos.</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>juan.perez@email.com</td>
                    <td>Médico</td>
                    <td>
                        <button>Editar</button>
                        <button>Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>María Gómez</td>
                    <td>maria.gomez@email.com</td>
                    <td>Paciente</td>
                    <td>
                        <button>Editar</button>
                        <button>Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
