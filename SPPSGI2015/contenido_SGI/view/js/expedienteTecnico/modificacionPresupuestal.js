var guardadoNuevo;
var ban = true;
$(document).ready(function () {
    $("#buscarObrSol").click(function () {
        if ($('#noObra').val() != "") {
            buscarEnc();
        } else {
            $('#noObra').focus();
        }
    });

    $("#accordion").collapse({
        toggle: false
    });

    $('.enc').each(function () {
        $(this).attr('disabled', true);
    });

    $("#btnEnviarMP").on("click", function () {
        enviarExpediente();
    });

    $("#btnClonarSol").click(function () {
        bootbox.confirm("Se generar\u00e1 una nueva solicitud,  \u00BFcontinuar?", function (result) {
            if (result) {
                clonarSolicitud(function () {
                    verificaTipoSol();
                });
            }
        });
    });

    $('#noObra').autoNumeric({aSep: '', mDec: 0, vMin: '0'});
    $('.number').autoNumeric();

    $("#tipoSolicitud").unbind("change").on("change", function () {
        $("#encabezado").hide();
    });
});

function buscarEnc(callback) {
    var idObra = $('#noObra').val();
    var tipoSolicitud = $("#tipoSolicitud").val();
//    if(tipoSolicitud=="12"){
//        modulo="3.1";
//    }
    $.ajax({
        data: {'accion': 'getObraSolicitud', 'idObr': idObra, 'tipoSolicitud': tipoSolicitud},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            var rSolicitud = $.parseJSON(response);
            console.log(rSolicitud);
            if (rSolicitud != "false") {
                $('#nosolicitud').val(rSolicitud.psolicitud[0].IdSol);
                $('#encejercicio').val(rSolicitud.psolicitud[0].Ejercicio);
                $('#encur').val(rSolicitud.psolicitud[0].NomSec);
                $('#encue').val(rSolicitud.psolicitud[0].NomUE);
                $('#encmonto').val(rSolicitud.psolicitud[0].Monto).focusin().focusout();
                $('#encnoobra').val(rSolicitud.psolicitud[0].IdObr);
                $('#encnomobr').val(rSolicitud.psolicitud[0].NomObr);
                $('#encmodeje').val(rSolicitud.psolicitud[0].NomModEje);
                $('#enctipobr').val(rSolicitud.psolicitud[0].NomTipObr);
                datosGlobalesSolicitud.psolicitud = rSolicitud.psolicitud[0];
                if (rSolicitud.psolicitud[0].IdSolPre !== tipoSolicitud) {
                    $("#btnClonarSol").show();
                    $("#encabezado").show();
                    guardadoNuevo = false;
                } else {
                    $("#btnClonarSol").hide();
                    verificaTipoSol();
                }

            } else {
                bootbox.alert("<p>No se puede generar la solicitud seleccionada por alguno de los siguientes motivos: <br/><ul><li>La obra ingresada no existe.</li><li>La obra ingresada se encuentra actualmente en otra etapa.</li><li>No existe oficio correspondiente a la etapa inmediata anterior.</li><li>El oficio correspondiente a la etapa inmediata anterior no se ha firmado.</li></ul>");
            }
//            verificarEstadoSolicitud();
            if (typeof (callback) != "undefined") {
                callback();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function verificaTipoSol() {
    switch ($("#tipoSolicitud").val()) {
        case "2":
            $("#pagActiva").val(3);
            buscarExpediente(function () {
                console.log("datosGlobalesSolicitud-aqui");
                console.log(datosGlobalesSolicitud);
                $("#containerProceso").load("contenido_SGI/view/ExpedienteTecnico/solicitudAutorizacion.php", function () {
                    $('.ayuda').each(function () {
                        $(this).attr("data-toggle", "tooltip");
                        $(this).attr("data-placement", "right");
                        $(this).tooltip();
                    });
                    cargarConceptos(function () {
                        cargaInfContratosTrabajosCalen();
                        $("input,select,textarea,button").each(function () {
                            $(this).attr("disabled", false);
                        });
                    });
                    if (!guardadoNuevo) {
                        verificarEstadoMP();
                    }
                });
                $("#containerBotones").show();
                $("#encabezado").show();
            });

            break;
        case "12":
            $("#pagActiva").val(3);
            buscarExpediente(function () {
                $("#containerProceso").load("contenido_SGI/view/ExpedienteTecnico/solicitudAutorizacion.php", function () {
                    $('.ayuda').each(function () {
                        $(this).attr("data-toggle", "tooltip");
                        $(this).attr("data-placement", "right");
                        $(this).tooltip();
                    });
                    cargarConceptosAmpliacion(function () {
                        cargaInfContratosTrabajosCalen();
                        $("input,select,textarea,button").each(function () {
                            $(this).attr("disabled", false);
                        });
                    });

                    if (!guardadoNuevo) {
                        verificarEstadoMP();
                    } else {
                        if (datosGlobalesSolicitud.psolicitud.EvaSoc == "1") {
                            getDictamen();
                        }
                    }
                });
                $("#containerBotones").show();
                $("#encabezado").show();
            });

            break;
        case "7":
            var idObra = $('#noObra').val();
            $.ajax({
                data: {'accion': 'montosCancelar', 'idObra': idObra},
                url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
                type: 'post',
                success: function (response) {
                    var rSolicitud = $.parseJSON(response);
                    console.log(rSolicitud);
                    if (rSolicitud != "false") {
                        $("#containerProceso").load("contenido_SGI/view/ExpedienteTecnico/cancelacion.php", function () {
                            $('.ayuda').each(function () {
                                $(this).attr("data-toggle", "tooltip");
                                $(this).attr("data-placement", "right");
                                $(this).tooltip();
                            });
                            for (var i = 0; i < rSolicitud.montoFed.length; i++) {
                                $("input[name='ffed[]']:eq(" + i + ")").val(rSolicitud.montoFed[i].NomFte);
                                $("input[name='idfed[]']:eq(" + i + ")").val(rSolicitud.montoFed[i].idFte);
                                $("input[name='fedasig[]']:eq(" + i + ")").val(number_format(rSolicitud.montoFed[i].MontoAsignado, 2));
                                $("input[name='fedaut[]']:eq(" + i + ")").val(number_format(rSolicitud.montoFed[i].MontoAutorizado, 2));
                                $("input[name='fedcan[]']:eq(" + i + ")").val(number_format(rSolicitud.montoFed[i].Disponible, 2));
                                $("input[name='f[]']:eq(" + i + ")").val(number_format(rSolicitud.montoFed[i].Disponible, 2));
                                if (i !== (rSolicitud.montoFed.length - 1)) {
                                    if (typeof addfed == 'function') {
                                        addfed($("input[name='fedaut[]']:eq(" + i + ")").parent().parent().find("input:last"));
                                    }
                                }
                            }
                            for (var j = 0; j < rSolicitud.montoEst.length; j++) {
                                $("input[name='fest[]']:eq(" + j + ")").val(rSolicitud.montoEst[j].NomFte);
                                $("input[name='idest[]']:eq(" + j + ")").val(rSolicitud.montoEst[j].idFte);
                                $("input[name='estasig[]']:eq(" + j + ")").val(number_format(rSolicitud.montoEst[j].MontoAsignado, 2));
                                $("input[name='estaut[]']:eq(" + j + ")").val(number_format(rSolicitud.montoEst[j].MontoAutorizado, 2));
                                $("input[name='estcan[]']:eq(" + j + ")").val(number_format(rSolicitud.montoEst[j].Disponible, 2));
                                $("input[name='e[]']:eq(" + j + ")").val(number_format(rSolicitud.montoEst[j].Disponible, 2));
                                if (j !== (rSolicitud.montoEst.length - 1)) {
                                    if (typeof addfed == 'function') {
                                        addfed($("input[name='estaut[]']:eq(" + j + ")").parent().parent().find("input:last"));
                                    }
                                }
                            }
                            $("input[name='fedcan[]']:eq(" + i + ")").focus();
                            $("input[name='estcan[]']:eq(" + j + ")").focus();
                            $('.obligatorioCan').on("change", function () {
                                $(this).val(number_format($(this).val(), 2));
                            });
                        });
                        $("#containerBotones").show();
                        $("#encabezado").show();
                    } else {
                        bootbox.alert("No existe esa obra o la solicitud actual no corresponde al tipo de solicitud seleccionada");
                    }
                },
                error: function (response) {
                    console.log("Errores::", response);
                }
            });
            break;
        case "4":   //REDUCCIÓN
            $("#pagActiva").val(4);
            buscarExpediente(function () {
                $("#containerProceso").load("contenido_SGI/view/ExpedienteTecnico/solicitudReduccion.php", function () {
                    $('.ayuda').each(function () {
                        $(this).attr("data-toggle", "tooltip");
                        $(this).attr("data-placement", "right");
                        $(this).tooltip();
                    });
                    cargarConceptosReduccion(function () {
                        cargaCombosContratos(function () {
                            cargaContratosConveniosReduccion(datosGlobalesSolicitud.idsolicitud);
                        });
                    });
                    if (!guardadoNuevo) {
                        verificarEstadoMP();
                    } else {
                        if (datosGlobalesSolicitud.psolicitud.EvaSoc == "1") {
                            getDictamen();
                        }
                    }
                    $("#containerBotones").show();
                    $("#encabezado").show();
                });
            });
            break;
    }
}

function cambiaSpan() {
    if ($("#collapseOne").hasClass("in"))
        $("#spanVariable").html("(Mostrar)");
    else
        $("#spanVariable").html("(Ocultar)");
}

function cambiaHojaMP(hoja) {
    $("#pagActiva").val(hoja);
    if ($("#tipoSolicitud").val() === "4" && hoja === 3) { //SOLICITUD DE REDUCCION
        if (tablaConceptosReduccion.data().length == 0) {
            colocaWaitGeneral();
            cargarConceptosReduccion(function () {
                eliminaWaitGeneral();
            });
        }
    }
}

function getDictamen() {
    $.ajax({
        data: {'accion': 'getDictamen', 'idSol': datosGlobalesSolicitud.idsolicitud},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                dict = true;
            } else {
                dict = false;
                bootbox.alert("El estudio socioeconomico no ha sido dictaminado");
                $("#containerBotones").hide();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardarParcialMP() {
    switch ($("#tipoSolicitud").val()) {
        case "2": //AUTORIZACION$("#tipoSolicitud").val()
            actualizarIdUsu();
            if ($("#pagActiva").val() == 3) {
                if (ban) {
                    guardarHoja3();
                }
            }
            if ($("#pagActiva").val() == 4) {
//                setTimeout(function () {
                if (ban) {
                    var validacionHoja4 = validaContratos();
                    console.log(validacionHoja4);
                    if (validacionHoja4.correcto) {
                        guardadoHoja4(function () {
                            guardarHoja3();
                        });
                    } else {
                        //console.log(validacionHoja4);
                        if (validacionHoja4.error.mostrarMensaje) {
//                            console.log($('#rowContratos').position().top);
                            $("#tableHoja4_length_select").focus();
//                            $('#maincontent').animate({
//                                scrollTop: Math.abs($('#rowContratos').offset().top) - $('#framecontentTop').height()
//                            }, 2000);
                            $(".popError").popover("show");
                        }
                    }
                }
            }
            break;
        case "4"://REDUCCION
            actualizarIdUsu();
            if ($("#tipoSolicitud").val() === datosGlobalesSolicitud.tiposolicitud) {
                if ($("#pagActiva").val() === "4") {
                    guardadoHoja4(function () {
                        bootbox.alert("Datos guardados");
                    });
                }
                if ($("#pagActiva").val() === "3") {
                    bootbox.confirm("\u00BFDesea guardar? Los montos ya no podr\u00e1n ser modificados", function (result) {
                        if (result) {
                            guardarHoja3(function () {
                                bootbox.alert("Datos guardados");
                            });
                        }
                    });
                }
            } else {
                colocaMensajePop($("#btnClonarSol"), "Alerta", "El tipo de solicitud seleccionado no coincide con operaci\u00f3n actual");
            }
            break;
        case "12": //AMPLIACION - AUTORIZACION
            actualizarIdUsu();
//            alert(guardadoNuevo);
            if ($("#pagActiva").val() == 3) {
//                setTimeout(function () {
                if (ban) {
                    guardarHoja3();
                }

//                }, 2000);
            }
            if ($("#pagActiva").val() == 4) {
//                setTimeout(function () {
                if (ban) {
                    var validacionHoja4 = validaContratos();
                    if (validacionHoja4.correcto) {
                        guardadoHoja4(function () {
                            guardarHoja3();
                        });
                    } else {
                        //console.log(validacionHoja4);
                        if (validacionHoja4.error.mostrarMensaje) {
//                            console.log($('#rowContratos').position().top);
                            $('#maincontent').animate({
                                scrollTop: Math.abs($('#rowContratos').offset().top) - $('#framecontentTop').height()
                            }, 2000);
                            $(".popError").popover("show");
                        }
                    }
                }

//                }, 2000);
            }
            if (guardadoNuevo) {
//                alert("Se clonara la solicitud");
//                setTimeout(function () {
                clonarSolicitud(function () {
                    buscarEnc();
                });


//                }, 2000);
            }

            break;
        case "7":
            if ($("#formcan").find(".obligatorioCan:visible").valid()) {
                var cancelado = Array(), disponible = Array();
                var a = 0, b = 0, d = 0;
                $('.obligatorioCan').each(function () {
                    var canc = (($(this).val()).replace(/,/g, "")) * 1
                    cancelado[a] = canc;
                    a++;
                });
                $('.oculto').each(function () {
                    var monoc = (($(this).val()).replace(/,/g, "")) * 1
                    disponible[b] = monoc;
                    b++;
                });
                for (var j = 0; j < a; j++) {
                    if (cancelado[j] > disponible[j]) {
                        d = d + 1;
                    }
                }
                if (d === 0) {
                    clonarSolicitud(function () {
                        buscarEnc(function () {
                            cancelarMontos(function () {
                                actualizarIdUsu();
                            });
                        });
                    });
                } else {
                    bootbox.alert('El monto a cancelar no debe superar el disponible');
                }
            } else {
                $("#formcan").find("[aria-invalid='true']:first").focus().each(function () {
                    bootbox.alert('Favor de llenar los campos obligatorios');
                });
            }
            break;
    }
}

function actualizarIdUsu(callback) {
    var sol = datosGlobalesSolicitud.idsolicitud;
    $.ajax({
        data: {'accion': 'actualizarIdUsu', 'sol': sol},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "ok") {
//                console.log("Actualización de IdUsu correcta");
            } else {
//                console.log("error al actualizar IdUsu");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function cancelarMontos(callback) {
    $('#solicitud').val($('#nosolicitud').val());
    var valores = $("#formcan").serialize();
    $.ajax({
        data: valores,
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                bootbox.alert("Montos cancelados exitosamente");
            } else {
                bootbox.alert("Error al cancelar montos");
            }

            if (typeof (callback) != "undefined") {
                callback();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function clonarSolicitud(callback) {
    var idSol = $('#nosolicitud').val();
    var EvaSoc = datosGlobalesSolicitud.psolicitud.EvaSoc;
    var idTipo = $("#tipoSolicitud").val();
    var idObr = $("#noObra").val();
    $.ajax({
        data: {'accion': 'cloneSolicitud', 'idSol': idSol, 'EvaSoc': EvaSoc, 'idTipo': idTipo, 'idObr': idObr},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                $("#nosolicitud").val(response);
                colocaMensajePop($("#nosolicitud"), "Atenci\u00f3n", "Nueva solicitud");
                datosGlobalesSolicitud.idsolicitud = response;
                ban = true;
                $("#btnClonarSol").hide();
            } else {
                bootbox.alert("El Estudio Socioeconomico no ha sido aceptado");
                ban = false;
                return false;
            }
//            verificarEstadoSolicitud();
            if (typeof (callback) != "undefined") {
                callback();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function enviarExpediente() {
    bootbox.confirm('El Expediente T\u00e9cnico se enviar\u00e1 a la DGI, ' + String.fromCharCode(191) + 'Desea continuar?', function (result) {
        if (result) {
            var banderaSolicitudCorrecta = true; //bandera para verificar que todos los contratos tengan convenio de reduccion en caso de ser tipo reduccion
            var mensajeError = "";
            if (datosGlobalesSolicitud.tiposolicitud === "2" || datosGlobalesSolicitud.tiposolicitud === "12") {
                if (tablaContratosHoja4.column(0).data().length === 0) {
                    mensajeError = "No se puede enviar la solicitud, se debe registrar un contrato";
                    banderaSolicitudCorrecta = false;
                } else if (tablaConceptos.column(0).data().length === 0) {
                    mensajeError = "No se puede enviar la solicitud, se debe registrar un concepto";
                    banderaSolicitudCorrecta = false;
                } else {
                    for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
                        if (tablaContratosHoja4.cell(i, 0).data() === "" || tablaContratosHoja4.cell(i, 0).data() === "0") {
                            mensajeError = "No se puede enviar la solicitud, los contratos no han sido guardados";
                            banderaSolicitudCorrecta = false;
                        }
                    }
                    for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
                        if (tablaConceptos.cell(i, 0) === "" || tablaConceptos.cell(i, 0) === "0") {
                            mensajeError = "No se puede enviar la solicitud, los conceptos no se han guardado";
                            banderaSolicitudCorrecta = false;
                        }
                    }
                    for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
                        if (tablaConceptos.cell(i, 10) === "" || tablaConceptos.cell(i, 10) === "0") {
                            mensajeError = "No se puede enviar la solicitud, todos los conceptos deben estar ligados a un contrato";
                            banderaSolicitudCorrecta = false;
                        }
                    }
                }
            }
            if (datosGlobalesSolicitud.tiposolicitud === "4") {
                for (var i = 0; i < tablaContratosReduccion.column(0).data().length; i++) {
                    if (tablaContratosReduccion.cell(i, 24).data() === "0") {
                        mensajeError = "No se puede enviar la solicitud, se debe registrar un convenio de reducci\u00f3n por cada contrato";
                        banderaSolicitudCorrecta = false;
                    }
                }
            }
            if (!banderaSolicitudCorrecta) {
                bootbox.alert(mensajeError);
            } else {
//            console.log("se envio");
                $.ajax({
                    data: {idSol: datosGlobalesSolicitud.idsolicitud, accion: "cabiarEstatusET", estado: 3, tipoSolicitud: datosGlobalesSolicitud.tiposolicitud},
                    url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
                    type: 'post',
                    success: function (response) {
                        if (response == "ok") {

                            sendNotification(datosGlobalesSolicitud.idsolicitud, $("#idUsuarioSession").val(),
                                    3, "", $("#idRolUsuarioSession").val(), "", "", "");
                            var montoFed = 0.00;
                            var montoEst = 0.00;
                            var montoContratos = 0.00;
                            var inputContratos = "";
                            $('#idsolCaratula').val($("#nosolicitud").val());
                            $('#ejercicioCaratula').val($("#encejercicio").val());
                            $('#nomobraCaratula').val($("#encnomobr").val());

                            for (var i = 0; i < tablaContratosHoja4.rows().data().length; i++) {
                                inputContratos += "<input type='hidden' name='numContrato[]' value='" + tablaContratosHoja4.cell(i, 1).data() + "'/>";
                                inputContratos += "<input type='hidden' class='number' name='montoContrato[]' value='" + tablaContratosHoja4.cell(i, 9).data() + "'/>";
                                montoContratos = parseFloat(montoContratos) + parseFloat(tablaContratosHoja4.cell(i, 9).data());
                            }

                            $('#montototalCaratula').val(montoContratos).focusin().focusout();

                            $('#ueCaratula').val($("#encue").val());
                            $('#tiposolCaratula').val($("#tipoSolicitud option:selected").text());

                            $("#imprime3").append(inputContratos);
                            $("#imprime3").find('.number').each(function () {
                                $(this).focusin().focusout();
                            });
                            $("#imprime3").submit();

                            bootbox.alert("El expediente t\u00e9cnico se envi\u00f3 correctamente", function () {
                                location.reload();
                            });

                        }
                    }
                });
            }
        }
    });
}

function verificarEstadoMP() {
    console.log(datosGlobalesSolicitud);
    $("#encabezado").find("input").attr("disabled", true);
    if ($("#tipoSolicitud").val() !== "4") { // DIFERENTE DE REDUCCION
        tablaConceptos.column(11).visible(false);
        tablaConceptos.column(12).visible(false);

        switch (datosGlobalesSolicitud.psolicitud.IdEdoSol) {
            case '2':
                $("#containerBotones").show();
                tablaConceptos.column(11).visible(true);
                tablaConceptos.column(12).visible(true);
                return true;
                break;
            case '3':
                bootbox.alert("La solicitud ya ha sido enviada a la DGI");
                $("#cargaExterna").hide();
                $("#containerBotones").hide();
                $("#abreModal").hide();
                $("#addContratoHoja4").hide();
                $("#btnAddConcepto").hide();
                for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
                    tablaContratosHoja4.cell(i, 17).data('<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>');
                }
                tablaContratosHoja4.draw();
                tablaConceptosContratoHoja4.column(4).visible(false);
                tablaConceptosContratoHoja4.draw();
                $("#rowGarantia").find("input").attr("disabled", true);
                $("#tabla2").find("input").attr("disabled", true);
                $("#rowAnticipo").find("input,textarea").attr("disabled", true);
                tablaHoja4.column(15).visible(false);
                tablaHoja4.draw();
                return false;
                break;
            case '4':
                bootbox.alert("La solicitud ya ha sido enviada a la DGI");
                $("#cargaExterna").hide();
                $("#containerBotones").hide();
                $("#abreModal").hide();
                $("#addContratoHoja4").hide();
                $("#btnAddConcepto").hide();
                for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
                    tablaContratosHoja4.cell(i, 17).data('<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>');
                }
                tablaContratosHoja4.draw();
                tablaConceptosContratoHoja4.column(4).visible(false);
                tablaConceptosContratoHoja4.draw();
                $("#rowGarantia").find("input").attr("disabled", true);
                $("#tabla2").find("input").attr("disabled", true);
                $("#rowAnticipo").find("input,textarea").attr("disabled", true);
                tablaHoja4.column(15).visible(false);
                tablaHoja4.draw();
                return false;
                break;
            case '5':
                $("#containerBotones").show();
                tablaConceptos.column(11).visible(true);
                tablaConceptos.column(12).visible(true);
                return true;
                break;
            case '6':
                bootbox.alert("La solicitud ya ha sido aceptada");
                $("#cargaExterna").hide();
                $("#containerBotones").hide();
                $("#abreModal").hide();
                $("#addContratoHoja4").hide();
                $("#btnAddConcepto").hide();
                for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
                    tablaContratosHoja4.cell(i, 17).data('<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>');
                }
                tablaContratosHoja4.draw();
                tablaConceptosContratoHoja4.column(4).visible(false);
                tablaConceptosContratoHoja4.draw();
                $("#rowGarantia").find("input").attr("disabled", true);
                $("#tabla2").find("input").attr("disabled", true);
                $("#rowAnticipo").find("input,textarea").attr("disabled", true);
                tablaHoja4.column(15).visible(false);
                tablaHoja4.draw();
                return false;
                break;
            default:
                bootbox.alert("Solicitud no v\u00e1lida");
                $("#containerBotones").hide();
                $("#abreModal").hide();
                $("#addContratoHoja4").hide();
                $("#btnAddConcepto").hide();
                return false;
                break;
        }
    } else {
        switch (datosGlobalesSolicitud.psolicitud.IdEdoSol) {
            case "2":
            case "5":
                $("#addConvenioReduccion").show();
                $("#containerBotones").show();
                break;
            case "3":
            case "4":
                bootbox.alert("La solicitud ya ha sido enviada a la DGI");
                $("#addConvenioReduccion").hide();
                $("#containerBotones").hide();
                break;
            case "6":
                bootbox.alert("La solicitud ya ha sido aceptada");
                $("#addConvenioReduccion").hide();
                $("#containerBotones").hide();
                break;
            default:
                $("#addConvenioReduccion").hide();
                $("#containerBotones").hide();
                break;
        }
    }
}

function addfed(elemento) {
    $newClone = $(elemento).parent().parent().parent().clone(true);
    $newClone.find("input").val("");
    $newClone.find("input:last").val("");
    $(elemento).parent().parent().parent().after($newClone);
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

jQuery.validator.addClassRules("obligatorioCan", {
    required: true
});

jQuery.extend(jQuery.validator.messages, {
    required: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Monto requerido</div>'
});

function justNumbers(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
        return true;
    return /\d/.test(String.fromCharCode(keynum));
}
