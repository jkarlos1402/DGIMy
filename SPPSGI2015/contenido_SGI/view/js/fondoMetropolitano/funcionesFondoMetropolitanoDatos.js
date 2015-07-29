var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

var tipoConsulta = '';
var GlobCvePry = '';
var GlobIdFonMet = '';
var GlobIdDetFonMet = '';
$(document).ready(function () {
    
    $("#btnNuevoEjercicio").hide();
    $("#btnModificarDatos").hide();
    $("#opcionAlta").prop('checked',true);                   
    
    comboEjercicio();
    comboFuente();
    comboSector();
    comboGrupoSocial();
    
    $("#btnGuardarDatos, #btnNuevoEjercicio, #btnModificarDatos").click(function(){
        validaDatos();
    });        
    
    $("#opcionAlta, #limpiar").click(function(){
        location.reload();
    });
    
    $("#opcionNuevoEjercicio").click(function(){
        $("#inputBuscar").show();
        $("#contenedorEjercicio").hide();
        $("#btnNuevoEjercicio").show();
        $("#btnModificarDatos").hide();
        $("#btnGuardarDatos").hide();
        deshablitaCampos();
    });
    
    $("#opcionModificar").click(function(){
        $("#inputBuscar").show();
        $("#contenedorEjercicio").show();
        $("#btnModificarDatos").show();
        $("#btnNuevoEjercicio").hide();
        $("#btnGuardarDatos").hide();
        deshablitaCampos();
    });
    
    $("#mostrarFM").click(function(){
        
        if($("#cveFondoMetropolitano").val()==""){
            bootbox.alert('Ingrese una clave a buscar');                
            return false;
        }        
        
        var opcionRadio = $('input[name=opciones]:checked').val();
        if(opcionRadio == 'modificar'){
            modificarDatos();
        }
        else{
            nuevoEjercicio();
        }        
    });
    
    $("#avanceFisico").autoNumeric({ mDec: '0', vMin: '0', vMax:100});
});

function modificarDatos(){
    tipoConsulta='modificar';    
    var cvePry = $("#cveFondoMetropolitano").val();
    var ejercicio = $("#ejercicioBusqueda").val();
    
    if(ejercicio==0){
        bootbox.alert('Selecciones un ejercicio a buscar');                
        return false;
    }
        
    $.ajax({
        data: {
            accion: 'getDetalleFonMet',
            cvePry: cvePry,
            ejercicio: ejercicio
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Obtener informacionpara modificar datos');
        },
        success: function (response) {            
            //console.log(response);                                                
            
            var info = jQuery.parseJSON(response);
            
            if(info.result){   
                var myRes = info.detFonMet[0];
               $('#fuente option[value=' + myRes.IdFte + ']').prop('selected', 'selected').change();                                              
               $("#proyecto").val(myRes.NomPry);               
               $('#ejercicio option[value=' + myRes.Ejercicio + ']').prop('selected', 'selected').change();                                              
               $('#sector option[value=' + myRes.IdSec + ']').prop('selected', 'selected').change();                                              
                setTimeout(function(){
                    $('#ue option[value=' + myRes.IdUE + ']').prop('selected', 'selected').change();                                              
                }, 1000);
               
               $('#grupoSocial option[value=' + myRes.IdGpo + ']').prop('selected', 'selected').change();                                              
               
               $("#observaciones").val(myRes.ObsFon);               
               $("#avanceFisico").val(myRes.AvaFis);               
               
               if(myRes.Terminado==1){
                   $("#terminado").prop('checked',true);                   
               }else{
                   $("#terminado").prop('checked',false);                   
               }
                
               $("#fuente, #proyecto ").attr("disabled",false);
               
               GlobCvePry= cvePry;
               GlobIdFonMet = myRes.IdFonMet;
               GlobIdDetFonMet = myRes.IdDetFon;
               
               console.log(GlobIdDetFonMet + GlobIdFonMet);
               
                habilitaCampos();
               
            }
            else{
                bootbox.alert('No se encontro informaci\u00f3n para la Clave:  ' + cvePry );                
                GlobCvePry= '';
                GlobIdFonMet = '';
                GlobIdDetFonMet = '';
                deshablitaCampos();
            }
                
        }
    });
}

