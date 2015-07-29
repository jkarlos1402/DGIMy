$(document).ready(function(){
    $( "#sigh6" ).click(function() {
		var guar = 6;
		$("#sig2").val(guar);
		var formualrioGeneral =$( "#formGral" ).serialize();
                var valsig = $("#valsig").val();
                
                if(valsig == 2){
                    $('#h6').removeClass('tab-pane active');
                    $('#h6').addClass('tab-pane');
                    $('#h7').addClass('tab-pane active');
                }else{
                    $.post( "contenido_sgi/vistas/ExpedienteTecnico/expedientetecnico_upd_parcial.php",formualrioGeneral,function( respuesta ) {
				$('#h6').removeClass('tab-pane active');
				$('#h6').addClass('tab-pane');
				$('#h7').addClass('tab-pane active');
                    },"json");
                }
	});

	$( "#anth6" ).click(function() {
		var guar = 6;
		$("#sig2").val(guar);
		var formualrioGeneral =$( "#formGral" ).serialize();
                var valsig = $("#valsig").val();
                
                if(valsig == 2){
                    $('#h6').removeClass('tab-pane active');
                    $('#h6').addClass('tab-pane');
                    $('#h5').addClass('tab-pane active');
                }else{
                    $.post( "contenido_sgi/vistas/ExpedienteTecnico/expedientetecnico_upd_parcial.php",formualrioGeneral,function( respuesta ) {
				$('#h6').removeClass('tab-pane active');
				$('#h6').addClass('tab-pane');
				$('#h5').addClass('tab-pane active');
                    },"json");
                }
	});
});