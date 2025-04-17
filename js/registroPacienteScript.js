$(function(){
    
    function sendRequest(action, usuarioId, direccion, seguro, fechaNacimiento, genero){
        fetch("../app/controller/RegistroController.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({action, usuarioId, fechaNacimiento, genero, direccion, seguro})
        });
    }

    function redirect() {

        location.href = "../index.php"

    }

    $("#RegistroPacienteBtn").on("click", function(){
        let $correo = $("#PacienteCorreo").val();
        let $direccion = $("#RegistroDireccion").val();
        let $genero = $("#genero").val();
        let $seguro = $("#RegistroSeguro").val();
        let $fechaNacimiento = $("#birthday").val();

        console.log($fechaNacimiento);

        sendRequest("paciente", $correo, $direccion, $seguro, $fechaNacimiento, $genero);

        setTimeout(function(){redirect()}, 200);
    })



})