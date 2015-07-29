$(document).ready(function () {


    var uploader = new qq.FileUploader({
        element: document.getElementById('microlocalizacion'),
        action: 'contenido_sgi/libs/fileuploaderServ.php',
        debug: true
    });
// Funcion para las coordenadas
    $('#disponiblesCobertura').multiSelect({
        selectableHeader: '<label class="col-md-12 control-label" style="text-align:left">Disponibles: </label>',
        selectionHeader: '<label class="col-md-12 control-label" style="text-align:left">Seleccionados: </label>'
    });
    $("#coor").change(function () {
        var valor = $('#coor').val();
        if (valor == 2)
        {
            $('#coordenadas').attr('hidden', 'hidden');
            $('#obscoor').attr('readonly', false);
            document.getElementById('label3').innerText = 'Escribir motivo por el cual no se capturan coordenadas';
            $("#lat").val('');
            $("#lat2").val('');
            $("#lon").val('');
            $("#lon2").val('');
        }
        else {
            if (valor == 1) {
                $('#coordenadas').removeAttr('hidden');
                $('#obscoor').attr('readonly', true);
                $("#obscoor").val('');
                document.getElementById('label3').innerText = '';
                initMap();
            } else {
                $('#coordenadas').attr('hidden', 'hidden');
                $('#obscoor').attr('readonly', true);
                $("#obscoor").val('');
                document.getElementById('label3').innerText = '';
                $("#lat").val('');
                $("#lat2").val('');
                $("#lon").val('');
                $("#lon2").val('');
            }
        }
    });

// Funciones para el manejo de una multilista
//    $(".pasarDerecha").click(function () {
//        $('.disponibles option:selected').remove().appendTo('.seleccionados');
//    });
//    $(".pasarIzquierda").click(function () {
//        $('.seleccionados option:selected').remove().appendTo('.disponibles');
//    });

// Funciones peticion tipo de cobertura en form localizacion
    $("#tipoCobertura").change(function () {
        cambioCobertura();
    });

    consultaCoberturas();

    $(".corde").unbind("change").on("change", function () {
        addCoordenadasMap();
    });
});

function consultaCoberturas() {
    $.ajax({
        data: {'accion': 'consultaCoberturas'},
        url: 'contenido_SGI/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
        type: 'post',
        success: function (response) {
            $("#tipoCobertura").html(response);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function cambioCobertura(callback) {
    var tipoCobertura = $('#tipoCobertura').val();
    $.ajax({
        data: {'accion': 'cambioCobertura', 'tipoCobertura': tipoCobertura},
        url: 'contenido_SGI/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
        type: 'post',
        success: function (response) {

            if (response === "vacio" || response == 0 || response == 1) {
                $('#mult1').attr('hidden', 'hidden');
                $('#comloc').attr('hidden', 'hidden');
            } else {
                $('#mult1').removeAttr('hidden');
                $('#disponiblesCobertura').html(response);
                $('#disponiblesCobertura').multiSelect("refresh");
                $('#comloc').removeAttr('hidden');
            }
            if (typeof (callback) !== "undefined") {
                callback();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardarHoja2() {
    if ($("#nbp").val() == "") {
        eliminaWaitGeneral();
//        alert('por favor guarde la Hoja 1 para continuar');
        bootbox.alert('Por favor guarde la Hoja 1 para continuar');
        $("#btnAtras").click();
        return false;
    }

    if (!validaHoja2()) {
        return false;
    }

    $("#accionGuardar").val('guardadoHoja2EstSoc');

    $("#listcob").val($("#disponiblesCobertura").val());
    var valoresh2 = $("#formGral").serialize();

    $.ajax({
        data: valoresh2,
        url: 'contenido_SGI/controller/estudioSocioeconomico/estudioSocioeconomicoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var dh1 = $.parseJSON(response);
            console.log(dh1);
            eliminaWaitGeneral();
            bootbox.alert('Se Completo la informaci\u00F3n No. de Banco:' + datosGlobalesSolicitud.idbco);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function validaHoja2() {
    if ($("#tipoCobertura").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciones un tipo de cobertura');
        $("#tipoCobertura").focus();
        return false;
    }
    if ($("#tipLoc").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciones un tipo de localidad');
        $("#tipLoc").focus();
        return false;
    }
    if ($("#coor").val() == 0) {
        eliminaWaitGeneral();
        bootbox.alert('Selecciona si se requiere coordenadas');
        $("#coor").focus();
        return false;
    }

    if ($("#coor").val() == 1) {
        if ($("#lat").val() == 0 || $("#lat").val() == '') {
            eliminaWaitGeneral();
            bootbox.alert('Ingresa latitud en coordenadas de Inicio');
            $("#lat").focus();
            return false;
        }
        if ($("#lon").val() == 0 || $("#lon").val() == '') {
            eliminaWaitGeneral();
            bootbox.alert('Ingresa longitud en coordenadas de Inicio');
            $("#lon").focus();
            return false;
        }
    }
    return true;

}

function initMap() {
    $("#map").width("700px").height("300px").gmap3({
        map: {
            options: {
                center: [19.354167, -99.630833],
                zoom: 8,
            }
        }
    });
}

function addCoordenadasMap() {
    //pintar Circulo
    var lat1 = $("#lat").val();
    var lon1 = $("#lon").val();
    var lat2 = $("#lat2").val();
    var lon2 = $("#lon2").val();

    if (lat1 != "" && lon1 != "" && (lat2 == "" || lat2 == "0.000000") && (lon2 == "" || lon2 == "0.000000")) {
        console.log("circ");
        $("#map").gmap3({
            clear: ["circulo", "rectangulo"],
            circle: {
                options: {
                    center: [lat1, lon1],
                    radius: 250,
                    fillColor: "#F4AFFF",
                    strokeColor: "#CB53DF",
                    clickable: true
                },
                id: "circulo"},
            map: {
                options: {
                    center: [lat1, lon1],
                    zoom: 12
                }
            }
        });
    }

    if (lat1 != "" && lon1 != "" && (lat2 != "" && lat2 != "0.000000") && (lon2 != "" && lon2 != "0.000000")) {
        console.log("rect");
        $("#map").gmap3({
            clear: ["circulo", "rectangulo"],
            rectangle: {
                options: {
                    bounds: [lat2, lon2, lat1, lon1],
                    fillColor: "#F4AFFF",
                    strokeColor: "#CB53DF",
                    clickable: true
                },
                id: "rectangulo"},
            map: {
                options: {
                    center: [lat2, lon2, lat1, lon1],
                    zoom: 12
                }
            }
        });
    }
//    
}
