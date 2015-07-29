 <!--
 @Modulo "Autorizacion Presupuestal"
 @Control "Control Templates Oficios"
 @versión: 0.1      
 @modificado: 15 de Diciembre del 2014
 @autor: Giovanni Estrada Aleman
-->

<!-- Se incluye el archivo del bootstrap con los estilos -->
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="contenido_SGI/view/css/jquery-ui-1.10.4.custom.css">

<!-- estilos especiales para el modulo autorizacion -->
<link href="contenido_SGI/view/css/estilosAutorizacion.css" rel="stylesheet">

<!-- Se incluye la libreria Jquery-->
<script type="text/javascript" src="contenido_SGI/view/jscripts/jquery-1.9.1.min.js"></script>
<script src="contenido_SGI/view/jscripts/jquery-ui.js"></script>

<!-- funciones javascript que desencadenan los eventos de los inputs en el template-->
<script type="text/javascript" src="contenido_SGI/view/js/oficios/funcionesAutorizacionTemp.js"></script>

<!-- Contenedor principal, se agrega un padding para que los campos no queden muy apretados -->
<div  class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>M&oacute;dulo de Control de plantillas de Oficios</strong></h3>
        </div>
    </div>                                                         
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline" role="form">                
                <div class="form-group">
                    <label class="label1"> Tipo: </label>
                    <select class="form-control input-sm" id="tipo" name="tipo">                        
                        <option value='0'>Elija una opci&oacute;n</option>                                      
                    </select>
                </div>                    
                <div class="form-group">
                    <label class="label1"> Ejercicio: </label>                    
                    <select class="form-control input-sm" id="ejercicio" name="ejercicio">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                </div>    
                <div class="form-group">                                                        
                    <label for="fuente" class="label1"> Fuente: </label>
                    <select class="form-control input-sm" id="fuente" name="fuente">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>                                        
                </div>
            </form>                                                                        
            <div class="row">&nbsp;</div>                        
            <form role="form" style="width: 50%">                
                <div class="form-group">
                    <label> Asunto: </label>
                    <input type="text" class="form-control input-sm" id="asunto" size="31">
                </div>                    
                <div class="form-group">
                    <label> Prefijo: </label>
                    <input type="text" class="form-control input-sm" id="prefijo" size="31">
                </div>                                                                     
                <div class="form-group">                                                        
                    <label for="fuente"> Fundamento legal: </label>
                    <textarea class="form-control textareaLong" rows="4" id="fundamento"></textarea>                                            
                </div>
                <div class="form-group">                                                        
                    <label for="fuente"> Complemento: </label>
                    <textarea class="form-control textareaLong" rows="4" id="complemento"></textarea>                                            
                </div>
            </form>
            
            <div class="row">
                <div class="col-md-2">                    
                    <p><button type="button" class="btn btn-default" id="etiquetaTotal">Agregar Total</button></p>
                </div>
                <div class="col-md-4">                    
                    &nbsp;
                </div>    
                <div class="col-md-2 text-right">                    
                    <p><button type="button" class="btn btn-default" id="guardarC">Guardar</button></p>
                </div>
                <div class="col-md-2 text-right">  
                    <p><button type="button" class="btn btn-default" id="salir">Salir</button></p>
                </div>
            </div>    
            
        </div>    
    </div>
    
        
    
</div>    