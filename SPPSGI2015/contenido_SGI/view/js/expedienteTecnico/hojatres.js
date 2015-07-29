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
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            for (var i = 4; i <= 8; i++) {
                var cell = tablaConceptos.cell(nRow, i).node();
                $(cell).addClass('number');
            }
        }, "drawCallback": function (settings) {
            $(".number").autoNumeric();
            $(".number").autoNumeric("update");
        }
    });
    tablaConceptos.column(0).visible(false); //ID CONCEPTO
    tablaConceptos.column(10).visible(false); // ID CONTRATO

    var uploader = new qq.FileUploader({
        element: document.getElementById('cargaCatalogoConceptos'),
        uploadButtonText: 'Cargar archivo',
        action: 'contenido_sgi/libs/fileuploaderServ.php',
        debug: true,
        onComplete: function (id, fileName, responseJSON) {
            cargaExterna(fileName);
        },
    });
    
//    $("#descargarTemplate").click(function(){
//        
//    });

    if (modulo == "1") {
        $("#cargaCatalogoConceptos").show();
    } else {
        $("#cargaCatalogoConceptos").hide();
    }

    $("#tablaConceptos tbody").on("click", "tr", function () {

    });

    $(".number").autoNumeric({vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});

    $("#pariPassu").click(function () {
        //desactivarPP();
    });

    $("#pariPassu").unbind("change").on("change", function () {
        for (var i = 0; i < fuentes.length; i++) {
            fuentes[i][2] = fuentes[i][1];
        }
        for (var i = 0; i < tablaConceptos.column(0).data().length; i++) {
            tablaConceptos.cell(i, 9).data("");
        }
        tablaConceptos.draw();
        montosFuentes = [];
        colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Se deben relacionar los conceptos con las fuentes");
        error = true;
        primeraVez = true;
        desactivarPP();
    });

    $("#abreModal").click(function () {
        $("#actualizarConcepto").hide();
        $("#agregaConcepto").show();
        $("#modalConcepto").modal("show");
    });

    $("#actualizarConcepto").click(function () {
        modificarConcepto();
    });

    $("#agregaConcepto").click(function () {
        agregarConcepto();
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
        colocaWaitGeneral();
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
        eliminaWaitGeneral();
//        tablaConceptos.column(9).visible(true);
    }
}

