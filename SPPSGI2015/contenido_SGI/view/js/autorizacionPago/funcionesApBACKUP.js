var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var idSol = 0;
var importesAnticipos = new Array();
var detalleFuentes = new Array();
var detalleConcepto = new Array();
var relConceptoFuentes = new Array();

$(document).ready(function () {

    tablaOficios = $('#tablaOficios').DataTable({"retrieve": true, "ordering": false, "sPaginationType": "bootstrap",
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
                "sLast": "Ãšltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
//            $('td:eq(7)', nRow).addClass("number");
//            $(nRow).click(function () {
//                alert($("#tablaOficios tr").find(".selected").length);
////                each(function(){
////                   alert();
////                });
//                $(this).addClass("selected");
//                seleccionarOficio(aData[0]);
//            });
        }});

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
                "sLast": "Ãšltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
//            $('td:eq(7)', nRow).addClass("number");
//            $(nRow).click(function () {
//                alert($("#tablaOficios tr").find(".selected").length);
////                each(function(){
////                   alert();
////                });
//                $(this).addClass("selected");
//                seleccionarOficio(aData[0]);
//            });
        }});
    tablaEstimaciones = $("#tablaMontosEst").DataTable({"retrieve": true, "ordering": false, "sPaginationType": "bootstrap",
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
                "sLast": "Ãšltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).click(function () {
                $("#tablaMontosEst tr.selected").each(function () {
                    $(this).removeClass("selected");
                });
                $(this).addClass("selected");
                $("#conceptoActual").val(aData[1]);
                $("#indexConceptos").val(iDataIndex);
                mostrarGridAPresu(aData[9]);
                console.log()
            });
        }});

    $("input[type=text],textarea,select").addClass("form-control input-sm");

    $(".number").autoNumeric({vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});
    $("#apRegistrada").click(function () {
        if ($("#apRegistrada").prop("checked")) {
            $("#fechaAlterna").prop("checked", false);
            $("#fechaF").hide();
            $("#apF").show();
        } else {
            $("#apF").hide();
        }
//        } else {
//            if (idAps) {
//                location.reload();
//            } else {
//                $("#apF").hide();
//            }
//
//        }
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
    $("#folioAp").on('change', (function () {
        getApById();
        $("#folioAp").attr("readonly", "true");
    }));
    $("#rfcAp").on('change', function () {
        buscaRfc($(this).val())
    });
    $("#fecDev,#fecha").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#btnEstimar").click(function () {
        if ($("#contrato").val() !== "-1" && $("#fuentes").val() !== "-1") {
            getConceptos(function () {
                $("#dialogEstimacion").modal();
            });
        } else {
            bootbox.alert("Se debe seleccionar contrato y fuente");
        }

    });

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
        $("#dialogEstimacion").modal('show');
    });


    $("#btnAmortizar").click(function () {
        $("#dialogAmortizacion").modal();
    });
    $("#btnAgregarFactura").click(function () {
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

    $("#accion").change(function () {
        switch ($(this).val()) {
            case "1": //CREACION DE AP
                $("#divobra").show();
                $("#divfolio").hide();
                $("#divperiodo").show();
                $("#btnbuscar").click(function () {
                    buscaObra();
                });
                break;
            case "2": //MODIFICACION DE AP
                $("#divobra").hide();
                $("#divfolio").show();
                $("#divperiodo").hide();
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
            case "1":
                buscaOficios(function () {
                    $("#divOficios").show();
                    $("#divContratos").show();
                    $("#divFuentes").show();
                    $("#divAmortizar").show();
                    $("#divPresupuestal").show();
                });
                break;
            case "2":
                $("#divOficios").hide();
                $("#divContratos").hide();
                $("#divFuentes").hide();
                $("#divPresupuestal").hide();
                buscaAnticipos();
                break;
            case "4":
                buscaOficios(function () {
                    $("#divOficios").show();
                    $("#divContratos").show();
                    $("#divFuentes").show();
                    $("#divEstimar").show();
                    $("#divPresupuestal").show();
                });
                break;
        }
    });

    $("#contratoAnticipo").change(function () {
        for (var i = 0; i < importesAnticipos.length; i++) {
            if ($(this).val() === importesAnticipos[i][0]) {
                $("#anticipoDisponible").val(importesAnticipos[i][1]);
            }
        }
    });

    $("#afectacionC").change(function () {
        afectacionPresupuestalConcepto();
    });

    cargarCombos();

});

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
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscaObra() {
    var idObr = $("#idObra").val();
    var ejercicio = $("#periodo").val();
    $.ajax({
        data: {'accion': 'getObraById', 'idObr': idObr, 'ejercicio': ejercicio},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            if (response=='') {
            var data = jQuery.parseJSON(response);
            console.log(data);
            if (data.obra[0].IdModEje == "3") { // CONTRATO
                $("#idTipAps option[value='6']").remove();
            } else { // POR ADMINISTRACION
                $("#idTipAps option[value='1']").remove();
                $("#idTipAps option[value='2']").remove();
                $("#idTipAps option[value='4']").remove();
            }
            idSol = data.obra[0].VerExpTec;

            if (data.contratos != "0") { //LLenar select contratos
                $("#contrato").html(data.contratos);
//                $("#divContratos").show();
            } else {
                console.log("no");
            }
            $("#fuentes").html(data.fuentes);
            detalleFuentes = data.montosFuentes;
            console.log("FUENTES SOLICITUD:");
            console.log(detalleFuentes);
//            }else{
//                alert();
//            }

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscaAnticipos() {
    $.ajax({
        data: {'accion': 'getContratoAnticipo', 'idSol': idSol},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            console.log(data);
            if (data.comboContratos !== "0") { //LLenar select contratos
                importesAnticipos = data.importes;
                $("#contratoAnticipo").html(data.comboContratos);
                $("#divContratoAnticipo").show();
            } else {
                console.log("no");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscaOficios(callback) {
    var idObr = $("#idObra").val();
    $.ajax({
        data: {'accion': 'getOficios', 'idObr': idObr},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            console.log(data);
            tablaOficios.clear().draw();
            for (var i = 0; i < data.length; i++) {
                var descFte = "";
                if (data[i].idFte == "0") {
                    descFte = "Varias";
                } else {
                    descFte = data[i].CveFte + "-" + data[i].DscFte;
                }
                tablaOficios.row.add([data[i].idOfi, data[i].Ejercicio, data[i].CveOfi, data[i].NomSolPre, data[i].FecFir, data[i].idFte, descFte, data[i].MontoAutorizado]).draw();
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

function getConceptos(callback) {
    var idContrato = $("#contrato").val();
    var idFte = $("#fuentes").val();
    $.ajax({
        data: {idContrato: idContrato, idFte: idFte, accion: "getConceptos"},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var dataConceptos = $.parseJSON(response);
            console.log(dataConceptos);
            relConceptoFuentes = dataConceptos.fuentes;
            tablaConceptos.clear().draw();

            for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, dataConceptos.conceptos[i].disponibleConcepto, "<input type='checkbox' class='seleccion' value='" + i + "'>"]).draw();
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

function agregarConceptos() {

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
            for (var i = 0; i < relConceptoFuentes.length; i++) {
                if (relConceptoFuentes[i].idPresu == tablaConceptos.cell(index, 0).data()) {
                    for (var j = 0; j < detalleFuentes.length; j++) {
                        if (detalleFuentes[j].idFte == relConceptoFuentes[i].idFte) {
                            var descFte = detalleFuentes[j].DscFte;
                        }
                    }
                    var objAplicacionPresupuestal = {
                        idPresu: relConceptoFuentes[i].idPresu,
                        idFte: relConceptoFuentes[i].idFte,
                        descFte: descFte,
                        disponibleFte: relConceptoFuentes[i].disponibleFte,
                        impSnIva: "",
                        amortizacion: "",
                        subtotal: "",
                        iva: "",
                        afectPresupuestal: "",
                        importeNeto: "",
                        icic: "",
                        cmic: "",
                        supervision: "",
                        ispt: "",
                        otro: "",
                        retenciones: ""
                    };
                    montosFteConcepto.push(objAplicacionPresupuestal);
                }
            }
            tablaEstimaciones.row.add(["", tablaConceptos.cell(index, 0).data(), tablaConceptos.cell(index, 1).data(), tablaConceptos.cell(index, 2).data(), tablaConceptos.cell(index, 6).data(), tablaConceptos.cell(index, 7).data(), tablaConceptos.cell(index, 8).data(), tablaConceptos.cell(index, 9).data(), "", montosFteConcepto, eliminar]).draw();
            tablaEstimaciones.column(9).visible(false);
            console.log(montosFteConcepto);
        }

    });

    $("#dialogConceptos").modal("hide");
    $("#dialogEstimacion").modal();
}

function mostrarGridAPresu(obj) {
//    console.log(obj);
//    console.log("No. Fuentes:" + obj.length);
    $("#indexFte").val(0);
    $("#nextFte").unbind("click").click(function () {
        navegacionGridFtes("next", obj);
    });
    $("#backFte").unbind("click").click(function () {
        navegacionGridFtes("back", obj);
    });
    $("#descFteEstimacion").html(obj[0].descFte);
    $("#idFteEstimacion").val(obj[0].idFte);
    $("#disponibleFte").val(obj[0].disponibleFte);

    $("#sinivaC").val(obj[0].impSnIva);
    $("#amortizacionC").val(obj[0].amortizacion);
    $("#icicC").val(obj[0].icic);
    $("#isptC").val(obj[0].ispt);
    $("#subtotalC").val(obj[0].subtotal);
    $("#ivaC").val(obj[0].iva);
    $("#cmicC").val(obj[0].cmic);
    $("#otroC").val(obj[0].otro);
    $("#afectacionC").val(obj[0].afectPresupuestal);
    $("#netoC").val(obj[0].neto);
    $("#supervisionC").val(obj[0].supervision);
    $("#totalC").val(obj[0].total);
    $("#gridAfectacionPresupuestal").show();
}

function navegacionGridFtes(accion, obj) {
    var indx = parseInt($("#indexFte").val());
    var nxt;
    var nRegistros = obj.length;
    if (accion === "next") {
        nxt = indx + 1;
    } else {
        nxt = indx - 1;
    }
    console.log("indiceActual:" + indx + " siguiente:" + nxt + " nRegistros:" + nRegistros);
    if (nxt >= 0 && nxt < nRegistros) { // CONTROL PARA QUE NO SE DESBORDE EL ARRAY
        $("#indexFte").val(nxt);
        $("#descFteEstimacion").html(obj[nxt].descFte);
        $("#idFteEstimacion").val(obj[nxt].idFte);
        $("#disponibleFte").val(obj[nxt].disponibleFte);

        $("#sinivaC").val(obj[nxt].impSnIva);
        $("#amortizacionC").val(obj[nxt].amortizacion);
        $("#icicC").val(obj[nxt].icic);
        $("#isptC").val(obj[nxt].ispt);
        $("#subtotalC").val(obj[nxt].subtotal);
        $("#ivaC").val(obj[nxt].iva);
        $("#cmicC").val(obj[nxt].cmic);
        $("#otroC").val(obj[nxt].otro);
        $("#afectacionC").val(obj[nxt].afectPresupuestal);
        $("#netoC").val(obj[nxt].neto);
        $("#supervisionC").val(obj[nxt].supervision);
        $("#totalC").val(obj[nxt].total);
    }
}

function afectacionPresupuestalConcepto() {
    var total = $("#afectacionC").val();
    $("#sinivaC").val(total);

    //IVA
    if ($("#ivaConceptos").val() != "0") {
        //CALCULAR EL IVA
    } else {
        $("#ivaC").val("0.00");
    }

}

function eliminar(elem) {

    var indiceEliminar = tablaEstimaciones.row($(elem).parent().parent()).index();
//    var montosCancel = tablaConceptos.cell(indiceEliminar, 8).data();
//    var datosFila = tablaConceptos.row(indiceEliminar).data();
//    if (datosFila[0] > 0) {
//        arrayEliminados.push(datosFila[0]);
//    }

    tablaEstimaciones.row(indiceEliminar).remove().draw();
    $(".inputAfectPresu").each(function () {
        $(this).val("");
    });
    $("#gridAfectacionPresupuestal").hide();
//    tablaConceptos.column(0).visible(false);
//    if (tablaConceptos.data().length == 0) {
//        $("#pariPassu").attr("disabled", false);
//    }
//    calcularMontosFtes(montosCancel, "cancel", indiceEliminar);
//    actualizaTotales();
}

//function getFolioAp() { //DEFINE EL FOLIO PARA LA NUEVA AP
//    $.ajax({
//        data: {'accion': 'getFolio'},
//        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
//        type: 'post',
//        success: function (response) {
//            console.log(response);
//            $("#folioAp").val(response);
//        },
//        error: function (response) {
//            console.log("Errores::", response);
//        }
//    });
//}
function getApById() {


    CveAps = $("#folioAp").val();
    $.ajax({
        data: {'accion': 'buscarFolioAplicacion', 'CveAps': CveAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            if (data.length > 0) {
                $("#btnCerrar").show();
                $("#btnImpresion").show();
                $("#movimientos").show();
                idAps = data[0].idAps;
                $("#estadoAp").val(data[0].NomEdoAps);
                $("#estimacionAp").val(data[0].NumEst);
                $("#fecEnvAp").val(data[0].FecEnv);
                $("#beneficiarioAp").val(data[0].NomEmp);
                $("#rfcAp").val(data[0].RfcEmp);
                $("#idEmpAp").val(data[0].idEmp);
                $("#observacionesAp").val(data[0].ObsAps);
                $("#ejecutoraAp").val(data[0].NomUE);
                FecRec = data[0].FecCre;
                FecCre = data[0].FecCre;
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

//                if (estadoAp != "2" && estadoAp != "4") {
//                    $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
//                    $("#dialogAvisos").modal();
//                    $("#msgAviso").html("La Autorizaci\u00f3n de Pago ya no se puede editar.");
//                }
                switch (estadoAp) {
                    case "1":
                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago a sido aceptada.");
                        break;
                    case "2":
                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago a sido cancelada.");
                        break;
                    case "3":
                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago est\u00e1  en proceso.");
                        break;
//                    case "4":
//                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
//                        $("#dialogAvisos").modal();
//                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago ya no se puede editar.");
//                        break;
                    case "5":
                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago ya no se puede editar.");
                        break;
                    case "6":
                        $("#btnGuardar,#btnAgregar,#btnCerrar,#btnQuitar").hide();
                        $("#dialogAvisos").modal();
                        $("#msgAviso").html("La Autorizaci\u00f3n de Pago a sido analizada.");
                        break;
                }

//                if(data[0].FecRec){
//                    $("#dialogAvisos").modal();
//                    $("#msgAviso").html("La Autorizaci\u00f3n de Pago ya se encuentra en an\u00e1lisis, no se puede editar.");
//                    $('#dialogAvisos').on('hidden.bs.modal', function () {
//                        $("#btnGuardar").hide();
//                    });
//                }

                $.ajax({
                    data: {'accion': 'getMovimientos', 'idAps': idAps},
                    url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
                    type: 'post',
                    success: function (response) {
                        console.log("MOVIMIENTOS:");
                        console.log(response);
                        var data = jQuery.parseJSON(response);
                        if (data.length > 0) {

                            $("#tablaAp tbody").find("tr").each(function () {
                                $(this).remove();
                            });
                            for (var i = 0; i < data.length; i++) {

                                if (data[i].idRef == 0) {
                                    var ref = '';
                                } else {
                                    var ref = data[i].idRef;
                                }

                                var newRow = "<tr id=" + indice + " onClick='seleccionaMov(this);'>\n\
                                            <td style='display:none;'>" + data[i].ejercicio + "<input type='text' id=tapejercicio" + indice + " value='" + data[i].ejercicio + "' style='display:none;'></td>\n\
                                            <td style='display:none;'>" + data[i].idObr + "<input type='text' id=tapobra" + indice + " value='" + data[i].idObr + "' style='display:none;'><input type='text' id=tapidModEje" + indice + " value='" + data[i].idModEje + "' style='display:none;'></td>\n\
                                            <td>" + data[i].nomTipAps + "<input type='text' id=tapidTipMov" + indice + " class='tipoMovimiento' value=" + data[i].idTipAps + " style='display:none;'></td>\n\
                                            <td>" + data[i].CveOfi + "<input type='text' id=tapidDetOfi" + indice + " value=" + data[i].idDetOfi + " style='display:none;'></td>\n\
                                            <td>" + data[i].CveRef + "<input type='text' id=tapidRef" + indice + " value=" + data[i].idRef + " style='display:none;'></td>\n\
                                            <td>" + data[i].DscFte + "<input type='text' id=tapidFte" + indice + " value='" + data[i].idFte + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomInv + "<input type='text' id=tapidInv" + indice + " value='" + data[i].idInv + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomRec + "<input type='text' id=tapidRec" + indice + " value='" + data[i].idRec + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].monto + "<input type='text' id=tapafectacion" + indice + " value=" + data[i].monto + " style='display:none;'><input type='text' id=idDetAps" + indice + " value=" + data[i].idDetAps + " style='display:none;'></td>\n\\n\
                                        </tr>";
                                $("#tablaAp tbody").append(newRow);
                                $("#tablaAp").trigger("update");

                                indice++;

                            }

                            $("#obraAp").val(data[0].idObr).change();
                            $("#idDetObrAp").val(data[0].idDetObr);
                            $("#nombreobraAp").val(data[0].NomObr);
                            $("#sectorAp").val(data[0].NomSec);
                            $("#icicAp").val(data[0].RetCnic);

                            $("#cmicAp").val(data[0].RetCicem);

                            $("#supervisionAp").val(data[0].RetSup);

                            $("#isptAp").val(data[0].RetIspt);

                            $("#otroAp").val(data[0].RetOtr);
                            $("#ivaAp").val(data[0].iva);

                            consulta = true;
                            detalle = true;
                            calcularAP();
                            $("#movimientoAp").val("6");
                            $("#movimientoAp").change();

                            //
                        }
                    },
                    error: function (response) {
                        console.log("Errores::", response);
                    }
                });

            } else {
                alert("No existe ese folio de AP registrado");
                $("#folioAp").removeAttr("readonly").focus();
                $("#movimientos").hide();
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

function buscaRfc(RfcEmp) {
    $.ajax({
        data: {'accion': 'consultaEmpresa', 'RfcEmp': RfcEmp},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            if (data.NomEmp) {
                $("#beneficiarioAp").val(data.NomEmp);
                $("#idEmpAp").val(data.idEmp);


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

function getObraById() {
    var idObr = $("#obraAp").val();
    $.ajax({
        data: {'accion': 'getObraAplicacion', 'idObra': idObr},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log("Obra::" + response);
            var data = jQuery.parseJSON(response);
            if (data.length > 0) {
                $("#ejecutoraAp").val(data[0].NomUE);
                $("#idDetObrAp").val(data[0].idDetObr);
                $("#nombreobraAp").val(data[0].NomObr);
                $("#sectorAp").val(data[0].NomSec);
                idDep = data[0].idDep;
                $("#movimientoAp").val("6");
                $("#movimientoAp").change();
            } else {
                alert("No existe la obra seleccionada");
                $("#obraAp").focus();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function getTipoAp() {
    $.ajax({
        data: {'accion': 'getTipoAp'},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            $("#movimientoAp").append(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function despliegaTabla() {

    if ($("#movimientoAp").val() == "1" || $("#movimientoAp").val() == "3" || $("#movimientoAp").val() == "5") {

        if ($("#movimientoAp").val() == "1") {
            ivaAmorticacion = true;
            $("#ivaDiv,#ivaAmortizacion").show();
        } else {
            ivaAmorticacion = false;
            $("#ivaDiv,#ivaAmortizacion").hide();
        }

        $("#tabla1").show();
        $("#tabla2").hide();
        $("#tabla1 tbody").find("tr").remove();
        $("#tabla1").trigger("update");
        buscaOficiosAp();
    } else {
        ivaAmorticacion = false;
        $("#ivaDiv,#ivaAmortizacion").hide();
        $("#tabla1").hide();
        $("#tabla2").show();
        $("#tabla2 tbody").find("tr").remove();
        $("#tabla2").trigger("update");
        buscaOficios();

    }
}



function seleccionaOficio(id) {
    $("#tabla2").find(".bg-success").removeClass("bg-success");
    $(id).addClass("bg-success");
    $("#ejercidoAp").prop("readonly", false);
    var index = $(id).attr("id");
    var idOficioActual = $("#idDetOfi" + index).val();
    calculaMontoOficios(idOficioActual);
}

function seleccionaAp(id) {
    $("#tabla1").find(".bg-success").removeClass("bg-success");
    $(id).addClass("bg-success");
    $("#ejercidoAp").prop("readonly", false);
    var index = $(id).attr("id");
    var idOficioActual = $("#idDetOfi" + index).val();
    var idDetApActual = $("#idDetAps" + index).val();
    calculaMontoAp(idDetApActual);
}

function calculaMontoOficios(idOficioActual) {

    $.ajax({
        data: {'accion': 'getMontoOficio', 'idDetOfi': idOficioActual, 'idAps': idAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            $("#tablaAp").find(".tipoMovimiento").each(
                    function () {
                        var ind = $(this).parents("tr").attr("id");
                        var montoAp = $("#tapafectacion" + ind).val().replace(/,/g, "");
                        montoAp = montoAp.replace(/,/g, "");
                        //response = parseFloat(response);
                        console.log(response + "_" + montoAp);

                        if ($("#tapidDetAps" + ind).val() == 0) {

                            if ($("#tapidDetOfi" + ind).val() == idOficioActual) {

                                if ($("#tapidTipMov" + ind).val() == "6" || $("#tapidTipMov" + ind).val() == "4" || $("#tapidTipMov" + ind).val() == "2") {
                                    console.log("resta::" + response + "-" + montoAp);
                                    response = response - montoAp;

                                } else if ($("#tapidTipMov" + ind).val() == "3") {
                                    console.log("suma::" + response + "+" + montoAp);
                                    response = response + montoAp;
                                }
                            }
                        }
                        console.log("Monto despues de op::" + response);
                    });
            if (response < 0)
                response = 0.00;
            $("#disponibleAp").val(response);
            $("#disponibleAp").focusin().focusout();
            console.log("Monto::" + response);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function calculaMontoAp(idDetApActual) {
    $.ajax({
        data: {'accion': 'getMontoOficioAp', 'idDetAps': idDetApActual, 'idAps': idAps, 'mov': $("#movimientoAp").val()},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            $("#tablaAp").find(".tipoMovimiento").each(
                    function () {
                        var ind = $(this).parents("tr").attr("id");
                        var montoAp = $("#tapafectacion" + ind).val().replace(/,/g, "");
                        montoAp = montoAp.replace(/,/g, "");
                        console.log(response + "_" + montoAp);

//                        if ($("#tapidRef" + ind).val() == idAps) {
                        if ($("#tapidTipMov" + ind).val() == "1" || $("#tapidTipMov" + ind).val() == "3" || $("#tapidTipMov" + ind).val() == "5") {
                            response = response - montoAp;
                        } else {
                            response = response + montoAp;
                        }
//                        }
                    });
            if (response < 0)
                response = 0.00;
            $("#disponibleAp").val(response);
            $("#disponibleAp").focusin().focusout();
            console.log("Monto::" + response);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscaOficiosAp() {

    if ($("#fechaAlterna").prop("checked")) { //SI SE CAMBIO LA FECHA SE PASA COMO PARAMETRO DE BUSQUEDA PARA LAS AP
        fecTmp = $("#fecha").val().split("-");
        FecRec = fecTmp[2] + "-" + fecTmp[1] + "-" + fecTmp[0];
    } else {
        if (!FecCre) {
            FecRec = yyyy + "-" + mm + "-" + dd;
        } else {
            FecRec = FecCre;
        }
    }
    console.log("FECHA:" + FecRec);
    var mov = $("#movimientoAp").val();

    colocaWait($("#tabla1"));
    $.ajax({
        data: {'accion': 'getOficiosAp', 'idObr': $("#obraAp").val(), 'idAps': idAps, 'fecrec': FecRec, 'mov': mov},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log("Ap query::" + response);
            var data = jQuery.parseJSON(response);
            var newRow = "";
            $("#tabla1 tbody").find("tr").each(function () {

                $(this).remove();
            });
            for (var i = 0; i < data.length; i++) {
                newRow += "<tr id=" + i + " onClick='seleccionaAp(this);'>\n\
                            <td>" + data[i].Ejercicio + "<input type='text' id=ejercicio" + i + " value=" + data[i].Ejercicio + " style='display:none;'></td>\n\
                            <td>" + data[i].CveAps + "<input type='text' id=CveAps" + i + " value=" + data[i].CveAps + " style='display:none;'><input type='text' id=idAps" + i + " value=" + data[i].idAps + " style='display:none;'><input type='text' id=idDetAps" + i + " value=" + data[i].idDetAps + " style='display:none;'></td>\n\
                            <td>" + data[i].NomTipAps + "<input type='text' id=idTipAps" + i + " value=" + data[i].idTipAps + " style='display:none;'></td>\n\
                            <td>" + data[i].FecEnv + "</td>\n\
                            <td id='of" + i + "'>" + data[i].CveOfi + "<input type='text' id=idTipOfi" + i + " value=" + data[i].idTipOfi + " style='display:none;'><input type='text' id=idDetOfi" + i + " value=" + data[i].idDetOfi + " style='display:none;'><input type='text' id=idRef" + i + " value=" + data[i].CveAps + " style='display:none;'></td>\n\\n\
                            <td id=fte" + i + ">" + data[i].DscFte + "<input type='text' id=idFte" + i + " value=" + data[i].idFte + " style='display:none;'></td>\n\
                            <td id=inv" + i + ">" + data[i].NomInv + "<input type='text' id=idInv" + i + " value=" + data[i].idInv + " style='display:none;'></td>\n\
                            <td id=rec" + i + ">" + data[i].NomRec + "<input type='text' id=idRec" + i + " value=" + data[i].idRec + " style='display:none;'></td>\n\
                            <td>" + data[i].Monto + "</td>\n\
                        </tr>";

            }
            eliminaWait($("#tabla1"));
            $("#tabla1 tbody").append(newRow);
            $("#tabla1").trigger("update");

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}


function validarEjercido() {
    var ejercido = ($("#ejercidoAp").val().replace(/,/g, ""));
    var disponible = ($("#disponibleAp").val().replace(/,/g, ""));
    console.log("Disponible:" + disponible + " Ejercido:" + ejercido);
    if ($("#disponibleAp").val() === "") {
        alert("Seleccione un oficio");
        $("#ejercidoAp").val("");
    }
    if ($("#movimientoAp").val() == "1") { // Amortizacion
        var iva = ejercido * 0.16;
        iva = iva.toFixed(2);
        $("#ivaAmortizacion").val(iva);
        ejercido = parseFloat(ejercido) + parseFloat(iva);
    }
    if (parseFloat(disponible) < parseFloat(ejercido)) {
        alert("El monto supero al monto disponible");
        $("#ejercidoAp").focus();
    }

}

function agregarMovimientos() {
    if ($("#ejercidoAp").val() != "") {
        var index = $(".tablesorter:visible").find(".bg-success").attr("id");
        var CveOfi = $("#of" + index).html();
        var NomRef = $("#idRef" + index).val()
        var DscFte = $("#fte" + index).text();
        var NomInv = $("#inv" + index).text();
        var NomRec = $("#rec" + index).text();
        if ($("#idDetAps" + index).val()) {
            referencia = $("#idDetAps" + index).val();
        } else {
            referencia = 0;
        }
        var newRow = "<tr id=" + indice + " onClick='seleccionaMov(this);'>\n\
                <td>" + $("#ejercicio" + index).val() + "<input type='text' id=tapejercicio" + indice + " value=" + $("#ejercicio" + index).val() + " style='display:none;'></td>\n\
                <td>" + $("#obraAp").val() + "<input type='text' id=tapobra" + indice + " value=" + $("#obraAp").val() + " style='display:none;'><input type='text' id=tapidModEje" + indice + " value=" + $("#idModEje" + index).val() + " style='display:none;'></td>\n\
                <td>" + $("#movimientoAp option:selected").text() + "<input type='text' id=tapidTipMov" + indice + " class='tipoMovimiento' value=" + $("#movimientoAp").val() + " style='display:none;'></td>\n\
                <td>" + CveOfi + "<input type='text' id=tapidDetOfi" + indice + " value=" + $("#idDetOfi" + index).val() + " style='display:none;'></td>\n\
                <td>" + NomRef + "<input type='text' id=tapidRef" + indice + " value=" + referencia + " style='display:none;'></td>\n\
                <td>" + DscFte + "<input type='text' id=tapidFte" + indice + " value=" + $("#idFte" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + NomInv + "<input type='text' id=tapidInv" + indice + " value=" + $("#idInv" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + NomRec + "<input type='text' id=tapidRec" + indice + " value=" + $("#idRec" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + $("#ejercidoAp").val() + "<input type='text' id=tapafectacion" + indice + " value=" + $("#ejercidoAp").val() + " style='display:none;'><input type='text' id=tapidDetAps" + indice + " value=0 style='display:none;'></td>\n\\n\
            </tr>";

        if ($("#ivaAmortizacion").val() != "") {
            indice++;
            newRow += "<tr id=" + indice + " onClick='seleccionaMov(this);'>\n\
                        <td>" + $("#ejercicio" + index).val() + "<input type='text' id=tapejercicio" + indice + " value=" + $("#ejercicio" + index).val() + " style='display:none;'></td>\n\
                        <td>" + $("#obraAp").val() + "<input type='text' id=tapobra" + indice + " value=" + $("#obraAp").val() + " style='display:none;'><input type='text' id=tapidModEje" + indice + " value=" + $("#idModEje" + index).val() + " style='display:none;'></td>\n\
                        <td>IVA<input type='text' id=tapidTipMov" + indice + " class='tipoMovimiento' value='5' style='display:none;'></td>\n\
                        <td>" + CveOfi + "<input type='text' id=tapidDetOfi" + indice + " value=" + $("#idDetOfi" + index).val() + " style='display:none;'></td>\n\
                        <td>" + NomRef + "<input type='text' id=tapidRef" + indice + " value=" + $("#idDetAps" + index).val() + " style='display:none;'></td>\n\
                        <td>" + DscFte + "<input type='text' id=tapidFte" + indice + " value=" + $("#idFte" + index).val() + " style='display:none;'></td>\n\\n\
                        <td>" + NomInv + "<input type='text' id=tapidInv" + indice + " value=" + $("#idInv" + index).val() + " style='display:none;'></td>\n\\n\
                        <td>" + NomRec + "<input type='text' id=tapidRec" + indice + " value=" + $("#idRec" + index).val() + " style='display:none;'></td>\n\\n\
                        <td>" + $("#ivaAmortizacion").val() + "<input type='text' id=tapafectacion" + indice + " value=" + $("#ivaAmortizacion").val() + " style='display:none;'><input type='text' id=tapidDetAps" + indice + " value=0 style='display:none;'></td>\n\\n\
                    </tr>";
            $("#ivaAmortizacion").val("");
        }

        $("#tablaAp tbody").append(newRow);
        $("#tablaAp").trigger("update");
        $("#ejercidoAp").val("");
        $(".tablesorter:visible").find(".bg-success").trigger("click");
        indice++;
        detalle = true;
        calcularAP();
    }

}

function seleccionaMov(tr) {
    if ($(tr).hasClass("bg-danger")) {
        $(tr).removeClass("bg-danger");
    } else {
        $(tr).addClass("bg-danger");
    }
}

function seleccionaTodos() {
    $("#tablaAp tbody").find("tr").each(function () {
        $(this).addClass("bg-danger");
    });
}

function deseleccionaTodos() {
    $("#tablaAp tbody").find("tr").each(function () {
        $(this).removeClass("bg-danger");
    });
}

function quitarSeleccionados() {
    $("#tablaAp tbody").find(".bg-danger").each(function () {
        var i = $(this).attr("id");
        if ($("#tapidDetAps" + i).val() != 0)
            apBorradas.push($("#idDetAps" + i).val());
        $(this).remove();

    });
    borrarAp();

}

function modTabla() { //SI SE HIZO UN CAMBIO EN LA TABLA DE APLICACIÓN PRESUPUESTAL
    detalle = false;
    calcularAP();
}

function calcularAP() {
    var movimientos = 0;
    $("#tablaAp tbody").find("tr").each(function () {
        movimientos++;
    });

    if (movimientos > 0) {
        var montoTmp;
        var importe = 0;
        var amortizacion = 0;
        var subtotal = 0;
        var iva = 0;
        var afectacion = 0;
        var neto = 0;
        if (none) {
//            alert();
            var icic = 0.00;
            var cmic = 0.00;
            var sup = 0.00;
            var ispt = 0.00;
            var otro = 0.00;
        } else {
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
            iva = $("#ivaAp").val().replace(/,/g, "");
            iva = iva.replace(/,/g, "");
        }
        var retenciones = 0;
        if (detalle) { //MOVIMIENTOS AGREGADOS
            var tipoAdm = false;
            var tipoAnt = false;

            $("#tablaAp tbody").find("tr").each(function () {
                var indice = $(this).attr("id");
                if ($("#tapidModEje" + indice).val() === "2") { //2= ADMINISTRACION
                    tipoAdm = true;
                }
                montoTmp = ($("#tapafectacion" + indice).val().replace(/,/g, ""));
                montoTmp = montoTmp.replace(/,/g, "");
                console.log("Monto TMP:" + montoTmp);


                if ($("#tapidTipMov" + indice).val() === "2") { //2 = ANTICIPO
                    tipoAnt = true;
                }
                if ($("#tapidTipMov" + indice).val() === "2" || $("#tapidTipMov" + indice).val() == "4" || $("#tapidTipMov" + indice).val() == "6") { //ANTICIPO,ESTIMACION,PAGO
                    importe = (parseFloat(importe) + parseFloat(montoTmp));
                    console.log("Importe:" + importe);
                }
                if ($("#tapidTipMov" + indice).val() === "1") { //AMORTIZACION
                    amortizacion = (parseFloat(amortizacion) + parseFloat(montoTmp));
                    console.log("Amortizacion:" + amortizacion);
                }

            });




            if (consulta) {
                console.log("Primer ingreso");
                importe = ((importe - iva) + amortizacion); //IMPORTE SIN IVA
                consulta = false;
            } else {
                importe = ((importe / (1.16)) + amortizacion); //IMPORTE SIN IVA
                console.log("Importe sin iva:" + importe);
                iva = ((importe - amortizacion) * 0.16);//IVA DEL IMPORTE
                console.log("Iva del importe:" + iva)
                if ((importe > amortizacion) && (!tipoAnt) && (!tipoAdm)) { //CALCULAR RETENCIONES SI HAY PAGOS
                    icic = (importe * 0.002);//ICIC
                    cmic = (importe * 0.005);//CMIC
                    sup = (importe * 0.02);//SUPERVISION

                } else {
                    icic = 0.00;//ICIC
                    cmic = 0.00;//CMIC
                    sup = 0.00;//SUPERVISION
                }
            }


            console.log("ICIC:" + icic);
            console.log("CMIC:" + cmic);
            console.log("Supervision:" + sup);
            console.log("ISPT:" + ispt);
            console.log("Otro:" + otro);
        } else { //MODIFICACION DIRECTA A LA TABLA "APLICACION PRESUPUESTAL"
            importe = ($("#sinivaAp").val().replace(/,/g, ""));
            importe = importe.replace(/,/g, "");
            amortizacion = ($("#amortizacionAp").val().replace(/,/g, ""));
            amortizacion = amortizacion.replace(/,/g, "");
            iva = ($("#ivaAp").val().replace(/,/g, ""));
            iva = iva.replace(/,/g, "");
            detalle = false;

        }
        subtotal = (importe) - (amortizacion);//SUBTOTAL
        console.log("Subtotal:" + subtotal);

        afectacion = parseFloat(subtotal) + parseFloat(iva);//AFECTACION PRESUPUESTAL
        console.log("Afectacion:" + afectacion);

        retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro);//AFECTACION PRESUPUESTAL
        console.log("Retenciones:" + retenciones);

        neto = (afectacion) - (retenciones);//AFECTACION PRESUPUESTAL
        console.log("Neto:" + neto);

        $("#sinivaAp").val(importe).focusin().focusout();
        $("#amortizacionAp").val(amortizacion).focusin().focusout();
        $("#subtotalAp").val(subtotal).focusin().focusout();
        $("#ivaAp").val(iva).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#afectacionAp").val(afectacion).focusin().focusout();
        $("#netoAp").val(neto).focusin().focusout();
        $("#icicAp").val(icic).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#cmicAp").val(cmic).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#supervisionAp").val(sup).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#isptAp").val(ispt).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#otroAp").val(otro).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#retencionesAp").val(retenciones).focusin().focusout();
        $("#letranetoAp").val(NumeroALetras($("#netoAp").val().replace(/,/g, "")));

    } else {
        $("#sinivaAp").val(0.00);
        $("#amortizacionAp").val(0.00);
        $("#subtotalAp").val(0.00);
        $("#ivaAp").val(0.00);
        $("#afectacionAp").val(0.00);
        $("#netoAp").val(0.00);
        $("#icicAp").val(0.00);
        $("#cmicAp").val(0.00);
        $("#supervisionAp").val(0.00);
        $("#isptAp").val(0.00);
        $("#otroAp").val(0.00);
        $("#retencionesAp").val(0.00);
        $("#letranetoAp").val("");
    }
}

function guardarAp() {

    var rows = 0;
    $("#tablaAp tbody").find("tr").each(function () {
        rows++;
    });
//    if (estadoAp != 3 && PrmMod != 1) {
//        alert("La AP debe estar en Proceso o Habilitada para Modificaci\u00f3n para poder realizarle cambios");
//        return false;
//    }
    if ($("#idEmpAp").val() == '') {
        alert("Debe seleccionar un Beneficiario v\u00e1lido");
        $("#rfcAp").focus();
        return false;
    }
    if (rows === 0) {
        alert("No hay movimientos realizados");
        return false;
    }

    var fecAlt = 0;
    var fecAlt2 = 0;
    if ($("#fechaAlterna").prop("checked")) { //SI SE CAMBIO LA FECHA SE OBTINE EL PARTE DEL FOLIO
        fecTmp = $("#fecha").val().split("-");
        fecAlt = fecTmp[2] + "" + fecTmp[1] + "" + fecTmp[0];
        fecAlt2 = fecTmp[2] + "-" + fecTmp[1] + "-" + fecTmp[0];
        fecAlt = fecAlt.substring(2, 8);
    }



    var apPrincipal = new Array();

    var apActDet = new Array();
    var principal = {
        'idAps': idAps,
        'NumEst': $("#estimacionAp").val(),
        'idEmp': $("#idEmpAp").val(),
        'ObsAps': $("#observacionesAp").val(),
        'PrmMod': 0,
        'Iva': $("#ivaAp").val().replace(/,/g, ""),
        'RetCnic': $("#icicAp").val().replace(/,/g, ""),
        'RetCicem': $("#cmicAp").val().replace(/,/g, ""),
        'RetSup': $("#supervisionAp").val().replace(/,/g, ""),
        'RetISPT': $("#isptAp").val().replace(/,/g, ""),
        'RetOtr': $("#otroAp").val().replace(/,/g, ""),
        'fecAlt': fecAlt,
        'fechaAlternativa': fecAlt2
    };
    apPrincipal.push(principal);

    if ($("#apRegistrada").prop("checked")) { //Actualizar Ap ya registrada
        $.ajax({
            data: {'accion': 'actualizarAp', 'apPrincipal': apPrincipal},
            url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
            type: 'post',
            success: function (response) {
                console.log(response);
                if (response) {
                    console.log("Insertar movimientos");
                    insertarMovimientos(idAps);
                } else {
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html("Error");
                    $('#dialogAvisos').on('hidden.bs.modal', function () {

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
    } else {                                //REGISTRAR NUEVA AP
        $.ajax({
            data: {'accion': 'registrarAp', 'apPrincipal': apPrincipal},
            url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
            type: 'post',
            success: function (response) {
                var data = jQuery.parseJSON(response);
                console.log(response);
                if (response) {
                    CveAps = data[1];
                    insertarMovimientos(data[0]);
                } else {
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html("Error");
                    $('#dialogAvisos').on('hidden.bs.modal', function () {

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
}

function insertarMovimientos(id) {
    var apDetalle = new Array();
    $("#tablaAp tbody").find("tr").each(function () { //SI LOS MOVIMIENTOS SON NUEVOS INSERTAR DATOS
        var index = $(this).attr("id");

        if ($("#tapidDetAps" + index).val() == 0) {
            var ivaAmort = 0;
            var factor = $("#tapafectacion" + index).val().replace(/,/g, "") / $("#afectacionAp").val().replace(/,/g, "");
            console.log("Factor: " + factor);
            if (($("#tapidTipMov" + index).val() != "2" && $("#tapidTipMov" + index).val() != "4" && $("#tapidTipMov" + index).val() != "6") || factor == null) {
                factor = 0;
            } else {
                ivaAmort = factor * ivaAp;
            }


            var detalle = {
                'idAps': id,
                'idDetOfi': $("#tapidDetOfi" + index).val(),
                'idRef': $("#tapidRef" + index).val(),
                'idTipAps': $("#tapidTipMov" + index).val(),
                'IvaAmo': ivaAmort,
                'Monto': $("#tapafectacion" + index).val(),
                'RetCnic': factor * $("#icicAp").val().replace(/,/g, ""),
                'RetCicem': factor * $("#cmicAp").val().replace(/,/g, ""),
                'RetSup': factor * $("#supervisionAp").val().replace(/,/g, ""),
                'RetISPT': factor * $("#isptAp").val().replace(/,/g, ""),
                'RetOtr': factor * $("#otroAp").val().replace(/,/g, "")
            }

            apDetalle.push(detalle);
        } else {
            //VERIFICAR SI HAY QUE ACTUALIZAR EL EL PRORATEO DE LOS MOVIMIENTOS YA REGISTRADOS
        }
    });
    console.log("Movimientos nuevos:");
    console.log(apDetalle);
    $.ajax({
        data: {'accion': 'guardaDetalle', 'apDetalle': apDetalle},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
//            alert(response);
            console.log(response);
//            if (response) {
//                if (apBorradas.length > 0) {
//                    console.log("Borrar Detalles");
//                    borrarAp();
//                }
//                else {
//                 
            $("#dialogAvisos").modal();
            $("#msgAviso").html("Datos guardados");
            $('#dialogAvisos').on('hidden.bs.modal', function () {

                $("#btnImpresion").show();
                $("#apRegistrada").prop("checked", true);
                $("#apF").show();
                $("#folioAp").val(CveAps).change().focus();

            });

//                }
//            }
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

function borrarAp() {
    console.log("Aps borradas:" + apBorradas);
    $.ajax({
        data: {'accion': 'borrarDetalle', 'apBorradas': apBorradas},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);

//                $("#dialogAvisos").modal();
//                $("#msgAviso").html("Datos guardados");
//                $('#dialogAvisos').on('hidden.bs.modal', function () {
//                    $("#btnImpresion").show();
//                    $("#apRegistrada").prop("checked",true);
//                    $("#folioAp").val(CveAps).focus();
//                });
            $(".tablesorter:visible").find(".bg-success").click();
            alert($(".tablesorter:visible").find(".bg-success").attr('onclick'));
            detalle = true;


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

function cerrarAp() {

    $.ajax({
        data: {'accion': 'cambiarEstado', 'idAps': idAps, 'estado': 5},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response) {
                $("#dialogAvisos").modal();
                $("#msgAviso").html("La Aplicaci\u00f3n de Pago a sido cerrada.");

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

function imprimirAp() {

    var datosGenerales = new Array();
    var datosAmortizacion = new Array();
    var aplicacionPresupuestal = new Array();
    var movimientos = new Array();
    var mAgua = 0;

    if (estadoAp == '4') {
        mAgua = 1;
    }
    var tmpGenerales = {
        'CveAps': CveAps,
        'Ejercicio': $("#tapejercicio0").val(),
        'unidadEjecutora': $("#ejecutoraAp").val(),
        'idDep': idDep,
        'numObra': $("#obraAp").val(),
        'nomObra': $("#nombreobraAp").val(),
        'modEje': $("#tapidModEje0").val(),
        'rfcBeneficiario': $("#rfcAp").val(),
        'nomBeneficiario': $("#beneficiarioAp").val(),
        'obs': $("#observacionesAp").val(),
        'sector': $("#sectorAp").val(),
        'mAgua': mAgua,
        'conceptoPago': $("#tapidTipMov0").val(),
        'estimacion': $("#estimacionAp").val()
    };
    datosGenerales.push(tmpGenerales);

    if ($("#tapidTipMov0").val() == "1" || $("#tapidTipMov0").val() == "4") {

        $("#tablaAp tbody").find("tr").each(function () {
            var ind = $(this).attr("id");
            var tmpAmortizacion = {
                'idTipMov': $("#tapidTipMov" + ind).val(),
                'cveRef': $("#tapidRef" + ind).parent("td").text(),
                'afectacion': $("#tapafectacion" + ind).val()
            }
            datosAmortizacion.push(tmpAmortizacion);
        });

    } else {
        datosAmortizacion = null;
    }


    var tmpAplicacion = {
        'impSinIva': $("#sinivaAp").val(),
        'amortizacion': $("#amortizacionAp").val(),
        'subtotal': $("#subtotalAp").val(),
        'iva': $("#ivaAp").val(),
        'afectacion': $("#afectacionAp").val(),
        'retenciones': $("#retencionesAp").val(),
        'icic': $("#icicAp").val(),
        'cmic': $("#cmicAp").val(),
        'supervision': $("#supervisionAp").val(),
        'ispt': $("#isptAp").val(),
        'otro': $("#otroAp").val(),
        'neto': $("#netoAp").val(),
        'letraNeto': $("#letranetoAp").val()
    };
    aplicacionPresupuestal.push(tmpAplicacion);

    $("#tablaAp tbody").find("tr").each(function () {
        var ind = $(this).attr("id");
        var tmpMovimientos = {
            'oficio': $("#tapidDetOfi" + ind).parent("td").text(),
            'fuente': $("#tapidFte" + ind).parent("td").text(),
            'inversion': $("#tapidInv" + ind).parent("td").text()
        };
        movimientos.push(tmpMovimientos);

    });


    $.ajax({
        data: {'accion': 'imprimeAp', 'datosGenerales': datosGenerales, 'datosAmortizacion': datosAmortizacion, 'aplicacionPresupuestal': aplicacionPresupuestal, 'movimientos': movimientos, 'idDetObr': $("#idDetObrAp").val()},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            if (response) {
                window.open("contenido_sgi/vistas/aplicacion/funciones/impresionAp.php", "_blank");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscarDevoluciones() {
    $("#tablaDev tbody").find("tr").each(function () {
        $(this).remove();
    });
    $.ajax({
        data: {'accion': 'getDevoluciones', 'idAps': idAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            var newRow = "";
            for (var i = 0; i < data.length; i++) {
                newRow += "<tr>\n\
                            <td>" + data[i].FecDev + "</td>\n\
                            <td>" + data[i].OfiDev + "</td>\n\
                            <td>" + data[i].idUsu + "</td>\n\
                            <td>" + data[i].ObsDev + "</td>\n\
                        </tr>";

            }
            $("#tablaDev tbody").append(newRow);
            $("#tablaDev").trigger("update");

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardarDevolucion() {
    var datos = new Array();
    var fecDev = $("#fecDev").val();
    var oficioDev = $("#oficioDev").val();
    var obsDev = $("#obsDev").val();
    var temp = {
        'idAps': idAps,
        'FecDev': fecDev,
        'OfiDev': oficioDev,
        'Obs': obsDev
    };
    datos.push(temp);
    $.ajax({
        data: {'accion': 'devolucionAp', 'ap': datos},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response) {
                buscarDevoluciones();
                $('#dialogDevolucion').on('hidden.bs.modal', function () {
                    location.reload();
                });
            } else {
                alert("Ocurrio un error al generar devolucion");
            }
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


