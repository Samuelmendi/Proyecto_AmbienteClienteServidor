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
            <a href="registro.php" id="Registro">Registro</a>
        </div>
    </div>

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="BienvenidoLogin">Bienvenido</h1>
            <br>
            <form>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form2Example1" class="form-control" />
                    <label class="form-label" for="form2Example1">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form2Example2" class="form-control" />
                    <label class="form-label" for="form2Example2">Password</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">

                    <div class="col">
                        <!-- Simple link -->
                        <a href="#!">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4">Sign
                    in</button>

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="registro.php">Register</a></p>
                </div>
            </form>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

    </section>

    <footer>
        <p>© 2024 MediCare. Todos los derechos reservados.</p>
    </footer>
</body>

</html>