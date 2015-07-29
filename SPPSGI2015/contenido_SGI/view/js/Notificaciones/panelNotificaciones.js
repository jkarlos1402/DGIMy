//variables glogables
var tablaNotificaciones;

var opcionesDataTable = {
    retrieve: true,
    searching: false,
    sPaginationType: "bootstrap",
    ordering: false,
    oLanguage: {
        sProcessing: "&nbsp; &nbsp; &nbsp;Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ning&uacute;n dato disponible en esta tabla",
        sInfo: "Mostrando registro(s) del _START_ al _END_ de un total de _TOTAL_ registro(s)",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "Primero",
            sLast: "&Uacute;ltimo",
            sNext: "Siguiente",
            sPrevious: "Anterior"
        },
        oAria: {
            sSortAscending: ": Activar para ordenar la columna de manera ascendente",
            sSortDescending: ": Activar para ordenar la columna de manera descendente"
        }
    }
};

//documento listo
$(document).ready(function () {
    tablaNotificaciones = $("#tablaNotificaciones").DataTable(opcionesDataTable);
    cargaNotificaciones($("#idUsuarioSession").val());
    $("#btnRefrescarNotificaciones").unbind("click").on("click", function () {
        cargaNotificaciones($("#idUsuarioSession").val());
    });
});

// funciones
function cargaNotificaciones(idUsu) {
    colocaWaitGeneral();
    tablaNotificaciones.clear();
    $.post("contenido_sgi/controller/notificaciones/notificacionesController.php", {accion: "getNotificaciones", idUsu: idUsu}, function (resp) {
        var notificaciones = $.parseJSON(resp);
        for (var i = 0; i < notificaciones.length; i++) {
            tablaNotificaciones.row.add([
                notificaciones[i].fechaNotificacion,
                notificaciones[i].mensaje,
                notificaciones[i].vigencia,
                notificaciones[i].accion
            ]);
        }
        tablaNotificaciones.draw();
        eliminaWaitGeneral();
    });
}

function colocaWaitGeneral() {
    var divWait = $('<div id="pleaseWaitSGI" class="modal-backdrop fade in"></div><div class="progress modal-dialog" id="progressWait" style="z-index: 99999;height: 40px;"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><p style="height: 40px;display: table;width: 100%;"><span style="display: table-cell;vertical-align: middle;font-size:18px;">Cargando informaci\u00f3n necesaria...</span></p></div></div>').appendTo('body');
    divWait.show();
}

function eliminaWaitGeneral() {
    $("#pleaseWaitSGI").remove();
    $("#progressWait").remove();
}

function colocaMensajeInfGeneral(mensaje) {
    if (!$("#mensajeGeneralSGI").attr("id")) {
        var divWait = $('<div id="mensajeGeneralSGI" class="alert alert-success" role="alert" style="padding: 5px;position: fixed; bottom:50px; left: 15px; display:none;">' + mensaje + '</div>').appendTo('body');
        divWait.show(800, "swing");
    }
}

function eliminaMensajeInfGeneral() {
    $("#mensajeGeneralSGI").hide(800, function () {
        $("#mensajeGeneralSGI").remove();
    });
}

function cambiaEstatusNotificacion(elem, idNotificacion) {
    var estatus = "false";
    if ($(elem).prop("checked")) {
        estatus = "true";
    }
    $.ajax({        
        url: 'http://192.168.20.7:8082/SGIApp-war/serv/notificacion/setNotification',
        data: {
            idNotificacion: idNotificacion,
            estatus: estatus
        },
        type: 'POST',
        crossDomain: true,
        success: function (data, textStatus, jqXHR) {            
            colocaMensajeInfGeneral(data.respuesta);
            setTimeout(function () {
                eliminaMensajeInfGeneral();
            }, 3000);
        }, error: function (jqXHR, textStatus, errorThrown) {
            colocaMensajeInfGeneral("Hubo un error con el sistema de notificaciones, contacta al administrador");
            setTimeout(function () {
                eliminaMensajeInfGeneral();
            }, 3000);
        }
    });
}