function nuevoEjercicio(){
    tipoConsulta='nuevoEjercicio';
    
    var cvePry = $("#cveFondoMetropolitano").val();
    $.ajax({
        data: {
            accion: 'getInfopFonMet',
            cvePry: cvePry
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Recuperar informacion nuevo ejercicio');
        },
        success: function (response) {            
            //console.log(response);            
            var info = jQuery.parseJSON(response);
            
            if(info.result){   
                habilitaCampos();
                
               var myRes = info.pFonMet[0];
               $('#fuente option[value=' + myRes.IdFte + ']').prop('selected', 'selected').change();                                              
               $("#proyecto").val(myRes.NomPry);               
               
               $("#fuente, #proyecto ").attr("disabled",true);
               GlobCvePry= cvePry;
               GlobIdFonMet = myRes.IdFonMet;
               GlobIdDetFonMet = '';
               
                
               
            }
            else{
                deshablitaCampos();
                bootbox.alert('No se encontro informaci\u00f3n para la Clave:  ' + cvePry );                
                GlobCvePry= '';
                GlobIdFonMet = '';
                GlobIdDetFonMet = '';
            }
        }
    });
    
}

function validaDatos(){
    var idFte = $("#fuente").val(); //obligatorio
    var nomPry = $("#proyecto").val(); //obligatorio
    var ejercicio = $("#ejercicio").val(); //obligatorio
    var idUE = $("#ue").val(); //obligatorio
    
    var avanceFisico = $("#avanceFisico").val(); 
    var observaciones = $("#observaciones").val(); 
    var grupoSocial = $("#grupoSocial").val(); 
    var terminado = 0;
    if($("#terminado").prop('checked')){
        terminado = 1;
    }    
    
    if(idFte==0){
        bootbox.alert('Seleccione una Fuente');
        return false;
    }
    
    if(nomPry==""){
        bootbox.alert('Ingrese un texto en el campo Proyecto');
        return false;
    }
    
    if(ejercicio==0){
        bootbox.alert('Seleccione un ejercicio');
        return false;
    }
    
    if ((!idUE) || (idUE==0)){
        bootbox.alert('Seleccione una Unidad Ejecutora');
        return false;
    }                   
    
    if(tipoConsulta=='nuevoEjercicio'){
        guardaNuevoEjercicio(GlobIdFonMet, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado);
    }
    else if(tipoConsulta=='modificar'){
        guardarModificarDatos(GlobIdFonMet,GlobIdDetFonMet,GlobCvePry,idFte, nomPry, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado);
    }
    else{
        guardarDatos(idFte, nomPry, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado);
    }    
}

function guardaNuevoEjercicio(GlobIdFonMet, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado){
    datos = {
        idFonMet: GlobIdFonMet,                
        ejercicio: ejercicio,
        idUe: idUE,
        avanceFisico: avanceFisico,
        observaciones: observaciones,
        grupoSocial: grupoSocial,
        terminado: terminado
    };
    
    $.ajax({
        data: {
            accion: 'guardarNuevoEjercicio',
            datos: datos
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Guardar Nuevo Ejercicio');
        },
        success: function (response) {            
            //console.log(response);            
            var info = jQuery.parseJSON(response);
            if(info.result){
                bootbox.alert('Ejercicio guardado correctamente para el proyecto: '+GlobCvePry);                                
            }
            else{
                bootbox.alert('Problema al guardar, por favor intentelo nuevamente');                                
            }
                        
        }
    });
}

