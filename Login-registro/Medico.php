<!DOCTYPE html>

<html>

<head>
    <title>MediCare</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/registroMedicoScript.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <h1><a href="../index.php" id="TitulodePagina">MediCare</a></h1>
    </div>

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="RegistroMedico">Registro Medico</h1>
            <br>
            <br>
            <form class="RegistroForm">

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="MedicoCorreo" class="form-control" name="correo" />
                    <label class="form-label" for="MedicoCorreo">Confirmar correo Electronico</label>
                </div>

                <!-- Especialidad input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroEspecialidad" class="form-control" />
                    <label class="form-label" for="RegistroEspecialidad">Especialidad</label>
                </div>

                <!-- Licencia input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroLicencia" class="form-control" />
                    <label class="form-label" for="RegistroLicencia">Numero de licencia</label>
                </div>

                <!-- Años de experiencia input -->
                <div data-mdb-input-init class="form-outline">
                    <input type="number" id="anosExp" class="form-control" />
                    <label class="form-label" for="anosExp">Años de experiencia</label>
                </div>

                <br>
                <br>

                <!-- Horario Laboral input -->
                <section>
                    <h4>Horaior Laborar</h4>
                    <label for="horaInicio">Hora Inicio:</label>
                    <input type="time" id="horaInicio" name="horaInicio" style="margin-right: 50px;">
                    <label for="horaFin">Hora Salida:</label>
                    <input type="time" id="horaFin" name="horaInicio">
                </section>

                <br>
                <br>

                <!-- Rango de dias que labura input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroDiasHabiles" class="form-control" />
                    <label class="form-label" for="RegistroDiasHabiles">Rango de Dias Habiles</label>
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