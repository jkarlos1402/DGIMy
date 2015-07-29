var GlobTipSol = '';
var numRows = 0;
var regRow = 0;
var GlobIdOfi = 0;
var numFuentes = 0;
$(document).ready(function () {
    //$("#btnOficio").hide();
    $("#btnGuardar").hide();

    $("#limpiar").click(function () {
        location.reload();
    });

    $("#mostrarOficio").click(function () {
        alert('cargar Info');
    });

    $("#agregarObra").click(function () {
        agregarObra();
    });

    /*$("#btnOficio").click(function(){
     alert('oficio');
     });*/

    $("#btnGuardar").click(function () {
        displayDialog();
    });

    $("#numObra").keyup(function () {
        $("#obra").val('');
        if ($.trim($("#numObra").val()) !== "") {
            infoObra();
        }
    });

    cargarCombos();
});

function cargarCombos() {
    $.ajax({
        data: {
            accion: 'combosOficios'
        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: cargar Combos');
        },
        success: function (response) {
            var info = jQuery.parseJSON(response);

            if (info.comboTipSol) {
                $("#tipSol").html(info.comboTipSol);
            }
            if (info.comboEjercicio) {
                $("#ejercicio").html(info.comboEjercicio);
            }
        }
    });
}

function agregarObra() {

    if ($("#ejercicio").val() == 0 || $("#tipSol").val() == 0) {
        bootbox.alert('Para continuar, por favor selecciona un tipo de Solicitud y un Ejercicio');
        return false;
    }

    if ($("#numObra").val() == "") {
        bootbox.alert('Para continuar, por favor ingrese un n\u00famero de obra');
        return false;
    }

    $.ajax({
        data: {
            accion: 'seleccionarObra',
            ejercicio: $("#ejercicio").val(),
            tipSol: $("#tipSol").val(),
            numObr: $("#numObra").val()
        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: consultar Obra');
        },
        success: function (response) {            
            var info = jQuery.parseJSON(response);
            console.log(info);
            if (info.result) {
                numFuentes += parseInt(info.numFtes);
                if (GlobTipSol == '') {
                    GlobTipSol = info.info[0].IdSolPre;
                    appendGridObr(info.info[0]);
                    if (info.infoFtes) {
                        console.log('globsol 0');
                        appendGridFtes(info.infoFtes);
                    }
                }
                else {
                    if (GlobTipSol != info.info[0].IdSolPre) {
                        bootbox.alert('La obra por agregar debe ser del mismo tipo que las anteriores');
                        return false;
                    }
                    else {
                        if (appendGridObr(info.info[0])) {
                            if (info.infoFtes) {
                                console.log('globsol ' + GlobTipSol);
                                appendGridFtes(info.infoFtes);
                            }
                        }
                    }
                }
            }
            else {
                bootbox.alert('<p>No se puede generar oficio para la obra ingresada por alguno de los siguientes motivos: <br/> <ul><li>No existe la obra.</li><li>La obra se encuentra en una etapa diferente al tipo de oficio seleccionado.</li><li>Ya se gener\u00f3(aron) un(los) oficio(s) correspondiente(s) para el ejercicio seleccionado.</li><li>La obra cuenta con estudio socioecon&oacute;mico no dictaminado.</li><li>La solicitud correspondiente no ha sido aceptada.</li><li>La solicitud correspondiente ah sido cancelada.</li></ul>', function () {
                    $("#obra").val("");
                    $("#numObra").val("");
                });
            }
        }
    });
}

function infoObra() {
    $.ajax({
        data: {
            accion: 'getInfoObra',
            idObr: $("#numObra").val()
        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: cargar Combos');
        },
        success: function (response) {

            var info = jQuery.parseJSON(response);
            if (info.result) {
                $("#obra").val(info.info[0].NomObr);
            }
        }
    });
}

function appendGridObr(info) {
    var TipSol = $("#tipSol").val();
    var bndAdd = true;
    $("#infoObras tbody tr").each(function () {
        if ($(this).find("td:eq(0)").text() === info.idObr) {
            bndAdd = false;
        }
    });
    if (bndAdd) {
        var monto = parseFloat(info.Monto);
        //var monto = parseFloat(info.Monto).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');;
        var row = "<tr id='row" + regRow + "'>";
        row += "   <td class='obrasGrid'>" + info.idObr + "</td>";
        row += "   <td>" + info.NomObr + "</td>";
        if ((TipSol == 1) || (TipSol == 3) || (TipSol == 9)) {
            row += "   <td class='montosGrid'>$" + parseFloat(info.MontoAsignado).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + "</td>";
        }
        else if ((TipSol == 2) || (TipSol == 10) || (TipSol == 11) || (TipSol == 12) || (TipSol == 13)) {
            row += "   <td class='montosGrid'>$" + parseFloat(info.MontoAutorizado).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + "</td>";
        }
        else {
            row += "   <td class='montosGrid'>$" + monto.replace(/\d(?=(\d{3})+\.)/g, '$&,') + "</td>";
        }

        row += "   <td>" + info.NomTipObr + "</td>";
        row += "   <td>" + info.NomModEje + "</td>";
        row += "   <td><button type='button' class='btn btn-success' onclick='showFuentes(" + info.idObr + ", " + regRow + ")'>Seleccionar Fuentes</button></td>";
        row += "   <td><button type='button' class='btn btn-danger' onclick='deleteRow(this)'>-</button></td>";
        row += "</tr>";

        $("#infoObrasBody").append(row);
        numRows++;
        regRow++;
        $("#btnGuardar").show();
        actualizarMonto();
        return true;
    } else {
        return false;
    }
}

