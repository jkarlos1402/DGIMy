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
            }
        }});
    
    $("#mostrarObras").click(function () {
       colocaWaitGeneral();
       buscarOficios();
    });
    
    $('#fecIni').datepicker({
        language: "es",
        weekStart: 1, format: "yyyy-mm-dd",
        autoclose: true
    });
    
    $('#fecFin').datepicker({
        language: "es",
        weekStart: 1, format: "yyyy-mm-dd",
        autoclose: true
    });
});

function buscarOficios(){
    var fecIni = $("#fecIni").val();
    var fecFin = $("#fecFin").val();
    $.ajax({
        data: {accion: 'getListadoOficios', 'fecIni':fecIni, 'fecFin':fecFin},
        url: "contenido_sgi/controller/oficios/oficiosController.php",
        type: "POST",
        success: function (response) {
            var oficios = $.parseJSON(response);
            tablaOficios.clear().draw();
            for (var i = 0; i < oficios.length; i++) {
                tablaOficios.row.add([oficios[i].CveOfi,oficios[i].NomSolPre,oficios[i].IdSol,oficios[i].Ejercicio,oficios[i].idObr,oficios[i].NomObr,oficios[i].NomEdoOfi,oficios[i].DscFte]).draw();
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}