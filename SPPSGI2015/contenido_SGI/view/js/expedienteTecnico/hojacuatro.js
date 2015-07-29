/*
 @Control "Hoja 4"
 @version: 0.1      @modificado: 22 de Diciembre del 2014
 
 */

// variables globales pero solo para utilizar dentro de hoja4
var tablaHoja4;
var tablaHoja4Admin;
var tablaConceptosHoja4;
var tablaConceptosContratoHoja4;
var tablaContratosHoja4;
var datostablaeliminadoshoja4 = new Array();
var contratosEliminados = [];
var banderaAddRFC = false;
var indexUltimoContratoSelected = -1;
var conceptosSelectedHoja4 = new Array();
var contenidoPopoverAnti = "";
var tablaContratosToSelect;

// se carga cuando la pagina esta lista
$(document).ready(function () {
    cargarHoja4();
});

// seccion de funciones
function cargarHoja4() {
    //console.log("tipo solicitud trae: "+datosGlobalesSolicitud.tiposolicitud);
    $('.numerote').autoNumeric({aSep: '', mDec: 2, vMin: '0.00'});
    $('.porcentaje').autoNumeric({aSep: '', mDec: 5, vMin: '0.00000'});
    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $(".acumesfina").autoNumeric('init', {aSep: ',', mDec: 2});
    $(".acumesfinaAdmin").autoNumeric('init', {aSep: ',', mDec: 2});
    //$('#nocontrato').autoNumeric({aSep: '', mDec: 0, vMin: '0'});   

    var opcionesDataTable = {
        retrieve: true,
        searching: true,
        sPaginationType: "bootstrap",
        ordering: false,
        oLanguage: {
            sProcessing: "&nbsp; &nbsp; &nbsp;Procesando...",
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

    tablaHoja4 = $('#tabla1').DataTable(opcionesDataTable);
    tablaHoja4Admin = $('#tabla1Admin').DataTable(opcionesDataTable);
    tablaConceptosContratoHoja4 = $('#tablaConceptosContrato').DataTable(opcionesDataTable);

    $('#fecini').datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    }).on('changeDate', function (selected) {
        $('#fecfin').datepicker('setStartDate', new Date(selected.date.valueOf()));
    });

    $('#fecfin').datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    });

    jQuery.extend(jQuery.validator.messages, {
        number: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">No v\u00e1lido</div>',
        min: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">No v\u00e1lido</div>',
        required: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Campo requerido</div>'
    });

    jQuery.validator.addMethod("mayor", function (value, element) {
        if ($(element).val() > 100) {
            return false;
        } else if ($(element).val() === "" || $(element).val() <= 100) {
            return true;
        }
    });

    jQuery.validator.addClassRules("obligatorioHoja4", {
        required: true
    });

    $("#tabHoja4Admin li:eq(0) a").tab("show");

    $("#agregaconceptotraba").click(function () {
        if ($("#siAddRFC:visible").length === 0) {
            if ($("#modal2").find(".obligatorioHoja4:visible").valid()) {
                if ($("#isEditContrato").val() === "1") {
                    var datosAnteriorContrato = tablaContratosHoja4.row(parseInt($("#indexTableContrato").val())).data();
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
                        datosAnteriorContrato[9],
                        $("#fecInicioContr").val(),
                        $("#fecTerminoContr").val(),
                        $("#diasContrato").val(),
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
                    tablaContratosHoja4.row(parseInt($("#indexTableContrato").val())).data(datosNew);
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
                        $("#fecInicioContr").val(),
                        $("#fecTerminoContr").val(),
                        $("#diasContrato").val(),
                        $("#dispInmuContrato").val(),
                        $("#motivosNoDispContrato").val(),
                        $("#fecDisponibilidadInm").val(),
                        $("#tipObrContr").val(),
                        '<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>&nbsp;<span class="glyphicon glyphicon-edit" style="cursor:pointer;" onclick="alterContrato(this);" title="Editar"></span>&nbsp;<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="deleteContrato(this);" title="Eliminar"></span>',
                        [],
                        "",
                        "",
                        [],
                        [],
                        $("#idRFC").val(),
                        "0",
                        $("#montoContrato").val(),
                        "0"
                    ];
                    if ($("#isConvenio").val() === "1") {
                        newElem[24] = $("#idcontratoPadre").val();
                    }
                    var indexAgregado = tablaContratosHoja4.row.add(newElem).index();
                    tablaContratosHoja4.cell(indexAgregado, 9).nodes().to$().addClass("numero2");
                    if ($("#isConvenio").val() === "1") {
                        conceptosSelectedHoja4 = [];
                        var conceptoConvenio = [];
                        var montoConvenio = 0;
                        for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
                            if (tablaConceptos.row(i).data()[10] === "0" || tablaConceptos.row(i).data()[10] === "") {
                                conceptoConvenio.push([
                                    tablaConceptos.cell(i, 1).data(),
                                    tablaConceptos.cell(i, 2).data(),
                                    tablaConceptos.cell(i, 9).data(),
                                    tablaConceptos.cell(i, 8).data(),
                                    '<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="eliminarConceptoContrato(this);"></span>',
                                    i
                                ]);
                                montoConvenio += parseFloat(tablaConceptos.cell(i, 8).data());
                                conceptosSelectedHoja4.push(i);
                            }
                        }
//                        console.log("index contrato padre");
//                        console.log($("#indexTableContrato").val());
                        tablaContratosHoja4.cell(indexAgregado, 9).data(montoConvenio);
                        tablaContratosHoja4.cell($("#indexTableContrato").val(), 25).data(parseFloat(tablaContratosHoja4.cell($("#indexTableContrato").val(), 25).data()) + montoConvenio);
                        actualizarConceptosHoja3(indexAgregado);
                        tablaContratosHoja4.cell(indexAgregado, 18).data(conceptoConvenio);
                        tablaContratosHoja4.row(indexAgregado).nodes().to$().addClass("rowConvenio");
                        tablaContratosHoja4.draw();
                    }
                }

                $("#modal2").modal("hide");
                limpiar("modal2");
                tablaContratosHoja4.draw();
                tablaContratosHoja4.column(0).visible(false);
                tablaContratosHoja4.column(3).visible(false);
                tablaContratosHoja4.column(4).visible(false);
                tablaContratosHoja4.column(5).visible(false);
                tablaContratosHoja4.column(7).visible(false);
                tablaContratosHoja4.column(8).visible(false);
                tablaContratosHoja4.column(10).visible(false);
                tablaContratosHoja4.column(11).visible(false);
                tablaContratosHoja4.column(12).visible(false);
                tablaContratosHoja4.column(13).visible(false);
                tablaContratosHoja4.column(14).visible(false);
                tablaContratosHoja4.column(15).visible(false);
                tablaContratosHoja4.column(16).visible(false);
                tablaContratosHoja4.column(18).visible(false);
                tablaContratosHoja4.column(19).visible(false);
                tablaContratosHoja4.column(20).visible(false);
                tablaContratosHoja4.column(21).visible(false);
                tablaContratosHoja4.column(22).visible(false);
                tablaContratosHoja4.column(23).visible(false);
                tablaContratosHoja4.column(24).visible(false);
                tablaContratosHoja4.column(25).visible(false);
                tablaContratosHoja4.column(26).visible(false);
                $("#tableHoja4").find("[role='row'][class='odd'],[role='row'][class='even'],[role='row'][class='even rowConvenio'],[role='row'][class='odd rowConvenio'],[role='row'][class='rowConvenio even'],[role='row'][class='rowConvenio odd']").unbind("click").on("click", function () {
                    $("#divTabContratos").show();
                    $("#tabHoja4 li:eq(0) a").tab("show");
                    if (tablaContratosHoja4.cell(tablaContratosHoja4.row($(this)).index(), 24) !== "") {
                        $("#tabHoja4 li:eq(1)").show();
                        $("#tabHoja4 li:eq(2)").show();
                    }
                    muestraCalendariazcionContrato(tablaContratosHoja4.row($(this)).index());
                    //////////////////////////////////////////////////////////////////////////////////
                    var banderaAnticipoConvenio = true;
                    var indexSelected = tablaContratosHoja4.row($(this)).index();
                    if (tablaContratosHoja4.cell(indexSelected, 24).data() !== "") {
                        for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
//                        console.log("importe: "+tablaContratosHoja4.cell(i,20).data().importe);
//                        if (tablaContratosHoja4.cell(i,0).data() === tablaContratosHoja4.cell(indexSelected,24).data() && tablaContratosHoja4.cell(i,20).data().importe === "" && tablaContratosHoja4.cell(i,20).data().importe === "0.00") {
//                            console.log("entro a ocultar");
//                            banderaAnticipoConvenio = false;
//                            break;
//                        }
                            if (tablaContratosHoja4.cell(i, 0).data() === tablaContratosHoja4.cell(indexSelected, 24).data() && tablaContratosHoja4.cell(i, 20).data().importe !== "" && tablaContratosHoja4.cell(i, 20).data().importe !== "0.00") {
//                            console.log("entro a ocultar");
                                banderaAnticipoConvenio = false;
                                break;
                            }
                        }
                    }
                    if (!banderaAnticipoConvenio) {
                        $("#tabHoja4 li:eq(1)").hide();
                        $("#tabHoja4 li:eq(2)").hide();
                    } else {
                        $("#tabHoja4 li:eq(1)").show();
                        $("#tabHoja4 li:eq(2)").show();
                    }
//////////////////////////////////////////////////////////////////////////////////////////
                });
                $("#addConvenioHoja4").hide();
            } else {
                $("#modal2").find("[aria-invalid='true']:first").focus().each(function () {
                    if ($(this).hasClass("fechaHoja4")) {
                        $(this).datepicker("show");
                    }
                });

            }
        } else {
            $("#empresaRFC").focus();
        }
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    });


    $('#contrato,#ene,#feb,#mar,#abr,#may,#jun,#jul,#ago,#sep,#oct,#nov,#dic,#totaldecontra').unbind("change").on("change", function () {
        var valoresMesesHoja4 = obtenervaloresdemodalmodal1();
        var total = (valoresMesesHoja4.ene + valoresMesesHoja4.feb + valoresMesesHoja4.mar + valoresMesesHoja4.abr + valoresMesesHoja4.may + valoresMesesHoja4.jun + valoresMesesHoja4.jul + valoresMesesHoja4.ago + valoresMesesHoja4.sep + valoresMesesHoja4.oct + valoresMesesHoja4.nov + valoresMesesHoja4.dic);

        if (total > 100) {
            this.value = "";
            valoresMesesHoja4 = obtenervaloresdemodalmodal1();
            total = (valoresMesesHoja4.ene + valoresMesesHoja4.feb + valoresMesesHoja4.mar + valoresMesesHoja4.abr + valoresMesesHoja4.may + valoresMesesHoja4.jun + valoresMesesHoja4.jul + valoresMesesHoja4.ago + valoresMesesHoja4.sep + valoresMesesHoja4.oct + valoresMesesHoja4.nov + valoresMesesHoja4.dic);
            bootbox.alert("El total debe de ser menor a 100");
        }
        $("#totaldecontra").html(total+"%");
    });


    $('#mesene,#mesfeb,#mesmar,#mesabr,#mesmay,#mesjun,#mesjul,#mesago,#messep,#mesoct,#mesnov,#mesdic').unbind("change").on("change", function () {
        sumaAcumulado(indexUltimoContratoSelected, "contrato");
        asignaCalendarizadosToContrato();
    });

    $('#meseneAdmin,#mesfebAdmin,#mesmarAdmin,#mesabrAdmin,#mesmayAdmin,#mesjunAdmin,#mesjulAdmin,#mesagoAdmin,#messepAdmin,#mesoctAdmin,#mesnovAdmin,#mesdicAdmin').unbind("change").on("change", function () {
        sumaAcumulado(indexUltimoContratoSelected, "general");
        asignaCalendarizadosToContrato();
    });

    $("#rowGarantia,#rowGarantiaCump,#rowAnticipo").find("input,textarea").unbind("change").on("change", function () {
        asignaCalendarizadosToContrato();
    });

    $('#agregarcalendariodegasto').click(function () {

        var valoresP = valoresdePorcentaje();
        var totalporcentaje = (valoresP.porcientoene + valoresP.porcientofeb + valoresP.porcientomar + valoresP.porcientoabr + valoresP.porcientomay + valoresP.porcientojun + valoresP.porcientojul + valoresP.porcientoago + valoresP.porcientosep + valoresP.porcientooct + valoresP.porcientonov + valoresP.porcientodic);
        if (totalporcentaje > 100) {
            this.value = "";
            bootbox.alert("El porcentaje total es de " + totalporcentaje + " y debe de ser menor a 100");
        }
    });

    $("#agregamodal1").unbind("click").on("click", function () {
        var valoresMesHoja4 = obtenervaloresdemodalmodal1();
        var total = (valoresMesHoja4.ene + valoresMesHoja4.feb + valoresMesHoja4.mar + valoresMesHoja4.abr + valoresMesHoja4.may + valoresMesHoja4.jun + valoresMesHoja4.jul + valoresMesHoja4.ago + valoresMesHoja4.sep + valoresMesHoja4.oct + valoresMesHoja4.nov + valoresMesHoja4.dic);
        if ($("#contrato").valid() && total > 0 && total <= 100) {
            $("#totaldecontra").prev("div").remove();
            if (total <= 100) {
                if ($("#isEdit").val() === "0") {
                    var indexh4 = "";
                    if ($("#isAdmin").val() === "0") {
                        tablaHoja4.row.add([indexh4, $("#contrato").val(), valoresMesHoja4.ene, valoresMesHoja4.feb, valoresMesHoja4.mar, valoresMesHoja4.abr, valoresMesHoja4.may, valoresMesHoja4.jun, valoresMesHoja4.jul, valoresMesHoja4.ago, valoresMesHoja4.sep, valoresMesHoja4.oct, valoresMesHoja4.nov, valoresMesHoja4.dic, total, '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>']).draw();
                    } else {
                        tablaHoja4Admin.row.add([indexh4, $("#contrato").val(), valoresMesHoja4.ene, valoresMesHoja4.feb, valoresMesHoja4.mar, valoresMesHoja4.abr, valoresMesHoja4.may, valoresMesHoja4.jun, valoresMesHoja4.jul, valoresMesHoja4.ago, valoresMesHoja4.sep, valoresMesHoja4.oct, valoresMesHoja4.nov, valoresMesHoja4.dic, total, '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>']).draw();
                    }
                    $("#totaldecontra").html(total+"%");
                } else {
                    var index = parseInt($("#indexTable").val());
                    if ($("#isAdmin").val() === "0") {
                        tablaHoja4.row(index).data([$("#valIndex0").val(), $("#contrato").val(), valoresMesHoja4.ene, valoresMesHoja4.feb, valoresMesHoja4.mar, valoresMesHoja4.abr, valoresMesHoja4.may, valoresMesHoja4.jun, valoresMesHoja4.jul, valoresMesHoja4.ago, valoresMesHoja4.sep, valoresMesHoja4.oct, valoresMesHoja4.nov, valoresMesHoja4.dic, total, '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>']);
                        tablaHoja4.draw();
                    } else {
                        tablaHoja4Admin.row(index).data([$("#valIndex0").val(), $("#contrato").val(), valoresMesHoja4.ene, valoresMesHoja4.feb, valoresMesHoja4.mar, valoresMesHoja4.abr, valoresMesHoja4.may, valoresMesHoja4.jun, valoresMesHoja4.jul, valoresMesHoja4.ago, valoresMesHoja4.sep, valoresMesHoja4.oct, valoresMesHoja4.nov, valoresMesHoja4.dic, total, '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>']);
                        tablaHoja4Admin.draw();
                    }
                }
                limpiar("modal1");
                tablaHoja4.column(0).visible(false);
                tablaHoja4Admin.column(0).visible(false);
                $("#modal1").modal("hide");
            } else {
                $("#totaldecontra").before('<div class="alert alert-danger col-md-12" role="alert" style="position: absolute; z-index:1;">El total debe de ser menor a 100%</div>');
            }
        } else {
            if ($("#contrato").valid() && (total <= 0 || total > 100)) {
                $("#totaldecontra").before('<div class="alert alert-danger col-md-12" role="alert" style="position: absolute; z-index:1;">La suma debe ser mayor a 0% y menor a 100%</div>');
            }
        }
        $("#totaldecontra").html("0");
        asignaCalendarizadosToContrato();
    });

    $("#cancelarmodal1").click(function () {
        $("#totaldecontra").html('0');
    });

    $("#btnAddModal1").unbind("click").on("click", function () {
        $("#ene").keyup();
        $("#isEdit").val("0");
        $("#isAdmin").val("0");
        $("#modal1").modal({backdrop: true, keyboard: false});
    });

    $("#btnAddModal1Admin").unbind("click").on("click", function () {
        $("#ene").keyup();
        $("#isEdit").val("0");
        $("#isAdmin").val("1");
        $("#modal1").modal({backdrop: true, keyboard: false});
    });

    $("#tabla2").find(".numero2").removeAttr("disabled");

    $("#modal1").on('show.bs.modal', function (e) {
        if ($("#isEdit").val() === "1") {
            $("#agregamodal1").text("Actualizar");
        } else {
            $("#agregamodal1").text("Agregar");
        }
    });

    $("#addContratoHoja4").unbind("click").on("click", function () {
        limpiar("modal2");
        $("#isEditContrato").val("0");
        $("#isConvenio").val("0");
        $("#modal2").modal({backdrop: false, keyboard: false});
        $("#modal2").find('.modal-title').text('Datos generales del contrato');
//        console.log(datosGlobalesSolicitud);
        colocaInfoGlobaltoContrato();
        //console.log(datosGlobalesSolicitud.psolicitud !== "" ? datosGlobalesSolicitud.psolicitud.IdSol : 0);
    });

    tablaContratosHoja4 = $("#tableHoja4").DataTable(opcionesDataTable);

    $("#btnAddConcepto").unbind("click").on("click", function () {
        $("#modalConceptosContrato").modal({backdrop: false, keyboard: false});

    });

    tablaConceptosHoja4 = $("#tablaConceptosHoja4").DataTable(opcionesDataTable);

    $("#modalConceptosContrato").on('show.bs.modal', function (e) {
        tablaConceptosHoja4.clear();
        tablaConceptosHoja4.rows.add(tablaConceptos.data()).draw();
        tablaConceptosHoja4.column(0).visible(false);
        tablaConceptosHoja4.column(10).visible(false);
        tablaConceptosHoja4.column(12).visible(false);
        for (var i = 0; i < tablaConceptosHoja4.column(0).data().length; i++) {
            if (tablaConceptosHoja4.cell(i, 10).data() === "0") {
                tablaConceptosHoja4.cell(i, 11).data('<input type="checkbox" onChange="cambioConcepto(this);"/>');
            } else {
                tablaConceptosHoja4.cell(i, 11).data('');
            }
            tablaConceptosHoja4.cell(i, 4).nodes().to$().addClass("numero2");           
            tablaConceptosHoja4.cell(i, 5).nodes().to$().addClass("numero2");            
            tablaConceptosHoja4.cell(i, 6).nodes().to$().addClass("numero2");            
            tablaConceptosHoja4.cell(i, 7).nodes().to$().addClass("numero2");            
            tablaConceptosHoja4.cell(i, 8).nodes().to$().addClass("numero2");            
        }
        tablaConceptosHoja4.draw();
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    });

    $("#btnAcpetarConceptoContr").unbind("click").on("click", function () {
        actualizarConceptosHoja3(indexUltimoContratoSelected);
        tablaConceptosContratoHoja4.clear();
        var montoContrato = 0;
        for (var i = 0; i < conceptosSelectedHoja4.length; i++) {
            tablaConceptosContratoHoja4.row.add([
                tablaConceptos.cell(conceptosSelectedHoja4[i], 1).data(),
                tablaConceptos.cell(conceptosSelectedHoja4[i], 2).data(),
                tablaConceptos.cell(conceptosSelectedHoja4[i], 9).data(),
                tablaConceptos.cell(conceptosSelectedHoja4[i], 8).data(),
                '<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="eliminarConceptoContrato(this);"></span>',
                conceptosSelectedHoja4[i]
            ]);
            montoContrato += parseFloat(tablaConceptosContratoHoja4.cell(i, 3).data().replace(/,/g, ""));
            tablaConceptosContratoHoja4.cell(i, 3).nodes().to$().addClass("numero2");
        }
        tablaConceptosContratoHoja4.column(5).visible(false);
        tablaConceptosContratoHoja4.draw();
//        console.log(montoContrato);
        tablaContratosHoja4.cell(indexUltimoContratoSelected, 9).data(montoContrato).draw();
        tablaContratosHoja4.cell(indexUltimoContratoSelected, 25).data(montoContrato).draw();
        $("#importeGarantiaCump").val(parseFloat(tablaContratosHoja4.row(indexUltimoContratoSelected).data()[9]) * 0.1);
        $("#modalConceptosContrato").modal("hide");
        asignaCalendarizadosToContrato();
        tablaContratosHoja4.draw();
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
        $('.numero2').autoNumeric("update");
    });

    $(".fechaHoja4").datepicker({
        language: "es",
        weekStart: 1, format: "dd-mm-yyyy",
        autoclose: true
    });

    $("#fecInicioContr").unbind("changeDate").on("changeDate", function (selected) {
        if (selected.date) {
            $("#fecTerminoContr").datepicker('setStartDate', new Date(selected.date.valueOf()));
            $("#fecTerminoContr").datepicker('setDate', new Date(selected.date.valueOf()));
            $("#fecTerminoContr").datepicker('update');
        }
    });

    $("#fecTerminoContr").unbind("changeDate").on("changeDate", function (selected) {
        if (selected.date) {
            var fechaInicio = new Date($("#fecInicioContr").datepicker("getDate"));
            var fechaTermino = new Date(selected.date);
            var tiempo = fechaTermino.getTime() - fechaInicio.getTime();
            var dias = Math.floor(tiempo / (1000 * 60 * 60 * 24));
            //console.log(dias);
            $("#diasContrato").val(dias);
        } else {
            $("#diasContrato").val("");
        }
    });

    $("#dispInmuContrato").unbind("change").on("change", function () {
        if ($(this).val() === "0") {
            $("#rowMotivos").show();
        } else {
            $("#rowMotivos").hide();
            $("#motivosNoDispContrato").val("");
            $("#fecDisponibilidadInm").val("");
            $("#fecDisponibilidadInm").datepicker("update");
        }
    });

    $("#montoAntiContr").unbind("change").on("change", function () {
        $("#isAutorizedAnticipo").val("0");
        cambioMontoAnticipo(indexUltimoContratoSelected, "monto");
    });

    $("#btnCancelConceptoContr").unbind("click").on("click", function () {
        conceptosSelectedHoja4 = new Array();
        $("#modalConceptosContrato").modal("hide");
    });

    $("#empresaRFC").unbind("change").on("change", function () {
        $("#empresaRFC").val($.trim($("#empresaRFC").val()).toUpperCase());
        $("#idRFC").val("");
        $("#numPadronContratista").val("");
        $("#empresaContrato").val("");
        buscaRFCEmpresa($.trim($(this).val()));
    });

    $("#startPlazoGarantia").unbind("changeDate").on("changeDate", function (selected) {
        if (selected.date) {
            $("#endPlazoGarantia").datepicker('setStartDate', new Date(selected.date.valueOf()));
            $("#endPlazoGarantia").datepicker('setDate', new Date(selected.date.valueOf()));
            $("#endPlazoGarantia").datepicker('update');
        } else {
            $("#endPlazoGarantia").val("");
            $("#endPlazoGarantia").datepicker('update');
        }
    });

    $("#tabHoja4 li:eq(0) a").tab("show");

    $("#btonCerrarDetalleContr").unbind("click").on("click", function () {
        $("#modalDetalleContrato").modal("hide");
    });

    $("#popRFC").popover({
        html: true,
        animation: true,
        trigger: "manual",
        content: "<p style='width: 150px;'>\u00BFDesea agregar la empresa?</p><p><span id='siAddRFC' class='btn btn-default'>S\u00ed</span>&nbsp;&nbsp;&nbsp;<span id='noAddRFC' class='btn btn-default'>No</span></p>"
    });

    $("#popAnticipo").popover({
        html: true,
        animation: true,
        trigger: "manual",
        placement: "top"
                //content: contenidoPopoverAnti
//        content: "<p style='width: 150px;'>\u00BFDesea agregar la empresa?</p><p><span id='siAddRFC' class='btn btn-default'>S\u00ed</span>&nbsp;&nbsp;&nbsp;<span id='noAddRFC' class='btn btn-default'>No</span></p>"
    });

    $('#popRFC').on('shown.bs.popover', function () {
        $("#siAddRFC").unbind("click").on("click", function () {
            banderaAddRFC = true;
            $("#popRFC").popover("hide");
        });
        $("#noAddRFC").unbind("click").on("click", function () {
            banderaAddRFC = false;
            $("#empresaRFC").val("");
            $("#numPadronContratista").val("");
            $("#empresaContrato").val("");
            $("#popRFC").popover("hide");
        });
    });

    bootbox.setDefaults({locale: "es"});

    $("#importeGarantia").unbind("change").on("change", function () {
        $("#montoAntiContr").val("").change();
        $("#montoAntiContr").autoNumeric("update");
        asignaCalendarizadosToContrato();
    });

    $("#addConvenioHoja4").unbind("click").on("click", function () {
        tablaContratosToSelect.clear();
        for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
            if (tablaContratosHoja4.cell(i, 24).data() === null || tablaContratosHoja4.cell(i, 24).data() === "" || tablaContratosHoja4.cell(i, 24).data() === "0") {
                tablaContratosToSelect.row.add([
                    tablaContratosHoja4.cell(i, 1).data(),
                    tablaContratosHoja4.cell(i, 2).data(),
                    tablaContratosHoja4.cell(i, 6).data(),
                    tablaContratosHoja4.cell(i, 9).data(),
                    '<input type="radio" name="contSelected" value="' + i + '"/>'
                ]);
                tablaContratosToSelect.cell(i, 3).nodes().to$().addClass("numero2");
            }
        }
        tablaContratosToSelect.draw();
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
        $("#modalSeleccionContrato").modal("show");
    });

    tablaContratosToSelect = $("#tablaContratosToSelect").DataTable(opcionesDataTable);

    $("#btnAceptarContratoSelected").unbind("click").on("click", function () {
        if ($("input[name='contSelected']:checked").val()) {
            $("#modalSeleccionContrato").modal("hide");
            muestraInfoParaConvenio($("input[name='contSelected']:checked").val());
        } else {
            bootbox.alert("Seleccione un contrato");
        }
    });

    $("#startPlazoGarantiaCump").unbind("changeDate").on("changeDate", function (selected) {
        if (selected.date) {
            $("#endPlazoGarantiaCump").datepicker('setStartDate', new Date(selected.date.valueOf()));
            $("#endPlazoGarantiaCump").datepicker('setDate', new Date(selected.date.valueOf()));
            $("#endPlazoGarantiaCump").datepicker('update');
        }
    });

    $("#pjeAntiContr").unbind("change").on("change", function () {
        if ($(this).val() !== "") {
            var valPje = parseFloat($(this).val());
            var montoMasIVA = parseFloat(tablaContratosHoja4.row(indexUltimoContratoSelected).data()[9] !== "" ? tablaContratosHoja4.row(indexUltimoContratoSelected).data()[9] : "0");
            $("#montoAntiContr").val(((valPje * montoMasIVA) / 100).toFixed(2));
            cambioMontoAnticipo(indexUltimoContratoSelected, "pje");
            asignaCalendarizadosToContrato();
            $('.numero2').autoNumeric("update");
        }
    });
}

