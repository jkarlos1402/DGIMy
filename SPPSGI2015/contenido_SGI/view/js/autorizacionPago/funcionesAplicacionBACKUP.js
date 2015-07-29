var FecRec;
var idDetObr;
var idAps;
var indice = 0;
var ivaAmorticacion;
var detalle = false;
var none = false;
var consulta = false;
var PrmMod = 0;
var estadoAp;
var apBorradas = new Array();
var ivaAp;
var e, f, c, d, a = false;

$(document).ready(function () {
    $("input[type=text],textarea,select").addClass("form-control input-sm");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    $(".number").autoNumeric({vMin: '-99999999999999999999999.00', vMax: '99999999999999999999999.00'});
    getTipoAp();
    //getFolioAp();
    $("#apRegistrada").click(function () {
        if ($("#apRegistrada").prop("checked")) {
            $("#apF").show();
        }else{
            $("#apF").hide();
        }
    });
    $("#folioAp").on('change', (function () {
        getApById();
        $("#folioAp").attr("readonly", "true");
    }));

    $("#fecDev").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);

    $("#obraAp").on('change', function () {
        getObraById();
    })
    $("#movimientoAp").change(function () {
        despliegaTabla();
        $("#disponibleAp").val("");
    });
    $("#ejercidoAp").change(function () {
        validarEjercido();
    });
    $("#btnAgregar").click(function () {
        agregarMovimientos();
    });
    $("#btnTodos").click(function () {
        seleccionaTodos();
    });
    $("#btnNinguno").click(function () {
        deseleccionaTodos();
    });
    $("#btnQuitar").click(function () {
        quitarSeleccionados();
    });
    $("#btnReload").click(function () {
        if (confirm(" \u00BFDesea cambiar de AP?"))
            location.reload();
    });
    $("#btnGuardar").click(function () {
        guardarAp();
    });
    $("#error").click(function () {
        e = true
    });
    $("#finiquito").click(function () {
        f = true
    });
    $("#cp").click(function () {
        c = true
    });
    $("#desafect").click(function () {
        d = true
    });
    $("#afect").click(function () {
        a = true
    });
    $("#btnDevolucion").click(function () {
        buscarDevoluciones();
        $("#dialogDevolucion").modal();
    });
    $("#btnGuardarDevolucion").click(function () {

        guardarDevolucion();
    });


});

