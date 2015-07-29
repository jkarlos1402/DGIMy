$(document).ready(function () {
    tablaSolicitudes = $('#tablaObservaciones').DataTable({"retrieve": true, "ordering": true, "sPaginationType": "bootstrap",
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
       buscarSolicitudes();
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

function buscarSolicitudes() {
    var fecIni = $("#fecIni").val();
    var fecFin = $("#fecFin").val();
    $.ajax({
        data: {accion: 'getSolicitudesPorDependencia', 'fecIni':fecIni, 'fecFin':fecFin},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
//            console.log(response);
            var solicitudes = $.parseJSON(response);
            tablaSolicitudes.clear().draw();
            var icono = "";
            var onclick="";
            for (var i = 0; i < solicitudes.length; i++) {
                if(solicitudes[i].NumObs!="0"){
                    onclick="onclick='buscarObservaciones("+solicitudes[i].idSol+","+solicitudes[i].Reingreso+")'";
                }else{
                    onclick="";
                }
                switch (solicitudes[i].idEdoSol) {
                    case "5":
                        icono = "<span style='cursor:pointer;' "+onclick+" class='badge alert-danger'>"+solicitudes[i].NumObs+"</span>";
                        break;
                    case "6":
                        icono = "<span style='cursor:pointer;' "+onclick+"' class='badge alert-success'>"+solicitudes[i].NumObs+"</span>";
                        break;
                    default:
                        icono = "<span style='cursor:pointer;' "+onclick+" class='badge alert-warning'>"+solicitudes[i].NumObs+"</span>";
                        break;
                }
                tablaSolicitudes.row.add([solicitudes[i].idSol,solicitudes[i].NomSolPre,solicitudes[i].NomObr, solicitudes[i].NomEdo, icono]).draw();
            }
            eliminaWaitGeneral();
        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });

}

function buscarObservaciones(idsol,Reingreso) {

    $.ajax({
        data: {accion: 'getObservaciones', idSol: idsol},
        url: "contenido_SGI/controller/expedienteTecnico/expedienteTecnicoController.php",
        type: "POST",
        success: function (response) {
//            console.log(response);
            var obs = $.parseJSON(response);
            crearAcordion(obs,Reingreso);

        },
        error: function (response) {
            console.log("Errores::", response);
        }
    });
}

function crearAcordion(obs,Reingreso) {
    var reingreso="";
    if(Reingreso=="1"){
        reingreso = "<span class='alert-danger'>REQUIERE REINGRESO</span>";
    }
    data_html = " 	<div class='panel panel-default'>";
    data_html += " 	  <div class='panel-heading'>";
    data_html += " 	    <h3 class='panel-title'>Observaciones ::: Expediente: [ " + obs[0].IdSol + " ] "+reingreso+"</h3>";
    data_html += " 	  </div>";
    data_html += " 	  <div class='panel-body'>";

    data_html += " 	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";

    for(var i=0;i<obs.length;i++){
        data_html += "   <div class='panel panel-success'>";
        data_html += "     <div class='panel-heading' role='tab' id='heading" + obs[i].IdEva + "'>";
        data_html += "       <h4 class='panel-title'>";
        data_html += "        <a data-toggle='collapse' data-parent='#accordion' href='#collapse" + obs[i].IdEva + "' aria-expanded='true' aria-controls='collapseOne'>";
        data_html += "      Observaci&oacute;n " + obs[i].IdEva + " [+]";
        data_html += "        </a>";
        data_html += "       </h4>";
        data_html += "     </div>";
        data_html += "    <div id='collapse" + obs[i].IdEva + "' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading" + obs[i].IdEva + "'>";
        data_html += "     <div class='panel-body'>";
        data_html += obs[i].FecEva + ' ' + obs[i].ObsDgi;
        data_html += "     </div>";
        data_html += "     </div>";
        data_html += "   </div>";
    }
    
    data_html += " 	</div>";
    data_html += " 	  </div>";
    data_html += " 	</div>";

    $("#obsCollapse").html(data_html);
    
    $('#obsCollapse').collapse({
        toggle: false
    });
    $("#collapse" + obs[0].IdEva).removeClass("off").addClass("in");
}