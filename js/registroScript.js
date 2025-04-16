$(function(){

    function sendRequest(action, nombre, apellido, telefono, correo, contrasena, tipo){
        
        fetch("../app/controller/RegistroController.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({action, nombre, apellido, telefono, correo, contrasena, tipo})
        });

    }

    function sendCorreo(correo){
        fetch("../Login-registro/Paciente.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({correo})
        });
    }

    function redirect(tipo){

        if(tipo == "paciente"){
            location.href = "Paciente.php";
        }else if (tipo == "medico"){
            location.href = "Medico.php"
        }

    }

    $("#RegistrarBtn").on("click", function(){
        let $tipo = "";
        let $nombre = $("#registroNombre").val();
        let $apellido = $("#registroApellido").val();
        let $telefono = $("#registroTelefono").val();
        let $correo = $("#RegistroCorreo").val();
        let $contrasena = $("#RegistroContraseña").val();
        
        if($("#RadioPaciente").is(':checked')){
            $tipo = $("#RadioPaciente").val();
        }else{
            $tipo = $("#RadioMedico").val();
        }

        //sendRequest("add", $nombre, $apellido, $telefono, $correo, $contrasena, $tipo);
        
        sendCorreo($correo);

        
           
   

    })



})