function hoja4Sol1and3() {
    $("#rowContratos").hide();
    $("#rowConceptos").hide();
    $("#rowAnticipo").hide();
    $("#rowGarantia").hide();
    $("#rowGarantiaCump").hide();
    $("#divTabContratos").show();
    $(".contratoSelected").text("N/A");
    $("#tabHoja4 li:lt(4)").hide();
    $("#tabHoja4 li:eq(4) a").click();
}

function hoja4Sol2() {
    $("#rowContratos").show();
    $("#rowConceptos").show();
    $("#rowAnticipo").show();
    $("#rowGarantia").show();
    $("#rowGarantiaCump").show();
    $(".contratoSelected").text("");
    $("#tabHoja4 li:lt(3)").show();
    $("#tabHoja4 li:eq(0) a").click();
    $("#addConvenioHoja4").hide();
    $("#addContratoHoja4").show();
    if ((datosGlobalesSolicitud.psolicitud !== "" && ($("#myTab li:last a").text() === "Observaciones"))) {
//        for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
//            tablaContratosHoja4.cell(i, 17).data('<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>');
//        }
        tablaContratosHoja4.draw();
        tablaConceptosContratoHoja4.column(4).visible(false);
        $("#addContratoHoja4").hide();
    }   
    if(datosGlobalesSolicitud.psolicitud.IdEdoSol === "3" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "4"){
        $("#addContratoHoja4").hide();
    }
}

