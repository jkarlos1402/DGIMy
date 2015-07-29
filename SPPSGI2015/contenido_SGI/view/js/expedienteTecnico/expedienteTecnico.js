var datosGlobalesSolicitud = {
    psolicitud: "",
    contratos: "",
    prgsolicitud: "",
    presolicitud: "",
    munsolicitud: "",
    acusolicitud: "",
    avancesFisicos: "",
    avancesFinancieros: "",
    idsolicitud: "",
    tiposolicitud: "",
    fuentes: "",
    monto: "",
    totalConceptos: "",
    impresionvalida: "",
    idContratoReduccion: "",
    montoTotalInv: "",
    conceptosReduccion: "",
    evaSoc: ""
};
var imagen = "";
var tabs = 0;
var ro = false; //Variable que se utiliza en hoja 3
var modulo;
$(document).ready(function () {
//Funcion de los botones generales
    $("#containerBotones").hover(function () {
        $(this).fadeTo("fast", 1);
    }, function () {
        $(this).fadeTo("fast", 0.4);
    });
    $("#btnAtras").click(function () {
        cambiarHoja(1);
    });
    $("#btnSiguiente").click(function () {
        cambiarHoja(2);
    });
// Funcion regargar ventana
    $(".reestablecer,#btnRefresh").click(function () {
        location.reload();
    });
//  Verificamos en que modulo se llama el js
    modulo = $("#modulo").val();

// Funcion para guardar
    $("#guardar").click(function () {
        guardarExpediente();
        if ($("#pagSiguiente").val() === "4") {
            guardado2(1);
        }
    });

    // Funcion para guardado parcial sobre la hoja actual     
    $("#btnGuardarParcial").click(function () {
        switch ($("#pagSiguiente").val()) {
            case "1":
                switch ($("#solpre").val()) {
                    case "1":
                        colocaWaitGeneral();
                        $("#accion").val("guardaHoja1");
                        guardarHoja1();
                        break;
                    case "3":
                        colocaWaitGeneral();
                        if ($("#flujo").val() == 3 && datosGlobalesSolicitud.tiposolicitud !== $("#solpre").val()) {
                            $("#accion").val("guardaFuentes");
                            guardarAmAs();
                        } else {
                            $("#accion").val("guardaFuentes");
                            guardarfuentes();
                        }
                        break;
                    case "8":
//                        colocaWaitGeneral();
//                        if ($("#flujo").val() == 8) {
//                            $("#accion").val("guardaFuentes");
//                            guardarAmAs();
//                        } else {
//                            $("#accion").val("guardaHoja1");
//                            guardarHoja1();
//                        }
                        break;
                    case "10": //se tiene que revisar guardado de montos
                        colocaWaitGeneral();
                        $("#accion").val("guardaHoja1");
                        guardarHoja1();
                        break;
                    case "13": //se tiene que revisar guardado de montos
                        colocaWaitGeneral();
                        if ($("#flujo").val() == 13 && datosGlobalesSolicitud.tiposolicitud !== $("#solpre").val()) {
                            $("#accion").val("guardaFuentes");
                            guardarAmAs();
                        } else {
                            $("#accion").val("guardaFuentes");
                            guardarfuentes();
                        }
                        break;
                    case "9": //se tiene que revisar guardado de montos
                    case "11": //se tiene que revisar guardado de montos
                        colocaWaitGeneral();
                        if ($("#flujo").val() == 9) {
                            $("#accion").val("guardaAsigAdic");
                            guardaAsigAdic();
                        } else {
                            $("#accion").val("guardaHoja1");
                            guardarHoja1();
                        }
                        break;
                }
                break;
            case "2":
                switch ($("#solpre").val()) {
                    case "1":
                    case "9":
                    case "11":
                        colocaWaitGeneral();
                        $("#accion").val("guardaHoja2");
                        guardarHoja2();
                        break;
                    case "3":
                        colocaWaitGeneral();
                        if ($("#flujo").val() == 3) {
                            bootbox.alert('Datos guardados correctamente');
                        } else {
                            $("#accion").val("guardaHoja2");
                            guardarHoja2();
                        }
                        break;
                    case "8":
                        colocaWaitGeneral();
                        $("#accion").val("guardaHoja2");
                        guardarHoja2();
                        break;
                    case "10":
                        colocaWaitGeneral();
                        $("#accion").val("guardaHoja2");
                        guardarHoja2();
                        break;
                }
                break;
            case "3":
                colocaWaitGeneral();
                guardarHoja3();
                break;
            case "4":
                colocaWaitGeneral();
                console.log("guardado de hoja 4");
                guardadoHoja4(function () {
                    eliminaWaitGeneral();
                    bootbox.alert("Datos guardados correctamente");
                });
                break;
            case "5":
                colocaWaitGeneral();
                guardarHoja5();
                break;
            case "6":
                colocaWaitGeneral();
                guardarHoja7();
                break;
            case "8":
                bootbox.confirm("\u00BFTerminar evaluaci&oacute;n?", function (result) {
                    if (result) {
                        colocaWaitGeneral();
                        guardarObservaciones();
                    }
                });
                break;
        }
//        eliminaMensajePop($("#btnGuardarParcial"));
    });

    $("#mostraredit").click(function () {
        if ($('#nosolicitud').val() != "") {
            colocaWaitGeneral();
            buscarExpediente(function () {
                eliminaWaitGeneral();
            });
        } else {
            $('#nosolicitud').focus();
        }
    });

    $("#myTab").find("li").each(function () {
        tabs++;
    });

    $("#pagSiguiente").val("1");
    if ($("#idRolUsuarioSession").val() === "3") {
        $("#btnGuardarParcial").hide();
        $("#myTab").hide();
        $("#formGral").hide();
        $("#containerBotones").hide();
    }
    if ($('#nosolicitud').length !== 0) {
        $('#nosolicitud').autoNumeric({aSep: '', mDec: 0, vMin: '0'});
    }
    $('.ayuda').each(function () {
        $(this).attr("data-toggle", "tooltip");
        $(this).attr("data-placement", "right");
        $(this).tooltip();
    });
});

