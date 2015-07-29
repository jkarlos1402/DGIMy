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
    idbco: "",
    tiposolicitud: "",
    fuentes: "",
    monto: "",
    totalConceptos: "",
};

var imagen = "";
var tabs = 0;

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

    // Funcion para guardar
    /*### Revisar
     $("#guardar").click(function () {
     alert("click Guardar");
     guardarExpediente();
     if ($("#pagSiguiente").val() === "4") {
     guardado2(1);
     }
     });
     */

    // Funcion para guardado parcial sobre la hoja actual       
    $("#btnGuardarParcial").click(function () {
        colocaWaitGeneral();
        var activa = 'h1';
        $(".tab-content").find(".active").each(function () {
            activa = $(this).attr("id");
        });
        if (activa == 'h1') {
            $("#accion").val("guardaHoja1");
            guardarHoja1();
        } else if (activa == 'h2') {
            $("#accion").val("guardaHoja2");
            guardarHoja2();
        }
    });

    //Funcion para mostrar datos busqueda
    //## Revisar
    $("#mostraredit").click(function () {
        if ($("#nbp").val() !== "") {
            bootbox.alert('Se debe limpiar la pantalla antes de revisar un estudio socioecon\u00f3mico', function () {
                location.reload();
            });
        } else {
            if ($('#numerobanco').val() != "") {
                colocaWaitGeneral();
                buscarEstudioSocioeconomico(function () {
                    $('.monfed,.monest.monmun').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
//                $('.monfed,.monest.monmun').autoNumeric("update");
                });
                //buscarExpediente();
            } else {
                $('#numerobanco').focus();
            }
        }
    });

    $("#myTab").find("li").each(function () {
        tabs++;
    });

    $('.ayuda').each(function () {
        $(this).attr("data-toggle", "tooltip");
        $(this).attr("data-placement", "right");
        $(this).tooltip();
    });

    $("#containerBotones").show();
    $("#btnImpIngreso").hide();
});

