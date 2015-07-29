var FecRec;
var idAps;
var indice = 0;
var ivaAmorticacion;
var detalle = false;
var none = false;
var consulta = false;
var PrmMod = 0;
var estadoAp;
var apBorradas = new Array();
var ivaAp;
var e, f, c, d, a = false;
var tipoMovimiento;
var movimientos = {};
var apGeneral = [];
var idSol;

$(document).ready(function () {
    $("input[type=text],textarea,select").addClass("form-control input-sm");
    $(".number").autoNumeric();
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    $(".number").autoNumeric({vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});

    tablaMovimientos = $('#tablaMovimientos').DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
        "oLanguage": {
            "sProcessing": "&nbsp; &nbsp; &nbsp;Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "    No se encontraron resultados",
            "sEmptyTable": "    Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "&nbsp; &nbsp; &nbsp;    Mostrando registro(s) de la _START_ a la _END_ de un total de _TOTAL_ registro(s)",
            "sInfoEmpty": " &nbsp; &nbsp; &nbsp;   Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "    (filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "    Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "    Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
//            $(nRow).css("cursor", "pointer");
            var cell = tablaMovimientos.cell(nRow, 8).node();
            $(cell).addClass('number');
            switch (aData[2]) {
                case "1": // AMORTIZACION
                    break;
                case "2": // ANTICIPO
                    break;
                case "4": // ESTIMACION
                    tablaMovimientos.cell(nRow, 9).data('<span  class="glyphicon glyphicon-list-alt" style="cursor:hand;" title="Ver conceptos" onClick="verConceptos();"></span>').draw();
                    break;
                case "5": // IVA
                    break;
                case "6": //PAGO
                    tablaMovimientos.cell(nRow, 9).data('<span  class="glyphicon glyphicon-list-alt" style="cursor:hand;" title="Ver conceptos" onClick="verConceptos();"></span>').draw();
                    break;
                    break;
                case "7": // ESTIMACION
                    tablaMovimientos.cell(nRow, 9).data('<span  class="glyphicon glyphicon-list-alt" style="cursor:hand;" title="Ver conceptos" onClick="verConceptos();"></span>').draw();
                    break;
            }
        }
        , "drawCallback": function (settings) {
            $(".number").autoNumeric();
            calcularAPGeneral();
        }});

    tablaEstimaciones = $("#tablaMontosEst").DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
        "oLanguage": {
            "sProcessing": "&nbsp; &nbsp; &nbsp;Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "    No se encontraron resultados",
            "sEmptyTable": "    Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "&nbsp; &nbsp; &nbsp;    Mostrando registro(s) de la _START_ a la _END_ de un total de _TOTAL_ registro(s)",
            "sInfoEmpty": " &nbsp; &nbsp; &nbsp;   Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "    (filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "    Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "    Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            for (var i = 2; i <= 4; i++) {
                var cell = tablaEstimaciones.cell(nRow, i).node();
                $(cell).addClass('number');
            }
        }
        , "drawCallback": function (settings) {
            $(".number").autoNumeric();
        }});

    tablaComprobaciones = $("#tablaMontosComp").DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
        "oLanguage": {
            "sProcessing": "&nbsp; &nbsp; &nbsp;Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "    No se encontraron resultados",
            "sEmptyTable": "    Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "&nbsp; &nbsp; &nbsp;    Mostrando registro(s) de la _START_ a la _END_ de un total de _TOTAL_ registro(s)",
            "sInfoEmpty": " &nbsp; &nbsp; &nbsp;   Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "    (filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "    Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "    Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            var cell = tablaComprobaciones.cell(nRow, 2).node();
            $(cell).addClass('number');
        }
        , "drawCallback": function (settings) {
            $(".number").autoNumeric();
        }});

    tablaComprobantes = $('#tablaComprobantes').DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
        "oLanguage": {
            "sProcessing": "&nbsp; &nbsp; &nbsp;Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "    No se encontraron resultados",
            "sEmptyTable": "    Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "&nbsp; &nbsp; &nbsp;    Mostrando registro(s) de la _START_ a la _END_ de un total de _TOTAL_ registro(s)",
            "sInfoEmpty": " &nbsp; &nbsp; &nbsp;   Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "    (filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "    Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "    Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }}});
