//GLOBALES
var idSol = datosGlobalesSolicitud.idsolicitud;
var fuentes = [];
var idFuentes = [];
var tablaConceptos;
var indiceEditar;
var arrayEliminados = [];
var ftesEliminadas = [];
var ftesActualizadas = [];
var pariPassu = true;
var montosFuentes = [];
var IdEdoSol = 1;
var totalGeneral = 0;
var error = false;
var guardado = false;
var primeraVez = true;
var montoAutorizado = 0;


$(document).ready(function () {

//    $.fn.dataTableExt.sErrMode = 'throw';


    tablaConceptosReduccion = $('#tablaConceptosReduccion').DataTable({"retrieve": true, "ordering": false, "sPaginationType": "bootstrap",
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
        }});
    tablaConceptosReduccion.column(0).visible(false); //ID CONCEPTO
    tablaConceptosReduccion.column(10).visible(false); // ID CONTRATO



    $(".number").autoNumeric({vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});

    $("#pariPassu").click(function () {
        desactivarPP();
    });

    $("#abreModal").click(function () {
        $("#actualizarConcepto").hide();
        $("#agregaConcepto").show();
        $("#modalConcepto").modal("show");
    });

    $('#cantidad,#preciou').on("change", function () {
        calcularTotal();
    });

    $("#ivaCheck").click(function () {
        calcularTotal();
    });

    $("#cancelarConcepto").click(function () {
        limpiar("modalConcepto");
        $("#totalConcepto").text("0.00");
        $("#ivaCheck").attr('checked', false);
        $("#modalConcepto").modal("hide");
        eliminaMensajePop($("#reduccionMonto"));
    });

    //verificarTipoSolicitud();
    //verificarEstadoSolicitud();

});

function desactivarPP() {
    if ($("#pariPassu").is(":checked")) {
        pariPassu = true;
        $("#fte").hide();

//        tablaConceptos.column(9).visible(false);
    } else {
        pariPassu = false;


        for (var i = 0; i < fuentes.length; i++) {
            idFuentes.push(fuentes[i][0]);
        }

        $.ajax({
            data: {idFuentes: idFuentes, accion: "getFuentesSeleccionadas"},
            url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
//                console.log(response);
                $("#ftes").find("option").remove();
                $("#ftes").append(response);
                $("#fte").show();
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });

//        tablaConceptos.column(9).visible(true);
    }
}

function modificarConceptoReduccion() {
    var id = tablaConceptosReduccion.cell(indiceEditar, 0).data();
    var totalReduccion = $("#reduccionMonto").val().replace(/,/g, "");
    var totalDisponible = $("#reduccionEjercido").val().replace(/,/g, "");
    if (parseFloat(totalReduccion) <= parseFloat(totalDisponible)) {
        eliminaMensajePop($("#reduccionMonto"));
        if (calcularMontosFtes(totalReduccion, indiceEditar)) {
            tablaConceptosReduccion.cell(indiceEditar, 13).data(totalReduccion).draw();
            actualizaTotales();
            $("#reduccionMonto").text("0.00");
            limpiar("modalConcepto");
            $("#modalConcepto").modal("hide");
            guardado = false; //OBLIGAMOS AL USUARIO A GUARDAR LA HOJA
        }
    } else {
        colocaMensajePop($("#reduccionMonto"), "Error", "No se puede reducir mas de lo disponible");
        error = true;
    }
}

function calcularTotal() {
    var cantidad = $("#cantidad").val().replace(/,/g, "");
    var precio = $("#preciou").val().replace(/,/g, "");
    var importeSinIva = cantidad * precio;
    var iva = 0.00;
    var totalConcepto = 0.00;
    $("#impsiniva").val(importeSinIva);
    $("#impsiniva").autoNumeric("update");

    if ($("#ivaCheck").is(":checked")) {
        iva = importeSinIva * 0.16;
        totalConcepto = importeSinIva + iva;
        $("#iva").val(iva);
        $("#iva").autoNumeric("update");
    }
    else {
        totalConcepto = importeSinIva;
        $("#iva").val(0.00);
        $("#iva").autoNumeric("update");
    }

    $("#totalConcepto").text(totalConcepto);
    $("#totalConcepto").autoNumeric("update");
}

