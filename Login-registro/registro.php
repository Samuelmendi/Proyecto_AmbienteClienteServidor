<!DOCTYPE html>

<html>

<head>
    <title>MediCare</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <form>
                <!-- Name input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="nombre" class="form-control" />
                    <label class="form-label" for="nombre">Nombre</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="correo" class="form-control" />
                    <label class="form-label" for="correo">Correo Electronico</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="contraseña" class="form-control" />
                    <label class="form-label" for="contraseña">Contraseña</label>
                </div>

                <!-- Password confirmation input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="Confirmacontraseña" class="form-control" />
                    <label class="form-label" for="Confirmacontraseña">Confirma la contraseña</label>
                </div>

                <br>

                <!-- Register button -->
                <button type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4">Registrar</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>
</body>

</html>