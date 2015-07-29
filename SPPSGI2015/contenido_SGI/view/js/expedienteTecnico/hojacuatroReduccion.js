//variables globales uso exclusivo
var tablaContratosReduccion;
var tablaContratosToSelect;
var contratosEliminados = [];

// acciones iniciales
$(document).ready(function () {
    var opcionesDataTable = {
        retrieve: true,
        searching: true,
        sPaginationType: "bootstrap",
        ordering: false,
        oLanguage: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ning&uacute;n dato disponible en esta tabla",
            sInfo: "Mostrando registro(s) del _START_ al _END_ de un total de _TOTAL_ registro(s)",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "&Uacute;ltimo",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        }
    };
    tablaContratosReduccion = $("#tablaContratosReduccion").DataTable(opcionesDataTable);
    $("#btonCerrarDetalleContr").unbind("click").on("click", function () {
        $("#modalDetalleContrato").modal("hide");
    });
    tablaContratosToSelect = $("#tablaContratosToSelect").DataTable(opcionesDataTable);
    $("#addConvenioReduccion").unbind("click").on("click", function () {
        mostrarContratosToSelected();
    });

    $("#btnAceptarContratoSelected").unbind("click").on("click", function () {
        if ($("input[type='radio'][name='contSelected']:checked").val()) {
            datosGlobalesSolicitud.idContratoReduccion = tablaContratosReduccion.cell(parseInt($("input[type='radio'][name='contSelected']:checked").val()), 0).data();
            $("#modalSeleccionContrato").modal("hide");
            muestraInfoParaConvenio($("input[type='radio'][name='contSelected']:checked").val());
            $("#modalAddConvenio").modal("show");
        } else {
            bootbox.alert("Se debe seleccionar un contrato");
        }

    });
    $("#btnAddConvenio").unbind("click").on("click", function () {
        addConvenioToObra();
    });
    $(".fechaHoja4").datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    });

    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
});