//    tablaComprobantes.column(0).visible(false);

    $("#apRegistrada").click(function () {
        if ($("#apRegistrada").prop("checked")) {
            $("#apF").show();
        } else {
            $("#apF").hide();
        }
    });
    $("#folioAp").on('change', (function () {
        getApById();
        //$("#folioAp").attr("readonly", "true");
    }));

    $("#fecDev").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);


    $("#btnReload").click(function () {
        if (confirm(" \u00BFDesea cambiar de AP?"))
            location.reload();
    });
    $("#btnGuardar").click(function () {
        colocaWaitGeneral();
        guardarAp();
    });
    $("#btnDocumentacion").click(function () {
        $("#dialogComprobantes").modal();
    });
    $("#error").click(function () {
        e = true
    });
    $("#finiquito").click(function () {
        f = true
    });
    $("#cp").click(function () {
        c = true
    });
    $("#desafect").click(function () {
        d = true
    });
    $("#afect").click(function () {
        a = true
    });
    $("#btnDevolucion").click(function () {
        $("#dialogDevolucion").modal();
    });
    $("#btnGuardarDevolucion").click(function () {
        guardarDevolucion();
    });


});


function getApById() {

    var CveAps = $("#folioAp").val();
    $.ajax({
        data: {'accion': 'getApByIdAnalisis', 'CveAps': CveAps},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            console.log(data);

            if (data.length > 0) {
                if (data[0].idEdoAps != 5) {
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html("El folio de la Autorizaci\u00f3n de Pago no es v\u00e1lido.");
                    $('#dialogAvisos').on('hidden.bs.modal', function () {
                        $("#iFolio").focus();
                    });
                    return false;
                }
                //$("#movimientos").show();
                movimientos = {};
                apGeneral = [];
                tablaMovimientos.clear().draw();
                idAps = data[0].idAps;
                idSol = data[0].idSol;
                $("#estadoAp").val(data[0].NomEdoAps);
                $("#fecRecAp").val(data[0].fechaRecepcion);
                $("#beneficiarioAp").val(data[0].NomEmp);
                $("#rfcAp").val(data[0].RfcEmp);
                $("#idEmpAp").val(data[0].idEmp);
                $("#observacionesAp").val(data[0].ObsAps);
                $("#ejecutoraAp").val(data[0].NomUE);
                FecRec = data[0].FecRec;
                idDetObr = data[0].idDetObr;
                PrmMod = data[0].PrmMod;
                estadoAp = data[0].idEdoAps;
                ivaAp = data[0].Iva;
                if (data[0].AutPagCP == "1")
                    $("#cpAp").prop("checked", true);
                if (data[0].Error == "1")
                    $("#errorAp").prop("checked", true);
                if (data[0].Finiquito == "1")
                    $("#finiquitoAp").prop("checked", true);
                if (data[0].DesAfe == "1")
                    $("#desafectacionAp").prop("checked", true);
                if (data[0].SolAfe == "1")
                    $("#soloAp").prop("checked", true);
                $("#obraAp").val(data[0].idObr);
                $("#idDetObrAp").val(data[0].idDetObr);
                $("#nombreobraAp").val(data[0].NomObr);
                if (data[0].IdModEje === "3") {
                    var mod = "Contrato";
                } else {
                    var mod = "Administraci\u00f3n";
                }
                $("#dscModEje").val(mod);
                $("#modEje").val(data[0].IdModEje);
                $("#sectorAp").val(data[0].NomSec);

                $("#sinivaAp").val(data[0].montoAp).focusin().focusout();
                $("#amortizacionAp").val(parseFloat(data[0].montoAmortizacion) + parseFloat(data[0].montoIvaAmortizacion)).focusin().focusout();
                $("#icicAp").val(data[0].Icic);
                $("#cmicAp").val(data[0].Cmic);
                $("#supervisionAp").val(data[0].Supervision);
                $("#isptAp").val(data[0].Ispt);
                $("#otroAp").val(data[0].Otro);
                $("#ivaAp").val(data[0].Iva);

                switch (data[0].idTipAps) {
                    case "2": //CARGA DE ANTICIPOS
                        tipoMovimiento = 2;

                        movimientos.idAps = data[0].idAps;
                        movimientos.CveAp = data[0].CveAps;
                        movimientos.idTipAps = data[0].idTipAps;
                        movimientos.dscMov = data[0].NomTipAps;
                        movimientos.idContrato = data[0].idContrato;
                        movimientos.dscContrato = data[0].numContra;
                        movimientos.idFte = data[0].idFte;
                        movimientos.dscFte = data[0].DscFte;
                        movimientos.cuentaFte = data[0].cuenta;
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = data[0].idObr;
                        movimientos.dscObr = data[0].NomObr;
                        movimientos.monto = $("#sinivaAp").val().replace(/,/g, "");
                        movimientos.amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
                        movimientos.subtotal = $("#subtotalAp").val().replace(/,/g, "");
                        movimientos.iva = $("#ivaAp").val().replace(/,/g, "");
                        movimientos.afectPresupuestal = $("#afectacionAp").val().replace(/,/g, "");
                        movimientos.impNeto = $("#netoAp").val().replace(/,/g, "");
                        movimientos.icic = $("#icicAp").val().replace(/,/g, "");
                        movimientos.cmic = $("#cmicAp").val().replace(/,/g, "");
                        movimientos.supervision = $("#supervisionAp").val().replace(/,/g, "");
                        movimientos.ispt = $("#isptAp").val().replace(/,/g, "");
                        movimientos.otro = $("#otroAp").val().replace(/,/g, "");
                        movimientos.retenciones = $("#retencionesAp").val().replace(/,/g, "");
                        apGeneral.push(movimientos);

                        tablaMovimientos.row.add([data[0].Ejercicio, data[0].numContra, data[0].idTipAps, data[0].NomTipAps, data[0].folioAmortizacion, data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAp, "", ""]).draw();
                        tablaMovimientos.columns([2, 5, 9]).visible(false);
                
                        for (var i = 0; i < data[0].comprobantes.length; i++) {
                            tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal']]).draw();
                        }
                        tablaComprobantes.column(0).visible(false);
                        break;

                    case "4": //CARGA DE ESTIMACION
                        tipoMovimiento = 4;
                        if (data[0].montoAmortizacion > 0) {// CALCULAR AMORTIZACION
//                                movimientos.montoAmortizacion = data[0].montoAmortizacion-data[0].montoIvaAmortizacion;
                            movimientos.montoAmortizacion = data[0].montoAmortizacion;
                            movimientos.montoIvaAmortizacion = data[0].montoIvaAmortizacion;
                            movimientos.folioAmortizacion = data[0].folioAmortizacion;
                        } else {
                            montoAmortizacion = 0.00;
                            movimientos.montoAmortizacion = 0.00;
                            movimientos.montoIvaAmortizacion = 0.00;
                            movimientos.folioAmortizacion = 0;
                        }
                        var conceptos = data[0].montosConceptos;
                        movimientos.idAps = data[0].idAps;
                        movimientos.CveAp = data[0].CveAps;
                        movimientos.idTipAps = data[0].idTipAps;
                        movimientos.dscMov = data[0].NomTipAps;
                        movimientos.idContrato = data[0].idContrato;
                        movimientos.dscContrato = data[0].numContra;
                        movimientos.idFte = data[0].idFte;
                        movimientos.dscFte = data[0].DscFte;
                        movimientos.cuentaFte = data[0].cuenta;
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = data[0].idObr;
                        movimientos.dscObr = data[0].NomObr;
                        movimientos.monto = $("#sinivaAp").val().replace(/,/g, "");
                        movimientos.amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
                        movimientos.subtotal = $("#subtotalAp").val().replace(/,/g, "");
                        movimientos.iva = $("#ivaAp").val().replace(/,/g, "");
                        movimientos.afectPresupuestal = $("#afectacionAp").val().replace(/,/g, "");
                        movimientos.impNeto = $("#netoAp").val().replace(/,/g, "");
                        movimientos.icic = $("#icicAp").val().replace(/,/g, "");
                        movimientos.cmic = $("#cmicAp").val().replace(/,/g, "");
                        movimientos.supervision = $("#supervisionAp").val().replace(/,/g, "");
                        movimientos.ispt = $("#isptAp").val().replace(/,/g, "");
                        movimientos.otro = $("#otroAp").val().replace(/,/g, "");
                        movimientos.retenciones = $("#retencionesAp").val().replace(/,/g, "");
                        movimientos.montosConceptos = data[0].montosConceptos;
                        apGeneral.push(movimientos);

                        tablaMovimientos.row.add([data[0].Ejercicio, data[0].numContra, data[0].idTipAps, data[0].NomTipAps, "", data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAp, ""]).draw();
                        if (data[0].montoAmortizacion > 0) {
                            tablaMovimientos.row.add(["", "", "1", 'Amortizaci\u00f3n', data[0].folioAmortizacion, data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAmortizacion, ""]).draw();
                            tablaMovimientos.row.add(["", "", "5", 'I.V.A.', '', data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoIvaAmortizacion, ""]).draw();
                        }
                        tablaMovimientos.columns([2, 5]).visible(false);
                        for (var i = 0; i < conceptos.length; i++) {
                            tablaEstimaciones.row.add([conceptos[i].claveObj, conceptos[i].concept, conceptos[i].total, conceptos[i].iva, conceptos[i].totalConIva]).draw();
                        }
                        $("#comp").hide();
                        $("#est").show();

                        for (var i = 0; i < data[0].comprobantes.length; i++) {
                            tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal']]).draw();
                        }
                        tablaComprobantes.column(0).visible(false);
                        break;

                    case "6": //CARGA DE PAGOS
                        tipoMovimiento = 7;
                        movimientos.montoAmortizacion = data[0].montoAmortizacion;
                        movimientos.montoIvaAmortizacion = data[0].montoIvaAmortizacion;
                        movimientos.folioAmortizacion = data[0].folioAmortizacion;

                        var conceptos = data[0].montosConceptos;
                        movimientos.idAps = data[0].idAps;
                        movimientos.CveAp = data[0].CveAps;
                        movimientos.idTipAps = data[0].idTipAps;
                        movimientos.dscMov = data[0].NomTipAps;
                        movimientos.idContrato = data[0].idContrato;
                        movimientos.dscContrato = data[0].numContra;
                        movimientos.idFte = data[0].idFte;
                        movimientos.dscFte = data[0].DscFte;
                        movimientos.cuentaFte = data[0].cuenta;
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = data[0].idObr;
                        movimientos.dscObr = data[0].NomObr;
                        movimientos.monto = $("#sinivaAp").val().replace(/,/g, "");
                        movimientos.amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
                        movimientos.subtotal = $("#subtotalAp").val().replace(/,/g, "");
                        movimientos.iva = $("#ivaAp").val().replace(/,/g, "");
                        movimientos.afectPresupuestal = $("#afectacionAp").val().replace(/,/g, "");
                        movimientos.impNeto = $("#netoAp").val().replace(/,/g, "");
                        movimientos.icic = $("#icicAp").val().replace(/,/g, "");
                        movimientos.cmic = $("#cmicAp").val().replace(/,/g, "");
                        movimientos.supervision = $("#supervisionAp").val().replace(/,/g, "");
                        movimientos.ispt = $("#isptAp").val().replace(/,/g, "");
                        movimientos.otro = $("#otroAp").val().replace(/,/g, "");
                        movimientos.retenciones = $("#retencionesAp").val().replace(/,/g, "");
                        movimientos.montosConceptos = data[0].montosConceptos;
                        apGeneral.push(movimientos);

                        tablaMovimientos.row.add([data[0].Ejercicio, data[0].numContra, data[0].idTipAps, data[0].NomTipAps, "", data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAp, ""]).draw();
                        if (data[0].montoAmortizacion > 0) {
                            tablaMovimientos.row.add(["", "", "1", 'Amortizaci\u00f3n', data[0].folioAmortizacion, data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAmortizacion, ""]).draw();
                        }
                        tablaMovimientos.columns([2, 5]).visible(false);

                        for (var i = 0; i < conceptos.length; i++) {
                            tablaEstimaciones.row.add([conceptos[i].claveObj, conceptos[i].concept, conceptos[i].total, conceptos[i].iva, conceptos[i].totalConIva]).draw();
                        }
                        $("#comp").hide();
                        $("#est").show();

                        for (var i = 0; i < data[0].comprobantes.length; i++) {
                            tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal']]).draw();
                        }
                        tablaComprobantes.column(0).visible(false);
                        break;
                    case "7": //CARGA DE COMPROBACION
                        tipoMovimiento = 7;
                        movimientos.montoAmortizacion = data[0].montoAmortizacion;
                        movimientos.montoIvaAmortizacion = data[0].montoIvaAmortizacion;
                        movimientos.folioAmortizacion = data[0].folioAmortizacion;

                        var conceptos = data[0].montosConceptos;
                        movimientos.idAps = data[0].idAps;
                        movimientos.CveAp = data[0].CveAps;
                        movimientos.idTipAps = data[0].idTipAps;
                        movimientos.dscMov = data[0].NomTipAps;
                        movimientos.idContrato = data[0].idContrato;
                        movimientos.dscContrato = data[0].numContra;
                        movimientos.idFte = data[0].idFte;
                        movimientos.dscFte = data[0].DscFte;
                        movimientos.cuentaFte = data[0].cuenta;
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = data[0].idObr;
                        movimientos.dscObr = data[0].NomObr;
                        movimientos.monto = $("#sinivaAp").val().replace(/,/g, "");
                        movimientos.amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
                        movimientos.subtotal = $("#subtotalAp").val().replace(/,/g, "");
                        movimientos.iva = $("#ivaAp").val().replace(/,/g, "");
                        movimientos.afectPresupuestal = $("#afectacionAp").val().replace(/,/g, "");
                        movimientos.impNeto = $("#netoAp").val().replace(/,/g, "");
                        movimientos.icic = $("#icicAp").val().replace(/,/g, "");
                        movimientos.cmic = $("#cmicAp").val().replace(/,/g, "");
                        movimientos.supervision = $("#supervisionAp").val().replace(/,/g, "");
                        movimientos.ispt = $("#isptAp").val().replace(/,/g, "");
                        movimientos.otro = $("#otroAp").val().replace(/,/g, "");
                        movimientos.retenciones = $("#retencionesAp").val().replace(/,/g, "");
                        movimientos.montosConceptos = data[0].montosConceptos;
                        apGeneral.push(movimientos);

                        tablaMovimientos.row.add([data[0].Ejercicio, data[0].numContra, data[0].idTipAps, data[0].NomTipAps, data[0].folioAmortizacion, data[0].idFte, data[0].DscFte, data[0].cuenta, data[0].montoAp, ""]).draw();
                        tablaMovimientos.columns([2, 5]).visible(false);
                        for (var i = 0; i < conceptos.length; i++) {
                            tablaComprobaciones.row.add([conceptos[i].claveObj, conceptos[i].concept, conceptos[i].totalConIva]).draw();
                        }
                        $("#comp").show();
                        $("#est").hide();

                        for (var i = 0; i < data[0].comprobantes.length; i++) {
                            tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal']]).draw();
                        }
                        tablaComprobantes.column(0).visible(false);
                        break;

                }

            } else {
                alert("No existe ese folio de AP registrado");
                $("#folioAp").removeAttr("readonly").focus();
//                $("#movimientos").hide();
                idAps = null;
                $("#estadoAp").val('');
                $("#fecRecAp").val('');
                $("#fecEnvAp").val('');
                $("#beneficiarioAp").val('');
                $("#observacionesAp").val('');
                $("#ejecutoraAp").val('');
                $("#obraAp").val('');
                $("#nombreobraAp").val('');
                $("#sectorAp").val('');
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function verConceptos() {
    $("#dialogEstimacion").modal();
}

function calcularAPGeneral(callback) {
    switch (tipoMovimiento) {
        case 1: //AMORTIZACION
            break;
        case 2: // ANTICIPO
            var importe = $("#sinivaAp").val().replace(/,/g, "");
            var amortizacion = 0.00;
            var subtotal = parseFloat(importe) - parseFloat(amortizacion);
            var iva = $("#ivaAp").val().replace(/,/g, "");
            var afectacion = parseFloat(subtotal) + parseFloat(iva);

            var icic = 0.00;
            var cmic = 0.00;
            var sup = 0.00;
            var ispt = 0.00;
            var otro = $("#otroAp").val().replace(/,/g, "");
            var retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro);
            var neto = parseFloat(afectacion) - parseFloat(retenciones);

            $("#amortizacionAp").val(amortizacion).focusin().focusout();
            $("#subtotalAp").val(subtotal).focusin().focusout();
            $("#afectacionAp").val(afectacion).focusin().focusout();
            $("#netoAp").val(neto).focusin().focusout();
            $("#retencionesAp").val(retenciones).focusin().focusout();
            $("#letranetoAp").val(NumeroALetras(neto));


            break;
        case 4: //ESTIMACION
            var importe = $("#sinivaAp").val().replace(/,/g, "");
            var amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
            var subtotal = 0.00;
            var iva = 0.00;
            var afectacion = 0.00;
            var neto = 0.00;
            var icic = $("#icicAp").val().replace(/,/g, "");
            icic = icic.replace(/,/g, "");
            var cmic = $("#cmicAp").val().replace(/,/g, "");
            cmic = cmic.replace(/,/g, "");
            var sup = $("#supervisionAp").val().replace(/,/g, "");
            sup = sup.replace(/,/g, "");
            var ispt = $("#isptAp").val().replace(/,/g, "");
            ispt = ispt.replace(/,/g, "");
            var otro = $("#otroAp").val().replace(/,/g, "");
            otro = otro.replace(/,/g, "");
            var iva = $("#ivaAp").val().replace(/,/g, "");
            iva = iva.replace(/,/g, "");
            subtotal = (importe) - (amortizacion); //SUBTOTAL
            console.log("Subtotal:" + subtotal);
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
            console.log("Afectacion:" + afectacion);
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
            console.log("Retenciones:" + retenciones);
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
            console.log("Neto:" + neto);
            $("#subtotalAp").val(subtotal);
            $("#afectacionAp").val(afectacion);
            $("#totalAp").val(retenciones);
            $("#netoAp").val(neto);
            $("#letranetoAp").val(NumeroALetras(neto));
            $(".number").each(function () {
                $(this).focusin().focusout();
            });
            break;
        case 7: //COMPROBACION
            var importe = $("#sinivaAp").val().replace(/,/g, "");
            var amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
            var subtotal = 0.00;
            var iva = 0.00;
            var afectacion = 0.00;
            var neto = 0.00;
            var icic = $("#icicAp").val().replace(/,/g, "");
            icic = icic.replace(/,/g, "");
            var cmic = $("#cmicAp").val().replace(/,/g, "");
            cmic = cmic.replace(/,/g, "");
            var sup = $("#supervisionAp").val().replace(/,/g, "");
            sup = sup.replace(/,/g, "");
            var ispt = $("#isptAp").val().replace(/,/g, "");
            ispt = ispt.replace(/,/g, "");
            var otro = $("#otroAp").val().replace(/,/g, "");
            otro = otro.replace(/,/g, "");
            var iva = $("#ivaAp").val().replace(/,/g, "");
            iva = iva.replace(/,/g, "");
            subtotal = (importe) - (amortizacion); //SUBTOTAL
            console.log("Subtotal:" + subtotal);
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
            console.log("Afectacion:" + afectacion);
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
            console.log("Retenciones:" + retenciones);
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
            console.log("Neto:" + neto);
            $("#subtotalAp").val(subtotal);
            $("#afectacionAp").val(afectacion);
            $("#totalAp").val(retenciones);
            $("#netoAp").val(neto);
            $("#letranetoAp").val(NumeroALetras(neto));
            $(".number").each(function () {
                $(this).focusin().focusout();
            });
            break;
    }
    if (typeof (callback) !== "undefined") {
        callback();
    }
    ;
}

function guardarAp() {
    bootbox.confirm("Se aceptar\u00e1 la Autorizaci\u00f3n de Pago, \u00BFDesea continuar?", function (response) {
        if (response) {
            var apPrincipal = new Array();
            var error = 0;
            var finiquito = 0;
            var cp = 0;
            var desafect = 0;
            var afect = 0;

            if ($("#errorAp").prop("checked"))
                error = 1;
            if ($("#finiquitoAp").prop("checked"))
                finiquito = 1;
            if ($("#cpAp").prop("checked"))
                cp = 1;
            if ($("#desafectacionAp").prop("checked"))
                desafect = 1;
            if ($("#soloAp").prop("checked"))
                afect = 1;



            var principal = {//DATOS A ACTUALIZAR DE LA PRINCIPAL
                'idAps': idAps,
                'Error': error,
                'Finiquito': finiquito,
                'AutPagCP': cp,
                'DesAfe': desafect,
                'SolAfe': afect,
                'ObsAps': $("#observacionesAp").val(),
            }
            apGeneral[0].tipos = principal;
            $.ajax({
                data: {'accion': 'aceptarAp', 'ap': apGeneral, 'idSol': idSol}, //'apPrincipal': apPrincipal},
                url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
                type: 'post',
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("Autorizaci\u00f3n de Pago aceptada.");
                        $('#dialogAvisos').on('hidden.bs.modal', function () {
                            location.reload();
                        });
                    }
                },
                error: function (response) {
                    console.log("Errores::", response);
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html(response);
                    $('#dialogAvisos').on('hidden.bs.modal', function () {
                        location.reload();
                    });
                }
            });
        }
    });
    eliminaWaitGeneral();
}

function guardarDevolucion() {
    bootbox.confirm("Se cancelar\u00e1 la Autorizaci\u00f3n de Pago, \u00BFDesea continuar?", function (response) {
        if (response) {
            var fecDev = $("#fecDev").val();
            var oficioDev = $("#oficioDev").val();
            var obsDev = $("#obsDev").val();
            var temp = {
                'idAps': idAps,
                'FecDev': fecDev,
                'OfiDev': oficioDev,
                'Obs': obsDev
            };
            apGeneral[0].datosDevolucion = temp;
//    console.log(apGeneral[0].datosDevolucion);
//    return false;
            $.ajax({
                data: {'accion': 'devolucionAp', 'ap': apGeneral, 'idSol': idSol}, //'apPrincipal': apPrincipal},
                url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
                type: 'post',
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("Autorizaci\u00f3n de Pago cancelada.");
                        $('#dialogAvisos').on('hidden.bs.modal', function () {
                            location.reload();
                        });
                    }
                },
                error: function (response) {
                    console.log("Errores::", response);
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html(response);
                    $('#dialogAvisos').on('hidden.bs.modal', function () {
                        location.reload();
                    });
                }
            });
        }
    });

}

function colocaWaitGeneral() {
    var divWait = $('<div id="pleaseWaitSGI" class="modal-backdrop fade in"></div><div class="progress modal-dialog" id="progressWait" style="z-index: 99999;height: 40px;"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><p style="height: 40px;display: table;width: 100%;"><span style="display: table-cell;vertical-align: middle;font-size:18px;">Cargando informaci\u00f3n necesaria...</span></p></div></div>').appendTo('body');
    divWait.show();
}

function eliminaWaitGeneral() {
    $("#pleaseWaitSGI").remove();
    $("#progressWait").remove();
}

