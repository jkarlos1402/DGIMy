/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// @Maricarmen_Sotelo

$(document).ready(function () {

// Validar solo numeros
    $('.numero').autoNumeric();
    $('.number-int').autoNumeric({mDec: 0});
    $('.monfed,.monest,.monmun').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $('#montin').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $('#numerobanco').autoNumeric({aSep: '', mDec: 0, vMin: '0'});

// Funciones para cuando se selecciona otro en para que se requiere
    $("#obj-6").click(function () {
        if ($("#obj-6").is(':checked')) {
            $('#otro').removeAttr('hidden');
        } else {
            $('#otro').attr('hidden', 'hidden');
            $('#otroobs').val('');
        }
    });

//Funciones para la suma de montos
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function () {
        suma();
    });


// Funcion para el firmado
    $("#evasoc").click(function () {        

        var valevasoc = $("#evasoc").val();
        if (valevasoc == 1) {
            $('#nes').removeAttr('hidden');
            $('#accfed').removeAttr('hidden');
        } else {
            $('#nes').attr('hidden', 'hidden');
            $('#accfed').attr('hidden', 'hidden');
        }
    });

//#Revisar si el registro de estudio socioeconomico guarda tipo de solicitud de presupuesto    
//Funcion para pedir No. de obra
    $("#solpre").change(function () {
        var tipsolpre = $("#solpre").val();
        if (tipsolpre == 1) {
            $('#noobra').attr('disabled', 'disabled');
        } else {
            $('#noobra').removeAttr('disabled');
        }
    })

//Funcion para add Fuentes
    $(".bt_ftefed").unbind("click").on("click", function () {
        addfed($(this));
    });

    $(".bt_fteest").unbind("click").on("click", function () {
        addest($(this));
    });

    $("#btnFirmar").click(function () {
        var a = 0;
        $(".obligatorio").each(function () {
            if ($(this).val() === "") {                
                a++;
            }
        });        
        if (a > 0) {
            bootbox.alert("Favor de llenar los campos obligatorios");
        } else {
            bootbox.confirm("La informaci\u00F3n se enviar\u00E1 para realizar el dictamen y ya no se podr\u00E1n hacer modificaciones. \u00BFDesea continuar?", function (result) {
                if (result) {
                    enviarDictaminar();
                }
            });
        }
    });

//LLamada a funciones iniciales
    colocaWaitGeneral();
    acciones();
    buscarUsuarioUni();
    combos();

});

//#Revisar cuando aparece el combo o la dependencia
function buscarUsuarioUni() {
    $.post("contenido_sgi/controller/estudioSocioeconomico/estudioSocioeconomicoController.php", {accion: 'buscarUsuarioUni'}, function (respuesta) {
        $('#ue0').html(respuesta.buscarUE);
        $('#ur0').html(respuesta.buscarUR);
        $('#ue2').html(respuesta.comboUE);
        $('#ur2').html(respuesta.comboUR);
        $('#usuuni').val(respuesta.usuarioUni);
        if (respuesta.usuarioUni == "" || respuesta.usuarioUni == null) {
            $('#depnoruni').removeAttr('hidden');
        } else {
            $('#usuariouni').removeAttr('hidden');
        }
    }, "json");
}

function combos() {
    $.post("contenido_sgi/controller/estudioSocioeconomico/estudioSocioeconomicoController.php", {accion: 'llenarcombos'}, function (respuesta) {
        $('#ejercicio').html(respuesta.ejercicio);
        $('#solpre').html(respuesta.solPre);
        $('#modalidad').html(respuesta.modEje);
        $('#tipobr').html(respuesta.tipObr);
        $('select[name="ffed[]"]').html(respuesta.fteFed);
        $('select[name="fest[]"]').html(respuesta.fteEst);
        $('#fbco').html(respuesta.fteBco);
        $('#gsoc').html(respuesta.gpoSoc);
        $('#metas').html(respuesta.metas);
        $('#beneficiario').html(respuesta.beneficiarios);
        $('#tipLoc').html(respuesta.tiploc);
        eliminaWaitGeneral();
    }, "json");
}

function acciones() {
    $.post("contenido_sgi/controller/estudioSocioeconomico/estudioSocioeconomicoController.php", {accion: 'buscarAcciones'}, function (respuesta) {
        $('#origen2').html(respuesta.accionesFed);
        $('#origen').html(respuesta.accionesEst);
        $('#origen,#origen2').multiSelect({
            selectableHeader: '<label class="col-md-12 control-label" style="text-align:left">Disponibles: </label>',
            selectionHeader: '<label class="col-md-12 control-label" style="text-align:left">Seleccionados: </label>',
        });
    }, "json");
}

function addfed(elem,callback) {
    var newElem = elem.parents(".ftefederal").clone();
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_ftefed").val("-").unbind("click").on("click", function () {
        delRow($(this));
    });
    elem.parents("div").parent().find(".ftefederal").last().after(newElem);
