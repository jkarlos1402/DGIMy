$(document).ready(function () {
   
   $("#infoGral").click(function(){
       $("#infoGralChild").toggle();
   });
   
   $("#limpiar").click(function(){
       location.reload();
   });
  
   $("#mostrarSolicitud").click(function(){
       if($("#idObra").val()==""){
           bootbox.alert('Ingresa un numero de Obra');
           return false;
       }
       
       var idObra = $("#idObra").val();
        $.ajax({
            data:  {
                accion : 'obtenerSolObra',
                idObra: idObra
            },
            url:   'contenido_sgi/controller/oficios/oficiosController.php',
            type:  'post',
            beforeSend: function () {                    
                //para seguir el debug
                console.log('Evento:: Buscar obtenerSolObra');
            },
            success:  function (response) {                                        
                console.log(response);
                //$("#infoFuentes").html(response);
                var info = jQuery.parseJSON(response);                
                
                if(info.result){
                    getSolicitud(info.idSol);
                    getHistoricoSolicitudes(idObra, info.idSol);
                    //console.log(info.idSol);
                    
                }
                else{
                    bootbox.alert('No existen solicitudes para este numero de Obra');
                    return false;
                }

            }
        });
       
   });
             
});


function getSolicitud(idSol){
    $.ajax({
        data:  {
            accion : 'getInfoSol',
            idSol: idSol   
        },
        url:   'contenido_sgi/controller/oficios/oficiosController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento:: getInfoSol');
        },
        success:  function (response) {                                        
            //console.log(response);
            var info = jQuery.parseJSON(response);                
            if(info.infoSol){
                console.log(info.infoSol)
                $("#ejercicio").val(info.infoSol[0].Ejercicio);
                $("#monto").val(info.infoSol[0].Monto);
                $("#modEje").val(info.infoSol[0].NomModEje);
                $("#tipoObr").val(info.infoSol[0].NomTipObr);
                $("#numObra").val(info.infoSol[0].IdObr);
                $("#obra").val(info.infoSol[0].NomObr);
                $("#ue").val(info.infoSol[0].NomUE);
                $("#ur").val(info.infoSol[0].NomSec);
                $("#tipSol").val(info.infoSol[0].NomSolPre);                                        
            }
        }
    }); 

    $.ajax({
        data:  {
            accion : 'getInfoSolFtes',
            idSol: idSol
        },
        url:   'contenido_sgi/controller/oficios/oficiosController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento:: getInfoSolFtes');
        },
        success:  function (response) {                                        
            console.log(response);
            $("#infoFuentes").html(response);
            //var info = jQuery.parseJSON(response);                

        }
    });
}

function llenarInfOficio(idSol, idFte){
            
    $("#DocumentoF").dialog({
        autoOpen: true,
        height: 550,
        width: 725,
        modal: true,
        resizable: false,
        buttons: [                              
            {
                id: "button-cerrar",
                text: "Cerrar",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                id: "button-guardar",
                text: "Guardar Oficio",
                click: function() {
                    guardarOficio(idSol, idFte);
                }
            }           
        ],                          
        close: function() {              
          //
        }
    });
    $(".ui-dialog-titlebar").hide();
    //$("#botonOficio").hide();
    $("#DocumentoF").ready(function() {
        //cargaInfoDialog();
    });
            
}

function guardarOficio(idSol, idFte){
    
    $("#idSolPdf").val(idSol);
    $("#idFtePdf").val(idFte);
    //se cambia la bandera para imprimir oficio general o por fuente
    $("#oficioGeneral").val(0);
    
    //$("#postPdf").submit();
    $.ajax({
        data:  {
            accion : 'guardarOficio',
            idSol: idSol,
            idFte: idFte,
            titular :   $("#titular").val(),
            asunto  :   $("#asunto").val(),
            ccp     :   $("#ccp").val(),
            prefijo :   $("#prefijo").val(),
            refer   :   $("#refer").val(),
            tat     :   $("#tat").val(),
            texto   :   $("#texto").val(),        
            idObr: $("#numObra").val(),
            ejercicio: $("#ejercicio").val(),
            tipImpOfi: 'fuente',             
        },
        url:   'contenido_sgi/controller/oficios/oficiosController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento:: guardar Oficio');
        },
        success:  function (response) {                                        
            console.log(response);
            //$("#contenidoFormPdf").html(response);
            //var info = jQuery.parseJSON(response);                
            $("#postPdf").submit();

        }
    });
}

function guardarOficioGeneral(idSol){
    $("#idSolPdf").val(idSol);
    $("#idFtePdf").val();
    //se cambia la bandera para imprimir oficio general o por fuente
    $("#oficioGeneral").val(1);
    
    $("#postPdf").submit();
    
}    

function getHistoricoSolicitudes(idObra, idSol){
    
    $.ajax({
        data:  {
            accion : 'getHistoricoSolicitudes',
            idObra: idObra,
            idSol: idSol
        },
        url:   'contenido_sgi/controller/oficios/oficiosController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento:: getHistoricoSolicitudes');
        },
        success:  function (response) {                                                                                                    
            $("#infoHistorial").html(response);            
        }
    });
}

function verInfoSolHist(idObra, idSol){
    //alert(idObra + ' -- ' + idSol);
    getSolicitud(idSol);
    getHistoricoSolicitudes(idObra, idSol);
}


function oficioGeneral(idSol){
    
    
    
    $("#DocumentoF").dialog({
        autoOpen: true,
        height: 550,
        width: 725,
        modal: true,
        resizable: false,
        buttons: [                              
            {
                id: "button-cerrar",
                text: "Cerrar",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                id: "button-guardar",
                text: "Guardar Oficio",
                click: function() {
                    
                    guardarOficioGeneral(idSol);
                }
            }           
        ],                          
        close: function() {              
          //
        }
    });
    $(".ui-dialog-titlebar").hide();
    //$("#botonOficio").hide();
    $("#DocumentoF").ready(function() {
        //cargaInfoDialog();
    });            
}