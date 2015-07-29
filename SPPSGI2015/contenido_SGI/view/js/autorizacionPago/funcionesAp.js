var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var idSol = 0;
var importesAnticipos = new Array();
var anticipoFuentes = new Array();
var detalleContrato = new Array();
var detalleFuentes = new Array();
var detalleConcepto = new Array();
var relConceptoFuentes = new Array();
var errorEstimacion;
var errorMonto;
var apGeneral = new Array();
var movimientosEliminados = new Array();
var tipoMovimiento;
var movimientos = {};
var montoAmortizacion = 0.00;
var ivaAmortizacion = 0.00;
var indiceEditarComprobante;
var idAps = 0;
var CveAps = 0;
var NomSec = "";
var arrayComrobantes = new Array();
var estadoAp = "4";
var modEje;
var arrayFoliosAmortizarAdm = new Array();
$(document).ready(function () {

    tablaConceptos = $('#tablaConceptos').DataTable({"retrieve": true, "ordering": false, "sPaginationType": "bootstrap",
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
                "sLast": "ÃƒÆ’Ã…Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $('td:eq(4)', nRow).addClass("number");
            $('td:eq(5)', nRow).addClass("number");
            $('td:eq(6)', nRow).addClass("number");
            $('td:eq(7)', nRow).addClass("number");
            $('td:eq(8)', nRow).addClass("number");
            $('td:eq(9)', nRow).addClass("number");

        }, "drawCallback": function (settings) {
            $(".number").autoNumeric();
        }
    });
    tablaEstimaciones = $("#tablaMontosEst").DataTable({retrieve: true, "ordering": false, "sPaginationType": "bootstrap",
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
                "sLast": "ÃƒÆ’Ã…Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).css("cursor", "pointer");
            $(nRow).addClass("fondoBlanco");
            $(nRow).hover(function () {
                if (!$(this).hasClass("selected")) {
                    $(this).addClass("bld");
                    $(this).removeClass("fondoBlanco");
                }

            }, function () {
                if (!$(this).hasClass("selected")) {
                    $(this).removeClass("bld");
                    $(this).addClass("fondoBlanco");
                }

            });
            $(nRow).click(function () {
                $("#tablaMontosEst tr.selected").each(function () {
                    $(this).removeClass("selected").addClass("fondoBlanco");
                });
                $(this).addClass("selected");
                $(this).removeClass("fondoBlanco");
                $("#conceptoActual").val(aData[1]);
                $("#indexConceptos").val(iDataIndex);
                mostrarGridAPresu(aData[8], aData[9], aData[10]);
//                console.log("obj FTE:");
//                console.log(aData[11]);
            });
            for (var i = 4; i <= 10; i++) {
                var cell = tablaEstimaciones.cell(nRow, i).node();
                $(cell).addClass('number');
            }

        }, "drawCallback": function (settings) {
            $(".number").autoNumeric();
        }
    });
    tablaEstimaciones.column(0).visible(false);
    tablaEstimaciones.column(1).visible(false);
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
                "sLast": "ÃƒÆ’Ã…Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
//            $(nRow).css("cursor", "pointer");
            var cell = tablaMovimientos.cell(nRow, 10).node();
            $(cell).addClass('number');
//            console.log(aData[4]);
            switch (aData[4]) {
                case "1": // AMORTIZACION
                    if (estadoAp !== "3") {
                        if ($("#idTipAps").val() === "6") {
                            tablaMovimientos.cell(nRow, 12).data('<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarAmortizacion(this);"></span>').draw();
                        } else {
                            tablaMovimientos.cell(nRow, 12).data('<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarMovimientos(this);"></span>').draw();
                        }
                    }

                    break;
                case "2": // ANTICIPO
                    break;
                case "4": // ESTIMACION
                    tablaMovimientos.cell(nRow, 11).data('<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="recuperarEstimaciones(this);"></span>').draw();
                    if (estadoAp !== "3")
                        tablaMovimientos.cell(nRow, 12).data('<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarMovimientos(this);"></span>').draw();
                    break;
                case "6": // PAGO
                    tablaMovimientos.cell(nRow, 11).data('<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="recuperarEstimaciones(this);"></span>').draw();
                    if (estadoAp !== "3")
                        tablaMovimientos.cell(nRow, 12).data('<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarMovimientos(this);"></span>').draw();
                    break;
                case "5": // IVA
                    if (estadoAp !== "3") {
                        var editaIva = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarIvaAmortizacion(this,' + aData[10] + ');"></span> ';
                        tablaMovimientos.cell(nRow, 11).data(editaIva).draw();
                    }
                    break;
                case "7": // COMPROBACION
                    tablaMovimientos.cell(nRow, 11).data('<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="recuperarEstimaciones(this);"></span>').draw();
                    if (estadoAp !== "3")
                        tablaMovimientos.cell(nRow, 12).data('<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarMovimientos(this);"></span>').draw();
                    break;
            }
        }
        , "drawCallback": function (settings) {
            calcularAPGeneral();
            if (tipoMovimiento !== 6) {
                tablaEstimaciones.clear().draw();
            }
        }});

    tablaComprobantes = $('#tablaComprobantes').DataTable({"retrieve": true, "ordering": false, "sPaginationType": "bootstrap",
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
                "sLast": "ÃƒÆ’Ã…Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }});
    tablaComprobantes.column(0).visible(false);
    tablaFuentesAnticipo = $('#tablaFuentesAnticipo').DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
        "oLanguage": {
            "sProcessing": "&nbsp; &nbsp; &nbsp;Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "    No se encontraron resultados",
            "sEmptyTable": "Esperando datos...",
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
                "sLast": "ÃƒÆ’Ã…Â¡ltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            var cell = tablaFuentesAnticipo.cell(nRow, 3).node();
            $(cell).addClass('number');
        }, "drawCallback": function (settings) {
            $(".number").autoNumeric();
        }});
    tablaFuentesAnticipo.column(0).visible(false);
    $("input[type=text],textarea,select").addClass("form-control input-sm");

    $("#idObra").change(function () {
        buscaObra();
    });

    $("#fechaAlterna").click(function () {
        if ($("#fechaAlterna").prop("checked")) {
            $("#apRegistrada").prop("checked", false);
            $("#fechaF").show();
            $("#apF").hide();
        } else {
            $("#fechaF").hide();
        }
    });
    $("#cveAp").on('change', (function () {
        colocaWaitGeneral();
        getApById();
//        $("#cveAp").attr("readonly", "true");
    }));
    $("#rfcAp").on('change', function () {
        buscaRfc($(this).val())
    });
    $("#fecDev,#fecha").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#porcentajeAnticipoAdm").TouchSpin({
        min: 0,
        max: 100,
        step: 1,
        decimals: 0,
        maxboostedstep: 10,
        postfix: '%',
//        verticalbuttons: true,
//        verticalupclass: 'glyphicon glyphicon-plus',
//        verticaldownclass: 'glyphicon glyphicon-minus'
    });

    $("#contrato").change(function () {
        $("#divFolioParaAmortizar").hide();
        $("#CveApAmortizar").text("");
        $("#folioParaAmortizar").val("");
        seleccionarBeneficiario();
        console.log(detalleContrato);

        for (var i = 0; i < detalleContrato.length; i++) { // BUSCAMOS SI EL CONTRATO SELECCIONADO TIENE DEFINIDO ANTICIPO
            if (detalleContrato[i].idContrato === $("#contrato").val()) {
                if (detalleContrato[i].pjeAnti !== "0.00000") {
                    $("#derechoAnticipo").val(1);
                    $("#porcentajeAnticipo").val(detalleContrato[i].pjeAnti);
                } else {
                    $("#derechoAnticipo").val(0);
                    $("#porcentajeAnticipo").val();
                }
            }
        }
    });
    $("#fuentes").change(function () {
        if (modEje === 3) { // POR CONTRATO
            if ($("#derechoAnticipo").val() === "1") { //SI EL CONTRATO TIENE DERECHO A ANTICIPO BUSCAMOS EL FOLIO
                getFolioParaAmortizar();
            }
        } else {// POR ADMINISTRACION
            getFolioParaAmortizar();
        }

    })
    $("#contratoAnticipo").change(function () {
        seleccionarBeneficiario();
        anticipoFuentes = [];
        tablaFuentesAnticipo.clear().draw();
        calculaAnticipoFuente();
    });
    $("#btnEstimar").click(function () {
        if ($("#contrato").val() !== "-1" && $("#fuentes").val() !== "-1") {
            getConceptos(function () {
                $("#updateMovimiento").hide();
                $("#agregarMovimiento").show();
                $("#dialogEstimacion").modal();
            });
        } else {
            bootbox.alert("Se debe seleccionar contrato y fuente");
        }

    });

    $("#btnPagos").click(function () {
        if ($("#fuentes").val() !== "-1") {
            getConceptos(function () {
                $("#tablaMontosEst thead tr:eq(0) th:eq(6)").text("Total a Pagar");
                $("#tablaMontosEst thead tr:eq(0) th:eq(7)").text("I.V.A.");
                $("#tablaMontosEst thead tr:eq(0) th:eq(8)").text("Total Pago con I.V.A.");
                $("#tituloDialog").text("Pago de Conceptos");
                $("#gridAfectacionPresupuestal div:eq(0)").html("Pago de Concepto");
                $("#estGeneral div:eq(0)").html("Pago General");

                $("#updateMovimiento").hide();
                $("#agregarMovimiento").show();
                $("#dialogEstimacion").modal();
            });
        } else {
            bootbox.alert("Se debe seleccionar una fuente");
        }

    });

    $("#agregarAmortizacion").click(function () {
        agregarAmortizacion();
    });


    $("#generaAmortizacion").click(function () {
        if ($("#fuentes").val() !== "-1" && $("#foliosAmortizar").val() !== "-1") {
            getConceptos(function () {
                $("#tablaMontosEst thead tr:eq(0) th:eq(8)").text("Total a Comprobar");
                tablaEstimaciones.column(8).visible(false);
                tablaEstimaciones.column(9).visible(false);

                $("#tituloDialog").text("Comprobaci\u00f3n de Conceptos");

                $("#gridAfectacionPresupuestal div:eq(0)").html("Comprobaci\u00f3n de Concepto");
                $("#tConcepto,#iConcepto").hide();
                $("#stConcepto label").text("Total");

                $("#estGeneral div:eq(0)").html("Comprobaci\u00f3n General");
                $("#tEstimar,#iEstimar").hide();
                $("#stEstimar label").text("Total");
                $("#dialogEstimacion").modal();

                $("#divInfAmort").show();
                $("#mntAm").text($("#montoPorAmortizar").val());

                $("#updateMovimiento").hide();
                $("#agregarMovimiento").show();
            });
        } else {
            bootbox.alert("Por favor, seleccione una fuente y el folio para amortizar.");
        }
    })
    $('#dialogEstimacion').on('hidden.bs.modal', function (e) {
        $(".inputAfectPresu").each(function () {
            $(this).val("")
        });
        $("#gridAfectacionPresupuestal").hide();
        $("#tablaMontosEst tr.selected").each(function () {
            $(this).removeClass("selected");
        });
    });
    $('#dialogConceptos').on('hidden.bs.modal', function (e) {
        $("#tablaConceptos").find(".seleccion:checked").each(function () {
            $(this).prop("checked", false);
        });
        if ($("#idTipAps").val() == "4") {//MOV ACTUAL ESTIMACION
            $("#dialogEstimacion").modal('show');
        } else if ($("#idTipAps").val() == "1") { //MOV ACTUAL AMORTIZACION

        }

    });
    $("#btnComprobacion").click(function () {
        if (Object.keys(apGeneral).length > 0) {
            $("#dialogComprobantes").modal();
        } else {
            bootbox.alert("No hay estimaciones registradas");
        }
    });
    $("#btnAgregarComprobantes").click(function () {
        guardarComprobantes();
    });
    $("#btnAgregarFactura").click(function () {
        $("#actualizarComprobante").hide();
        $("#agregaComprobante").show();
        $("#folioComprobante").val("");
        $("#tipoComprobante").val("");
        $("#importeComprobante").val("");
        $("#partidaComprobante").val("");
        $("#dialogFacturas").modal();
    });
    $("#btnAgregaConceptoEst").click(function () {
        $("#dialogEstimacion").modal('hide');
        $("#dialogConceptos").modal();
    });
    $("#btnAgregarConceptoFactura").click(function () {
        $("#dialogConceptos").modal();
    });
    $("#btnSeleccionarConceptos").click(function () {
        agregarConceptos();
    });
    $("#agregaComprobante").click(function () {
        agregarComprobantes();
    });
    $("#actualizarComprobante").click(function () {
        modificarComprobantes();
    });
    $("#accion").change(function () {
        switch ($(this).val()) {
            case "1": //CREACION DE AP

                $("#divobra").show();
                $("#divfolio").hide();
                $("#divperiodo").show();
                $("#conGeneral").hide();
                apGeneral = [];
                movimientos = {};
                $("#btnbuscar").click(function () {
                    buscaObra();
                });
                break;
            case "2": //MODIFICACION DE AP
                $("#divobra").hide();
                $("#divfolio").show();
                $("#divperiodo").hide();
                $("#conGeneral").hide();
                apGeneral = [];
                movimientos = {};
                $("#btnbuscar").click(function () {
                    getApById();
                });
                break;
            case "3": //DEVOLUCION DE AP
                $("#divobra").hide();
                $("#divfolio").show();
                $("#divperiodo").hide();
                break;
        }
    });
    $("#idTipAps").change(function () {
        switch ($(this).val()) {

            case "2": //ANTICIPO
                tipoMovimiento = 2;
                if (modEje == 3) { // POR CONTRATO
                    $("#divGuardar").hide();
                    $("#divagregarAnticipo").show();
                    $("#divFuentes").hide();

                    $("#contrato").hide();
                    $("#divContratos").hide();
                    $("#divContratoAnticipo,#tablaFuentesAnticipo").show();

                    $("#divEstimar").hide();
                    $("#divComprobantes").hide();
                    $("#divAmortizar").hide();
                    $("#movimientos").hide();
                    $("#divPresupuestal").hide();

                    buscaAnticipos();
                } else { //POR ADMINISTRACION
                    $("#divGuardar").hide();
                    $("#divagregarAnticipo").show();
                    $("#divAnticipoAdm,#tablaFuentesAnticipo").show();

                    $("#divFuentes").hide();
                    $("#divEstimar").hide();
                    $("#divPagos").hide();
                    $("#divComprobantes").hide();
                    $("#divAmortizar").hide();
                    $("#movimientos").hide();
                    $("#divPresupuestal").hide();
                }

                break;
            case "4": //ESTIMACION
                tipoMovimiento = 4;
                $("#divContratos").show();
                $("#contrato").show();
                $("#divContratoAnticipo,#tablaFuentesAnticipo").hide();
                $("#divFuentes").show();
                $("#divEstimar").show();
                $("#divComprobantes").show();
                $("#divAmortizar").hide();
                $("#movimientos").show();
                $("#divPresupuestal").show();
                $("#divagregarAnticipo").hide();
                $("#divGuardar").show();
                break;
            case "6": //PAGO
                tipoMovimiento = 6;
                $("#divagregarAnticipo").hide();
                $("#divAnticipoAdm,#tablaFuentesAnticipo").hide();
                $("#divContratoAnticipo,#tablaFuentesAnticipo").hide();
                $("#divFuentes,#divParaAmortizar").show();
                $("#divEstimar,#generaAmortizacion,#divInfAmort").hide();
                $("#divPagos").show();
                $("#divComprobantes").show();
                $("#divAmortizar").hide();
                $("#movimientos").show();
                $("#divPresupuestal").show();
                $("#divagregarAnticipo,#divCombosParaAmortizar").hide();
                $("#divGuardar").show();
                break;
            case "7": //COMPROBACION
                tipoMovimiento = 7;
                $("#divFuentes").show();
                $("#divComprobantes,#generaAmortizacion").show();
                $("#movimientos").show();
                $("#divPresupuestal").show();
                $("#divGuardar").show();
                $("#divPagos,#divParaAmortizar").hide();
                break;
        }
    });
    $("#afectacionC").change(function () {
        afectacionPresupuestalConcepto();
    });
    cargarCombos();
    $(".edit").each(function () {
        $(this).change(function () {
            calcularAPGeneral(function () {
                if (apGeneral.length > 0) {
                    apGeneral[0]['monto'] = $("#sinivaAp").val().replace(/,/g, "");
                    apGeneral[0]['amortizacion'] = $("#amortizacionAp").val().replace(/,/g, "");
                    apGeneral[0]['subtotal'] = $("#subtotalAp").val().replace(/,/g, "");
                    apGeneral[0]['iva'] = $("#ivaAp").val().replace(/,/g, "");
                    apGeneral[0]['afectPresupuestal'] = $("#afectacionAp").val().replace(/,/g, "");
                    apGeneral[0]['impNeto'] = $("#netoAp").val().replace(/,/g, "");
                    apGeneral[0]['icic'] = $("#icicAp").val().replace(/,/g, "");
                    apGeneral[0]['cmic'] = $("#cmicAp").val().replace(/,/g, "");
                    apGeneral[0]['supervision'] = $("#supervisionAp").val().replace(/,/g, "");
                    apGeneral[0]['ispt'] = $("#isptAp").val().replace(/,/g, "");
                    apGeneral[0]['otro'] = $("#otroAp").val().replace(/,/g, "");
                    apGeneral[0]['retenciones'] = $("#retencionesAp").val().replace(/,/g, "");
                }
            });
        });
    });
    $(".number").each(function () {
        $(this).change(function () {
            $(".number").autoNumeric('init', {vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});
        });
    });
});

