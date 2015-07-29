var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var tipoSol = 0;
$(document).ready(function () {

    $("#btnFirma").hide();
    $("#btnAceptar").hide();
    $("#btnCancelar").hide();

    $("#limpiar").click(function () {
        location.reload();
    });

    $("#fechaFirma").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#btnFirma").click(function () {
        bootbox.confirm("\u00BFDesea firmar el oficio?", function (resp) {
            if (resp) {
                if ($("#cveOfi").val() == "") {
                    bootbox.alert('Ingresa una clave de oficio');
                    return false;
                }

                if ($("#fechaFirma").val() == "") {
                    bootbox.alert('Ingresa una fecha valida');
                    return false;
                }

                $.ajax({
                    data: {
                        accion: 'guardarFechaFirma',
                        fechaFirma: $("#fechaFirma").val(),
                        cveOfi: $("#cveOfi").val()
                    },
                    url: 'contenido_sgi/controller/oficios/oficiosController.php',
                    type: 'post',
                    beforeSend: function () {
                        //para seguir el debug
                        console.log('Evento:: guardar fecha firma');
                    },
                    success: function (response) {
                        var info = jQuery.parseJSON(response);

                        if (info.result) {

                            $("#mostrarOficio").click();
                            guardarActualizacionOficio($("#btnAceptar"));
                        }
                        else {
                            bootbox.alert('Ocurrio un error al guardar a fecha de firma, por favor intentelo nuevamente');
                        }
                    }
                });
            }
        });
    });

    $(".btnAccion").click(function () {
        var elemento = $(this);
        bootbox.confirm("\u00BFDesea actualizar el oficio?", function (resp) {
            if (resp) {
                guardarActualizacionOficio(elemento);
            }
        });
    });


    $("#mostrarOficio").click(function () {
        $.ajax({
            data: {
                accion: 'obtenerInfoOfi',
                cveOfi: $("#cveOfi").val()
            },
            url: 'contenido_sgi/controller/oficios/oficiosController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Obtener info Oficio');
            },
            success: function (response) {
                var info = jQuery.parseJSON(response);
                console.log(info);
                if (info.result) {
                    $("#tipOfi").html(info.info[0].NomSolPre);
                    $("#ejercicio").html(info.info[0][8]);
                    $("#status").html(info.info[0].NomEdoOfi);
                    $("#idObra").html(info.info[0].idObr);
                    $("#nombreObra").html(info.info[0].NomObr);
                    $("#statusId option[value=" + info.info[0].idEdoOFi + "]").attr("selected", true);
                    tipoSol = info.info[0].tipoSol;

                    var cambioFecha = info.info[0].FecOfi.split('-');
                    $("#fecOfi").html(cambioFecha[2] + '-' + cambioFecha[1] + '-' + cambioFecha[0]);

                    var fechFir = info.info[0].FecFir;
                    if (fechFir) {
                        var cambFech = fechFir.split('-');
                        fechFir = cambFech[2] + '-' + cambFech[1] + '-' + cambFech[0];
                        $("#btnFirma").css('display', 'none');
                    }
                    else {
                        if (info.info[0].idEdoOFi == 3) {
                            $("#btnFirma").css('display', 'block');
                        }
                        else {
                            $("#btnFirma").css('display', 'none');
                        }
                    }

                    $("#fecFir").html(fechFir);                    
                    if (info.cancelable && info.info[0].idEdoOFi !== "2") {
                        $("#btnCancelar").show();
                    }
                    else {
                        $("#btnCancelar").hide();
                    }
                }
                else {
                    bootbox.alert('No existe informacion para este oficio');
                    return false;
                }
            }
        });
    });

});

function guardarActualizacionOficio(elem) {
    console.log(elem);
    if ($("#cveOfi").val() == "") {
        bootbox.alert('Ingresa una clave de oficio');
        return false;
    }
    var edoOfi = 3;
    if ($(elem).attr('id') == "btnAceptar") {
        edoOfi = 1;
    }
    else if ($(elem).attr('id') == "btnCancelar") {
        edoOfi = 2;
        $(elem).hide();
    }

    $.ajax({
        data: {
            accion: 'guardarStatus',
            idEdoOfi: edoOfi,
            cveOfi: $("#cveOfi").val(),
            tipoSol: tipoSol
        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: guardar estatus');
        },
        success: function (response) {
            console.log(response);

            var info = jQuery.parseJSON(response);

            if (info.result) {
                $("#mostrarOficio").click();
            }
            else {
                bootbox.alert('Ocurrio un error al cambiar el estatus del oficio, por favor intentelo nuevamente');
            }
        }
    });
}