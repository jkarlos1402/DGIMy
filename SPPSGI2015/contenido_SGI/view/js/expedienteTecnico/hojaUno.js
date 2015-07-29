/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

// Validar solo numeros
    $('.numero').autoNumeric();
    $('.number-int').autoNumeric({mDec: 0});

// Funciones para cuando se selecciona otro en para que se requiere
    $("#obj-6").click(function () {
        if ($("#obj-6").is(':checked')) {
            $('#otro').removeAttr('hidden');
            $('#otroobs').addClass('obligatorioHoja1');
        } else {
            $('#otro').attr('hidden', 'hidden');
            $('#otroobs').val('');
            $('#otroobs').removeClass('obligatorioHoja1');
        }
    });

//Funciones para la suma de montos y obligatorio fuente
    $('.monfed, .monest, .monmun').change(function () {
        suma();
        if (parseFloat($(this).val()) > 0 && $(this).parent().parent().find('select:first').val() == "") {
            $(this).parent().parent().find('select:first').addClass('obligatorioHoja1');
        } else {
            $(this).parent().parent().find('select:first').removeClass('obligatorioHoja1');
        }
        if (parseFloat($(this).val()) !== 0.00 && $(this).parent().parent().find('select:first').val() !== "") {
            $(this).removeClass('obligatorioHoja1');
        }
    });

//Funciones para la suma de montos y obligatorio monto
    $('.numftef, .numftee, .numftem').change(function () {
        suma();
        if ($(this).val() !== "") {
            if ($(this).parent().parent().find('input:first').val() == 0.00) {
                $(this).parent().parent().find('input:first').val('');
                $(this).parent().parent().find('input:first').addClass('obligatorioHoja1');
            }
        } else {
            $(this).parent().parent().find('input:first').removeClass('obligatorioHoja1');
        }
        if ($(this).parent().parent().find('input:first').val() !== 0.00 && $(this).val() !== "") {
            $(this).removeClass('obligatorioHoja1');
        }
    });

// Funcion para el firmado
    $("#evasoc").click(function () {
        var valevasoc = $("#evasoc").val();
        if (valevasoc == 1) {
            $('#nes').removeAttr('hidden');
            $('#nes').addClass('obligatorioHoja1');
        } else {
            $('#nes').attr('hidden', 'hidden');
            $('#nes').removeClass('obligatorioHoja1');
        }
    });

//Funcion para pedir No. de obra
    $("#solpre").change(function () {
        switch ($("#solpre").val()) {
            case "1":
                $('#noobra').attr('readonly', 'readonly');
                $('#idsol').attr('readonly', 'readonly');
                $('#noobra').removeClass('obligatorioHoja1');
                $('#idsol').removeClass('obligatorioHoja1');
                break;
            case "3":
                $('#noobra').attr('readonly', false);
                $('#noobra').addClass('obligatorioHoja1');
                $('#noobra').focus();
                $('#flujo').val(3);
                $('#idsol').attr('readonly', 'readonly');
                $('#idsol').removeClass('obligatorioHoja1');
                break;
            case "8":
                $('#noobra').attr('readonly', 'readonly');
                $('#noobra').removeClass('obligatorioHoja1');
                $('#idsol').attr('readonly', false);
                $('#idsol').addClass('obligatorioHoja1');
                $('#idsol').focus();
                $('#flujo').val(8);
                break;
            case "13":
                $('#noobra').removeAttr('readonly');
                $('#noobra').addClass('obligatorioHoja1');
                $('#noobra').focus();
                $('#flujo').val(13);
                $('#idsol').attr('readonly', 'readonly');
                $('#idsol').removeClass('obligatorioHoja1');
                break;
            case "9":
            case "11":
                $('#noobra').attr('readonly', false);
                $('#noobra').addClass('obligatorioHoja1');
                $('#noobra').focus();
                $('#flujo').val(9);
                $('#idsol').attr('readonly', 'readonly');
                $('#idsol').removeClass('obligatorioHoja1');
                break;
            case "10":
                $('#idsol').attr('readonly', 'readonly');
                $('#idsol').removeClass('obligatorioHoja1');
                $('#noobra').removeClass('obligatorioHoja1');
                break;
        }
    });

//Funcion para add Fuentes
    $(".bt_ftefed").unbind("click").on("click", function () {
        addfed($(this));
    });

    $(".bt_fteest").unbind("click").on("click", function () {
        addest($(this));
    });

//Llenar campos cuando se tiene num de banco
    $("#nbp").change(function () {
        colocaWaitGeneral();
        buscarBanco();
    });

//Llenar campos cuando se tiene num de obra
    $("#noobra").change(function () {
        if ($("#solpre").val() == 3 || $("#solpre").val() == 13) {
            colocaWaitGeneral();
            buscarSol();
        } else {
            colocaWaitGeneral();
            buscarObra();
        }
    });

//Llenar campos cuando se tiene num de solicitud
    $("#idsol").change(function () {
        colocaWaitGeneral();
        buscarSolAct();
    });

//LLamada a funciones iniciales
    colocaWaitGeneral();
    acciones();
    buscarUsuarioUni();
    combos();
});

function buscarUsuarioUni() {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: 'buscarUsuarioUni'}, function (respuesta) {
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
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: 'llenarcombos'}, function (respuesta) {
        $('#ejercicio').html(respuesta.ejercicio);
        $('#solpre').html(respuesta.solPre);
        $('#modalidad').html(respuesta.modEje);
        $('#tipobr').html(respuesta.tipObr);
        $("select[name='ffed[]']").html(respuesta.fteFed);
        $("select[name='fest[]']").html(respuesta.fteEst);
        $('#fbco').html(respuesta.fteBco);
        $('#metas').html(respuesta.metas);
        $('#beneficiario').html(respuesta.beneficiarios);
        eliminaWaitGeneral();
    }, "json");
}