function cambiarHoja(param) {
    eliminaMensajePop($("#btnGuardarParcial"));
    if (param == 1) { // ATRAS
        $(".tab-content").find(".active").each(function () {
            switch ($(this).attr("id")) {
                case "h2":
                    $("#pagSiguiente").val(1);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(0) a").tab("show");
                    break;
                case "h3":
                    eliminaMensajePop($("#btnGuardarParcial"));
                    $("#pagSiguiente").val(2);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(1) a").tab("show");
                    if (datosGlobalesSolicitud.psolicitud.LatIni !== "0") {
                        google.maps.event.trigger(map, "resize");
                    }
                    break;
                case "h4":
                    $("#pagSiguiente").val(3);
                    datosGlobalesSolicitud.contratos = "";
                    //cargarConceptos();
                    $("#myTab li:eq(2) a").tab("show");
                    break;
                case "h5":
                    $("#pagSiguiente").val(4);
                    cargaInfContratosTrabajosCalen();
                    $("#myTab li:eq(3) a").tab("show");
                    break;
                case "h6":
                    $("#pagSiguiente").val(5);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(4) a").tab("show");
                    break;
                case "h7":
                    $("#pagSiguiente").val(6);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(5) a").tab("show");
                    break;
                case "h8":
                    if ($(this).attr("id") === "h8") {
                        $("#pagSiguiente").val(6);
                        $("#myTab li:eq(5) a").tab("show");
                    } else {
                        $("#pagSiguiente").val(7);
                        $("#myTab li:eq(6) a").tab("show");
                    }
                    datosGlobalesSolicitud.contratos = "";
                    $("#btnGuardarParcial").hide();
                    break;
            }
        });
    } else {          // SIGUIENTE
        $(".tab-content").find(".active").each(function () {
            switch ($(this).attr("id")) {
                case "h1":
                    if (datosGlobalesSolicitud.psolicitud === "") {
                        $("#myTab li:eq(0) a").tab("show");
                        colocaMensajePop($("#btnGuardarParcial"), "Alerta", "Se debe guardar antes de continuar...");
                    } else {
                        if (datosGlobalesSolicitud.tiposolicitud !== $("#solpre").val() && !($("#myTab li:last a").text() === "Observaciones")) {
                            $("#myTab li:eq(0) a").tab("show");
                        } else {
                            $("#pagSiguiente").val(2);
                            datosGlobalesSolicitud.contratos = "";
                            $("#myTab li:eq(1) a").tab("show");
                            if (datosGlobalesSolicitud.psolicitud.LatIni != "0") {
                                google.maps.event.trigger(map, "resize");
                            }
                        }
                    }
                    break
                case "h2":
                    $("#pagSiguiente").val(3);
                    cargarConceptos();
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(2) a").tab("show");
                    break;
                case "h3":
                    if (!error && guardado) { //Si no hay error en montos y si ya se guardo la hoja
                        eliminaMensajePop($("#btnGuardarParcial"));
                        $("#pagSiguiente").val(4);
                        cargaInfContratosTrabajosCalen();// carga los datos en hoja cuatro, la funcion esta declarada en hojacuatro.js
                        $("#myTab li:eq(3) a").tab("show");
                    } else {
                        colocaMensajePop($("#btnGuardarParcial"), "Aviso", "No se han capturado conceptos");
                    }
                    break;
                case "h4":
                    $("#pagSiguiente").val(5);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(4) a").tab("show");
                    break;
                case "h5":
                    $("#pagSiguiente").val(6);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(5) a").tab("show");
                    break;
                case "h6":
                    if ($("#idRolUsuarioSession").val() === "3") {
                        $("#pagSiguiente").val(8);
                        $("#myTab li:eq(6) a").tab("show");
                        if (!$("#idobsol").attr("readonly")) {
                            $("#btnGuardarParcial").show();
                        }
                    }
                    datosGlobalesSolicitud.contratos = "";
                    break;
                case "h7":
                    $("#pagSiguiente").val(8);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(7) a").tab("show");
                    break;
            }
        });
    }
    if (tabs == 7) {
        if ($("#pagSiguiente").val() == 1) {
            $("#btnAtras").hide();
            $("#btnSiguiente").show();
        } else if ($("#pagSiguiente").val() == 7) {
            $("#btnAtras").show();
            $("#btnSiguiente").hide();
        } else {
            $("#btnAtras").show();
            $("#btnSiguiente").show();
        }
    } else {
        if ($("#pagSiguiente").val() == 1) {
            $("#btnAtras").hide();
            $("#btnSiguiente").show();
        } else if ($("#pagSiguiente").val() == 9) {
            $("#btnAtras").show();
            $("#btnSiguiente").hide();
        } else {
            $("#btnAtras").show();
            $("#btnSiguiente").show();
        }
    }
}

