<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el usuario está logueado y es médico
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'medico') {
    header('Location: Log-in.php');
    exit();
}

// Obtener el ID del médico basado en el ID de usuario
require_once '../app/modelos/MedicoDB.php';
$medicoId = MedicoDB::getMedicoIdByUsuarioId($_SESSION['usuario_id']);

if (!$medicoId) {
    echo "Error: No se pudo encontrar la información del médico.";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Panel Médico - MediCare</title>
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
            <li><a href="agendarCita.php">Agendar Cita</a></li>
            <li><a href="panelMedico.php" class="active">Panel Médico</a></li>
        </ul>
    </nav>

    <main class="container">
        <h2>Panel Médico</h2>
        <p>Aquí puedes gestionar tus citas y revisar la información de tus pacientes.</p>

        <div id="errorMessage" style="display:none;" class="alert alert-danger"></div>
        <div id="successMessage" style="display:none;" class="alert alert-success"></div>

        <h3>📅 Citas Programadas</h3>
        <div class="mb-3">
            <label for="filtroEstado" class="form-label">Filtrar por estado:</label>
            <select id="filtroEstado" class="form-select">
                <option value="todos">Todos</option>
                <option value="pendiente">Pendientes</option>
                <option value="confirmada">Confirmadas</option>
                <option value="completada">Completadas</option>
                <option value="cancelada">Canceladas</option>
            </select>
        </div>

        <div id="loadingCitas" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p>Cargando citas...</p>
        </div>

        <div id="citasContainer" style="display:none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaCitas">
                    <!-- Las citas se cargarán dinámicamente aquí -->
                </tbody>
            </table>
            <div id="noCitas" style="display:none;" class="alert alert-info">
                No hay citas programadas.
            </div>
        </div>

        <h3>🩺 Pacientes Asignados</h3>
        <div id="loadingPacientes" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p>Cargando pacientes...</p>
        </div>

        <div id="pacientesContainer" style="display:none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Paciente</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Condición</th>
                        <th>Historial</th>
                    </tr>
                </thead>
                <tbody id="tablaPacientes">
                    <!-- Los pacientes se cargarán dinámicamente aquí -->
                </tbody>
            </table>
            <div id="noPacientes" style="display:none;" class="alert alert-info">
                No hay pacientes asignados.
            </div>
        </div>
    </main>

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
                                <strong>Paciente:</strong> <span id="modalPaciente"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Fecha y Hora:</strong> <span id="modalFechaHora"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Estado:</strong> <span id="modalEstado"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>ID de Cita:</strong> <span id="modalCitaId"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Motivo de la consulta:</strong>
                            <p id="modalMotivo"></p>
                        </div>
                        <div class="mb-3">
                            <label for="modalNotas" class="form-label"><strong>Notas médicas:</strong></label>
                            <textarea class="form-control" id="modalNotas" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="modalEstadoSelect" class="form-label"><strong>Actualizar estado:</strong></label>
                            <select class="form-select" id="modalEstadoSelect">
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarCambiosBtn">Guardar Cambios</button>
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
        // ID del médico obtenido desde PHP
        const medicoId = <?php echo $medicoId ? $medicoId : 0; ?>;
        let citasData = []; // Para almacenar los datos de citas
        let pacientesData = []; // Para almacenar los datos de pacientes
        let citaActual = null; // Para almacenar la cita actual en el modal

        $(document).ready(function() {
            // Cargar citas al iniciar
            cargarCitas();
            cargarPacientes();

            // Evento para el filtro de estado
            $('#filtroEstado').on('change', function() {
                mostrarCitasFiltradas();
            });

            // Evento para guardar cambios en una cita
            $('#guardarCambiosBtn').on('click', function() {
                const citaId = citaActual.cita_id;
                const estado = $('#modalEstadoSelect').val();
                const notas = $('#modalNotas').val();

                actualizarCita(citaId, estado, notas);
            });
        });

        // Función para cargar las citas del médico
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
                        paciente_nombre_completo: 'Carlos Ramírez', 
                        fecha: '2025-04-25', 
                        hora: '10:00', 
                        estado: 'pendiente',
                        motivo: 'Consulta de rutina',
                        notas: ''
                    },
                    { 
                        cita_id: 102, 
                        paciente_nombre_completo: 'Andrea López', 
                        fecha: '2025-04-26', 
                        hora: '14:00', 
                        estado: 'confirmada',
                        motivo: 'Revisión de exámenes',
                        notas: 'Paciente con antecedentes de hipertensión'
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
                    action: 'getCitasMedico',
                    medicoId: medicoId
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
            const estado = $('#filtroEstado').val();
            let citasFiltradas = [...citasData];
            
            if (estado !== 'todos') {
                citasFiltradas = citasData.filter(cita => cita.estado === estado);
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
                            <td>${cita.cita_id}</td>
                            <td>${cita.paciente_nombre_completo}</td>
                            <td>${cita.fecha}</td>
                            <td>${cita.hora}</td>
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
                        $('#modalPaciente').text(cita.paciente_nombre_completo);
                        $('#modalFechaHora').text(`${cita.fecha} a las ${cita.hora}`);
                        $('#modalEstado').text(cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1));
                        $('#modalCitaId').text(cita.cita_id);
                        $('#modalMotivo').text(cita.motivo);
                        $('#modalNotas').val(cita.notas || '');
                        $('#modalEstadoSelect').val(cita.estado);
                        
                        // Mostrar el modal
                        new bootstrap.Modal(document.getElementById('citaModal')).show();
                    }
                });
            }
        }

        // Función para cargar los pacientes del médico
        function cargarPacientes() {
            $('#loadingPacientes').show();
            $('#pacientesContainer').hide();

            // Simulación de carga de datos (reemplazar con llamada a API real)
            setTimeout(function() {
                // Datos de ejemplo - reemplazar con datos reales de API
                pacientesData = [
                    { 
                        paciente_id: 201, 
                        nombre_completo: 'María Fernández', 
                        edad: 35,
                        condicion: 'Hipertensión',
                        historial: 'Paciente con hipertensión controlada. Última visita: 15/03/2025'
                    },
                    { 
                        paciente_id: 202, 
                        nombre_completo: 'Pedro Gómez', 
                        edad: 42,
                        condicion: 'Diabetes Tipo 2',
                        historial: 'Paciente con diabetes tipo 2. Control mensual requerido.'
                    }
                ];
                
                $('#loadingPacientes').hide();
                
                if (pacientesData.length === 0) {
                    $('#noPacientes').show();
                } else {
                    let html = '';
                    pacientesData.forEach(paciente => {
                        html += `
                            <tr>
                                <td>${paciente.paciente_id}</td>
                                <td>${paciente.nombre_completo}</td>
                                <td>${paciente.edad}</td>
                                <td>${paciente.condicion}</td>
                                <td><button class="btn btn-info btn-sm ver-historial" data-paciente-id="${paciente.paciente_id}">Ver Historial</button></td>
                            </tr>
                        `;
                    });
                    
                    $('#tablaPacientes').html(html);
                    $('#pacientesContainer').show();
                    
                    // Asignar evento para ver historial de paciente
                    $('.ver-historial').on('click', function() {
                        const pacienteId = $(this).data('paciente-id');
                        const paciente = pacientesData.find(p => p.paciente_id == pacienteId);
                        
                        if (paciente) {
                            alert(`Historial de ${paciente.nombre_completo}:\n\n${paciente.historial}`);
                        }
                    });
                }
            }, 1000);
        }

        // Función para actualizar el estado de una cita
        function actualizarCita(citaId, estado, notas) {
            // Simulación de actualización (reemplazar con llamada a API real)
            setTimeout(function() {
                // Actualizar datos locales
                const index = citasData.findIndex(c => c.cita_id == citaId);
                if (index !== -1) {
                    citasData[index].estado = estado;
                    citasData[index].notas = notas;
                }
                
                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('citaModal'));
                if (modal) modal.hide();
                
                // Actualizar la vista
                mostrarCitasFiltradas();
                
                // Mostrar mensaje de éxito
                $('#successMessage').text('Cita actualizada correctamente').show();
                setTimeout(() => { $('#successMessage').hide(); }, 3000);
            }, 500);

            // Código para la llamada API real (cuando esté implementada)
            /*
            $.ajax({
                url: '../app/controller/CitasController.php',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'modificar',
                    citaId: citaId,
                    estado: estado,
                    notas: notas
                }),
                success: function(response) {
                    if (response.success) {
                        // Cerrar el modal
                        bootstrap.Modal.getInstance(document.getElementById('citaModal')).hide();
                        
                        // Actualizar los datos locales
                        const index = citasData.findIndex(c => c.cita_id == citaId);
                        if (index !== -1) {
                            citasData[index].estado = estado;
                            citasData[index].notas = notas;
                        }
                        
                        // Actualizar la vista
                        mostrarCitasFiltradas();
                        
                        // Mostrar mensaje de éxito
                        $('#successMessage').text('Cita actualizada correctamente').show();
                        setTimeout(() => { $('#successMessage').hide(); }, 3000);
                    } else {
                        $('#errorMessage').text('Error: ' + response.message).show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#errorMessage').text('Error en la conexión. Por favor, intenta nuevamente.').show();
                    console.error('Error en la solicitud:', error);
                }
            });
            */
        }
    </script>
    <script src="../js/panelMedicoScript.js"></script>
</body>

</html>