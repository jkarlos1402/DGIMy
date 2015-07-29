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
var datosAp = new Array();
var movAp = new Array();

$(document).ready(function () {
    $("input[type=text],textarea,select").addClass("form-control input-sm");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    $(".number").autoNumeric();
    getEstadosAp();
    $("#folioAp").on('change', (function () {
        getApById();
        $("#folioAp").attr("readonly", "true");
    }));
    $("#fecRecAp,#fecEnvio,#fecEntrega,#fechaCancel").datepicker({
        format: "dd-mm-yyyy"
    });
    $("#movimientoAp").change(function () {
        despliegaTabla();
        $("#disponibleAp").val("");
    });
    $("#estadoAp").change(function () {
        if ($("#estadoAp").val() == "2") {
            $("#divCancel").show();
        } else {
            $("#divCancel").hide();
        }
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
    $("#btnImprimir").click(function () {
        imprimirDetalle();
    });


    //$("#ivaAp,#icicAp,#cmicAp,#supervisionAp,#isptAp,#otroAp").on('keyup',function(){modTabla();})
});

function getApById() {

    var CveAps = $("#folioAp").val();
    $.ajax({
        data: {'accion': 'buscarFolioControl', 'CveAps': CveAps},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var data = jQuery.parseJSON(response);
            datosAp.push(data[0]);
            if (data.length > 0) {
                $("#movimientos").show();
                idAps = data[0].idAps;
                $("#estadoAp").val(data[0].idEdoAps);
                estadoAp = data[0].idEdoAps;
                $("#fecRecAp").val(data[0].FecRec);
                $("#fecEntrega").val(data[0].FecEnt);
                $("#fecEnvio").val(data[0].FecEnv);
                $("#beneficiarioAp").val(data[0].NomEmp);
                $("#observacionesAp").val(data[0].ObsAps);
                $("#ejecutoraAp").val(data[0].NomUE);
                $("#turnoAp").val(data[0].idTurAps);
                $("#relacion").val(data[0].CveApsRel);
                if (data[0].Error == 1) {
                    $("#errorAp").attr("checked", "");
                }
                if (data[0].Finiquito == 1) {
                    $("#finiquitoAp").attr("checked", "");
                }
                if (data[0].DesAfe == 1) {
                    $("#desafectacionAp").attr("checked", "");
                }
                if (data[0].SolAfe == 1) {
                    $("#soloAp").attr("checked", "");
                }
                if (data[0].AutPagCP == 1) {
                    $("#cpAp").attr("checked", "");
                }
                if (data[0].PrmMod == 1) {
                    $("#modAp").attr("checked", "");
                }
                FecRec = data[0].FecRec;
                idDetObr = data[0].idDetObr;
                PrmMod = data[0].PrmMod;
                estadoAp = data[0].idEdoAps;
                ivaAp = data[0].Iva;

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
                                            <td>" + data[i].idFte + "<input type='text' id=tapidFte" + indice + " value='" + data[i].idFte + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomInv + "<input type='text' id=tapidInv" + indice + " value='" + data[i].idInv + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].nomRec + "<input type='text' id=tapidRec" + indice + " value='" + data[i].idRec + "' style='display:none;'></td>\n\\n\
                                            <td>" + data[i].monto + "<input type='text' id=tapafectacion" + indice + " value=" + data[i].monto + " style='display:none;'><input type='text' id=idDetAps" + indice + " value=" + data[i].idDetAps + " style='display:none;'></td>\n\\n\
                                        </tr>";
                                $("#tablaAp tbody").append(newRow);
                                $("#tablaAp").trigger("update");
                                 movAp.push(data[i]);   
                                indice++;
                                
                            }
                            $("#obraAp").val(data[0].idObr);
                            $("#idDetObrAp").val(data[0].idDetObr);
                            $("#nombreobraAp").val(data[0].NomObr);
                            $("#icicAp").val(data[0].RetCnic);

                            $("#cmicAp").val(data[0].RetCicem);

                            $("#supervisionAp").val(data[0].RetSup);

                            $("#isptAp").val(data[0].RetIspt);

                            $("#otroAp").val(data[0].RetOtr);
                            $("#ivaAp").val(data[0].iva);

                            consulta = true;
                            detalle = true;
                            calcularAP();

                            //
                        }
                    },
                    error: function (response) {
                        console.log("Errores::", response);
                    }
                });
                $("#btnGuardar").show();
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
                $("#btnGuardar").hide();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function getEstadosAp() {
    $.ajax({
        data: {'accion': 'getEstadoAp'},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            $("#estadoAp").append(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
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
        //$("#letranetoAp").val(covertirNumLetras($("#netoAp").val().replace(/,/g,"")));

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
    var error = 0, finiquito = 0, cp = 0, desafect = 0, afect = 0, modif = 0;
    var apPrincipal = new Array();
    var datosCancel = new Array();
    if ($("#estadoAp").val() == "1" && $("#fecEnvio").val() == "") {
        alert("Debe asignar fecha de env\u00edo para AP aceptado");
        $("#fecEnvio").focus();
        return false;
    }

    if ($("#estadoAp").val() == "2") { //Estado cancelado
        var cancel = {
            'idAps': idAps,
            'FecDev': $("#fechaCancel").val(),
            'OfiDev': $("#oficioCancel").val(),
            'Obs': $("#observacionesCancel").val()
        };
        datosCancel.push(cancel);
    }

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
    if ($("#modAp").prop("checked"))
        modif = 1;


    var principal = {//DATOS A ACTUALIZAR DE LA PRINCIPAL
        'idAps': idAps,
        'idEdoAps': $("#estadoAp").val(),
        'idTurAps': $("#turnoAp").val(),
        'idRelAps': $("#relacion").val() != "" ? $("#relacion").val() : '0',
        'FecRec': $("#fecRecAp").val(),
        'FecEnv': $("#fecEnvio").val(),
        'FecEnt': $("#fecEntrega").val(),
        'PrmMod': modif,
        'Finiquito': finiquito,
        'AutPagCP': cp,
        'DesAfe': desafect,
        'SolAfe': afect,
        'Error': error,
        'ObsAps': $("#observacionesAnalisis").val()
    };
    apPrincipal.push(principal);
    console.log("Cancelacion:");
    console.log(datosCancel);
    console.log("Principal:");
    console.log(apPrincipal);



    $.ajax({
        data: {'accion': 'actualizarApControl', 'datosCancel': datosCancel, 'apPrincipal': apPrincipal},
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
            } else {
                $("#dialogAvisos").modal();
                $("#msgAviso").html("Ocurri&oacute; un error");
                $('#dialogAvisos').on('hidden.bs.modal', function () {
                    location.reload();
                });
            }
//            console.log("Ap query::" + response);
//            var data = jQuery.parseJSON(response);


        },
        error: function (response) {
            $("#dialogAvisos").modal();
            $("#msgAviso").html(response);
            $('#dialogAvisos').on('hidden.bs.modal', function () {
                location.reload();
            });
            console.log("Errores::", response);
        }
    });

}

function imprimirDetalle() {
   console.log(datosAp);
   console.log(movAp);
   var montosAp = new Array();
    var tmpMontos={
        'impsiniva':$("#sinivaAp").val(),
        'amortizacion':$("#amortizacionAp").val(),
        'icic':$("#icicAp").val(),
        'ispt':$("#isptAp").val(),
        'subtotal':$("#subtotalAp").val(),
        'iva':$("#ivaAp").val(),
        'cmic':$("#cmicAp").val(),
        'otro':$("#otroAp").val(),
        'afectacion':$("#afectacionAp").val(),
        'neto':$("#netoAp").val(),
        'supervision':$("#supervisionAp").val(),
        'total':$("#totalAp").val()
    };
    montosAp.push(tmpMontos);
    console.log(montosAp);
    $.ajax({
        data: {'accion': 'imprimirDetalle', 'datosAp': datosAp,'movAp':movAp,'montosAp':montosAp},
        url: 'contenido_SGI/vistas/Aplicacion/funciones/funcionesAplicacionController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response) {
                window.open("contenido_sgi/vistas/aplicacion/funciones/impresionDetalleAp.php", "_blank");
//                location.reload();
            } else {
                alert("Error al generar la impresion de Ap");
            }
        },
        error: function (response) {
            $("#dialogAvisos").modal();
            $("#msgAviso").html(response);
            $('#dialogAvisos').on('hidden.bs.modal', function () {
                location.reload();
            });
            console.log("Errores::", response);
        }
    });
}

