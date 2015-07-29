var index = 0;
var vObra = false;
var vRFC = false;
var actualizacion = false;
var aplist = 0;
var relacionExistente = false;
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var arrayEliminados = [];
    var currData = [];
$(document).ready(function () {
    $("input,textarea,select").addClass("form-control input-sm");
 
    tabla = $('#tabla1').DataTable({"retrieve": true, "ordering": true, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
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
        },"fnPreDrawCallback": function(oSettings) {
        /* reset currData before each draw*/
        currData = [];
    },
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        /* push this row of data to currData array*/
        currData.push(aData);

    },
    "fnDrawCallback": function(oSettings) {
        /* can now access sorted data array*/
//        console.log(currData)
    }
    });
    tabla.columns([0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]).visible(false);


    $("#folioAp").change(function () {
        if ($("#folioAp").val() === "") {
            eliminaMensajePop($("#folioAp"));
        } else {
            buscarAp();
        }

    });

    $("#fecEnvio").datepicker({
        format: "dd-mm-yyyy"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#btnEnviar").click(function () {
        //alert('Enviar');        
        guardarDataRel();
    });

    $("#AgregarAp").click(function () {

        var filas = tabla.rows().data().length;
        var band = false;
        if (filas > 0) {
            for (var i = 0; i < filas; i++) {
                if ($("#folioAp").val() === tabla.cell(i, 1).data()) {
                    bootbox.alert("Autorizaci\u00f3n de Pago ya listada");
                    return false;
                } else {
                    band = true;
                }
            }
            if (band) {
                agregarAp();
            }
        } else {
            agregarAp();

        }
    });

    $("#relacion").change(function () {
        obtieneRelacion();
        $("#btnPdf").hide();
    });

    $("#btnPdf").click(function () {
        generaPdf();
//        $("#pdfEnvio").submit();
    });
    cargarCombosRelacion();

});