//    $('.monfed,.monest').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function () {
        suma();
    });
    if(typeof(callback) === "function"){
        callback();
//        $('.monfed,.monest').autoNumeric("update");
    }
}

function addest(elem,callback) {    
    var newElem = elem.parents(".fteestatal").clone();
    console.log(newElem.html());
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_fteest").val("-").unbind("click").on("click", function () {
        delRow($(this));
    });
    elem.parents("div").parent().find(".fteestatal").last().after(newElem);
//    $('.monfed,.monest').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function () {
        suma();
    });
    if(typeof(callback) === "function"){
        callback();
    }
}

function delRow(elem) {
    elem.parent("div").remove();
    suma();
}

function suma() {
    var montofed = 0;
    var montoest = 0;
    var montomun = 0;
    $('.monfed').each(function () {
        var montofed1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
        montofed = montofed + parseFloat(montofed1);     
    });
    $('.monest').each(function () {
        var montoest1 = $.trim($(this).val()) !== "" ? ((($(this).val()).replace(/,/g, "")) * 1) : 0;
        montoest = montoest + parseFloat(montoest1);        
    });
    montomun = $.trim($('.monmun').val()) !== "" ? (parseFloat(($('.monmun').val()).replace(/,/g, "")) * 1) : 0;

    var total = parseFloat(montofed) + parseFloat(montoest) + parseFloat(montomun);

    $("#montin").val(total);
    $("#montin").focusin().focusout();
    datosGlobalesSolicitud.monto = $("#montin").val().replace(/,/g, "");    
    porcentaje();
}