// funciones
function cargaContratosConveniosReduccion(idSolicitud) {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {idSol: idSolicitud, accion: "getContratosHoja4"}, function (data) {
//        console.log("contratos");
        var datosHoja4 = $.parseJSON(data);
//        console.log(datosHoja4);
        var contratoNuevo;
        var opciones = "";
        for (var i = 0; i < datosHoja4.contratos.length; i++) {
            if ((datosGlobalesSolicitud.psolicitud.IdEdoSol === "2" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "5") && datosHoja4.contratos[i].estatus === "0") {
                opciones = '<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>&nbsp;<span class="glyphicon glyphicon-edit" style="cursor:pointer;" onclick="alterContrato(this);" title="Editar"></span>&nbsp;<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="deleteContrato(this);" title="Eliminar"></span>';
            } else {
                opciones = '<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>';
            }
            contratoNuevo = [
                datosHoja4.contratos[i].idContrato, datosHoja4.contratos[i].numContra,
                datosHoja4.contratos[i].fecCeleb, datosHoja4.contratos[i].descrip,
                datosHoja4.contratos[i].empresa[0].RfcEmp, datosHoja4.contratos[i].empresa[0].padronContr,
                datosHoja4.contratos[i].empresa[0].NomEmp, datosHoja4.contratos[i].idTipContr,
                datosHoja4.contratos[i].idMod, datosHoja4.contratos[i].monto,
                datosHoja4.contratos[i].fecInicioContr, datosHoja4.contratos[i].fecTerminoContr,
                datosHoja4.contratos[i].diasCal, datosHoja4.contratos[i].inmuDispo,
                datosHoja4.contratos[i].motNoDisp, datosHoja4.contratos[i].fecDisp,
                datosHoja4.contratos[i].idTipObrContr,
                opciones,
                "",
                {folio: datosHoja4.contratos[i].folioGar, fechaEmision: datosHoja4.contratos[i].fecEmisGar, importe: datosHoja4.contratos[i].importeGar, inicioPlazo: datosHoja4.contratos[i].fecIniGar, finPlazo: datosHoja4.contratos[i].fecFinGar, folioCump: datosHoja4.contratos[i].folioGarCump, fechaEmisionCump: datosHoja4.contratos[i].fecEmisGarCump, importeCump: datosHoja4.contratos[i].importeGarCump, inicioPlazoCump: datosHoja4.contratos[i].fecIniGarCump, finPlazoCump: datosHoja4.contratos[i].fecFinGarCump},
                {importe: datosHoja4.contratos[i].importeAnti, porcentaje: "", motivos: datosHoja4.contratos[i].motivImporte, formaPago: datosHoja4.contratos[i].formaPagoAnti},
                [],
                "",
                datosHoja4.contratos[i].idEmp,
                datosHoja4.contratos[i].contratoPadre,
                datosHoja4.contratos[i].montoAutActual,
                datosHoja4.contratos[i].estatus
            ];
            var avaFisHoja4 = [];
            for (var j = 0; j < datosHoja4.contratos[i].programas.length; j++) {
                datosHoja4.contratos[i].programas[j][15] = '';
                avaFisHoja4.push([datosHoja4.contratos[i].programas[j][0],
                    datosHoja4.contratos[i].programas[j][1],
                    datosHoja4.contratos[i].programas[j][2],
                    datosHoja4.contratos[i].programas[j][3],
                    datosHoja4.contratos[i].programas[j][4],
                    datosHoja4.contratos[i].programas[j][5],
                    datosHoja4.contratos[i].programas[j][6],
                    datosHoja4.contratos[i].programas[j][7],
                    datosHoja4.contratos[i].programas[j][8],
                    datosHoja4.contratos[i].programas[j][9],
                    datosHoja4.contratos[i].programas[j][10],
                    datosHoja4.contratos[i].programas[j][11],
                    datosHoja4.contratos[i].programas[j][12],
                    datosHoja4.contratos[i].programas[j][13],
                    datosHoja4.contratos[i].programas[j][14],
                    datosHoja4.contratos[i].programas[j][15]]);
            }
            contratoNuevo[21] = avaFisHoja4;
            var avanceFinanHoja4 = datosHoja4.contratos[i].avanceFinan.split(",");
            contratoNuevo[22] = avanceFinanHoja4;
            tablaContratosReduccion.row.add(contratoNuevo);
            if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] !== "00-00-0000") {
                tablaContratosReduccion.row(i).nodes().to$().addClass("rowConvenio");
            }
            if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] === "00-00-0000") {
                tablaContratosReduccion.row(i).nodes().to$().addClass("rowConvenioReduccion");
                var indexContratoPadre = tablaContratosReduccion.column(0).data().indexOf(contratoNuevo[24]);
                tablaContratosReduccion.cell(indexContratoPadre, 24).data("?");
            }
            tablaContratosReduccion.cell(i, 9).nodes().to$().addClass("numero2");            
        }
        tablaContratosReduccion.draw();
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
        tablaContratosReduccion.column(0).visible(false);
        tablaContratosReduccion.column(3).visible(false);
        tablaContratosReduccion.column(4).visible(false);
        tablaContratosReduccion.column(5).visible(false);
        tablaContratosReduccion.column(7).visible(false);
        tablaContratosReduccion.column(8).visible(false);
        tablaContratosReduccion.column(10).visible(false);
        tablaContratosReduccion.column(11).visible(false);
        tablaContratosReduccion.column(12).visible(false);
        tablaContratosReduccion.column(13).visible(false);
        tablaContratosReduccion.column(14).visible(false);
        tablaContratosReduccion.column(15).visible(false);
        tablaContratosReduccion.column(16).visible(false);
        tablaContratosReduccion.column(18).visible(false);
        tablaContratosReduccion.column(19).visible(false);
        tablaContratosReduccion.column(20).visible(false);
        tablaContratosReduccion.column(21).visible(false);
        tablaContratosReduccion.column(22).visible(false);
        tablaContratosReduccion.column(23).visible(false);
        tablaContratosReduccion.column(24).visible(false);
        tablaContratosReduccion.column(25).visible(false);
        tablaContratosReduccion.column(26).visible(false);
    });
}