function acciones() {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: 'buscarAcciones'}, function (respuesta) {
        $('#origen').html(respuesta.accionesEst);
        $('#origen').multiSelect({
            selectableHeader: '<label class="col-md-12 control-label" style="text-align:left">Disponibles: </label>',
            selectionHeader: '<label class="col-md-12 control-label" style="text-align:left">Seleccionados: </label>',
        });
    }, "json");
}

function addfed(elem, callback) {
    var newElem = elem.parents(".ftefederal").clone();
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_ftefed").val("-").unbind("click").on("click", function () {
        delRow($(this));
    });
    elem.parents("div").parent().find(".ftefederal").last().after(newElem);

    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function () {
        suma();
    });
    if (typeof (callback) === "function") {
        callback();
    }
}

function addest(elem, callback) {
    var newElem = elem.parents(".fteestatal").clone();
    console.log(newElem.html());
    newElem.find("input").val("");
    newElem.find("select").val("");
    newElem.find(".bt_fteest").val("-").unbind("click").on("click", function () {
        delRow($(this));
    });
    elem.parents("div").parent().find(".fteestatal").last().after(newElem);
    $('.monfed, .monest, .monmun, .numftef, .numftee, .numftem').unbind("change").on("change", function () {
        suma();
    });

    if (typeof (callback) === "function") {
        callback();
    }
}

function delRow(elem) {
    $(elem).parent('div').remove();
    suma();
}

function suma() {
    var montofed = 0;
    var montoest = 0;
    var montomun = 0;
    var inicial = 0;
    var oculto = 0;
    var montoTotalAnterior = 0;
    var total = 0;
    var montin = 0;
    var montoTotalF = 0;
    $('.monfed').each(function () {
        var montofed1 = (($(this).val()).replace(/,/g, "")) * 1;
        montofed = montofed + parseFloat(montofed1);
        $(this).val(number_format($(this).val(), 2));
    });
    $('.monest').each(function () {
        var montoest1 = (($(this).val()).replace(/,/g, "")) * 1;
        montoest = montoest + parseFloat(montoest1);
        $(this).val(number_format($(this).val(), 2));
    });
    montomun = parseFloat(($('.monmun').val()).replace(/,/g, "")) * 1;
    if (!montomun)
        montomun = 0;
    $('.monmun').val(number_format($('.monmun').val(), 2));
    
    var mIe = parseFloat($("#montoTotalAAe").val());
    if(!mIe) mIe = 0;

    montoTotalAnterior = parseFloat($("#montoTotalAA").val());

    if($("#solpre").val() === "3" || $("#solpre").val() === "13"){
        if($('#banAm').val() == 1){
            $('.inicial').each(function () {
                var inicial1 = $(this).val() * 1;
                inicial = inicial + parseFloat(inicial1);
            });
            $('.oculto').each(function () {
                var oculto1 = $(this).val() * 1;
                oculto = oculto + parseFloat(oculto1);
            });
            total = parseFloat(oculto) + parseFloat(montofed) + parseFloat(montoest) + parseFloat(montomun);
            $("#montin").val(number_format(total, 2));
            montin = parseFloat(($('#montin').val()).replace(/,/g, "")) * 1;
            montoTotalF = parseFloat(montin) - parseFloat(montomun);
        }else{
            total = parseFloat(montofed) + parseFloat(montoest) + parseFloat(montomun) + parseFloat(montoTotalAnterior) + parseFloat(mIe);
            $("#montin").val(number_format(total, 2));
            montin = parseFloat(($('#montin').val()).replace(/,/g, "")) * 1;
            montoTotalF = parseFloat(montin) - parseFloat(montomun) - parseFloat(mIe);
        }
    } else {
        total = parseFloat(montofed) + parseFloat(montoest) + parseFloat(montomun);
        $("#montin").val(number_format(total, 2));
        montin = parseFloat(($('#montin').val()).replace(/,/g, "")) * 1;
        montoTotalF = parseFloat(montin) - parseFloat(montomun) - parseFloat(mIe);
    }

    if ($("#solpre").val() === "3" || $("#solpre").val() === "13") {
        var sTMF = Array(), vTMF = Array(), sTME = Array(), vTME = Array();
        var a = 0, g = 0, b = 0, h = 0;
        $('.sumarF').each(function () {
            var montofed1 = (($(this).val()).replace(/,/g, "")) * 1;
            var montofed2 = $("input[name='f2[]']:eq(" + a + ")").val() * 1;
            montofed2 = montofed2 + parseFloat(montofed1);
            sTMF[a] = montofed2;
            a++;
        });
        for (var j = 0; j < a; j++) {
            vTMF[g] = [sTMF[j]];
            g++;
        }
        $('.sumarAAF').each(function () {
            for (var j = 0; j < vTMF.length; j++) {
                $(this).val(vTMF[j]);
            }
        });
        
        $('.sumarE').each(function () {
            var montoest1 = (($(this).val()).replace(/,/g, "")) * 1;
            var montoest2 = $("input[name='e2[]']:eq(" + b + ")").val() * 1;
            montoest2 = montoest2 + parseFloat(montoest1);
            sTME[b] = montoest2;
            b++;
        });
        for (var j = 0; j < b; j++) {
            vTME[h] = [sTME[j]];
            h++;
        }
        $('.sumarAAE').each(function () {
            for (var j = 0; j < vTME.length; j++) {
                $(this).val(vTME[j]);
            }
        });
    }
    datosGlobalesSolicitud.monto = montoTotalF;
//    console.log("datosGlobalesSolicitud.monto");
//    console.log(datosGlobalesSolicitud.monto);
    porcentaje();
}