function hoja4Sol12() {
    $("#rowContratos").show();
    $("#rowConceptos").show();
    $("#rowAnticipo").show();
    $("#rowGarantia").show();
    $("#rowGarantiaCump").show();
    $(".contratoSelected").text("");
    $("#tabHoja4 li:lt(3)").show();
    $("#tabHoja4 li:eq(0) a").click();
    $("#btnAddConcepto").hide();
    $("#addContratoHoja4").hide();
    $("#addConvenioHoja4").show();
//    for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
//        tablaContratosHoja4.cell(i, 17).data('<span class="glyphicon glyphicon-list-alt" style="cursor:pointer;" onclick="detallesConceptoContrato(this);" title="Ver m\u00e1s"></span>');
//    }
    tablaContratosHoja4.draw();
    tablaConceptosContratoHoja4.column(4).visible(false);
    $("#addContratoHoja4").hide();
}

function hoja4Sol10and11and13() {
    $("#rowContratos").hide();
    $("#rowConceptos").show();
    $("#rowAnticipo").show();
    $("#rowGarantia").show();
    $("#rowGarantiaCump").show();
    $(".contratoSelected").text("");
    $("#tabHoja4 li:lt(3)").show();
    $("#tabHoja4 li:eq(0) a").click();
    $("#btnAddConcepto").show();
    $("#addContratoHoja4").show();
    $("#addConvenioHoja4").hide();
    $("#divTabContratosAdmin").show();
}

function colocaInfoGlobaltoContrato() {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: "getOficioAsignacionObr", idObr: datosGlobalesSolicitud.psolicitud.IdObr}, function (data) {
//        console.log(data);
        var res = $.parseJSON(data);
        $("#numOfiAsiContrato").text(res.CveOfi);
        $("#fecOfiAsiContrato").text(res.FecOfi);
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
    });
}

function validaContratos() {
    $("#tableHoja4").find(".popError").removeAttr("title").removeAttr("data-content").removeAttr("aria-describedby").removeClass("popError");
    var respuesta = {correcto: true, error: {mostrarMensaje: false}};
    for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
        if (tablaContratosHoja4.row(i).data()[18].length === 0) {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe seleccionar al menos un concepto para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[19].folioCump === "") {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe ingresar el folio de la garant\u00eda de cumplimiento para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[19].fechaEmisionCump === "") {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe ingresar la fecha de emisi\u00f3n de la garant\u00eda de cumplimiento para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[19].importeCump === "") {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe ingresar el importe de la garant\u00eda de cumplimiento para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[19].inicioPlazoCump === "") {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe ingresar la fecha de inicio de la garant\u00eda de cumplimiento para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[19].finPlazoCump === "") {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe ingresar la fecha de t\u00e9rmino de la garant\u00eda de cumplimiento para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else if (tablaContratosHoja4.row(i).data()[20].importe !== "" && parseFloat(tablaContratosHoja4.row(i).data()[20].importe) !== 0) {
            if (tablaContratosHoja4.row(i).data()[20].bndAnticipo === "1" && $.trim(tablaContratosHoja4.row(i).data()[20].motivos) === "") {
                respuesta.correcto = false;
                respuesta.error.mostrarMensaje = true;
                tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Ingrese los motivos del porcentaje de anticipo para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
                $(".popError").popover({html: true,
                    animation: true,
                    trigger: "manual",
                    placement: "top"
                });
                break;
            } else if (tablaContratosHoja4.row(i).data()[20].bndAnticipo === "2" && tablaContratosHoja4.row(i).data()[20].autorizado === "0") {
                respuesta.correcto = false;
                respuesta.error.mostrarMensaje = true;
                tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "El porcentaje del anticipo debe ser autorizado por una autoridad para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
                $(".popError").popover({html: true,
                    animation: true,
                    trigger: "manual",
                    placement: "top"
                });
                break;
            } else if (tablaContratosHoja4.row(i).data()[20].bndAnticipo === "2" && tablaContratosHoja4.row(i).data()[20].autorizado === "1" && $.trim(tablaContratosHoja4.row(i).data()[20].motivos) === "") {
                respuesta.correcto = false;
                respuesta.error.mostrarMensaje = true;
                tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Ingrese los motivos del porcentaje de anticipo para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
                $(".popError").popover({html: true,
                    animation: true,
                    trigger: "manual",
                    placement: "top"
                });
                break;
            }
        } else if (tablaContratosHoja4.row(i).data()[21].length === 0) {
            respuesta.correcto = false;
            respuesta.error.mostrarMensaje = true;
            tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe registrar por lo menos un avance f\u00edsico para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
            $(".popError").popover({html: true,
                animation: true,
                trigger: "manual",
                placement: "top"
            });
            break;
        } else {
            var noAvaFina = true;
            for (var j = 0; j < tablaContratosHoja4.row(i).data()[22].length; j++) {
                var valor = isNaN(tablaContratosHoja4.row(i).data()[22][j]) ? 0.00 : parseFloat(tablaContratosHoja4.row(i).data()[22][j]);
                if (valor > 0.00) {
                    noAvaFina = false;
                }
            }
            if (noAvaFina) {
                respuesta.correcto = false;
                respuesta.error.mostrarMensaje = true;
                tablaContratosHoja4.row(i).nodes().to$().addClass("popError").attr("title", "Error").attr("data-content", "Se debe registrar el avance financiero para el contrato: " + tablaContratosHoja4.cell(i, 1).data());
                $(".popError").popover({html: true,
                    animation: true,
                    trigger: "manual",
                    placement: "top"
                });
                break;
            } else {
                respuesta.correcto = true;
            }
        }
    }
    return respuesta;
}

function muestraInfoParaConvenio(index) {
    if (validaConceptosParaConvenio()) {
        var datosSel = tablaContratosHoja4.row(index).data();
        $("#isConvenio").val("1");
        $("#indexTableContrato").val(index);
        $("#isEditContrato").val("0");
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
        $("#modal2").find('.modal-title').text('Datos generales del convenio');
        $("#modal2").modal("show");
    } else {
        bootbox.alert("No se puede crear el convenio, no hay conceptos nuevos");
    }
}