function getApById() {

    CveAps = $("#cveAp").val();
    $.ajax({
        data: {'accion': 'getApById', 'CveAps': CveAps},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            var data = jQuery.parseJSON(response);
            if (data) {
                console.log(data);
                $("#idObra").val(data[0].idObr);
                buscaObra(function () {
                    estadoAp = data[0].idEdoAps;
                    $("#observacionesAp").val(data[0].ObsAps);
                    switch (data[0].idEdoAps) {
                        case "3":
                            $("#divGuardar").hide();
                            $("#divCerrar").hide();
                            $("#divagregarMovimiento").hide();
                            $("#updateMovimiento").hide();
                            $("#btnEstimar").hide();
                            $("#divComprobacion").show();
                            $("#divImpresion").show();
                            estadoAp = data[0].idEdoAps;
                            break;
                        case "4":
                            $("#divCerrar").show();
                            estadoAp = data[0].idEdoAps;
                            break;
                        default:
                            $("#divGuardar").hide();
                            $("#divCerrar").hide();
                            $("#divagregarMovimiento").hide();
                            $("#updateMovimiento").hide();
                            $("#btnEstimar").hide();
                            $("#divComprobacion").hide();
                            $("#divImpresion").hide();
                            estadoAp = data[0].idEdoAps;
                        break;
                    }
                    switch (data[0].idTipAps) {
                        case "2": //CARGA DE ANTICIPOS
                            tipoMovimiento = 2;

                            for (var i = 0; i < detalleContrato.length; i++) {
                                if (detalleContrato[i].idContrato === data[0].idContrato) { // SELECCIONAMOS DATOS DEL CONTRATO DEL ARRAY GLOBAL
                                    $("#noContrato").val(detalleContrato[i].numContra);
                                    $("#importeContrato").val(detalleContrato[i].monto);
                                    $("#fechaContrato").val(detalleContrato[i].fecCeleb);
                                    $("#fechaIniContrato").val(detalleContrato[i].fecInicioContr);
                                    $("#fechaFinContrato").val(detalleContrato[i].fecTerminoContr);
                                }
                            }
                            $("#importeContrato").val(data[0].montoAutActual);
                            $("#idTipAps").val(2).attr("readonly", true);
                            buscaAnticipos(function () {
                                $("#movimientos").show();
                                $("#tablaFuentesAnticipo").hide();
                                if (modEje === 3) {
                                    $("#contratoAnticipo").val(data[0].idContrato).attr("readonly", true);
                                    seleccionarBeneficiario();
                                    var tmpNumContrato = $("#noContrato").val();
                                } else {
                                    $("#divContratoAnticipo").hide();
                                    $("#rfcAp").val(data[0].RfcEmp);
                                    $("#beneficiarioAp").val(data[0].NomEmp);
                                    $("#idEmpAp").val(data[0].idEmp);
                                    var tmpNumContrato = 0;
                                }
                                var tmpEjercicio = data[0].Ejercicio;
                                var tmpObr = $("#idObra").val();
                                var tmpNomObr = $("#nomObra").val();
                                var tmpidTipAps = data[0].idTipAps;
                                var tmpDscTipAps = $("#idTipAps option:selected").text();
                                var tmpAfectacion = data[0].montoAp;

                                for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                                    if (detalleFuentes[j].idFte === data[0].idFte) {
                                        var tmpidFte = detalleFuentes[j].idFte;
                                        var tmpDscFte = detalleFuentes[j].DscFte;
                                        var tmpCuentaFte = detalleFuentes[j].cuenta;
                                    }
                                }

                                tablaMovimientos.row.add(["", tmpEjercicio, tmpObr, tmpNumContrato, tmpidTipAps, tmpDscTipAps, '', tmpidFte, tmpDscFte, tmpCuentaFte, tmpAfectacion, "", ""]).draw();
                                tablaMovimientos.columns([0, 4, 6, 7, 11, 12]).visible(false);
                                for (var i = 0; i < data[0]['comprobantes'].length; i++) {
                                    var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
                                    var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
                                    tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal'], editar, eliminar]).draw();
                                }

                                $("#sinivaAp").val(data[0].montoAp).focusin().focusout();
                                $("#ivaAp").val(data[0].Iva).focusin().focusout();
                                $("#icicAp").val(data[0].Icic).focusin().focusout();
                                $("#cmicAp").val(data[0].Cmic).focusin().focusout();
                                $("#supervisionAp").val(data[0].Supervision).focusin().focusout();
                                $("#isptAp").val(data[0].Ispt).focusin().focusout();
                                $("#otroAp").val(data[0].Otro).focusin().focusout();
                                idAps = data[0].idAps;
                                CveAps = data[0].CveAps;
                                NomSec = data[0].NomSec;
                                calcularAPGeneral(function () {
                                    $("#divPresupuestal,#divImpresion").show();
                                    movimientos.idAp = data[0].idAps;
                                    movimientos.CveAps = data[0].CveAps;
                                    movimientos.idTipAps = data[0].idTipAps;
                                    movimientos.dscMov = tmpDscTipAps;
                                    movimientos.idContrato = data[0].idContrato;
                                    movimientos.dscContrato = tmpNumContrato;
                                    movimientos.idFte = tmpidFte;
                                    movimientos.dscFte = tmpDscFte;
                                    movimientos.cuentaFte = tmpCuentaFte;
                                    movimientos.idEmp = $("#idEmpAp").val();
                                    movimientos.rfcEmp = $("#rfcAp").val();
                                    movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                                    movimientos.idObr = tmpObr;
                                    movimientos.dscObr = tmpNomObr;
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
                                    movimientos.comprobantes = data[0].comprobantes;
                                    apGeneral.push(movimientos);
                                    console.log(apGeneral);
                                });
                            });
                            break;

                        case "4": // ESTIMACION
                            tipoMovimiento = 4;

                            for (var i = 0; i < detalleContrato.length; i++) {
                                if (detalleContrato[i].idContrato === data[0].idContrato) { // SELECCIONAMOS DATOS DEL CONTRATO DEL ARRAY GLOBAL
                                    $("#noContrato").val(detalleContrato[i].numContra);
                                    $("#importeContrato").val(detalleContrato[i].monto);
                                    $("#fechaContrato").val(detalleContrato[i].fecCeleb);
                                    $("#fechaIniContrato").val(detalleContrato[i].fecInicioContr);
                                    $("#fechaFinContrato").val(detalleContrato[i].fecTerminoContr);
                                }
                            }
                            $("#importeContrato").val(data[0].montoAutActual);
                            $("#idTipAps").val(4).attr("readonly", true);
                            $("#contrato").val(data[0].idContrato).change().attr("readonly", true);
                            $("#divContratos").show();
                            $("#fuentes").val(data[0].idFte).change().attr("readonly", true);
                            $("#divFuentes").show();
                            $("#divEstimar").show();
                            $("#divComprobantes").show();
                            $("#movimientos").show();
                            $("#divPresupuestal").show();

                            seleccionarBeneficiario();
                            var tmpEjercicio = data[0].Ejercicio;
                            var tmpObr = $("#idObra").val();
                            var tmpNomObr = $("#nomObra").val();
                            var tmpNumContrato = $("#noContrato").val();
                            var tmpidTipAps = data[0].idTipAps.toString();
                            var tmpDscTipAps = $("#idTipAps option:selected").text();
                            var tmpAfectacion = data[0].montoAp;

                            for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                                if (detalleFuentes[j].idFte === data[0].idFte) {
                                    var tmpidFte = detalleFuentes[j].idFte;
                                    var tmpDscFte = detalleFuentes[j].DscFte;
                                    var tmpCuentaFte = detalleFuentes[j].cuenta;
                                }
                            }

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

                            for (var i = 0; i < data[0]['comprobantes'].length; i++) {
                                console.log(data[0]['comprobantes'][i]);
                                var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
                                var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
                                tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal'], editar, eliminar]).draw();
                            }

//                            var tmpAmortMasIva = parseFloat(data[0].montoAmortizacion) 
                            var tmpAmortMasIva = parseFloat(data[0].montoAmortizacion) + parseFloat(data[0].montoIvaAmortizacion);
                            $("#sinivaAp").val(data[0].montoAp);
                            $("#amortizacionAp").val(tmpAmortMasIva);
                            $("#ivaAp").val(data[0].Iva).focusin().focusout();
                            $("#icicAp").val(data[0].Icic).focusin().focusout();
                            $("#cmicAp").val(data[0].Cmic).focusin().focusout();
                            $("#supervisionAp").val(data[0].Supervision).focusin().focusout();
                            $("#isptAp").val(data[0].Ispt).focusin().focusout();
                            $("#otroAp").val(data[0].Otro).focusin().focusout();
                            idAps = data[0].idAps;
                            CveAps = data[0].CveAps;
                            NomSec = data[0].NomSec;
                            calcularAPGeneral(function () {
                                movimientos.idAp = data[0].idAps;
                                movimientos.CveAps = data[0].CveAps;
                                movimientos.idTipAps = $("#idTipAps").val();
                                movimientos.dscMov = $("#idTipAps option:selected").html();
                                movimientos.idContrato = $("#contrato").val();
                                movimientos.dscContrato = $("#contrato option:selected").html();
                                movimientos.idEmp = $("#idEmpAp").val();
                                movimientos.rfcEmp = $("#rfcAp").val();
                                movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                                movimientos.idObr = $("#idObra").val();
                                movimientos.dscObr = $("#nomObra").val();
                                movimientos.idFte = tmpidFte;
                                movimientos.dscFte = tmpDscFte;
                                movimientos.cuentaFte = tmpCuentaFte;
                                movimientos.montosConceptos = data[0].montosConceptos;
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
                                movimientos.comprobantes = data[0].comprobantes;
                                apGeneral.push(movimientos);
                                console.log(apGeneral);
                                movimientos = {};

                                getConceptos(function () {
                                    $("#updateMovimiento").hide();
                                    $("#agregarMovimiento").show();
                                });
                            });

                            tablaMovimientos.row.add(["", tmpEjercicio, tmpObr, tmpNumContrato, tmpidTipAps, tmpDscTipAps, '', tmpidFte, tmpDscFte, tmpCuentaFte, tmpAfectacion, "", ""]).draw();
                            if (data[0].montoAmortizacion > 0) {
                                tablaMovimientos.row.add(["", "", "", "", "1", 'Amortizaci\u00f3n', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoAmortizacion, "", ""]).draw();
                                tablaMovimientos.row.add(["", "", "", "", "5", 'I.V.A.', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoIvaAmortizacion, "", ""]).draw();
                            }
                            tablaMovimientos.columns([0, 4, 6, 7]).visible(false);
                            $("#sinivaAp").val(data[0].montoAp).focusin().focusout();
                            break;

                        case "6":
                            tipoMovimiento = 6;

                            $("#idTipAps").val(6).attr("readonly", true);
                            $("#fuentes").val(data[0].idFte).attr("readonly", true);
                            getFolioParaAmortizar(function () {
                                $("#foliosAmortizar").val(data[0].folioAmortizacion).change();

                                $("#divFuentes").show();
                                $("#divComprobantes").show();
                                $("#movimientos").show();
                                $("#divPresupuestal").show();

                                $("#rfcAp").val(data[0].RfcEmp);
                                $("#idEmpAp").val(data[0].idEmp);
                                $("#beneficiarioAp").val(data[0].NomEmp);
                                var tmpEjercicio = data[0].Ejercicio;
                                var tmpObr = $("#idObra").val();
                                var tmpNomObr = $("#nomObra").val();
                                var tmpidTipAps = data[0].idTipAps.toString();
                                var tmpDscTipAps = $("#idTipAps option:selected").text();
                                var tmpAfectacion = data[0].montoAp;

                                for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                                    if (detalleFuentes[j].idFte === data[0].idFte) {
                                        var tmpidFte = detalleFuentes[j].idFte;
                                        var tmpDscFte = detalleFuentes[j].DscFte;
                                        var tmpCuentaFte = detalleFuentes[j].cuenta;
                                    }
                                }

                                $("#foliosAmortizar").val(data[0].folioAmortizacion).change();
                                $("#montoParaAmortizar").val(data[0].montoAmortizacion);

                                movimientos.montoAmortizacion = data[0].montoAmortizacion;
                                movimientos.montoIvaAmortizacion = data[0].montoIvaAmortizacion;
                                movimientos.folioAmortizacion = data[0].folioAmortizacion;


                                for (var i = 0; i < data[0]['comprobantes'].length; i++) {
                                    console.log(data[0]['comprobantes'][i]);
                                    var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
                                    var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
                                    tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal'], editar, eliminar]).draw();
                                }

//                            var tmpAmortMasIva = parseFloat(data[0].montoAmortizacion) 
                                $("#sinivaAp").val(data[0].montoAp);
                                $("#amortizacionAp").val(data[0].montoAmortizacion);
                                $("#ivaAp").val(data[0].Iva).focusin().focusout();
                                $("#icicAp").val(data[0].Icic).focusin().focusout();
                                $("#cmicAp").val(data[0].Cmic).focusin().focusout();
                                $("#supervisionAp").val(data[0].Supervision).focusin().focusout();
                                $("#isptAp").val(data[0].Ispt).focusin().focusout();
                                $("#otroAp").val(data[0].Otro).focusin().focusout();
                                idAps = data[0].idAps;
                                CveAps = data[0].CveAps;
                                NomSec = data[0].NomSec;
                                calcularAPGeneral(function () {
                                    movimientos.idAp = data[0].idAps;
                                    movimientos.CveAps = data[0].CveAps;
                                    movimientos.idTipAps = $("#idTipAps").val();
                                    movimientos.dscMov = $("#idTipAps option:selected").html();
                                    movimientos.idContrato = data[0].idContrato;
                                    movimientos.dscContrato = "0";
                                    movimientos.idEmp = $("#idEmpAp").val();
                                    movimientos.rfcEmp = $("#rfcAp").val();
                                    movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                                    movimientos.idObr = $("#idObra").val();
                                    movimientos.dscObr = $("#nomObra").val();
                                    movimientos.idFte = tmpidFte;
                                    movimientos.dscFte = tmpDscFte;
                                    movimientos.cuentaFte = tmpCuentaFte;
                                    movimientos.montosConceptos = data[0].montosConceptos;
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
                                    movimientos.comprobantes = data[0].comprobantes;
                                    apGeneral.push(movimientos);
                                    console.log(apGeneral);
                                    movimientos = {};

                                    getConceptos(function () {
                                        $("#updateMovimiento").hide();
                                        $("#agregarMovimiento").show();
                                    });

                                    tablaMovimientos.clear().draw();
                                    tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), apGeneral[0].dscContrato, apGeneral[0].idTipAps, apGeneral[0].dscMov, '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].monto, "", ""]).draw();
                                    if (data[0].montoAmortizacion > 0) {
                                        tablaMovimientos.row.add(["", "", "", "", "1", 'Amortizaci\u00f3n', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoAmortizacion, "", ""]).draw();
                                    }
                                    tablaMovimientos.columns([0, 3, 4, 6, 7]).visible(false);

                                    $("#tablaMontosEst thead tr:eq(0) th:eq(6)").text("Total a Pagar");
                                    $("#tablaMontosEst thead tr:eq(0) th:eq(7)").text("I.V.A.");
                                    $("#tablaMontosEst thead tr:eq(0) th:eq(8)").text("Total Pago con I.V.A.");
                                    $("#tituloDialog").text("Pago de Conceptos");
                                    $("#gridAfectacionPresupuestal div:eq(0)").html("Pago de Concepto");
                                    $("#estGeneral div:eq(0)").html("Pago General");

                                    $("#dialogEstimacion").modal('hide');
                                    $("#sinivaAp").val(data[0].montoAp).focusin().focusout();
                                    $("#divCombosParaAmortizar").show();

                                });
                            });
                            break;

                        case "7": // COMPROBACION
                            tipoMovimiento = 7;

                            $("#idTipAps").val(7).attr("readonly", true);
                            $("#fuentes").val(data[0].idFte).attr("readonly", true);
                            getFolioParaAmortizar(function () {
                                $("#foliosAmortizar").val(data[0].folioAmortizacion).change();

                                $("#divFuentes").show();
                                $("#divComprobantes").show();
                                $("#movimientos").show();
                                $("#divPresupuestal").show();

                                $("#rfcAp").val(data[0].RfcEmp);
                                $("#idEmpAp").val(data[0].idEmp);
                                $("#beneficiarioAp").val(data[0].NomEmp);
                                var tmpEjercicio = data[0].Ejercicio;
                                var tmpObr = $("#idObra").val();
                                var tmpNomObr = $("#nomObra").val();
                                var tmpidTipAps = data[0].idTipAps.toString();
                                var tmpDscTipAps = $("#idTipAps option:selected").text();
                                var tmpAfectacion = data[0].montoAp;

                                for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                                    if (detalleFuentes[j].idFte === data[0].idFte) {
                                        var tmpidFte = detalleFuentes[j].idFte;
                                        var tmpDscFte = detalleFuentes[j].DscFte;
                                        var tmpCuentaFte = detalleFuentes[j].cuenta;
                                    }
                                }

                                movimientos.montoAmortizacion = data[0].montoAmortizacion;
                                movimientos.montoIvaAmortizacion = data[0].montoIvaAmortizacion;
                                movimientos.folioAmortizacion = data[0].folioAmortizacion;


                                for (var i = 0; i < data[0]['comprobantes'].length; i++) {
                                    console.log(data[0]['comprobantes'][i]);
                                    var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
                                    var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
                                    tablaComprobantes.row.add([data[0]['comprobantes'][i]['idAps'], data[0]['comprobantes'][i]['folio'], data[0]['comprobantes'][i]['tipoDocumento'], data[0]['comprobantes'][i]['importe'], data[0]['comprobantes'][i]['partidaPresupuestal'], editar, eliminar]).draw();
                                }

//                            var tmpAmortMasIva = parseFloat(data[0].montoAmortizacion) 
                                $("#sinivaAp").val(data[0].montoAp);
                                $("#amortizacionAp").val(data[0].montoAmortizacion);
                                $("#ivaAp").val(data[0].Iva).focusin().focusout();
                                $("#icicAp").val(data[0].Icic).focusin().focusout();
                                $("#cmicAp").val(data[0].Cmic).focusin().focusout();
                                $("#supervisionAp").val(data[0].Supervision).focusin().focusout();
                                $("#isptAp").val(data[0].Ispt).focusin().focusout();
                                $("#otroAp").val(data[0].Otro).focusin().focusout();
                                idAps = data[0].idAps;
                                CveAps = data[0].CveAps;
                                NomSec = data[0].NomSec;
                                calcularAPGeneral(function () {
                                    movimientos.idAp = data[0].idAps;
                                    movimientos.CveAps = data[0].CveAps;
                                    movimientos.idTipAps = $("#idTipAps").val();
                                    movimientos.dscMov = $("#idTipAps option:selected").html();
                                    movimientos.idContrato = data[0].idContrato;
                                    movimientos.dscContrato = "0";
                                    movimientos.idEmp = $("#idEmpAp").val();
                                    movimientos.rfcEmp = $("#rfcAp").val();
                                    movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                                    movimientos.idObr = $("#idObra").val();
                                    movimientos.dscObr = $("#nomObra").val();
                                    movimientos.idFte = tmpidFte;
                                    movimientos.dscFte = tmpDscFte;
                                    movimientos.cuentaFte = tmpCuentaFte;
                                    movimientos.montosConceptos = data[0].montosConceptos;
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
                                    movimientos.comprobantes = data[0].comprobantes;
                                    apGeneral.push(movimientos);
                                    console.log(apGeneral);
                                    movimientos = {};

                                    getConceptos(function () {
                                        $("#updateMovimiento").hide();
                                        $("#agregarMovimiento").show();
                                    });

                                    tablaMovimientos.clear().draw();
                                    tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), apGeneral[0].dscContrato, apGeneral[0].idTipAps, apGeneral[0].dscMov, '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].monto, "", ""]).draw();
                                    tablaMovimientos.columns([0, 3, 4, 6, 7]).visible(false);

                                    $("#tablaMontosEst thead tr:eq(0) th:eq(8)").text("Total a Comprobar");
                                    tablaEstimaciones.column(8).visible(false);
                                    tablaEstimaciones.column(9).visible(false);

                                    $("#tituloDialog").text("Comprobaci\u00f3n de Conceptos");

                                    $("#gridAfectacionPresupuestal div:eq(0)").html("Comprobaci\u00f3n de Concepto");
                                    $("#tConcepto,#iConcepto").hide();
                                    $("#stConcepto label").text("Total");

                                    $("#estGeneral div:eq(0)").html("Comprobaci\u00f3n General");
                                    $("#tEstimar,#iEstimar").hide();
                                    $("#stEstimar label").text("Total");

                                    $("#divInfAmort").show();
                                    $("#mntAm").text($("#montoPorAmortizar").val());

                                    $("#dialogEstimacion").modal('hide');
                                    $("#sinivaAp").val(data[0].montoAp).focusin().focusout();
                                    $("#generaAmortizacion").hide();

                                });
                            });
                            break;
                    }
                });
            } else {
                bootbox.alert("No existe esa Autorizaci\u00f3n de Pago");
            }

        },
        error: function (response) {
        }
    });
    eliminaWaitGeneral();
}