function appendGridFtes(infoFtes) {    
    var TipSol = $("#tipSol").val();

    var newRow = "<table style='font-sie: 8px'>";
    newRow += "<tr style='background-color: #ddd'>";
    newRow += "<td>Fuente</td>";
    newRow += "<td>Tipo</td>";
    newRow += "<td>Cuenta</td>";
    newRow += "<td>Monto</td>";
    newRow += "<td>% Inversion</td>";
    newRow += "<td></td>";
    newRow += "</tr>";

    var tipFTe = ["", "Federal", "Estatal"];
    
    $(infoFtes).each(function (index, val) {
        //Fuente	Tipo	Cuenta	Monto	% Inversion                
        newRow += "<tr class='fteInv'>";
        newRow += "<td>" + val.DscFte + "</td>";
        newRow += "<td>" + tipFTe[val.tipoFte] + "</td>";
        newRow += "<td style='text-align: left;'>" + val.cuenta + "</td>";

        if ((TipSol == 1) || (TipSol == 3) || (TipSol == 9)) {
            newRow += "<td style='text-align: right;'>$<span class='numerico'>" + parseFloat(val.monto) + "</span></td>";
        }
        else if ((TipSol == 2) || (TipSol == 10) || (TipSol == 11) || (TipSol == 12) || (TipSol == 13)) {
            newRow += "<td style='text-align: right;' >$<span class='numerico'>" + (parseFloat(val.MontoAutorizado)-parseFloat(val.MontoEjercido)).toFixed(2) + "</span></td>";
        }
        else {
            newRow += "<td style='text-align: right'>$<span class='numerico'>" + parseFloat(val.monto) + "</span></td>";
        }

//            newRow +=           "<td style='text-align: right'>"+monto+"</td>";
        newRow += "<td style='text-align: right'>" + parseFloat(val.pjeInv).toFixed(2) + "</td>";
        newRow += "<td><input type='checkbox' name='fte_obra' value='" + val.idFte + "' checked='checked' class='fte_row" + (regRow - 1) + "'/></td>";
        newRow += "</tr>";        
    });

    newRow += "</table>";

    var row = "<tr id='fte_row" + (regRow - 1) + "'>";
    row += "   <td colspan='7'><div id='fte_" + (regRow - 1) + "' style='display: none; background-color: #eaeaea'>" + newRow + "</div></td>";
    row += "</tr>";

    $("#infoObras").append(row);

    $("input[name='fte_obra']").click(function () {
        caculaMontosFte();
    });
    $(".numerico").autoNumeric({aSep: ',', mDec: 2});
}

function deleteRow(element) {
    var elemId = $(element).parent().parent().attr('id');
    //borrrar el id de ftes
    $("#fte_" + elemId).remove();
    $(element).parent().parent().remove();

    actualizarMonto();
    numRows--;
    if (numRows > 0) {
        $("#btnGuardar").show();
    }
    else {
        GlobTipSol = '';
        $("#btnGuardar").hide();
    }
}


function actualizarMonto() {
    var Tot = 0;
    $(".montosGrid").each(function (index) {
        Tot += parseFloat($(this).text().replace("$", "").replace(/,/g, ""));
        console.log(index + ": " + $(this).text());
    });

    Tot = parseFloat(Tot).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
    $("#monto").val(Tot);
    //$("#monto").autoNumeric();
}

function displayDialog() {
    if ($("#button-guardar").length > 0) {
        $("#button-pdf").hide();
        $("#button-word").hide();
    }
    loadFuentes(function () {
        $("#DocumentoF").modal("show");
    });
}

function verPdf() {
    if (GlobIdOfi != 0) {
        $("#idOficioPdf").val(GlobIdOfi);
        setTimeout(function () {
            $("#viewPdf").submit();
        }, 200);

    }
}

function verWord() {
    if (GlobIdOfi != 0) {
        $("#idOficioWord").val(GlobIdOfi);
        setTimeout(function () {
            $("#viewWord").submit();
        }, 200);

    }
}


