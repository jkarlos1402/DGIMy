var index = 0;
var vObra = false;
var vRFC = false;
var actualizacion = false;
var area;
$(document).ready(function () {
    $("input,textarea,select").addClass("form-control input-sm");

    tablaRelacion = $('#tablaAp').DataTable({"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
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
            }}});
    tablaRelacion.column(4).visible(false);

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    cargarAreas();
    cargarTurnos();

    $("#iFolio").change(function () {
        buscarFolio();
    });
    $("#fIngreso,#fTurnada").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

//    $("#tablaAp").tablesorter();
//    $("#btnIngresar").click(function () {
//        if (validarDatos()) {
//            agregaPa();
//            $("#iFolio,#sObservaciones,#sEmpresa,#idEmpresa,#iRfc,#iObra,#idObra").val("");
//            $("#sPeriodo").find('option').remove();
//            vRFC = false;
//
//
//        }
//    });

    $("#btnIngresar").unbind("click").click(function () {
        var filas = tablaRelacion.rows().data().length;
        var band = false;
        if (filas > 0) {
            for (var i = 0; i < filas; i++) {
                if ($("#idAps").val() === tablaRelacion.cell(i, 0).data()) {
                    bootbox.alert("Autorizaci\u00f3n de Pago ya listada");
                    return false;
                } else {
                    band = true;
                }
            }
            if (band) {
                agregaPa();
            }
        } else {
            agregaPa();

        }

    });

    $("#sPeriodo").unbind("change").on("change", function () {
        buscarIdObra();
    });
    $("#iObra").focusout(function () {
        buscaObra($(this).val())
    });
    $("#iRfc").focusout(function () {
        buscaRfc($(this).val())
    });
    $("#btnQuitar").click(function () {
        var aCheck = new Array();
        $(".check").each(function () {
            if (this.checked) {
                aCheck.push($(this).parent().parent().attr("id"));
            }
        });
        quitarPa(aCheck);
    });
    $("#btnNinguno").click(function () {
        $(".check").each(function () {
            $(this).attr("checked", false);
        });
    });
    $("#btnTodos").click(function () {
        $(".check").each(function () {
            $(this).attr("checked", true);
        });
    });
    $("#btnTurnar").click(function () {
        if ($("#sArea").val() != "-1") {
            turnarAp();
        } else {
            alert("Por favor seleccione un area");
        }
    });
    $("#iFolio").focus();
});

