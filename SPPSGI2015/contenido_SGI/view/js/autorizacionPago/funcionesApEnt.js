var index = 0;
var vObra = false;
var vRFC = false;
var actualizacion = false;
var arrayEliminados = [];
var aplist = 0;

$(document).ready(function () {
    $("input,textarea,select").addClass("form-control input-sm");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

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
        }, "fnPreDrawCallback": function (oSettings) {
            /* reset currData before each draw*/
            currData = [];
        },
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            /* push this row of data to currData array*/
            currData.push(aData);

        },
        "fnDrawCallback": function (oSettings) {
            /* can now access sorted data array*/
//        console.log(currData)
        }
    });
    tabla.column(0).visible(false);


    $("#fecEntrega").datepicker({
        format: "dd-mm-yyyy"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#folioAp").change(function () {
        buscaApAceptado();
    });
    $("#btnAgregar").click(function () {
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

    $("#entregarAp").click(function () {
        entregarAps();
    });

});

function agregarAp() {
    tabla.row.add([$("#idAp").val(),
        $("#folioAp").val(),
        $("#fecEntrega").val(),
        '<span  class="glyphicon glyphicon-remove" style="cursor:hand;" onClick="eliminar(this);"></span>']).draw();

    $("#folioAp").val('');
    $("#btnAgregar").hide();
    $("idAp").val('');
}

function entregarAps() {
    var Items = new Array();
    var filas = tabla.rows().data().length;

    if (filas > 0) {
        for (var i = 0; i < filas; i++) {
            Items.push(tabla.row(i).data());
        }
        $.ajax({
            data: {
                accion: 'entregaAps',
                items: Items
            },
            url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
            type: 'post',
            success: function (response) {
                //console.log(response);
                bootbox.alert('Informacion guardada correctamente');
                tabla.clear().draw();
                $("#folioAp").val('');
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    }
}

function buscaApAceptado() {
    var cveAp = $("#folioAp").val();
    var fecEntrega = $("#fecEntrega").val();
    $.ajax({
        data: {
            accion: 'buscarFolioAceptado',
            cveAp: cveAp
        },
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
//            console.log(response);
            var data = jQuery.parseJSON(response);
            if (data['resultado']) {
                $("#btnAgregar").show();
                $("#idAp").val(data['info'].idAps);
            }
            else {
                $("#btnAgregar").hide();
                $("#idAp").val('');
                bootbox.alert('Folio no registrado o no ha sido aceptado.');
                $("#folioAp").val('');
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function eliminar(elem) {
    var indiceEliminar = tabla.row($(elem).parent().parent()).index();
    tabla.row(indiceEliminar).remove().draw();
}

function validarFormatoFecha(campo) {
    var RegExPattern = /^\d{1,2}\-\d{1,2}\-\d{2,4}$/;
    if ((campo.match(RegExPattern)) && (campo != '')) {
        return true;
    } else {
        return false;
    }
}