function detallesConceptoContrato(elem) {
    var aPos = tablaContratosReduccion.row($(elem).parent().parent()).index();
    //console.log(aPos);
    var dataSelected = tablaContratosReduccion.row(aPos).data();
    $("#noContratoC").text(dataSelected[1]);
    $("#fecCelebracionC").text(dataSelected[2]);
    $("#descContratoC").text(dataSelected[3]);
    $("#empresaRFCC").text(dataSelected[4]);
    $("#numPadronContratistaC").text(dataSelected[5]);
    $("#empresaContratoC").text(dataSelected[6]);
    $("#tipoContratoC").text($("#tipoContrato option[value='" + dataSelected[7] + "']").text());
    $("#modAdjContratoC").text($("#modAdjContrato option[value='" + dataSelected[8] + "']").text());
    $("#montoContratoC").text(dataSelected[9]);
    $("#fecInicioContrC").text(dataSelected[10]);
    $("#fecTerminoContrC").text(dataSelected[11]);
    $("#diasContratoC").text(dataSelected[12]);
    $("#dispInmuContratoC").text($("#dispInmuContrato option[value='" + dataSelected[13] + "']").text());
    if (dataSelected[13] === "0") {
        $("#rowMotivosC").show();
    } else {
        $("#rowMotivosC").hide();
    }
    $("#motivosNoDispContratoC").text(dataSelected[14]);
    $("#fecDisponibilidadInmC").text(dataSelected[15]);
    $("#tipObrContrC").text($("#tipObrContr option[value='" + dataSelected[16] + "']").text());
    $("#orgOfObrC").text(datosGlobalesSolicitud.psolicitud.NomUE);
    $("#tblFuenteContratoC tbody").html("");
    for (var i = 0; i < datosGlobalesSolicitud.fuentes.length; i++) {
        $("#tblFuenteContratoC").append("<tr><td>" + datosGlobalesSolicitud.fuentes[i][4] + "</td><td>" + datosGlobalesSolicitud.fuentes[i][3] + "</td><td class='numero2'>" + datosGlobalesSolicitud.fuentes[i][1] + "</td><td class='numero2'>" + datosGlobalesSolicitud.fuentes[i][2] + "</td></tr>");
    }
    $("#numObrContratoC").text(datosGlobalesSolicitud.psolicitud.IdObr !== null ? datosGlobalesSolicitud.psolicitud.IdObr : "");
    $("#nomObrContratoC").text(datosGlobalesSolicitud.psolicitud.NomObr);    
    if (datosGlobalesSolicitud.psolicitud.IdCob === "1") {
        $("#coberturaContratoC").text("Estatal");
    } else if (datosGlobalesSolicitud.psolicitud.IdCob === "2") {
        $("#coberturaContratoC").text("Regional");
    } else {
        $("#coberturaContratoC").text("Municipal");
    }
    $("#descObrContratoC").text(datosGlobalesSolicitud.psolicitud.PriCar);
    $("#modalDetalleContrato").modal();
    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $('.numero2').autoNumeric("update");
}


function cargaCombosContratos(callback) {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: "combosContratos"}, function (data) {
        var combos = $.parseJSON(data);
        $("#tipoContrato").html(combos["tipos"]);
        $("#modAdjContrato").html(combos["modAdj"]);
        $("#tipObrContr").html(combos["tipObrContr"]);
        if (typeof (callback) === "function") {
            callback();
        }
    });
}