function validaConceptosParaConvenio() {
    var banderaNuevo = false;
    for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
        if (tablaConceptos.row(i).data()[10] === "" || tablaConceptos.row(i).data()[10] === "0") {
            banderaNuevo = true;
        }
    }
    return banderaNuevo;
}

function alterContrato(elem) {
    $("#isEditContrato").val("1");
    $("#indexTableContrato").val(tablaContratosHoja4.row($(elem).parent().parent()).index());
    var contSelected = tablaContratosHoja4.row($(elem).parent().parent()).data();
    $("#idcontrato").val(contSelected[0]);
    $("#noContrato").val(contSelected[1]);
    $("#fecCelebracion").val(contSelected[2]).datepicker("update");
    $("#descContrato").val(contSelected[3]);
    $("#idRFC").val(contSelected[23]);
    $("#empresaRFC").val(contSelected[4]);
    $("#numPadronContratista").val(contSelected[5]);
    $("#empresaContrato").val(contSelected[6]);
    $("#tipoContrato").val(contSelected[7]);
    $("#modAdjContrato").val(contSelected[8]);
    $("#montoContrato").val(contSelected[9]);
    $("#fecInicioContr").val(contSelected[10]).datepicker("update");
    $("#fecTerminoContr").val(contSelected[11]).datepicker("update");
    $("#diasContrato").val(contSelected[12]);
    $("#dispInmuContrato").val(contSelected[13]).change();
    $("#motivosNoDispContrato").val(contSelected[14]);
    $("#fecDisponibilidadInm").val(contSelected[15]).datepicker("update");
    $("#tipObrContr").val(contSelected[16]);
    $("#modal2").modal("show");
    $('.numero2').autoNumeric("update");
}

function cambioMontoAnticipo(index, origen) {
    var montoMasIVA = parseFloat(tablaContratosHoja4.row(index).data()[9] !== "" ? tablaContratosHoja4.row(index).data()[9] : "0");
    if (parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") <= parseFloat($("#importeGarantia").val() !== "" ? $("#importeGarantia").val().replace(/,/g, "") : "0")) {
        if (parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") > (montoMasIVA * 0.30) && parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") <= (montoMasIVA * 0.50)) {
            $("#rowMotivosPjeMayor").show();
            $("#montoAntiContr").removeClass("alert alert-danger");
            $("#montoAntiContr").addClass("alert alert-warning");
            $("#montoAntiContr").removeAttr("title");
            $("#popAnticipo").attr("data-content", "<p style='width: 150px;' role='alert' class='alert alert-warning'>El monto del anticipo supera el 30% del monto del contrato, indique los motivos</p>");
            $("#popAnticipo").popover("show");
            $("#closePopAnti").unbind("click").on("click", function () {
                $("#popAnticipo").popover("hide");
            });
            $("#bndAnticipo").val("1");
        } else if (parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") > (montoMasIVA * 0.50) && parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") <= montoMasIVA) {
            $("#rowMotivosPjeMayor").show();
            $("#montoAntiContr").removeClass("alert alert-warning");
            $("#montoAntiContr").addClass("alert alert-danger");
            $("#montoAntiContr").attr("title", "Anticipo no autorizado");
            $("#popAnticipo").attr("data-content", "<p style='width: 244px;' role='alert' class='alert alert-danger'>El monto del anticipo supera el 50% del monto del contrato, se requiere autorizaci\u00f3n de una autoridad</p><p id='mensajePopAnti' role='alert' class='alert alert-danger' style='display: none;'></p><p><div class='input-group'><span class='input-group-addon' id='basic-addon1'>Usuario:</span><input type='text' class='form-control' id='usuarioAutAnti' name='usuarioAutAnti' /></div></p><p><div class='input-group'><span class='input-group-addon' id='basic-addon1'>Contrase\u00f1a:</span><input type='password' class='form-control' id='passAutAnti' name='passAutAnti' /></div></p><p style='text-align: right;'><span class='btn btn-success' id='bntAceptarAut'>Aceptar</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-default' id='bntCancelarAut'>Cancelar</span></p>");
            $("#popAnticipo").popover("show");
            $("#usuarioAutAnti").unbind("click").on("click", function () {
                $("#usuarioAutAnti").popover("hide");
            });
            $("#closePopAnti").unbind("click").on("click", function () {
                $("#popAnticipo").popover("hide");
            });
            $("#bndAnticipo").val("2");
            $("#bntCancelarAut").unbind("click").on("click", function () {
                $("#popAnticipo").popover("hide");
                $("#montoAntiContr").val("0.00");
                $("#pjeAntiContr").val("0.00");
                $("#montoAntiContr").removeClass("alert alert-warning");
                $("#montoAntiContr").removeClass("alert alert-danger");
                $("#rowMotivosPjeMayor").hide();
            });
            $("#bntAceptarAut").unbind("click").on("click", function () {
                $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {usuario: $.trim($("#usuarioAutAnti").val()), pass: $("#passAutAnti").val(), accion: 'verificaAutorizacion'}, function (data) {
                    if (data === "0") {
                        $("#usuarioAutAnti").popover({html: true,
                            animation: true,
                            trigger: "manual",
                            placement: "right"});
                        $("#usuarioAutAnti").attr("title", "Aviso");
                        $("#usuarioAutAnti").attr("data-content", "Datos incorrectos, no autorizado, intente de nuevo");
                        $("#usuarioAutAnti").popover("show");
                    } else {
                        $("#usuarioAutAnti").popover("hide");
                        $("#usuarioAutAnti").removeAttr("title");
                        $("#usuarioAutAnti").removeAttr("data-content");
                        $("#usuarioAutAnti").popover("destroy");
                        $("#montoAntiContr").removeClass("alert");
                        $("#montoAntiContr").attr("title", "Anticipo autorizado");
                        $("#popAnticipo").popover("hide");
                        $("#isAutorizedAnticipo").val(data);
                    }
                    asignaCalendarizadosToContrato();
                });
            });
        } else {
            $("#montoAntiContr").removeClass("alert alert-warning");
            $("#montoAntiContr").removeClass("alert alert-danger");
            $("#motivosPjeMayorContrato").val("");
            $("#rowMotivosPjeMayor").hide();
            $("#popAnticipo").popover("hide");
            $("#bndAnticipo").val("0");
        }
    } else {
        $("#popAnticipo").attr("data-content", "<p style='width: 150px;'>El anticipo no puede superar el monto de la garant\u00eda</p>");
        $("#popAnticipo").popover("show");
        $("#montoAntiContr").val("");
    }
    if (origen !== "pje") {
        calculaPje(index);
    }
    asignaCalendarizadosToContrato();
}

function detallesConceptoContrato(elem) {
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: "getOficioAsignacionObr", idObr: datosGlobalesSolicitud.psolicitud.IdObr}, function (data) {
        var res = $.parseJSON(data);
        $("#numOfiAsiContratoC").text(res.CveOfi);
        $("#fecOfiAsiContratoC").text(res.FecOfi);
        var aPos = tablaContratosHoja4.row($(elem).parent().parent()).index();
        //console.log(aPos);
        var dataSelected = tablaContratosHoja4.row(aPos).data();
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
        $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
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
    });
}

function buscaRFCEmpresa(rfcEmpresa) {
    $("#popRFC").popover("hide");
    if ($.trim(rfcEmpresa) !== "") {
        $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {rfcEmpresa: $.trim(rfcEmpresa), accion: 'consultaRFC'}, function (respuesta) {
//            console.log(respuesta);
            var data = $.parseJSON(respuesta);
            if (data.length > 0) {
                $("#idRFC").val(data[0].idEmp);
                $("#empresaContrato").val(data[0].NomEmp);
                $("#numPadronContratista").val(data[0].padronContr);
                banderaAddRFC = false;
            } else {
                setTimeout(function () {
                    $("#popRFC").popover("show");
                }, 100)
            }
        });
    }
}

function editaAvaFis(elem) {
    var aPos;
    var dataSelected;
    if ($(elem).parents("table").attr("id") !== "tabla1Admin") {
        aPos = tablaHoja4.row($(elem).parent().parent()).index();
        dataSelected = tablaHoja4.row(aPos).data();
        $("#isAdmin").val("0");
    } else {
        aPos = tablaHoja4Admin.row($(elem).parent().parent()).index();
        dataSelected = tablaHoja4Admin.row(aPos).data();
        $("#isAdmin").val("1");
    }
    asignarvaloresdemodalmodal1(dataSelected[1], dataSelected[2], dataSelected[3], dataSelected[4], dataSelected[5], dataSelected[6], dataSelected[7], dataSelected[8], dataSelected[9], dataSelected[10], dataSelected[11], dataSelected[12], dataSelected[13], dataSelected[14]);

    var valoresMeses = obtenervaloresdemodalmodal1();
    var total = (valoresMeses.ene + valoresMeses.feb + valoresMeses.mar + valoresMeses.abr + valoresMeses.may + valoresMeses.jun + valoresMeses.jul + valoresMeses.ago + valoresMeses.sep + valoresMeses.oct + valoresMeses.nov + valoresMeses.dic);
    $("#totaldecontra").html(total+"%");
    $("#isEdit").val("1");
    $("#indexTable").val(aPos);
    $("#valIndex0").val(dataSelected[0]);
    $("#modal1").modal("show");
}

function eliminaAvaFis(elem) {
    bootbox.confirm("\u00BFDesea eliminar?", function (result) {
        if (result) {
            var aPos;
            var dataSelected;
            if ($(elem).parents("table").attr("id") !== "tabla1Admin") {
                aPos = tablaHoja4.row($(elem).parent().parent()).index();
                dataSelected = tablaHoja4.row(aPos).data();
                if (dataSelected[0] !== "") {
                    datostablaeliminadoshoja4.push(dataSelected[0]);
                }
                tablaHoja4.row(aPos).remove().draw();
            } else {
                aPos = tablaHoja4Admin.row($(elem).parent().parent()).index();
                dataSelected = tablaHoja4Admin.row(aPos).data();
                if (dataSelected[0] !== "") {
                    datostablaeliminadoshoja4.push(dataSelected[0]);
                }
                tablaHoja4Admin.row(aPos).remove().draw();
            }
            asignaCalendarizadosToContrato();
        }
    });
}

function eliminarConceptoContrato(elem) {
    bootbox.confirm("\u00BFDesea eliminar?", function (result) {
        if (result) {
            var index = tablaConceptosContratoHoja4.row($(elem).parent().parent()).index();
            var montoContrato = tablaContratosHoja4.cell(indexUltimoContratoSelected, 9).data();
            montoContrato -= parseFloat(tablaConceptosContratoHoja4.cell(index, 3).data());
            tablaConceptos.cell(tablaConceptosContratoHoja4.cell(index, 5).data(), 10).data("0").draw();
            var indexTemp = $.inArray(tablaConceptosContratoHoja4.cell(index, 5).data(), conceptosSelectedHoja4);
            conceptosSelectedHoja4.splice(indexTemp, 1);
            tablaContratosHoja4.cell(indexUltimoContratoSelected, 9).data(montoContrato).draw();
            $("#importeGarantiaCump").val(parseFloat(tablaContratosHoja4.row(indexUltimoContratoSelected).data()[9]) * 0.1);
            tablaConceptosContratoHoja4.row(index).remove().draw();
            asignaCalendarizadosToContrato();
        }
    });
}

function actualizarConceptosHoja3(index) {
    for (var i = 0; i < conceptosSelectedHoja4.length; i++) {
        tablaConceptos.cell(conceptosSelectedHoja4[i], 10).data("tmp" + index).draw();
    }
}

function cambioConcepto(elem) {
    var index = tablaConceptosHoja4.row($(elem).parent().parent()).index();
    if ($(elem).prop("checked")) {
        conceptosSelectedHoja4.push(index);
    } else {
        var indexTemp = $.inArray(index, conceptosSelectedHoja4);
        conceptosSelectedHoja4.splice(indexTemp, 1);
    }
    //console.log(conceptosSelectedHoja4);
}

