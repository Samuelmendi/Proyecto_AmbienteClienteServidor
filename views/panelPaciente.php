<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el usuario está logueado y es paciente
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'paciente') {
    header('Location: Log-in.php');
    exit();
}

// Obtener el ID del paciente basado en el ID de usuario
require_once '../app/modelos/PacienteDB.php';
$pacienteId = PacienteDB::getPacienteIdByUsuarioId($_SESSION['usuario_id']);

if (!$pacienteId) {
    echo "Error: No se pudo encontrar la información del paciente.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Panel Paciente - MediCare</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>
    <div id="WebHeader">
        <a href="../index.php" id="LogoContainer">
            <img src="../assets/img/logo.png" alt="MediCare Logo" id="LogoMedicare">
        </a>
        <div id="loginout">
            <a href="cerrarSesion.php" id="Login">Cerrar Sesión</a>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="panelPaciente.php" class="active">Panel Paciente</a></li>
            <li><a href="agendarCita.php">Agendar Cita</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Panel del Paciente</h2>
        <p>Bienvenido a tu panel personal. Aquí puedes gestionar tus citas y ver tu historial médico.</p>

        <div id="errorMessage" style="display:none;" class="alert alert-danger"></div>
        <div id="successMessage" style="display:none;" class="alert alert-success"></div>

        <div class="view-section">
            <h3>📅 Mis Citas</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="filtroCitas" class="form-label">Filtrar por estado:</label>
                    <select id="filtroCitas" class="form-select">
                        <option value="todas">Todas</option>
                        <option value="pendiente">Pendientes</option>
                        <option value="confirmada">Confirmadas</option>
                        <option value="completada">Completadas</option>
                        <option value="cancelada">Canceladas</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <a href="agendarCita.php" class="btn">Agendar Nueva Cita</a>
                </div>
            </div>
            
            <div id="loadingCitas" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Cargando tus citas...</p>
            </div>
            <div id="citasContainer" style="display: none;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCitas">
                        <!-- Las citas se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
                <div id="noCitas" style="display: none;" class="alert alert-info">
                    No tienes citas programadas. <a href="agendarCita.php">Agenda tu primera cita</a>.
                </div>
            </div>
        </div>

        <div class="view-section">
            <h3>🩺 Mi Historial Médico</h3>
            <div id="loadingHistorial" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Cargando tu historial médico...</p>
            </div>
            <div id="historialContainer" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Información Personal</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <span id="nombrePaciente">Cargando...</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Fecha de Nacimiento:</strong> <span id="fechaNacimiento">Cargando...</span></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Género:</strong> <span id="generoPaciente">Cargando...</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Número de Seguro:</strong> <span id="numeroSeguro">Cargando...</span></p>
                            </div>
                        </div>
                        <h5 class="card-title mt-4">Historial Médico</h5>
                        <p id="historialMedico">Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles de cita -->
    <div class="modal fade" id="citaModal" tabindex="-1" aria-labelledby="citaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="citaModalLabel">Detalles de la Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="citaDetails">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Médico:</strong> <span id="modalMedico"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Especialidad:</strong> <span id="modalEspecialidad"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fecha y Hora:</strong> <span id="modalFechaHora"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Estado:</strong> <span id="modalEstado"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Motivo de la consulta:</strong>
                            <p id="modalMotivo"></p>
                        </div>
                        <div class="mb-3">
                            <strong>Notas del médico:</strong>
                            <p id="modalNotas">No hay notas disponibles.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" id="cancelarCitaBtn" style="display: none;">Cancelar Cita</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 MediCare. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ID del paciente obtenido desde PHP
        const pacienteId = <?php echo $pacienteId ? $pacienteId : 0; ?>;
        let citasData = []; // Para almacenar los datos de citas
        let citaActual = null; // Para almacenar la cita actual en el modal

        $(document).ready(function() {
            // Cargar citas e historial al cargar la página
            cargarCitas();
            cargarHistorialPaciente();

            // Evento para el filtro de citas
            $('#filtroCitas').on('change', function() {
                mostrarCitasFiltradas();
            });

            // Evento para cancelar cita
            $('#cancelarCitaBtn').on('click', function() {
                if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
                    cancelarCita(citaActual.cita_id);
                }
            });
        });

        // Función para cargar las citas del paciente
        function cargarCitas() {
            $('#loadingCitas').show();
            $('#citasContainer').hide();
            $('#errorMessage').hide();

            // Simulación de carga de datos (reemplazar con llamada a API real)
            setTimeout(function() {
                // Datos de ejemplo - reemplazar con datos reales de API
                citasData = [
                    { 
                        cita_id: 101, 
                        fecha: '2025-04-25', 
                        hora: '10:00', 
                        medico_nombre: 'Dr. Carlos', 
                        medico_apellidos: 'Pérez', 
                        medico_nombre_completo: 'Dr. Carlos Pérez',
                        especialidad: 'Cardiología',
                        estado: 'pendiente',
                        motivo: 'Consulta de rutina',
                        notas: ''
                    },
                    { 
                        cita_id: 102, 
                        fecha: '2025-05-10', 
                        hora: '16:30', 
                        medico_nombre: 'Dra. Ana', 
                        medico_apellidos: 'Gómez', 
                        medico_nombre_completo: 'Dra. Ana Gómez',
                        especialidad: 'Dermatología',
                        estado: 'confirmada',
                        motivo: 'Revisión de tratamiento',
                        notas: ''
                    }
                ];
                
                $('#loadingCitas').hide();
                mostrarCitasFiltradas();
                $('#citasContainer').show();
            }, 1000);

            // Código para la llamada API real (cuando esté implementada)
            /*
            $.ajax({
                url: '../app/controller/CitasController.php',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'getCitasPaciente',
                    pacienteId: pacienteId
                }),
                success: function(response) {
                    $('#loadingCitas').hide();
                    
                    if (response.success) {
                        citasData = response.citas;
                        mostrarCitasFiltradas();
                        $('#citasContainer').show();
                    } else {
                        $('#errorMessage').text('Error: ' + response.message).show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingCitas').hide();
                    $('#errorMessage').text('Error en la conexión. Por favor, intenta nuevamente.').show();
                    console.error('Error en la solicitud:', error);
                }
            });
            */
        }

        // Función para mostrar citas filtradas por estado
        function mostrarCitasFiltradas() {
            const filtro = $('#filtroCitas').val();
            let citasFiltradas = [...citasData];
            
            if (filtro !== 'todas') {
                citasFiltradas = citasData.filter(cita => cita.estado === filtro);
            }
            
            if (citasFiltradas.length === 0) {
                $('#tablaCitas').html('');
                $('#noCitas').show();
            } else {
                $('#noCitas').hide();
                
                let html = '';
                citasFiltradas.forEach(cita => {
                    let estadoClass = '';
                    switch (cita.estado) {
                        case 'pendiente': estadoClass = 'text-warning'; break;
                        case 'confirmada': estadoClass = 'text-primary'; break;
                        case 'completada': estadoClass = 'text-success'; break;
                        case 'cancelada': estadoClass = 'text-danger'; break;
                    }
                    
                    html += `
                        <tr>
                            <td>${cita.fecha}</td>
                            <td>${cita.hora}</td>
                            <td>${cita.medico_nombre_completo}</td>
                            <td>${cita.especialidad}</td>
                            <td><span class="${estadoClass}">${cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1)}</span></td>
                            <td>
                                <button class="btn btn-info btn-sm ver-cita" data-cita-id="${cita.cita_id}">Ver Detalles</button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#tablaCitas').html(html);
                
                // Asignar evento para ver detalles de cita
                $('.ver-cita').on('click', function() {
                    const citaId = $(this).data('cita-id');
                    const cita = citasData.find(c => c.cita_id == citaId);
                    
                    if (cita) {
                        citaActual = cita;
                        
                        // Llenar el modal con los datos de la cita
                        $('#modalMedico').text(cita.medico_nombre_completo);
                        $('#modalEspecialidad').text(cita.especialidad);
                        $('#modalFechaHora').text(`${cita.fecha} a las ${cita.hora}`);
                        $('#modalEstado').text(cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1));
                        $('#modalMotivo').text(cita.motivo);
                        
                        if (cita.notas) {
                            $('#modalNotas').text(cita.notas);
                        } else {
                            $('#modalNotas').text('No hay notas disponibles.');
                        }
                        
                        // Mostrar botón de cancelar solo si la cita está pendiente o confirmada
                        if (cita.estado === 'pendiente' || cita.estado === 'confirmada') {
                            $('#cancelarCitaBtn').show();
                        } else {
                            $('#cancelarCitaBtn').hide();
                        }
                        
                        // Mostrar el modal
                        new bootstrap.Modal(document.getElementById('citaModal')).show();
                    }
                });
            }
        }

        // Función para cargar el historial del paciente
        function cargarHistorialPaciente() {
            $('#loadingHistorial').show();
            $('#historialContainer').hide();

            // Simulación de carga de datos (reemplazar con llamada a API real)
            setTimeout(function() {
                // Datos de ejemplo - reemplazar con datos reales de API
                const historialData = {
                    nombre: 'Juan Pérez',
                    fechaNacimiento: '1985-07-15',
                    genero: 'Masculino',
                    numeroSeguro: 'SEG123456789',
                    historial: 'Paciente con hipertensión arterial controlada mediante medicación. Último chequeo general en marzo 2025 con resultados normales. Se recomienda control de presión arterial regularmente y seguimiento cada 6 meses.'
                };
                
                // Llenar datos en la vista
                $('#nombrePaciente').text(historialData.nombre);
                $('#fechaNacimiento').text(historialData.fechaNacimiento);
                $('#generoPaciente').text(historialData.genero);
                $('#numeroSeguro').text(historialData.numeroSeguro);
                $('#historialMedico').text(historialData.historial);
                
                $('#loadingHistorial').hide();
                $('#historialContainer').show();
            }, 1500);
        }

        // Función para cancelar una cita
        function cancelarCita(citaId) {
            $.ajax({
                url: '../app/controller/CitasController.php',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'cancelar',
                    citaId: citaId
                }),
                success: function(response) {
                    if (response.success) {
                        // Cerrar el modal
                        bootstrap.Modal.getInstance(document.getElementById('citaModal')).hide();
                        
                        // Actualizar los datos locales
                        const index = citasData.findIndex(c => c.cita_id == citaId);
                        if (index !== -1) {
                            citasData[index].estado = 'cancelada';
                        }
                        
                        // Actualizar la vista
                        mostrarCitasFiltradas();
                        
                        // Mostrar mensaje de éxito
                        $('#successMessage').text('Cita cancelada correctamente').show();
                        setTimeout(() => { $('#successMessage').hide(); }, 3000);
                    } else {
                        $('#errorMessage').text('Error: ' + response.message).show();
                        setTimeout(() => { $('#errorMessage').hide(); }, 3000);
                    }
                },
                error: function(xhr, status, error) {
                    $('#errorMessage').text('Error en la conexión. Por favor, intenta nuevamente.').show();
                    console.error('Error en la solicitud:', error);
                    
                    // Como estamos en desarrollo, simulamos una respuesta exitosa
                    // ELIMINAR ESTE CÓDIGO EN PRODUCCIÓN
                    const index = citasData.findIndex(c => c.cita_id == citaId);
                    if (index !== -1) {
                        citasData[index].estado = 'cancelada';
                    }
                    bootstrap.Modal.getInstance(document.getElementById('citaModal')).hide();
                    mostrarCitasFiltradas();
                    $('#successMessage').text('Cita cancelada correctamente').show();
                    setTimeout(() => { $('#successMessage').hide(); }, 3000);
                }
            });
        }
    </script>
</body>

</html>