function mostrarContratosToSelected() {
    tablaContratosToSelect.clear();
    for (var i = 0; i < tablaContratosReduccion.column(0).data().length; i++) {
        if (tablaContratosReduccion.cell(i, 24).data() === null || tablaContratosReduccion.cell(i, 24).data() === "" || tablaContratosReduccion.cell(i, 24).data() === "0") {
            tablaContratosToSelect.row.add([
                tablaContratosReduccion.cell(i, 1).data(),
                tablaContratosReduccion.cell(i, 2).data(),
                tablaContratosReduccion.cell(i, 6).data(),
                tablaContratosReduccion.cell(i, 9).data(),
                '<input type="radio" name="contSelected" value="' + i + '"/>'
            ]);
        }
    }
    for (var i = 0; i < tablaContratosToSelect.column(0).data().length; i++) {
        tablaContratosToSelect.cell(i, 3).nodes().to$().addClass("numero2");        
    }
    tablaContratosToSelect.draw();
    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $("#modalSeleccionContrato").modal("show");
}

function muestraInfoParaConvenio(index) {
    var datosSel = tablaContratosReduccion.row(index).data();
    $("#isConvenio").val("1");
    $("#isEditContrato").val("0");
    $("#indexTableContrato").val(index);
    $("#idRFC").val(datosSel[23]);
    $("#idcontratoPadre").val(datosSel[0]);
    $("#empresaRFC").val(datosSel[4]).attr("readonly", true);
    $("#numPadronContratista").val(datosSel[5]).attr("readonly", true);
    $("#empresaContrato").val(datosSel[6]).attr("readonly", true);
    $("#tipoContrato").val(datosSel[7]).attr("readonly", true);
    $("#tipoContrato option[value!='" + datosSel[7] + "']").hide();
    $("#modAdjContrato").val(datosSel[8]).attr("readonly", true);
    $("#modAdjContrato option[value!='" + datosSel[8] + "']").hide();
    $("#dispInmuContrato").val(datosSel[13]).attr("readonly", true);
    $("#dispInmuContrato option[value!='" + datosSel[13] + "']").hide();
    if (datosSel[14] !== "") {
        $("#rowMotivos").show();
        $("#motivosNoDispContrato").val(datosSel[14]).attr("readonly", true);
        $("#fecDisponibilidadInm").val(datosSel[15]).datepicker("update");
    }
    $("#tipObrContr").val(datosSel[16]).attr("readonly", true);
    $("#tipObrContr option[value!='" + datosSel[16] + "']").hide();
    colocaInfoGlobaltoContrato();
    $("#modalAddConvenio").find('.modal-title').text('Datos del convenio de reducci\u00f3n');
    $("#modalAddConvenio").modal("show");
}

function colocaInfoGlobaltoContrato() {
    $("#orgOfObr").text(datosGlobalesSolicitud.psolicitud.NomUE);
    $("#tblFuenteContrato tbody").html("");
    for (var i = 0; i < datosGlobalesSolicitud.fuentes.length; i++) {
        $("#tblFuenteContrato").append("<tr><td>" + datosGlobalesSolicitud.fuentes[i][4] + "</td><td>" + datosGlobalesSolicitud.fuentes[i][3] + "</td><td class='numero2'>" + datosGlobalesSolicitud.fuentes[i][1] + "</td><td class='numero2'>" + datosGlobalesSolicitud.fuentes[i][2] + "</td></tr>");
    }
    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $("#numObrContrato").text(datosGlobalesSolicitud.psolicitud.IdObr !== null ? datosGlobalesSolicitud.psolicitud.IdObr : "");
    $("#nomObrContrato").text(datosGlobalesSolicitud.psolicitud.NomObr);
    if (datosGlobalesSolicitud.psolicitud.IdCob === "1") {
        $("#coberturaContrato").text("Estatal");
    } else if (datosGlobalesSolicitud.psolicitud.IdCob === "2") {
        $("#coberturaContrato").text("Regional");
    } else {
        $("#coberturaContrato").text("Municipal");
    }
    $("#descObrContrato").text(datosGlobalesSolicitud.psolicitud.PriCar);
}