function porcentaje() {
    var totamonto = (($("#montin").val()).replace(/,/g, "")) * 1;
    var pf = Array(), ifd = Array(), monf = Array();
    var pe = Array(), ies = Array(), mone = Array();
    var pm = Array(), imu = Array(), monm = Array();
    var federal = Array(), estatal = Array(), municipal = Array();
    var completo = Array();
    var a = 0, b = 0, c = 0, d = 0, e = 0, f = 0, g = 0, h = 0, i = 0, n = 0, q = 0, r = 0;
    $('.monfed').each(function () {
        var porf = (((($(this).val()).replace(/,/g, "")) * 1) * 100) / totamonto;
        var mfed = $(this).val();
        pf[a] = porf;
        monf[a] = mfed;
        a++;
    });
    $('.numftef').each(function () {
        var ifed = $(this).val();
        ifd[d] = ifed;
        d++;
    });
    $('.monest').each(function () {
        var pore = (((($(this).val()).replace(/,/g, "")) * 1) * 100) / totamonto;
        var mest = $(this).val();
        pe[b] = pore;
        mone[b] = mest;
        b++;
    });
    $('.numftee').each(function () {
        var iest = $(this).val();
        ies[e] = iest;
        e++;
    });
    $('.monmun').each(function () {
        var porm = (((($(this).val()).replace(/,/g, "")) * 1) * 100) / totamonto;
        var mmun = $(this).val();
        pm[c] = porm;
        monm[c] = mmun;
        c++;
    });
    $('.numftem').each(function () {
        var imun = $(this).val();
        imu[f] = imun;
        f++;
    });

    for (var j = 0; j < a; j++) {
        federal[g] = [ifd[j], monf[j], pf[j]];
        g++;
    }
    for (var k = 0; k < b; k++) {
        estatal[h] = [ies[k], mone[k], pe[k]];
        h++;
    }
    for (var l = 0; l < c; l++) {
        municipal[i] = [imu[l], monm[l], pm[l]];
        i++;
    }

    var numcampos = federal.length + municipal.length + estatal.length;
    var numfed = federal.length;
    var numfed2 = federal.length + estatal.length;

    for (var m = 0; m < numcampos; m++) {
        if (n < numfed) {
            completo[n] = federal[m];
        } else {
            if (n < numfed2) {
                completo[n] = estatal[q];
                q++;
            } else {
                completo[n] = municipal[r];
            }
        }
        n++;
    }
    datosGlobalesSolicitud.fuentes = completo;
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

function justNumbers(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
        return true;
    return /\d/.test(String.fromCharCode(keynum));
}

function guardarHoja1() {



    if ($("#ue")) {
        //se habilitan los campos para que el serialize los tome en cuenta
        $("#ue").attr('disabled', false);
        $("#ur").attr('disabled', false);
    }
    //se habilita el id banco para que pueda ser enviado al hacer update
    $("#nbp").attr('disabled', false);

    $("#accionGuardar").val('guardadoHoja1EstSoc');
    $("#acc").val($("#origen").val());
    var valoresh1 = $("#formGral").serialize();

    if (!validaHoja1()) {
        return false;
    }

    $.ajax({
        data: valoresh1,
        url: 'contenido_SGI/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
        type: 'post',
        success: function (response) {
            //se vuelven a deshabilitar los campos de ue y ur y nbp
            $("#nbp").attr('disabled', true);
            if ($("#ue")) {
                $("#ue").attr('disabled', true);
                $("#ur").attr('disabled', true);
            }

            var dh1 = $.parseJSON(response);
            if (dh1.idBco) {
                $('#nbp').val(dh1.idBco);
                datosGlobalesSolicitud.idbco = dh1.idBco;
            }
            if (dh1.noSol) {
                $('#idsol').val(dh1.noSol);
                datosGlobalesSolicitud.idsolicitud = dh1.noSol;
            }
            //datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
            //datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
            eliminaWaitGeneral();
            if (dh1.update) {
                bootbox.alert('Se modific\u00f3 No. de Banco:' + datosGlobalesSolicitud.idbco);
            } else {
                bootbox.alert('Se registr\u00f3 No. de Banco:' + datosGlobalesSolicitud.idbco);
            }
            /*
             if ($("#firmar").prop("checked")) {// se envia notificacion
             sendNotification("", $("#idUsuarioSession").val(),
             "", "", $("#idRolUsuarioSession").val(), datosGlobalesSolicitud.idbco, "3");
             }
             $("#btnSiguiente").click();
             console.log(datosGlobalesSolicitud);
             */
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function validaHoja1() {
    if ($("#ejercicio").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciona un ejercicio');
        $("#ejercicio").focus();
        return false;
    }
    if ($("#nomobra").val().length < 2) {
        eliminaWaitGeneral();
        bootbox.alert('Ingrese un nombre de obra');
        $("#nomobra").focus();
        return false;
    }
    if ($("#jusobr").val().length < 2) {
        eliminaWaitGeneral();
        bootbox.alert('Ingrese justificaci\u00F3n de la obra');
        $("#jusobr").focus();
        return false;
    }
    if ($("#modalidad").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Seleccione una modalidad de ejecuci\u00F3n');
        $("#modalidad").focus();
        return false;
    }
    if ($("#tipobr").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Seleccione un tipo de obra');
        $("#tipobr").focus();
        return false;
    }
    if ($("#caract").val().length < 2) {
        eliminaWaitGeneral();
        bootbox.alert('Ingrese las principales caracter\u00EDsticas');
        $("#caract").focus();
        return false;
    }

    if ($("#montin").val() <= 0) {
        eliminaWaitGeneral();
        bootbox.alert('Ingrese un monto de inversion mayor a cero');
        $("#montin").focus();
        return false;
    }

    var monf = 1;        
    $(".monfed").each(function (index, val) {                
        if (parseFloat($.trim($(this).val())) > 0 && $(this).parents(".ftefederal").find(".numftef").val() === "") {
            eliminaWaitGeneral();
            bootbox.alert('Selecciona una fuente Federal para el monto ingresado ');
            $(this).parents(".ftefederal").find(".numftef").focus();
            monf = 0;
            return false;
        }
    });
    if (monf != 1) {
        return false;
    }

    var monest = 1;
    $(".monest").each(function (index, val) {
        console.log(index + ":: id :: " + $(this).attr('id'));
        var elemn = $(this).attr('id');

        if (parseFloat($.trim($(this).val())) > 0 && $(this).parents(".fteestatal").find(".numftee").val() === "") {
            eliminaWaitGeneral();
            bootbox.alert('Selecciona una fuente Estatal para el monto ingresado ');
            $(this).parents(".fteestatal").find(".numftee").focus();
            monest = 0;
            return false;
        }
    });

    if (monest != 1) {
        return false;
    }


    if ($("#metas").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciona una meta por lograr');
        $("#metas").focus();
        return false;
    }
    if ($("#mecant").val() <= 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciona una cantidad que corresponda a la meta por lograr');
        $("#mecant").focus();
        return false;
    }
    if ($("#anios").val() <= 0 && $("#meses").val() <= 0) {
        eliminaWaitGeneral();
        bootbox.alert('Ingresa un tiempo de duraci\u00F3n de la obra');
        return false;
    }

    return true;
}

function enviarDictaminar() {    
    $("#nbp").attr('disabled', false);
    var idBco = $("#nbp").val();
    $("#nbp").attr('disabled', true);

    if (idBco == "") {
        eliminaWaitGeneral();
        bootbox.alert('Se requiere guardar los cambios');
        return false;
    }

    $.ajax({
        data: {
            accion: 'enviarDictaminar',
            idBco: idBco
        },
        url: 'contenido_SGI/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
        type: 'post',
        success: function (response) {
            console.log("datosGlobalesSolicitud.idbco");
            console.log(datosGlobalesSolicitud.idbco);
            sendNotification("", $("#idUsuarioSession").val(),
                    "", "", $("#idRolUsuarioSession").val(), datosGlobalesSolicitud.idbco, "3","");

            //despues de enviar la notificacion se recargan los datos para bloquear el E.S.            
            $("#numerobanco").val(idBco);

            buscarEstudioSocioeconomico();
            bootbox.alert('Solicitud de banco ' + idBco + ' ha sido enviada a dictaminar',function(){
                location.reload();
            });
//            console.log(datosGlobalesSolicitud);
//            $("#btnGuardarParcial").hide();
//            $("#btnFirmar").hide();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}