function cargarCombos() {
    $.ajax({
        data: {'accion': 'getCombos'},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            var data = jQuery.parseJSON(response);
            $("#periodo").html(data[0]);
            $("#idTipAps").html(data[1]);
            $("#ejecutoraAp").val(data[2]);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscaRfc(RfcEmp) {
    $.ajax({
        data: {'accion': 'consultaEmpresa', 'RfcEmp': RfcEmp},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {

            var data = jQuery.parseJSON(response);
            console.log(data);
            if (data.NomEmp) {
                $("#beneficiarioAp").val(data.NomEmp);
                $("#idEmpAp").val(data.idEmp);
                for (var i = 0; i < apGeneral.length; i++) {
                    apGeneral[i]['idEmp'] = data.idEmp;
                }
                eliminaMensajePop($("#rfcAp"));
            } else {
                alert("No existe el RFC seleccionado");
                $("#idEmpAp,#beneficiarioAp").val('');
                $("#rfcAp").focus();

            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscaObra(callback) {
    colocaWaitGeneral();
    var idObr = $("#idObra").val();
    var ejercicio = $("#periodo").val();
    $.ajax({
        data: {'accion': 'getObraById', 'idObr': idObr, 'ejercicio': ejercicio},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            if (response !== 'false') {
                var data = jQuery.parseJSON(response);
//                console.log(data);
                $("#conGeneral").show();
                if (data.obra[0].IdModEje == "3") { // CONTRATO
                    modEje = 3;
                    $("#modEje").val('Contrato');
                    $("#idTipAps option[value='1']").remove();
                    $("#idTipAps option[value='6']").remove();
                    $("#idTipAps option[value='7']").remove();
                    $("#contrato").html(data.comboContratos);
                    detalleContrato = data.contratos;
                } else { // POR ADMINISTRACION
                    modEje = 2
                    $("#modEje").val('Administraci\u00f3n');
                    $("#idTipAps option[value='1']").remove();
                    $("#idTipAps option[value='4']").remove();
                    $("#montoObraAdm").val(data.obra[0].MontoAutorizado).focusin().focusout();
                    $("#montoDisponibleObraAdm").val(data.obra[0].MontoDisponible).focusin().focusout();
                }
                idSol = data.obra[0].VerExpTec;
                $("#fuentes").html(data.fuentes);
                detalleFuentes = data.montosFuentes;
                $("#nomObra").val(data.obra[0].NomObr);
                $("#preAutorizado").val(data.obra[0].MontoAutorizado);

            } else {
                bootbox.alert("La obra no cuenta con oficios de autorizaci\u00f3n firmados o no cuenta con suficiencia econ\u00f3mica disponible");
            }
            if (typeof (callback) != "undefined") {
                callback();
            }
            ;

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
    eliminaWaitGeneral();

}

function getFolioParaAmortizar(callback) {
    colocaWaitGeneral();
    var idObr = $("#idObra").val();
    var idFte = $("#fuentes").val();
    $.ajax({
        data: {'accion': 'getFolioParaAmortizar', 'idObr': idObr, 'idFte': idFte, 'idSol': idSol},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            console.log(data);
            if (data) {
                if (modEje === 3) {//POR CONTRATO
                    if (data[0].porComprobar > 0.00) { // SI FALTA POR COMPROBAR SE CREA UNA AMORTIZACION
                        $("#CveApAmortizar").text(data[0].CveAps);
                        $("#folioParaAmortizar").val(data[0].idAp);
                        $("#divFolioParaAmortizar").show();
                    } else {  // SI NO FALTA POR COMPROBAR SOLO SE REALIZA LA ESTIMACION
                        alert("ya se amortizo todo");
                    }
                } else {
                    arrayFoliosAmortizarAdm = [];
                    $("#montoPorAmortizar").val(0).focusin().focusout();
                    $("#foliosAmortizar option").remove();
                    $('#foliosAmortizar').append($('<option>', {
                        value: -1,
                        text: "Seleccione..."
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#foliosAmortizar').append($('<option>', {
                            value: data[i].idAp,
                            text: data[i].CveAps
                        }));
                        arrayFoliosAmortizarAdm.push([data[i].idAp, data[i].porComprobar]);
                    }
                    $("#divCombosParaAmortizar").show();
                    if (tipoMovimiento === 6) {
                        $("#divCombosParaAmortizar").hide();
                        $("#generaAmortizacion").hide();
                        $("#montoPorAmortizar").show();
                        $("#divParaAmortizar").show();

                    }
                    if (typeof (callback) != "undefined") {
                        callback();
                    }
                    ;
                }
            } else {
                bootbox.alert("No hay anticipos registrados y/o aceptados para esa fuente");
                $("#divFolioParaAmortizar").hide();
                $("#CveApAmortizar").text('');
                $("#folioParaAmortizar").val('');
                $("#btnPagos").hide();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
    eliminaWaitGeneral();
}

function setDisponibleAmortizar() {
    var tmpFolio = $("#foliosAmortizar").val();
    console.log(arrayFoliosAmortizarAdm);
    for (var i = 0; i < arrayFoliosAmortizarAdm.length; i++) {
        if (tmpFolio === arrayFoliosAmortizarAdm[i][0]) {
            $("#montoPorAmortizar").val(arrayFoliosAmortizarAdm[i][1]).focusin().focusout();
        }
    }
}

function verificaMontoAmort() {
    $("#generaAmortizacion").hide();
    var montoParaAmortizar = $("#montoParaAmortizar").val().replace(/,/g, "");
    var montoPorAmortizar = $("#montoPorAmortizar").val().replace(/,/g, "");
    console.log(montoParaAmortizar);
    console.log(montoPorAmortizar);
    if (parseFloat(montoParaAmortizar) > parseFloat(montoPorAmortizar)) {
        colocaMensajePop($("#montoPorAmortizar"), "Error", "El monto supera el monto por amortizar.","top");
        $("#agregarAmortizacion").hide();
    } else {
        eliminaMensajePop($("#montoPorAmortizar"));
        $("#agregarAmortizacion").show();
    }
}

function seleccionarBeneficiario() {
    switch (tipoMovimiento) {
        case 2:
            var idContrato = $("#contratoAnticipo").val();
            for (var i = 0; i < detalleContrato.length; i++) {
                if (idContrato === detalleContrato[i].idContrato) {
                    $("#rfcAp").val(detalleContrato[i].RfcEmp);
                    $("#idEmpAp").val(detalleContrato[i].idEmp);
                    $("#beneficiarioAp").val(detalleContrato[i].NomEmp);
                }
            }
            break;
        case 4:
            var idContrato = $("#contrato").val();
            for (var i = 0; i < detalleContrato.length; i++) {
                if (idContrato === detalleContrato[i].idContrato) {
                    $("#rfcAp").val(detalleContrato[i].RfcEmp);
                    $("#idEmpAp").val(detalleContrato[i].idEmp);
                    $("#beneficiarioAp").val(detalleContrato[i].NomEmp);
                }
            }
            break;
    }

}

function buscaAnticipos(callback) {
    $.ajax({
        data: {'accion': 'getContratoAnticipo', 'idSol': idSol},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            var data = jQuery.parseJSON(response);
//            console.log(data);
            if (data.comboContratos !== "0") { //LLenar select contratos
                importesAnticipos = data.importes;
                $("#contratoAnticipo").html(data.comboContratos);
                $("#divContratoAnticipo").show();
            } else {
                console.log("no");
            }
            if (typeof (callback) != "undefined") {
                callback();
            }
            ;
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function calculaAnticipoFuente() {
    anticipoFuentes = [];
    if (modEje === 3) { // POR CONTRATO
        var idContrato = $("#contratoAnticipo").val();
        var anticipoTotal = 0;
        var anticipoPorFuente = 0;
        var porcentaje = 0.00000;
        console.log(importesAnticipos);
        for (var i = 0; i < importesAnticipos.length; i++) {
            if (idContrato === importesAnticipos[i][0]) {
                anticipoTotal = parseFloat(importesAnticipos[i][1]).toFixed(2); //BUSCAMOS EL ANTICIPO GENERAL EN EL ARRAY
                for (var j = 0; j < importesAnticipos[i][2].length; j++) { //BUCAMOS EN CADA FUENTE SU PORCENTAJE
                    porcentaje = importesAnticipos[i][2][j][3];
                    anticipoPorFuente = (anticipoTotal * porcentaje) / 100;
                    anticipoPorFuente = anticipoPorFuente.toFixed(2);
                    //LLENAMOS EL ARRAY QUE CONTIENE IDFTE,MONTO DE ANTICIPO
                    anticipoFuentes.push([importesAnticipos[i][2][j][0], anticipoPorFuente]);
                    tablaFuentesAnticipo.row.add([importesAnticipos[i][2][j][0], importesAnticipos[i][2][j][2], importesAnticipos[i][2][j][4], anticipoPorFuente, ""]).draw();
                }
            }
        }
        if (anticipoTotal > 0) {
            $("#montoTotalAnticipo").val(anticipoTotal);
            //VERIFICAR LA SUMA DE LAS FUENTES SEA IGUAL ANTICIPO GENERAL
            //SI ES MAYOR, RESTARSELO A LA ULTIMA FUENTE
            //SI ES MENOR, SUMARSELO A LA ULTIMA FUENTE 
            for (var i = 0; i < detalleContrato.length; i++) {
                if (idContrato === detalleContrato[i].idContrato) {
                    $("#importeContrato").val(detalleContrato[i].montoAutActual);
                    $("#noContrato").val(detalleContrato[i].numContra);
                    $("#fechaContrato").val(detalleContrato[i].fecCeleb);
                }
            }
            $("#agregarAnticipo").show();
        } else {
            bootbox.alert("Atenci\u00f3n: Ya se generaron los anticipos de ese contrato.");
            $("#agregarAnticipo").hide();
        }
    } else { // POR ADMINISTRACION
        tablaFuentesAnticipo.clear().draw();
        var montoTotalObra = $("#montoObraAdm").val().replace(/,/g, "");
        var anticipoPorFuente = 0.00;
        var porcentajeFuente = 0.00000;
        var montoTotalAnticipo = $("#montoAnticipoAdm").val().replace(/,/g, "");
        // VERIFICAMOS QUE EL MONTO DE ANTICIPO SEA MENOR QUE EL DISPONIBLE
        if (montoTotalAnticipo > parseFloat($("#montoDisponibleObraAdm").val().replace(/,/g, ""))) {
            colocaMensajePop($("#montoAnticipoAdm"), "Error", "El monto de anticipo es mayor al monto disponible","top");
            return false;
        } else {
            eliminaMensajePop($("#montoAnticipoAdm"));
            $("#montoTotalAnticipo").val(montoTotalAnticipo);
            for (var i = 0; i < detalleFuentes.length; i++) {
                anticipoPorFuente = 0.00;
                porcentajeFuente = detalleFuentes[i]['pjeInv'];
                anticipoPorFuente = (montoTotalAnticipo * porcentajeFuente) / 100;
                anticipoPorFuente = anticipoPorFuente.toFixed(2);
                //LLENAMOS EL ARRAY QUE CONTIENE IDFTE,MONTO DE ANTICIPO
                anticipoFuentes.push([detalleFuentes[i]['idFte'], anticipoPorFuente]);
                tablaFuentesAnticipo.row.add([detalleFuentes[i]['idFte'], detalleFuentes[i]['DscFte'], detalleFuentes[i]['cuenta'], anticipoPorFuente, ""]).draw();

            }
        }
    }
}

function getConceptos(callback) {
    var idFte = $("#fuentes").val();
    if (modEje === 3) {// CONTRATO
        var idContrato = $("#contrato").val();
        $.ajax({
            data: {idContrato: idContrato, idFte: idFte, accion: "getConceptos"},
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {
                var dataConceptos = $.parseJSON(response);
                console.log("CONCEPTOS:");
                console.log(dataConceptos);
                relConceptoFuentes = dataConceptos.fuentes;
                tablaConceptos.clear().draw();
                for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                    tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, dataConceptos.conceptos[i].disponibleConcepto, "<input type='checkbox' id='concepto" + i + "' class='seleccion' value='" + i + "'>"]).draw();
                }
                tablaConceptos.column(0).visible(false);
                if (typeof (callback) != "undefined") {
                    callback();
                }
                ;
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    } else {//ADMINISTRACION
        $.ajax({
            data: {idFte: idFte, idSol: idSol, accion: "getConceptosFuente"},
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {
                var dataConceptos = $.parseJSON(response);
//                console.log("CONCEPTOS:");
//                console.log(dataConceptos);

//                $("#tablaMontosEst thead tr:eq(0) th:eq(9)").text("Total a Comprobar");
                relConceptoFuentes = dataConceptos.fuentes;
                tablaConceptos.clear().draw();
                for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                    tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, dataConceptos.conceptos[i].disponibleConcepto, "<input type='checkbox' id='concepto" + i + "' class='seleccion' value='" + i + "'>"]).draw();
                }
                tablaConceptos.column(0).visible(false);
                if (typeof (callback) != "undefined") {
                    callback();
                }
                ;
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }

}

function agregarConceptos(callback) {
    $("#tablaConceptos").find(".seleccion:checked").each(function () {
        var index = $(this).val();
        var baux = false;
        var conceptosEnEstimacion = tablaEstimaciones.column(1).data();
        for (var a = 0; a < conceptosEnEstimacion.length; a++) {
            if (conceptosEnEstimacion[a] === tablaConceptos.cell(index, 0).data()) { // VERIFICAMOS Q EL CONCEPTO NO ESTE EN LA TABLA ESTIMACION
                baux = true;
            }
        }
        if (!baux) {
            var montosFteConcepto = new Array();
            var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
            tablaEstimaciones.row.add(["", tablaConceptos.cell(index, 0).data(), tablaConceptos.cell(index, 1).data(), tablaConceptos.cell(index, 2).data(), tablaConceptos.cell(index, 6).data(), tablaConceptos.cell(index, 7).data(), tablaConceptos.cell(index, 8).data(), tablaConceptos.cell(index, 9).data(), 0.00, 0.00, 0.00, eliminar]).draw();
            $(this).prop("checked", false);
        }

    });
    $("#dialogConceptos").modal("hide");
    $("#dialogEstimacion").modal();
    if (typeof (callback) != "undefined") {
        callback();
    }
    ;
}

function mostrarGridAPresu(total, iva, totalciva) {
    eliminaMensajePop($("#agregarMovimiento"));
    $("#totalEstCon").val(total).focusin().focusout();
    $("#ivaEstCon").val(iva).focusin().focusout();
    $("#totalEstIvaCon").val(totalciva).focusin().focusout();

    $(".inputAfectPresu").each(function () {
        $(this).unbind('change').change(function () {
            despachadorFunciones(
                    calcularEstimacionConcepto(),
                    calcularTotalEstimacion()
                    );

        });
    });
    $("#gridAfectacionPresupuestal").show();
}

function despachadorFunciones(f1, f2, f3, f4) {
    if (typeof (f1) !== "undefined") {
        f1();
    }
    ;
    if (typeof (f2) !== "undefined") {
        f2();
    }
    ;
    if (typeof (f3) !== "undefined") {
        f3();
    }
    ;
    if (typeof (f4) !== "undefined") {
        f4();
    }
    ;
}

function calcularEstimacionConcepto() {
    var totalEstimar = $("#totalEstCon").val().replace(/,/g, "");
    var totalIva = $("#ivaEstCon").val().replace(/,/g, "");
    var totalConIva = parseFloat(totalEstimar) + parseFloat(totalIva);
    $("#totalEstIvaCon").val(totalConIva);
    var indxConcepto = $("#indexConceptos").val();
    if (totalConIva > tablaEstimaciones.cell(indxConcepto, 7).data()) {
        colocaMensajePop($("#totalEstCon"), "Error", "Se ha superado el monto disponible","left");
        errorMonto = true;
        return false;
    } else {
        errorMonto = false;
        eliminaMensajePop($("#totalEstCon"));
    }

    tablaEstimaciones.cell(indxConcepto, 8).data(totalEstimar).draw();
    tablaEstimaciones.cell(indxConcepto, 9).data(totalIva).draw();
    tablaEstimaciones.cell(indxConcepto, 10).data(totalConIva).draw();
    $(".number").autoNumeric('update');
//    calcularTotalEstimacion();
}

function calcularTotalEstimacion() {
    var totalEstimacion = 0.00;
    var totalIva = 0.00;
    var totalConIva = 0.00;
//    console.log(tablaEstimaciones);

    for (var i = 0; i < tablaEstimaciones.column(0).data().length; i++) {
        totalEstimacion = parseFloat(totalEstimacion) + ((tablaEstimaciones.cell(i, 8).data() == "") ? 0 : parseFloat(tablaEstimaciones.cell(i, 8).data()));
        totalIva = parseFloat(totalIva) + ((tablaEstimaciones.cell(i, 9).data() == "") ? 0 : parseFloat(tablaEstimaciones.cell(i, 9).data()));
        totalConIva = parseFloat(totalConIva) + ((tablaEstimaciones.cell(i, 10).data() == "") ? 0 : parseFloat(tablaEstimaciones.cell(i, 10).data()));
    }
    $("#totalEstimar").val(totalEstimacion);
    $("#ivaEstimar").val(totalIva);
    $("#totalConIva").val(totalConIva);
    $(".number").autoNumeric('update');
    if (modEje === 2 && tipoMovimiento === 7)//ADMINISTRACION y COMPROBACION
    {
        var porAmortizar = $("#montoPorAmortizar").val().replace(/,/g, "");
        if (totalConIva > porAmortizar) {
            colocaMensajePop($("#totalEstimar"), "Atenci\u00f3n", "El monto de comprobaci\u00f3n es mayor al monto por amortizar","left");
            $("#agregarMovimiento").show();
            return;
        } else {
            eliminaMensajePop($("#totalEstimar"));
//            switch (estadoAp) {
//                case "4":
//                    if (idAps !== 0) {
//                        $("#agregarMovimiento").hide();
//                        $("#updateMovimiento").show();
//                    }else{
//                        $("#agregarMovimiento").show();
//                        $("#updateMovimiento").hide();
//                    }
//                    eliminaMensajePop($("#totalEstimar"));
//                    break;
//                case "3":
//                    $("#agregarMovimiento").hide();
//                    $("#btnAgregaConceptoEst").hide();
//                    break;
//                default :
//                    $("#agregarMovimiento").show();
//                    eliminaMensajePop($("#totalEstimar"));
//                    break;
//            }
        }
    }

    if (tipoMovimiento === 6) {
        for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
            if (detalleFuentes[j].idFte === $("#fuentes").val()) {
                var montoDisponiblePago = detalleFuentes[j].disponible;
            }
        }
        console.log(detalleFuentes);
        if (parseFloat(totalConIva) > parseFloat(montoDisponiblePago)) {
            colocaMensajePop($("#agregarMovimiento"), "Atenci\u00f3n", "Se super\u00f3 el monto disponible de la fuente: $" + montoDisponiblePago,"left");
            return;
        } else {
            eliminaMensajePop($("#agregarMovimiento"));
        }
    }
}

function eliminarMovimientos() {
    bootbox.confirm("Se eliminar\u00e1n las estimaciones realizadas, \u00BFDesea continuar?", function (response) {
        if (response) {
            tablaMovimientos.clear().draw();
            $("#totalEstimar").val(0.00).focusin().focusout();
            $("#ivaEstimar").val(0.00).focusin().focusout();
            $("#totalConIva").val(0.00).focusin().focusout();
            $(".afectPresu").each(function () {
                $(this).val(0.00).focusin().focusout();
            });
            $("#letranetoAp").val("");
            apGeneral = [];
            movimientos = {};
            if (tipoMovimiento === 7) {
                $("#generaAmortizacion").show();
            }
            if (tipoMovimiento === 6) {
                $("#divPagos").show();
                tablaEstimaciones.clear().draw();
                $("#divCombosParaAmortizar").hide();
            }
        }
    });
}

function eliminar(elem, id, monto) {
    switch (tipoMovimiento) {
        case 1://AMORTIZACION
            break;
        case 2: //ANTICIPO
            var indiceEliminar = tablaMovimientos.row($(elem).parent().parent()).index();
            tablaMovimientos.row(indiceEliminar).remove().draw();
            $("#sinivaAp").val('0.00');
            $("#amortizacionAp").val('0.00');
            $("#subtotalAp").val('0.00');
            $("#ivaAp").val('0.00');
            $("#afectacionAp").val('0.00');
            $("#netoAp").val('0.00');
            $("#icicAp").val('0.00');
            $("#cmicAp").val('0.00');
            $("#supervisionAp").val('0.00');
            $("#isptAp").val('0.00');
            $("#otroAp").val('0.00');
            $("#retencionesAp").val('0.00');
            var newMontoAnticipo = parseFloat($("#anticipoDisponible").val().replace(/,/g, "")) + parseFloat(monto);
            $("#anticipoDisponible").val(newMontoAnticipo).focusin().focusout();
            if (id !== -1) {
                alert("SI ID");
                movimientosEliminados.push(id);
            } else {
                alert("No ID");
            }
            apGeneral['anticipo'] = null;
            $("#agregarAnticipo").show();
            break;
        case 4: //ESTIMACION
            var indiceEliminar = tablaEstimaciones.row($(elem).parent().parent()).index();
            $(elem).parent().parent().unbind("click");
            tablaEstimaciones.row(indiceEliminar).remove().draw();
            $("#gridAfectacionPresupuestal").hide();
            calcularTotalEstimacion();
            break;
        case 6: //PAGO
            var indiceEliminar = tablaEstimaciones.row($(elem).parent().parent()).index();
            $(elem).parent().parent().unbind("click");
            tablaEstimaciones.row(indiceEliminar).remove().draw();
            $("#gridAfectacionPresupuestal").hide();
            calcularTotalEstimacion();
            $("#divPagos").show();
            break;
        case 7: //COMPROBACION
            var indiceEliminar = tablaEstimaciones.row($(elem).parent().parent()).index();
            $(elem).parent().parent().unbind("click");
            tablaEstimaciones.row(indiceEliminar).remove().draw();
            $("#gridAfectacionPresupuestal").hide();
            calcularTotalEstimacion();
            break;
    }
}

function editarIvaAmortizacion(elem, iva) {
    console.log(iva);
    $(elem).popover({
        content: '<div class="row form-group" style="width:200px"><div class="col-md-12"><input type="text" id="ivaScroll" value=' + iva + ' class="form-control col-md-12"></div></div>\n\
                    <div class="row form-group"><span class="btn btn-primary glyphicon glyphicon-ok col-md-offset-5" onClick="ajustaIvaAmortizacion();"></span></div>',
        trigger: "manual",
        placement: "bottom",
        title: "IVA",
        html: true
    });
    $(elem).popover("show");

    $("#ivaScroll").TouchSpin({
        min: iva - 1,
        max: iva + 1,
        step: 0.01,
        decimals: 2,
        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus'
    });
}

function ajustaIvaAmortizacion() {

    var amortVieja = tablaMovimientos.cell(1, 10).data();
    var ivaNuevo = $("#ivaScroll").val();
    var amortNueva = parseFloat(amortVieja) + parseFloat(ivaNuevo);
    apGeneral[0].montoIvaAmortizacion = ivaNuevo,
            tablaMovimientos.cell(2, 10).data(ivaNuevo).draw();
    $("#amortizacionAp").val(amortNueva).focusin().focusout();
    calcularAPGeneral();
    $("#tablaMovimientos").find("[aria-describedby]").each(function () {
        $(this).popover("hide");
        $(this).popover("destroy");
    });

}

function agregarAmortizacion() {
    apGeneral = [];
    for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
        if (detalleFuentes[j].idFte === $("#fuentes").val()) {
            var tmpidFte = detalleFuentes[j].idFte;
            var tmpDscFte = detalleFuentes[j].DscFte;
            var tmpCuentaFte = detalleFuentes[j].cuenta;
        }
    }

    movimientos.montoAmortizacion = $("#montoParaAmortizar").val().replace(/,/g, "");
    movimientos.montoIvaAmortizacion = 0.00;
    movimientos.folioAmortizacion = $("#foliosAmortizar").val();


    var tmpArray = new Array(); // REGISTRAMOS LOS CONCEPTOS Y SUS ESTIMACIONES
    for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
        tmpArray.push([tablaEstimaciones.cell(i, 1).data(), tablaEstimaciones.cell(i, 8).data(), tablaEstimaciones.cell(i, 9).data(), tablaEstimaciones.cell(i, 10).data()]);
    }

    $("#amortizacionAp").val(movimientos.montoAmortizacion);
    calcularAPGeneral(function () {
        movimientos.idAp = idAps;
        movimientos.CveAps = CveAps;
        movimientos.idTipAps = $("#idTipAps").val();
        movimientos.dscMov = $("#idTipAps option:selected").html();
        movimientos.idContrato = "0";
        movimientos.dscContrato = "0";
        movimientos.idEmp = $("#idEmpAp").val();
        movimientos.rfcEmp = $("#rfcAp").val();
        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
        movimientos.idObr = $("#idObra").val();
        movimientos.dscObr = $("#nomObra").val();
        movimientos.idFte = tmpidFte;
        movimientos.dscFte = tmpDscFte;
        movimientos.cuentaFte = tmpCuentaFte;
        movimientos.montosConceptos = tmpArray;
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
        movimientos = {};
    });

    tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), "", "1", 'Amortizaci\u00f3n', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoAmortizacion, "", ""]).draw();
    tablaMovimientos.columns([0, 4, 6, 7]).visible(false);
    $("#dialogEstimacion").modal('hide');
    $("#divGuardar").show();
    $("#agregarAmortizacion").hide();
    $("#montoParaAmortizar").attr("readonly", "readonly");

}

function eliminarAmortizacion(elem) {
    var indiceEliminar = tablaMovimientos.row($(elem).parent().parent()).index();
    tablaMovimientos.row(indiceEliminar).remove().draw();
    $("#montoParaAmortizar").removeAttr("readonly").change();
    if (apGeneral[0]['idAps'] !== "") {
        for (var j = 0; j < apGeneral[0].montosConceptos.length; j++) {
            for (var k = 0; k < tablaConceptos.column(0).data().length; k++) {
                if (tablaConceptos.cell(k, 0).data() === apGeneral[0].montosConceptos[j][0]) {
                    $("#concepto" + k).prop('checked', true);
                }
            }
        }

        $("#tablaConceptos").find(".seleccion:checked").each(function () {
            var index = $(this).val();
            var baux = false;
            var conceptosEnEstimacion = tablaEstimaciones.column(1).data();
            for (var a = 0; a < conceptosEnEstimacion.length; a++) {
                if (conceptosEnEstimacion[a] === tablaConceptos.cell(index, 0).data()) { // VERIFICAMOS Q EL CONCEPTO NO ESTE EN LA TABLA ESTIMACION
                    baux = true;
                }
            }
            if (!baux) {
                var montosFteConcepto = new Array();
                var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
                tablaEstimaciones.row.add(["", tablaConceptos.cell(index, 0).data(), tablaConceptos.cell(index, 1).data(), tablaConceptos.cell(index, 2).data(), tablaConceptos.cell(index, 6).data(), tablaConceptos.cell(index, 7).data(), tablaConceptos.cell(index, 8).data(), tablaConceptos.cell(index, 9).data(), 0.00, 0.00, 0.00, eliminar]).draw();
                $(this).prop("checked", false);
            }

        });


        for (var l = 0; l < apGeneral[0].montosConceptos.length; l++) {
            tablaEstimaciones.cell(l, 8).data(apGeneral[0].montosConceptos[l][1]).draw();
            tablaEstimaciones.cell(l, 9).data(apGeneral[0].montosConceptos[l][2]).draw();
            tablaEstimaciones.cell(l, 10).data(apGeneral[0].montosConceptos[l][3]).draw();
            $("#indexConceptos").val(l);
        }


    }
    agregarMovimiento("update");
}

function agregarMovimiento(accion, index, callback) {

    switch (tipoMovimiento) {
        case 1: //AMORTIZACION
            if (accion === "update") {
                apGeneral = [];
            }

            for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                if (detalleFuentes[j].idFte === $("#fuentes").val()) {
                    var tmpidFte = detalleFuentes[j].idFte;
                    var tmpDscFte = detalleFuentes[j].DscFte;
                    var tmpCuentaFte = detalleFuentes[j].cuenta;
                }
            }

            movimientos.montoAmortizacion = $("#montoParaAmortizar").val().replace(/,/g, "");
            movimientos.montoIvaAmortizacion = 0.00;
            movimientos.folioAmortizacion = $("#foliosAmortizar").val();


            var tmpArray = new Array(); // REGISTRAMOS LOS CONCEPTOS Y SUS ESTIMACIONES

            $("#amortizacionAp").val(movimientos.montoAmortizacion);
            calcularAPGeneral(function () {
                movimientos.idAp = idAps;
                movimientos.CveAps = CveAps;
                movimientos.idTipAps = $("#idTipAps").val();
                movimientos.dscMov = $("#idTipAps option:selected").html();
                movimientos.idContrato = "0";
                movimientos.dscContrato = "0";
                movimientos.idEmp = $("#idEmpAp").val();
                movimientos.rfcEmp = $("#rfcAp").val();
                movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                movimientos.idObr = $("#idObra").val();
                movimientos.dscObr = $("#nomObra").val();
                movimientos.idFte = tmpidFte;
                movimientos.dscFte = tmpDscFte;
                movimientos.cuentaFte = tmpCuentaFte;
                movimientos.montosConceptos = tmpArray;
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
                movimientos = {};
            });

            tablaMovimientos.clear().draw();
            tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), "", "1", 'Amortizaci\u00f3n', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoAmortizacion, "", ""]).draw();
            tablaMovimientos.columns([0, 4, 6, 7]).visible(false);
            $("#dialogEstimacion").modal('hide');
            $("#divGuardar").show();
            $("#generaAmortizacion").hide();
            break;
        case 2: //ANTICIPO
            apGeneral = [];
            var montoAnticipo = $("#montoTotalAnticipo").val().replace(/,/g, "");
            if (montoAnticipo !== "0.00") {
                for (var i = 0; i < anticipoFuentes.length; i++) {
                    $("#sinivaAp").val(anticipoFuentes[i][1]).focusin().focusout();
                    calcularAPGeneral(function () {
                        movimientos.idAp = idAps;
                        movimientos.idTipAps = $("#idTipAps").val();
                        movimientos.dscMov = $("#idTipAps option:selected").html();
                        if (modEje === 3) { // POR CONTRATO
                            movimientos.idContrato = $("#contratoAnticipo").val();
                            movimientos.dscContrato = $("#contratoAnticipo option:selected").html();
                        } else { // POR ADMINISTRACION
                            movimientos.idContrato = "0";
                            movimientos.dscContrato = "0";
                        }
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = $("#idObra").val();
                        movimientos.dscObr = $("#nomObra").val();
                        movimientos.idFte = anticipoFuentes[i][0];
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
                        movimientos = {};
                    });
                }
                guardarApAnticipo();
            } else {
                bootbox.alert("Ya se ha generado un anticipo para ese contrato.");
            }
            break;
        case 4: // ESTIMACION
            if (!errorMonto) {
                for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                    if (tablaEstimaciones.cell(i, 8).data() === 0.00) {
                        errorEstimacion = true;
                        colocaMensajePop($("#agregarMovimiento"), "Atenci\u00f3n", "Existen conceptos sin estimar","left");
                        return;
                    } else {
                        errorEstimacion = false;
                        eliminaMensajePop($("#agregarMovimiento"));
                    }
                }
                if (!errorEstimacion) {

                    if (accion === "update") {
                        apGeneral = [];
                    }

                    for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                        if (detalleFuentes[j].idFte === $("#fuentes").val()) {
                            var tmpidFte = detalleFuentes[j].idFte;
                            var tmpDscFte = detalleFuentes[j].DscFte;
                            var tmpCuentaFte = detalleFuentes[j].cuenta;
                        }
                    }
                    if ($("#derechoAnticipo").val() === "1") {// CALCULAR AMORTIZACION
                        var pjeAnticipo = $("#porcentajeAnticipo").val();
                        var montoEstimacion = $("#totalConIva").val().replace(/,/g, "");
                        montoAmortizacion = (parseFloat(pjeAnticipo) * parseFloat(montoEstimacion)) / 100;
                        ivaAmortizacion = parseFloat(montoAmortizacion) * 0.16;
                        var tmpArray = [];
                        movimientos.montoAmortizacion = montoAmortizacion - ivaAmortizacion;
                        movimientos.montoIvaAmortizacion = ivaAmortizacion;
                        movimientos.folioAmortizacion = $("#folioParaAmortizar").val();
                    } else {
                        var montoEstimacion = $("#totalConIva").val().replace(/,/g, "");
                        montoAmortizacion = 0.00;
                        movimientos.montoAmortizacion = 0.00;
                        movimientos.montoIvaAmortizacion = 0.00;
                        movimientos.folioAmortizacion = 0;
                    }

                    var tmpArray = new Array(); // REGISTRAMOS LOS CONCEPTOS Y SUS ESTIMACIONES
                    for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                        tmpArray.push([tablaEstimaciones.cell(i, 1).data(), tablaEstimaciones.cell(i, 8).data(), tablaEstimaciones.cell(i, 9).data(), tablaEstimaciones.cell(i, 10).data()]);
                    }

                    $("#sinivaAp").val(montoEstimacion);
                    $("#amortizacionAp").val(montoAmortizacion);
                    calcularAPGeneral(function () {
                        movimientos.idAp = idAps;
                        movimientos.CveAps = CveAps;
                        movimientos.idTipAps = $("#idTipAps").val();
                        movimientos.dscMov = $("#idTipAps option:selected").html();
                        movimientos.idContrato = $("#contrato").val();
                        movimientos.dscContrato = $("#contrato option:selected").html();
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = $("#idObra").val();
                        movimientos.dscObr = $("#nomObra").val();
                        movimientos.idFte = tmpidFte;
                        movimientos.dscFte = tmpDscFte;
                        movimientos.cuentaFte = tmpCuentaFte;
                        movimientos.montosConceptos = tmpArray;
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
                        movimientos = {};
                    });
                    tablaMovimientos.clear().draw();
                    tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), apGeneral[0].dscContrato, apGeneral[0].idTipAps, apGeneral[0].dscMov, '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].monto, "", ""]).draw();
                    if ($("#derechoAnticipo").val() === "1") {
                        tablaMovimientos.row.add(["", "", "", "", "1", 'Amortizaci\u00f3n', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoAmortizacion, "", ""]).draw();
                        tablaMovimientos.row.add(["", "", "", "", "5", 'I.V.A.', '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].montoIvaAmortizacion, "", ""]).draw();
                    }
                    tablaMovimientos.columns([0, 4, 6, 7]).visible(false);
                    $("#dialogEstimacion").modal('hide');
                    $("#divGuardar").show();
                    $("#btnEstimar").hide();
                }
            }
            break;
        case 6: // PAGO
            if (!errorMonto) {
                for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                    if (tablaEstimaciones.cell(i, 8).data() === 0.00) {
                        errorEstimacion = true;
                        colocaMensajePop($("#agregarMovimiento"), "Atenci\u00f3n", "Existen conceptos sin estimar","left");
                        return;
                    } else {
                        errorEstimacion = false;
                        eliminaMensajePop($("#agregarMovimiento"));
                    }
                }
                if (!errorEstimacion) {

                    if (accion === "update") {
                        apGeneral = [];
                    }

                    var montoEstimacion = $("#totalConIva").val().replace(/,/g, "");
                    for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                        if (detalleFuentes[j].idFte === $("#fuentes").val()) {
                            var montoDisponiblePago = detalleFuentes[j].disponible;
                            var tmpidFte = detalleFuentes[j].idFte;
                            var tmpDscFte = detalleFuentes[j].DscFte;
                            var tmpCuentaFte = detalleFuentes[j].cuenta;
                        }
                    }


                    montoAmortizacion = 0.00;
                    movimientos.montoAmortizacion = 0.00;
                    movimientos.montoIvaAmortizacion = 0.00;
                    movimientos.folioAmortizacion = 0;

                    var tmpArray = new Array(); // REGISTRAMOS LOS CONCEPTOS Y SUS ESTIMACIONES
                    for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                        tmpArray.push([tablaEstimaciones.cell(i, 1).data(), tablaEstimaciones.cell(i, 8).data(), tablaEstimaciones.cell(i, 9).data(), tablaEstimaciones.cell(i, 10).data()]);
                    }

                    $("#sinivaAp").val(montoEstimacion);
                    $("#amortizacionAp").val(montoAmortizacion);
                    calcularAPGeneral(function () {
                        movimientos.idAp = idAps;
                        movimientos.CveAps = CveAps;
                        movimientos.idTipAps = $("#idTipAps").val();
                        movimientos.dscMov = $("#idTipAps option:selected").html();
                        movimientos.idContrato = 0;
                        movimientos.dscContrato = 0;
                        movimientos.idEmp = $("#idEmpAp").val();
                        movimientos.rfcEmp = $("#rfcAp").val();
                        movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                        movimientos.idObr = $("#idObra").val();
                        movimientos.dscObr = $("#nomObra").val();
                        movimientos.idFte = tmpidFte;
                        movimientos.dscFte = tmpDscFte;
                        movimientos.cuentaFte = tmpCuentaFte;
                        movimientos.montosConceptos = tmpArray;
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
                        movimientos = {};
                    });
                    tablaMovimientos.clear().draw();
                    tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), apGeneral[0].dscContrato, apGeneral[0].idTipAps, apGeneral[0].dscMov, '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].monto, "", ""]).draw();
                    tablaMovimientos.columns([0, 4, 6, 7]).visible(false);
                    $("#dialogEstimacion").modal('hide');
                    $("#divGuardar,#divCombosParaAmortizar").show();
                    $("#divPagos").hide();
                }
                console.log(apGeneral);
            }
            break;
        case 7: // COMPROBACION
            var totalComprobacion = $("#totalEstimar").val().replace(/,/g, "");

            for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                if (tablaEstimaciones.cell(i, 8).data() === 0.00) {
                    errorEstimacion = true;
                    colocaMensajePop($("#agregarMovimiento"), "Atenci\u00f3n", "Existen conceptos sin comprobar","left");
                    return;
                } else {
                    errorEstimacion = false;
                    eliminaMensajePop($("#agregarMovimiento"));
                }
            }

            if (!errorEstimacion) {

                if (accion === "update") {
                    apGeneral = [];
                }

                for (var j = 0; j < detalleFuentes.length; j++) { // BUSCAMOS A LA FUENTE SELECCIONADA EN EL ARRAY PARA OBTENER SUS DATOS
                    if (detalleFuentes[j].idFte === $("#fuentes").val()) {
                        var tmpidFte = detalleFuentes[j].idFte;
                        var tmpDscFte = detalleFuentes[j].DscFte;
                        var tmpCuentaFte = detalleFuentes[j].cuenta;
                    }
                }

                var tmpArray = [];
                movimientos.montoAmortizacion = totalComprobacion;
                movimientos.montoIvaAmortizacion = 0.00;
                movimientos.folioAmortizacion = $("#foliosAmortizar").val();


                var tmpArray = new Array(); // REGISTRAMOS LOS CONCEPTOS Y SUS ESTIMACIONES
                for (var i = 0; i < tablaEstimaciones.column(1).data().length; i++) {
                    tmpArray.push([tablaEstimaciones.cell(i, 1).data(), tablaEstimaciones.cell(i, 8).data(), tablaEstimaciones.cell(i, 9).data(), tablaEstimaciones.cell(i, 10).data()]);
                }

                $("#sinivaAp").val(totalComprobacion);
                $("#amortizacionAp").val(totalComprobacion);
                calcularAPGeneral(function () {
                    movimientos.idAp = idAps;
                    movimientos.CveAps = CveAps;
                    movimientos.idTipAps = $("#idTipAps").val();
                    movimientos.dscMov = $("#idTipAps option:selected").html();
                    movimientos.idContrato = 0;
                    movimientos.dscContrato = 0
                    movimientos.idEmp = $("#idEmpAp").val();
                    movimientos.rfcEmp = $("#rfcAp").val();
                    movimientos.beneficiarioEmp = $("#beneficiarioAp").val();
                    movimientos.idObr = $("#idObra").val();
                    movimientos.dscObr = $("#nomObra").val();
                    movimientos.idFte = tmpidFte;
                    movimientos.dscFte = tmpDscFte;
                    movimientos.cuentaFte = tmpCuentaFte;
                    movimientos.montosConceptos = tmpArray;
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
                    movimientos = {};
                });
                tablaMovimientos.clear().draw();
                tablaMovimientos.row.add(["", $("#periodo").val(), $("#idObra").val(), apGeneral[0].dscContrato, apGeneral[0].idTipAps, apGeneral[0].dscMov, '', apGeneral[0].idFte, apGeneral[0].dscFte, apGeneral[0].cuentaFte, apGeneral[0].monto, "", ""]).draw();
                tablaMovimientos.columns([0, 3, 4, 6, 7]).visible(false);
                $("#dialogEstimacion").modal('hide');
                $("#divGuardar").show();
                $("#btnEstimar,#generaAmortizacion").hide();
            }
            break;
    }

    if (typeof (callback) != "undefined") {
        callback();
    }
    ;

}


