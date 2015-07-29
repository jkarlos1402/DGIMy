$(document).ready(function () {
    colocaWaitGeneral();
    tablaNormatividad = $('#tablaNormatividad').DataTable({"retrieve": true, "ordering": true, "sPaginationType": "bootstrap",
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
    buscarNormas();
});

function buscarNormas() {
    $.ajax({
        data: {accion: 'consultasNormas'},
        url: "contenido_SGI/controller/normatividad/normatividadController.php",
        type: "POST",
        success: function (response) {
            var norma = $.parseJSON(response);
            tablaNormatividad.clear().draw();
            var guardar = "";
            var ruta = "";
            for (var i = 0; i < norma.length; i++) {
                ruta = "contenido_SGI/uploads/"+norma[i].Archivo;
                guardar = "<a href='"+ruta+"' target='blank'><span style='cursor:pointer;' class='fa fa-file-pdf-o'></span></a>";
                tablaNormatividad.row.add([norma[i].Nombre,norma[i].Descripcion,guardar]).draw();
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function colocaWaitGeneral() {
    var divWait = $('<div id="pleaseWaitSGI" class="modal-backdrop fade in"></div><div class="progress modal-dialog" id="progressWait" style="z-index: 99999;height: 40px;"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><p style="height: 40px;display: table;width: 100%;"><span style="display: table-cell;vertical-align: middle;font-size:18px;">Cargando informaci\u00f3n necesaria...</span></p></div></div>').appendTo('body');
    divWait.show();
}