function actualizaTotales() {

    var totalSinIva = 0;
    var totalIva = 0;
    var total = 0;
    var totalReducciones = 0.00;
    var arraySinIva = tablaConceptosReduccion.column(6).data();
    var arrayIva = tablaConceptosReduccion.column(7).data();
    var arrayTotal = tablaConceptosReduccion.column(8).data();
    var arrayTotalReducciones = tablaConceptosReduccion.column(13).data();

    for (var i = 0; i < arrayTotal.length; i++) {
        totalSinIva = parseFloat(totalSinIva) + parseFloat(arraySinIva[i].replace(/,/g, ""));
        totalIva = parseFloat(totalIva) + parseFloat(arrayIva[i].replace(/,/g, ""));
        total = parseFloat(total) + parseFloat(arrayTotal[i].replace(/,/g, ""));
        totalReducciones = parseFloat(totalReducciones) + parseFloat(arrayTotalReducciones[i].replace(/,/g, ""));
    }

    $("#totalSinIva").text(totalSinIva);
    $("#totalIva").text(totalIva);
    $("#total").text(total);
    $("#totalReduccion").text(totalReducciones);
    datosGlobalesSolicitud.totalReduccion = totalReducciones;
    $("#totalSinIva,#totalIva,#total,#totalReduccion").autoNumeric("update");

}

function calcularMontosFtes(totalConcepto, indice) {
    var tmpMontos = [];
    totalConcepto = totalConcepto.replace(/,/g, "");
    if (!pariPassu) { //Si no es PP se selecciona una fuente por concepto
        fuenteSeleccionada = $("#ftes").val();
//        if (primeraVez) {
//            for (var i = 0; i < fuentes.length; i++) {
//                if (fuentes[i][0] == fuenteSeleccionada) { //Se busca la fuente seleccionada en el array
//                    if (totalConcepto <= fuentes[i][2]) { //Si el monto del concepto > a monto por fte-> aviso
//                        fuentes[i][2] = fuentes[i][2] - totalConcepto; // Se resta el total de concepto al monto de inv de la fuente
//                        tmpMontos.push([fuenteSeleccionada, totalConcepto]);
//                        montosFuentes.push(tmpMontos); //Se guarda el idFte, pjeInv y  el total de concepto  
//                    } else {
//                        alert("El monto del concepto supera el monto de inversion de la fuente");
//                        return false;
//                    }
//                }
//            }
//        } else {
        if (fuenteSeleccionada == montosFuentes[indice][0][0]) { // si solo cambiaron los montos

            for (var i = 0; i < fuentes.length; i++) {
                if (fuentes[i][0] == fuenteSeleccionada) { //buscamos los datos de la fuente
                    if (totalConcepto <= fuentes[i][2] + parseFloat(montosFuentes[indice][0][1])) {
                        fuentes[i][2] = (fuentes[i][2] + parseFloat(montosFuentes[indice][0][1])) - totalConcepto;
                        montosFuentes[indice][0][1] = totalConcepto;
                    }
                }
            }
//            }
        }

    }
    else { // Si es PP se realiza el prorrateo de montos sobre todas las fuentes

        for (var i = 0; i < montosFuentes[indice].length; i++) {
            for (var j = 0; j < fuentes.length; j++) {
                if (fuentes[j][0] == montosFuentes[indice][i][0]) {
                    var pje = fuentes[j][3];
                    var montoFte = (totalConcepto * pje) / 100;
                    fuentes[i][2] = fuentes[i][2] - montoFte;
                    montosFuentes[indice][i][1] = montoFte;

                }
            }
        }
//        }
    }

    console.log("REDUCCION POR CONCEPTO");
    console.log(montosFuentes);
    return true;
}