function cambiarHoja(param) {
    if (param == 1) { // ATRAS
        $(".tab-content").find(".active").each(function () {
            switch ($(this).attr("id")) {
                case "h2":
                    $("#pagSiguiente").val(1);
                    $("#pagActiva").val(2);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(0) a").tab("show");
                    break;
            }
        });
    } else {          // SIGUIENTE
        $(".tab-content").find(".active").each(function () {
            switch ($(this).attr("id")) {
                case "h1":
                    $("#pagSiguiente").val(2);
                    $("#pagActiva").val(1);
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(1) a").tab("show");
                    break
                case "h2":
                    $("#pagSiguiente").val(3);
                    $("#pagActiva").val(2);
                    cargarConceptos();
                    datosGlobalesSolicitud.contratos = "";
                    $("#myTab li:eq(2) a").tab("show");
                    break;
            }
        });
    }

    var activa = 'h1';
    $(".tab-content").find(".active").each(function () {
        activa = $(this).attr("id");
    });

    if (activa == 'h1') {
        $("#btnAtras").hide();
        $("#btnSiguiente").show();
    } else if (activa == 'h2') {
        $("#btnAtras").show();
        $("#btnSiguiente").hide();
    } else {
        $("#btnAtras").show();
        $("#btnSiguiente").show();
    }
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

function buscarEstudioSocioeconomico(callback) {

    var numBco = $("#numerobanco").val();

    if (numBco == "" && numBco <= 0) {
        eliminaWaitGeneral();
        bootbox.alert('Ingresa un numero de banco a buscar ');
        return false;
    }
    else {        
        $.ajax({
            data: {
                accion: 'revisaBloqueo',
                numBco: numBco
            },
            url: 'contenido_sgi/controller/banco/bancoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Buscar Numero Banco');
            },
            success: function (response) {                
                var info = jQuery.parseJSON(response);                
                if (info.bloqueo === 1) {
                    $("#btnGuardarParcial").remove();
                    $("#btnFirmar").remove();
                    $("#containerBotones").show();
                    if (info.tipMov === "6" || info.tipMov === "3" || info.tipMov === "4" || info.tipMov === "5") {
                        $("#btnImpIngreso").attr("onclick", "muestraFichaTec(" + numBco + ");").show();
                    }else{
                        $("#btnImpIngreso").remove();
                    }
                    $(".qq-upload-button").hide();
                }
                else {
                    $("#containerBotones").show();
                }
            }
        });

        var parametros = {
            accion: 'consultaNumBco',
            numBco: numBco
        };

        $.ajax({
            data: parametros,
            url: 'contenido_sgi/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Buscar Numero Banco');
            },
            success: function (response) {
                //console.log('Reponse ::' + response);     

                //se recupera la informacion en formato JSON
                var info = jQuery.parseJSON(response);                
                if (info.infoRes) {

                    $("#vidaPry").val(info.infoSol[0].vidaPry);
                    $("#nbp").val(numBco);
                    $("#idsol").val(info.infoSol[0].IdSol);
                    $('#ejercicio option[value=' + info.infoSol[0].Ejercicio + ']').prop('selected', 'selected').change();
                    $("#nomobra").val(info.infoSol[0].NomObr);
                    $("#jusobr").val(info.infoSol[0].Justifi);
                    $('#modalidad option[value=' + info.infoSol[0].IdModEje + ']').prop('selected', 'selected').change();
                    $('#tipobr option[value=' + info.infoSol[0].IdTipObr + ']').prop('selected', 'selected').change();
                    $("#mu").val(number_format(info.infoSol[0].MonMun, 2));
                    $("#fmun").val(info.infoSol[0].FteMun);
                    $("#caract").val(info.infoSol[0].PriCar);
                    $('#gsoc option[value=' + info.infoSol[0].IdGpo + ']').prop('selected', 'selected').change();
                    $('#metas option[value=' + info.infoSol[0].IdMet + ']').prop('selected', 'selected').change();
                    $("#mecant").val(info.infoSol[0].CanMet).focusin().focusout();
                    $('#beneficiario option[value=' + info.infoSol[0].IdBen + ']').prop('selected', 'selected').change();
                    $("#becant").val(info.infoSol[0].CanBen).focusin().focusout();
                    $('#meses option[value=' + info.infoSol[0].DurMes + ']').prop('selected', 'selected').change();
                    $("#anios").val(info.infoSol[0].DurAgs);
                    $('#tipoCobertura option[value=' + info.infoSol[0].IdCob + ']').prop('selected', 'selected').change();
                    $('#tipLoc option[value=' + info.infoSol[0].idTipLoc + ']').prop('selected', 'selected').change();
                    $("#inputEmail3").val(info.infoSol[0].NomLoc);
                    $('#coor option[value=' + info.infoSol[0].CooGeo + ']').prop('selected', 'selected').change();
                    $("#obscoor").val(info.infoSol[0].ObsCoo);

                    $("#lat").val(info.infoSol[0].LatIni);
                    $("#lon").val(info.infoSol[0].LonIni);

                    $("#lat2").val(info.infoSol[0].LatFin);
                    $("#lon2").val(info.infoSol[0].LonFin);

                    setTimeout(function () {
                        if (info.infoSol[0].IdCob == 2) {
                            for (var i = 0; i < info.infoCobReg.length; i++) {
                                //console.log(info.infoCobReg[i].idmun);                            
                                $("#disponiblesCobertura option[value=" + info.infoCobReg[i].idreg + "]").attr("selected", "selected").change();
                            }
                        }
                        else if (info.infoSol[0].IdCob == 3) {
                            for (var i = 0; i < info.infoCobMun.length; i++) {
                                //console.log(info.infoCobMun[i].idmun);                            
                                $("#disponiblesCobertura option[value=" + info.infoCobMun[i].idmun + "]").attr("selected", "selected").change();
                            }
                        }
                        $('#disponiblesCobertura').multiSelect("refresh");
                    }, 5000);

                    // cargar los datos de las fuentes federales                         
                    for (var i = 0; i < info.infoFteFed.length; i++) {
                        if (i === 0) {
                            $(".monfed:first").val(info.infoFteFed[i].monto).focusin().focusout();
                            $('select[name="ffed[]"]:eq(0) option[value=' + info.infoFteFed[i].idFte + ']').prop('selected', 'selected');
                        } else {
                            addfed($(".monfed:first"), function () {
                                $(".monfed:eq(" + i + ")").val(info.infoFteFed[i].monto);
                                $('select[name="ffed[]"]:eq(' + i + ') option[value=' + info.infoFteFed[i].idFte + ']').prop('selected', 'selected');
                            });

                        }
                    }

                    // cargar los datos de las fuentes estatales                                        
                    for (var i = 0; i < info.infoFteEst.length; i++) {
                        if (i === 0) {
                            $(".monest:first").val(info.infoFteEst[i].monto).focusin().focusout();
                            $('select[name="fest[]"]:eq(0) option[value=' + info.infoFteEst[i].idFte + ']').prop('selected', 'selected');
                        } else {
                            addest($(".monest:first"), function () {
                                $(".monest:eq(" + i + ")").val(info.infoFteEst[i].monto);
                                $('select[name="fest[]"]:eq(' + i + ') option[value=' + info.infoFteEst[i].idFte + ']').prop('selected', 'selected');

                            });

                        }
                    }
                    $(".monest").each(function () {
                        $(this).focusin().focusout()
                    });
                    //console.log(info.infoFteEst);

                    //cargar las acciones estatales                    
                    for (var i = 0; i < info.infoAccEst.length; i++) {
                        $("#origen option[value=" + info.infoAccEst[i].idacu + "]").attr("selected", "selected").change();
                    }
                    //cargar las acciones federales
                    for (var i = 0; i < info.infoAccFed.length; i++) {
                        $("#origen2 option[value='" + info.infoAccFed[i].idacu + "']").attr("selected", "selected").change();
                    }
                    $('#origen2,#origen').multiSelect("refresh");


                    //check para las opciones de factibilidad Legal
                    var dataLeg = jQuery.parseJSON(info.infoSol[0].FactLeg);
                    for (var i = 0; i < dataLeg.cu.length; i++) {
                        $.each(dataLeg.cu[i], function (key, value) {
                            $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                        });
                    }

                    //check para las opciones de factibilidad Ambiental
                    //uso de suelo
                    var dataAmb = jQuery.parseJSON(info.infoSol[0].FactAmb);
                    for (var i = 0; i < dataAmb.uso_suelo.length; i++) {
                        $.each(dataAmb.uso_suelo[i], function (key, value) {
                            $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                        });
                    }
                    //impacto ambiental
                    for (var i = 0; i < dataAmb.impacto_ambiental.length; i++) {
                        $.each(dataAmb.impacto_ambiental[i], function (key, value) {
                            $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                        });
                    }
                    //extensiones avisos
                    for (var i = 0; i < dataAmb.extensiones_avisos.length; i++) {
                        $.each(dataAmb.extensiones_avisos[i], function (key, value) {
                            $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                        });
                    }

                    //check para las opciones de factibilidad Tecnica
                    var dataTec = jQuery.parseJSON(info.infoSol[0].FactTec);
                    for (var i = 0; i < dataTec.cu.length; i++) {
                        $.each(dataTec.cu[i], function (key, value) {
                            $("input[name=" + key + "][value='" + value + "']").prop("checked", true);
                        });
                    }

                    $('#montin').val(parseFloat(info.infoSol[0].Monto)+parseFloat($("#mu").val() !== "" ? $("#mu").val().replace(/,/g,""): "0.00")).focusin().focusout();

                    datosGlobalesSolicitud.idbco = numBco;
                    datosGlobalesSolicitud.idsolicitud = info.infoSol[0].IdSol;
                    $('.monfed,.monest,.monmun').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});

                    imagen = info.infoSol[0].Imagen;
                    if (imagen != '' && imagen) {
                        muestraThumb(imagen);
                    }
                }
                else {
                    bootbox.alert('No se encontr\u00F3 informaci\u00F3n para el No. Banco ' + numBco);
                }
                if (typeof (callback) === "function") {
                    callback();
                    eliminaWaitGeneral();
                } else {
                    eliminaWaitGeneral();
                }
            },
            error: function (response) {
                console.log("Errores::", response);
                eliminaWaitGeneral();
            }
        });
    }
}

function muestraFichaTec(idBco) {
    $("#idBcoFicha").val(idBco);
    $("#formFichaBco").submit();
}