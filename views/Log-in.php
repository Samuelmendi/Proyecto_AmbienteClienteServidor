<!DOCTYPE html>
<html>
<head>
    <title>MediCare - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
    <div id="WebHeader">
        <a href="../index.php" id="LogoContainer">
            <img src="../assets/img/logo.png" alt="MediCare Logo" id="LogoMedicare">
        </a>
        <div id="loginout">
            <a href="registro.php" id="Registro">Registro</a>
        </div>
    </div>

    <section class="vh-90" style="background-color: #eee;" id="LogInSection">
        <div class="container h-100 p-md-5">
            <h1 id="BienvenidoLogin">Bienvenido</h1>
            <br>
            <div id="errorMessage" style="display:none; color: red;"></div>
            <form>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="loginCorreo" class="form-control" />
                    <label class="form-label" for="loginCorreo">Correo Electrónico</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="loginPassword" class="form-control" />
                    <label class="form-label" for="loginPassword">Contraseña</label>
                </div>

                <!-- Forgot password link -->
                <div class="row mb-4">
                    <div class="col">
                        <a href="#!">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="button" id="loginBtn" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Iniciar Sesión</button>

                <!-- Register link -->
                <div class="text-center">
                    <p>¿No eres miembro? <a href="registro.php">Regístrate</a></p>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br>
    </section>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/loginScript.js"></script>
</body>
</html>