function cargarCombosRelacion() {
    $.ajax({
        data: {
            accion: 'combosRelacionEnvio'
        },
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            $("#ejercicio").html(data.ejercicio);
            $("#tipoRelacion").html(data.tipRel);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscarAp() {
    var cveAp = $("#folioAp").val();
    $.ajax({
        data: {
            accion: 'buscarApEnvio',
            cveAp: cveAp
        },
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            console.log(data);
            if (data['resultado']) {
                $("#idAps").val(data['info'].idAps);
                $("#CveAps").val(data['info'].CveAps);
                $("#idTipAps").val(data['info'].idTipAps);
                $("#TipoFte").val(data['info'].TipoFte);
                $("#monto").val(data['info'].monto);
                $("#montoAmortizacion").val(data['info'].montoAmortizacion);
                $("#NomUe").val(data['info'].NomUE);
                $("#idUe").val(data['info'].IdUE);
                $("#NomSec").val(data['info'].NomSec);
                $("#idSec").val(data['info'].IdSec);
                $("#NomEmp").val(data['info'].NomEmp);
                $("#EjAp").val(data['info'].Ejercicio);
                eliminaMensajePop($("#folioAp"));
                $("#AgregarAp").show();
            }
            else {
                $("#AgregarAp").hide();
                colocaMensajePop($("#folioAp"), "Error", "Folio no v\u00e1lido", "top");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function obtieneRelacion() {
    var idRel = $("#relacion").val();
    if (idRel.length > 0) {
        $.ajax({
            data: {
                accion: 'obtenerRelacion',
                idRel: idRel
            },
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {

                var data = jQuery.parseJSON(response);
                console.log(data);
                if (data) {
                    relacionExistente = true;
                    $("#folioAp").val('');
                    $("#relacion").val(data[0].idRelAps);
                    $("#ejercicio option[value=" + data[0].Ejercicio + "]").attr("selected", true);
                    $("#fecEnvio").val(data[0].FecEnv);
                    $("#tipoRelacion option[value=" + data[0].idTipRel + "]").attr("selected", true);
                    $("#oficioEnvio").val(data[0].OfiRel);
                    tabla.clear().draw();
//                    var k =3;
                    for (var i = 0; i < data[0].Aps.length; i++) {
//                        if(i == 2||i==4){
//                            k=k-1;
//                        }
                        tabla.row.add([data[0].Aps[i].idAps,
                            data[0].Aps[i].CveAps,
                            data[0].Aps[i].idTipAps,
                            data[0].Aps[i].TipoFte,
                            data[0].Aps[i].monto,
                            data[0].Aps[i].montoAmortizacion,
                            data[0].Aps[i].NomUE,
//                            i,
                            data[0].Aps[i].IdUE,
                            data[0].Aps[i].NomSec,
//                            k,
                            data[0].Aps[i].IdSec,
                            data[0].Aps[i].NomEmp,
                            data[0].Aps[i].Ejercicio,
                            data[0].Aps[i].idRelAps,
                            '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
                    }
                    $("#btnPdf").show();
                    eliminaMensajePop($("#folioAp"));
                }
                else {
                    relacionExistente = false;
                    tabla.clear().draw();
                    bootbox.alert('Relaci\u00f3n inexistente, se crear\u00e1 una nueva relaci\u00f3n al guardar.');
                    $("#relacion").val('');
                    $("#ejercicio option[value=0]").attr("selected", true);
                    $("#fecEnvio").datepicker({
                        format: "dd-mm-yyyy"
                    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);
                    $("#tipoRelacion option[value=0]").attr("selected", true);
                    $("#oficioEnvio").val('DGI/DRCI/DRC');
                    $("#btnPdf").hide();
                }
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }
}

function agregarAp() {
    tabla.row.add([$("#idAps").val(),
        $("#CveAps").val(),
        $("#idTipAps").val(),
        $("#TipoFte").val(),
        $("#monto").val(),
        $("#montoAmortizacion").val(),
        $("#NomUe").val(),
        $("#idUe").val(),
        $("#NomSec").val(),
        $("#idSec").val(),
        $("#NomEmp").val(),
        $("#ejercicio").val(),
        "",
        '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
    $("#folioAp").val('');
    $("#AgregarAp").hide();
    $(".din").each(function () {
        $(this).val('');
    });
    $("#btnPdf").hide();
}

function agregarRelacion() {
    if ($("#ejercicio").val() == 0) {
        alert('Selecciona un ejercicio');
        $("#ejercicio").focus();
        return false
    }
    if ($("#fecEnvio").val().length < 1) {
        alert('Ingesa una fecha de envio');
        $("#fecEnvio").focus();
        return false;
    }
    if ($("#tipoRelacion").val() == 0) {
        alert('Ingresa un tipo de relacion');
        $("#tipoRelacion").focus();
        return false;
    }
    if ($("#oficioEnvio").val().length < 1) {
        alert('Ingresa un Oficio de envio');
        $("#oficioEnvio").focus();
        return false;
    }

    $.ajax({
        data: {
            accion: 'agregarRelacion',
            ejercicio: $("#ejercicio").val(),
            fechaEnvio: $("#fecEnvio").val(),
            tipoRel: $("#tipoRelacion").val(),
            oficio: $("#oficioEnvio").val()
        },
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        async: false,
        success: function (response) {
            var data = jQuery.parseJSON(response);
            //console.log(data);
            if (data.resultado) {
                $("#relacion").val(data.idRelAps);
                $("#relacion").change();
//                alert('se creo el id de relacion ' + data.idRelAps);
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function guardarDataRel() {
    var Items = new Array();
    var filas = tabla.rows().data().length;

    if (filas > 0) {
        for (var i = 0; i < filas; i++) {
            Items.push(tabla.cell(i, 0).data());
        }
        agregarRelacion();
        if ($("#relacion").val().length > 0) {
            $.ajax({
                data: {
                    accion: 'guardarDataRel',
                    relacion: $("#relacion").val(),
                    eliminados: arrayEliminados,
                    items: Items
                },
                url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
                type: 'post',
                async: false,
                success: function (response) {
                    bootbox.alert("Relacion No: " + $("#relacion").val() + " guardada.");
                    $("#btnPdf").show();
//                   
                    //var data = jQuery.parseJSON(response);            

                },
                error: function (response) {
                    console.log("Errores::", response);
                }
            });
        }
    } else {
        bootbox.alert('Ingrese por lo menos una Autorizaci\u00f3n de Pago');
        $("#folioAp").focus();
        return false;
    }
}

function generaPdf() {

    var filas = tabla.rows().data().length;
    tabla.order([9, 'asc'],[7, 'asc']).draw();
//    tabla.column(9).data().sort();
    var arrayDatos = [];
    var datosForm ="";
    for (var i = 0; i < currData.length; i++) {
        arrayDatos.push(currData[i]);
    }
    console.log(arrayDatos);
//    var filas = tabla.rows().data().length;
//    tabla.order([9, 'asc'],[7, 'asc']).draw();
////    tabla.column(9).data().sort();
//    var arrayDatos = [];
//    var datosForm ="";
//    for (var i = 0; i < filas; i++) {
//        arrayDatos.push(tabla.row(i,{order:'current'}).data());
//    }
//    console.log(currData);
    
    for(var i=0;i<arrayDatos.length;i++){
        datosForm += "<input type='text' name='idAps[]' value='"+arrayDatos[i][0]+"'/>\n\
                <input type='text' name='CveAps[]' value='"+arrayDatos[i][1]+"'/>\n\
                <input type='text' name='idTipAps[]' value='"+arrayDatos[i][2]+"'/>\n\
                <input type='text' name='TipoFte[]' value='"+arrayDatos[i][3]+"'/>\n\
                <input type='text' name='monto[]' class='number' value='"+arrayDatos[i][4]+"'/>\n\
                <input type='text' name='montoAmortizacion[]' class='number' value='"+arrayDatos[i][5]+"'/>\n\
                <input type='text' name='NomUe[]' value='"+arrayDatos[i][6]+"'/>\n\
                <input type='text' name='idUe[]' value='"+arrayDatos[i][7]+"'/>\n\
                <input type='text' name='NomSec[]' value='"+arrayDatos[i][8]+"'/>\n\
                <input type='text' name='idSec[]' value='"+arrayDatos[i][9]+"'/>\n\
                <input type='text' name='NomEmp[]'value='"+arrayDatos[i][10]+"'/>\n\
                <input type='text' name='ejercicio[]' value='"+arrayDatos[i][11]+"'/>";
    }
    $("#pdfEnvio").append(datosForm);
//    $(".number").autoNumeric();
    $("#pdfEnvio").append("<input type='text' name='relacion' value='" + $("#relacion").val() + "'/>");
    $("#pdfEnvio").append("<input type='text' name='oficio' value='" + $("#oficioEnvio").val() + "'/>");
    $("#pdfEnvio").append("<input type='text' name='tipoRelacion' value='" + $("#tipoRelacion").val() + "'/>");
    $("#pdfEnvio").submit();
//    
}

function eliminar(elem) {
    var indiceEliminar = tabla.row($(elem).parent().parent()).index();
    if (tabla.cell(indiceEliminar, 12).data() !== "") {
        arrayEliminados.push(tabla.cell(indiceEliminar, 0).data());
    }
    tabla.row(indiceEliminar).remove().draw();
}

function colocaMensajePop(elemento, titulo, mensaje, lugar) {
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