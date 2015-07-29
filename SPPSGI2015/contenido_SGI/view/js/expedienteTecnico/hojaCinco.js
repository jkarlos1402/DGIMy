
function guardarHoja5() {
    var valorh5 = $("#obsdep").val();
    var idsol = $("#idsol").val();

    var datosH5 = {
        campo: valorh5,
        idsol: idsol,
        accion: 'guardaHoja5'
    };

    $.ajax({
        data: datosH5,
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var dh1 = $.parseJSON(response);
            datosGlobalesSolicitud.idsolicitud = $('#idsol').val();
            datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
//            datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
            eliminaWaitGeneral();
            bootbox.alert('Datos guardados correctamente');
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}