function guardarModificarDatos(GlobIdFonMet,GlobIdDetFonMet,GlobCvePry,idFte, nomPry, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado){
    datos = {
        idFonMet: GlobIdFonMet, 
        idDetFon: GlobIdDetFonMet,
        cveProy: GlobCvePry,
        idFte: idFte,
        nomPry: nomPry,
        ejercicio: ejercicio,
        idUe: idUE,
        avanceFisico: avanceFisico,
        observaciones: observaciones,
        grupoSocial: grupoSocial,
        terminado: terminado
    };
    
    $.ajax({
        data: {
            accion: 'guardarModificarDatos',
            datos: datos
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Guardar Modificar Datos');
        },
        success: function (response) {            
            console.log(response);            
            
            var info = jQuery.parseJSON(response);
            if(info.result){
                GlobCvePry = info.cvePry;
                bootbox.alert('Informacion guardada correctamente para el proyecto: '+GlobCvePry);                                
                $("#cveFondoMetropolitano").val(GlobCvePry);
                $("#mostrarFM").click();
            }
            else{
                bootbox.alert('Problema al guardar, por favor intentelo nuevamente');                                
            }
            
        }
    });
}


function guardarDatos(idFte, nomPry, ejercicio, idUE, avanceFisico, observaciones, grupoSocial, terminado){        
    
    datos = {
        idFte: idFte,
        nomPry: nomPry,
        ejercicio: ejercicio,
        idUe: idUE,
        avanceFisico: avanceFisico,
        observaciones: observaciones,
        grupoSocial: grupoSocial,
        terminado: terminado
    };
    
    $.ajax({
        data: {
            accion: 'guardarDatos',
            datos: datos
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Guardar Datos');
        },
        success: function (response) {            
            //console.log(response);            
            var info = jQuery.parseJSON(response);
            if(info.result){
                bootbox.alert('Datos guardados correctamente con la clave '+info.detalle.cveFonMet);                
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
            $("#ejercicioBusqueda").html(info.ejercicio);
        }
    });
}

function comboGrupoSocial(){
    $.ajax({
        data: {
            accion: 'comboGrupoSocial'            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo Grupo Social');
        },
        success: function (response) {            
            //console.log(response);
            var info = jQuery.parseJSON(response);
            
            $("#grupoSocial").html(info.grupoSocial);
                        
        }
    });
}

function comboSector(){    
    
    $.ajax({
        data: {
            accion: 'comboSector'            
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo Sector');
        },
        success: function (response) {            
            //console.log(response);
            var info = jQuery.parseJSON(response);
            
            $("#sector").html(info.sector);
                        
        }
    });
}

function comboUE(){
    var sector = $("#sector").val();
    if(sector!=0){
        $.ajax({
            data: {
                accion: 'comboUE',
                idSector: sector
            },
            url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Combo UE');
            },
            success: function (response) {            
                //console.log(response);
                var info = jQuery.parseJSON(response);

                $("#ue").html(info.ue);

            }
        });
    }
    else{
        $("#ue").html('');
    }
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

function deshablitaCampos(){
    $('#fuente option[value=0]').prop('selected', 'selected').change();                                              
    $("#fuente").attr('disabled',true);
    
    $("#proyecto").val('');
    $("#proyecto").attr('disabled',true);
    
    $('#ejercicio option[value=0]').prop('selected', 'selected').change();                                              
    $("#ejercicio").attr('disabled',true);
    
    $('#sector option[value=0]').prop('selected', 'selected').change();                                              
    $("#sector").attr('disabled',true);        
    
    $("#ue").attr('disabled',true);        
        
    $('#grupoSocial option[value=0]').prop('selected', 'selected').change();                                              
    $("#grupoSocial").attr('disabled',true);
    
    $("#observaciones").val('');
    $("#observaciones").attr('disabled',true);
    
    $("#avanceFisico").val('');
    $("#avanceFisico").attr('disabled',true);
}

function habilitaCampos(){        
        
    $("#ejercicio").attr('disabled',false);        
    $("#sector").attr('disabled',false);            
    $("#ue").attr('disabled',false);                
    $("#grupoSocial").attr('disabled',false);    
    $("#observaciones").attr('disabled',false);        
    $("#avanceFisico").attr('disabled',false);
}