function agregarConcepto() {
    var displayFtes = "";
    if (pariPassu) {
        displayFtes = "Varias";
    } else {
//        displayFtes = $("#ftes").val();
        displayFtes = $("#ftes option:selected").text();
    }

    //Seleccionamos la Fuente y realizamos los calculos depenndiendo la modalidad
    var totalConcepto = $("#totalConcepto").text().replace(/,/g, "");
    if (calcularMontosFtes(totalConcepto, "add", 0)) { //Si regresa falso supero el monto de inversion
        tablaConceptos.row.add(["", $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text(), displayFtes, "0", '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
        tablaConceptos.column(0).visible(false); //ID CONCEPTO
        tablaConceptos.column(10).visible(false); // ID CONTRATO
        actualizaTotales();
        $("#totalConcepto").text("0.00");
        $("#ivaCheck").attr('checked', false);
        limpiar("modalConcepto");
        $("#modalConcepto").modal("hide");
    }
    $("#pariPassu").attr("disabled", true);
}

function modificarConcepto() {
    //datosGlobalesSolicitud.fuentes = [];
    var id = tablaConceptos.cell(indiceEditar, 0).data();
    var totalConcepto = $("#totalConcepto").text().replace(/,/g, "");
    var fteAux = "";
    if (id != "") {
        id = id;
    } else {
        id = ("");
    }
    if (pariPassu) {
        fteAux = "Varias";
    } else {
//        fteAux = $("#ftes").val();
        fteAux = $("#ftes option:selected").text();
    }

    if (calcularMontosFtes(totalConcepto, "update", indiceEditar)) {
        tablaConceptos.row(indiceEditar).data([id, $("#clave").val(), $("#concepto").val(), $("#unidadm").val(), $("#cantidad").val(), $("#preciou").val(), $("#impsiniva").val(), $("#iva").val(), $("#totalConcepto").text().replace(/,/g, ""), fteAux, $("#idContrato").val(), '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>', '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
        tablaConceptos.column(0).visible(false); //ID CONCEPTO
        tablaConceptos.column(10).visible(false); // ID CONTRATO
        actualizaTotales();
        $("#totalConcepto").text("0.00");
        $("#ivaCheck").attr('checked', false);
        limpiar("modalConcepto");
        $("#modalConcepto").modal("hide");
        guardado = false; //OBLIGAMOS AL USUARIO A GUARDAR LA HOJA
    }
    if (modulo == "3" || modulo == "3.1") {//Verificamos se hayan relacionado los conceptos con las fuentes para quitar error
        for (var i = 0; i < tablaConceptos.data().length; i++) {
            if (tablaConceptos.cell(i, 9).data() == "") {
//                $("#errorRelPreFte").show();
                setTimeout(function () {
                    colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Se deben relacionar los conceptos con las fuentes");
                }, 500);
                error = true;
                return false;
            } else {
                eliminaMensajePop($("#btnGuardarParcialMP"));
//                $("#errorRelPreFte").hide();
                error = false;
            }
        }

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
    var arraySinIva = tablaConceptos.column(6).data();
    var arrayIva = tablaConceptos.column(7).data();
    var arrayTotal = tablaConceptos.column(8).data();
    //console.log(arrayTotal);

    for (var i = 0; i < arrayTotal.length; i++) {
        totalSinIva = parseFloat(totalSinIva) + parseFloat(arraySinIva[i].replace(/,/g, ""));
        totalIva = parseFloat(totalIva) + parseFloat(arrayIva[i].replace(/,/g, ""));
        total = parseFloat(total) + parseFloat(arrayTotal[i].replace(/,/g, ""));
    }

    $("#totalSinIva").text(totalSinIva);
    $("#totalIva").text(totalIva);
    $("#total").text(total);
    datosGlobalesSolicitud.totalConceptos = total;
    $("#totalSinIva,#totalIva,#total").autoNumeric("update");

    if (datosGlobalesSolicitud.tiposolicitud == "12" && datosGlobalesSolicitud.psolicitud.EvaSoc == "1") {
        if ((total - montoAutorizado) > monto25) { //AMPLIACION, SI SOBREPASA EL 25% DEL AUTORIZADO AVISAR
//            $("#error25Ampliacion").show();
            colocaMensajePop($("#btnGuardarParcial"), "Atenci\u00f3n", "Se super&oacute; el 25% del monto autorizado, se debe ingresar nuevo Estudio Socioecon&oacute;mico");
        } else {
            eliminaMensajePop($("#btnGuardarParcial"));
//            $("#error25Ampliacion").hide();
        }
    }

    //SI ES AUTORIZACION
    if (datosGlobalesSolicitud.tiposolicitud == "3" && datosGlobalesSolicitud.psolicitud.EvaSoc == "1" && modulo != "2") {
        if (total > totalGeneral) {
            colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "El monto ha superado el monto inicial\nMonto inicial: $<span class='n'>" + totalGeneral + "</span>");
            error = true;
        } else {
            eliminaMensajePop($("#btnGuardarParcialMP"));
            error = false;
        }
    }

    if ((datosGlobalesSolicitud.tiposolicitud == "10" || datosGlobalesSolicitud.tiposolicitud == "11" || datosGlobalesSolicitud.tiposolicitud == "13") && modulo != "2") {
        if (total < totalGeneral) {
            eliminaMensajePop($("#btnGuardarParcial"));
            colocaMensajePop($("#btnGuardarParcial"), "Atenci\u00f3n", "El monto es menor al monto inicial\nMonto inicial: $<span class='n'>" + totalGeneral + "</span>");

            error = true;
        } else if (total > totalGeneral) {
            eliminaMensajePop($("#btnGuardarParcial"));
            colocaMensajePop($("#btnGuardarParcial"), "Atenci\u00f3n", "El monto es mayor al monto inicial\nMonto inicial: $<span class='n'>" + totalGeneral + "</span>");
            $(".n").autoNumeric();

            error = true;
        } else {
            eliminaMensajePop($("#btnGuardarParcial"));
            error = false;
        }
        $(".n").autoNumeric();

    } else {
        if (total > totalGeneral) {
            colocaMensajePop($("#btnGuardarParcial"), "Atenci\u00f3n", "El monto ha superado el monto inicial\nMonto inicial: $<span class='n'>" + totalGeneral + "</span>");
            error = true;
        } else {
            eliminaMensajePop($("#btnGuardarParcial"));
            error = false;
        }
    }
    //verificar el monto total con el monto inicial y desplegar alert


}

function calcularMontosFtes(totalConcepto, operacion, indice) {
    var tmpMontos = [];
    console.log(fuentes);
    console.log(montosFuentes);
    switch (operacion) {
        case 'add':
            if (!pariPassu) { //Si no es PP se selecciona una fuente por concepto
                fuenteSeleccionada = $("#ftes").val();
                for (var i = 0; i < fuentes.length; i++) {
                    if (fuentes[i][0] == fuenteSeleccionada) { //Se busca la fuente seleccionada en el array
                        if (totalConcepto <= parseFloat(fuentes[i][2])) { //Si el monto del concepto > a monto por fte-> aviso
                            fuentes[i][2] = parseFloat(fuentes[i][2]) - totalConcepto; // Se resta el total de concepto al monto de inv de la fuente
                            tmpMontos.push([fuenteSeleccionada, 'dummy', totalConcepto]);
                            montosFuentes.push(tmpMontos); //Se guarda el idFte, pjeInv y  el total de concepto  
                        } else {
                            bootbox.alert("El monto del concepto supera el monto de inversion de la fuente", function () {
                            });

                        }
                    }
                }
            }
            else { // Si es PP se realiza el prorrateo de montos sobre todas las fuentes
                var tmpFtes = [];
                var sumaFuentes = 0;
                for (var i = 0; i < fuentes.length; i++) {
                    var idfte = fuentes[i][0];
                    var pje = fuentes[i][3];
                    var montoFte = (totalConcepto * pje) / 100; //Se realiza el prorrateo para cada fuente
                    sumaFuentes = sumaFuentes + montoFte;
                    fuentes[i][2] = parseFloat(fuentes[i][2]) - montoFte; //Se resta el monto al monto de inv de la fuente
                    tmpFtes.push([idfte, 'dummy', montoFte]);

                }
                montosFuentes.push(tmpFtes); //Se guarda el idFte, pjeInv y  el total de concepto  
                if (sumaFuentes < totalConcepto) {
                    fuentes[0][2] = parseFloat(fuentes[0][2]) + parseFloat(sumaFuentes - totalConcepto);
                    montosFuentes[0][0][2] = montosFuentes[0][0][2] + parseFloat(sumaFuentes - totalConcepto);
                } else if (sumaFuentes > totalConcepto) {
                    fuentes[0][2] = parseFloat(fuentes[0][2]) - parseFloat(sumaFuentes - totalConcepto);
                    montosFuentes[0][0][2] = montosFuentes[0][0][2] - parseFloat(sumaFuentes - totalConcepto);
                }

                if ((datosGlobalesSolicitud.tiposolicitud != "3" && modulo != "1") || (modulo == "1" && (datosGlobalesSolicitud.tiposolicitud == "10" || datosGlobalesSolicitud.tiposolicitud == "11" || datosGlobalesSolicitud.tiposolicitud == "13"))) {
                    //BUSCAMOS SI HAY UN MONTO DISPONIBLE NEGATIVO EN LA FUENTES
                    for (var i = 0; i < fuentes.length; i++) {
                        if (fuentes[i][2] < 0.00) {
                            var montoModificable = parseFloat(fuentes[i][2]) * (-1);
                            montoModificable = montoModificable.toFixed(2);

                            for (var k = 0; k < fuentes.length; k++) {
                                if (fuentes[k][1] !== fuentes[i][1]) {
                                    if ((parseFloat(fuentes[k][2]).toFixed(2) - parseFloat(montoModificable)) >= 0) //VERIFICAMOS QUE LE ALCANCE A OTRA FUENTE
                                    {
                                        for (var j = 0; j < montosFuentes[indice].length; j++) {
                                            if (fuentes[k][0] == montosFuentes[indice][j][0]) { //EL MONTO SE LO SUMAMAMOS A OTRA FTE
                                                fuentes[k][2] = parseFloat(fuentes[k][2]).toFixed(2) - parseFloat(montoModificable);
                                                montosFuentes[indice][j][2] = montosFuentes[indice][j][2] + parseFloat(montoModificable);
                                            }
                                            if (fuentes[i][0] == montosFuentes[indice][j][0]) { //SE LO RESTAMOS A LA FUENTE NEGATIVA   
                                                fuentes[i][2] = 0.00;
                                                montosFuentes[indice][j][2] = montosFuentes[indice][j][2] - parseFloat(montoModificable);
                                            }

                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            break;
        case 'cancel':
            if (!pariPassu) { //Si no es PP se selecciona una fuente por concepto
                var fteBuscar = montosFuentes[indice][0][0];
                var montofteBuscar = montosFuentes[indice][0][2];
                for (var i = 0; i < fuentes.length; i++) {
                    if (fteBuscar == fuentes[i][0]) { //Se busca la fuente seleccionada en el array
                        fuentes[i][2] = parseFloat(fuentes[i][2]) + parseFloat(montofteBuscar); // Sumamos el monto del concepto borrado al monto de inversion
                        montosFuentes.splice(indice, 1); //Eliminamos el registo en el el array
                    }
                }
            }
            else { // Si es PP se realiza el prorrateo de montos sobre todas las fuentes
                totalConcepto = totalConcepto.replace(/,/g, "");
                for (var i = 0; i < fuentes.length; i++) {
                    var idfte = fuentes[i][0];
                    var pje = fuentes[i][3];
                    var montoFte = (totalConcepto * pje) / 100; //Se realiza el prorrateo para cada fuente
                    //console.log(fuentes[i][2] + ":" + montoFte);
                    fuentes[i][2] = parseFloat(fuentes[i][2]) + montoFte; //Se suma el monto cancelado al monto de inv de la fuente
                }
                montosFuentes.splice(indice, 1); //Eliminamos el registo en el el array 

            }
            break;
        case 'update':
            if (!pariPassu) { //Si no es PP se selecciona una fuente por concepto
                fuenteSeleccionada = $("#ftes").val();
                if (primeraVez) {
                    for (var i = 0; i < fuentes.length; i++) {
                        if (fuentes[i][0] == fuenteSeleccionada) { //Se busca la fuente seleccionada en el array
                            if (totalConcepto <= parseFloat(fuentes[i][2])) { //Si el monto del concepto > a monto por fte-> aviso
                                fuentes[i][2] = parseFloat(fuentes[i][2]) - totalConcepto; // Se resta el total de concepto al monto de inv de la fuente
                                tmpMontos.push([fuenteSeleccionada, 'dummy', totalConcepto]);
                                montosFuentes.push(tmpMontos); //Se guarda el idFte, pjeInv y  el total de concepto  
                            } else {
                                bootbox.alert("El monto del concepto supera el monto de inversion de la fuente", function () {

                                });
                                return false;
                            }
                        }
                    }

                } else {
                    if (fuenteSeleccionada == montosFuentes[indice][0][0]) { // si solo cambiaron los montos

                        for (var i = 0; i < fuentes.length; i++) {
                            if (fuentes[i][0] == fuenteSeleccionada) { //buscamos los datos de la fuente
                                if (totalConcepto <= fuentes[i][2] + parseFloat(montosFuentes[indice][0][2])) {
                                    fuentes[i][2] = (fuentes[i][2] + parseFloat(montosFuentes[indice][0][2])) - totalConcepto;
                                    montosFuentes[indice][0][2] = totalConcepto;
                                }
                            }
                        }

                    } else { // Si cambio la fuente
                        for (var i = 0; i < fuentes.length; i++) {
                            if (fuentes[i][0] == fuenteSeleccionada) { //Se busca la fuente seleccionada en el array
                                if (totalConcepto <= fuentes[i][1]) { //Si el monto del concepto > a monto por fte-> aviso
                                    fuentes[i][2] = fuentes[i][2] - totalConcepto; // Se resta el total de concepto al monto de inv de la fuente

                                    for (var j = 0; j < fuentes.length; j++) {
                                        if (fuentes[j][0] == montosFuentes[indice][0][0]) { //buscamos la fuente original 
                                            fuentes[j][2] = parseFloat(fuentes[j][2]) + parseFloat(totalConcepto); // le sumamos el monto
                                        }
                                    }
                                    montosFuentes[indice][0] = [fuenteSeleccionada, 'dummy', totalConcepto]; //Se guarda el idFte, pjeInv y  el total de concepto  
                                } else {
                                    bootbox.alert("El monto del concepto supera el monto de inversion de la fuente", function () {

                                    });
                                    return false;
                                }

                            }
                        }
                    }
                }

            }
            else { // Si es PP se realiza el prorrateo de montos sobre todas las fuentes
                totalConcepto = totalConcepto.replace(/,/g, "");
                totalConcepto = parseFloat(totalConcepto);
//                console.log(fuentes);
                if (primeraVez) {
                    var tmpBand = false;
                    var tmpFtes = [];
                    var sumaFuentes = 0;
                    for (var i = 0; i < fuentes.length; i++) {
                        var idfte = fuentes[i][0];
                        var pje = fuentes[i][3];
                        var montoFte = (totalConcepto * pje) / 100; //Se realiza el prorrateo para cada fuente
//                        alert(montoFte);
                        sumaFuentes = parseFloat(sumaFuentes) + parseFloat(montoFte.toFixed(2));
                        if (fuentes[i][2] > 0) {
                            fuentes[i][2] = parseFloat(fuentes[i][2]) - montoFte; //Se resta el monto al monto de inv de la fuente
                            tmpFtes.push([idfte, 'dummy', montoFte]);
                            tmpBand = false;
                        } else {
                            tmpBand = true;
                        }
//                        console.log("concepto:"+totalConcepto+" PjeFte:"+pje+" TOTAL:"+montoFte);
                    }
                    if (tmpBand) { // VERIFICCAAAAAAR
                        for (var i = 0; i < montosFuentes[indice].length; i++) {
                            for (var j = 0; j < fuentes.length; j++) {
                                if (fuentes[j][0] == montosFuentes[indice][i][0]) {
                                    var pje = fuentes[j][3];

                                    var montoFte = (totalConcepto * pje) / 100;
                                    fuentes[i][2] = parseFloat(fuentes[i][2]) - montoFte;
                                    montosFuentes[indice][i][2] = montoFte;

                                }
                            }
                        }
                    } else {
                        montosFuentes.push(tmpFtes); //Se guarda el idFte, pjeInv y  el total de concepto 
                        if (sumaFuentes < totalConcepto) {
                            fuentes[0][2] = parseFloat(fuentes[0][2]) + parseFloat(sumaFuentes - totalConcepto);
                            montosFuentes[0][0][2] = montosFuentes[0][0][2] + parseFloat(sumaFuentes - totalConcepto);
                        } else if (sumaFuentes > totalConcepto) {
                            fuentes[0][2] = parseFloat(fuentes[0][2]) - parseFloat(sumaFuentes - totalConcepto);
                            montosFuentes[0][0][2] = montosFuentes[0][0][2] - parseFloat(sumaFuentes - totalConcepto);
                        } else {
                            console.log("si es igual");
                        }
                    }
                } else {
                    for (var i = 0; i < montosFuentes[indice].length; i++) {
                        for (var j = 0; j < fuentes.length; j++) {
                            if (fuentes[j][0] == montosFuentes[indice][i][0]) {
                                var pje = fuentes[j][3];

                                var montoFte = (totalConcepto * pje) / 100;
                                fuentes[i][2] = parseFloat(fuentes[i][2]) - montoFte;
                                montosFuentes[indice][i][2] = montoFte;

                            }
                        }
                    }
                }

                if ((datosGlobalesSolicitud.tiposolicitud != "3" && modulo != "1") || (modulo == "1" && (datosGlobalesSolicitud.tiposolicitud == "10" || datosGlobalesSolicitud.tiposolicitud == "11" || datosGlobalesSolicitud.tiposolicitud == "13"))) {
                    //BUSCAMOS SI HAY UN MONTO DISPONIBLE NEGATIVO EN LA FUENTES
                    for (var i = 0; i < fuentes.length; i++) {
                        if (fuentes[i][2] < 0.00) {
                            var montoModificable = parseFloat(fuentes[i][2]) * (-1);
                            montoModificable = montoModificable.toFixed(2);

                            for (var k = 0; k < fuentes.length; k++) {
                                if (fuentes[k][1] !== fuentes[i][1]) {
                                    if ((parseFloat(fuentes[k][2]).toFixed(2) - parseFloat(montoModificable)) >= 0) //VERIFICAMOS QUE LE ALCANCE A OTRA FUENTE
                                    {
                                        for (var j = 0; j < montosFuentes[indice].length; j++) {
                                            if (fuentes[k][0] == montosFuentes[indice][j][0]) { //EL MONTO SE LO SUMAMAMOS A OTRA FTE
                                                fuentes[k][2] = parseFloat(fuentes[k][2]).toFixed(2) - parseFloat(montoModificable);
                                                montosFuentes[indice][j][2] = montosFuentes[indice][j][2] + parseFloat(montoModificable);
                                            }
                                            if (fuentes[i][0] == montosFuentes[indice][j][0]) { //SE LO RESTAMOS A LA FUENTE NEGATIVA   
                                                fuentes[i][2] = 0.00;
                                                montosFuentes[indice][j][2] = montosFuentes[indice][j][2] - parseFloat(montoModificable);
                                            }

                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

            }
//            console.log("fuentes actualizadas");
//            console.log(fuentes);
//            console.log("fuentes Globales");
//            console.log(datosGlobalesSolicitud.fuentes);
//            console.log("montosFuentes actualizadas");
//            console.log(montosFuentes);

            break;
    }

//    datosGlobalesSolicitud.fuentes = fuentes;
//    console.log(fuentes);
//    console.log("MONTO POR CONCEPTO");
//    console.log(montosFuentes);
//    console.log("DISPONIBLE FUENTES:");
//    console.log(fuentes);
    return true;
}

function editar(elem) {
    indiceEditar = tablaConceptos.row($(elem).parent().parent()).index();
    var datosFila = tablaConceptos.row(indiceEditar).data();
    $("#clave").val(datosFila[1]);
    $("#concepto").val(datosFila[2]);
    $("#unidadm").val(datosFila[3]);
    $("#cantidad").val(datosFila[4]).focusin().focusout();
    $("#preciou").val(datosFila[5]).focusin().focusout();
    $("#impsiniva").val(datosFila[6]).focusin().focusout();
    $("#iva").val(datosFila[7]);
    if (datosFila[7] > 0) {
        $("#ivaCheck").click();
    }
    $("#totalConcepto").text(datosFila[8]);
    $("#totalConcepto").autoNumeric("update");
    $("#idFte").val(datosFila[9]);
    $("#idContrato").val(datosFila[10]);
    $("#actualizarConcepto").show();
    $("#agregaConcepto").hide();
    $("#modalConcepto").modal("show");
}

function eliminar(elem) {
    bootbox.confirm("Se eliminar\u00e1 el concepto, \u00BFDesea Continuar?", function (response) {
        if (response) {
            var indiceEliminar = tablaConceptos.row($(elem).parent().parent()).index();
            var montosCancel = tablaConceptos.cell(indiceEliminar, 8).data();
            var datosFila = tablaConceptos.row(indiceEliminar).data();
            if (datosFila[0] > 0) {
                arrayEliminados.push(datosFila[0]);
            }
            tablaConceptos.row(indiceEliminar).remove().draw();
//    tablaConceptos.column(0).visible(false);
            if (tablaConceptos.data().length == 0) {
                $("#pariPassu").attr("disabled", false);
            }
            calcularMontosFtes(montosCancel, "cancel", indiceEliminar);
            actualizaTotales();
        }
    });
}

function limpiar(limformularios) {
    $("#" + limformularios + " :input").each(function () {
        $(this).val('');
    });

}

function cargarConceptos(callback) {
//    console.log("datosGlobalesSolicitud");
//    console.log(datosGlobalesSolicitud);
    tablaConceptos.clear().draw();
    idSol = datosGlobalesSolicitud.idsolicitud;
//   if (datosGlobalesSolicitud.psolicitud !== "") {
    totalGeneral = 0;
    colocaWaitGeneral();

    $.ajax({
        data: {idSol: idSol, accion: "getHoja3"},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            var dataConceptos = $.parseJSON(response);
//            console.log(dataConceptos);
            //CARGA DE MONTOS Y PROCENTAJES DE LAS FUENTES
            fuentes = datosGlobalesSolicitud.fuentes;//[[21, 150000, 17.95332], [22, 250000, 29.92220], [23, 320000, 38.30042], [24, 75500, 9.03651], [25, 40000, 4.78755]];
            console.log(fuentes);
            for (var k = 0; k < datosGlobalesSolicitud.fuentes.length; k++) {
                totalGeneral = totalGeneral + parseFloat(datosGlobalesSolicitud.fuentes[k][1]);
            }
            console.log("TOTAL DE INVERSION:" + totalGeneral);

            if (dataConceptos['conceptos'].length != 0) {
                if (dataConceptos.preftes.length > 0) { //Si no hay registros es porque se realiza la primera autorizacion
                    primeraVez = false;
                    montosFuentes = [];
                    for (var j = 0; j < dataConceptos.preftes.length; j++) {
                        montosFuentes.push(dataConceptos.preftes[j]); // Se llenan los montos de fuentes por concepto
                        for (var l = 0; l < dataConceptos.preftes[j].length; l++) {
                            for (var k = 0; k < fuentes.length; k++) {
                                if (fuentes[k][0] == dataConceptos.preftes[j][l][0]) {
                                    fuentes[k][2] = fuentes[k][2] - dataConceptos.preftes[j][l][2]; //Se actualizan los montos originales disponibles por fuente
                                }
                            }
                        }
                    }
                }
                if (dataConceptos.conceptos.length > 0) {
                    for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                        var editar = '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>';
                        var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
                        var stringFte = "";
                        if (!primeraVez) { //YA HAY CONCEPTOS RELACIONADOS A FUENTES EN AUTORIZACION
                            if (montosFuentes[i].length > 1) {
                                stringFte = "Varias";
                            } else {
                                stringFte = montosFuentes[i][0][3];
                                pariPassu = false;

                            }
//                            $("#errorRelPreFte").hide(); 
                            eliminaMensajePop($("#btnGuardarParcialMP"));
                            error = false;
                        } else { // ENVIAR MENSAJE AL USUARIO QUE DEBE RELACIONAR FUENTES CON CONCEPTOS EN AUTORIZACION
                            error = true;
                            if (modulo == "3") {
                                setTimeout(function () {
                                    colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Se deben relacionar los conceptos con las fuentes");
                                }, 500);
                                //$("#errorRelPreFte").show();
                            } else {
                                tablaConceptos.column(9).visible(false);
                            }

                        }
                        if (dataConceptos.conceptos[i].idContrato != "0") {
                            editar = "";
                            eliminar = "";
                            montoAutorizado = montoAutorizado + parseFloat(dataConceptos.conceptos[i].total);
                        }
                        tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, stringFte, dataConceptos.conceptos[i].idContrato, editar, eliminar]).draw();
                    }

                    tablaConceptos.column(0).visible(false);
                    tablaConceptos.column(10).visible(false);

                    monto25 = (25 * montoAutorizado) / 100;

                    if (!pariPassu && (modulo != "1" || (datosGlobalesSolicitud.tiposolicitud == "10" || datosGlobalesSolicitud.tiposolicitud == "11" || datosGlobalesSolicitud.tiposolicitud == "13"))) {
                        $("#pariPassu").click();
                    }
                    datosGlobalesSolicitud.totalConceptos = montoAutorizado;
                }
//
//            console.log("DISPONIBLE INICIAL PARA FUENTES:");
//            console.log(fuentes);
//            console.log("MONTO POR CONCEPTO FUENTES:");
//            console.log(montosFuentes);

                if (ro) { //SI ES PROCESO DE REVISION
                    tablaConceptos.column(0).visible(false);
                    tablaConceptos.column(10).visible(false);
                    tablaConceptos.column(11).visible(false);
                    tablaConceptos.column(12).visible(false);
                    $("#pariPassu").attr("disabled", "disabled");
                }
//                console.log(tablaConceptos.data());
                eliminaWaitGeneral();
                actualizaTotales();
                guardado = true;
            } else {
                if (modulo == "1" && datosGlobalesSolicitud.psolicitud.IdSolPre != "10") {
                    tablaConceptos.column(9).visible(false);
                }
                eliminaWaitGeneral();
                actualizaTotales();

            }
            if (datosGlobalesSolicitud.tiposolicitud == "1" || datosGlobalesSolicitud.tiposolicitud == "3") {
                $("#pp").hide();
            }
            if (typeof (callback) != "undefined") {
                callback();
            }
            if (typeof (datosGlobalesSolicitud.psolicitud) === "object" && (datosGlobalesSolicitud.psolicitud.IdEdoSol === "3" || datosGlobalesSolicitud.psolicitud.IdEdoSol === "4")) {
                $("#pariPassu").attr("disabled", "disabled");
            }
            console.log("fuentes");
            console.log(fuentes);
            console.log("montosFuentes");
            console.log(montosFuentes);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

//    }

}

function  cargarConceptosAmpliacion(callback) {
    // BUSCAR LOS CONCEPTOS PERO DESHABILITAR LOS CONCEPTOS QU ANTERIORES Y PONE CUALES YA TIENE FUENTES Y CUALES NO
//    console.log(datosGlobalesSolicitud);
    tablaConceptos.clear().draw();
    idSol = datosGlobalesSolicitud.idsolicitud;
//   if (datosGlobalesSolicitud.psolicitud !== "") {
    totalGeneral = 0;
    colocaWaitGeneral();
    $.ajax({
        data: {idSol: idSol, accion: "getHoja3Ampliacion"},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            var dataConceptos = $.parseJSON(response);
            //console.log(dataConceptos);
            //CARGA DE MONTOS Y PROCENTAJES DE LAS FUENTES
//            fuentes = datosGlobalesSolicitud.fuentes;//[[21, 150000, 17.95332], [22, 250000, 29.92220], [23, 320000, 38.30042], [24, 75500, 9.03651], [25, 40000, 4.78755]];

            for (var k = 0; k < datosGlobalesSolicitud.fuentes.length; k++) {
                totalGeneral = totalGeneral + parseFloat(datosGlobalesSolicitud.fuentes[k][1]);
                fuentes.push([datosGlobalesSolicitud.fuentes[k][0], datosGlobalesSolicitud.fuentes[k][1], datosGlobalesSolicitud.fuentes[k][2], datosGlobalesSolicitud.fuentes[k][3], datosGlobalesSolicitud.fuentes[k][4], datosGlobalesSolicitud.fuentes[k][5]]);
            }
            console.log(fuentes);
            console.log(dataConceptos.preftes);
            //console.log("TOTAL DE INVERSION:" + totalGeneral);

            montosFuentes = [];
            for (var j = 0; j < dataConceptos.preftes.length; j++) {
                montosFuentes.push(dataConceptos.preftes[j]); // Se llenan los montos de fuentes por concepto
//                for (var l = 0; l < dataConceptos.preftes[j].length; l++) {
//                    for (var k = 0; k < fuentes.length; k++) {
//                        if (fuentes[k][0] == dataConceptos.preftes[j][l][0]) {
//                            
//                            fuentes[k][2] = fuentes[k][2] - dataConceptos.preftes[j][l][1]; //Se actualizan los montos originales disponibles por fuente
//                        }
//                    }
//                }
            }

            //console.log(montosFuentes);

            for (var i = 0; i < dataConceptos.conceptos.length; i++) {
                var stringFte = "";
                var editar = '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>';
                var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
                if (montosFuentes[i].length > 1) {
                    stringFte = "Varias";
                } else if (montosFuentes[i].length == 1) {
                    stringFte = montosFuentes[i][0][3];
                    pariPassu = false;
                } else {
//                    $("#errorRelPreFte").show();
                    setTimeout(function () {
                        colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Se deben relacionar los conceptos con las fuentes");
                    }, 500);
                    error = true;
                }
                if (dataConceptos.conceptos[i].idContrato != "0") {
                    editar = "";
                    eliminar = "";
                }

                tablaConceptos.row.add([dataConceptos.conceptos[i].idPresu, dataConceptos.conceptos[i].claveObj, dataConceptos.conceptos[i].concept, dataConceptos.conceptos[i].uniMedi, dataConceptos.conceptos[i].cantidad, dataConceptos.conceptos[i].precioUni, dataConceptos.conceptos[i].importe, dataConceptos.conceptos[i].iva, dataConceptos.conceptos[i].total, stringFte, dataConceptos.conceptos[i].idContrato, editar, eliminar]).draw();

            }
            montosFuentes = montosFuentes.filter(Boolean); //ELiminamos los elementos vacios del array

            if (!pariPassu) {
                $("#pariPassu").click();
            }
            actualizaTotales();
            //console.log(datosGlobalesSolicitud.fuentes);
            for (var i = 0; i < datosGlobalesSolicitud.fuentes.length; i++) {
                if (datosGlobalesSolicitud.fuentes[i][5] === "" || !datosGlobalesSolicitud.fuentes[i][5]) {
                    colocaMensajePop($("#btnGuardarParcialMP"), "Atenci\u00f3n", "Existen fuentes sin cuenta");
                    ban = false;
                    return false;
                }
            }

            if (typeof (callback) != "undefined") {
                callback();
            }

        },
        error: function (response) {

        }
    });
    eliminaWaitGeneral();

}

function guardarHoja3() {

    if (!error) {

        var conceptosPresupuesto = [];
        var conceptos = tablaConceptos.rows().data();

        for (var i = 0; i < conceptos.length; i++) {
            conceptosPresupuesto.push(conceptos[i]);
        }
//        console.log(conceptosPresupuesto);
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
        montoAutorizado = $("#total").text().replace(/,/g, "");
        //console.log(montosFuentes);
//        console.log(datosPresupuesto);
//        return false;
//        colocaWaitGeneral();
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
        eliminaWaitGeneral();
        bootbox.alert('Existen errores en los conceptos.');
        actualizaTotales();
    }
}

function cargaExterna(fileName) {
//    alert(fileName);
    colocaWaitGeneral();
    $.ajax({
        type: "POST",
        url: "contenido_SGI/libs/parser.php",
        data: {fileName: fileName},
        success: function (response) {

            var dataConceptos = $.parseJSON(response);
            //console.log(dataConceptos);
            var editar = '<span  class="glyphicon glyphicon glyphicon-pencil" style="cursor:hand;" onClick="editar(this);"></span>';
            var eliminar = '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>';
            var element_count = 0;
            for (e in dataConceptos) {
                element_count++;
            }
            //console.log(element_count);
            for (var i = 1; i <= element_count; i++) {

                tablaConceptos.row.add(["", dataConceptos[i][1], dataConceptos[i][2], dataConceptos[i][3], dataConceptos[i][4], dataConceptos[i][5], dataConceptos[i][6], dataConceptos[i][7], dataConceptos[i][8], "", "0", editar, eliminar]).draw();
            }
            eliminaWaitGeneral();
            actualizaTotales();
//          e             
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}