function guardarExpediente() {
    var formualrioGeneral = $("#formGral").serialize();
    $.post("contenido_sgi/vistas/ExpedienteTecnico/expedientetecnico_upd.php", formualrioGeneral, function (respuesta) {
        bootbox.alert("No. de solicitud: " + respuesta.respuesta, function () {
            location.reload();
        });
    }, "json");
}

function buscarExpediente(callback) {
    var id = $('#nosolicitud').val();
    var Firmado, Firmado2, IdEdoSol, IdTipEva, EvaSoc, Dictamen, IdCob;
    $.ajax({
        data: {'accion': 'buscaSolicitud', 'id': id},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                console.log(rSolicitud);
                datosGlobalesSolicitud.psolicitud = rSolicitud.psolicitud[0];
                if (verificarEstadoSolicitud()) {
                    datosGlobalesSolicitud.contratos = rSolicitud.contratoSolicitud;
                    datosGlobalesSolicitud.prgsolicitud = rSolicitud.prgSolicitud;
                    datosGlobalesSolicitud.presolicitud = rSolicitud.preSolicitud;
                    datosGlobalesSolicitud.munsolicitud = rSolicitud.munSolicitud;
                    datosGlobalesSolicitud.acusolicitud = rSolicitud.acuSolicitud;
                    datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                    datosGlobalesSolicitud.tiposolicitud = rSolicitud.psolicitud[0].IdSolPre;
                    datosGlobalesSolicitud.montoTotalInv = rSolicitud.psolicitud[0].Monto;
                    Firmado = rSolicitud.psolicitud[0].Firmado;
                    Firmado2 = rSolicitud.psolicitud[0].Firmado2;
                    IdEdoSol = rSolicitud.psolicitud[0].IdEdoSol;
                    IdTipEva = rSolicitud.psolicitud[0].IdTipEva;
                    EvaSoc = rSolicitud.psolicitud[0].EvaSoc;
                    Dictamen = rSolicitud.psolicitud[0].Dictamen;
                    IdCob = rSolicitud.psolicitud[0].IdCob;
                    imagen = rSolicitud.psolicitud[0].Imagen;
                    if (imagen != '' && imagen) {
                        muestraThumb(imagen);
                    }
                    var fuentestemp = [];
                    if (rSolicitud.psolicitud[0].IdSolPre == "3" || rSolicitud.psolicitud[0].IdSolPre == "12" || rSolicitud.psolicitud[0].IdSolPre == "13") {
                        $('#banAm').val(1);
                        $('#montoTotalAAe').val(rSolicitud.psolicitud[0].MonMun);
                        for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                            fuentestemp.push([rSolicitud.fuentesfed[i].idFte, rSolicitud.fuentesfed[i].montoTotalAm, rSolicitud.fuentesfed[i].MontoAmpliado, rSolicitud.fuentesfed[i].pjeInv, rSolicitud.fuentesfed[i].nombre, rSolicitud.fuentesfed[i].cuenta]);
                        }
                        for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                            fuentestemp.push([rSolicitud.fuentesest[i].idFte, rSolicitud.fuentesest[i].montoTotalAm, rSolicitud.fuentesest[i].MontoAmpliado, rSolicitud.fuentesest[i].pjeInv, rSolicitud.fuentesest[i].nombre, rSolicitud.fuentesest[i].cuenta]);
                        }
                        datosGlobalesSolicitud.fuentes = fuentestemp;
                        console.log("fuentes temp");
                        console.log(datosGlobalesSolicitud.fuentes);
                    } else {
                        for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                            fuentestemp.push([rSolicitud.fuentesfed[i].idFte, rSolicitud.fuentesfed[i].monto, rSolicitud.fuentesfed[i].disponible, rSolicitud.fuentesfed[i].pjeInv, rSolicitud.fuentesfed[i].nombre, rSolicitud.fuentesfed[i].cuenta]);
                        }
                        for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                            fuentestemp.push([rSolicitud.fuentesest[i].idFte, rSolicitud.fuentesest[i].monto, rSolicitud.fuentesest[i].disponible, rSolicitud.fuentesest[i].pjeInv, rSolicitud.fuentesest[i].nombre, rSolicitud.fuentesest[i].cuenta]);
                        }
                        datosGlobalesSolicitud.fuentes = fuentestemp;
                        console.log("fuentes temp");
                        console.log(datosGlobalesSolicitud.fuentes);
                    }
                  
