<!DOCTYPE html>

<html>

<head>
    <title>MediCare</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/registroScript.js"></script>
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

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="BienvenidoLogin">Registro</h1>
            <br>
            <br>
            <form class="RegistroForm">
                <!-- Name input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="registroNombre" class="form-control" />
                    <label class="form-label" for="registroNombre">Nombre</label>
                </div>

                <!-- Apellido input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="registroApellido" class="form-control" />
                    <label class="form-label" for="registroApellido">Apellido</label>
                </div>

                <!-- telefono input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="registroTelefono" class="form-control" />
                    <label class="form-label" for="registroTelefono">Telefono</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroCorreo" class="form-control" />
                    <label class="form-label" for="correo">Correo Electronico</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="RegistroContraseña" class="form-control" />
                    <label class="form-label" for="contraseña">Contraseña</label>
                </div>

                <!-- Password confirmation input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="ConfirmaContraseña" class="form-control" />
                    <label class="form-label" for="Confirmacontraseña">Confirma la contraseña</label>
                </div>

                <section class="RadioButtons">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioOpcion" id="RadioPaciente" value="paciente" checked>
                        <label class="form-check-label" for="RadioPaciente">
                            Paciente              
                        </label>
                    </div>

                    <div style="margin: 20px"></div>
            
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioOpcion" id="RadioMedico" value="medico">
                        <label class="form-check-label" for="RadioMedico">
                            Medico
                        </label>
                    </div>
                </section>

                <br>

                <!-- Register button -->
                <button id="RegistrarBtn" type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4" >Registrar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>
</body>

</html>