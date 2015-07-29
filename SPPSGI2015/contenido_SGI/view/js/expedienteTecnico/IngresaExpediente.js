var index = 0;
var vsol = false;
var actualizacion = false;
var area;
var obj = new Array();
$(document).ready(function () {

    tablaRelacion = $('#tablaEx').DataTable({"paging": false,
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
            }
        }});
    tablaRelacion.column(4).visible(false);
    tablaRelacion.column(5).visible(false);

    $("input,textarea,select").addClass("form-control input-sm");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    cargarAreas();
    cargarTurnos();

    $("#ieFolio").change(function () {
        buscarFolio();
    });

    $("#feIngreso,#feTurnada").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

//    $("#tablaAp").tablesorter();
    $("#btneIngresar").click(function () {
        var filas = tablaRelacion.rows().data().length;

        if (filas > 0) {
            for (var i = 0; i < filas; i++) {
                console.log(tablaRelacion.cell(i, 0).data());
                if ($("#ieFolio").val() === tablaRelacion.cell(i, 0).data()) {
                    bootbox.alert("Solicitud ya listada");
                    return false;
                } else {
                    agregaPa();
                    //cargarDatos();
                    $("#idSolexp").val($("#idSolexp").val() + "." + $("#ieFolio").val());
                    $("#nomUEexp").val($("#nomUEexp").val() + ".");
                    $("#nomSolPreexp").val($("#nomSolPreexp").val() + ".");

                    $("#ieFolio,#seObservaciones").val("");
                    $("#sPeriodo").find('option').remove();
                    return false;
                }
            }
        } else {
            agregaPa();
            //cargarDatos();
            $("#idSolexp").val($("#idSolexp").val() + "." + $("#ieFolio").val());
            $("#nomUEexp").val($("#nomUEexp").val() + ".");
            $("#nomSolPreexp").val($("#nomSolPreexp").val() + ".");
            $("#ieFolio,#seObservaciones").val("");
            $("#sPeriodo").find('option').remove();

        }

    });




    $("#sePeriodo").unbind("change").on("change", function () {
        buscarIdsol();
    });
//    $("#iObra").focusout(function () {
//        buscaObra($(this).val())
//    });
//    $("#iRfc").focusout(function () {
//        buscaRfc($(this).val())
//    });

    $("#btneTurnar").click(function () {
        if ($("#seArea").val() != "-1") {
            turnarExp();
        } else {
            alert("Por favor seleccione un area");
        }
    });
    $("#ieFolio").focus();
});


function buscarFolio() {
    var idsol = $("#ieFolio").val();
    $.ajax({
        data: {'accion': 'getExpTById', 'idsol': idsol},
        url: 'contenido_SGI/controller/ExpedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {

            var data = jQuery.parseJSON(response);
//            console.log(data);
            if (data.length == 0) {
                $("#dialogAvisos").modal();
                $("#msgAviso").html("Folio de Expediente no v\u00e1lido.");
                $('#dialogAvisos').on('hidden.bs.modal', function () {
                    $("#ieFolio").val('').focus();
                });
                return false;
            } else {
                $('#idSolexp').val(data[0].idSol);
                $('#nomUEexp').val(data[0].nomUe);
                $('#nomSolPreexp').val(data[0].nomSolPre);
                //$('#obj').val(obj);
                area = data[0].idDir;
                $("#btneIngresar").show();

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
        url: 'contenido_SGI/controller/ExpedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
//           alert(response);
//            var data = jQuery.parseJSON(response);

//            $("#seArea").val(response);
            $("#seArea").append(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}



function cargarTurnos() {
    $.ajax({
        data: {'accion': 'consultaTurnos'},
        url: 'contenido_SGI/controller/ExpedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
//            var data = jQuery.parseJSON(response);
            $("#ieTurno").val(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}


function agregaPa() {
    if ($("#seArea").val() != "-1")
    {
        if (area != $("#seArea").val()) {
            alert("Se ha ingresado un Expediente de otra Area");
            return false;
        } else {
//            var ieFolio  = $("#ieFolio").val();
            var ieFolio = $("#ieFolio").val();
            var seObservaciones = $("#seObservaciones").val();
            var feIngreso = $("#feIngreso").val();
            var ieTurno = $("#ieTurno").val();
            var uE = $("#nomUEexp").val();
            var solPre = $("#nomSolPreexp").val();
//        var idObra = $("#idObra").val();
//        var ieEmpresa = $("#idEmp").val();
            tablaRelacion.row.add([ieFolio, feIngreso, ieTurno, seObservaciones, uE, solPre, '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
            $("#btneIngresar").hide();
            $("#seArea").val(area).attr("disabled", "true");
        }
    } else {

        var ieFolio = $("#ieFolio").val();
        var seObservaciones = $("#seObservaciones").val();
        var feIngreso = $("#feIngreso").val();
        var ieTurno = $("#ieTurno").val();
        var uE = $("#nomUEexp").val();
        var solPre = $("#nomSolPreexp").val();
//        var idObra = $("#idObra").val();
//        var ieEmpresa = $("#idEmp").val();
        tablaRelacion.row.add([ieFolio, feIngreso, ieTurno, seObservaciones, uE, solPre, '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();
        $("#btneIngresar").hide();
        $("#seArea").val(area).attr("disabled", "true");
        $("#btneIngresar").hide();
    }


}

function eliminar(elem) {
    var indiceEliminar = tablaRelacion.row($(elem).parent().parent()).index();
    tablaRelacion.row(indiceEliminar).remove().draw();
}

function turnarExp() {
//    var indiceEx;
    var datos = new Array();
    var expedientes = tablaRelacion.rows().data();
    for (var i = 0; i < expedientes.length; i++) {
        datos.push(expedientes[i]);
    }
    if (datos.length == 0) {
        alert("Ingrese Expediente");
        return false;
    }
    else {
        var area = $("#seArea").val();
//        console.log(datos);
//        return false;
        $.ajax({
            data: {'accion': 'cabiarEstatusET', 'idSol': datos, 'estado': 4, 'turno': $("#ieTurno").val()},
            url: 'contenido_SGI/controller/ExpedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
//                console.log("datos");
//                console.log(datos);
                var idsSolNot = "";
                if (response) {
                    var nombreArea = $("#seArea option:selected").text();
                    console.log(datos);
                    $("#Turno").val($("#ieTurno").val());
                    $("#area").val(nombreArea);
                    $("#fechaTurno").val($("#feTurnada").val());
                    for (var i = 0; i < datos.length; i++) {
                        idsSolNot += "," + datos[i][0];
                        var camposExpediente = "<input name='idSol[]' value='" + datos[i][0] + "' type='hidden'/>" +
                                "<input name='ue[]' value='" + datos[i][4] + "' type='hidden'/>" +
                                "<input name='tipo[]' value='" + datos[i][5] + "' type='hidden'/>";
                        $("#imprime").append(camposExpediente);
                    }
                    $("#imprime").submit();
                }
                idsSolNot = idsSolNot.replace(",","");                
                sendNotification(idsSolNot, $("#idUsuarioSession").val(), "4", "", $("#idRolUsuarioSession").val(), "", "", "");
                bootbox.alert("Solicitud Ingresada", function () {
                    location.reload();
                });
            }
            ,
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }
}


function validarDatos() {
    if ($("#ieFolio").val() == "") {
        alert("No ha ingresado folio");
        $("#ieFolio").focus();
        return false;
    } else {
        return true;
    }
}