function valoresdePorcentaje() {
    var valoresPorcentaje = {
        porcientoene: parseInt($('#porcientoene').val()),
        porcientofeb: parseInt($('#porcientofeb').val()),
        porcientomar: parseInt($('#porcientomar').val()),
        porcientoabr: parseInt($('#porcientoabr').val()),
        porcientomay: parseInt($('#porcientomay').val()),
        porcientojun: parseInt($('#porcientojun').val()),
        porcientojul: parseInt($('#porcientojul').val()),
        porcientoago: parseInt($('#porcientoago').val()),
        porcientosep: parseInt($('#porcientosep').val()),
        porcientooct: parseInt($('#porcientooct').val()),
        porcientonov: parseInt($('#porcientonov').val()),
        porcientodic: parseInt($('#porcientodic').val())
    };
    return valoresPorcentaje;
}

function sumaAcumulado(index, tipo) {
    var acumulados = obtenerValoresdeMeses(tipo);
    var totalFuentes = 0;
    for (var i = 0; i < datosGlobalesSolicitud.fuentes.length; i++) {
        totalFuentes += parseFloat(datosGlobalesSolicitud.fuentes[i][1]);
    }
    console.log("totalFuentes");
    console.log(totalFuentes);
    console.log("datosGlobalesSolicitud.fuentes");
    console.log(datosGlobalesSolicitud.fuentes);
    for (var i = 0; i < 12; i++) {
        if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {
            if (acumulados[i] > totalFuentes) {
                bootbox.alert("Excediste el Total = $<b class='numero2'>" + totalFuentes + "</b> del Presupuesto");
                if (i > 0) {
                    $(".montoMesFina:gt( " + (i - 1) + " )").val("0");
                } else {
                    $(".montoMesFina:eq( 0 )").val("0");
                    $(".montoMesFina:gt( 0 )").val("0");
                }
                acumulados = obtenerValoresdeMeses(tipo);
                $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
                $(".acumesfina:gt( " + i + " )").html(acumulados[i]);
                break;
            }
            $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
        } else if (datosGlobalesSolicitud.tiposolicitud === "2" || datosGlobalesSolicitud.tiposolicitud === "12") {
            if (acumulados[i] > tablaContratosHoja4.row(index).data()[9]) {
                bootbox.alert("Excediste el Total = $<b class='numero2'>" + tablaContratosHoja4.row(index).data()[9] + "</b> del Presupuesto");
                if (i > 0) {
                    $(".montoMesFina:gt( " + (i - 1) + " )").val("0");
                } else {
                    $(".montoMesFina:eq( 0 )").val("0");
                    $(".montoMesFina:gt( 0 )").val("0");
                }
                acumulados = obtenerValoresdeMeses(tipo);
                $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
                $(".acumesfina:gt( " + i + " )").html(acumulados[i]);
                break;
            }
            $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
        } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
            if (tipo === "general") {
                if (acumulados[i] > totalFuentes) {
                    bootbox.alert("Excediste el Total = $<b class='numero2'>" + totalFuentes + "</b> del Presupuesto");
                    if (i > 0) {
                        $(".montoMesFinaAdmin:gt( " + (i - 1) + " )").val("0");
                    } else {
                        $(".montoMesFinaAdmin:eq( 0 )").val("0");
                        $(".montoMesFinaAdmin:gt( 0 )").val("0");
                    }
                    acumulados = obtenerValoresdeMeses(tipo);
                    $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
                    $(".acumesfina:gt( " + i + " )").html(acumulados[i]);
                    break;
                }
                $(".acumesfinaAdmin:eq( " + i + " )").html(acumulados[i]);
            } else {
                if (acumulados[i] > tablaContratosHoja4.row(index).data()[9]) {
                    bootbox.alert("Excediste el Total = $<b class='numero2'>" + tablaContratosHoja4.row(index).data()[9] + "</b> del Presupuesto");
                    if (i > 0) {
                        $(".montoMesFina:gt( " + (i - 1) + " )").val("0");
                    } else {
                        $(".montoMesFina:eq( 0 )").val("0");
                        $(".montoMesFina:gt( 0 )").val("0");
                    }
                    acumulados = obtenerValoresdeMeses(tipo);
                    $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
                    $(".acumesfina:gt( " + i + " )").html(acumulados[i]);
                    break;
                }
                $(".acumesfina:eq( " + i + " )").html(acumulados[i]);
            }
        }
    }
    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    $(".numero2").autoNumeric("update");
    if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {
        var porcentajesAcu = new Array();
        for (var i = 0; i < 12; i++) {
            porcentajesAcu.push(((acumulados[i] * 100) / totalFuentes).toFixed(5));
            $('.pjeAcuFina:eq(' + i + ')').html(porcentajesAcu[i]);
        }
        $(".acumesfina").autoNumeric("update");
    } else if (datosGlobalesSolicitud.tiposolicitud === "2" || datosGlobalesSolicitud.tiposolicitud === "12") {
        var porcentajesAcu = new Array();
        for (var i = 0; i < 12; i++) {
            if (tablaContratosHoja4.row(index).data()[9] !== "") {
                porcentajesAcu.push(((acumulados[i] * 100) / tablaContratosHoja4.row(index).data()[9]).toFixed(5));
                $('.pjeAcuFina:eq(' + i + ')').html(porcentajesAcu[i]);
            } else {
                $('.pjeAcuFina:eq(' + i + ')').html("0.00");
            }
        }
        $(".acumesfina").autoNumeric("update");
    } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
        if (tipo === "contrato") {
            var porcentajesAcu = new Array();
            for (var i = 0; i < 12; i++) {
                if (tablaContratosHoja4.row(index).data()[9] !== "") {
                    porcentajesAcu.push(((acumulados[i] * 100) / tablaContratosHoja4.row(index).data()[9]).toFixed(5));
                    $('.pjeAcuFina:eq(' + i + ')').html(porcentajesAcu[i]);
                } else {
                    $('.pjeAcuFina:eq(' + i + ')').html("0.00");
                }
            }
            $(".acumesfina").autoNumeric("update");
        } else {
            var porcentajesAcu = new Array();
            for (var i = 0; i < 12; i++) {
                porcentajesAcu.push(((acumulados[i] * 100) / totalFuentes).toFixed(5));
                $('.pjeAcuFinaAdmin:eq(' + i + ')').html(porcentajesAcu[i]);
            }
            $(".acumesfinaAdmin").autoNumeric("update");
        }
    }
}

function obtenerValoresdeMeses(tipo) {
    var acumulados = [];
    var valoresMeses;
    if (tipo === "contrato") {
        valoresMeses = {
            mesene: $.trim($('#mesene').val()) !== "" ? parseFloat($('#mesene').val().replace(/,/g, "")) : 0,
            mesfeb: $.trim($('#mesfeb').val()) !== "" ? parseFloat($('#mesfeb').val().replace(/,/g, "")) : 0,
            mesmar: $.trim($('#mesmar').val()) !== "" ? parseFloat($('#mesmar').val().replace(/,/g, "")) : 0,
            mesabr: $.trim($('#mesabr').val()) !== "" ? parseFloat($('#mesabr').val().replace(/,/g, "")) : 0,
            mesmay: $.trim($('#mesmay').val()) !== "" ? parseFloat($('#mesmay').val().replace(/,/g, "")) : 0,
            mesjun: $.trim($('#mesjun').val()) !== "" ? parseFloat($('#mesjun').val().replace(/,/g, "")) : 0,
            mesjul: $.trim($('#mesjul').val()) !== "" ? parseFloat($('#mesjul').val().replace(/,/g, "")) : 0,
            mesago: $.trim($('#mesago').val()) !== "" ? parseFloat($('#mesago').val().replace(/,/g, "")) : 0,
            messep: $.trim($('#messep').val()) !== "" ? parseFloat($('#messep').val().replace(/,/g, "")) : 0,
            mesoct: $.trim($('#mesoct').val()) !== "" ? parseFloat($('#mesoct').val().replace(/,/g, "")) : 0,
            mesnov: $.trim($('#mesnov').val()) !== "" ? parseFloat($('#mesnov').val().replace(/,/g, "")) : 0,
            mesdic: $.trim($('#mesdic').val()) !== "" ? parseFloat($('#mesdic').val().replace(/,/g, "")) : 0
        };
    } else {
        valoresMeses = {
            mesene: $.trim($('#meseneAdmin').val()) !== "" ? parseFloat($('#meseneAdmin').val().replace(/,/g, "")) : 0,
            mesfeb: $.trim($('#mesfebAdmin').val()) !== "" ? parseFloat($('#mesfebAdmin').val().replace(/,/g, "")) : 0,
            mesmar: $.trim($('#mesmarAdmin').val()) !== "" ? parseFloat($('#mesmarAdmin').val().replace(/,/g, "")) : 0,
            mesabr: $.trim($('#mesabrAdmin').val()) !== "" ? parseFloat($('#mesabrAdmin').val().replace(/,/g, "")) : 0,
            mesmay: $.trim($('#mesmayAdmin').val()) !== "" ? parseFloat($('#mesmayAdmin').val().replace(/,/g, "")) : 0,
            mesjun: $.trim($('#mesjunAdmin').val()) !== "" ? parseFloat($('#mesjunAdmin').val().replace(/,/g, "")) : 0,
            mesjul: $.trim($('#mesjulAdmin').val()) !== "" ? parseFloat($('#mesjulAdmin').val().replace(/,/g, "")) : 0,
            mesago: $.trim($('#mesagoAdmin').val()) !== "" ? parseFloat($('#mesagoAdmin').val().replace(/,/g, "")) : 0,
            messep: $.trim($('#messepAdmin').val()) !== "" ? parseFloat($('#messepAdmin').val().replace(/,/g, "")) : 0,
            mesoct: $.trim($('#mesoctAdmin').val()) !== "" ? parseFloat($('#mesoctAdmin').val().replace(/,/g, "")) : 0,
            mesnov: $.trim($('#mesnovAdmin').val()) !== "" ? parseFloat($('#mesnovAdmin').val().replace(/,/g, "")) : 0,
            mesdic: $.trim($('#mesdicAdmin').val()) !== "" ? parseFloat($('#mesdicAdmin').val().replace(/,/g, "")) : 0
        };
    }
    acumulados.push(valoresMeses.mesene);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct + valoresMeses.mesnov);
    acumulados.push(valoresMeses.mesene + valoresMeses.mesfeb + valoresMeses.mesmar + valoresMeses.mesabr + valoresMeses.mesmay + valoresMeses.mesjun + valoresMeses.mesjul + valoresMeses.mesago + valoresMeses.messep + valoresMeses.mesoct + valoresMeses.mesnov + valoresMeses.mesdic);
    return acumulados;
}

function obtenervaloresdemodalmodal1() {
    var valoresModal1 = {
        ene: parseFloat($('#ene').val() !== "" ? $('#ene').val() : "0"),
        feb: parseFloat($('#feb').val() !== "" ? $('#feb').val() : "0"),
        mar: parseFloat($('#mar').val() !== "" ? $('#mar').val() : "0"),
        abr: parseFloat($('#abr').val() !== "" ? $('#abr').val() : "0"),
        may: parseFloat($('#may').val() !== "" ? $('#may').val() : "0"),
        jun: parseFloat($('#jun').val() !== "" ? $('#jun').val() : "0"),
        jul: parseFloat($('#jul').val() !== "" ? $('#jul').val() : "0"),
        ago: parseFloat($('#ago').val() !== "" ? $('#ago').val() : "0"),
        sep: parseFloat($('#sep').val() !== "" ? $('#sep').val() : "0"),
        oct: parseFloat($('#oct').val() !== "" ? $('#oct').val() : "0"),
        nov: parseFloat($('#nov').val() !== "" ? $('#nov').val() : "0"),
        dic: parseFloat($('#dic').val() !== "" ? $('#dic').val() : "0")
    };
    return valoresModal1;
}

