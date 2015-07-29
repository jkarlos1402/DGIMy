var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

var resultProy = false;
var GlobEjercicio='';
var GlobClave='';
var GlobIdDetFon = 0;
$(document).ready(function () {
    
    $("#fecha").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);
    
    $('#monto').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
    
    comboEjercicio();
    
    $("#btnAgregar").click(function(){
        agregarDepositos();
    });
    
    $("#btnQuitar").click(function(){
        quitarDepositos();
    });
    
    $("#btnGuardarDepositos").click(function(){
        guardarDepositos();
    });
    
    $("#ejercicio").change(function(){
        getProyecto();
    });
    
    $("#clave").keyup(function(){
        getProyecto();
    });
    
});

function getProyecto(){
    var clave = $("#clave").val();
    var ejercicio = $("#ejercicio").val();
    
    if(ejercicio!=0){
        
        if(clave!=""){
            
            $.ajax({
                data: {
                    accion: 'getDetalleFonMet',
                    ejercicio: ejercicio,
                    cvePry: clave
                },
                url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
                type: 'post',
                beforeSend: function () {
                    //para seguir el debug
                    console.log('Evento:: Guardar Depositos');
                },
                success: function (response) {

                    console.log(response);
                    var info = jQuery.parseJSON(response);
                    
                    if(info.result){
                        $("#proyecto").val(info.detFonMet[0].NomPry);
                        resultProy=true;
                        GlobClave=clave;
                        GlobEjercicio=ejercicio;
                        GlobIdDetFon= info.detFonMet[0].IdDetFon;
                        
                        obtenerDepositos(GlobIdDetFon);
                        
                    }
                    else{
                        limpiarCampos();
                    }
                }
            });
            
        }  
        else{
            limpiarCampos();
        }
    }
    else{
        limpiarCampos();
    }    
    
    /*setTimeout(function(){
    console.log('Clave: '+GlobClave + ' Ejercicio: '+GlobEjercicio + ' Busqueda: ' + resultProy);},1000);*/
    
    
}

function obtenerDepositos(IdDetFon){
    $.ajax({
        data: {
            accion: 'getDepositosDet',            
            idDetFon: IdDetFon
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Obtener Depositos');
        },
        success: function (response) {
            //console.log(response);            
            var info = jQuery.parseJSON(response);
            
            if(info.result){
                var row = '';
                $("#tabladepositosbody").html('');
                $.each(info.depositos, function( index, value ) {
                    //console.log(value.FecDep + value.Monto);
                                        
                    montoParse = parseFloat(value.Monto).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        
                    row += "<tr>";
                    row += "    <td width='50px'><input type='checkbox' name='option' /></td>";
                    row += "    <td width='170px' class='FechaTotal'>"+value.FecDep+"</td>";
                    row += "    <td width='200px' style='text-align: right' class='MontosTotal'>"+montoParse+"</td>";    
                    row += "</tr>";
                        
                });                
                
                $("#tabladepositosbody").append(row);
                
                calcularTotal();
            }
            
        }
    });
}

function limpiarCampos(){
    $("#proyecto").val('');
    resultProy=false;
    GlobClave='';
    GlobEjercicio='';
    GlobIdDetFon=0;
    $("#tabladepositosbody").html('');
    $("#etiquetaDepositos").html('0');
    $("#etiquetaTotal").html('0.0');
}

function guardarDepositos(){
    
    if(!resultProy){
        bootbox.alert('Seleccione un Proyecto al que se aplicaran los depositos');                
        return false;
    }
    
    var datos = new Array();
    
    $('.FechaTotal').each(function(){
        
        var montoCelda = $(this).parent().find('.MontosTotal').html();
        var dato={            
            'fecha': $(this).html(),
            'monto': montoCelda.replace(/,/g,'')
        }
        
        datos.push(dato);
    });
    
    if(datos.length>0){
        $.ajax({
            data: {
                accion: 'guardarDepositos',
                datos: datos,
                idDetFon: GlobIdDetFon
            },
            url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Guardar Depositos');
            },
            success: function (response) {

                console.log(response);
                bootbox.alert('depositos guardados correctamente');                
                //var info = jQuery.parseJSON(response);
                
            }
        });
    }
    else{
        bootbox.alert('Ingrese por lo menos un deposito');                
        return false;
    }
    
    
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

function agregarDepositos(){
    
    var fecha = $("#fecha").val();
    var monto = $("#monto").val();
    if(monto==''){
        bootbox.alert('Ingrese un monto');                
        $("#monto").focus();
        return false;
    }
    monto = monto.replace(/,/g,'');        
    montoParse = parseFloat(monto).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    
    var row = '';
    row += "<tr>";
    row += "    <td width='50px'><input type='checkbox' name='option' /></td>";
    row += "    <td width='170px' class='FechaTotal'>"+fecha+"</td>";
    row += "    <td width='200px' style='text-align: right' class='MontosTotal'>"+montoParse+"</td>";    
    row += "</tr>";
    
    $("#tabladepositosbody").append(row);
        
    $("#monto").val('');
    
    calcularTotal();        
    
}

function quitarDepositos(){        
    bootbox.confirm("se van a eliminar los depositos, \u00BFdesea continuar? " , function(result) {        
        if(result){
            $('input[name=option]:checked').each(function(){
                $(this).parent().parent().remove();
            });
            calcularTotal();        
        }
    });    
    
}


function calcularTotal(){
    var Total = 0;
    var depositos = 0;
    $('.MontosTotal').each(function(){
        var valor = $(this).html();
        monto = valor.replace(/,/g,'');        
        
        Total = parseFloat(Total) + parseFloat(monto);                
                        
        depositos++;        
    }); 
    
    Total = parseFloat(Total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    
    $("#etiquetaDepositos").html('<b>'+depositos+'</b>');
    $("#etiquetaTotal").html('<b>'+Total+'</b>');
    
}