 /*
 @Modulo "Autorizacion Presupuestal"
 @Control "Control de Templates de oficios"
 @versión: 0.1      
 @modificado: 16 de Diciembre del 2014
 @autor: Giovanni Estrada Aleman
*/

$(document).ready(function (){
    
    cargarCombos();    
    
    $("#guardarC").click(function(){
        
        var vc = validaCampos();
        if(vc){
            guardaTemplate();
        }
    });
    
    $("#etiquetaTotal").click(function (){
        var txt = $("#fundamento").val();
        if(txt.indexOf('<<<Total>>>') != -1){
            alert('Ya se encuentra una etiqueta para el total');
            $("#fundamento").focus();
            return false;
        }
        else{
            $("#fundamento").val($("#fundamento").val() + '<<<Total>>>');
        }
    });
    
    $("#tipo").change(function (){
        revisaTemplate();
    });
    
    $("#ejercicio").change(function (){
        revisaTemplate();
    });
    
    $("#fuente").change(function (){
        revisaTemplate();
    });
    
    $("#inversion").change(function (){
        revisaTemplate();
    });
    
    $("#recursos").change(function (){
        revisaTemplate();
    });
    
});

function guardaTemplate(){
    
    $.ajax({   
        data: {
            accion: 'guardarTemplateOficio',
            tipo: $("#tipo").val(),
            ejercicio: $("#ejercicio").val(),            
            fuente: $("#fuente").val(),            
            asunto: $("#asunto").val(),
            prefijo: $("#prefijo").val(),
            fundamento: $("#fundamento").val(),
            complemento: $("#complemento").val()
        },
        url:   'contenido_SGI/controller/oficios/funcionesAutorizacionController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento:: Guardar Template');                        
            
        },
        success:  function (response) {                                                                  
            console.log(response);                                                                
            var info = jQuery.parseJSON(response);                          
            if(info.resultado){                
                limpiaCampos();
                alert('Template No: ' + info.idTxt + '\nguardado correctamente');                
            }
            else{
                alert('ocurrio un problema al ingresar el registro');
            }
        },                
        error: function(response) {                    
            console.log("Errores::", response);
        }                
    });
    
}

function validaCampos(){
    
    if($("#tipo").val()==0){
        alert('Selecciona un tipo de documento');
        $("#tipo").focus();
        return false;
    }
    
    if($("#ejercicio").val()==0){
        alert('Selecciona un ejercicio');
        $("#ejercicio").focus();
        return false;
    }
  
    
    if($("#asunto").val().length<1){
        alert('Ingresa un texto en el asunto');
        $("#asunto").focus();
        return false;
    }    
    
    if($("#prefijo").val().length<1){
        alert('Ingresa un texto en el prefijo');
        $("#prefijo").focus();
        return false;
    }    
    
    if($("#fundamento").val().length<1){
        alert('Ingresa un texto en el fundamento');
        $("#fundamento").focus();
        return false;
    }
    
    if($("#complemento").val().length<1){
        alert('Ingresa un texto en el complemeto');
        $("#fundamento").focus();
        return false;
    }
    
    if($("#fundamento").val().indexOf('<<<Total>>>') == -1){
        alert('se debe incluir la etiqueta total en el contenido del texto del fundamento');
        $("#fundamento").focus();
        return false;
    }
    
    
    return true;
}

function cargarCombos(){
    $.ajax({   
        data: {accion: 'cargarCombos'},
        url:   'contenido_SGI/controller/oficios/funcionesAutorizacionController.php',
        type:  'post',
        beforeSend: function () {                    
            //para seguir el debug
            console.log('Evento::Cargar Combos');
        },
        success:  function (response) {                                                                  
            //console.log(response);
            var info = jQuery.parseJSON(response);                          
            //console.log(info)                     
            $('#ejercicio').append(info.ejercicios);
            $('#fuente').append(info.catFuentes);            
            $('#tipo').append(info.tipOficios);                        
                                                    
        },                
        error: function(response) {                    
            console.log("Errores::", response);
        }                
    });
}

function revisaTemplate(){
    if($("#tipo").val()!= 0 && $("#ejercicio").val()!= 0){
        var parametros = {
            accion : 'consultaTemplateOficio',
            tipOficio: $("#tipo").val(),
            ejercicio: $("#ejercicio").val(),
            fuente: $("#fuente").val(),
            recurso: '',        
            inversion: ''   
        };

        $.ajax({
            data:  parametros,
            url:   'contenido_SGI/controller/oficios/funcionesAutorizacionController.php',
            type:  'post',
            beforeSend: function () {                    
                //para seguir el debug
                console.log('Evento::Template oficio');
            },
            success:  function (response) {                                        
                //console.log('Reponse Template Oficio::' + response);                       
                
                //se recupera la informacion en formato JSON
                var info = jQuery.parseJSON(response);                                       
                //console.log(info);
                //se recorren los elementos del arregle obtenido
                if(info['resultado']){                
                        //console.log('llega'+info.informacion);                                                
                        $("#asunto").val(info.informacion.AsuOFi);                    
                        $("#prefijo").val(info.informacion.PfjOfi);                                                                            
                        $("#fundamento").val(info.informacion.fundamento);
                        $("#complemento").val(info.informacion.complemento);
                        
                }                
                else{
                    $("#asunto").val('');                    
                    $("#prefijo").val('');                                                                            
                    $("#fundamento").val('');
                    $("#complemento").val('');
                }                
            },                
            error: function(response) {                    
                console.log("Errores::", response);
            }                
        });                            
    }
}

function limpiaCampos(){
    $("#tipo option[value=0]").attr("selected",true);
    $("#ejercicio option[value=0]").attr("selected",true);
    $("#fuente option[value=0]").attr("selected",true);
    //$("#inversion option[value=0]").attr("selected",true);
    //$("#recursos option[value=0]").attr("selected",true);
    $("#asunto").val('');
    $("#prefijo").val('');
    $("#fundamento").val('');
    $("#complemento").val('');
}