function porcentaje() {
    var totamonto = datosGlobalesSolicitud.monto;
//    console.log("monto");
//    console.log(datosGlobalesSolicitud.monto);
    var pf = Array(), ifd = Array(), monf = Array(), nff = Array(), dpff = Array();
    var pe = Array(), ies = Array(), mone = Array(), nfe = Array(), dpfe = Array();
    var federal = Array(), estatal = Array();
    var completo = Array();
    var a = 0, b = 0, a2 = 0, b2 = 0, d = 0, e = 0, g = 0, h = 0, n = 0, q = 0, z = 0;
    var totalmA = 0;
    if($("#solpre").val() === "3" || $("#solpre").val() === "13"){
        var montoAmpliado = 0;
        $('.monfed, .monest').each(function () {
            var mAmpliado = (($(this).val()).replace(/,/g, "")) * 1;
           montoAmpliado = montoAmpliado + parseFloat(mAmpliado);
        });
        totalmA = parseFloat(montoAmpliado);
        $('.monfed').each(function () {
            var porf = ((((($(this).val()).replace(/,/g, "")) * 1) * 100) / totalmA).toFixed(5);
            pf[a2] = porf;
            a2++;
        });
        $("input[name='f3[]']:eq(" + a + ")").each(function () {
            var mfed = $(this).val() * 1;
            var disfed = $(this).val() * 1;
            monf[a] = mfed;
            dpff[a] = disfed;
            a++;
        });
        $("#monfed").val(monf);
        $("#porfed").val(pf);
        $('.numftef').each(function () {
            var ifed = $(this).val();
            var nomff = $(this).find('option:selected').text();
            ifd[d] = ifed;
            nff[d] = nomff;
            d++;
        });
        $("#validfed").val(ifd);
        $('.monest').each(function () {
            var pore = ((((($(this).val()).replace(/,/g, "")) * 1) * 100) / totalmA).toFixed(5);
            pe[b2] = pore;
            b2++;
        });
        $("input[name='e3[]']:eq(" + b + ")").each(function () {
            var mest = $(this).val() * 1;
            var disest = $(this).val() * 1;
            mone[b] = mest;
            dpfe[b] = disest;
            b++;
        });
        $("#monest").val(mone);
        $("#porest").val(pe);
        $('.numftee').each(function () {
            var iest = $(this).val();
            var nomfe = $(this).find('option:selected').text();
            ies[e] = iest;
            nfe[e] = nomfe;
            e++;
        });
        $("#validest").val(ies);
    }else{
        $('.monfed').each(function () {
            var porf = ((((($(this).val()).replace(/,/g, "")) * 1) * 100) / totamonto).toFixed(5);
            var mfed = (($(this).val()).replace(/,/g, "")) * 1;
            var disfed = (($(this).val()).replace(/,/g, "")) * 1;
            pf[a] = porf;
            monf[a] = mfed;
            dpff[a] = disfed;
            a++;
        });
        $("#monfed").val(monf);
        $("#porfed").val(pf);
        $('.numftef').each(function () {
            var ifed = $(this).val();
            var nomff = $(this).find('option:selected').text();
            ifd[d] = ifed;
            nff[d] = nomff;
            d++;
        });
        $("#validfed").val(ifd);
        $('.monest').each(function () {
            var pore = ((((($(this).val()).replace(/,/g, "")) * 1) * 100) / totamonto).toFixed(5);
            var mest = (($(this).val()).replace(/,/g, "")) * 1;
            var disest = (($(this).val()).replace(/,/g, "")) * 1;
            pe[b] = pore;
            mone[b] = mest;
            dpfe[b] = disest;
            b++;
        });
        $("#monest").val(mone);
        $("#porest").val(pe);
        $('.numftee').each(function () {
            var iest = $(this).val();
            var nomfe = $(this).find('option:selected').text();
            ies[e] = iest;
            nfe[e] = nomfe;
            e++;
        });
        $("#validest").val(ies);
    }//aquí termina el else
    
    for (var j = 0; j < a; j++) {
        federal[g] = [ifd[j], monf[j], dpff[j], pf[j], nff[j]];
        g++;
    }
    for (var k = 0; k < b; k++) {
        estatal[h] = [ies[k], mone[k], dpfe[k], pe[k], nfe[k]];
        h++;
    }
    var numcampos = federal.length + estatal.length;
    var numfed = federal.length;

    for (var m = 0; m < numcampos; m++) {
        if (n < numfed) {
            completo[n] = federal[m];
        } else {
            if (n < numcampos) {
                completo[n] = estatal[q];
                q++;
            }
        }
        n++;
    }
    
    datosGlobalesSolicitud.fuentes = completo;
//    console.log(datosGlobalesSolicitud.fuentes);
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
    porcentaje();
    var valoresh1 = $("#formGral").serialize();

    if ($.trim($("#nbp").val()) !== "") {
        $.ajax({
            data: valoresh1,
            url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
                console.log(response);
                var dh1 = $.parseJSON(response);
                $('#idsol').val(dh1);
                datosGlobalesSolicitud.idsolicitud = dh1;
                datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
                datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
                eliminaWaitGeneral();
                bootbox.alert('No. de Solicitud de ET: ' + dh1);
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    } else {
        if ($("#formGral").find(".obligatorioHoja1:visible").valid()) {
            $.ajax({
                data: valoresh1,
                url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var dh1 = $.parseJSON(response);
                    $('#idsol').val(dh1);
                    datosGlobalesSolicitud.idsolicitud = dh1;
                    datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
                    datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
                    eliminaWaitGeneral();
                    bootbox.alert('No. de Solicitud de ET: ' + dh1);
                },
                error: function (response) {
                    console.log("Errores::", response);
                }
            });
        } else {
            $("#formGral").find("[aria-invalid='true']:first").focus().each(function () {
                eliminaWaitGeneral();
                bootbox.alert('Favor de llenar los campos obligatorios');
            });
        }
    }
}

function buscarBanco() {
    var id = $('#nbp').val();
    var IdTipEva, EvaSoc, IdCob;
    $.ajax({
        data: {'accion': 'buscaBanco', 'id': id},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                console.log(rSolicitud);
                IdTipEva = rSolicitud.psolicitud[0].IdTipEva;
                EvaSoc = rSolicitud.psolicitud[0].EvaSoc;
                IdCob = rSolicitud.psolicitud[0].IdCob;
                imagen = rSolicitud.psolicitud[0].Imagen;
                if (imagen != '' && imagen) {
                    muestraThumb(imagen);
                }
                var fuentesBuscaBanco = [];
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    fuentesBuscaBanco.push([rSolicitud.fuentesfed[i].idFte, rSolicitud.fuentesfed[i].monto, rSolicitud.fuentesfed[i].disponible, rSolicitud.fuentesfed[i].pjeInv, rSolicitud.fuentesfed[i].nombre, rSolicitud.fuentesfed[i].cuenta]);
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    fuentesBuscaBanco.push([rSolicitud.fuentesest[i].idFte, rSolicitud.fuentesest[i].monto, rSolicitud.fuentesest[i].disponible, rSolicitud.fuentesest[i].pjeInv, rSolicitud.fuentesest[i].nombre, rSolicitud.fuentesest[i].cuenta]);
                }
                datosGlobalesSolicitud.fuentes = fuentesBuscaBanco;
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    if (i === 0) {
                        $(".monfed:first").val(number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                        $('select[name="ffed[]"]:eq(0) option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected');
                    } else {
                        addfed($(".monfed:first"), function () {
                            $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                            $('select[name="ffed[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected');
                        });

                    }
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    if (i === 0) {
                        $(".monest:first").val(number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
                        $('select[name="fest[]"]:eq(0) option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected');
                    } else {
                        addest($(".monest:first"), function () {
                            $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].monto, 2));
                            $('select[name="fest[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected');

                        });

                    }
                }

                $('#idsol').val(rSolicitud.psolicitud[0].IdSol);
                datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                $('#ejercicio').val(rSolicitud.psolicitud[0].Ejercicio);
                $("#ejercicio option[value!='" + rSolicitud.psolicitud[0].Ejercicio + "']").hide();
                $('#ur3').val(rSolicitud.psolicitud[0].NomSec);
                $('#ue3').val(rSolicitud.psolicitud[0].NomUE);
                $('#usuedit').removeAttr('hidden');
                $('#mu').val(rSolicitud.psolicitud[0].MonMun);
                $('#fmun').val(rSolicitud.psolicitud[0].FteMun);
                var Monto = parseFloat(rSolicitud.psolicitud[0].Monto);
                var MonMun = parseFloat(rSolicitud.psolicitud[0].MonMun);
                var montin = Monto + MonMun;
                $('#montin').val(number_format(montin, 2));
                datosGlobalesSolicitud.monto = Monto;
//                console.log(datosGlobalesSolicitud.monto);
                $('#montoTotalAA').val(rSolicitud.psolicitud[0].Monto);
                $('#usuedit').removeAttr('hidden');
                $('#depnoruni').attr('hidden', 'hidden');
                $('#usuariouni').attr('hidden', 'hidden');
                $('#caract').val(rSolicitud.psolicitud[0].PriCar);
                $('#noobra').val(rSolicitud.psolicitud[0].IdObr);
                $('#nomobra').val(rSolicitud.psolicitud[0].NomObr);
                $('#jusobr').val(rSolicitud.psolicitud[0].Justifi);
                $('#mecant').val(rSolicitud.psolicitud[0].CanMet).focusin().focusout();
                $('#becant').val(rSolicitud.psolicitud[0].CanBen).focusin().focusout();
                $('#beneficiario').val(rSolicitud.psolicitud[0].IdBen);
                $("#beneficiario option[value!='" + rSolicitud.psolicitud[0].IdBen + "']").hide();
                $('#metas').val(rSolicitud.psolicitud[0].IdMet);
                $("#metas option[value!='" + rSolicitud.psolicitud[0].IdMet + "']").hide();
                $('#modalidad').val(rSolicitud.psolicitud[0].IdModEje);
                $("#modalidad option[value!='" + rSolicitud.psolicitud[0].IdModEje + "']").hide();
                $('#tipobr').val(rSolicitud.psolicitud[0].IdTipObr);
                $("#tipobr option[value!='" + rSolicitud.psolicitud[0].IdTipObr + "']").hide();
                $('#tipLoc').val(rSolicitud.psolicitud[0].idTipLoc);

                if (rSolicitud.psolicitud[0].CooGeo == 1) {
                    $('#coor').val(1);
                    $('#obscoor').attr('readonly', true);
                    $('#coordenadas').removeAttr('hidden');
                } else {
                    if (rSolicitud.psolicitud[0].CooGeo == 2) {
                        $('#coor').val(2);
                        $('#obscoor').attr('readonly', false);
                        $('#obscoor').val(rSolicitud.psolicitud[0].ObsCoo);
                    }
                }
                $('#lat').val(rSolicitud.psolicitud[0].LatIni);
                $('#lon').val(rSolicitud.psolicitud[0].LonIni);
                $('#lat2').val(rSolicitud.psolicitud[0].LatFin);
                $('#lon2').val(rSolicitud.psolicitud[0].LonFin);
                $("#origen").before("<input type='hidden' name='origen' id='origenOculto'/>");
                for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                    $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                    $("#origenOculto").val($("#origenOculto").val() + "," + rSolicitud.acciEstatal[i].idacu);
                }
                $("#origenOculto").val($("#origenOculto").val().replace(",", ""));
                $("#origen").attr("disabled", "disabled");
                $('#origen').multiSelect("refresh");
                $('#tipoCobertura').val(rSolicitud.psolicitud[0].IdCob);
                $('#inputEmail3').val(rSolicitud.psolicitud[0].NomLoc);
                if (IdCob == "vacio" || IdCob == 0 || IdCob == 1 || IdCob == "null") {
                    $('#mult1').attr('hidden', 'hidden');
                    $('#comloc').attr('hidden', 'hidden');
                } else {
                    cambioCobertura(function () {
                        if (IdCob == 2) {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            $("#disponiblesCobertura").before("<input type='hidden' name='disponiblesCobertura' id='disponiblesCoberturaOculto' />");
                            for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                                $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val() + "," + rSolicitud.regSolicitud[i].idreg);
                            }
                            $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val().replace(",",""));
                            $('#disponiblesCobertura').attr("disabled","disabled");
                            $('#disponiblesCobertura').multiSelect("refresh");
                        } else {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            $("#disponiblesCobertura").before("<input type='hidden' name='disponiblesCobertura' id='disponiblesCoberturaOculto' />");
                            for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                                $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val() + "," + rSolicitud.munSolicitud[i].idmun);
                            }
                            $("#disponiblesCoberturaOculto").val($("#disponiblesCoberturaOculto").val().replace(",",""));
                            $('#disponiblesCobertura').attr("disabled","disabled");
                            $('#disponiblesCobertura').multiSelect("refresh");
                        }
                    });
                }
                $('.bnc').each(function () {
                    $(this).attr('readonly', true);
                });
            } else {
                bootbox.alert("<p>No se puede asignar el Estudio Socioecon&oacute;mico por alguno de los siguientes motivos: <br/> <ul><li>El Estudio Socioecon&oacute;mico no existe.</li><li>El Estudio Socioecon&oacute;mico no ha sido dictaminado.</li><li>El Estudio Socioecon&oacute;mico ya ha sido asignado a otra solicitud.</li></ul>", function () {
                    $("#nbp").val("");
                });
            }
