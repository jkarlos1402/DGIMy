/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {


    $("#enviarET").click(function () {
        enviarExpediente();
    });

    $("#imprimirET").click(function () {
        if($("#enviarET:visible").length==1){
            $("#marcaAgua").val("1");
        }else{
            $("#marcaAgua").val("0");
        }
       
        var montoFed =0.00;
        var montoEst =0.00;
        $('#idsolCaratula').val($("#idsol").val());
        $('#ejercicioCaratula').val($("#ejercicio").val());
        $('#nomobraCaratula').val($("#nomobra").val());
        $('#montototalCaratula').val($("#montin").val());
        $(".monfed").each(function(){
            montoFed = parseFloat(montoFed) + parseFloat($(this).val().replace(/,/g, ""));
        });
        $(".monest").each(function(){
            montoEst = parseFloat(montoEst) + parseFloat($(this).val().replace(/,/g, ""));
        });
        
        $('#montofedCaratula').val(montoFed).focusin().focusout();
        $('#montoestCaratula').val(montoEst).focusin().focusout();
        $('#montomunCaratula').val($("#mu").val());
        $('#ueCaratula').val($("#ue3").val());
        $('#tiposolCaratula').val($("#solpre option:selected").text());
        
        $("#imprime2").submit();
        //$('#fechaingCaratula').val($("#fechainghei").val());



    });


});

function guardarHoja7() {
    var cs = $("#criterios").val();
    var dn = $("#depnorm").val();
    var idsol = $("#idsol").val();

    var datosH7 = {
        criterios: cs,
        depnorm: dn,
        idsol: idsol,
        accion: 'guardaHoja7'
    };

    $.ajax({
        data: datosH7,
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var dh1 = $.parseJSON(response);
            datosGlobalesSolicitud.idsolicitud = $('#idsol').val();
            datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
//            datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
            eliminaWaitGeneral();
            bootbox.alert('Datos guardados correctamente');
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function enviarExpediente() {
    console.log(datosGlobalesSolicitud.psolicitud);
    var idEstatus = "";
    bootbox.confirm('El Expediente T\u00e9cnico se enviar\u00e1 a la DGI, ' + String.fromCharCode(191) + 'Desea continuar?', function (result) {
        if (result) {
            var banderaSolicitudCorrecta = true; //bandera para verificar que todos los contratos tengan convenio de reduccion en caso de ser tipo reduccion
            var mensajeError = "";
            if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9" || datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
                if (tablaConceptos.column(0).data().length === 0) {
                    mensajeError = "No se puede enviar la solicitud, se debe registrar un concepto";
                    banderaSolicitudCorrecta = false;
                } else {
                    for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
                        if (tablaConceptos.cell(i, 0) === "" || tablaConceptos.cell(i, 0) === "0") {
                            mensajeError = "No se puede enviar la solicitud, los conceptos no se han guardado";
                            banderaSolicitudCorrecta = false;
                        }
                    }
                    if (datosGlobalesSolicitud.tiposolicitud !== "10" && datosGlobalesSolicitud.tiposolicitud !== "11" && datosGlobalesSolicitud.tiposolicitud !== "13") {
                        if (tablaHoja4.column(0).data().length === 0) {
                            mensajeError = "No se puede enviar la solicitud, registre un avance f\u00edsico";
                            banderaSolicitudCorrecta = false;
                        } else {
                            for (var i = 0; i < tablaHoja4.column(0).data().length; i++) {
                                if (tablaHoja4.cell(i, 0) === "" || tablaConceptos.cell(i, 0) === "0") {
                                    mensajeError = "No se puede enviar la solicitud, los avances f\u00edsicos no se han guardado";
                                    banderaSolicitudCorrecta = false;
                                }
                            }
                            var registroAvanceFinan = false;
                            for (var i = 0; i < 12; i++) {
                                if (datosGlobalesSolicitud.avancesFinancieros[i] !== "0.00" || datosGlobalesSolicitud.avancesFinancieros[i] !== "0" || datosGlobalesSolicitud.avancesFinancieros[i] !== "") {
                                    registroAvanceFinan = true;
                                }
                            }
                            if (!registroAvanceFinan) {
                                mensajeError = "No se puede enviar la solicitud, el avance financiero no se ha registrado";
                                banderaSolicitudCorrecta = false;
                            }
                        }
                    } else {//administracion
                        for (var i = 0; i < tablaHoja4Admin.column(0).data().length; i++) {
                            if (tablaHoja4Admin.cell(i, 0) === "" || tablaConceptos.cell(i, 0) === "0") {
                                mensajeError = "No se puede enviar la solicitud, los avances f\u00edsicos no se han guardado";
                                banderaSolicitudCorrecta = false;
                            }
                        }
                        if (tablaHoja4Admin.column(0).data().length === 0) {
                            mensajeError = "No se puede enviar la solicitud, los avances f\u00edsicos no se han guardado";
                            banderaSolicitudCorrecta = false;
                        }
                        var registroAvanceFinan = false;
                        for (var i = 0; i < 12; i++) {
                            if (datosGlobalesSolicitud.avancesFinancieros[0][i] !== "0.00" && datosGlobalesSolicitud.avancesFinancieros[0][i] !== "0" && datosGlobalesSolicitud.avancesFinancieros[0][i] !== "") {
                                registroAvanceFinan = true;
                            }
                        }
                        if (!registroAvanceFinan) {
                            mensajeError = "No se puede enviar la solicitud, el avance financiero no se ha registrado";
                            banderaSolicitudCorrecta = false;
                        }
                    }
                }
            }
            if (!banderaSolicitudCorrecta) {
                bootbox.alert(mensajeError);
            } else {
                if (datosGlobalesSolicitud.psolicitud.Reingreso == "1" || datosGlobalesSolicitud.psolicitud.Reingreso == null) {
                    idEstatus = 3;
                } else {
                    idEstatus = 4;
                }
                $.ajax({
                    data: {idSol: datosGlobalesSolicitud.idsolicitud, accion: "cabiarEstatusET", estado: idEstatus},
                    url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
                    type: 'post',
                    success: function (response) {
                        if (response == "ok") {
//                            bootbox.alert("El expediente t\u00e9cnico se env\u00f3 correctamente");
                            bootbox.alert("El expediente t\u00e9cnico se envi\u00f3 correctamente", function () {

                            });
                            sendNotification(datosGlobalesSolicitud.idsolicitud, $("#idUsuarioSession").val(),
                                    idEstatus, "", $("#idRolUsuarioSession").val(), "", "","");
                            if (idEstatus == 3) {
                            }
                        }
                    },
                    error: function (response) {
                        console.log("Errores::", response);
                    }
                });
                $("#enviarET,#btnGuardarParcial").hide();
                
            }
        }
    });
}

