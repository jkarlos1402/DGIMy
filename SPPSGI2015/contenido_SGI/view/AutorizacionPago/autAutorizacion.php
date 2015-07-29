 <!--
 @Modulo "Autorizacion Presupuestal"
 @Control "Autorizacion"
 @versión: 0.1      
 @modificado: 21 de Octubre del 2014
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
<script type="text/javascript" src="contenido_SGI/view/jscripts/nl.js"></script>
<script type="text/javascript" src="contenido_SGI/view/jscripts/funcionesAutorizacion.js"></script>


<!-- Contenedor principal, se agrega un padding para que los campos no queden muy apretados -->
<div  class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>M&oacute;dulo de Autorizaci&oacute;n</strong></h3>
        </div>
    </div>                      
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label class="label1">
                        <input type="radio" name="oficioExistente" id="alta" value="true" checked> Alta
                    </label>
                </div>    
                <div class="form-group">
                    <label>
                        <input type="radio" name="oficioExistente" id="modificacion" value="false"> Modificaci&oacute;n
                    </label>
                </div>    
            </form>
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
                    <label> Ejercicio: </label>
                    <select class="form-control input-sm" id="ejercicio" name="ejercicio">
                        <option value='0'>Elija una opci&oacute;n</option>                
                    </select>
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
                        <input type="checkbox" value="cp" name="cp" id="cp">&nbsp;CP
                    </label>                            
                </div>                
                
            </form>    
        </div>
    </div>    
    
    <div class="panel panel-default">
        <div class="panel-body">
            <label class="label1">Sector: </label>
            <label id='letraSector'></label>
            <div class="row">&nbsp;</div>
            <form class="form-inline" role="form">                
                <div class="form-group">
                    <label class="label1">Total: </label>
                    <input type="text" class="form-control input-sm" id="total" name="total" disabled="disabled">
                    <input type="text" class="form-control input-sm" id="letraTotal" name="letraTotal" size="120">
                </div>                                    
            </form>    
        </div>
    </div>      
    
    <div class="panel panel-default">
        
        <div class="panel-heading">
            <h3 class="panel-title text-center"><strong>Movimientos</strong></h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" role="form">                
                <div class="form-group">                                         
                    <label class="label1">Obra:</label>
                    <input type="text" class="form-control input-sm" id="obra" name="obra">                                          
                    <input type="text" class="form-control input-sm " id="letraObra" name="letraObra" size="120">                    
                    <input type="hidden" name="idDetObr" id='idDetObr' value="" />
                </div>                                    
            </form>  
            
            <div class="row">&nbsp;</div>
            
            <form class="form-inline " role="form">                
                <div class="form-group">
                    <label for="movimiento" class="label1"> Movimiento:&nbsp;</label>
                    <select class="form-control input-sm" id="movimiento" name="movimiento">
                        <option value='0'>Elija una opci&oacute;n</option>                        
                        <option value='6'>Reducci&oacute;n</option>
                        <option value='1'>Ampliaci&oacute;n</option>
                    </select>
                
                    <label for="referencia"> Referencia: </label>
                    <select class="form-control input-sm" id="referencia" name="referencia"></select>                    
                    <label for="fuente"> Fuente: </label>
                    <select class="form-control input-sm" id="fuente" name="fuente">
                        <option value='0'>Elija una opci&oacute;n</option>              
                    </select>
                </div>
                <div class="row">&nbsp;</div>
                <div class="form-group">
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
                    <input type="text" class="form-control input-sm" id="uEjecutora" name="uEjecutora" style="display: none">                                          
                    <input type="text" class="form-control input-sm " id="uEjecutoraLetra" name="uEjecutoraLetra" size="120">                                        
                </div>                                    
            </form>  
            
            <div class="row">&nbsp;</div>
            
            <div class="row">                
                <div class="col-md-4 form-inline col-md-offset-1">                                                            
                    <label class="labelCenter">Monto por asignar: </label>                
                    <input type="text" class="form-control input-sm" id="montoPorAsignar" name="montoPorAsignar"> 
                </div>
                <div class=".col-md-4 form-inline">                    
                    <label class="labelCenter">Monto Asignado: </label>                     
                    <input type="text" class="form-control input-sm" id="montoAsignado" name="montoAsignado">                                                                
                </div>  
            </div>
            
            <div class="row">&nbsp;</div>
            
            <div class="row">                
                <div class="col-md-4 form-inline col-md-offset-1">                                                            
                    <label class="labelCenter">Monto por autorizar: </label>                
                    <input type="text" class="form-control input-sm" id="montoPorAutorizar" name="montoPorAutorizar">                                                                                                            
                </div>
                <div class=".col-md-4 form-inline">                    
                    <label class="labelCenter">Monto autorizado: </label>                     
                    <input type="text" class="form-control input-sm" id="montoAutorizado" name="montoAutorizado">                                                                
                </div>  
            </div>                                               
            
            <div class="row">&nbsp;</div>
            
            <div class="row">
                <div class="col-lg-10">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><b>Obra</b></th>                                
                                <th><b>Movimiento</b></th>
                                <th><b>Referencia</b></th>
                                <th><b>Fuente</b></th>
                                <th><b>Inversi&oacute;n</b></th>
                                <th><b>Recurso</b></th>
                                <th><b>Ejecutor</b></th>
                                <th><b>Asignado</b></th>
                                <th><b>Autorizado</b></th>
                                <th>&nbsp;</th>
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
                <div class="col-md-1">
                    
                    <p><button type="button" class="btn btn-default" id="botonAgregar"><<< Agregar</button></p>
                    <p><button type="button" class="btn btn-default" id="botonQuitar"><<< Quitar</button></p>
                    <p><button type="button" class="btn btn-default" id="botonTodos"><<< Todos</button></p>
                    <p><button type="button" class="btn btn-default" id="botonNinguno"><<< Ninguno</button></p>
                    
                </div>
            </div>   
            <div class="row panel">&nbsp;</div>
            
            <div class="row">
                <div class="col-md-4">
                    <p><button type="button" class="btn btn-default" id="botonCuerpo">Cuerpo</button></p>
                </div>
                <div class="col-md-2">
                    <!--<p><button type="button" class="btn btn-default" id="botonConsulta">Consulta</button></p>-->
                </div>
                <div class="col-md-2">
                    <p><button type="button" class="btn btn-default" id="botonOficio" style="display: none">Imprimir Oficio</button></p>
                </div>
                <div class="col-md-2">
                    <p><button type="button" class="btn btn-default" id="botonGuardar">Guardar</button></p>
                </div>
                <div class="col-md-2">
                    <p><button type="button" class="btn btn-default" id="botonSalir">Salir</button></p>
                </div>
            </div>
            
        </div>    
    </div>
    
    
    <!-- -->
    
    <div id="DocumentoF" style="display: none; overflow: hidden" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><strong>Cuerpo del Oficio</strong></h3>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">                
                <div class="col-md-6 form-inline">                                                            
                    <label class="label1 top">Titular: </label>                
                    <textarea class="form-control" rows="4" cols="30" id="titular"></textarea>                        
                </div>
                <div class=".col-md-4 form-inline">                    
                    <label class="label1 top">Asunto: </label>                     
                    <textarea class="form-control" rows="4" cols="30" id="asunto"></textarea>                        
                </div>  
            </div>                                            
            <div class="row">&nbsp;</div>
            <div class="row">                
                <div class="col-md-6 form-inline">                                                            
                    <label class="label1 top">C.c.p: </label>                
                    <textarea class="form-control" rows="5" cols="30" id="ccp"></textarea>                                            
                </div>
                <div class=".col-md-4 form-inline">                    
                    <label class="label1">Prefijo: </label>                     
                    <input type="text" class="form-control input-sm" id="prefijo" size="31">                                                                
                </div>                
                <div style="height: 5px;">&nbsp;</div> 
                <div class=".col-md-4 form-inline">                    
                    <label class="label1">Refer: </label>                     
                    <input type="text" class="form-control input-sm" id="refer" size="31">                                                                
                </div>
                <div style="height: 5px;">&nbsp;</div>                
                <div class=".col-md-4 form-inline">                    
                    <label class="label1">T.A.T.: </label>                     
                    <input type="text" class="form-control input-sm" id="tat" size="31">
                </div>
            </div> 
            <div class="row">&nbsp;</div>
            <div class="row">                
                <div class="col-md-12 form-inline">                                                            
                    <label class="label1 top">Texto: </label>                
                    <textarea class="form-control textareaLong" rows="4" id="texto"></textarea>                                            
                </div>                
            </div> 
            <div class="row">&nbsp;</div>
        </div> 
    </div>  
    
</div>    