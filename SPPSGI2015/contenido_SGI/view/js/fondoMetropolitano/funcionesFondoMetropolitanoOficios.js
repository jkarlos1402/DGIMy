var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

$(document).ready(function () {
    
    comboEjercicio();
    comboFuente();
    comboTipOficio();
    comboSesion();
    comboSector();        
    
    $("#fecha").datepicker({
        format: "dd-mm-yyyy",
        language: "es"
    }).datepicker("setDate", dd + "-" + mm + "-" + yyyy);
    
    $("#btnAgregar").click(function(){
        agregarMontosGrid();
    });
    
    $("#btnQuitar").click(function(){
        quitarMontosGrid();
    });
    
    $("#btnCargarTextos").click(function(){
        cargarPlantillaOficio();                   
    });
    
    $("#fuente, #ue").change(function(){
        listaProyectos();
    });
        
    $("#btnGuardarOficio").click(function(){
        guardarOficio();
    });
        
    
});

function quitarMontosGrid(){

    
    $( ".agregados" ).each(function( index ) {
        var id = $(this).attr('Id').replace('addcheck_', '');                                
        
        if($(this).prop( 'checked')){                            
            $(this).parent().parent().remove();
            $("#"+id).show();
            $("#monto_"+id).val('');
            $("#check_"+id).prop( 'checked',false);            
        }
                
    });
    
    calcularSuma();        
}

