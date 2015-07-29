var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

$(document).ready(function () {
    
     tablaListado = $('#listadoAp').DataTable({"retrieve": true, "ordering": false, "searching": false, "paging": false, "sPaginationType": "bootstrap", "info": false,
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
            
        }, "drawCallback": function (settings) {
            
        }});
    
    getListadoAp(1, 0);

    $("#FecCre").datepicker({
        format: "yyyy-mm-dd",
        language: "es"
    }).datepicker("setDate", yyyy + "-" + mm + "-" + dd);

    $("#porFecha").click(function () {
        $("#btnGroupDrop1").html('Filtro por: Fecha <span class="caret"></span>');
        $("#filtroFecha").show();
        $("#filtroFolio").hide();
        $("#contDev").hide();
    });
    $("#buscaFecha").click(function () {
        getListadoAp(2, $("#FecCre").val());
    });

    $("#porFolio").click(function () {
        $("#btnGroupDrop1").html('Filtro por: Folio <span class="caret"></span>');
        $("#filtroFecha").hide();
        $("#filtroFolio").show();
        $("#contDev").hide();

    });
    $("#buscaCve").click(function () {
       
        getListadoAp(3, $("#CveAps").val());
    });

    $("#porMes").click(function () {
        $("#btnGroupDrop1").html('Filtro por: &Uacute;ltimo mes <span class="caret"></span>');
        $("#filtroFecha").hide();
        $("#filtroFolio").hide();
       $("#contDev").hide();
        getListadoAp(1, 0);
    });

    $("input[type=text],textarea,select").addClass("form-control input-sm");
    $("#listadoAp_filter,#listadoAp_length").hide();
    
    $("#cerrar").click(function(){$("#contDev").hide()});
});

function getListadoAp(condicion, parametro) {
    $.ajax({
        data: {'accion': 'listadoApGeneral', 'condicion': condicion, 'parametro': parametro},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            tablaListado.clear().draw();
            var data = jQuery.parseJSON(response);
//            console.log(data);
            if (data.length > 0) {
                var cancel = "";
                for (var i = 0; i < data.length; i++) {
                    if (data[i].idEdoAps == "2") {
                        cancel = "<a href='#' title='Ver detalle de la devoluci&oacute;n' onclick='muestraDevolucion("+data[i].idAps+","+data[i].CveAps+");'><img src='contenido_SGI/view/img/warning.png' style='width:15px;'></a>";
                    }else{
                        cancel="";
                    }
                    tablaListado.row.add([data[i].CveAps, data[i].FecCre, data[i].NomEdoAps, cancel]).draw();
                }
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function muestraDevolucion(idAps,Cve){
    $.ajax({
        data: {'accion': 'getDevoluciones', 'idAps': idAps},
        url: 'contenido_SGI/controller/autorizacionPago/funcionesApController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            var newRow = "";
            $("#FolCve").val(Cve);
            $("#OfiDev").val(data[0].OfiDev);
            $("#FecDev").val(data[0].FecDev);
            $("#ObsDev").text(data[0].ObsDev);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
    $("#contDev").show();
}