function asignarvaloresdemodalmodal1(dato1, dato2, dato3, dato4, dato5, dato6, dato7, dato8, dato9, dato10, dato11, dato12, dato13) {
    $('#contrato').val(dato1);
    $('#ene').val(dato2);
    $('#feb').val(dato3);
    $('#mar').val(dato4);
    $('#abr').val(dato5);
    $('#may').val(dato6);
    $('#jun').val(dato7);
    $('#jul').val(dato8);
    $('#ago').val(dato9);
    $('#sep').val(dato10);
    $('#oct').val(dato11);
    $('#nov').val(dato12);
    $('#dic').val(dato13);
}

function listadeDatosPrograma(idprogh4h, priconcp, priene, prifeb, primar, priabr, primay, prijun, prijul, priago, prisep, prioct, prinov, pridic, pritotal) {
    this.idprogh4h = idprogh4h;
    this.priconcp = priconcp;
    this.priene = priene;
    this.prifeb = prifeb;
    this.primar = primar;
    this.priabr = priabr;
    this.primay = primay;
    this.prijun = prijun;
    this.prijul = prijul;
    this.priago = priago;
    this.prisep = prisep;
    this.prioct = prioct;
    this.prinov = prinov;
    this.pridic = pridic;
    this.pritotal = pritotal;
}

function listadeDatoscalendario(calene, calfeb, calmar, calabr, calmay, caljun, caljul, calago, calsep, caloct, calnov, caldic) {
    this.calene = calene;
    this.calfeb = calfeb;
    this.primar = calmar;
    this.calabr = calabr;
    this.calmay = calmay;
    this.caljun = caljun;
    this.caljul = caljul;
    this.calago = calago;
    this.calsep = calsep;
    this.caloct = caloct;
    this.calnov = calnov;
    this.caldic = caldic;
}

function listadeDatoscontrato(idcontrah4he, numcontra, imptcontra, finicontra, ffincontra) {
    this.idcontrah4he = idcontrah4he;
    this.numcontra = numcontra;
    this.imptcontra = imptcontra;
    this.finicontra = finicontra;
    this.ffincontra = ffincontra;
}

function guardadoHoja4(callback) {
    if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {//guardado cuando es asignacion inicial        
        $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {trabajosFisicos: datosGlobalesSolicitud.avancesFisicos, trabajosEliminados: datostablaeliminadoshoja4, avanceFinanciero: datosGlobalesSolicitud.avancesFinancieros, accion: 'guardaHoja4', idSol: datosGlobalesSolicitud.idsolicitud, tipSol: datosGlobalesSolicitud.tiposolicitud}, function (respuesta) {
//            console.log(respuesta);
            var data = $.parseJSON(respuesta);
            if (data.idProgramas) {
                for (var i = 0; i < data.idProgramas.length; i++) {
                    tablaHoja4.cell(data.idProgramas[i].index, 0).data(data.idProgramas[i].id);
                }
            }
            tablaHoja4.draw();
            asignaCalendarizadosToContrato();
            datostablaeliminadoshoja4 = new Array();
            if (typeof (callback) === "function") {
                callback();
            }
        });
    } else if (datosGlobalesSolicitud.tiposolicitud === "2" || datosGlobalesSolicitud.tiposolicitud === "12") {
//        console.log("tablaContratosHoja4.data().toArray()");
//        console.log(tablaContratosHoja4.data().toArray());
//        console.log("contratosEliminados");
//        console.log(contratosEliminados);
        $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {contratosEliminados: contratosEliminados, contratos: tablaContratosHoja4.data().toArray(), accion: 'guardaHoja4', idSol: datosGlobalesSolicitud.idsolicitud, tipSol: datosGlobalesSolicitud.tiposolicitud}, function (respuesta) {
//            console.log("aqui guardado de hoja 4");
//            console.log(respuesta);
//            console.log("hasta aqui guardado de hoja 4");
            var data = $.parseJSON(respuesta);
            if (data.res === "correcto") {
                if (data.idsContratos) {
                    for (var i = 0; i < data.idsContratos.length; i++) {
                        tablaContratosHoja4.row(data.idsContratos[i].index).data()[0] = data.idsContratos[i].id;
                        for (var j = 0; j < data.idsContratos[i].idsTrabajos.length; j++) {
                            tablaContratosHoja4.row(data.idsContratos[i].index).data()[21][data.idsContratos[i].idsTrabajos[j].index][0] = data.idsContratos[i].idsTrabajos[j].id;
                        }
                        for (var j = 0; j < tablaContratosHoja4.cell(data.idsContratos[i].index, 18).data().length; j++) {
                            tablaConceptos.row(tablaContratosHoja4.cell(data.idsContratos[i].index, 18).data()[j][5]).data()[10] = data.idsContratos[i].id;
                        }
                    }
                }
                contratosEliminados = [];
            }
            if (typeof (callback) === "function") {
                callback();
            }
        });
    } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
        var msj = "";
        var banderaAntMay = true;
        for (var i = 0; i < tablaContratosHoja4.column(0).data().length; i++) {
            var valorImporte = (tablaContratosHoja4.cell(i, 20).data()).importe;
            var valorTreinta = (tablaContratosHoja4.cell(i, 9).data()) * 0.30;
            var valorCincuenta = (tablaContratosHoja4.cell(i, 9).data()) * 0.50;
            if ((tablaContratosHoja4.cell(i, 20).data()).motivos === "" && valorImporte > valorTreinta || valorImporte > valorCincuenta) {
//                console.log(tablaContratosHoja4.cell(i, 1).data());
                msj = "Favor de capturar motivos de anticipo del contrato No. " + tablaContratosHoja4.cell(i, 1).data();
                banderaAntMay = false;
            }
        }
        if (!banderaAntMay) {
            bootbox.alert(msj);
        } else {
            $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {trabajosFisicos: datosGlobalesSolicitud.avancesFisicos, trabajosEliminados: datostablaeliminadoshoja4, avanceFinanciero: datosGlobalesSolicitud.avancesFinancieros, accion: 'guardaHoja4', idSol: datosGlobalesSolicitud.idsolicitud, tipSol: datosGlobalesSolicitud.tiposolicitud}, function (respuesta) {
                var data = $.parseJSON(respuesta);
                if (data.idProgramas) {
                    for (var i = 0; i < data.idProgramas.length; i++) {
                        tablaHoja4Admin.cell(data.idProgramas[i].index, 0).data(data.idProgramas[i].id);
                    }
                }
                tablaHoja4Admin.draw();
//                asignaCalendarizadosToContrato();
                datostablaeliminadoshoja4 = new Array();
                $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {contratosEliminados: contratosEliminados, contratos: tablaContratosHoja4.data().toArray(), accion: 'guardaHoja4', idSol: datosGlobalesSolicitud.idsolicitud, tipSol: datosGlobalesSolicitud.tiposolicitud}, function (resp) {
                    var datos = $.parseJSON(resp);
                    if (datos.res === "correcto" && datos.idsContratos) {
                        for (var i = 0; i < datos.idsContratos.length; i++) {
                            tablaContratosHoja4.row(datos.idsContratos[i].index).data()[0] = datos.idsContratos[i].id;
                            for (var j = 0; j < datos.idsContratos[i].idsTrabajos.length; j++) {
                                tablaContratosHoja4.row(datos.idsContratos[i].index).data()[21][datos.idsContratos[i].idsTrabajos[j].index][0] = datos.idsContratos[i].idsTrabajos[j].id;
                            }
                            for (var j = 0; j < tablaContratosHoja4.cell(datos.idsContratos[i].index, 18).data().length; j++) {
                                tablaConceptos.row(tablaContratosHoja4.cell(datos.idsContratos[i].index, 18).data()[j][5]).data()[10] = datos.idsContratos[i].id;
                            }
                        }
                        contratosEliminados = [];
                    }
                    if (typeof (callback) === "function") {
                        callback();
                    }
                });
            });
        }

    }
    tablaContratosHoja4.draw();
    tablaConceptos.draw();
}

function limpiar(limformularios) {
    $("#" + limformularios + " :input").each(function () {
        $(this).val('');
    });
}