//            verificarEstadoSolicitud();

            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscarObra() {
    var id = $('#noobra').val();
    var IdTipEva, IdCob;
    var tipoObra = $('#solpre').val();
    $.ajax({
        data: {'accion': 'buscaObra', 'id': id, 'tipoObra': tipoObra},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                IdTipEva = rSolicitud.psolicitud[0].IdTipEva;
                IdCob = rSolicitud.psolicitud[0].IdCob;
                imagen = rSolicitud.psolicitud[0].Imagen;
                $('#imagen').val(rSolicitud.psolicitud[0].Imagen);
                if (imagen != '' && imagen) {
                    muestraThumb(imagen);
                }
                $('#ur3').val(rSolicitud.psolicitud[0].NomSec);
                $('#ue3').val(rSolicitud.psolicitud[0].NomUE);
                $('#usuedit').removeAttr('hidden');
                $('#usuedit').removeAttr('hidden');
                $('#depnoruni').attr('hidden', 'hidden');
                $('#usuariouni').attr('hidden', 'hidden');
                $('#caract').val(rSolicitud.psolicitud[0].PriCar);
                $('#nomobra').val(rSolicitud.psolicitud[0].NomObr);
                $('#jusobr').val(rSolicitud.psolicitud[0].Justifi);
                $('#mecant').val(rSolicitud.psolicitud[0].CanMet).focusin().focusout();
                $('#becant').val(rSolicitud.psolicitud[0].CanBen).focusin().focusout();
                $('#beneficiario').val(rSolicitud.psolicitud[0].IdBen);
                $('#metas').val(rSolicitud.psolicitud[0].IdMet);
                $('#modalidad').val(rSolicitud.psolicitud[0].IdModEje);
                $('#evasoc').val(rSolicitud.psolicitud[0].EvaSoc);
                $('#evasoc').attr('readonly', true);
                if (rSolicitud.psolicitud[0].EvaSoc == 1) {
                    $('#nes').attr('hidden', false);
                    $('#nbp').val(rSolicitud.banco).attr('readonly', true);
                }
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
                }
                $('#otroobs').val(rSolicitud.psolicitud[0].ObjOtrObs);
                $('#tipobr').val(rSolicitud.psolicitud[0].IdTipObr);
                $('#tipLoc').val(rSolicitud.psolicitud[0].idTipLoc);
                if (rSolicitud.psolicitud[0].CooGeo == 1) {
                    $('#coor').val(1);
                    $('#obscoor').attr('readonly', true);
                    $('#coordenadas').removeAttr('hidden');
                } else {
                    if (rSolicitud.psolicitud[0].CooGeo == 2) {
                        $('#coor').val(2);
                        $('#obscoor').attr('readonly', false);
                        $('#obscoor').val(rSolicitud.psolicitud[0].ObsCoo);
                    }
                }
                $('#lat').val(rSolicitud.psolicitud[0].LatIni);
                $('#lon').val(rSolicitud.psolicitud[0].LonIni);
                $('#lat2').val(rSolicitud.psolicitud[0].LatFin);
                $('#lon2').val(rSolicitud.psolicitud[0].LonFin);
                for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                    $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                }
                $('#origen').multiSelect("refresh");
                $('#tipoCobertura').val(rSolicitud.psolicitud[0].IdCob);
                $('#inputEmail3').val(rSolicitud.psolicitud[0].NomLoc);
                if (IdCob == "vacio" || IdCob == 0 || IdCob == 1 || IdCob == "null") {
                    $('#mult1').attr('hidden', 'hidden');
                    $('#comloc').attr('hidden', 'hidden');
                } else {
                    cambioCobertura(function () {
                        if (IdCob == 2) {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh");
                        } else {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh")
                        }
                    });
                }
            } else {
//                bootbox.alert("No existe la obra");
                bootbox.alert('<p>No se encuentra la obra alguno de los siguientes motivos: <br/> <ul><li>No existe la obra.</li><li>La obra se encuentra en una etapa diferente.</li><li>Ya se utiliz\u00f3 la obra para este tipo de Solicitud.</li><li>No se ha ejercido el monto total de la obra.</li><li>La obra no pertenece a la modalidad de ejecuci\u00f3n.</li></ul>'); 
            }
