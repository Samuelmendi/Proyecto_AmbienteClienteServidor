$(function(){
    
    function sendRequest(action, usuarioId, especialidad, licencia, Exp, horaInicio, horaFinal, DiasHabiles){
        fetch("../app/controller/RegistroController.php", {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({action, usuarioId, especialidad, licencia, Exp, horaInicio, horaFinal, DiasHabiles})
        });
    }

    function redirect() {

        location.href = "../index.php"

    }

    $("#RegistroPacienteBtn").on("click", function(){
        let $correo = $("#MedicoCorreo").val();
        let $especialidad = $("#RegistroEspecialidad").val();
        let $licencia = $("#RegistroLicencia").val();
        let $Exp = $("#anosExp").val();
        let $horaInicio = $("#horaInicio").val();
        let $horaFinal = $("#horaFin").val();
        let $DiasHabiles = $("#RegistroDiasHabiles").val();

        sendRequest("medico", $correo, $especialidad, $licencia, $Exp, $horaInicio, $horaFinal, $DiasHabiles);

        //setTimeout(function(){redirect()}, 200);
    })



})