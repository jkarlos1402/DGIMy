$(document).ready(function () {
    $("#idobsol").change(function () {
        definirReingreso()
    });
});

function definirReingreso() {
    if ($("#idobsol").val() == "5") {
        $("#rIngreso").show();
    } else {
        $("#rIngreso").hide();
        $("#reingreso").attr("checked", false);
    }
}

function guardarObservaciones() {
    var idsol = datosGlobalesSolicitud.idsolicitud;
    var tipoSolicitud = datosGlobalesSolicitud.tiposolicitud;
    var estatus = $("#idobsol").val();
    if (estatus == 6) {
        guardaMontos();
    }
    var obs = $("#obset").val();
    var reingreso = 0;
    if ($("#reingreso").is(":checked")) {
        reingreso = 1;
    }
    if (validarObservaciones()) {
        $.ajax({
            type: "POST",
            url: "contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php",
            data: {accion: "guardarObservaciones", idSol: idsol, estado: estatus, obs: obs, reingreso: reingreso, tipoSolicitud: tipoSolicitud},
            success: function (response) {
                if (response == "ok") {
//                    bootbox.alert("Expediente analizado correctamente");
                    eliminaWaitGeneral();
                    sendNotification(idsol, $("#idUsuarioSession").val(),
                            estatus, "", $("#idRolUsuarioSession").val(), "", "", "");// notificacion
                    bootbox.alert("Expediente analizado correctamente", function () {
                        location.reload();
                    });                    
                }
            },
            error: function (response) {
                eliminaWaitGeneral();
                console.log("Errores::", response);
            }
        });
    }
}

function validarObservaciones() {
    if (($("#idobsol").val() == "5" && $("#obset").val() != "") || $("#idobsol").val() == "6") {
        return true;
    } else {
        eliminaWaitGeneral();
        bootbox.alert("Para devolver el expediente por favor ingrese los comentarios");
        return false;
    }
}

function guardaMontos() {
    var tiposolicitud = datosGlobalesSolicitud.tiposolicitud;
    var idsol = datosGlobalesSolicitud.idsolicitud;
    $("#accion").val("guardarMontos");

    if (tiposolicitud == "3" || tiposolicitud == "9") {
        $("#montoInv").val(datosGlobalesSolicitud.montoTotalInv);
    } else {
        $("#montoInv").val(datosGlobalesSolicitud.totalConceptos);
    }

    var valores = $("#formGral").serialize();

    if (validarObservaciones()) {
        $.ajax({
            type: "POST",
            url: "contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php",
            data: valores,
            success: function (response) {
                var rSolicitud = $.parseJSON(response);
                if (rSolicitud == idsol) {
                    console.log("Ok::", response);
                }
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }
}