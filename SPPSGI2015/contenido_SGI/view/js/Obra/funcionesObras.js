
$(document).ready(function () {
    $("#containerBotones").hover(function () {
        $(this).fadeTo("fast", 1);
    }, function () {
        $(this).fadeTo("fast", 0.4);
    });

    $("#acc").change(function () {
        var acc = $("#acc").val();
        if (acc == 1) {
            $("#sol").attr('hidden', false);
            $("#obr").attr('hidden', true);
            $("#conprg").attr('hidden', true);
            $("#conpry").attr('hidden', true);
            $("#altprg").attr('hidden', false);
            $("#altpry").attr('hidden', false);
            $('#prgObra').addClass('obligatorio');
            $('#pryObra').addClass('obligatorio');
            $("#solicitudObra").focus();
            $('#solicitudObra').addClass('obligatorio');
            $('#noObra').removeClass('obligatorio');
        } else {
            if (acc == 2) {
                $("#obr").attr('hidden', false);
                $("#sol").attr('hidden', true);
                $("#altprg").attr('hidden', true);
                $("#altpry").attr('hidden', true);
                $("#conprg").attr('hidden', false);
                $("#conpry").attr('hidden', false);
                $('#prgObra').removeClass('obligatorio');
                $('#pryObra').removeClass('obligatorio');
                $("#noObra").focus();
                $('#noObra').addClass('obligatorio');
                $('#solicitudObra').removeClass('obligatorio');
            } else {
                $("#obr").attr('hidden', true);
                $("#sol").attr('hidden', true);
                $("#conprg").attr('hidden', true);
                $("#conpry").attr('hidden', true);
                $("#altprg").attr('hidden', true);
                $("#altpry").attr('hidden', true);
                $('#prgObra').removeClass('obligatorio');
                $('#pryObra').removeClass('obligatorio');
                $('#noObra').removeClass('obligatorio');
                $('#solicitudObra').removeClass('obligatorio');
            }
        }
    });

    $("#conprg").attr('hidden', true);
    $("#conpry").attr('hidden', true);
    $("#altprg").attr('hidden', true);
    $("#altpry").attr('hidden', true);

    $("#solicitudObra").on("change",function () {
        colocaWaitGeneral();
        buscarSolicitud();
    });

    $("#noObra").change(function () {
        colocaWaitGeneral();
        buscarSolObra();
    });

    $("#prgObra").change(function () {
        colocaWait($("#pryObra"));
        llenarPryEP();
    });
    
    llenarClaPry()
});