//                    if (datosGlobalesSolicitud.tiposolicitud === "3" && modulo == '1') {// CRAGA DE LAS FUENTES PARA AMPLIACIÓN
                    if (datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "12" || rSolicitud.psolicitud[0].IdSolPre == "13") {// CRAGA DE LAS FUENTES PARA AMPLIACIÓN
                        $('#montoTotalAA').val(rSolicitud.psolicitud[0].Monto);
                        for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                            if (i === 0) {
                                $(".monfed:first").val(number_format(rSolicitud.fuentesfed[i].MontoAmpliado, 2)).attr("title", "Monto asignado anterior: " + number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                                $("input[name='f2[]']:eq(0)").val(rSolicitud.fuentesfed[i].monto);
                                $("input[name='f4[]']:eq(0)").val(rSolicitud.fuentesfed[i].MontoAmpliado);
//                                $(".monfed:first").val("0.00").attr("title", "Monto asignado anterior: " + number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                                $('select[name="ffed[]"]:eq(0) option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected').show();
                                $("select[name='ffed[]']:eq(0) option[value!='" + rSolicitud.fuentesfed[i].idFte + "']").hide();
                            } else {
                                addfed($(".monfed:first"), function () {
                                    $("input[name='f2[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].monto);
                                    $("input[name='f4[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].MontoAmpliado);
//                                    $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                                    $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].MontoAmpliado, 2));
                                    $('select[name="ffed[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected').show();
                                    $("select[name='ffed[]']:eq(" + i + ") option[value!='" + rSolicitud.fuentesfed[i].idFte + "']").hide();
                                });

                            }
                        }

                        for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                            if (i === 0) {
                                $("input[name='e2[]']:eq(0)").val(rSolicitud.fuentesest[i].monto);
                                $("input[name='e4[]']:eq(0)").val(rSolicitud.fuentesest[i].MontoAmpliado);
                                $(".monest:first").val(number_format(rSolicitud.fuentesest[i].MontoAmpliado, 2)).attr("title", "Monto asignado anterior: " + number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
//                                $(".monest:first").val("0.00").attr("title", "Monto asignado anterior: " + number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
                                $('select[name="fest[]"]:eq(0) option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').show();
                                $("select[name='fest[]']:eq(0) option[value!='" + rSolicitud.fuentesest[i].idFte + "']").hide();
                            } else {
                                addfed($(".monest:first"), function () {
                                    $("input[name='e2[]']:eq(" + i + ")").val(rSolicitud.fuentesest[i].monto);
                                    $("input[name='e4[]']:eq(" + i + ")").val(rSolicitud.fuentesest[i].MontoAmpliado);
                                    $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].MontoAmpliado, 2));
//                                    $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].monto, 2));
                                    $('select[name="fest[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').show();
                                    $("select[name='fest[]']:eq(" + i + ") option[value!='" + rSolicitud.fuentesest[i].idFte + "']").hide();
                                });

                            }
                        }

                    } else { // CARGA DE FUENTES PARA LAS DEMAS SOLICITUDES
                        for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                            if (i === 0) {
                                $(".monfed:first").val(number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                                $('select[name="ffed[]"]:eq(0) option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected').show();
                                $("select[name='ffed[]']:eq(0) option[value!='" + rSolicitud.fuentesfed[i].idFte + "']").hide();
                            } else {
                                addfed($(".monfed:first"), function () {
                                    $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                                    $('select[name="ffed[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected');
                                    $("select[name='ffed[]']:eq(" + i + ") option[value!='" + rSolicitud.fuentesfed[i].idFte + "']").hide();
                                });

                            }
                        }

                        for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                            if (i === 0) {
                                $(".monest:first").val(number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
                                $('select[name="fest[]"]:eq(0) option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').show();
                                $("select[name='fest[]']:eq(0) option[value!='" + rSolicitud.fuentesest[i].idFte + "']").hide();
                            } else {
                                addfed($(".monest:first"), function () {
                                    $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].monto, 2));
                                    $('select[name="fest[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').show();
                                    $("select[name='fest[]']:eq(" + i + ") option[value!='" + rSolicitud.fuentesest[i].idFte + "']").hide();
                                });

                            }
                        }

                    }
                    if ((datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9" || datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") || ($("#idRolUsuarioSession").val() === "3")) {
                        $('#idsol').val(rSolicitud.psolicitud[0].IdSol);
                        datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                        $('#ejercicio').val(rSolicitud.psolicitud[0].Ejercicio);
                        $("#ejercicio option[value!='" + rSolicitud.psolicitud[0].Ejercicio + "']").hide();
                        $('#ur3').val(rSolicitud.psolicitud[0].NomSec);
                        $('#ue3').val(rSolicitud.psolicitud[0].NomUE);
                        $('#usuedit').removeAttr('hidden');
                        $('#depnoruni').attr('hidden', 'hidden');
                        $('#usuariouni').attr('hidden', 'hidden');
                        $('#modalidad').val(rSolicitud.psolicitud[0].IdModEje);
                        $("#modalidad option[value!='" + rSolicitud.psolicitud[0].IdModEje + "']").hide();
                        $('#tipobr').val(rSolicitud.psolicitud[0].IdTipObr);
                        $("#tipobr option[value!='" + rSolicitud.psolicitud[0].IdTipObr + "']").hide();
                        $('#evasoc').val(rSolicitud.psolicitud[0].EvaSoc).attr('readonly', true);
                        if (rSolicitud.psolicitud[0].EvaSoc == 1) {
                            $('#nes').attr('hidden', false);
                            $('#nbp').val(rSolicitud.banco);
                            $('.bnc').each(function () {
                                $(this).attr('readonly', true);
                                $('#nbp').attr('readonly', true);
                            });
                            $("#evasoc option[value!='" + rSolicitud.psolicitud[0].EvaSoc + "']").hide();
                            $("#tipLoc option[value!='" + rSolicitud.psolicitud[0].idTipLoc + "']").hide();
                            $("#beneficiario option[value!='" + rSolicitud.psolicitud[0].IdBen + "']").hide();
                            $("#metas option[value!='" + rSolicitud.psolicitud[0].IdMet + "']").hide();
                            $("#coor option[value!='" + rSolicitud.psolicitud[0].CooGeo + "']").hide();
                            $("#tipoCobertura option[value!='" + rSolicitud.psolicitud[0].IdCob + "']").hide();
                        }
                        $('#fmun').val(rSolicitud.psolicitud[0].FteMun);
                        $('#mu').val(number_format(rSolicitud.psolicitud[0].MonMun, 2));
                        var Monto = parseFloat(rSolicitud.psolicitud[0].Monto);
                        var MonMun = parseFloat(rSolicitud.psolicitud[0].MonMun);
                        var montin = Monto + MonMun;
                        $('#montoTotalAA').val(rSolicitud.psolicitud[0].Monto);
//                    $('#montin').val(number_format(rSolicitud.psolicitud[0].Monto, 2));
                        datosGlobalesSolicitud.monto = Monto;
                        console.log(datosGlobalesSolicitud.monto);
                        $('#montin').val(number_format(montin, 2));
                        $('#caract').val(rSolicitud.psolicitud[0].PriCar);
                        $('#noobra').val(rSolicitud.psolicitud[0].IdObr);
                        $('#nomobra').val(rSolicitud.psolicitud[0].NomObr);
                        $('#jusobr').val(rSolicitud.psolicitud[0].Justifi);
                        $('#obsdep').val(rSolicitud.psolicitud[0].ObsUE);
                        $('#criterios').val(rSolicitud.psolicitud[0].CriSoc);
                        $('#depnorm').val(rSolicitud.psolicitud[0].DepNor);
                        $('#mecant').val(rSolicitud.psolicitud[0].CanMet).focusin().focusout();
                        $('#becant').val(rSolicitud.psolicitud[0].CanBen).focusin().focusout();
                        $('#beneficiario').val(rSolicitud.psolicitud[0].IdBen);
                        $('#metas').val(rSolicitud.psolicitud[0].IdMet);
                        $('#solpre').val(rSolicitud.psolicitud[0].IdSolPre);
                        $('#tipoSol').val(rSolicitud.psolicitud[0].IdSolPre);
                        $('#solpreval').val(rSolicitud.psolicitud[0].NomSolPre);
                        $('#tipLoc').val(rSolicitud.psolicitud[0].idTipLoc);

                        if (rSolicitud.psolicitud[0].ObjEstSoc == 1) {
                            $("#obj-0").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjPryEje == 1) {
                            $("#obj-1").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjDerVia == 1) {
                            $("#obj-2").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjMIA == 1) {
                            $("#obj-3").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjObr == 1) {
                            $("#obj-4").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjAcc == 1) {
                            $("#obj-5").attr('checked', true);
                        }
                        if (rSolicitud.psolicitud[0].ObjOtr == 1) {
                            $("#obj-6").attr('checked', true);
                            $('#otro').removeAttr('hidden');
                        } else {
                            $("#obj-6").after("<input type='hidden' name='obj6' value='0'/>");
                        }
                        $('#otroobs').val(rSolicitud.psolicitud[0].ObjOtrObs);
                        if (rSolicitud.psolicitud[0].CooGeo == 1) {
                            $('#coor').val(1);
                            $('#obscoor').attr('readonly', true);
                            $('#coordenadas').removeAttr('hidden');
                        } else {
                            if (rSolicitud.psolicitud[0].CooGeo == 2) {
                                $('#coor').val(2);
                                if (rSolicitud.psolicitud[0].IdEdoSol == 3 || rSolicitud.psolicitud[0].IdEdoSol == 4 || rSolicitud.psolicitud[0].IdEdoSol == 6) {
                                    $('#obscoor').attr('readonly', true);
                                } else {
                                    $('#obscoor').attr('readonly', false);
                                }
                                $('#obscoor').val(rSolicitud.psolicitud[0].ObsCoo);
                            }
                        }
                        $('#lat').val(rSolicitud.psolicitud[0].LatIni);
                        $('#lon').val(rSolicitud.psolicitud[0].LonIni);
                        $('#lat2').val(rSolicitud.psolicitud[0].LatFin);
                        $('#lon2').val(rSolicitud.psolicitud[0].LonFin);
                        if (modulo != "3") {
                            initMap(); // Definimos el mapa
                            addCoordenadasMap();//pintamos objetos en el mapa  
                        }
                        if ($("#origen").attr("readonly") !== "undefined") {
                            $("#origen").before("<input type='hidden' name='origen' id='origenOculto'/>");
                            for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                                $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                                $("#origenOculto").val($("#origenOculto").val() + "," + rSolicitud.acciEstatal[i].idacu);
                            }
                            $("#origenOculto").val($("#origenOculto").val().replace(",", ""));
                            $('#origen').attr("disabled", "disabled");
                            $('#origen').multiSelect("refresh");
                        } else {
                            for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                                $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                            }
                        }
                        $('#tipoCobertura').val(rSolicitud.psolicitud[0].IdCob);
                        $('#inputEmail3').val(rSolicitud.psolicitud[0].NomLoc);
                        if (IdCob == "vacio" || IdCob == 0 || IdCob == 1 || IdCob == "null" || IdCob == "" || IdCob == null) {
                            $('#mult1').attr('hidden', 'hidden');
                            $('#comloc').attr('hidden', 'hidden');
                        } else {
                            if (typeof cambioCobertura == 'function') {
                                cambioCobertura();
                            }
                            setTimeout(function () {
                                if (IdCob == 2) {
                                    $('#mult1').removeAttr('hidden');
                                    $('#comloc').removeAttr('hidden');
                                    if ($("#disponiblesCobertura").attr("readonly") !== "undefined") {
                                        $("#disponiblesCobertura").before("<input type='hidden' name='disponiblesCobertura' id='disponiblesCoberturaOculto'/>");
                                        for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                            $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                                            $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val() + "," + rSolicitud.regSolicitud[i].idreg);
                                        }
                                        $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val().replace(",", ""));
                                        $('#disponiblesCobertura').attr("disabled", "disabled");
                                        $('#disponiblesCobertura').multiSelect("refresh");
                                    } else {
                                        for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                            $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                                        }
                                        $('#disponiblesCobertura').multiSelect("refresh");
                                    }
                                } else {
                                    $('#mult1').removeAttr('hidden');
                                    $('#comloc').removeAttr('hidden');
                                    if ($("#disponiblesCobertura").attr("readonly") !== "undefined") {
                                        $("#disponiblesCobertura").before("<input type='hidden' name='disponiblesCobertura' id='disponiblesCoberturaOculto'/>");
                                        for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                            $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                                            $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val() + "," + rSolicitud.munSolicitud[i].idmun);
                                        }
                                        $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val().replace(",", ""));
                                        $('#disponiblesCobertura').attr("disabled", "disabled");
                                        $('#disponiblesCobertura').multiSelect("refresh");
                                    } else {
                                        for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                            $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                                        }
                                        $('#disponiblesCobertura').multiSelect("refresh");
                                    }
                                }
                            }, 1000);
                        }
                    }
                    $("#myTab").show();
                    $("#formGral").show();
                    $("#containerBotones").show();
                }
