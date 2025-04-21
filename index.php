<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesheet.css">
</head>

<body>
    <!-- Header -->
    <div id="WebHeader">
        <a href="index.php" id="LogoContainer">
            <img src="assets/img/logo.png" alt="MediCare Logo" id="LogoMedicare">
        </a>
        <div id="loginout">
            <a href="views/Log-in.php" id="Login">Log in</a>
            <a href="views/registro.php" id="Registro">Registro</a>
        </div>
    </div>

    <!-- Navegación -->
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="views/agendarCita.php">Agendar Cita</a></li>
            <li><a href="views/gestionUsuarios.php">Gestión de Usuarios</a></li>
            <li><a href="views/panelMedico.php">Panel Médico</a></li>
            <li><a href="views/panelPaciente.php">Panel Paciente</a></li>
        </ul>
    </nav>

    <!-- Hero -->
    <section id="hero">

    </section>

    <!-- Contenido Principal -->
    <div class="container">
        <h2>Bienvenidos</h2>

        <section class="view-section">
            <h2>Características principales</h2>
            <div id="Caracteristicas">
                <ul>
                    <li>Gestión de citas médicas</li>
                    <li>Administración de usuarios</li>
                    <li>Panel especializado para médicos</li>
                </ul>
                <ul>
                    <li>Portal de pacientes</li>
                    <li>Seguridad de datos</li>
                    <li>Interfaz intuitiva</li>
                </ul>
            </div>
        </section>

        <section class="view-section">
            <h2>Sobre Nosotros</h2>
            <p>Somos una plataforma innovadora diseñada para optimizar la gestión médica, facilitando el acceso y la
                administración de la atención para médicos y pacientes.</p>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
