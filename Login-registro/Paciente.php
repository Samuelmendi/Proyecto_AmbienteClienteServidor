<!DOCTYPE html>

<html>

<head>
    <title>MediCare</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/registroPacienteScript.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <h1><a href="../index.php" id="TitulodePagina">MediCare</a></h1>
    </div>

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="RegistroPaciente">Registro Paciente</h1>
            <br>
            <br>
            <form class="RegistroForm"> 
                
                <!-- Date input -->
                <div>
                    <input type="date" id="birthday" name="birthday">
                    <label class="form-label" for="birthday">Fecha de nacimiento</label>
                </div>

                <br>

                <!-- genero input -->
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Genero</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Masculino</option>
                        <option>Femenino</option>
                        <option>Otro</option>
                    </select>
                </div>

                <br>
                <br>

                <!-- Direccion input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroDireccion" class="form-control" />
                    <label class="form-label" for="correo">Direccion</label>
                </div>

                <!-- Numero de seguro input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="RegistroSeguro" class="form-control" />
                    <label class="form-label" for="correo">Numero de seguro</label>
                </div>

                <!-- Register button -->
                <button id="RegistroPacienteBtn" type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4">Terminar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>
</body>

</html>