function calcularSuma(){
    var suma = 0;
    var numRows = 0;
    $( ".montosAgregados" ).each(function( index ) {
        var monto = $(this).html();
        suma = parseFloat(suma) + parseFloat(monto.replace(/,/g,''));
        numRows++;
    });
    
    $("#numProyectos").html(numRows);
    $("#totalProyectos").html(parseFloat(suma).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
       
    if(numRows>0){
        deshabilitaCombos();
    }
    else{
        habilitaCampos();
    }
}


function agregarMontosGrid(){
    var error = 0;
    var addRow = "";
    var numRows = 0;
    var suma = 0;
    var rowsHide = new Array();
    
    $( ".rowGrid" ).each(function( index ) {
        var idRow = $(this).attr('Id');
        if($("#check_"+idRow).prop( 'checked')){
            
            if($("#monto_"+idRow).val()<=0 || $("#monto_"+idRow).val()==""){
                error = 1;
            }      
            
            addRow += " <tr class='rowcheck_"+idRow+"'>";
            addRow += "     <td> <input type='checkbox' id='addcheck_"+ idRow +"' class='agregados'></td>";            
            addRow += "     <td>" + $("#cve_"+idRow).html() + "</td>";
            addRow += "     <td>" + $("#nom_"+idRow).html() + "</td>";
            addRow += "     <td style='text-align: right' class='montosAgregados'>" + $("#monto_"+idRow).val() + "</td>";
            addRow += " </tr>";
            
            var monFormat = $("#monto_"+idRow).val();
            
            suma = parseFloat(suma) + parseFloat(monFormat.replace(/,/g,''));
            numRows++;
            
            rowsHide.push(idRow);            
            
        }        
    });
    
    if(numRows==0){
        bootbox.alert('Seleccione por lo menos un proyecto para agregar');                
    }
    
    if(error==1){
        bootbox.alert('Ingrese un monto para los proyectos seleccionados');                
        return false;
    }    
    
    else{        
        $.each(rowsHide, function( index, value ) {
            $("#"+value).hide();
        });    
        
        $("#numProyectos").html(numRows);
        $("#totalProyectos").html(parseFloat(suma).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $("#tablaagregados").html(addRow);                
    }
    
    if(numRows>0){
        deshabilitaCombos();
    }
    else{
        habilitaCampos();
    }
    
}

function deshabilitaCombos(){
    $("#ejercicio").attr('disabled', true);
    $("#fuente").attr('disabled', true);
    $("#tipOfi").attr('disabled', true);
    $("#sesion").attr('disabled', true);    
    $("#sector").attr('disabled', true);
    $("#ue").attr('disabled', true);
}

function habilitaCampos(){
    $("#ejercicio").attr('disabled', false);
    $("#fuente").attr('disabled', false);
    $("#tipOfi").attr('disabled', false);
    $("#sesion").attr('disabled', false);    
    $("#sector").attr('disabled', false);
    $("#ue").attr('disabled', false);
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

function comboSesion(){
    var ejercicio = $("#ejercicio").val();
    $.ajax({
        data: {
            accion: 'comboSesion',
            ejercicio: ejercicio
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: Combo Sesion');
        },
        success: function (response) {            
            console.log(response);
            var info = jQuery.parseJSON(response);
            if(info.result){
                $("#sesion").html(info.catSesion);
            }
            else{
                $("#sesion").html("<option value='0'>No existe sesion para el ejercicio "+ejercicio+"</option>");
            }
                                    
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


function listaProyectos(){
    
    var ejercicio = $("#ejercicio").val();
    var fuente = $("#fuente").val();    
    var ue = $("#ue").val();    
    if(ejercicio!=0 && fuente!=0 && ue!=0){
        
        $.ajax({
            data: {
                accion: 'listaProyectosEjercicio',
                ejercicio: ejercicio,
                fuente: fuente,
                ue: ue
            },
            url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Lista Proyectos');
            },
            success: function (response) {            
                
                $("#tablaProyectos").html(response);
                
                $('.montoInput').autoNumeric({aSep: ',', mDec: 2, vMin: '0.00'});
                /*var info = jQuery.parseJSON(response);*/
            }
        });                
    }    
    else{
        $("#tablaProyectos").html('');
    }
}

function cargarPlantillaOficio(){
    var ejercicio = $("#ejercicio").val();
    var fuente = $("#fuente").val();
    var tipOfi = $("#tipOfi").val();
    var ue = $("#ue").val();
    var sector = $("#sector").val();
    
    if(ejercicio == 0){
        bootbox.alert('Selecciona un ejercicio');                
        return false;
    }
    
    if(fuente == 0){
        bootbox.alert('Selecciona una fuente');                
        return false;
    }
    
    if(tipOfi == 0){
        bootbox.alert('Selecciona un tipo de oficio');                
        return false;
    }
    
    if(ue == 0 || !ue){
        bootbox.alert('Selecciona una Unidad Ejecutora');                
        return false;
    }
        
    
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
                bootbox.alert('No se tiene una plantilla para este Ejercicio, Fuente y Tipo de Oficio');                
                $("#texto").html('');
            }                                
        }
    });         
    
    $.ajax({
        data: {
            accion: 'cargarTitularCopias',
            ue: ue,
            sector: sector
        },
        url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
        type: 'post',
        beforeSend: function () {
            //para seguir el debug
            console.log('Evento:: cargar Titular y Copias');
        },
        success: function (response) {            

            console.log(response);
            var info = jQuery.parseJSON(response);
            
            if(info.resultTitular){
                $("#titular").html(info.resultTitular);
            }else{
                $("#titular").html('Titular no registrado');
            }
            
            if(info.resultCopias){
                $("#ccp").html(info.resultCopias);                
            }                                    
        }
    }); 
    
}

function guardarOficio(){
    
    var tipOfi = $("#tipOfi").val();
    var sesion = $("#sesion").val();
    var texto = $("#texto").val();
    var titular = $("#titular").val();
    var ccp = $("#ccp").val();
    var fuente = $("#fuente").val();
    var fecha = $("#fecha").val();
    var ejercicio = $("#ejercicio").val();
    
    if(tipOfi==0){
        bootbox.alert('Selecciona un tipo de Oficio');               
        return false;
    }
    
    if(fuente==0){
        bootbox.alert('Selecciona una fuente');               
        return false;
    }
    if(sesion==0){
        bootbox.alert('Selecciona una Sesion');               
        return false;
    }       
    
    if(titular==''){
        bootbox.alert('Ingresa un titular para el oficio');               
        return false;
    }
    
    if(ccp==''){
        bootbox.alert('Ingresa un texto C.c.p. para el oficio');               
        return false;
    }
    
    if(texto==''){
        bootbox.alert('Ingresa un texto para el oficio');               
        return false;
    }
    
    
    var datosOfi = {
        'tipOfi' : tipOfi,
        'fuente' : fuente,
        'sesion' : sesion,
        'texto' : texto,
        'titular' : titular,
        'ccp' : ccp,
        'fecha': fecha,
        'ejercicio': ejercicio
    };
    
    var datos = new Array();
    
    $(".agregados").each(function( index, value ) {
        var dato = new Array();
        var idDetFon = $(this).attr('Id').replace('addcheck_','');        
        var monto = $(this).parent().parent().find('.montosAgregados').html().replace(/,/g,'');
        
        dato = {
            'idDetFon': idDetFon,
            'monto': monto
        };              
         
        datos.push(dato);
        
    });
    
    if(datos.length>0){
        $.ajax({
            data: {
                accion: 'guardarOficio',
                datos: datos,
                datosOfi: datosOfi                
            },
            url: 'contenido_sgi/controller/fondoMetropolitano/fondoMetropolitanoController.php',
            type: 'post',
            beforeSend: function () {
                //para seguir el debug
                console.log('Evento:: Guardar Oficio');
            },
            success: function (response) {

                console.log(response);                
                var info = jQuery.parseJSON(response);                
                
                if(info.result){
                    bootbox.alert('Se guardaron correctamente los datos para el oficio: '+ info.CveOfi);    
                    $("#btnGuardarOficio").hide();
                    $("#btnWord").show();
                    $("#btnPdf").show();
                    $(".idOfiFon").val(info.idOfiFon);
                }
            }
        });
    }
    else{
        bootbox.alert('Ingrese por lo menos un movimiento');    
        return false;
    }
}