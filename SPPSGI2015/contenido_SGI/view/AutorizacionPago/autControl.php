 <!--
 @Modulo "Autorizacion Presupuestal"
 @Control "Control Oficios"
 @versión: 0.1      
 @modificado: 26 de Octubre del 2014
 @autor: Giovanni Estrada Aleman
-->

<!-- Se incluye el archivo del bootstrap con los estilos -->
<link href="contenido_SGI/vistas/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="contenido_SGI/vistas/css/jquery-ui-1.10.4.custom.css">

<!-- estilos especiales para el modulo autorizacion -->
<link href="contenido_SGI/vistas/css/estilosAutorizacion.css" rel="stylesheet">

<!-- Se incluye la libreria Jquery-->
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/jquery-1.9.1.min.js"></script>
<script src="contenido_SGI/vistas/jscripts/jquery-ui.js"></script>

<!-- funciones javascript que desencadenan los eventos de los inputs en el template-->
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/funcionesControlOficios.js"></script>

<!-- Contenedor principal, se agrega un padding para que los campos no queden muy apretados -->
<div  class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>M&oacute;dulo de Control de Oficios</strong></h3>
        </div>
    </div>                                                         
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label class="label1">Oficio: </label>                    
                    <input type="text" class="form-control input-sm" id="cveoficio" name="cveoficio">
                    <input type="text" class="form-control input-sm" id="oficio" name="oficio" style='display: none'>
                </div>                    
                <div class="form-group">
                    <label> Tipo: </label>
                    <select class="form-control input-sm" id="tipo" name="tipo">                        
                        <option value='0'>Elija una opci&oacute;n</option>                                      
                    </select>
                </div>    
                <div class="form-group">
                    <label for="estado"> Estado: </label>
                    <select class="form-control input-sm" id="estado" name="estado">                        
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                </div>
                <div class="form-group">
                    <label> Ejercicio: </label>                    
                    <label id='Ejercicio'></label>                    
                </div>
            </form>   
            
            <div class="row">&nbsp;</div>
            
            <form class="form-inline" role="form">
                <div class="form-group"> 
                    <label class="label1">Fecha: </label>
                    <input type="text" class="form-control input-sm" id="fecha" name="fecha">
                </div>
                <div class="form-group">
                    <label for="firma"> Firma: </label>
                    <input type="text" class="form-control input-sm" id="firma" name="firma">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="modificable" name="modificable" id="modificable">&nbsp;Modificable
                    </label>                            
                </div> 
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="cp" name="cp" id="cp">&nbsp;CP
                    </label>                            
                </div>                
                <div class="form-group form-inline col-md-offset-11">                    
                    <p><button type="button" class="btn btn-default" id="cambiarOficio">Cambiar</button></p>
                </div>
            </form>    
        </div>
    </div>           
    
    <div class="panel panel-default">                
        <div class="panel-body">            
            
            <form class="form-inline " role="form">                
                <div class="form-group">                                                        
                    <label for="fuente"> Fuente: </label>
                    <select class="form-control input-sm" id="fuente" name="fuente">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                
                    <label for="inversion" class="label1">Inversi&oacute;n: </label>
                    <select class="form-control input-sm" id="inversion" name="inversion">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                
                    <label for="recursos"> Recursos: </label>
                    <select class="form-control input-sm" id="recursos" name="recursos">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                </div>
            </form>
            
            <div class="row">&nbsp;</div>
                         
            <form class="form-inline" role="form">                
                <div class="form-group">                                         
                    <label class="label1">U. Ejecutora: </label>
                    <input type="text" class="form-control input-sm" id="uEjecutora" name="uEjecutora">                                          
                    <input type="text" class="form-control input-sm " id="uEjecutoraLetra" name="uEjecutoraLetra" size="100">                    
                </div>    
                <div class="form-group form-inline col-md-offset-11">                        
                    <p><button type="button" class="btn btn-default" id="cambiarInfOficio">Cambiar</button></p>                    
                </div>                                    
            </form>  
            
            <div class="row">&nbsp;</div>                       
            <div class="row">
                <div class="col-md-4">
                    <p><button type="button" class="btn btn-default" id="todos">Todos</button></p>
                </div>
                <div class="col-md-6">
                    <p>&nbsp;</p>
                </div>                
                <div class="col-md-2 text-right">
                    <p><button type="button" class="btn btn-default" id="ninguno">Ninguno</button></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ">
                    <table class="table table-bordered">
                        <thead>
                            <tr>                        
                                <th>&nbsp;</th>
                                <th><b>Obra</b></th>
                                <th><b>Movimiento</b></th>
                                <th><b>Referencia</b></th>
                                <th><b>Fuente</b></th>
                                <th><b>Inversi&oacute;n</b></th>
                                <th><b>Recurso</b></th>
                                <th><b>Ejecutor</b></th>
                                <th><b>Asignado</b></th>
                                <th><b>Autorizado</b></th>                                
                            </tr>
                        </thead>
                        <tbody class="table-bordered" id="tablaBody"></tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>                       
                                <td>&nbsp;</td>                       
                            </tr>
                        </tfoot>
                    </table>                
                </div>               
            </div>   
            <div class="row panel">&nbsp;</div>                                   
            
            <div class="row">&nbsp;</div>                       
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>                        
                                <th><b>Oficio</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Movimiento</b></th>                                
                                <th><b>Obra</b></th>                                
                            </tr>
                        </thead>
                        <tbody class="table-bordered" id="tablaBodyOfis"></tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>                        
                                <th><b>AP</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Movimiento</b></th>                                
                                <th><b>Obra</b></th>                                
                            </tr>
                        </thead>
                        <tbody class="table-bordered" id="tablaBodyAps"></tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>                                
                            </tr>
                        </tfoot>
                    </table>                    
                </div>                                
            </div>
            
            <div class="row">&nbsp;</div>
            
            <div class="row">
                <div class="col-md-8">                    
                    &nbsp;
                </div>    
                <div class="col-md-2 text-right">                    
                    <p><button type="button" class="btn btn-default" id="guardar">Guardar</button></p>
                </div>
                <div class="col-md-2 text-right">  
                    <p><button type="button" class="btn btn-default" id="salir">Salir</button></p>
                </div>
            </div>    
            
        </div>    
    </div>
    
        
    
</div>    