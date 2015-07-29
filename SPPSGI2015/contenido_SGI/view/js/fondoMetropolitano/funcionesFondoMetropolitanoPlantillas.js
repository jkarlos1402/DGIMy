
$(document).ready(function () {
    
    comboEjercicio();
    comboFuente();
    comboTipOficio();
    
    $("#btnGuardarPlantilla").click(function(){
        guardaPlantilla();
    });
    
    
    $("#ejercicio, #fuente, #tipOfi").change(function(){
        cargarPlantilla();
    });
    
});

function cargarPlantilla(){
    
    var ejercicio = $("#ejercicio").val();
    var fuente = $("#fuente").val();
    var tipOfi = $("#tipOfi").val();
    
    if(ejercicio!=0 && fuente!=0 && tipOfi!=0){
        $.ajax({
            data: {
                accion: 'cargarPlantillaOficio',
                ejercicio: ejercicio,
                fuente: fuente,
                tipOfi: tipOfi
            },
            url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: cargar Plantilla Oficio');
            },
            success: function (response) {            
                
                //console.log(response);
                var info = jQuery.parseJSON(response);
                
                if(info.result){
                    $("#texto").html(info.plantilla[0].TxtOfi);
                }
                else{
                    $("#texto").html('');
                }                                
            }
        });
    }
    else{
        $("#texto").html('');
    }
}

function guardaPlantilla(){
    var ejercicio = $("#ejercicio").val();
    var fuente = $("#fuente").val();
    var tipOfi = $("#tipOfi").val();
    var txt = $("#texto").val();    
    
    if(ejercicio==0){
        bootbox.alert('Por favor, seleccione un ejercicio');                
        return false;
    }
    if(fuente==0){
        bootbox.alert('Por favor, seleccione una fuente');                
        return false;
    }
    if(tipOfi==0){
        bootbox.alert('Por favor, seleccione un tipo de Oficio');                
        return false;
    }
    
    if(txt==""){
        bootbox.alert('Por favor, ingrese un texto');                
        return false;
    }
    
    $.ajax({
        data: {
            accion: 'guardarPlantilla',
            ejercicio: ejercicio,
            fuente: fuente,
            tipOfi: tipOfi,
            texto: txt
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Guardar Plantilla');
        },
        success: function (response) {            
            console.log(response);
            var info = jQuery.parseJSON(response);                        
            if(info.result){
                bootbox.alert('Se guard\u00f3 la informaci\u00f3n de plantilla');                
            }
            else{
                bootbox.alert('Problema al guardar, por favor intentelo nuevamente');                
            }
            
        }
    });
    
    
    
}

function comboEjercicio(){    
    
    $.ajax({
        data: {
            accion: 'comboEjercicio'            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo Ejercicio');
        },
        success: function (response) {            
            //console.log(response);
            var info = jQuery.parseJSON(response);
            
            $("#ejercicio").html(info.ejercicio);
                        
        }
    });
}

function comboFuente(){    
    
    $.ajax({
        data: {
            accion: 'comboFuente'            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo Fuente');
        },
        success: function (response) {            
            //console.log(response);
            var info = jQuery.parseJSON(response);
            
            $("#fuente").html(info.fuente);
                        
        }
    });
}

function comboTipOficio(){
    
   $.ajax({
        data: {
            accion: 'comboTipOficio'            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo TipOficio');
        },
        success: function (response) {            
            console.log(response);
            var info = jQuery.parseJSON(response);
            
            $("#tipOfi").html(info.catTipOfi);
                        
        }
    }); 
}