function cargaInfContratosTrabajosCalen() {
    tablaContratosHoja4.clear().draw();
    tablaHoja4.clear().draw();
    tablaHoja4Admin.clear().draw();
    tablaConceptosHoja4.clear().draw();
    tablaConceptosContratoHoja4.clear().draw();
    if (datosGlobalesSolicitud.idsolicitud !== "") {
        colocaWaitGeneral();
        $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {idSol: datosGlobalesSolicitud.idsolicitud, tipoSolicitud: datosGlobalesSolicitud.tiposolicitud, accion: "getDatosHoja4"}, function (data) {
            var datosHoja4 = $.parseJSON(data);
//            console.log(datosHoja4);
            if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {
                datosGlobalesSolicitud.avancesFisicos = datosHoja4.trabajos;
                datosGlobalesSolicitud.avancesFinancieros = datosHoja4.avanceFinancieros;
                datosHoja4 = null;
                if (datosGlobalesSolicitud.avancesFisicos !== "" && datosGlobalesSolicitud.avancesFisicos && datosGlobalesSolicitud.avancesFisicos.length > 0) {
                    tablaHoja4.rows.add(datosGlobalesSolicitud.avancesFisicos).draw();
                }

                tablaHoja4.column(0).visible(false);
                tablaHoja4.draw();
                for (var i = 0; i < 12; i++) {
                    $(".montoMesFina:eq(" + i + ")").val(datosGlobalesSolicitud.avancesFinancieros[0][i]);
                }
                sumaAcumulado(indexUltimoContratoSelected, "contrato");
            } else if (datosGlobalesSolicitud.tiposolicitud === "2" || datosGlobalesSolicitud.tiposolicitud === "12") {
//                console.log(datosHoja4);
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
                        [],
                        {folio: datosHoja4.contratos[i].folioGar, fechaEmision: datosHoja4.contratos[i].fecEmisGar, importe: datosHoja4.contratos[i].importeGar, inicioPlazo: datosHoja4.contratos[i].fecIniGar, finPlazo: datosHoja4.contratos[i].fecFinGar, folioCump: datosHoja4.contratos[i].folioGarCump, fechaEmisionCump: datosHoja4.contratos[i].fecEmisGarCump, importeCump: datosHoja4.contratos[i].importeGarCump, inicioPlazoCump: datosHoja4.contratos[i].fecIniGarCump, finPlazoCump: datosHoja4.contratos[i].fecFinGarCump},
                        {importe: datosHoja4.contratos[i].importeAnti, porcentaje: datosHoja4.contratos[i].pjeAnti, motivos: datosHoja4.contratos[i].motivImporte, formaPago: datosHoja4.contratos[i].formaPagoAnti, bndAnticipo: "0", autorizado: "1"},
                        [],
                        [],
                        datosHoja4.contratos[i].idEmp,
                        datosHoja4.contratos[i].contratoPadre,
                        datosHoja4.contratos[i].montoAutActual,
                        datosHoja4.contratos[i].estatus
                    ];
                    if (parseFloat(datosHoja4.contratos[i].pjeAnti) > 30.00000 && parseFloat(datosHoja4.contratos[i].pjeAnti) <= 50.000000) {
                        contratoNuevo[20].bndAnticipo = "1";
                    } else if (parseFloat(datosHoja4.contratos[i].pjeAnti) > 50) {
                        contratoNuevo[20].bndAnticipo = "2";
                        contratoNuevo[20].autorizado = "1";
                    } else {
                        contratoNuevo[20].bndAnticipo = "0";
                        contratoNuevo[20].autorizado = "1";
                    }
                    var conceptosCont = [];
                    var opcionesConcepto = "";
                    if ((datosGlobalesSolicitud.psolicitud.IdEdoSol === "2" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "5") && datosHoja4.contratos[i].estatus === "0") {
                        opcionesConcepto = '<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="eliminarConceptoContrato(this);"></span>';
                    } else {
                        opcionesConcepto = '';
                    }
                    tablaConceptos.column(10).data().each(function (value, index) {
                        if (value === datosHoja4.contratos[i].idContrato) {
                            conceptosCont.push([tablaConceptos.row(index).data()[1],
                                tablaConceptos.row(index).data()[2],
                                tablaConceptos.row(index).data()[9],
                                tablaConceptos.row(index).data()[8],
                                opcionesConcepto,
                                index
                            ]);
                        }
                    });
                    contratoNuevo[18] = conceptosCont;
                    var avaFisHoja4 = [];
                    var opcionesProgramas = "";
                    if ((datosGlobalesSolicitud.psolicitud.IdEdoSol === "2" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "5") && datosHoja4.contratos[i].estatus === "0") {
                        opcionesProgramas = '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>';
                    } else {
                        opcionesProgramas = '';
                    }
                    for (var j = 0; j < datosHoja4.contratos[i].programas.length; j++) {
                        datosHoja4.contratos[i].programas[j][15] = opcionesProgramas;
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
                    tablaContratosHoja4.row.add(contratoNuevo);
                    tablaContratosHoja4.draw();
                    if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] !== "00-00-0000") {
                        tablaContratosHoja4.row(i).nodes().to$().addClass("rowConvenio");
                    }
                    if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] === "00-00-0000") {
                        tablaContratosHoja4.row(i).nodes().to$().addClass("rowConvenioReduccion");
                    }
                    tablaContratosHoja4.cell(i, 9).nodes().to$().addClass("numero2");
                    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
                }
                tablaContratosHoja4.draw();
                tablaContratosHoja4.column(0).visible(false);
                tablaContratosHoja4.column(3).visible(false);
                tablaContratosHoja4.column(4).visible(false);
                tablaContratosHoja4.column(5).visible(false);
                tablaContratosHoja4.column(7).visible(false);
                tablaContratosHoja4.column(8).visible(false);
                tablaContratosHoja4.column(10).visible(false);
                tablaContratosHoja4.column(11).visible(false);
                tablaContratosHoja4.column(12).visible(false);
                tablaContratosHoja4.column(13).visible(false);
                tablaContratosHoja4.column(14).visible(false);
                tablaContratosHoja4.column(15).visible(false);
                tablaContratosHoja4.column(16).visible(false);
                tablaContratosHoja4.column(18).visible(false);
                tablaContratosHoja4.column(19).visible(false);
                tablaContratosHoja4.column(20).visible(false);
                tablaContratosHoja4.column(21).visible(false);
                tablaContratosHoja4.column(22).visible(false);
                tablaContratosHoja4.column(23).visible(false);
                tablaContratosHoja4.column(24).visible(false);
                tablaContratosHoja4.column(25).visible(false);
                tablaContratosHoja4.column(26).visible(false);
                $("#tableHoja4").find("[role='row'][class='odd'],[role='row'][class='even'],[role='row'][class='even rowConvenio'],[role='row'][class='odd rowConvenio'],[role='row'][class='rowConvenio even'],[role='row'][class='rowConvenio odd']").unbind("click").on("click", function () {
                    $("#divTabContratos").show();
                    $("#tabHoja4 li:eq(0) a").tab("show");
                    muestraCalendariazcionContrato(tablaContratosHoja4.row($(this)).index());
                });
            } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
                datosGlobalesSolicitud.avancesFisicos = datosHoja4.trabajos;
                datosGlobalesSolicitud.avancesFinancieros = datosHoja4.avanceFinancieros;
                tablaHoja4Admin.rows.add(datosGlobalesSolicitud.avancesFisicos).draw();
                tablaHoja4Admin.column(0).visible(false);
                tablaHoja4Admin.draw();
                for (var i = 0; i < 12; i++) {
                    $(".montoMesFinaAdmin:eq(" + i + ")").val(datosGlobalesSolicitud.avancesFinancieros[0][i]);
                }
                sumaAcumulado(indexUltimoContratoSelected, "general");
                var contratoNuevo;
                var opciones;
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
                        [],
                        {folio: datosHoja4.contratos[i].folioGar, fechaEmision: datosHoja4.contratos[i].fecEmisGar, importe: datosHoja4.contratos[i].importeGar, inicioPlazo: datosHoja4.contratos[i].fecIniGar, finPlazo: datosHoja4.contratos[i].fecFinGar, folioCump: datosHoja4.contratos[i].folioGarCump, fechaEmisionCump: datosHoja4.contratos[i].fecEmisGarCump, importeCump: datosHoja4.contratos[i].importeGarCump, inicioPlazoCump: datosHoja4.contratos[i].fecIniGarCump, finPlazoCump: datosHoja4.contratos[i].fecFinGarCump},
                        {importe: datosHoja4.contratos[i].importeAnti, porcentaje: datosHoja4.contratos[i].pjeAnti, motivos: datosHoja4.contratos[i].motivImporte, formaPago: datosHoja4.contratos[i].formaPagoAnti},
                        [],
                        [],
                        datosHoja4.contratos[i].idEmp,
                        datosHoja4.contratos[i].contratoPadre,
                        datosHoja4.contratos[i].montoAutActual,
                        datosHoja4.contratos[i].estatus
                    ];
                    var conceptosCont = [];
                    var opcionesConcepto = "";
                    if ((datosGlobalesSolicitud.psolicitud.IdEdoSol === "2" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "5") && datosHoja4.contratos[i].estatus === "0") {
                        opcionesConcepto = '<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onclick="eliminarConceptoContrato(this);"></span>';
                    } else {
                        opcionesConcepto = '';
                    }
                    tablaConceptos.column(10).data().each(function (value, index) {
                        if (value === datosHoja4.contratos[i].idContrato) {
                            conceptosCont.push([tablaConceptos.row(index).data()[1],
                                tablaConceptos.row(index).data()[2],
                                tablaConceptos.row(index).data()[9],
                                tablaConceptos.row(index).data()[8],
                                opcionesConcepto,
                                index
                            ]);
                        }
                    });
                    contratoNuevo[18] = conceptosCont;
                    var avaFisHoja4 = [];
                    var opcionesProgramas = "";
                    if ((datosGlobalesSolicitud.psolicitud.IdEdoSol === "2" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "5") && datosHoja4.contratos[i].estatus === "0") {
                        opcionesProgramas = '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>';
                    } else {
                        opcionesProgramas = '';
                    }
                    for (var j = 0; j < datosHoja4.contratos[i].programas.length; j++) {
                        datosHoja4.contratos[i].programas[j][15] = opcionesProgramas;
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
                    tablaContratosHoja4.row.add(contratoNuevo);
                    tablaContratosHoja4.draw();
                    if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] !== "00-00-0000") {
                        tablaContratosHoja4.row(i).nodes().to$().addClass("rowConvenio");
                    }
                    if (contratoNuevo[24] && contratoNuevo[24] !== "0" && contratoNuevo[24] !== "" && contratoNuevo[10] !== "" && contratoNuevo[10] === "00-00-0000") {
                        tablaContratosHoja4.row(i).nodes().to$().addClass("rowConvenioReduccion");
                    }
                    tablaContratosHoja4.cell(i, 9).nodes().to$().addClass("numero2");
                    $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
                }
                tablaContratosHoja4.draw();
                tablaContratosHoja4.column(0).visible(false);
                tablaContratosHoja4.column(3).visible(false);
                tablaContratosHoja4.column(4).visible(false);
                tablaContratosHoja4.column(5).visible(false);
                tablaContratosHoja4.column(7).visible(false);
                tablaContratosHoja4.column(8).visible(false);
                tablaContratosHoja4.column(10).visible(false);
                tablaContratosHoja4.column(11).visible(false);
                tablaContratosHoja4.column(12).visible(false);
                tablaContratosHoja4.column(13).visible(false);
                tablaContratosHoja4.column(14).visible(false);
                tablaContratosHoja4.column(15).visible(false);
                tablaContratosHoja4.column(16).visible(false);
                tablaContratosHoja4.column(18).visible(false);
                tablaContratosHoja4.column(19).visible(false);
                tablaContratosHoja4.column(20).visible(false);
                tablaContratosHoja4.column(21).visible(false);
                tablaContratosHoja4.column(22).visible(false);
                tablaContratosHoja4.column(23).visible(false);
                tablaContratosHoja4.column(24).visible(false);
                tablaContratosHoja4.column(25).visible(false);
                tablaContratosHoja4.column(26).visible(false);
                $("#tableHoja4").find("[role='row'][class='odd'],[role='row'][class='even'],[role='row'][class='even rowConvenio'],[role='row'][class='odd rowConvenio'],[role='row'][class='rowConvenio even'],[role='row'][class='rowConvenio odd']").unbind("click").on("click", function () {
                    $("#divTabContratos").show();
                    $("#tabHoja4 li:eq(0) a").tab("show");
                    muestraCalendariazcionContrato(tablaContratosHoja4.row($(this)).index());
                });
            }
            if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {
                hoja4Sol1and3();
            } else if (datosGlobalesSolicitud.tiposolicitud === "2") {
                hoja4Sol2();
            } else if (datosGlobalesSolicitud.tiposolicitud === "12") {
                hoja4Sol12();
            } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
                hoja4Sol10and11and13();
            }
            eliminaWaitGeneral();
        });
    }
    $.post("contenido_sgi/controller/expedienteTecnico/expedienteTecnicoController.php", {accion: "combosContratos"}, function (data) {
//        console.log(data);
        var combos = $.parseJSON(data);
        $("#tipoContrato").html(combos["tipos"]);
        $("#modAdjContrato").html(combos["modAdj"]);
        $("#tipObrContr").html(combos["tipObrContr"]);
    });
}