//function getFolioAp() { //DEFINE EL FOLIO PARA LA NUEVA AP
//    $.ajax({
//        data: {'accion': 'getFolio'},
//        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
//        type: 'post',
//        success: function (response) {
//            console.log(response);
//            $("#folioAp").val(response);
//        },
//        error: function (response) {
//            console.log("Errores::", response);
//        }
//    });
//}
function getApById() {

    var CveAps = $("#folioAp").val();
    $.ajax({
        data: {'accion': 'buscarFolioAplicacion', 'CveAps': CveAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            if (data.length > 0) {
                $("#movimientos").show();
                idAps = data[0].idAps;
                $("#estadoAp").val(data[0].NomEdoAps);
                $("#fecRecAp").val(data[0].FecRec);
                $("#fecEnvAp").val(data[0].FecEnv);
                $("#beneficiarioAp").val(data[0].NomEmp);
                $("#rfcAp").val(data[0].RfcEmp);
                $("#idEmpAp").val(data[0].idEmp);
                $("#observacionesAp").val(data[0].ObsAps);
                $("#ejecutoraAp").val(data[0].NomUE);
                FecRec = data[0].FecRec;
                idDetObr = data[0].idDetObr;
                PrmMod = data[0].PrmMod;
                estadoAp = data[0].idEdoAps;
                ivaAp = data[0].Iva;
                if (data[0].AutPagCP == "1")
                    $("#cpAp").prop("checked", true);
                if (data[0].Error == "1")
                    $("#errorAp").prop("checked", true);
                if (data[0].Finiquito == "1")
                    $("#finiquitoAp").prop("checked", true);
                if (data[0].DesAfe == "1")
                    $("#desafectacionAp").prop("checked", true);
                if (data[0].SolAfe == "1")
                    $("#soloAp").prop("checked", true);

                $("#rfcAp").on('change', function () {
                    buscaRfc($(this).val())
                });
                $.ajax({
                    data: {'accion': 'getMovimientos', 'idAps': idAps},
                    url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
                    type: 'post',
                    success: function (response) {
                        console.log(response);
                        var data = jQuery.parseJSON(response);
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var newRow = "<tr id=" + indice + " onClick='seleccionaMov(this);'>\n\
                                            <td>" + data[i].ejercicio + "<input type='text' id=tapejercicio" + indice + " value='" + data[i].ejercicio + "' style='display:none;'></td>\n\
                                            <td>" + data[i].idObr + "<input type='text' id=tapobra" + indice + " value='" + data[i].idObr + "' style='display:none;'><input type='text' id=tapidModEje" + indice + " value='" + data[i].idModEje + "' style='display:none;'></td>\n\
                                            <td>" + data[i].nomTipAps + "<input type='text' id=tapidTipMov" + indice + " class='tipoMovimiento' value=" + data[i].idTipAps + " style='display:none;'></td>\n\
                                            <td>" + data[i].CveOfi + "<input type='text' id=tapidDetOfi" + indice + " value=" + data[i].idDetOfi + " style='display:none;'></td>\n\
                                            <td>" + data[i].idRef + "<input type='text' id=tapidRef" + indice + " value=" + data[i].idRef + " style='display:none;'></td>\n\
                                            <td>" + data[i].NomFte + "<input type='text' id=tapidFte" + indice + " value='" + data[i].idFte + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomInv + "<input type='text' id=tapidInv" + indice + " value='" + data[i].idInv + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomRec + "<input type='text' id=tapidRec" + indice + " value='" + data[i].idRec + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].monto + "<input type='text' id=tapafectacion" + indice + " value=" + data[i].monto + " style='display:none;'><input type='text' id=idDetAps" + indice + " value=" + data[i].idDetAps + " style='display:none;'></td>\n\\n\
                                        </tr>";
                                $("#tablaAp tbody").append(newRow);
                                $("#tablaAp").trigger("update");

                                indice++;

                            }
                            $("#obraAp").val(data[0].idObr);
                            $("#idDetObrAp").val(data[0].idDetObr);
                            $("#nombreobraAp").val(data[0].NomObr);
                            $("#sectorAp").val(data[0].NomSec);
                            $("#icicAp").val(data[0].RetCicem);

                            $("#cmicAp").val(data[0].RetCnic);

                            $("#supervisionAp").val(data[0].RetSup);

                            $("#isptAp").val(data[0].RetIspt);

                            $("#otroAp").val(data[0].RetOtr);
                            $("#ivaAp").val(data[0].iva);

                            consulta = true;
                            detalle = true;
                            calcularAP();
                            $("#movimientoAp").val("6");
                            $("#movimientoAp").trigger("change");

                            //
                        }
                    },
                    error: function (response) {
                        console.log("Errores::", response);
                    }
                });

            } else {
                alert("No existe ese folio de AP registrado");
                $("#folioAp").removeAttr("readonly").focus();
                $("#movimientos").hide();
                idAps = null;
                $("#estadoAp").val('');
                $("#fecRecAp").val('');
                $("#fecEnvAp").val('');
                $("#beneficiarioAp").val('');
                $("#observacionesAp").val('');
                $("#ejecutoraAp").val('');
                $("#obraAp").val('');
                $("#nombreobraAp").val('');
                $("#sectorAp").val('');
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscaRfc(RfcEmp) {
    $.ajax({
        data: {'accion': 'consultaEmpresa', 'RfcEmp': RfcEmp},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            var data = jQuery.parseJSON(response);
            if (data.NomEmp) {
                $("#beneficiarioAp").val(data.NomEmp);
                $("#idEmpAp").val(data.idEmp);


            } else {
                alert("No existe el RFC seleccionado");
                $("#idEmpAp,#beneficiarioAp").val('');
                $("#rfcAp").focus();

            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function getObraById() {
    var idObr = $("#obraAp").val();
    $.ajax({
        data: {'accion': 'getObraAplicacion', 'idObra': idObr},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log("Obra::" + response);
            var data = jQuery.parseJSON(response);
            if (data.length > 0) {
                $("#ejecutoraAp").val(data[0].NomUE);
                $("#idDetObrAp").val(data[0].idDetObr);
                $("#nombreobraAp").val(data[0].NomObr);
                $("#sectorAp").val(data[0].NomSec);
            } else {
                alert("No existe la obra seleccionada");
                $("#obraAp").focus();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function getTipoAp() {
    $.ajax({
        data: {'accion': 'getTipoAp'},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            $("#movimientoAp").append(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function despliegaTabla() {
    if ($("#movimientoAp").val() == "1" || $("#movimientoAp").val() == "3" || $("#movimientoAp").val() == "5") {

        if ($("#movimientoAp").val() == "1") {
            ivaAmorticacion = true;
            $("#ivaDiv,#ivaAmortizacion").show();
        } else {
            ivaAmorticacion = false;
            $("#ivaDiv,#ivaAmortizacion").hide();
        }

        $("#tabla1").show();
        $("#tabla2").hide();
        $("#tabla1 tbody").find("tr").remove();
        $("#tabla1").trigger("update");
        buscaOficiosAp();
    } else {
        ivaAmorticacion = false;
        $("#ivaDiv,#ivaAmortizacion").hide();
        $("#tabla1").hide();
        $("#tabla2").show();
        $("#tabla2 tbody").find("tr").remove();
        $("#tabla2").trigger("update");
        buscaOficios();

    }
}

function buscaOficios() {

    $.ajax({
        data: {'accion': 'getOficios', 'idDetObr': $("#idDetObrAp").val()/*$("#obraAp").val()*/},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log("Oficios::" + response);
            var data = jQuery.parseJSON(response);
            var newRow = "";

            for (var i = 0; i < data.length; i++) {
                newRow += "<tr id=" + i + " onClick='seleccionaOficio(this);'>\n\
                            <td>" + data[i].Ejercicio + "<input type='text' id=ejercicio" + i + " value=" + data[i].Ejercicio + " style='display:none;'><input type='text' id=idModEje" + i + " value=" + data[i].idModEje + " style='display:none;'></td>\n\
                            <td id=of" + i + ">" + data[i].CveOfi + "<input type='text' id=idDetOfi" + i + " value=" + data[i].idDetOfi + " style='display:none;'><input type='text' id=idRef" + i + " value=" + data[i].idRef + " style='display:none;'></td>\n\
                            <td>" + data[i].NomTipOfi + "<input type='text' id=idTipOfi" + i + " value=" + data[i].idTipOfi + " style='display:none;'></td>\n\
                            <td>" + data[i].FecFir + "</td>\n\
                            <td id=fte" + i + ">" + data[i].NomFte + "<input type='text' id=idFte" + i + " value=" + data[i].idFte + " style='display:none;'></td>\n\
                            <td id=inv" + i + ">" + data[i].NomInv + "<input type='text' id=idInv" + i + " value=" + data[i].idInv + " style='display:none;'></td>\n\
                            <td id=rec" + i + ">" + data[i].NomRec + "<input type='text' id=idRec" + i + " value=" + data[i].idRec + " style='display:none;'></td>\n\
                            <td>" + data[i].MonAut + "</td>\n\
                        </tr>";

            }
            $("#tabla2 tbody").append(newRow);
            $("#tabla2").trigger("update");

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function seleccionaOficio(id) {
    $("#tabla2").find(".bg-success").removeClass("bg-success");
    $(id).addClass("bg-success");
    $("#ejercidoAp").prop("readonly", false);
    var index = $(id).attr("id");
    var idOficioActual = $("#idDetOfi" + index).val();
    calculaMontoOficios(idOficioActual);
}

function seleccionaAp(id) {
    $("#tabla1").find(".bg-success").removeClass("bg-success");
    $(id).addClass("bg-success");
    $("#ejercidoAp").prop("readonly", false);
    var index = $(id).attr("id");
    var idOficioActual = $("#idDetOfi" + index).val();
    calculaMontoAp(idOficioActual);
}

function calculaMontoOficios(idOficioActual) {

    $.ajax({
        data: {'accion': 'getMontoOficio', 'idDetOfi': idOficioActual, 'idAps': idAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            $("#tablaAp").find(".tipoMovimiento").each(
                    function () {
                        var ind = $(this).parents("tr").attr("id");
                        var montoAp = $("#tapafectacion" + ind).val().replace(/,/g, "");
                        montoAp = montoAp.replace(/,/g, "");
                        console.log(response + "_" + montoAp);

                        if ($("#tapidDetOfi" + ind).val() == idOficioActual) {
                            if ($("#tapidTipMov" + ind).val() == "6" || $("#tapidTipMov" + ind).val() == "4" || $("#tapidTipMov" + ind).val() == "2") {
                                response = response - montoAp;
                            } else if ($("#tapidTipMov" + ind).val() == "3") {
                                response = response + montoAp;
                            }
                        }
                    });
            if (response < 0)
                response = 0.00;
            $("#disponibleAp").val(response);
            $("#disponibleAp").focusin().focusout();
            console.log("Monto::" + response);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function calculaMontoAp(idOficioActual) {

    $.ajax({
        data: {'accion': 'getMontoOficioAp', 'idDetOfi': idOficioActual, 'idAps': idAps, 'mov': $("#movimientoAp").val()},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            $("#tablaAp").find(".tipoMovimiento").each(
                    function () {
                        var ind = $(this).parents("tr").attr("id");
                        var montoAp = $("#tapafectacion" + ind).val().replace(/,/g, "");
                        montoAp = montoAp.replace(/,/g, "");
                        console.log(response + "_" + montoAp);

                        if ($("#tapidRef" + ind).val() == idAps) {
                            if ($("#tapidTipMov" + ind).val() == "1" || $("#tapidTipMov" + ind).val() == "3" || $("#tapidTipMov" + ind).val() == "5") {
                                response = response - montoAp;
                            }
                        }
                    });
            if (response < 0)
                response = 0.00;
            $("#disponibleAp").val(response);
            $("#disponibleAp").focusin().focusout();
            console.log("Monto::" + response);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscaOficiosAp() {
    var mov = $("#movimientoAp").val();

    $.ajax({
        data: {'accion': 'getOficiosAp', 'idObr': $("#obraAp").val(), 'idAps': idAps, 'fecrec': FecRec, 'mov': mov},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log("Ap query::" + response);
            var data = jQuery.parseJSON(response);
            var newRow = "";
            for (var i = 0; i < data.length; i++) {
                newRow += "<tr id=" + i + " onClick='seleccionaAp(this);'>\n\
                            <td>" + data[i].Ejercicio + "<input type='text' id=ejercicio" + i + " value=" + data[i].Ejercicio + " style='display:none;'></td>\n\
                            <td>" + data[i].CveAps + "<input type='text' id=CveAps" + i + " value=" + data[i].CveAps + " style='display:none;'><input type='text' id=idAps" + i + " value=" + data[i].idAps + " style='display:none;'></td>\n\
                            <td>" + data[i].NomTipAps + "<input type='text' id=idTipAps" + i + " value=" + data[i].idTipAps + " style='display:none;'></td>\n\
                            <td>" + data[i].FecEnv + "</td>\n\
                            <td>" + data[i].NomTipOfi + "<input type='text' id=idTipOfi" + i + " value=" + data[i].idTipOfi + " style='display:none;'><input type='text' id=idDetOfi" + i + " value=" + data[i].idDetOfi + " style='display:none;'><input type='text' id=idRef" + i + " value=" + data[i].idRef + " style='display:none;'></td>\n\\n\
                            <td id=fte" + i + ">" + data[i].NomFte + "<input type='text' id=idFte" + i + " value=" + data[i].idFte + " style='display:none;'></td>\n\
                            <td id=inv" + i + ">" + data[i].NomInv + "<input type='text' id=idInv" + i + " value=" + data[i].idInv + " style='display:none;'></td>\n\
                            <td id=rec" + i + ">" + data[i].NomRec + "<input type='text' id=idRec" + i + " value=" + data[i].idRec + " style='display:none;'></td>\n\
                            <td>" + data[i].MonAut + "</td>\n\
                        </tr>";

            }
            $("#tabla1 tbody").append(newRow);
            $("#tabla1").trigger("update");

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}


function validarEjercido() {
    var ejercido = ($("#ejercidoAp").val().replace(/,/g, ""));
    var disponible = ($("#disponibleAp").val().replace(/,/g, ""));
    console.log("Disponible:" + disponible + " Ejercido:" + ejercido);
    if ($("#disponibleAp").val() === "") {
        alert("Seleccione un oficio");
        $("#ejercidoAp").val("");
    }
    if (ivaAmorticacion && (($("#ivaAmortizacion").val() + $("#ejercidoAp").val().replace(/,/g, "")) > $("#disponibleAp").val().replace(/,/g, ""))) {
        alert("El monto supero al monto disponible");
    }
    if (parseFloat(disponible) < parseFloat(ejercido)) {

        alert("El monto supero al monto disponible");
        $("#ejercidoAp").focus();
    }
}

function agregarMovimientos() {
    if ($("#ejercidoAp").val() != "") {
        var index = $(".tablesorter:visible").find(".bg-success").attr("id");
        var CveOfi = $("#of" + index).html();
        var NomRef = $("#idRef" + index).val();
        var NomFte = $("#fte" + index).text();
        var NomInv = $("#inv" + index).text();
        var NomRec = $("#rec" + index).text();
        var newRow = "<tr id=" + indice + " onClick='seleccionaMov(this);'>\n\
                <td>" + $("#ejercicio" + index).val() + "<input type='text' id=tapejercicio" + indice + " value=" + $("#ejercicio" + index).val() + " style='display:none;'></td>\n\
                <td>" + $("#obraAp").val() + "<input type='text' id=tapobra" + indice + " value=" + $("#obraAp").val() + " style='display:none;'><input type='text' id=tapidModEje" + indice + " value=" + $("#idModEje" + index).val() + " style='display:none;'></td>\n\
                <td>" + $("#movimientoAp option:selected").text() + "<input type='text' id=tapidTipMov" + indice + " class='tipoMovimiento' value=" + $("#movimientoAp").val() + " style='display:none;'></td>\n\
                <td>" + CveOfi + "<input type='text' id=tapidDetOfi" + indice + " value=" + $("#idDetOfi" + index).val() + " style='display:none;'></td>\n\
                <td>" + NomRef + "</td>\n\
                <td>" + NomFte + "<input type='text' id=tapidFte" + indice + " value=" + $("#idFte" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + NomInv + "<input type='text' id=tapidInv" + indice + " value=" + $("#idInv" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + NomRec + "<input type='text' id=tapidRec" + indice + " value=" + $("#idRec" + index).val() + " style='display:none;'></td>\n\\n\
                <td>" + $("#ejercidoAp").val() + "<input type='text' id=tapafectacion" + indice + " value=" + $("#ejercidoAp").val() + " style='display:none;'><input type='text' id=idDetAps" + indice + " value=0 style='display:none;'></td>\n\\n\
            </tr>";
        $("#tablaAp tbody").append(newRow);
        $("#tablaAp").trigger("update");
        $("#ejercidoAp").val("");
        $(".tablesorter:visible").find(".bg-success").trigger("click");
        indice++;
        detalle = true;
        calcularAP();
    }

}

function seleccionaMov(tr) {
    if ($(tr).hasClass("bg-danger")) {
        $(tr).removeClass("bg-danger");
    } else {
        $(tr).addClass("bg-danger");
    }
}

function seleccionaTodos() {
    $("#tablaAp tbody").find("tr").each(function () {
        $(this).addClass("bg-danger");
    });
}

function deseleccionaTodos() {
    $("#tablaAp tbody").find("tr").each(function () {
        $(this).removeClass("bg-danger");
    });
}

function quitarSeleccionados() {
    $("#tablaAp tbody").find(".bg-danger").each(function () {
        var i = $(this).attr("id");
        if ($("#idDetAps" + i).val() != 0)
            apBorradas.push($("#idDetAps" + i).val());
        $(this).remove();
        $(".tablesorter:visible").find(".bg-success").trigger("click");
    });
    detalle = true;
    calcularAP();
}

function modTabla() { //SI SE HIZO UN CAMBIO EN LA TABLA DE APLICACIÓN PRESUPUESTAL
    detalle = false;
    calcularAP();
}

function calcularAP() {
    var movimientos = 0;
    $("#tablaAp tbody").find("tr").each(function () {
        movimientos++;
    });

    if (movimientos > 0) {
        var montoTmp;
        var importe = 0;
        var amortizacion = 0;
        var subtotal = 0;
        var iva = 0;
        var afectacion = 0;
        var neto = 0;
        if (none) {
            alert();
            var icic = 0.00;
            var cmic = 0.00;
            var sup = 0.00;
            var ispt = 0.00;
            var otro = 0.00;
        } else {
            var icic = $("#icicAp").val().replace(/,/g, "");
            icic = icic.replace(/,/g, "");
            var cmic = $("#cmicAp").val().replace(/,/g, "");
            cmic = cmic.replace(/,/g, "");
            var sup = $("#supervisionAp").val().replace(/,/g, "");
            sup = sup.replace(/,/g, "");
            var ispt = $("#isptAp").val().replace(/,/g, "");
            ispt = ispt.replace(/,/g, "");
            var otro = $("#otroAp").val().replace(/,/g, "");
            otro = otro.replace(/,/g, "");
            iva = $("#ivaAp").val().replace(/,/g, "");
            iva = iva.replace(/,/g, "");
        }
        var retenciones = 0;
        if (detalle) { //MOVIMIENTOS AGREGADOS
            var tipoAdm = false;
            var tipoAnt = false;

            $("#tablaAp tbody").find("tr").each(function () {
                var indice = $(this).attr("id");
                if ($("#tapidModEje" + indice).val() === "2") { //2= ADMINISTRACION
                    tipoAdm = true;
                }
                montoTmp = ($("#tapafectacion" + indice).val().replace(/,/g, ""));
                montoTmp = montoTmp.replace(/,/g, "");
                console.log("Monto TMP:" + montoTmp);


                if ($("#tapidTipMov" + indice).val() === "2") { //2 = ANTICIPO
                    tipoAnt = true;
                }
                if ($("#tapidTipMov" + indice).val() === "2" || $("#tapidTipMov" + indice).val() == "4" || $("#tapidTipMov" + indice).val() == "6") { //ANTICIPO,ESTIMACION,PAGO
                    importe = (parseFloat(importe) + parseFloat(montoTmp));
                    console.log("Importe:" + importe);
                }
                if ($("#tapidTipMov" + indice).val() === "1") { //AMORTIZACION
                    amortizacion = (parseFloat(amortizacion) + parseFloat(montoTmp));
                    console.log("Amortizacion:" + amortizacion);
                }

            });




            if (consulta) {
                console.log("Primer ingreso");
                importe = ((importe - iva) + amortizacion); //IMPORTE SIN IVA
                consulta = false;
            } else {
                importe = ((importe / (1.16)) + amortizacion); //IMPORTE SIN IVA
                console.log("Importe sin iva:" + importe);
                iva = ((importe - amortizacion) * 0.16);//IVA DEL IMPORTE
                console.log("Iva del importe:" + iva)
                if ((importe > amortizacion) && (!tipoAnt) && (!tipoAdm)) { //CALCULAR RETENCIONES SI HAY PAGOS
                    icic = (importe * 0.002);//ICIC
                    cmic = (importe * 0.005);//CMIC
                    sup = (importe * 0.02);//SUPERVISION

                } else {
                    icic = 0.00;//ICIC
                    cmic = 0.00;//CMIC
                    sup = 0.00;//SUPERVISION
                }
            }


            console.log("ICIC:" + icic);
            console.log("CMIC:" + cmic);
            console.log("Supervision:" + sup);
            console.log("ISPT:" + ispt);
            console.log("Otro:" + otro);
        } else { //MODIFICACION DIRECTA A LA TABLA "APLICACION PRESUPUESTAL"
            importe = ($("#sinivaAp").val().replace(/,/g, ""));
            importe = importe.replace(/,/g, "");
            amortizacion = ($("#amortizacionAp").val().replace(/,/g, ""));
            amortizacion = amortizacion.replace(/,/g, "");
            iva = ($("#ivaAp").val().replace(/,/g, ""));
            iva = iva.replace(/,/g, "");
            detalle = false;

        }
        subtotal = (importe) - (amortizacion);//SUBTOTAL
        console.log("Subtotal:" + subtotal);

        afectacion = parseFloat(subtotal) + parseFloat(iva);//AFECTACION PRESUPUESTAL
        console.log("Afectacion:" + afectacion);

        retenciones = parseFloat(icic) + parseFloat(cmic) + parseFloat(sup) + parseFloat(ispt) + parseFloat(otro);//AFECTACION PRESUPUESTAL
        console.log("Retenciones:" + retenciones);

        neto = (afectacion) - (retenciones);//AFECTACION PRESUPUESTAL
        console.log("Neto:" + neto);

        $("#sinivaAp").val(importe).focusin().focusout();
        $("#amortizacionAp").val(amortizacion).focusin().focusout();
        $("#subtotalAp").val(subtotal).focusin().focusout();
        $("#ivaAp").val(iva).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#afectacionAp").val(afectacion).focusin().focusout();
        $("#netoAp").val(neto).focusin().focusout();
        $("#icicAp").val(icic).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#cmicAp").val(cmic).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#supervisionAp").val(sup).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#isptAp").val(ispt).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#otroAp").val(otro).unbind('change').focusin().focusout().on('change', function () {
            modTabla();
        });
        $("#retencionesAp").val(retenciones).focusin().focusout();
        $("#letranetoAp").val(NumeroALetras($("#netoAp").val().replace(/,/g, "")));

    } else {
        $("#sinivaAp").val(0.00);
        $("#amortizacionAp").val(0.00);
        $("#subtotalAp").val(0.00);
        $("#ivaAp").val(0.00);
        $("#afectacionAp").val(0.00);
        $("#netoAp").val(0.00);
        $("#icicAp").val(0.00);
        $("#cmicAp").val(0.00);
        $("#supervisionAp").val(0.00);
        $("#isptAp").val(0.00);
        $("#otroAp").val(0.00);
        $("#retencionesAp").val(0.00);
        $("#letranetoAp").val("");
    }
}

function guardarAp() {
    var rows = 0;
    $("#tablaAp tbody").find("tr").each(function () {
        rows++;
    });

    if (rows === 0) {
        alert("No hay movimientos realizados");
        return false;
    }
//    if (estadoAp != 3 && PrmMod != 1) {
//        alert("La AP debe estar en Proceso o Habilitada para Modificaci\u00f3n para poder realizarle cambios");
//        return false;
//    }
    if ($("#idEmpAp").val() == '') {
        alert("Debe seleccionar un Beneficiario v\u00e1lido");
        $("#rfcAp").focus();
        return false;
    }

    var apPrincipal = new Array();
    var apDetalle = new Array();
    var apActDet = new Array();
    var error = 0;
    var finiquito = 0;
    var cp = 0;
    var desafect = 0;
    var afect = 0;
    console.log("Aps borradas:" + apBorradas);


    $("#tablaAp tbody").find("tr").each(function () { //SI LOS MOVIMIENTOS NO SON NUEVOS ENTONCES ACTUALIZA
        var i = $(this).attr("id");
        if ($("#idDetAps" + i).val() != 0) {
            var ivaAmort = 0;
            var factor = $("#tapafectacion" + i).val() / $("#afectacionAp").val().replace(/,/g, "");
            if (($("#tapidTipMov" + i).val() != "2" && $("#tapidTipMov" + i).val() != "4" && $("#tapidTipMov" + i).val() != "6") || factor == null) {
                factor = 0;
            } else {
                ivaAmort = factor * ivaAp;
            }
            var actualizacion = {
                'idDetAps': $("#idDetAps" + i).val(),
                'IvaAmo': ivaAmort,
                'Monto': $("#tapafectacion" + i).val(),
                'RetCnic': factor * $("#icicAp").val().replace(/,/g, ""),
                'RetCicem': factor * $("#cmicAp").val().replace(/,/g, ""),
                'RetSup': factor * $("#supervisionAp").val().replace(/,/g, ""),
                'RetISPT': factor * $("#isptAp").val().replace(/,/g, ""),
                'RetOtr': factor * $("#otroAp").val().replace(/,/g, "")
            };
            apActDet.push(actualizacion);
        }
    });

    console.log("Movimientos Actualizados:" + apActDet);

    if ($("#errorAp").prop("checked"))
        error = 1;
    if ($("#finiquitoAp").prop("checked"))
        finiquito = 1;
    if ($("#cpAp").prop("checked"))
        cp = 1;
    if ($("#desafectacionAp").prop("checked"))
        desafect = 1;
    if ($("#soloAp").prop("checked"))
        afect = 1;



    var principal = {//DATOS A ACTUALIZAR DE LA PRINCIPAL
        'idAps': idAps,
        'NumEst': $("#estimacionAp").val(),
        'idEmp': $("#idEmpAp").val(),
        'Error': error,
        'Finiquito': finiquito,
        'AutPagCP': cp,
        'DesAfe': desafect,
        'SolAfe': afect,
        'ObsAps': $("#observacionesAp").val(),
        'PrmMod': 0,
        'Iva': $("#ivaAp").val().replace(/,/g, ""),
        'RetCnic': $("#icicAp").val().replace(/,/g, ""),
        'RetCicem': $("#cmicAp").val().replace(/,/g, ""),
        'RetSup': $("#supervisionAp").val().replace(/,/g, ""),
        'RetISPT': $("#isptAp").val().replace(/,/g, ""),
        'RetOtr': $("#otroAp").val().replace(/,/g, "")

    }
    apPrincipal.push(principal);
    console.log("ApPrincipal:" + apPrincipal);

    $("#tablaAp tbody").find("tr").each(function () { //SI LOS MOVIMIENTOS SON NUEVOS INSERTAR DATOS
        var index = $(this).attr("id");
        if ($("#idDetAps" + index).val() == 0) {
            var ivaAmort = 0;
            var factor = $("#tapafectacion" + index).val().replace(/,/g, "") / $("#afectacionAp").val().replace(/,/g, "");
            console.log("Factor: " + factor);
            if (($("#tapidTipMov" + index).val() != "2" && $("#tapidTipMov" + index).val() != "4" && $("#tapidTipMov" + index).val() != "6") || factor == null) {
                factor = 0;
            } else {
                ivaAmort = factor * ivaAp;
            }
            var detalle = {
                'idAps': idAps,
                'idDetOfi': $("#tapidDetOfi" + index).val(),
                'idRef': 0,
                'idTipAps': $("#tapidTipMov" + index).val(),
                'IvaAmo': ivaAmort,
                'Monto': $("#tapafectacion" + index).val(),
                'RetCnic': factor * $("#icicAp").val().replace(/,/g, ""),
                'RetCicem': factor * $("#cmicAp").val().replace(/,/g, ""),
                'RetSup': factor * $("#supervisionAp").val().replace(/,/g, ""),
                'RetISPT': factor * $("#isptAp").val().replace(/,/g, ""),
                'RetOtr': factor * $("#otroAp").val().replace(/,/g, "")

            }

            apDetalle.push(detalle);
        }
    });
    console.log("Movimientos nuevos:" + apDetalle);

    $.ajax({
        data: {'accion': 'guardaDetalle', 'apBorradas': apBorradas, 'apPrincipal': apPrincipal, 'apDetalle': apDetalle},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response) {
                $("#dialogAvisos").modal();
                $("#msgAviso").html("Datos guardados");
                $('#dialogAvisos').on('hidden.bs.modal', function () {
                    location.reload();
                });
            }
        },
        error: function (response) {
            console.log("Errores::", response);
            $("#dialogAvisos").modal();
            $("#msgAviso").html(response);
            $('#dialogAvisos').on('hidden.bs.modal', function () {
                location.reload();
            });
        }
    });

}

function buscarDevoluciones() {
    $("#tablaDev tbody").find("tr").each(function () {
        $(this).remove();
    });
    $.ajax({
        data: {'accion': 'getDevoluciones', 'idAps': idAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            var newRow = "";
            for (var i = 0; i < data.length; i++) {
                newRow += "<tr>\n\
                            <td>" + data[i].FecDev + "</td>\n\
                            <td>" + data[i].OfiDev + "</td>\n\
                            <td>" + data[i].idUsu + "</td>\n\
                            <td>" + data[i].ObsDev + "</td>\n\
                        </tr>";

            }
            $("#tablaDev tbody").append(newRow);
            $("#tablaDev").trigger("update");

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function guardarDevolucion() {
    var datos = new Array();
    var fecDev = $("#fecDev").val();
    var oficioDev = $("#oficioDev").val();
    var obsDev = $("#obsDev").val();
    var temp = {
        'idAps': idAps,
        'FecDev': fecDev,
        'OfiDev': oficioDev,
        'Obs': obsDev
    };
    datos.push(temp);
    $.ajax({
        data: {'accion': 'devolucionAp', 'ap': datos},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response) {
                buscarDevoluciones();
                $('#dialogDevolucion').on('hidden.bs.modal', function () {
                    location.reload();
                });
            } else {
                alert("Ocurrio un error al generar devolucion");
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}