function buscarFolio() {

    var CveAps = $("#iFolio").val();
    $.ajax({
        data: {'accion': 'buscarFolio', 'CveAps': CveAps},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            if (response != "false") {
                var data = jQuery.parseJSON(response);

                if (data[0].idEdoAps !== "5" && data[0].idEdoAps !== "3") { // VERIFICAR QUE EL ESTADO SEA INGRESADO O EN PROCESO
                    $("#dialogAvisos").modal();
                    $("#msgAviso").html("El folio de la Autorizaci\u00f3n de Pago no v\u00e1lido.");
                    $('#dialogAvisos').on('hidden.bs.modal', function () {
                        $("#iFolio").focus();
                    });
                    return false;
                }
                $("#sEstado").val(data[0].NomEdoAps);
                $("#sPeriodo option[value=" + data[0].ejercicio + "]").attr("selected", true);
                $("#sPeriodo").unbind("change").on("change", function () {
                    buscarIdObra();
                });
                $("#sObservaciones").val(data[0].ObsAps);
                $("#idEmp").val(data[0].idEmp);
                $("#iRfc").val(data[0].RfcEmp);
                $("#sEmpresa").val(data[0].NomEmp);
                vRFC = true;
                $('#nomUE').val(data[0].NomUE);
                $('#idAps').val(data[0].idAps);
                $("#btnIngresar").show();
                area = data[0].idDir;
            } else {
                $("#dialogAvisos").modal();
                $("#msgAviso").html("El folio de la Autorizaci\u00f3n de Pago no v\u00e1lido.");
                $('#dialogAvisos').on('hidden.bs.modal', function () {
                    $("#sEstado").val("");

                    $("#sObservaciones").val("");
                    $("#idEmp").val("");
                    $("#iRfc").val("");
                    $("#sEmpresa").val("");
                    vRFC = true;
                    $('#nomUE').val("");
                    $('#idAps').val("");
                    $("#btnIngresar").show();
                    $("#btnIngresar").hide();
                    $("#iFolio").focus();
                });

                return false;
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscaObra(idObra) {
    $.ajax({
        data: {'accion': 'consultaObras', 'idObra': idObra},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            if (data.periodo) {
//                console.log(response);
                $("#sPeriodo").append(data.periodo);
                buscarIdObra();


            } else {
                alert("No existe la obra seleccionada");
                $("#iObra").focus();

            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscarIdObra() {
    var idObra = $("#iObra").val();
    var periodo = $("#sPeriodo").val();
    $.ajax({
        data: {'accion': 'getObraById', 'idObra': idObra, 'periodo': periodo},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            //console.log(response);
            $("#idObra").val(response);

            //var data = jQuery.parseJSON(response);

        },
        error: function (response) {
            console.log("Errores::", response);

        }
    });
    return true;
}

function buscaRfc(RfcEmp) {
    $.ajax({
        data: {'accion': 'consultaEmpresa', 'RfcEmp': RfcEmp},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            if (data.NomEmp) {
                $("#sEmpresa").val(data.NomEmp);
                $("#idEmp").val(data.idEmp);

                vRFC = true;
            } else {
                alert("No existe el RFC seleccionado");
                $("#iRfc").focus();
                vRFC = false;
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}
function cargarAreas() {

    $.ajax({
        data: {'accion': 'consultaArea'},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
//           alert(response);
//            var data = jQuery.parseJSON(response);
            $("#sArea").append(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function cargarTurnos() {
    $.ajax({
        data: {'accion': 'consultaTurnos'},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
//            var data = jQuery.parseJSON(response);
            $("#iTurno").val(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}


function agregaPa() {
    if ($("#sArea").val() != "-1") {
        if (area != $("#sArea").val()) {
            alert("Se ha ingresado una A.P. de otra \u00e1rea");
            return false;
        } else {
            var iFolio = $("#iFolio").val();
            var idAps = $("#idAps").val();
            var sEstado = $("#sEstado").val();
            var sObservaciones = $("#sObservaciones").val();
            var fIngreso = $("#fIngreso").val();
            var iTurno = $("#iTurno").val();
            var idObra = $("#idObra").val();
            var iEmpresa = $("#idEmp").val();
            var ue = $("#nomUE").val();
            tablaRelacion.row.add([idAps, iFolio, fIngreso, iTurno, sObservaciones, ue, '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
            $("#btnIngresar").hide();
            $("#iFolio,#sObservaciones").val("");
            $("#sArea").val(area);
        }
    } else {
        var iFolio = $("#iFolio").val();
        var idAps = $("#idAps").val();
        var sEstado = $("#sEstado").val();
        var sObservaciones = $("#sObservaciones").val();
        var fIngreso = $("#fIngreso").val();
        var iTurno = $("#iTurno").val();
        var idObra = $("#idObra").val();
        var iEmpresa = $("#idEmp").val();
        var ue = $("#nomUE").val();
        tablaRelacion.row.add([idAps, iFolio, fIngreso, iTurno, sObservaciones, ue, '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
        $("#btnIngresar").hide();
        $("#iFolio,#sObservaciones").val("");
        $("#sArea").val(area);
    }


}

function eliminar(elem) {
    var indiceEliminar = tablaRelacion.row($(elem).parent().parent()).index();
    tablaRelacion.row(indiceEliminar).remove().draw();
}

function turnarAp() {
    var datos = new Array();
    var aps = tablaRelacion.rows().data();
    for (var i = 0; i < aps.length; i++) {
        datos.push(aps[i]);
    }
    if (datos.length == 0) {
        alert("Ingrese AP");
        return false;
    }
    else {

        var area = $("#sArea").val();
        $.ajax({
            data: {'accion': 'ingresaAp', 'aps': datos, 'area': area},
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {
//                console.log(response);
                if (response) {
                    var nombreArea = $("#sArea option:selected").text();
                    $("#Turno").val($("#iTurno").val());
                    $("#area").val(nombreArea);
                    $("#fechaTurno").val($("#fTurnada").val());
                    for (var i = 0; i < datos.length; i++) {
                        var camposFolios = "<input class='dinamic' name='CveAps[]' value='" + datos[i][1] + "' type='text'/>";
                        $("#imprime").append(camposFolios);
                    }
                    $("#imprime").submit();
                    $("#imprime").find('.dinamic').each(function () {
                        $(this).remove();
                    });
                    tablaRelacion.clear().draw();
                    $("#iFolio,#sObservaciones").val("");
                    $("#btnIngresar").hide();
                    cargarTurnos();
                    $("#sArea").val("-1");
                } else {
                    bootbox.alert("Error");
                }
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }

}

function validarDatos() {
    if ($("#iFolio").val() == "") {
        alert("No ha ingresado folio");
        $("#iFolio").focus();
        return false;
    } else if (!vRFC) {
        alert("No ha ingresado beneficiario");
        $("#iRfc").focus();
        return false;
    } else {
        return true;
    }
}