//                 $('.number-int').autoNumeric({mDec: 0});
                if (typeof (callback) === "function") {
                    callback();
                }
            } else {
                eliminaWaitGeneral();
                bootbox.alert("No existe esa solicitud");
            }
//            verificarEstadoSolicitud();            
        },
        error: function (response) {
            eliminaWaitGeneral();
            console.log("Errores::", response);
        }
    });

}


function Eliminar1() {
    var par = $(this).parent().parent(); //tr
    par.remove();
}

/*-------------------- FUNCION PARA MOSTRAR VISTA PREVIA DE IMAGEN -------------------*/
function muestraThumb(img) {
    $("#imgPrev").find("a").each(function () {
        $(this).remove()
    });
    $("#imgPrev").append("<a href='#' onclick='muestraImagen()'><img style='width:75%' src='contenido_SGI/uploads/" + img + "'></a>");
    imagen = img;
}
/*-------------------- FUNCION PARA ABRIR IMAGEN -------------------*/
function muestraImagen() {
    $("#imgOriginal").attr("src", "contenido_SGI/uploads/" + imagen + "");
    $("#modalImagen").modal();
}

//funcion para mostrar el resultado de la suma con comas en monto de inversion antfinancieros
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

function colocaWaitGeneral() {
    var divWait = $('<div id="pleaseWaitSGI" class="modal-backdrop fade in"></div><div class="progress modal-dialog" id="progressWait" style="z-index: 99999;height: 40px;"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><p style="height: 40px;display: table;width: 100%;"><span style="display: table-cell;vertical-align: middle;font-size:18px;">Cargando informaci\u00f3n necesaria...</span></p></div></div>').appendTo('body');
    divWait.show();
}

