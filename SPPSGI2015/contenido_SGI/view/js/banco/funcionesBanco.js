var tiposDeMovimiento = {
    1: 'Creado',
    2: 'Edici\u00f3n',
    3: 'Env\u00edado',
    4: 'Ingreso',
    5: 'Revisi\u00f3n',
    6: 'Aceptado',
    7: 'Cancelado',
    8: 'En proceso',
    9: 'Registrado',
    10: 'Analizado'
};

var opcionesDataTable = {
    retrieve: true,
    searching: true,
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
    }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
        if (aData[8] === 1) {
            for (var i = 0; i <= 7; i++) {
                var cel = tablaObservacionesBanco.cell(nRow, i).node();
                $(cel).addClass("negrita");
            }
        }
        var no = tablaObservacionesBanco.cell(nRow, 8).node();
        $(no).addClass("hidden", true);
        var mto = tablaObservacionesBanco.cell(nRow, 6).node();
        $(mto).addClass("mto");
    }
};

var tablaObservacionesBanco;
var tablaHistorialBanco;
var tablaObsPartBanco;
/*
 
 */
$(document).ready(function () {
    $("#btnIngresar").click(function () {
        if ($("#numbco").val() == "") {
            bootbox.alert('Ingresa un numero de banco');
            $("#numbco").focus();
            return false
        }
        else {
            if ($("#status").val() == 0) {
                bootbox.alert('Selecciona un estatus');
                $("#status").focus();
                return false
            }
            else {
                if ($("#observaciones").val() == "") {
                    bootbox.alert('Ingresa observaciones');
                    $("#status").focus();
                    return false
                }
                else {
                    enviarStatus();
                }

            }
        }

    });

    tablaObservacionesBanco = $("#tablaObservaciones").DataTable(opcionesDataTable);
    tablaHistorialBanco = $("#lista").DataTable(opcionesDataTable);
    tablaObsPartBanco = $("#lista2").DataTable(opcionesDataTable);
    cargaGrid();
});

function enviarStatus() {
    $.ajax({
        data: {
            accion: 'guardarStatus',
            idBco: $("#numbco").val(),
            status: $("#status").val(),
            observaciones: $("#observaciones").val()
        },
        url: 'contenido_SGI/controller/banco/bancoController.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            var info = jQuery.parseJSON(response);

            if (info.infores) {
                bootbox.alert('Registro correcto');
                cargaGrid();
            }
            else {
                bootbox.alert('Ocurri\u00F3 un error al registrar intente nuevamente');
            }

            //console.log(response);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}
function cargaGrid() {
    $.ajax({
        data: {
            accion: 'consultaInfoBanco',
            rolUsu: $("#idRolUsuarioSession").val(),
            idUsu: $("#idUsuarioSession").val()
        },
        url: 'contenido_SGI/controller/banco/bancoController.php',
        type: 'post',
        success: function (response) {
            var info = jQuery.parseJSON(response);
            var total = 0;
            var ban = 0;
            console.log("info");
            console.log(info);
            tablaObservacionesBanco.clear();
            if (info.infoRes) {
                $("#resConsulta").html('');
                $.each(info.infoData, function (index, value) {
                    if ($("#idRolUsuarioSession").val() === "2") {
                        if (value.NumStatus === "3") {
                            total++;
                            ban = 1;
                        } else {
                            ban = 0;
                        }
                    } else if ($("#idRolUsuarioSession").val() === "1") {
                        if (value.NumStatus === "2" || value.NumStatus === "6") {
                            total++;
                            ban = 1;
                        } else {
                            ban = 0;
                        }
                    }
                    if (value.NumDictamen === "" || value.NumDictamen === null) {
                        tablaObservacionesBanco.row.add([
                            "<a onClick='muestraFichaTec(" + value.IdBco + ");' style='cursor: pointer;'>" + value.IdBco + "</a>",
                            value.NumDictamen,
                            value.NomObr,
                            value.NomUE,
                            value.fecMov,
                            value.Status,
                            number_format(value.Monto, 2),
                            "<div class='btn btn-warning' onclick=\"mostrarHistorico('" + value.IdSol + "')\">+</div>",
                            ban
                        ]);
                    } else {
                        tablaObservacionesBanco.row.add([
                            "<a onClick='muestraFichaTec(" + value.IdBco + ");' style='cursor: pointer;'>" + value.IdBco + "</a>",
                            "<a onclick=\"mostrarDictamen('" + value.IdSol + "', '" + value.IdBco + "')\" style='cursor: pointer;'>" + value.NumDictamen + "</a>",
                            value.NomObr,
                            value.NomUE,
                            value.fecMov,
                            value.Status,
                            number_format(value.Monto, 2),
                            "<div class='btn btn-warning' onclick=\"mostrarHistorico('" + value.IdSol + "')\">+</div>",
                            ban
                        ]);
                    }
                });
                $("#total").html(total);
                tablaObservacionesBanco.draw();
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function mostrarDictamen(idSol, idBco) {
    $("#formPdfDic").html("<form method='POST' action='contenido_SGI/view/Banco/dictamenPDF.php' target='_blank'>" +
            "<input type='text' name='idBco' value='" + idBco + "' />" +
            "<input type='text' name='idSol' value='" + idSol + "' />" +
            "<input type='submit' name='enviar' value='enviar' id='enviarPDF' />" +
            "</form>");
    $("#enviarPDF").click();
}

function mostrarHistorico(idSol) {
    $.ajax({
        data: {
            accion: 'consultaestsol',
            idSol: idSol
        },
        url: 'contenido_SGI/controller/banco/bancoController.php',
        type: 'post',
        success: function (response) {
            var info = jQuery.parseJSON(response);
            console.log(info);
            tablaHistorialBanco.clear();
            for (var i = 0; i < info.length; i++) {
                tablaHistorialBanco.row.add([
                    info[i].FecAce,
                    "V." + ((info.length) - i),
                    info[i].obs,
                    info[i].opcion
                ]);
            }
            tablaHistorialBanco.draw();
            $("#dialog1").modal("show");
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function mostrarObs(idEva) {
    $.ajax({
        data: {
            accion: 'consultadeteva',
            idEva: idEva
        },
        url: 'contenido_SGI/controller/banco/bancoController.php',
        type: 'post',
        success: function (response) {
            var info = jQuery.parseJSON(response);
            tablaObsPartBanco.clear();
            for (var i = 0; i < info.length; i++) {
                if (info[i].Observa !== "") {
                    tablaObsPartBanco.row.add([
                        info[i].NomSub,
                        info[i].Pagina,
                        info[i].Observa
                    ]);
                }
            }
            tablaObsPartBanco.draw();
            $("#dialog2").modal("show");
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function muestraFichaTec(idBco) {
    $("#idBcoFicha").val(idBco);
    $("#formFichaBco").submit();
}