//            verificarEstadoSolicitud();
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscarSol() {
    var id = $('#noobra').val();
    var IdTipEva, EvaSoc, IdCob;
    var tipoObra = $('#solpre').val();
    $.ajax({
        data: {'accion': 'buscaSol', 'id': id, 'tipoObra': tipoObra},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                console.log(rSolicitud);
                datosGlobalesSolicitud.psolicitud = rSolicitud.psolicitud[0];
                datosGlobalesSolicitud.contratos = rSolicitud.contratoSolicitud;
                datosGlobalesSolicitud.prgsolicitud = rSolicitud.prgSolicitud;
                datosGlobalesSolicitud.presolicitud = rSolicitud.preSolicitud;
                datosGlobalesSolicitud.munsolicitud = rSolicitud.munSolicitud;
                datosGlobalesSolicitud.acusolicitud = rSolicitud.acuSolicitud;
                datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                datosGlobalesSolicitud.tiposolicitud = rSolicitud.psolicitud[0].IdSolPre;
                IdTipEva = rSolicitud.psolicitud[0].IdTipEva;
                EvaSoc = rSolicitud.psolicitud[0].EvaSoc;
                IdCob = rSolicitud.psolicitud[0].IdCob;
                imagen = rSolicitud.psolicitud[0].Imagen;
                if (imagen != '' && imagen) {
                    muestraThumb(imagen);
                }
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    if (i === 0) {
                        if ($("#solpre").val() !== "3" && $("#solpre").val() !== "13") {
                            $(".monfed:first").val(number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                        }
                        $('select[name="ffed[]"]:eq(0) option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected').attr('readonly', true);
                        $("input[name='f[]']:eq(0)").val(rSolicitud.fuentesfed[i].monto);
                        $("input[name='f2[]']:eq(0)").val(rSolicitud.fuentesfed[i].monto);
                        $("input[name='fcta[]']:eq(0)").val(rSolicitud.fuentesfed[i].cuenta);
                    } else {
                        addfed($(".monfed:first"), function () {
                            if ($("#solpre").val() !== "3" && $("#solpre").val() !== "13") {
                                $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                            }
                            $('select[name="ffed[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected').attr('readonly', true);
                            $("input[name='f[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].monto);
                            $("input[name='f2[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].monto);
                            $("input[name='fcta[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].cuenta);
                        });
                    }
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    if (i === 0) {
                        if ($("#solpre").val() !== "3" && $("#solpre").val() !== "13") {
                            $(".monest:first").val(number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
                        }
                        $('select[name="fest[]"]:eq(0) option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').attr('readonly', true);
                        $("input[name='e[]']:eq(0)").val(rSolicitud.fuentesest[i].monto);
                        $("input[name='e2[]']:eq(0)").val(rSolicitud.fuentesest[i].monto);
                        $("input[name='ecta[]']:eq(0)").val(rSolicitud.fuentesest[i].cuenta);
                    } else {
                        addest($(".monest:first"), function () {
                            if ($("#solpre").val() !== "3" && $("#solpre").val() !== "13") {
                                $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].monto, 2));
                            }
                            $('select[name="fest[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected').attr('readonly', true);
                            $("input[name='e[]']:eq(" + i + ")").val(rSolicitud.fuentesest[i].monto);
                            $("input[name='e2[]']:eq(" + i + ")").val(rSolicitud.fuentesest[i].monto);
                            $("input[name='ecta[]']:eq(" + i + ")").val(rSolicitud.fuentesest[i].cuenta);
                        });
                    }
                }

                var fuentesBuscarSol = [];
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    fuentesBuscarSol.push([rSolicitud.fuentesfed[i].idFte, rSolicitud.fuentesfed[i].monto, rSolicitud.fuentesfed[i].disponible, rSolicitud.fuentesfed[i].pjeInv, rSolicitud.fuentesfed[i].nombre]);
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    fuentesBuscarSol.push([rSolicitud.fuentesest[i].idFte, rSolicitud.fuentesest[i].monto, rSolicitud.fuentesest[i].disponible, rSolicitud.fuentesest[i].pjeInv, rSolicitud.fuentesest[i].nombre]);
                }
                datosGlobalesSolicitud.fuentes = fuentesBuscarSol;
                $('#idsol').val(rSolicitud.psolicitud[0].IdSol);
                $('#ejercicio').val(rSolicitud.psolicitud[0].Ejercicio);
                $('#ur3').val(rSolicitud.psolicitud[0].NomSec);
                $('#ue3').val(rSolicitud.psolicitud[0].NomUE);
                $('#usuedit').removeAttr('hidden');
                $('#tipLoc').val(rSolicitud.psolicitud[0].idTipLoc);
                if ($("#solpre").val() !== "3" && $("#solpre").val() !== "13") {
                    console.log($("#solpre").val());
                    $('#mu').val(number_format(rSolicitud.psolicitud[0].MonMun, 2));
                }
                $('#fmun').val(rSolicitud.psolicitud[0].FteMun);
                var Monto = parseFloat(rSolicitud.psolicitud[0].Monto);
                var MonMun = parseFloat(rSolicitud.psolicitud[0].MonMun);
                var montin = Monto + MonMun;
                $('#montin').val(number_format(montin, 2));
                $('#montoTotalAAe').val(MonMun);
                datosGlobalesSolicitud.monto = Monto;
//                console.log(datosGlobalesSolicitud.monto);
                $('#montoTotalAA').val(rSolicitud.psolicitud[0].Monto);
                $('#usuedit').removeAttr('hidden');
                $('#depnoruni').attr('hidden', 'hidden');
                $('#usuariouni').attr('hidden', 'hidden');
                $('#caract').val(rSolicitud.psolicitud[0].PriCar);
                $('#noobra').val(rSolicitud.psolicitud[0].IdObr);
                $('#nomobra').val(rSolicitud.psolicitud[0].NomObr);
                $('#jusobr').val(rSolicitud.psolicitud[0].Justifi);
                $('#mecant').val(rSolicitud.psolicitud[0].CanMet).focusin().focusout();
                $('#becant').val(rSolicitud.psolicitud[0].CanBen).focusin().focusout();
                $('#beneficiario').val(rSolicitud.psolicitud[0].IdBen);
                $('#metas').val(rSolicitud.psolicitud[0].IdMet);
                $('#modalidad').val(rSolicitud.psolicitud[0].IdModEje);
                $('#tipobr').val(rSolicitud.psolicitud[0].IdTipObr);
                $('#evasoc').val(rSolicitud.psolicitud[0].EvaSoc);
                $('#evasoc').attr('readonly', true);
                if (rSolicitud.psolicitud[0].EvaSoc == 1) {
                    $('#nes').attr('hidden', false);
                    $('#nbp').val(rSolicitud.banco);
                    if ($("#flujo").val() == 8) {
                        $('#nbp').attr('readonly', true);
                    }
                }
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
                }
                $('#otroobs').val(rSolicitud.psolicitud[0].ObjOtrObs);
                if (rSolicitud.psolicitud[0].CooGeo == 1) {
                    $('#coor').val(1);
                    $('#obscoor').attr('readonly', true);
                    $('#coordenadas').removeAttr('hidden');
                } else {
                    if (rSolicitud.psolicitud[0].CooGeo == 2) {
                        $('#coor').val(2);
                        $('#obscoor').attr('readonly', false);
                        $('#obscoor').val(rSolicitud.psolicitud[0].ObsCoo);
                    }
                }
                $('#lat').val(rSolicitud.psolicitud[0].LatIni);
                $('#lon').val(rSolicitud.psolicitud[0].LonIni);
                $('#lat2').val(rSolicitud.psolicitud[0].LatFin);
                $('#lon2').val(rSolicitud.psolicitud[0].LonFin);
                $('#obsdep').val(rSolicitud.psolicitud[0].ObsUE);
                $('#criterios').val(rSolicitud.psolicitud[0].CriSoc);
                $('#depnorm').val(rSolicitud.psolicitud[0].DepNor);
                for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                    $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                }
                $('#origen').multiSelect("refresh");
                $('#tipoCobertura').val(rSolicitud.psolicitud[0].IdCob);
                $('#inputEmail3').val(rSolicitud.psolicitud[0].NomLoc);
                if (IdCob == "vacio" || IdCob == 0 || IdCob == 1 || IdCob == "null") {
                    $('#mult1').attr('hidden', 'hidden');
                    $('#comloc').attr('hidden', 'hidden');
                } else {
                    cambioCobertura(function () {
                        if (IdCob == 2) {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh");
                        } else {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh")
                        }
                    });
                }
                if ($("#flujo").val() == 3) {
                    $('.am-as').each(function () {
                        $(this).attr('readonly', true);
                    });
                }
            } else {
//                bootbox.alert("Obra no localizada");
                bootbox.alert('<p>No se encuentra la obra alguno de los siguientes motivos: <br/> <ul><li>No existe la obra.</li><li>La obra se encuentra en una etapa diferente.</li><li>Ya se utiliz\u00f3 la obra para este tipo de Solicitud.</li><li>No se ha ejercido el monto total de la obra.</li><li>La obra no pertenece a la modalidad de ejecuci\u00f3n.</li></ul>'); 
            }