function editarReduccion(elem) {
    indiceEditar = tablaConceptosReduccion.row($(elem).parent().parent()).index();
    var datosFila = tablaConceptosReduccion.row(indiceEditar).data();
    $("#clave").val(datosFila[1]).attr("readonly", true);
    $("#concepto").val(datosFila[2]).attr("readonly", true);
    $("#unidadm").val(datosFila[3]).attr("readonly", true);
    $("#cantidad").val(datosFila[4]).attr("readonly", true);
    $("#preciou").val(datosFila[5]).attr("readonly", true);
    $("#impsiniva").val(datosFila[6]).attr("readonly", true);
    $("#iva").val(datosFila[7]).attr("readonly", true);
    if (datosFila[7] > 0) {
        $("#ivaCheck").click().attr("disabled", true);
    }
    $("#ivaCheck").attr("disabled", true);
    $("#totalConcepto").text(datosFila[8]).attr("readonly", true);
    if (!pariPassu) {
        $("#ftes").val(datosFila[9]).attr("readonly", true);
    }
    $("#idFte").val(datosFila[9]).attr("readonly", true);
    $("#idContrato").val(datosFila[10]).attr("readonly", true);
    $("#reduccionEjercido").val(parseFloat(datosFila[12]));
    $("#actualizarConcepto,#camposReduccion").show();
    $("#agregaConcepto").hide();
    $("#modalConcepto").modal("show");
}

function limpiar(limformularios) {
    $("#" + limformularios + " :input").each(function () {
        $(this).val('');
    });

}

function  cargarConceptosReduccion(callback) {
    $("#abreModal").hide();
    $("#divConceptos").hide();
    $("#divReduccion").show();
    var arrayConceptosReduccion = [];
//    tablaConceptosReduccion.clear().draw();
    idSol = datosGlobalesSolicitud.idsolicitud;
    totalGeneral = 0;
    colocaWaitGeneral();
    $.ajax({
        data: {idSol: idSol, accion: "getHoja3Reduccion"},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            var dataConceptos = $.parseJSON(response);
            for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                arrayConceptosReduccion[i] = {"idPresu": dataConceptos.conceptos[i].idPresu, "disponibleReduccion": dataConceptos.conceptos[i].disponibleReduccion,"idContrato":dataConceptos.conceptos[i].idContrato};
            }
            datosGlobalesSolicitud.conceptosReduccion = arrayConceptosReduccion;
            console.log(datosGlobalesSolicitud.conceptosReduccion);
            if (typeof (callback) === "function") {
                callback();
            }
        },
        error: function (response) {
            bootbox.alert(response);
        }
    });
    eliminaWaitGeneral();

}

function guardarHoja3() {
    console.log("ERROR:" + error);
    alert();
    if (!error) {
        
        var conceptosPresupuesto = [];
        var conceptos = tablaConceptosReduccion.rows().data();

        for (var i = 0; i < conceptos.length; i++) {
            conceptosPresupuesto.push(conceptos[i]);
        }
        var datosPresupuesto = {
            conceptos: conceptosPresupuesto,
            conceptosEliminados: arrayEliminados,
            idSol: datosGlobalesSolicitud.idsolicitud,
            accion: 'guardaHoja3',
            pp: pariPassu,
            relprefte: montosFuentes,
            modulo: modulo,
            idSolPre: datosGlobalesSolicitud.tiposolicitud
        };
        //console.log(montosFuentes);
        console.log(datosPresupuesto);
        //        
        $.ajax({
            data: datosPresupuesto,
            url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
//                console.log(response);

                var id = $.parseJSON(response);
                if (id) {
                    for (var i = 0; i < id.length; i++) {
                        tablaConceptos.cell(parseInt(id[i][1]), 0).data(parseInt(id[i][0])).draw();
                        guardado = true;
                    }
//                tablaConceptos.column(0).visible(false);
                    eliminaWaitGeneral();
                    bootbox.alert('Datos guardados.');
                }
                guardado = true;
                //console.log(tablaConceptos.data());
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });

    } else {

        actualizaTotales();
    }
}