function deleteContrato(elem) {
    bootbox.confirm("\u00BFDesea eliminar?", function (result) {
        if (result) {
            var aPos = tablaContratosHoja4.row($(elem).parent().parent()).index();
            var dataSelected = tablaContratosHoja4.row(aPos).data();
            for (var i = 0; i < dataSelected[18].length; i++) {
                tablaConceptos.row(dataSelected[18][i][5]).data()[10] = "0";
            }
            tablaConceptos.draw();
            var programasEliminados = [];
            for (var i = 0; i < dataSelected[21].length; i++) {
                if (dataSelected[21][i][0] !== "") {
                    programasEliminados.push(dataSelected[21][i][0]);
                }
            }
            if (dataSelected[0] !== "") {
                contratosEliminados.push({idContrato: dataSelected[0], programas: programasEliminados});
            }
            tablaContratosHoja4.row(aPos).remove().draw();
            $("#divTabContratos").hide();
            if (datosGlobalesSolicitud.tiposolicitud === "12") {
                $("#addConvenioHoja4").show();
            }
            if (dataSelected[24] && dataSelected[24] !== "" && dataSelected[24] !== "0") {
                var indexContratoPadre = tablaContratosHoja4.column(0).data().indexOf(dataSelected[24]);
                tablaContratosHoja4.cell(indexContratoPadre, 25).data(parseFloat(tablaContratosHoja4.cell(indexContratoPadre, 25).data()) - parseFloat(dataSelected[9]));
                tablaContratosHoja4.draw();
            }
        }
    });
}
function muestraCalendariazcionContrato(index) {
    $(".contratoSelected").text(tablaContratosHoja4.row(index).data()[1]);
    var camposMeses = ["mesene", "mesfeb", "mesmar", "mesabr", "mesmay", "mesjun", "mesjul", "mesago", "messep", "mesoct", "mesnov", "mesdic"];
    if (index !== indexUltimoContratoSelected) {
        conceptosSelectedHoja4 = new Array();
        if (indexUltimoContratoSelected > -1) {
            asignaCalendarizadosToContrato();
        }
        if (tablaContratosHoja4.row(index).data()[18].length > 0) {
            tablaConceptosContratoHoja4.clear().draw();
            tablaConceptosContratoHoja4.rows.add(tablaContratosHoja4.row(index).data()[18]).draw();
            for (var i = 0; i < tablaConceptosContratoHoja4.column(0).data().length; i++) {
                conceptosSelectedHoja4.push(tablaConceptosContratoHoja4.cell(i, 5).data());
                tablaConceptosContratoHoja4.cell(i, 3).nodes().to$().addClass("numero2");
                $('.numero2').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
            }
        } else {
            tablaConceptosContratoHoja4.clear().draw();
        }
        if (tablaContratosHoja4.row(index).data()[19] !== "") {
            $("#folioGarantia").val((tablaContratosHoja4.row(index).data()[19]).folio);
            $("#fecGarantia").val((tablaContratosHoja4.row(index).data()[19]).fechaEmision);
            $("#importeGarantia").val((tablaContratosHoja4.row(index).data()[19]).importe);
            $("#startPlazoGarantia").val((tablaContratosHoja4.row(index).data()[19]).inicioPlazo);
            $("#endPlazoGarantia").val((tablaContratosHoja4.row(index).data()[19]).finPlazo);
            $("#folioGarantiaCump").val((tablaContratosHoja4.row(index).data()[19]).folioCump);
            $("#fecGarantiaCump").val((tablaContratosHoja4.row(index).data()[19]).fechaEmisionCump);
            $("#importeGarantiaCump").val((tablaContratosHoja4.row(index).data()[19]).importeCump);
            $("#startPlazoGarantiaCump").val((tablaContratosHoja4.row(index).data()[19]).inicioPlazoCump);
            $("#endPlazoGarantiaCump").val((tablaContratosHoja4.row(index).data()[19]).finPlazoCump);
        } else {
            $("#folioGarantia").val("");
            $("#fecGarantia").val("");
            $("#importeGarantia").val("");
            $("#startPlazoGarantia").val("");
            $("#endPlazoGarantia").val("");
            $("#folioGarantiaCump").val("");
            $("#fecGarantiaCump").val("");
            $("#startPlazoGarantiaCump").val("");
            $("#endPlazoGarantiaCump").val("");
            $("#importeGarantiaCump").val(parseFloat(tablaContratosHoja4.row(index).data()[9]) * 0.1);
        }
        if (tablaContratosHoja4.row(index).data()[20] !== "") {
            $("#montoAntiContr").val((tablaContratosHoja4.row(index).data()[20]).importe);
            $("#pjeAntiContr").val((tablaContratosHoja4.row(index).data()[20]).porcentaje);
            $("#motivosPjeMayorContrato").val((tablaContratosHoja4.row(index).data()[20]).motivos);
//            calculaPje(index);
            $("#formaPagoAnticipoContrato").val((tablaContratosHoja4.row(index).data()[20]).formaPago);
            $("#bndAnticipo").val((tablaContratosHoja4.row(index).data()[20]).bndAnticipo);
            $("#isAutorizedAnticipo").val((tablaContratosHoja4.row(index).data()[20]).autorizado);
            if (tablaContratosHoja4.row(index).data()[20].bndAnticipo === "1" || tablaContratosHoja4.row(index).data()[20].bndAnticipo === "2") {
                $("#rowMotivosPjeMayor").show();
            } else {
                $("#rowMotivosPjeMayor").hide();
            }
        } else {
            $("#montoAntiContr").val("");
            $("#pjeAntiContr").val("");
            $("#motivosPjeMayorContrato").val("");
            $("#formaPagoAnticipoContrato").val("");
            $("#bndAnticipo").val("0");
            $("#isAutorizedAnticipo").val("0");
        }
        if (tablaContratosHoja4.row(index).data()[21].length > 0) {
            tablaHoja4.clear().draw();
            tablaHoja4.rows.add(tablaContratosHoja4.row(index).data()[21]).draw();
        } else {
            tablaHoja4.clear().draw();
        }
        if (tablaContratosHoja4.row(index).data()[22].length > 0) {
            for (var i = 0; i < 12; i++) {
                $("#" + camposMeses[i]).val(tablaContratosHoja4.row(index).data()[22][i]);
            }
        } else {
            for (var i = 0; i < 12; i++) {
                $("#" + camposMeses[i]).val("");
            }
        }
        sumaAcumulado(index, "contrato");
        tablaHoja4.column(0).visible(false);
        tablaConceptosContratoHoja4.column(5).visible(false);
        indexUltimoContratoSelected = index;
        $('.numero2').autoNumeric("update");        
        if(typeof (datosGlobalesSolicitud.psolicitud) === "object" && (datosGlobalesSolicitud.psolicitud.IdEdoSol === "3" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "4")){                        
            $(".fechaHoja4").datepicker("remove");
            $(".fechaHoja4").removeAttr("style");
            $("#importeGarantiaCump").removeAttr("style");
            $("#folioGarantia").attr("readonly",true);
            $("#importeGarantia").attr("readonly",true);
            $("#montoAntiContr").attr("readonly",true);
            $("#pjeAntiContr").attr("readonly",true);
            $("#formaPagoAnticipoContrato").attr("readonly",true);
            $("#folioGarantiaCump").attr("readonly",true);
            $("#btnAddModal1").hide();
            $(".montoMesFina").attr("readonly",true);
        }else{
            $(".fechaHoja4").datepicker("update");
        }
    }
}

function calculaPje(index) {
    var montoMasIVA = parseFloat(tablaContratosHoja4.row(index).data()[9] !== "" ? tablaContratosHoja4.row(index).data()[9] : "0");
    $("#pjeAntiContr").val(((parseFloat($("#montoAntiContr").val() !== "" ? $("#montoAntiContr").val().replace(/,/g, "") : "0") * 100) / montoMasIVA).toFixed(5));
}

function limpiaCalendarizados() {
    tablaHoja4.clear().draw();
    $(".contratoSelected").text("");
    $("#tabla2").find("input").val("");
    sumaAcumulado(indexUltimoContratoSelected, "");
    indexUltimoContratoSelected = -1;
    tablaConceptosContratoHoja4.clear().draw();
    conceptosSelectedHoja4 = new Array();
}

function asignaCalendarizadosToContrato() {
    if (indexUltimoContratoSelected !== -1 || datosGlobalesSolicitud.tiposolicitud !== "") {
        var camposMeses = ["mesene", "mesfeb", "mesmar", "mesabr", "mesmay", "mesjun", "mesjul", "mesago", "messep", "mesoct", "mesnov", "mesdic"];
        var camposMesesAdmin = ["meseneAdmin", "mesfebAdmin", "mesmarAdmin", "mesabrAdmin", "mesmayAdmin", "mesjunAdmin", "mesjulAdmin", "mesagoAdmin", "messepAdmin", "mesoctAdmin", "mesnovAdmin", "mesdicAdmin"];
        if (datosGlobalesSolicitud.tiposolicitud === "1" || datosGlobalesSolicitud.tiposolicitud === "3" || datosGlobalesSolicitud.tiposolicitud === "9") {
            datosGlobalesSolicitud.avancesFisicos = tablaHoja4.rows().data().toArray();
            datosGlobalesSolicitud.avancesFinancieros = new Array();
            for (var i = 0; i < 12; i++) {
                datosGlobalesSolicitud.avancesFinancieros.push($("#" + camposMeses[i]).val() !== "" ? $("#" + camposMeses[i]).val().replace(/,/g, "") : "0.00");
            }
        } else if (datosGlobalesSolicitud.tiposolicitud === "10" || datosGlobalesSolicitud.tiposolicitud === "11" || datosGlobalesSolicitud.tiposolicitud === "13") {
            datosGlobalesSolicitud.avancesFisicos = tablaHoja4Admin.rows().data().toArray();
            datosGlobalesSolicitud.avancesFinancieros = new Array();
            for (var i = 0; i < 12; i++) {
                datosGlobalesSolicitud.avancesFinancieros.push($("#" + camposMesesAdmin[i]).val() !== "" ? $("#" + camposMesesAdmin[i]).val().replace(/,/g, "") : "0.00");
            }
            if (tablaContratosHoja4.row(indexUltimoContratoSelected).data()) {
                tablaContratosHoja4.row(indexUltimoContratoSelected).data()[21] = tablaHoja4.rows().data().toArray();
                tablaContratosHoja4.row(indexUltimoContratoSelected).data()[18] = tablaConceptosContratoHoja4.rows().data().toArray();
                tablaContratosHoja4.row(indexUltimoContratoSelected).data()[19] = {folio: $("#folioGarantia").val(), fechaEmision: $("#fecGarantia").val(), importe: $("#importeGarantia").val() !== "" ? $("#importeGarantia").val().replace(/,/g, "") : "0.00", inicioPlazo: $("#startPlazoGarantia").val(), finPlazo: $("#endPlazoGarantia").val(), folioCump: $("#folioGarantiaCump").val(), fechaEmisionCump: $("#fecGarantiaCump").val(), importeCump: $("#importeGarantiaCump").val() !== "" ? $("#importeGarantiaCump").val().replace(/,/g, "") : "0.00", inicioPlazoCump: $("#startPlazoGarantiaCump").val(), finPlazoCump: $("#endPlazoGarantiaCump").val()};
                tablaContratosHoja4.row(indexUltimoContratoSelected).data()[20] = {importe: $("#montoAntiContr").val().replace(/,/g, ""), porcentaje: $("#pjeAntiContr").val(), motivos: $("#motivosPjeMayorContrato").val(), formaPago: $("#formaPagoAnticipoContrato").val(), bndAnticipo: $("#bndAnticipo").val(), autorizado: $("#isAutorizedAnticipo").val()};
                for (var i = 0; i < 12; i++) {
                    tablaContratosHoja4.row(indexUltimoContratoSelected).data()[22][i] = $("#" + camposMeses[i]).val().replace(/,/g, "");
                }
            }
        } else {
            tablaContratosHoja4.row(indexUltimoContratoSelected).data()[21] = tablaHoja4.rows().data().toArray();
            tablaContratosHoja4.row(indexUltimoContratoSelected).data()[18] = tablaConceptosContratoHoja4.rows().data().toArray();
            tablaContratosHoja4.row(indexUltimoContratoSelected).data()[19] = {folio: $("#folioGarantia").val(), fechaEmision: $("#fecGarantia").val(), importe: $("#importeGarantia").val() !== "" ? $("#importeGarantia").val().replace(/,/g, "") : "0.00", inicioPlazo: $("#startPlazoGarantia").val(), finPlazo: $("#endPlazoGarantia").val(), folioCump: $("#folioGarantiaCump").val(), fechaEmisionCump: $("#fecGarantiaCump").val(), importeCump: $("#importeGarantiaCump").val() !== "" ? $("#importeGarantiaCump").val().replace(/,/g, "") : "0.00", inicioPlazoCump: $("#startPlazoGarantiaCump").val(), finPlazoCump: $("#endPlazoGarantiaCump").val()};
            tablaContratosHoja4.row(indexUltimoContratoSelected).data()[20] = {importe: $("#montoAntiContr").val().replace(/,/g, ""), porcentaje: $("#pjeAntiContr").val(), motivos: $("#motivosPjeMayorContrato").val(), formaPago: $("#formaPagoAnticipoContrato").val(), bndAnticipo: $("#bndAnticipo").val(), autorizado: $("#isAutorizedAnticipo").val()};
            for (var i = 0; i < 12; i++) {
                tablaContratosHoja4.row(indexUltimoContratoSelected).data()[22][i] = $("#" + camposMeses[i]).val().replace(/,/g, "");
            }
        }
    } else {
        bootbox.alert("Primero debe seleccionar un contrato");
    }
}