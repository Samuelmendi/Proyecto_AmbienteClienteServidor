$(function(){

    function sendRequest(action, nombre, apellido, telefono, correo, contrasena, tipo){
        fetch("app/controller/RegistroController.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({action, nombre, apellido, telefono, correo, contrasena, tipo})
        });
    }

    $("#RegistrarBtn").on("click", function(){
        let tipo = "";

        console.log("lol");
        if($("#RadioPaciente").is('checked')){
            console.log("paciente");
            tipo = $("#RadioPaciente").val();
            location.href = "Paciente.php";
        }else{
            console.log("medico");
            tipo = $("#RadioMedico").val();
            location.href = "Medico.php"
        }

    })



})