
$(document).ready(function() {

$('.numero').mask('000,000,000,000,000.00', {reverse: true});

	$( "#sec" ).change(function() {
		var sec= $('#sec').val();
		$.post( "contenido_sgi/vistas/Techos/funciones/techosB-fnc.php", {sec:sec}, function( respuesta ) {
			$('#ue').html( respuesta.respuesta);
		},"json");
	});

	$( "#ejer" ).change(function() {
		var ejer= $('#ejer').val();

		$( "#inv" ).change(function() {
			var inv= $('#inv').val();

			if(inv == 1){
				$.post( "contenido_sgi/vistas/Techos/funciones/techosC-fnc.php", {ejer:ejer}, function( respuesta ) {
					$('#proyecto').removeAttr('hidden');
					$('#proy').html( respuesta.respuesta);
				},"json");
			}else{
				$('#proyecto').attr('hidden','hidden');
			}	
		});	
	});

	$( "#guardar" ).click(function() {

		//----------

        jQuery.validator.addMethod(  
          "notEqualTo",  
          function(elementValue,element,param) {  
            return elementValue != param;  
          }
          ,  
          "Seleccione un elemento "  
        ); 
	

		jQuery.validator.setDefaults({
		  debug: true,
		  success: "valid"
		});

		var form = $( "#formgral" );
		form.validate({
			        rules: {	            	            
			            ejer: { required: true, notEqualTo: 0  },
			            sec: { required: true, notEqualTo: 0  },
			            ue: { required: true, notEqualTo: 0  },
			            fte: { required: true, notEqualTo: 0  },
			            inv: { required: true, notEqualTo: 0  },  
			            mov: { required: true, notEqualTo: 0  },
			            monto: { required: true, notEqualTo: 0  }

			        },			        
			        messages: {
			            ejer: { required: "Seleccione elemento." },
			            sec:  { required: "Seleccione elemento." },
			            ue:  { required: "Seleccione elemento." },
			            fte: { required: "Seleccione elemento." },
			            inv:  { required: "Seleccione elemento." },
			            mov: { required: "Seleccione elemento." },
			            monto: { required: "Capture un monto." }
			        }	
		});

	  if(form.valid()){
	  	var formgral =$( "#formgral" ).serialize();
		
			$.post( "contenido_sgi/vistas/Techos/techos_upd.php",formgral,function( respuesta) {

				$('#campotecho').removeAttr('hidden');
				$('#techo').val(respuesta.respuesta2);

				bootbox.alert(respuesta.respuesta,  function() {
				});

					$('#campotecho').attr('hidden','hidden');
					$( "#mov" ).val(0);
					$( "#ejer" ).val(0);
					$( "#sec" ).val(0);
					$( "#ue" ).val(0);
					$( "#fte" ).val(0);
					$( "#inv" ).val(0);
					$( "#proy" ).val(0);
					$( "#monto" ).val('');
					$( "#obs" ).val('');
					$('#proyecto').attr('hidden','hidden');

			},"json");
	  }
		
	});


});