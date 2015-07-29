$(document).ready(function () {

//    $("#lat,#lon").autoNumeric({vMin: '-100.7999999', vMax: '18.4999999'});
//    $("#lat2,#lon2").autoNumeric({vMin: '-98.6999999', vMax: '20.39999999'});

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
        if (valor == 2) {
            $('#coordenadas').attr('hidden', 'hidden');
            $('#obscoor').attr('readonly', false);
            $('#obscoor').addClass('obligatorioHoja2');
            document.getElementById('label3').innerText = 'Escribir motivo por el cual no se capturan coordenadas';
            $("#lat").val('');
            $("#lat2").val('');
            $("#lon").val('');
            $("#lon2").val('');
            $('#lat').removeClass('obligatorioHoja2');
            $('#lon').removeClass('obligatorioHoja2');
        } else {
            $('#obscoor').removeClass('obligatorioHoja2');
            if (valor == 1) {
                $('#coordenadas').removeAttr('hidden');
                initMap();
                $('#obscoor').attr('readonly', true);
                $("#obscoor").val('');
                $('#lat').addClass('obligatorioHoja2');
                $('#lon').addClass('obligatorioHoja2');
                document.getElementById('label3').innerText = '';
            } else {
                $('#coordenadas').attr('hidden', 'hidden');
                $('#obscoor').attr('readonly', true);
                $("#obscoor").val('');
                document.getElementById('label3').innerText = '';
                $("#lat").val('');
                $("#lat2").val('');
                $("#lon").val('');
                $("#lon2").val('');
                $('#lat').removeClass('obligatorioHoja2');
                $('#lon').removeClass('obligatorioHoja2');
            }
        }
    });

    $(".corde").unbind("change").on("change", function () {
        addCoordenadasMap();
    });

// Funciones peticion tipo de cobertura en form localizacion
    $("#tipoCobertura").change(function () {
        cambioCobertura();
    });

    llenarCombos();
});

function llenarCombos() {
    $.ajax({
        data: {'accion': 'llenarCombos'},
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
        type: 'post',
        success: function (response) {
            var dh2 = $.parseJSON(response);
            $("#tipoCobertura").html(dh2.cobertura);
            $('#tipLoc').html(dh2.tiploc);
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
        url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
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
    //$("#listcob").val($("#disponiblesCobertura").val());
    var valoresh2 = $("#formGral").serialize();

    if ($("#formGral").find(".obligatorioHoja2:visible").valid()) {
        $.ajax({
            data: valoresh2,
            url: 'contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php',
            type: 'post',
            success: function (response) {
                console.log(response);
                var dh1 = $.parseJSON(response);
                datosGlobalesSolicitud.idsolicitud = $('#idsol').val();
                datosGlobalesSolicitud.tiposolicitud = $("#solpre").val();
                //datosGlobalesSolicitud.psolicitud = $("#formGral").serialize();
                eliminaWaitGeneral();
                bootbox.alert('Datos guardados correctamente');
            },
            error: function (response) {
                console.log("Errores::", response);
            }
        });
    } else {
        $("#formGral").find("[aria-invalid='true']:first").focus().each(function () {
            eliminaWaitGeneral();
            bootbox.alert('Favor de llenar los campos obligatorios');
        });
    }
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

jQuery.validator.addClassRules("obligatorioHoja2", {
    required: true
});