//            verificarEstadoSolicitud();

            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

//
function guardarAmAs() {
    var idSol = $("#idsol").val();
    var idTipo = $("#solpre").val();
    var idObr = $("#noobra").val();

    $.ajax({
        data: {'accion': 'cloneSolicitud', 'idSol': idSol, 'idTipo': idTipo, 'idObr': idObr},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var dh1 = $.parseJSON(response);
            $('#idsol').val(dh1).attr('readonly', true);
            if ($("#flujo").val() == 3 || $("#flujo").val() == 13) {
                guardarfuentes();
            } else {
                if ($("#flujo").val() == 8) {
                    $("#accion").val("guardaHoja1");
                    guardarHoja1();
                } else {

                    eliminaWaitGeneral();
                }
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardarfuentes() {
    porcentaje();
    var valoresh1 = $("#formGral").serialize();

    $.ajax({
        data: valoresh1,
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var dh1 = $.parseJSON(response);
            $('#idsol').val(dh1).attr('readonly', true);
            datosGlobalesSolicitud.idsolicitud = dh1;
            datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
            datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
            eliminaWaitGeneral();
            bootbox.alert('No. de Solicitud de ET: ' + dh1);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

jQuery.validator.addClassRules("obligatorioHoja1", {
    required: true
});

function guardaAsigAdic() {
    porcentaje();
    var valoresh1 = $("#formGral").serialize();

    if ($("#formGral").find(".asigAdic:visible").valid()) {
        $.ajax({
            data: valoresh1,
            url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
                console.log(response);
                var dh1 = $.parseJSON(response);
                $('#idsol').val(dh1);
                datosGlobalesSolicitud.idsolicitud = dh1;
                datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
                datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
                eliminaWaitGeneral();
                bootbox.alert('No. de Solicitud de ET: ' + dh1);
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    } else {
        $("#formGral").find("[aria-invalid='true']:first").focus().each(function () {
            eliminaWaitGeneral();
            bootbox.alert('Favor de llenar los campos obligatorios');
        });
    }
}

function buscarSolAct() {
    var id = $('#idsol').val();
    var IdEdoSol, IdTipEva, IdCob;
    $.ajax({
        data: {'accion': 'buscaSolicitudAct', 'id': id},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
//                console.log(rSolicitud);
                datosGlobalesSolicitud.psolicitud = rSolicitud.psolicitud[0];
//                if (verificarEstadoSolicitud()) {
                datosGlobalesSolicitud.contratos = rSolicitud.contratoSolicitud;
                datosGlobalesSolicitud.prgsolicitud = rSolicitud.prgSolicitud;
                datosGlobalesSolicitud.presolicitud = rSolicitud.preSolicitud;
                datosGlobalesSolicitud.munsolicitud = rSolicitud.munSolicitud;
                datosGlobalesSolicitud.acusolicitud = rSolicitud.acuSolicitud;
                datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                datosGlobalesSolicitud.tiposolicitud = rSolicitud.psolicitud[0].IdSolPre;
                datosGlobalesSolicitud.montoTotalInv = rSolicitud.psolicitud[0].Monto;
                IdEdoSol = rSolicitud.psolicitud[0].IdEdoSol;
                IdTipEva = rSolicitud.psolicitud[0].IdTipEva;
                IdCob = rSolicitud.psolicitud[0].IdCob;
                imagen = rSolicitud.psolicitud[0].Imagen;
                if (imagen != '' && imagen) {
                    muestraThumb(imagen);
                }
                var fuentestemp = [];
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    fuentestemp.push([rSolicitud.fuentesfed[i].idFte, rSolicitud.fuentesfed[i].monto, rSolicitud.fuentesfed[i].disponible, rSolicitud.fuentesfed[i].pjeInv, rSolicitud.fuentesfed[i].nombre, rSolicitud.fuentesfed[i].cuenta]);
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    fuentestemp.push([rSolicitud.fuentesest[i].idFte, rSolicitud.fuentesest[i].monto, rSolicitud.fuentesest[i].disponible, rSolicitud.fuentesest[i].pjeInv, rSolicitud.fuentesest[i].nombre, rSolicitud.fuentesest[i].cuenta]);
                }
                datosGlobalesSolicitud.fuentes = fuentestemp;
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    if (i === 0) {
                        $(".monfed:first").val(number_format(rSolicitud.fuentesfed[i].monto, 2)).focusin().focusout();
                        $('select[name="ffed[]"]:eq(0) option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected');
                    } else {
                        addfed($(".monfed:first"), function () {
                            $(".monfed:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                            $('select[name="ffed[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesfed[i].idFte + ']').prop('selected', 'selected');
                        });

                    }
                }
                for (var i = 0; i < rSolicitud.fuentesest.length; i++) {
                    if (i === 0) {
                        $(".monest:first").val(number_format(rSolicitud.fuentesest[i].monto, 2)).focusin().focusout();
                        $('select[name="fest[]"]:eq(0) option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected');
                    } else {
                        addest($(".monest:first"), function () {
                            $(".monest:eq(" + i + ")").val(number_format(rSolicitud.fuentesest[i].monto, 2));
                            $('select[name="fest[]"]:eq(' + i + ') option[value=' + rSolicitud.fuentesest[i].idFte + ']').prop('selected', 'selected');

                        });

                    }
                }

                $('#idsol').val(rSolicitud.psolicitud[0].IdSol);
                datosGlobalesSolicitud.idsolicitud = rSolicitud.psolicitud[0].IdSol;
                $('#ejercicio').val(rSolicitud.psolicitud[0].Ejercicio);
                $('#ur3').val(rSolicitud.psolicitud[0].NomSec);
                $('#ue3').val(rSolicitud.psolicitud[0].NomUE);
                $('#usuedit').removeAttr('hidden');
                $('#depnoruni').attr('hidden', 'hidden');
                $('#usuariouni').attr('hidden', 'hidden');
                $('#modalidad').val(rSolicitud.psolicitud[0].IdModEje);
                $('#tipobr').val(rSolicitud.psolicitud[0].IdTipObr);
                $('#evasoc').val(rSolicitud.psolicitud[0].EvaSoc);
                $('#evasoc').attr('readonly', true);
                if (rSolicitud.psolicitud[0].EvaSoc == 1) {
                    $('#nes').attr('hidden', false);
                    $('#nbp').val(rSolicitud.banco);
                    }
                $('#fmun').val(rSolicitud.psolicitud[0].FteMun);
                $('#mu').val(rSolicitud.psolicitud[0].MonMun);
                var Monto = parseFloat(rSolicitud.psolicitud[0].Monto);
                var MonMun = parseFloat(rSolicitud.psolicitud[0].MonMun);
                var montin = Monto + MonMun;
                $('#montin').val(number_format(montin, 2));
                datosGlobalesSolicitud.monto = Monto;
//                console.log(datosGlobalesSolicitud.monto);
                $('#montoTotalAA').val(rSolicitud.psolicitud[0].Monto);
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
                }
                $('#otroobs').val(rSolicitud.psolicitud[0].ObjOtrObs);
                if (rSolicitud.psolicitud[0].CooGeo == 1) {
                    $('#coor').val(1);
                    $('#obscoor').attr('readonly', true);
                    $('#coordenadas').removeAttr('hidden');
                } else {
                    if (rSolicitud.psolicitud[0].CooGeo == 2) {
                        $('#coor').val(2);
                        $('#obscoor').attr('readonly', false);
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
                for (var i = 0; i < rSolicitud.acciEstatal.length; i++) {
                    $("#origen option[value='" + rSolicitud.acciEstatal[i].idacu + "']").attr("selected", "selected");
                }
                $('#origen').multiSelect("refresh");
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
                            for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.regSolicitud[i].idreg + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh");
                        } else {
                            $('#mult1').removeAttr('hidden');
                            $('#comloc').removeAttr('hidden');
                            for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                                $("#disponiblesCobertura option[value='" + rSolicitud.munSolicitud[i].idmun + "']").attr("selected", "selected");
                            }
                            $('#disponiblesCobertura').multiSelect("refresh")
                        }
                    }, 1000);
                }
//                }
                eliminaWaitGeneral();

            } else {
                eliminaWaitGeneral();
                bootbox.alert("Solicitud no v\u00e1lida");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}