function addConvenioToObra() {
    if ($("#modalAddConvenio").find(".obligatorioHoja4:visible").valid()) {
        if ($("#isEditContrato").val() === "1") {
            var datosAnteriorContrato = tablaContratosReduccion.row(parseInt($("#indexTableContrato").val())).data();
            var datosNew = [
                datosAnteriorContrato[0],
                $("#noContrato").val(),
                $("#fecCelebracion").val(),
                $("#descContrato").val(),
                $("#empresaRFC").val(),
                $("#numPadronContratista").val(),
                $("#empresaContrato").val(),
                $("#tipoContrato").val(),
                $("#modAdjContrato").val(),
                $("#montoContrato").val(),
                "",
                "",
                "0",
                $("#dispInmuContrato").val(),
                $("#motivosNoDispContrato").val(),
                $("#fecDisponibilidadInm").val(),
                $("#tipObrContr").val(),
                '<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>&nbsp;<span class="glyphicon glyphicon-edit" style="cursor:pointer;" onclick="alterContrato(this);" title="Editar"></span>&nbsp;<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="deleteContrato(this);" title="Eliminar"></span>',
                datosAnteriorContrato[18],
                datosAnteriorContrato[19],
                datosAnteriorContrato[20],
                datosAnteriorContrato[21],
                datosAnteriorContrato[22],
                $("#idRFC").val(),
                datosAnteriorContrato[24],
                datosAnteriorContrato[25],
                datosAnteriorContrato[26]
            ];
            tablaContratosReduccion.row(parseInt($("#indexTableContrato").val())).data(datosNew);
        } else {
            var newElem = [
                "",
                $("#noContrato").val(),
                $("#fecCelebracion").val(),
                $("#descContrato").val(),
                $("#empresaRFC").val(),
                $("#numPadronContratista").val(),
                $("#empresaContrato").val(),
                $("#tipoContrato").val(),
                $("#modAdjContrato").val(),
                $("#montoContrato").val(),
                "",
                "",
                "0",
                $("#dispInmuContrato").val(),
                $("#motivosNoDispContrato").val(),
                $("#fecDisponibilidadInm").val(),
                $("#tipObrContr").val(),
                '<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>&nbsp;<span class="glyphicon glyphicon-edit" style="cursor:pointer;" onclick="alterContrato(this);" title="Editar"></span>&nbsp;<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="deleteContrato(this);" title="Eliminar"></span>',
                [],
                "",
                "",
                [],
                ["", "", "", "", "", "", "", "", "", "", "", ""],
                $("#idRFC").val(),
                "0",
                "0.00",
                "0"
            ];
            if ($("#isConvenio").val() === "1") {
                newElem[24] = datosGlobalesSolicitud.idContratoReduccion;
            }
            var indexAgregado = tablaContratosReduccion.row.add(newElem).index();
            tablaContratosReduccion.cell(parseInt($("#indexTableContrato").val()), 24).data("?");
            tablaContratosReduccion.row(indexAgregado).nodes().to$().addClass("rowConvenioReduccion");
            tablaContratosReduccion.draw();
        }
        $("#modalAddConvenio").modal("hide");
        tablaContratosReduccion.draw();
        tablaContratosReduccion.column(0).visible(false);
        tablaContratosReduccion.column(3).visible(false);
        tablaContratosReduccion.column(4).visible(false);
        tablaContratosReduccion.column(5).visible(false);
        tablaContratosReduccion.column(7).visible(false);
        tablaContratosReduccion.column(8).visible(false);
        tablaContratosReduccion.column(10).visible(false);
        tablaContratosReduccion.column(11).visible(false);
        tablaContratosReduccion.column(12).visible(false);
        tablaContratosReduccion.column(13).visible(false);
        tablaContratosReduccion.column(14).visible(false);
        tablaContratosReduccion.column(15).visible(false);
        tablaContratosReduccion.column(16).visible(false);
        tablaContratosReduccion.column(18).visible(false);
        tablaContratosReduccion.column(19).visible(false);
        tablaContratosReduccion.column(20).visible(false);
        tablaContratosReduccion.column(21).visible(false);
        tablaContratosReduccion.column(22).visible(false);
        tablaContratosReduccion.column(23).visible(false);
        tablaContratosReduccion.column(24).visible(false);
        tablaContratosReduccion.column(25).visible(false);
        tablaContratosReduccion.column(26).visible(false);
        //$("#addConvenioReduccion").hide();
    } else {
        $("#modal2").find("[aria-invalid='true']:first").focus().each(function () {
            if ($(this).hasClass("fechaHoja4")) {
                $(this).datepicker("show");
            }
        });

    }
}