function calcularAPGeneral(callback) {
    switch (tipoMovimiento) {
        case 1: //AMORTIZACION
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
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
            $("#retencionesAp").val(retenciones.toFixed(2));
            $("#subtotalAp").val(subtotal.toFixed(2));
            $("#afectacionAp").val(afectacion.toFixed(2));
            $("#totalAp").val(retenciones.toFixed(2));
            $("#netoAp").val(neto.toFixed(2));
            $("#letranetoAp").val(NumeroALetras(neto.toFixed(2)));
            $(".number").each(function () {
                $(this).focusin().focusout();
            });
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
            $("#retencionesAp").val(retenciones.toFixed(2)).focusin().focusout();
            $("#amortizacionAp").val(amortizacion.toFixed(2)).focusin().focusout();
            $("#subtotalAp").val(subtotal.toFixed(2)).focusin().focusout();
            $("#afectacionAp").val(afectacion.toFixed(2)).focusin().focusout();
            $("#netoAp").val(neto.toFixed(2)).focusin().focusout();
            $("#retencionesAp").val(retenciones.toFixed(2)).focusin().focusout();
            $("#letranetoAp").val(NumeroALetras(neto.toFixed(2)));


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
//            console.log("Subtotal:" + subtotal);
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
//            console.log("Afectacion:" + afectacion);
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
//            console.log("Retenciones:" + retenciones);
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
            console.log("Neto:" + neto);
            $("#retencionesAp").val(retenciones.toFixed(2));
            $("#subtotalAp").val(subtotal.toFixed(2));
            $("#afectacionAp").val(afectacion.toFixed(2));
            $("#totalAp").val(retenciones.toFixed(2));
            $("#netoAp").val(neto.toFixed(2));
            $("#letranetoAp").val(NumeroALetras(neto.toFixed(2)));
            $(".number").each(function () {
                $(this).focusin().focusout();
            });
            break;
        case 6: //PAGO
            var importe = $("#sinivaAp").val().replace(/,/g, "");
            var amortizacion = $("#amortizacionAp").val().replace(/,/g, "");
            var subtotal = 0.00;
            var iva = 0.00;
            var afectacion = 0.00;
            var neto = 0.00;
            var retenciones = 0.00;
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
//            console.log("Subtotal:" + subtotal);
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
//            console.log("Afectacion:" + afectacion);
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
//            console.log("Retenciones:" + retenciones);
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
            console.log("Neto:" + neto);
            $("#retencionesAp").val(retenciones.toFixed(2));
            $("#subtotalAp").val(subtotal.toFixed(2));
            $("#afectacionAp").val(afectacion.toFixed(2));
            $("#totalAp").val(retenciones.toFixed(2));
            $("#netoAp").val(neto.toFixed(2));
            $("#letranetoAp").val(NumeroALetras(neto.toFixed(2)));
            $(".number").each(function () {
                $(this).focusin().focusout();
            });
            break;

        case 7: // COMPROBACION
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
//            console.log("Subtotal:" + subtotal);
            afectacion = parseFloat(subtotal) + parseFloat(iva); //AFECTACION PRESUPUESTAL
//            console.log("Afectacion:" + afectacion);
            retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro); //AFECTACION PRESUPUESTAL
//            console.log("Retenciones:" + retenciones);
            neto = (afectacion) - (retenciones); //AFECTACION PRESUPUESTAL
//            console.log("Neto:" + neto);
            $("#subtotalAp").val(subtotal.toFixed(2));
            $("#afectacionAp").val(afectacion.toFixed(2));
            $("#totalAp").val(retenciones.toFixed(2));
            $("#netoAp").val(neto.toFixed(2));
            $("#letranetoAp").val(NumeroALetras(neto.toFixed(2)));
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

function recuperarEstimaciones(indexMov) {
//    var indice = tablaMovimientos.row($(indexMov).parent().parent()).index();
    //    for (var i = 0; i < apGeneral.length; i++) {
    for (var j = 0; j < apGeneral[0].montosConceptos.length; j++) {
        for (var k = 0; k < tablaConceptos.column(0).data().length; k++) {
            if (tablaConceptos.cell(k, 0).data() === apGeneral[0].montosConceptos[j][0]) {
                $("#concepto" + k).prop('checked', true);
            }
        }
    }
    //    }
    agregarConceptos(function () {

        for (var l = 0; l < apGeneral[0].montosConceptos.length; l++) {
            tablaEstimaciones.cell(l, 8).data(apGeneral[0].montosConceptos[l][1]).draw();
            tablaEstimaciones.cell(l, 9).data(apGeneral[0].montosConceptos[l][2]).draw();
            tablaEstimaciones.cell(l, 10).data(apGeneral[0].montosConceptos[l][3]).draw();
            $("#indexConceptos").val(l);
        }

    });

    if ((estadoAp !== "3" && idAps !== 0) || tablaMovimientos.column(1).data().length > 0 && idAps == 0) {
        $("#updateMovimiento").unbind("click").click(function () {
            agregarMovimiento('update');
        }).show();
        $("#agregarMovimiento").hide();
    } else {
        $("#updateMovimiento").hide();
        $("#agregarMovimiento").hide();
    }
    $("#dialogEstimacion").modal();
    calcularTotalEstimacion();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//COMPROBANTES

function guardarComprobantes() {
    var tmpComprobantes = [];
    for (var i = 0; i < tablaComprobantes.column(1).data().length; i++) {
        tmpComprobantes.push([tablaComprobantes.cell(i, 0).data(), tablaComprobantes.cell(i, 1).data(), tablaComprobantes.cell(i, 2).data(), tablaComprobantes.cell(i, 3).data().replace(/,/g, ""), tablaComprobantes.cell(i, 4).data()]);
    }
    $.ajax({
        data: {'accion': 'guardarComprobantes', 'idAps': idAps, 'comprobantes': tmpComprobantes},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            if (response) {
                bootbox.alert("Documentaci\u00f3n guardada.");
                apGeneral[0]['comprobantes'] = tmpComprobantes;
                $("#dialogComprobantes").modal('hide');
            } else {
                bootbox.alert("Ocurri\u00f3n un error.");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function agregarComprobantes() {
    $("#dialogFacturas").modal('hide');
    var noFolio = $("#folioComprobante").val();
    var tpoComprobante = $("#tipoComprobante").val();
    tpoComprobante = tpoComprobante.replace(/\n/gi, "<br />");
    var importeComprobante = $("#importeComprobante").val();
    var partidaComprobante = $("#partidaComprobante").val();
    var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
    var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
    tablaComprobantes.row.add(["", noFolio, tpoComprobante, importeComprobante, partidaComprobante, editar, eliminar]).draw();
}

function modificarComprobantes() {
    var id = tablaComprobantes.cell(indiceEditarComprobante, 0).data();
    var noFolio = $("#folioComprobante").val();
    var tpoComprobante = $("#tipoComprobante").val();
    tpoComprobante = tpoComprobante.replace(/\n/gi, "<br />");
    var importeComprobante = $("#importeComprobante").val();
    var partidaComprobante = $("#partidaComprobante").val();
    var editar = '<span  class="glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editarComprobante(this);"></span>';
    var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminarComprobante(this);"></span>';
    tablaComprobantes.row(indiceEditarComprobante).data([id, noFolio, tpoComprobante, importeComprobante, partidaComprobante, editar, eliminar]).draw();
//    tablaComprobantes.column(0).visible(false); //ID CONCEPTO
    //    tablaComprobantes.column(10).visible(false); // ID CONTRATO
    $("#dialogFacturas").modal("hide");


}

function editarComprobante(elem) {
    indiceEditarComprobante = tablaComprobantes.row($(elem).parent().parent()).index();
    var datosFila = tablaComprobantes.row(indiceEditarComprobante).data();
    $("#folioComprobante").val(datosFila[0]);
    $("#tipoComprobante").val(datosFila[1].replace(/<br \/>/g, '\n'));
    $("#importeComprobante").val(datosFila[2]);
    $("#partidaComprobante").val(datosFila[3]);

    $("#actualizarComprobante").show();
    $("#agregaComprobante").hide();
    $("#dialogFacturas").modal("show");
}

function eliminarComprobante(elem) {
    var indiceEliminar = tablaComprobantes.row($(elem).parent().parent()).index();
    $(elem).parent().parent().unbind("click");
    tablaComprobantes.row(indiceEliminar).remove().draw();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////


function guardarAp() {
    if (apGeneral.length > 0) {
        if ($("#idEmpAp").val() !== "") {
            console.log(apGeneral);
            apGeneral[0]['observaciones'] = $("#observacionesAp").val();
            $.ajax({
                data: {'accion': 'guardarAp', 'datosAp': apGeneral, 'idSol': idSol},
                url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
                type: 'post',
                success: function (response) {
                    console.log(response);
                    if (!response) {
                        bootbox.alert("Ha ocurrido un error");
                    } else {
                        var data = jQuery.parseJSON(response);
                        bootbox.alert("Se ha generado la Autorizaci\u00f3n de Pago con Folio: <b>" + data[1] + "</b>", function (result) {
                            //                    location.reload();
                            $("#divCerrar").show();
                            apGeneral[0]['idAp'] = data[0];
                            apGeneral[0]['CveAps'] = data[1];
                        });
                    }
                },
                error: function (response) {
                    console.log("Errores::", response);
                }
            });
        } else {
             colocaMensajePop($("#rfcAp"), "Error", "Ingrese un beneficiario.","top");
            $("#rfcAp").focus();

        }
    }
}

function guardarApAnticipo() {
    if ($("#idEmpAp").val() === "") {
        colocaMensajePop($("#rfcAp"), "Error", "Ingrese un beneficiario.","top");
        $("#rfcAp").focus();

    } else {
        eliminaMensajePop($("#rfcAp"));
        colocaWaitGeneral();

        $.ajax({
            data: {'accion': 'guardarApAnticipo', 'datosAp': apGeneral, 'idSol': idSol},
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {
                console.log(response);
                if (!response) {
                    bootbox.alert("Ha ocurrido un error");
                } else {
                    var data = jQuery.parseJSON(response);
                    for (var i = 0; i < tablaFuentesAnticipo.data().length; i++) {
                        for (var j = 0; j < data.length; j++) {
                            if (tablaFuentesAnticipo.cell(i, 0).data() === data[j][0]) {
                                tablaFuentesAnticipo.cell(i, 4).data(data[j][1]).draw();
                            }
                        }
                    }
                    $("#divagregarAnticipo").hide();
                    bootbox.alert("Anticipo(s) generado(s) con \u00e9xito!");
                }
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
        eliminaWaitGeneral();
    }
}

function cerrarAp() {
    bootbox.confirm("Una vez cerrado el registro ya no se podr\u00e1 modificar. \u00BFDesea continuar?", function (response) {
        if (response) {
            colocaWaitGeneral();
           idAps = apGeneral[0].idAp;
            $.ajax({
                data: {'accion': 'cerrarAp', 'datosAp': apGeneral, 'idSol': idSol, 'estado': 3},
                url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
                type: 'post',
                success: function (response) {
                    if (!response) {
                        bootbox.alert("Ha ocurrido un error");
                    } else {
                        bootbox.alert("Registro cerrado con \u00e9xito.");
                        $("#divGuardar").hide();
                        $("#divCerrar").hide();
                        $("#divComprobacion").show();
                        $("#divImpresion").show();
                    }
                },
                error: function (response) {
                    console.log("Errores::", response);
                }
            });
            eliminaWaitGeneral();
        }
    });
}

function generaPDF() {
    $("#impresionForm").empty();
    var inputs = '';
    for (var i = 0; i < apGeneral.length; i++) {
        //        if (tipoMovimiento === 2) { // ANTICIPO
        inputs += '<input type="text" name="idFtes[]" value="' + apGeneral[i].idFte + '" />' +
                '<input type="text" name="descFtes[]" value="' + apGeneral[i].dscFte + '" />' +
                '<input type="text" name="cuentaFtes[]" value="' + apGeneral[i].cuentaFte + '" />';
        //        }
        if (tipoMovimiento == 4) { // ESTIMACION
            inputs += '<input type="text" class="numberPdf" name="montoAmortizacion" value="' + apGeneral[i].montoAmortizacion + '" />' +
                    '<input type="text" class="numberPdf" name="montoIvaAmortizacion" value="' + apGeneral[i].montoIvaAmortizacion + '" />' +
                    '<input type="text" name="folioAmortizacion" value="' + $("#CveApAmortizar").text() + '" />';
        }
        if (tipoMovimiento == 6 && apGeneral[i].montoAmortizacion > 0) { // PAGO
            inputs += '<input type="text" class="numberPdf" name="montoAmortizacion" value="' + apGeneral[i].montoAmortizacion + '" />' +
                    '<input type="text" class="numberPdf" name="montoIvaAmortizacion" value="' + apGeneral[i].montoIvaAmortizacion + '" />' +
                    '<input type="text" name="folioAmortizacion" value="' + $("#foliosAmortizar option:selected").text() + '" />';
        }
        if (tipoMovimiento == 7) { // ESTIMACION
            inputs += '<input type="text" class="numberPdf" name="montoAmortizacion" value="' + apGeneral[i].montoAmortizacion + '" />' +
                    '<input type="text" class="numberPdf" name="montoIvaAmortizacion" value="' + apGeneral[i].montoIvaAmortizacion + '" />' +
                    '<input type="text" name="folioAmortizacion" value="' + $("#foliosAmortizar option:selected").text() + '" />';
        }

        if ($("#btnCerrar:visible").length === 1) {
            inputs += '<input type="text" name="marcaAgua" value="1" />';
        } else {
            inputs += '<input type="text" name="marcaAgua" value="0" />';
        }
        inputs += '<input type="text" name="ejercicio" value="' + $("#periodo").val() + '" />' +
                '<input type="text" name="ue" value="' + $("#ejecutoraAp").val() + '" />' +
                '<input type="text" name="sector" value="' + NomSec + '" />' +
                '<input type="text" name="obra" value="' + $("#idObra").val() + '" />' +
                '<input type="text" name="nombreObra" value="' + $("#nomObra").val() + '" />' +
                '<input type="text" class="numberPdf" name="presupuestoAutorizado" value="' + $("#preAutorizado").val() + '" />' +
                '<input type="text" name="movimiento" value="' + $("#idTipAps option:selected").text() + '" />' +
                '<input type="text" name="modEjecucion" value="' + $("#modEje").val() + '" />' +
                '<input type="text" name="beneficiario" value="' + $("#beneficiarioAp").val() + '" />' +
                '<input type="text" name="rfc" value="' + $("#rfcAp").val() + '" />' +
                '<input type="text" name="noContrato" value="' + $("#noContrato").val() + '" />' +
                '<input type="text" name="fechaContrato" value="' + $("#fechaContrato").val() + '" />' +
                '<input type="text" name="fechaIniContrato" value="' + $("#fechaIniContrato").val() + '" />' +
                '<input type="text" name="fechaFinContrato" value="' + $("#fechaFinContrato").val() + '" />' +
                '<input type="text" class="numberPdf" name="importeContrato" value="' + $("#importeContrato").val() + '" />' +
                '<input type="text" name="observaciones" value="' + $("#observacionesAp").val() + '" />' +
                '<input type="text" name="CveAps" value="' + apGeneral[i].CveAps + '" />' +
                '<input type="text" class="numberPdf" name="impSinIva" value="' + apGeneral[i].monto + '" />' +
                '<input type="text" class="numberPdf" name="amortizacion" value="' + apGeneral[i].amortizacion + '" />' +
                '<input type="text" class="numberPdf" name="subtotal" value="' + apGeneral[i].subtotal + '" />' +
                '<input type="text" class="numberPdf" class="number" name="iva" value="' + apGeneral[i].iva + '" />' +
                '<input type="text" class="numberPdf" name="afectacionPresupuestal" value="' + apGeneral[i].afectPresupuestal + '" />' +
                '<input type="text" class="numberPdf" name="retenciones" value="' + apGeneral[i].retenciones + '" />' +
                '<input type="text" class="numberPdf" name="icic" value="' + apGeneral[i].icic + '" />' +
                '<input type="text" class="numberPdf" name="cmic" value="' + apGeneral[i].cmic + '" />' +
                '<input type="text" class="numberPdf" name="supervision" value="' + apGeneral[i].supervision + '" />' +
                '<input type="text" class="numberPdf" name="ispt" value="' + apGeneral[i].ispt + '" />' +
                '<input type="text" class="numberPdf" name="otro" value="' + apGeneral[i].otro + '" />' +
                '<input type="text" class="numberPdf" name="neto" value="' + apGeneral[i].impNeto + '" />' +
                '<input type="text" name="letra" value="' + $("#letranetoAp").val() + '" />';

        for (var j = 0; j < apGeneral[i]['comprobantes'].length; j++) {
            inputs += '<input type="text" name="noFolio[]" value="' + apGeneral[i]['comprobantes'][j][1] + '" />' +
                    '<input type="text" name="tipoDocumento[]" value="' + apGeneral[i]['comprobantes'][j][2] + '" />' +
                    '<input type="text" class="numberPdf" name="importe[]" value="' + apGeneral[i]['comprobantes'][j][3] + '" />' +
                    '<input type="text" name="partida[]" value="' + apGeneral[i]['comprobantes'][j][4] + '" />';
        }
    }
    $("#impresionForm").append(inputs);
    $(".numberPdf").each(function () {
        $(this).autoNumeric();
    });
    $("#impresionForm").submit();
}

function colocaMensajePop(elemento, titulo, mensaje,lugar) {
    $(elemento).popover({
        content: "<b>" + mensaje + "</b>",
        trigger: "manual",
        placement: lugar,
        title: titulo,
        html: true
    });
    $(elemento).popover("show");
    $("#" + $(elemento).attr("aria-describedby")).find("h3").addClass("alert-danger");
}

function eliminaMensajePop(elemento) {
    if ($(elemento).attr("aria-describedby")) {
        $(elemento).popover("hide");
        $(elemento).popover("destroy");
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


