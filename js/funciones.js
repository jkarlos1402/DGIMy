/*
 * 
 */
function trim(str){
     var str=str.replace(/^\s+|\s+$/,'');
     return str;
}
    
$(document).ready(function() {    

    $("#signup").validate({
        rules: {
            Usuario: { required: true, minlength: 3},
            Password: { required: true, minlength: 3}
        },
        messages: {
            Usuario: "Escriba su usuario.",
            Password: "Escriba su contraseña."
        },
        submitHandler: function(form){       
            var usuario =$('#Usuario').val();
            var password=$('#Password').val();
            var lstyear =$('#lstyear').val();
            var dataString = 'usuario='+usuario+'&password='+password+'&lstyear='+lstyear;

               // var dataString = 'usuario='+$('#Usuario').val()+'&password='+$('#Password').val();
                $("#signup").hide(); 
                $.ajax({
                type: "POST",
                /*url:  "inc/login.php",*/
                url: "login.php",
                data: dataString,
                success: function(data){                    
                    var result=data.split(",");                    
                    
                    //-------
                    
                    if(result[0]=='Autentificado'){
                         var url = "SPPSGI2015/index.php?x=0&y=0";                                               
                         window.location= url;               
                    }else{
                        $("#status").html(result);                        
                        $("#status").show();
                        $("#status").addClass('error');
                        $("#signup").show(); 
                    }                     
                    //-------
                }
            });
        }
    });
});


                        
                        
                        
                        