function alterContrato(elem) {
    $("#isEditContrato").val("1");
    $("#indexTableContrato").val(tablaContratosReduccion.row($(elem).parent().parent()).index());
    var contSelected = tablaContratosReduccion.row($(elem).parent().parent()).data();
    $("#idcontrato").val(contSelected[0]);
    $("#noContrato").val(contSelected[1]);
    $("#fecCelebracion").val(contSelected[2]).datepicker("update");
    $("#descContrato").val(contSelected[3]);
    $("#idRFC").val(contSelected[23]);
    $("#empresaRFC").val(contSelected[4]);
    $("#numPadronContratista").val("N/A");
    $("#empresaContrato").val(contSelected[6]);
    $("#tipoContrato").val(contSelected[7]);
    $("#modAdjContrato").val(contSelected[8]);
    $("#montoContrato").val(contSelected[9]);
    $("#dispInmuContrato").val(contSelected[13]).change();
    $("#motivosNoDispContrato").val(contSelected[14]);
    $("#fecDisponibilidadInm").val(contSelected[15]).datepicker("update");
    $("#tipObrContr").val(contSelected[16]);
    $("#modalAddConvenio").modal("show");
}

function deleteContrato(elem) {
    bootbox.confirm("\u00BFDesea eliminar?", function (result) {
        if (result) {
            var aPos = tablaContratosReduccion.row($(elem).parent().parent()).index();
            var dataSelected = tablaContratosReduccion.row($(elem).parent().parent()).data();
            if (dataSelected[0] !== "") {
                contratosEliminados.push({idContrato: dataSelected[0], programas: []});
            }
            var indexContratoPadre = tablaContratosReduccion.column(0).data().indexOf(dataSelected[24]);
            tablaContratosReduccion.cell(indexContratoPadre, 24).data("0");
            tablaContratosReduccion.row(aPos).remove().draw();
            $("#addConvenioReduccion").show();
            datosGlobalesSolicitud.idContratoReduccion = "";
        }
    });
}

function guardadoHoja4(callback) {
    if (datosGlobalesSolicitud.tiposolicitud === "4") {
        var contratosConConv = [];
        for (var i = 0; i < tablaContratosReduccion.column(0).data().length; i++) {
            if (tablaContratosReduccion.cell(i, 24).data() === "?") {
                tablaContratosReduccion.cell(i, 24).data("0");
                contratosConConv.push(i);
            }
            if (tablaContratosReduccion.cell(i, 10).data() === "00-00-0000") {
                tablaContratosReduccion.cell(i, 21).data("");
            }
        }
        $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {contratosEliminados: contratosEliminados, contratos: tablaContratosReduccion.data().toArray(), accion: 'guardaHoja4', idSol: datosGlobalesSolicitud.idsolicitud, tipSol: datosGlobalesSolicitud.tiposolicitud}, function (respuesta) {
//            console.log(respuesta);
            var data = $.parseJSON(respuesta);
            if (data.res === "correcto") {
                for (var i = 0; i < data.idsContratos.length; i++) {
                    tablaContratosReduccion.row(data.idsContratos[i].index).data()[0] = data.idsContratos[i].id;
                }
                contratosEliminados = [];
            }
            tablaContratosReduccion.draw();
            for (var i = 0; i < contratosConConv.length; i++) {
                tablaContratosReduccion.cell(contratosConConv[i], 24).data("?");
            }
            if (typeof (callback) === "function") {
                callback();
            }
        });
    }
}