function eliminaWaitGeneral() {
    $("#pleaseWaitSGI").remove();
    $("#progressWait").remove();
}

function verificarEstadoSolicitud() {
    switch (modulo) { //VERIFICAMOS EN QUE MODULO SE ENCUENTRA PARA DETERMINAR LAS VALIDACIONES Y ACCIONES
        case '1':   //MODULO DE SOLICITUD DEL EXPEDIENTE TECNICO
            //Verificamos que la solicitud sea Asignacion,Asignacion adicional,Actualizacion,Asignacion-Autorizacion*Inicial
            if (datosGlobalesSolicitud.psolicitud.IdSolPre == "1" || datosGlobalesSolicitud.psolicitud.IdSolPre == "3" || datosGlobalesSolicitud.psolicitud.IdSolPre == "8" || datosGlobalesSolicitud.psolicitud.IdSolPre == "9" || datosGlobalesSolicitud.psolicitud.IdSolPre == "10" || datosGlobalesSolicitud.psolicitud.IdSolPre == "11" || datosGlobalesSolicitud.psolicitud.IdSolPre == "13") {
                switch (datosGlobalesSolicitud.psolicitud.IdEdoSol) {
                    case '2':
                        $("#cargaExterna").show();
                        if (datosGlobalesSolicitud.psolicitud.IdSolPre == "10") { //ASIGACION-AUTORIZACION
                            $("#pp").show();
                            tablaConceptos.column(9).visible();
                        } else {
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                            $("#pp").hide();
                            tablaConceptos.column(9).visible(false);
                            if ($("#flujo").val() == 3) {
                                $('.am-as').each(function () {
                                    $(this).attr('readonly', true);
                                });
                            }
                        }
                        return true;
                        break;
                    case '3':
                        $("#cargaExterna").hide();
                        eliminaWaitGeneral();
                        bootbox.alert("La solicitud ha sido enviada");
                        $('#formGral').find('input, select, textarea, button').each(function () {
                            $(this).attr('readonly', true);
                            $('#disponiblesCobertura').attr('readonly', false);
                            $('#disponiblesCobertura').attr('readonly', true);
                            $('#enviarET').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                            $("#pp").hide();
                        });
                        $("#microlocalizacion").hide();
                        $("#btnGuardarParcial,#enviarET").hide();
                        $("#abreModal,#btnAddModal1").hide();
                        $("#addContratoHoja4").hide();
                        $("#btnAddConcepto").hide();
                        tablaConceptos.column(11).visible(false);
                        tablaConceptos.column(12).visible(false);
                        tablaHoja4.column(15).visible(false);
                        return true;
                        break;
                    case '4':
                        $("#cargaExterna").hide();
                        eliminaWaitGeneral();
                        bootbox.alert("La solicitud ha sido ingresada a la DGI");
                        $('#formGral').find('input, select, textarea, button').each(function () {
                            $(this).attr('readonly', true);
                            $('#disponiblesCobertura').attr('readonly', false);
                            $('#disponiblesCobertura').attr('readonly', true);
                            $('#enviarET').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                        });
                        $("#microlocalizacion").hide();
                        $("#btnGuardarParcial,#enviarET").hide();
                        $("#abreModal,#btnAddModal1").hide();
                        $("#addContratoHoja4").hide();
                        $("#btnAddConcepto").hide();
                        tablaConceptos.column(11).visible(false);
                        tablaConceptos.column(12).visible(false);
                        tablaHoja4.column(15).visible(false);
                        return true;
                        break;
                    case '5':

                        $('#idobsol').attr('readonly', true);
                        $('#obset').attr('readonly', true);
                        $("#pp").hide();
                        tablaConceptos.column(9).visible(false);
                        if ($("#flujo").val() == 3) {
                            $('.am-as').each(function () {
                                $(this).attr('readonly', true);
                            });
                        }
                        return true;
                        break;
//                        $('#idobsol').attr('disabled', true);
//                        $('#obset').attr('disabled', true);
//                        //HOJA 2
//                        $("#microlocalizacion").hide();
//
//                        //HOJA 3
//                        $("#abreModal").hide();
//                        $("#pariPassu").attr("readonly", true);
//                        ro = true;
//                        $("#enviarET").show();
//                        return true;
//                        break;

                    case '6':
                        eliminaWaitGeneral();
                        bootbox.alert("La solicitud ha sido aceptada");
                        $('#formGral').find('input, select, textarea, button').each(function () {
                            $(this).attr('readonly', true);
                            $('#disponiblesCobertura').attr('readonly', false);
                            $('#disponiblesCobertura').attr('readonly', true);
                            $('#enviarET').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                            $('#idobsol').attr('readonly', true);
                            $('#obset').attr('readonly', true);
                        });
                        $("#microlocalizacion").hide();
                        $("#btnGuardarParcial,#enviarET").hide();
                        $("#abreModal,#btnAddModal1").hide();
                        $("#addContratoHoja4").hide();
                        $("#btnAddConcepto").hide();
                        tablaConceptos.column(11).visible(false);
                        tablaConceptos.column(12).visible(false);
                        tablaHoja4.column(15).visible(false);
                        return true;
                        break;

                }
            }
            else {
                eliminaWaitGeneral();
                bootbox.alert("El tipo de solicitud no corresponde a este m\u00f3dulo");
                return false;
            }
            break;
        case '2': //MODULO DE REVISION DEL EXPEDIENTE TECNICO
            $("#eviarET").hide();
            $("#imprimirET").hide();
            switch (datosGlobalesSolicitud.psolicitud.IdEdoSol) {

                case '3':
                    eliminaWaitGeneral();
                    bootbox.alert("La solicitud a\u00fan no ingresa a la DGI");
                    return false;
                    break;
                case '4':
                    $("#formGral").find("input,select,textarea").each(function () {
                        $(this).attr("readonly", true);
                    });
                    $("#formGral").find(".obs,#tablaConceptos_length_select,#tablaConceptos_filter_input").each(function () {
                        $(this).removeAttr("readonly");
                    });
                    $('#sp').attr('hidden', true);
                    $('#sp2').attr('hidden', false);

                    //HOJA 2
                    $("#microlocalizacion").hide();

                    //HOJA 3
                    $("#abreModal").hide();
                    $("#pariPassu").attr("readonly", true);
                    ro = true;

                    //HOJA 4
                    $("#addContratoHoja4").hide();
                    $("#btnAddConcepto").hide();
                    $("#btnAddModal1").hide();
                    tablaConceptosContratoHoja4.column(4).visible(false);
                    tablaConceptosContratoHoja4.draw();
                    $("#rowGarantia").find("input").attr("readonly", true);
                    $("#tabla2").find("input").attr("readonly", true);
                    $("#rowAnticipo").find("input,textarea").attr("readonly", true);
                    tablaHoja4.column(15).visible(false);
                    tablaHoja4.draw();

                    //HOJA 5

                    //HOJA 6

                    //HOJA 7
                    $("#enviarET").hide();
                    $("#reingreso").attr("readonly", false);
                    return true;
                    break;
                case '5':
                    eliminaWaitGeneral();
                    bootbox.alert("La solicitud ya ha sido revisada");
                    $('#formGral').find('input, select, textarea, button').each(function () {
                        $(this).attr('readonly', true);
                        $('#disponiblesCobertura').attr('readonly', false);
                        $('#disponiblesCobertura').attr('readonly', true);
                        $('#enviarET').attr('readonly', true);
                        $('#idobsol').attr('readonly', true);
                        $('#obset').attr('readonly', true);
                        $('#idobsol').attr('readonly', true);
                        $('#obset').attr('readonly', true);
                    });
                    $("#microlocalizacion").hide();
                    $("#btnGuardarParcial,#enviarET").hide();
                    $("#abreModal,#btnAddModal1").hide();
                    $("#addContratoHoja4").hide();
                    $("#btnAddConcepto").hide();
                    tablaConceptos.column(11).visible(false);
                    tablaConceptos.column(12).visible(false);
                    tablaConceptosContratoHoja4.column(4).visible(false);
                    tablaConceptosContratoHoja4.draw();
                    $("#rowGarantia").find("input").attr("readonly", true);
                    $("#tabla2").find("input").attr("readonly", true);
                    $("#rowAnticipo").find("input,textarea").attr("readonly", true);
                    tablaHoja4.column(15).visible(false);
                    tablaHoja4.draw();
                    return true;
                    break;
                case '6':
                    eliminaWaitGeneral();
                    bootbox.alert("La solicitud ya ha sido aceptada");
                    $('#formGral').find('input, select, textarea, button').each(function () {
                        $(this).attr('readonly', true);
                        $('#disponiblesCobertura').attr('readonly', false);
                        $('#disponiblesCobertura').attr('readonly', true);
                        $('#enviarET').attr('readonly', true);
                        $('#idobsol').attr('readonly', true);
                        $('#obset').attr('readonly', true);
                        $('#idobsol').attr('readonly', true);
                        $('#obset').attr('readonly', true);
                    });
                    $("#microlocalizacion").hide();
                    $("#btnGuardarParcial,#enviarET").hide();
                    $("#abreModal,#btnAddModal1").hide();
                    $("#addContratoHoja4").hide();
                    $("#btnAddConcepto").hide();
                    tablaConceptos.column(11).visible(false);
                    tablaConceptos.column(12).visible(false);
                    tablaConceptosContratoHoja4.column(4).visible(false);
                    tablaConceptosContratoHoja4.draw();
                    $("#rowGarantia").find("input").attr("readonly", true);
                    $("#tabla2").find("input").attr("readonly", true);
                    $("#rowAnticipo").find("input,textarea").attr("readonly", true);
                    tablaHoja4.column(15).visible(false);
                    tablaHoja4.draw();
                    return true;
                    break;
                default:
                    eliminaWaitGeneral();
                    bootbox.alert("Solicitud no v\u00e1lida");
                    return false;
                    break;
            }
            break;

        case '3': //MODULO DE MODIFICACION PRESUPUESTAL
            //SE PASA POR DEFAULT TRUE Y SE HACE LA VERIFICACION DENTRO DEL MODULO PARA EVITAR 
            //CONFLICTOS CON LOS TIEMPOS
            return true;
            break;
    }
}