function loadFuentes(callback) {

    $(".obrasGrid").each(function (index) {
        var rowObr = $(this).parent().attr('id');
        var Ftes = new Array();

        //se recorren las fuentes seleccioadas
        //fte_obra
        $("input[name='fte_obra']").each(function (index) {
            if ($(this).prop('checked')) {
                Ftes.push($(this).val().replace(/,/g, "").replace("$", ""));
            }
        });

        $.ajax({
            data: {
                accion: 'comboFtesOficio',
                fuentes: Ftes
            },
            url: 'contenido_sgi/controller/oficios/oficiosController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Fuentes Oficio');
            },
            success: function (response) {
                console.log(response);
                var info = jQuery.parseJSON(response);
                if (info.result) {
                    $("#idFteTemplate").html(info.combo);
                }
                else {
                    $("#idFteTemplate").html("<option value='0'>Selecciona una fuente para cargar la plantilla</option>");
                }

                $("#idFteTemplate").change();
                if (typeof (callback) === "function") {
                    callback();
                }
            }
        });
    });
}

function loadTemplateFte() {
    var idFte = $("#idFteTemplate").val();
    var idSol = $("#tipSol").val();
    var ejercicio = $("#ejercicio").val();
    $.ajax({
        data: {
            accion: 'loadTemplate',
            ejercicio: ejercicio,
            idSol: idSol,
            idFte: idFte
        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: load Template');
            $("#asunto").val('');
            $("#prefijo").val('');
            $("#texto").val('');
        },
        success: function (response) {
            //console.log(response);
            var info = jQuery.parseJSON(response);

            if (info.result) {

                $("#asunto").val(info.info[0].AsuOFi);
                $("#prefijo").val(info.info[0].PfjOfi);
                $("#ccp").val(info.info[0].ccp);
                var texto = info.info[0].fundamento;
                var Texto = texto.replace('<<<Total>>>', ' $' + $("#monto").val() + ' (' + NumeroALetras($("#monto").val().replace(/,/g, "")) + ')');
                $("#texto").val(Texto + '\n' + info.info[0].complemento);


            }
        }
    });

}

function guardarOficio() {
    var tipOfi = 'general';
    var Items = new Array();

    $(".obrasGrid").each(function (index) {

        //id del row de la obra
        var rowObr = $(this).parent().attr('id');
        var Ftes = new Array();

        //se recorren las fuentes seleccioadas
        $(".fte_" + rowObr).each(function (index) {
            if ($(this).prop('checked')) {
                //se obtienen los montos de la fuente
                var montoFte = $(this).parent().parent().find("td").eq(3).find("span:first").html();
                montoFte = montoFte.replace(/,/g, "").replace("$", "");

                Ftes.push({
                    'fte': $(this).val(),
                    'montoFte': montoFte
                });
            }
            else {
                tipOfi = 'fuente';
            }
        });
        Items.push({'idObra': $(this).text(), 'fuentes': Ftes});

    });
    if ($(".fteInv").length !== numFuentes) {
        tipOfi = 'fuente';
    }    
    $.ajax({
        data: {
            accion: 'guardarOficioMultObras',
            titular: $("#titular").val(),
            asunto: $("#asunto").val(),
            ccp: $("#ccp").val(),
            prefijo: $("#prefijo").val(),
            refer: $("#refer").val(),
            tat: $("#tat").val(),
            texto: $("#texto").val(),
            idSolPre: GlobTipSol,
            ejercicio: $("#ejercicio").val(),
            tipImpOfi: tipOfi,
            obras: Items

        },
        url: 'contenido_sgi/controller/oficios/oficiosController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: guardar Oficios Multiples obras');
        },
        success: function (response) {

            var info = jQuery.parseJSON(response);
            if (info.result) {
                GlobIdOfi = info.idOfi;
                bootbox.alert('Se guardo la informaci\u00f3n para el oficio: ' + info.idOfi);
                $("#button-pdf").show();
                $("#button-word").show();
                $("#button-guardar").remove();
            }
            else {
                bootbox.alert('ocurrio un error al guardar la informaci\u00f3n');
            }

        }
    });
}

function showFuentes(obra, row) {
    $("#fte_" + row).toggle();
    caculaMontosFte();

}

function caculaMontosFte() {
    var Tot = 0;
    $("input[name='fte_obra']").each(function (index) {
        if ($(this).prop('checked')) {
            var montoFte = $(this).parent().parent().find("td").eq(3).find("span:first").html();
            montoFte = montoFte.replace(/,/g, "").replace("$", "");
            Tot = parseFloat(Tot) + parseFloat(montoFte);
        }
    });

    $("#monto").val(parseFloat(Tot).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
}