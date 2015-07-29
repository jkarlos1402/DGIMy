$(document).ready(function () {
    tablaObra = $('#tablaObsObr').DataTable({"retrieve": true, "ordering": true, "sPaginationType": "bootstrap",
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
        }, "fnCreatedRow": function (nRow, aData, iDataIndex) {
            var mto = tablaObra.cell(nRow, 2).node();
            $(mto).addClass("mto");
        }
    });
    
    $("#mostrarObras").click(function () {
       colocaWaitGeneral();
       buscarObras(); 
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

function buscarObras() {
    var fecIni = $("#fecIni").val();
    var fecFin = $("#fecFin").val();
    $.ajax({
        data: {accion: 'consultasObras', 'fecIni':fecIni, 'fecFin':fecFin},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
            var obra = $.parseJSON(response);
            tablaObra.clear().draw();
            var icono = "";
            var guardar = "";
            var onclick="";
            var exportar = "";
            var oficios = "";
            var varof = "";
            var aps = "";
            var varap = "";
            var lista = 1;
            var archivo = 2;
            for (var i = 0; i < obra.obra.length; i++) {
                if(obra.obra[i].NumObr!="0"){
                    onclick="onclick='buscarSolicitudes("+obra.obra[i].idObr+","+lista+")'";
                    exportar = "onclick = 'buscarSolicitudes("+obra.obra[i].idObr+","+archivo+")'";
                    for (var j = 0; j < obra.oficios.length; j++) {
                        if(obra.oficios[j].idObr === obra.obra[i].idObr){
                            oficios="onclick='buscarOficios("+obra.oficios[j].idObr+")'";
                            varof = "<span style='cursor:pointer;' "+oficios+" class='badge alert-warning'>"+obra.oficios[j].NumObrOfi+"</span>";
                        }else{
                            oficios = "";
                            varof = "<span style='cursor:pointer;' "+oficios+" class='badge alert-warning'>0</span>";
                        }
                    }
                    
                    for (var k = 0; k < obra.ap.length; k++) {
                        if(obra.ap[k].idObr === obra.obra[i].idObr){
                            aps="onclick='buscarAp("+obra.obra[i].idObr+")'";
                            varap = "<span style='cursor:pointer;' "+aps+" class='badge alert-warning'>"+obra.ap[k].NumObrAp+"</span>";
                        }else{
                            aps = "";
                            varap = "<span style='cursor:pointer;' "+aps+" class='badge alert-warning'>0</span>";
                        }
                    }
                    
                }else{
                    onclick="";
                    exportar = "";
                }
            icono = "<span style='cursor:pointer;' "+onclick+" class='badge alert-warning'>"+obra.obra[i].NumObr+"</span>";
            guardar = "<span style='cursor:pointer;' "+exportar+" class='fa fa-file-pdf-o'></span>";
            tablaObra.row.add([obra.obra[i].idObr,obra.obra[i].NomObr,number_format(obra.obra[i].MontoAsignado, 2),icono,guardar,varof,varap]).draw();
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscarSolicitudes(idObr, tipo) {
    var excelObras = [];
    $.ajax({
        data: {accion: 'solicitudesObras', idObr: idObr, tipo: tipo},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
            var solicitudes = $.parseJSON(response);
            if(tipo == 1){
                crearAcordion(solicitudes);
            }else{
                window.open("contenido_sgi/view/Obra/consultaObra_xls.php?idObr="+idObr);
            }
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscarOficios(idObr) {
    $.ajax({
        data: {accion: 'oficiosObras', idObr: idObr},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
            var oficios = $.parseJSON(response);
            crearAcordionOf(oficios);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function buscarAp(idObr) {
    $.ajax({
        data: {accion: 'apObras', idObr: idObr},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
            var aps = $.parseJSON(response);
            crearAcordionAP(aps);
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function crearAcordion(solicitudes) {
    data_html = " 	<div class='panel panel-default'>";
    data_html += " 	  <div class='panel-heading'>";
    data_html += " 	    <h3 class='panel-title'>Solicitudes ::: Obra: [ " + solicitudes[0].IdObr + " ] </h3>";
    data_html += " 	  </div>";
    data_html += " 	  <div class='panel-body'>";
    data_html += " 	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";

    for(var i=0;i<solicitudes.length;i++){
        data_html += "   <div class='panel panel-success'>";
        data_html += "     <div class='panel-heading' role='tab' id='heading" + solicitudes[i].IdSol + "'>";
        data_html += "       <h4 class='panel-title'>";
        data_html += "        <a data-toggle='collapse' data-parent='#accordion' href='#collapse" + solicitudes[i].IdSol + "' aria-expanded='true' aria-controls='collapseOne'>";
        data_html += "      Solicitud " + solicitudes[i].IdSol + " [+]";
        data_html += "        </a>";
        data_html += "       </h4>";
        data_html += "     </div>";
        data_html += "    <div id='collapse" + solicitudes[i].IdSol + "' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading" + solicitudes[i].IdSol + "'>";
        data_html += "     <div class='panel-body'>";
        data_html += "      <table class='table table-hover table-bordered'>";
        data_html += "          <thead>";
        data_html += "              <tr class='success'>";
        data_html += "                  <td>Solicitud</td>";
        data_html += "                  <td>Tipo de Solicitud</td>";
        data_html += "                  <td>Nombre de la Obra</td>";
        data_html += "                  <td>Monto</td>";
        data_html += "                  <td>Estado</td>";
        data_html += "              </tr>";
        data_html += "          </thead>";
        data_html += "          <tbody>";
        data_html += "              <tr>";
        data_html += "                  <td>"+solicitudes[i].IdSol+"</td>";
        data_html += "                  <td>"+solicitudes[i].NomSolPre+"</td>";
        data_html += "                  <td>"+solicitudes[i].NomObr+"</td>";
        data_html += "                  <td><p align=right>"+number_format(solicitudes[i].Monto, 2)+"</p></td>";
        data_html += "                  <td>"+solicitudes[i].NomEdo+"</td>";
        data_html += "              </tr>";
        data_html += "          </tbody>";
        data_html += "      </table>";
        data_html += "     </div>";
        data_html += "     </div>";
        data_html += "   </div>";
    }
    data_html += " 	</div>";
    data_html += " 	  </div>";
    data_html += " 	</div>";

    $("#solCollapse").html(data_html);
    
    $('#solCollapse').collapse({
        toggle: false
    });
    $("#collapse" + solicitudes[0].IdSol).removeClass("off").addClass("in");
}


function crearAcordionOf(oficios) {
    data_html = " 	<div class='panel panel-default'>";
    data_html += " 	  <div class='panel-heading'>";
    data_html += " 	    <h3 class='panel-title'>Oficios ::: Obra: [ " + oficios[0].idObr + " ] </h3>";
    data_html += " 	  </div>";
    data_html += " 	  <div class='panel-body'>";
    data_html += " 	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";

    for(var i=0;i<oficios.length;i++){
        data_html += "   <div class='panel panel-success'>";
        data_html += "     <div class='panel-heading' role='tab' id='heading" + oficios[i].idDetOfi + "'>";
        data_html += "       <h4 class='panel-title'>";
        data_html += "        <a data-toggle='collapse' data-parent='#accordion' href='#collapse" + oficios[i].idDetOfi + "' aria-expanded='true' aria-controls='collapseOne'>";
        data_html += "      Oficio " + oficios[i].CveOfi + " Fuente " + oficios[i].DscFte + " [+]";
        data_html += "        </a>";
        data_html += "       </h4>";
        data_html += "     </div>";
        data_html += "    <div id='collapse" + oficios[i].idDetOfi + "' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading" + oficios[i].idDetOfi + "'>";
        data_html += "     <div class='panel-body'>";
        data_html += "      <table class='table table-hover table-bordered'>";
        data_html += "          <thead>";
        data_html += "              <tr class='success'>";
        data_html += "                  <td>Cve. Oficio</td>";
        data_html += "                  <td>Tipo de Solicitud</td>";
        data_html += "                  <td>Id. Solicitud</td>";
        data_html += "                  <td>Nombre de la Obra</td>";
        data_html += "                  <td>Estado del Oficio</td>";
        data_html += "              </tr>";
        data_html += "          </thead>";
        data_html += "          <tbody>";
        data_html += "              <tr>";
        data_html += "                  <td>"+oficios[i].CveOfi+"</td>";
        data_html += "                  <td>"+oficios[i].NomSolPre+"</td>";
        data_html += "                  <td>"+oficios[i].IdSol+"</td>";
        data_html += "                  <td>"+oficios[i].NomObr+"</td>";
        data_html += "                  <td>"+oficios[i].NomEdoOfi+"</td>";
        data_html += "              </tr>";
        data_html += "          </tbody>";
        data_html += "      </table>";
        data_html += "     </div>";
        data_html += "     </div>";
        data_html += "   </div>";
    }
    data_html += " 	</div>";
    data_html += " 	  </div>";
    data_html += " 	</div>";

    $("#solCollapse").html(data_html);
    
    $('#solCollapse').collapse({
        toggle: false
    });
    $("#collapse" + oficios[0].idDetOfi).removeClass("off").addClass("in");
}

function crearAcordionAP(aps) {
    data_html = " 	<div class='panel panel-default'>";
    data_html += " 	  <div class='panel-heading'>";
    data_html += " 	    <h3 class='panel-title'>Autorizaci&oacute;n de Pago ::: Obra: [ " + aps[0].idObr + " ] </h3>";
    data_html += " 	  </div>";
    data_html += " 	  <div class='panel-body'>";
    data_html += " 	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";

    for(var i=0;i<aps.length;i++){
        data_html += "   <div class='panel panel-success'>";
        data_html += "     <div class='panel-heading' role='tab' id='heading" + aps[i].idAps + "'>";
        data_html += "       <h4 class='panel-title'>";
        data_html += "        <a data-toggle='collapse' data-parent='#accordion' href='#collapse" + aps[i].idAps + "' aria-expanded='true' aria-controls='collapseOne'>";
        data_html += "      Autorizaci&oacute;n de Pago " + aps[i].idAps + " [+]";
        data_html += "        </a>";
        data_html += "       </h4>";
        data_html += "     </div>";
        data_html += "    <div id='collapse" + aps[i].idAps + "' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading" + aps[i].idAps + "'>";
        data_html += "     <div class='panel-body'>";
        data_html += "      <table class='table table-hover table-bordered'>";
        data_html += "          <thead>";
        data_html += "              <tr class='success'>";
        data_html += "                  <td>Autorizaci&oacute;n de pago</td>";
        data_html += "                  <td>Tipo de Autorizaci&oacute;n de Pago</td>";
        data_html += "                  <td>Nombre de la Obra</td>";
        data_html += "                  <td>Monto</td>";
        data_html += "                  <td>Estado de la Autorizaci&oacute;n de Pagos</td>";
        data_html += "              </tr>";
        data_html += "          </thead>";
        data_html += "          <tbody>";
        data_html += "              <tr>";
        data_html += "                  <td>"+aps[i].idAps+"</td>";
        data_html += "                  <td>"+aps[i].NomTipAps+"</td>";
        data_html += "                  <td>"+aps[i].NomObr+"</td>";
        data_html += "                  <td><p align=right>"+number_format(aps[i].Monto,2)+"</p></td>";
        data_html += "                  <td>"+aps[i].NomEdoAps+"</td>";
        data_html += "              </tr>";
        data_html += "          </tbody>";
        data_html += "      </table>";
        data_html += "     </div>";
        data_html += "     </div>";
        data_html += "   </div>";
    }
    data_html += " 	</div>";
    data_html += " 	  </div>";
    data_html += " 	</div>";

    $("#solCollapse").html(data_html);
    
    $('#solCollapse').collapse({
        toggle: false
    });
    $("#collapse" + aps[0].idAps).removeClass("off").addClass("in");
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