<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - MediCare</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <a href="../index.php" id="LogoContainer">
            <img src="../assets/img/logo.png" alt="MediCare Logo" id="LogoMedicare">
            <h1 id="TitulodePagina">MediCare</h1>
        </a>
        <div id="loginout">
            <a href="../Login-registro/Log-in.php" id="Login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
            <a href="../Login-registro/registro.php" id="Registro"><i class="fas fa-user-plus"></i> Registro</a>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="../index.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="agendarCita.php" class="active"><i class="far fa-calendar-plus"></i> Agendar Cita</a></li>
            <li><a href="gestionUsuarios.php"><i class="fas fa-users-cog"></i> Gestión de Usuarios</a></li>
            <li><a href="panelMedico.php"><i class="fas fa-user-md"></i> Panel Médico</a></li>
            <li><a href="panelPaciente.php"><i class="fas fa-user"></i> Panel Paciente</a></li>
        </ul>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e88e5, #1565c0);">
                        <h2 class="mb-0">
                            <i class="far fa-calendar-plus me-2"></i>Agendar Cita Médica
                        </h2>
                    </div>
                    <div class="card-body p-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Complete todos los campos para programar su cita. Recibirá una confirmación por correo electrónico.
                        </div>

                        <form action="#" method="POST" class="mt-4">
                            <div class="row">
                                <!-- Selección de especialidad -->
                                <div class="col-md-6 mb-4">
                                    <label for="especialidad" class="form-label">
                                        <i class="fas fa-stethoscope me-2"></i>Especialidad
                                    </label>
                                    <select id="especialidad" name="especialidad" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una especialidad</option>
                                        <option value="medicina-general">Medicina General</option>
                                        <option value="cardiologia">Cardiología</option>
                                        <option value="pediatria">Pediatría</option>
                                        <option value="neurologia">Neurología</option>
                                        <option value="ginecologia">Ginecología</option>
                                        <option value="oftalmologia">Oftalmología</option>
                                    </select>
                                </div>

                                <!-- Selección de médico -->
                                <div class="col-md-6 mb-4">
                                    <label for="medico" class="form-label">
                                        <i class="fas fa-user-md me-2"></i>Médico
                                    </label>
                                    <select id="medico" name="medico" class="form-control" required>
                                        <option value="" selected disabled>Seleccione un médico</option>
                                        <option value="1">Dr. Juan Pérez</option>
                                        <option value="2">Dra. Ana Gómez</option>
                                        <option value="3">Dr. Carlos Rodríguez</option>
                                        <option value="4">Dra. María Sánchez</option>
                                    </select>
                                </div>

                                <!-- Fecha de la cita -->
                                <div class="col-md-6 mb-4">
                                    <label for="fecha" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Fecha
                                    </label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                                </div>

                                <!-- Hora de la cita -->
                                <div class="col-md-6 mb-4">
                                    <label for="hora" class="form-label">
                                        <i class="fas fa-clock me-2"></i>Hora
                                    </label>
                                    <input type="time" id="hora" name="hora" class="form-control" required>
                                </div>

                                <!-- Motivo de la consulta -->
                                <div class="col-12 mb-4">
                                    <label for="motivo" class="form-label">
                                        <i class="fas fa-comment-medical me-2"></i>Motivo de la consulta
                                    </label>
                                    <textarea id="motivo" name="motivo" class="form-control" rows="4" placeholder="Describa brevemente el motivo de su consulta" required></textarea>
                                </div>

                                <!-- Información adicional -->
                                <div class="col-12 mb-4">
                                    <label for="info-adicional" class="form-label">
                                        <i class="fas fa-info-circle me-2"></i>Información adicional (opcional)
                                    </label>
                                    <textarea id="info-adicional" name="info-adicional" class="form-control" rows="3" placeholder="Incluya cualquier información adicional que considere relevante"></textarea>
                                </div>
                            </div>

                            <!-- Confirmación de términos -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terminos" required>
                                <label class="form-check-label" for="terminos">
                                    Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> para agendar citas
                                </label>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-undo me-2"></i>Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calendar-check me-2"></i>Agendar Cita
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información lateral -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="card shadow-lg mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información</h5>
                    </div>
                    <div class="card-body">
                        <p>Horario de atención:</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-calendar-day me-2"></i>Lunes a viernes: 8:00 AM - 8:00 PM</li>
                            <li><i class="fas fa-calendar-day me-2"></i>Sábados: 8:00 AM - 2:00 PM</li>
                        </ul>
                        <hr>
                        <p><i class="fas fa-phone-alt me-2"></i>Teléfono: (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i>Email: citas@medicare.com</p>
                    </div>
                </div>

                <div class="card shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>¿Puedo cancelar mi cita?</strong></p>
                        <p>Sí, puede cancelar o reprogramar su cita hasta 24 horas antes.</p>
                        <hr>
                        <p><strong>¿Qué documentos debo llevar?</strong></p>
                        <p>Identificación, tarjeta de seguro médico y cualquier estudio médico previo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Términos y Condiciones -->
    <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terminosModalLabel">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Política de Citas</h6>
                    <p>Al agendar una cita en MediCare, usted acepta las siguientes condiciones:</p>
                    <ul>
                        <li>Debe llegar 15 minutos antes de su cita programada.</li>
                        <li>Si necesita cancelar, debe hacerlo con al menos 24 horas de antelación.</li>
                        <li>Las citas perdidas sin previo aviso pueden generar un cargo.</li>
                        <li>Debe traer su identificación y tarjeta de seguro médico a todas las citas.</li>
                    </ul>
                    <!-- Más contenido del modal aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>