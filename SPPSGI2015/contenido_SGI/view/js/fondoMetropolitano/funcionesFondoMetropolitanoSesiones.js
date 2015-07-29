var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

$(document).ready(function () {
    
    comboEjercicio();
    
    cargarGridSesiones();
    
    $("#fecha").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);
    
    $("#ejercicio").change(function(){
        cargarGridSesiones();
    });
    
    $("#btnGuardarSesion").click(function(){
        validaSesion();
    });
});


function validaSesion(){
    var ejercicio = $("#ejercicio").val();
    var fecha = $("#fecha").val();
    var sesion = $("#sesion").val();
    if(ejercicio == 0){
        bootbox.alert('seleccione un ejercicio');
        return false;
    }
    if(fecha.length==0){
        bootbox.alert('Ingrese una fecha');
        return false;
    }
    if(sesion==""){
        bootbox.alert('Ingrese un texto en el campo sesi\u00f3n');
        return false;
    }
    
    guardaSesion(ejercicio, fecha, sesion);        
    
}

function guardaSesion(ejercicio, fecha, sesion){
    $.ajax({
        data: {
            accion: 'guardaSesion',
            ejercicio: ejercicio,
            fecha: fecha,
            sesion: sesion
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Guardar Sesion');
        },
        success: function (response) {            
            //console.log(response);
            var info = jQuery.parseJSON(response);
            if(info.result){
                bootbox.alert('Informaci\u00f3n guardada correctamente');
                
                cargarGridSesiones();
            }
            else{
                bootbox.alert('Error al guardar la informaci\u00f3n intentelo nuevamente');
            }
                        
        }
    });
}

function cargarGridSesiones(){
    
    var ejercicio = $("#ejercicio").val();
    
    if(!ejercicio){
        ejercicio = 0;
    }  
    
    $.ajax({
        data: {
            accion: 'infoGridSesiones',
            ejercicio: ejercicio            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Grid Sesiones');
        },
        success: function (response) {            
            console.log(response);
            var info = jQuery.parseJSON(response);
            
            if(info.result){
                var gridHtml = '';
                
                $.each(info.grid, function( index, value ) {                    
                    gridHtml +=  "<tr>";                    
                    gridHtml += "<td>"+value.Ejercicio+"</td>";
                    gridHtml += "<td>"+value.FecSes+"</td>";
                    gridHtml += "<td>"+value.NomSes+"</td>";                    
                    gridHtml += "<td><button type='button' class='btn btn-danger' onclick=\"borrarSesion('"+value.IdSesion+"')\">Borrar</button></td>";
                    gridHtml += "<tr>";                    
                });
                
                $("#infoSesiones").html(gridHtml);
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

function borrarSesion(idSesion){
    bootbox.confirm("se va a borrar la sesi\u00f3n ¿desea continuar? " , function(result) {
        
        if(result){
            $.ajax({
                data: {
                    accion: 'borrarSesion',
                    idSesion: idSesion
                    
                },
                url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
                type: 'post',
                beforeSend: function () {
                    //para seguir el debug
                    console.log('Evento:: Combo Ejercicio');
                },
                success: function (response) {            
                    console.log(response);
                    var info = jQuery.parseJSON(response);
                    if(info.exist){
                        bootbox.alert('No se puede borrar, existen oficios generados que contienen la sesi\u00f3n');
                    }
                    cargarGridSesiones();

                }
            });
        }
        
    }); 
}