$(function(){
    
    function sendRequest(action, nombre, apellido, telefono, correo, contrasena, tipo){
        fetch("app/controller/RegistroController.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({action, nombre, apellido, telefono, correo, contrasena, tipo})
        });
    }

    

    $("#RegistroPacienteBtn").on("click", function(){
        console.log($("#RegistroCorreo").val())

    })



})