function colocaMensajePop(elemento, titulo, mensaje) {
    $(elemento).popover({
        content: "<b>" + mensaje + "</b>",
        trigger: "manual",
        placement: "top",
        title: titulo,
        html: true
    });
    console.log(elemento);
    setTimeout(function () {
        $(elemento).popover("show");
        $("#" + $(elemento).attr("aria-describedby")).find("h3").addClass("alert-danger");
    }, 500);
}

function eliminaMensajePop(elemento) {
    if ($(elemento).attr("aria-describedby")) {
        $(elemento).popover("hide");
        $(elemento).popover("destroy");
    }
}

function bloqueaTabs() {
    setTimeout(function () {
        var offset = 0;
        if ($("#idRolUsuarioSession").val() === "3" && $("#pagSiguiente").val() === "8") {
            offset = 2;
        } else {
            offset = 1;
        }
        $("#myTab li:eq(" + (parseInt($("#pagSiguiente").val()) - offset) + ") a").tab("show");
    }, 50);
}

//function verificarTipoSolicitud() {
//    switch ($("#tipoSolicitud").val()) {
//        case 1 :
//            break;
//        case "2" : //SOLICITUD DE AUTORIZACION
//            alert();
//            $("input").each(function () {
//                $(this).attr("disabled", false);
//            });
//            break;
//    }
//}