function buscarSolicitud() {
    var id = $('#solicitudObra').val();
    $.ajax({
        data: {'accion': 'buscaSolicitud', 'id': id},
        url: 'contenido_SGI/controller/obra/ObraController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                $('#ejercicioObra').val(rSolicitud.psolicitud[0].Ejercicio);
                $('#tipoObraVal').text(rSolicitud.psolicitud[0].NomTipObr);
                $('#nombreObra').text(rSolicitud.psolicitud[0].NomObr);
                $('#justifiObra').text(rSolicitud.psolicitud[0].Justifi);
                $('#priCarObra').text(rSolicitud.psolicitud[0].PriCar);
                $('#tipoCobObra').text(rSolicitud.psolicitud[0].NomCob);
                $('#costoObra').val(number_format(rSolicitud.psolicitud[0].Monto, 2));
                $('#localidadObra').text(rSolicitud.psolicitud[0].NomLoc);
                $('#latIniObra').text(rSolicitud.psolicitud[0].LatIni);
                $('#lonIniObra').text(rSolicitud.psolicitud[0].LonIni);
                $('#latFinObra').text(rSolicitud.psolicitud[0].LatFin);
                $('#lonFinObra').text(rSolicitud.psolicitud[0].LonFin);
                $('#sectorObra').text(rSolicitud.psolicitud[0].NomSec);
                $('#ueObra').text(rSolicitud.psolicitud[0].NomUE);
                $('#gpoSocObra').text(rSolicitud.psolicitud[0].NomGpo);
                $('#modEjecObra').text(rSolicitud.psolicitud[0].NomModEje);
                $('#valsolpre').val(rSolicitud.psolicitud[0].IdSolPre);
                if (rSolicitud.psolicitud[0].IdCob == 3) {
                    var mun = "", val = "", coma = ", ";
                    for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                        if (i < rSolicitud.munSolicitud.length - 1) {
                            val = rSolicitud.munSolicitud[i].NomMun + coma;
                        } else {
                            val = rSolicitud.munSolicitud[i].NomMun;
                        }
                        mun = mun + val;
                        $('#valreg').text(mun);
                    }
                } else {
                    if (rSolicitud.psolicitud[0].IdCob == 2) {
                        var reg = "", val = "", coma = ",";
                        for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                            if (i < rSolicitud.regSolicitud.length - 1) {
                                val = rSolicitud.regSolicitud[i].NomReg + coma;
                            } else {
                                val = rSolicitud.regSolicitud[i].NomReg;
                            }
                            reg = reg + val;
                            $('#valreg').text(reg);
                        }
                    } else {
                        $('#valreg').text("");
                    }
                }
                if (rSolicitud.fuentesfed.length === 0) {
                    $('#divFed').removeClass('obligatorio').attr('hidden', 'hidden');
                }
                if (rSolicitud.fuentesest.length === 0) {
                    $('#divEst').removeClass('obligatorio').attr('hidden', 'hidden');
                }
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    $("input[name='federal[]']:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                    $("input[name='ffed[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].nombre);
                    $("input[name='idfed[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].idFte);
                    if (i !== (rSolicitud.fuentesfed.length - 1)) {
                        if (typeof addfed == 'function') {
                            addfed($("input[name='federal[]']:eq(" + i + ")").parent().parent().find("input:last"));
                        }
                    }
                }
                for (var j = 0; j < rSolicitud.fuentesest.length; j++) {
                    $("input[name='estatal[]']:eq(" + j + ")").val(number_format(rSolicitud.fuentesest[j].monto, 2));
                    $("input[name='fest[]']:eq(" + j + ")").val(rSolicitud.fuentesest[j].nombre);
                    $("input[name='idest[]']:eq(" + j + ")").val(rSolicitud.fuentesest[j].idFte);
                    if (j !== (rSolicitud.fuentesest.length - 1)) {
                        if (typeof addfed == 'function') {
                            addfed($("input[name='estatal[]']:eq(" + j + ")").parent().parent().find("input:last"));
                        }
                    }
                }
                colocaWait($("#prgObra"));
                llenarPrograma();
            } else {
                bootbox.alert("Solicitud no valida o ya pertenece a una obra");
                $("#solicitudObra").val("");
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscarSolObra() {
    var id = $('#noObra').val();

    $.ajax({
        data: {'accion': 'buscaSolObra', 'id': id},
        url: 'contenido_SGI/controller/obra/ObraController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rSolicitud = $.parseJSON(response);
                $('#valsol').val(rSolicitud.psolicitud[0].IdSol);
                $('#ejercicioObra').val(rSolicitud.psolicitud[0].Ejercicio);
                $('#tipoObraVal').text(rSolicitud.psolicitud[0].NomTipObr);
                $('#nombreObra').text(rSolicitud.psolicitud[0].NomObr);
                $('#justifiObra').text(rSolicitud.psolicitud[0].Justifi);
                $('#priCarObra').text(rSolicitud.psolicitud[0].PriCar);
                $('#tipoCobObra').text(rSolicitud.psolicitud[0].NomCob);
                $('#costoObra').val(number_format(rSolicitud.psolicitud[0].Monto, 2));
                $('#localidadObra').text(rSolicitud.psolicitud[0].NomLoc);
                $('#latIniObra').text(rSolicitud.psolicitud[0].LatIni);
                $('#lonIniObra').text(rSolicitud.psolicitud[0].LonIni);
                $('#latFinObra').text(rSolicitud.psolicitud[0].LatFin);
                $('#lonFinObra').text(rSolicitud.psolicitud[0].LonFin);
                $('#sectorObra').text(rSolicitud.psolicitud[0].NomSec);
                $('#ueObra').text(rSolicitud.psolicitud[0].NomUE);
                $('#gpoSocObra').text(rSolicitud.psolicitud[0].NomGpo);
                $('#modEjecObra').text(rSolicitud.psolicitud[0].NomModEje);
                $('#cprgObra').text(rSolicitud.programa[0].nombre);
                $('#cpryObra').text(rSolicitud.proyecto[0].nombre);
                $('#clapry').val(rSolicitud.clapry);
                $('#clapry').attr('disabled',true);
                if (rSolicitud.psolicitud[0].IdCob == 3) {
                    var mun = "", val = "", coma = ", ";
                    for (var i = 0; i < rSolicitud.munSolicitud.length; i++) {
                        if (i < rSolicitud.munSolicitud.length - 1) {
                            val = rSolicitud.munSolicitud[i].NomMun + coma;
                        } else {
                            val = rSolicitud.munSolicitud[i].NomMun;
                        }
                        mun = mun + val;
                        $('#valreg').text(mun);
                    }
                } else {
                    if (rSolicitud.psolicitud[0].IdCob == 2) {
                        var reg = "", val = "", coma = ",";
                        for (var i = 0; i < rSolicitud.regSolicitud.length; i++) {
                            if (i < rSolicitud.regSolicitud.length - 1) {
                                val = rSolicitud.regSolicitud[i].NomReg + coma;
                            } else {
                                val = rSolicitud.regSolicitud[i].NomReg;
                            }
                            reg = reg + val;
                            $('#valreg').text(reg);
                        }
                    } else {
                        $('#valreg').text("");
                    }
                }
                if (rSolicitud.fuentesfed.length === 0) {
                    $('#divFed').removeClass('obligatorio').attr('hidden', 'hidden');
                }
                if (rSolicitud.fuentesest.length === 0) {
                    $('#divEst').removeClass('obligatorio').attr('hidden', 'hidden');
                }
                for (var i = 0; i < rSolicitud.fuentesfed.length; i++) {
                    $("input[name='federal[]']:eq(" + i + ")").val(number_format(rSolicitud.fuentesfed[i].monto, 2));
                    $("input[name='ffed[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].nombre);
                    $("input[name='idfed[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].idFte);
                    $("input[name='ctafed[]']:eq(" + i + ")").val(rSolicitud.fuentesfed[i].cuenta);
                    if (i !== (rSolicitud.fuentesfed.length - 1)) {
                        if (typeof addfed == 'function') {
                            addfed($("input[name='federal[]']:eq(" + i + ")").parent().parent().find("input:last"));
                        }
                    }
                }
                for (var j = 0; j < rSolicitud.fuentesest.length; j++) {
                    $("input[name='estatal[]']:eq(" + j + ")").val(number_format(rSolicitud.fuentesest[j].monto, 2));
                    $("input[name='fest[]']:eq(" + j + ")").val(rSolicitud.fuentesest[j].nombre);
                    $("input[name='idest[]']:eq(" + j + ")").val(rSolicitud.fuentesest[j].idFte);
                    $("input[name='ctaest[]']:eq(" + j + ")").val(rSolicitud.fuentesest[j].cuenta);
                    if (j !== (rSolicitud.fuentesest.length - 1)) {
                        if (typeof addfed == 'function') {
                            addfed($("input[name='estatal[]']:eq(" + j + ")").parent().parent().find("input:last"));
                        }
                    }
                }
                colocaWait($("#prgObra"));
                llenarPrograma();
            } else {
                bootbox.alert("Obra no valida");
                $("#noObra").val("");
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardaObra() {
    colocaWaitGeneral();
    if ($("#acc").val() == 0) {
        $("#acc").focus();
    } else {
        if ($("#acc").val() == 1) {
            if (($("#solicitudObra").val() == "") && ($("#acc").val() == 1)) {
                $("#solicitudObra").focus();
            } else {
                if ($("#obra").find(".obligatorio:visible").valid()) {
                    $('#accion').val('guardaObra');
                    var valobra = $('#obra').serialize();
                    $.ajax({
                        data: valobra,
                        url: 'contenido_SGI/controller/obra/ObraController.php',
                        type: 'post',
                        success: function (response) {
                            if (response != "false") {
                                var rSolicitud = $.parseJSON(response);
                                sendNotification($("#solicitudObra").val(), $("#idUsuarioSession").val(),
                                        "", rSolicitud, $("#idRolUsuarioSession").val(), "", "","");
                                eliminaWaitGeneral();
                                bootbox.alert("Datos guardados, No. Obra: " + rSolicitud, function (result) {
                                    location.reload();
                                });                                
                            } else {
                                bootbox.alert("Error al registrar obra");
                            }
                        },
                        error: function (response) {
                            console.log("Errores::", response);
                        }
                    });
                } else {
                    $("#obra").find("[aria-invalid='true']:first").focus().each(function () {
                        eliminaWaitGeneral();
                        bootbox.alert('Favor de llenar los campos obligatorios');
                    });
                }
            }
        } else {
            if ($("#acc").val() == 2) {
                if (($("#noObra").val() == "") && ($("#acc").val() == 2)) {
                    $("#noObra").focus();
                } else {
                    if ($("#obra").find(".obligatorio:visible").valid()) {
                        $('#accion').val('modificarObra');
                        console.log($('#accion').val());
                        var valobra = $('#obra').serialize();
                        $.ajax({
                            data: valobra,
                            url: 'contenido_SGI/controller/obra/ObraController.php',
                            type: 'post',
                            success: function (response) {
                                if (response != "false") {
                                    var rSolicitud = $.parseJSON(response);
                                    eliminaWaitGeneral();
                                    bootbox.confirm("Datos modificados, No. Obra: " + rSolicitud, function (result) {
                                        location.reload();
                                    });
                                } else {
                                    bootbox.alert("Error al modificar obra");
                                }
                            },
                            error: function (response) {
                                console.log("Errores::", response);
                            }
                        });
                    } else {
                        $("#obra").find("[aria-invalid='true']:first").focus().each(function () {
                            eliminaWaitGeneral();
                            bootbox.alert('Favor de llenar los campos obligatorios');
                        });
                    }
                }
            }
        }
    }
}

function colocaWaitGeneral() {
    var divWait = $('<div id="pleaseWaitSGI" class="modal-backdrop fade in"></div><div class="progress modal-dialog" id="progressWait" style="z-index: 99999;height: 40px;"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><p style="height: 40px;display: table;width: 100%;"><span style="display: table-cell;vertical-align: middle;font-size:18px;">Cargando informaci\u00f3n necesaria...</span></p></div></div>').appendTo('body');
    divWait.show();
}

function eliminaWaitGeneral() {
    $("#pleaseWaitSGI").remove();
    $("#progressWait").remove();
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

function llenarPrograma() {
    var ejercicio = $('#ejercicioObra').val();
    $.ajax({
        data: {'accion': 'buscaPrograma', 'ejercicio': ejercicio},
        url: 'contenido_SGI/controller/obra/ObraController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rPrograma = $.parseJSON(response);
                $("#prgObra").html(rPrograma.programa);
            } else {
                bootbox.alert("No existe programa para este ejercicio");
            }
            eliminaWait($("#prgObra"));
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function llenarPryEP() {
    var prg = $('#prgObra').val();
    var ejercicio = $('#ejercicioObra').val();
    $.ajax({
        data: {'accion': 'buscaProyecto', 'prg': prg, 'ejercicio': ejercicio},
        url: 'contenido_SGI/controller/obra/ObraController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rPrograma = $.parseJSON(response);
                $("#pryObra").html(rPrograma.proyecto);
            } else {
                bootbox.alert("No existe proyecto para este programa");
            }
            eliminaWait($("#pryObra"));
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function colocaWait(elemento) {
    var progress = '<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Cargando...</span></div></div>';
    $(elemento).after(progress);
    $(elemento).hide();
}
function eliminaWait(elemento) {
    $(elemento).next("div").remove();
    $(elemento).show();
}

jQuery.validator.addClassRules("obligatorio", {
    required: true
});

jQuery.extend(jQuery.validator.messages, {
    required: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Campo requerido</div>'
});

function llenarClaPry() {
    $.ajax({
        data: {'accion': 'buscaClaPry'},
        url: 'contenido_SGI/controller/obra/ObraController.php',
        type: 'post',
        success: function (response) {
            if (response != "false") {
                var rPrograma = $.parseJSON(response);
                $("#clapry").html(rPrograma.clapry);
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}