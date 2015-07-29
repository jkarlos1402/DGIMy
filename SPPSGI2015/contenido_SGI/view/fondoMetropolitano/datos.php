<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/estilosGenerales.css">
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/bootstrap/css/bootstrap-duallistbox.css"> 
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/jquery.bootstrap-duallistbox.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/jquery.validate.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootbox.min.js"></script>
<script src="contenido_SGI/view/js/autoNumeric.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/nl.js" type="text/javascript"></script>

<script type="text/javascript" src="contenido_SGI/view/js/fondoMetropolitano/funcionesFondoMetropolitanoDatos.js"></script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Datos</strong></h3>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">    
        <div class="row form-inline col-md-12">                
            <div>            

                <label class="col-md-3 control-label" for="opcionAlta">  
                    <input id='opcionAlta' name='opciones' type="radio" value="alta" />
                    <div style="vertical-align: middle; height: 35px; display: inline-block">Alta</div>
                </label>    
                <label class="col-md-3 control-label" for="opcionModificar">  
                    <input id='opcionModificar' name='opciones' type="radio" value="modificar" />
                    <div style="vertical-align: middle; height: 35px; display: inline-block">Modificaci&oacute;n</div>
                </label>    
                <label class="col-md-3 control-label" for="opcionNuevoEjercicio">  
                    <input id='opcionNuevoEjercicio' name='opciones' type="radio" value="nuevoEjercicio" />
                    <div style="vertical-align: middle; height: 35px; display: inline-block">Nuevo Ejercicio</div>
                </label>    
            </div>                
        </div>
    </div>    

    <div class="panel-body" id="inputBuscar" style="display: none">            
        <div class="row form-inline">            
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">Clave Proyecto FM</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="cveFondoMetropolitano" name="cveFondoMetropolitano"/>
                </div>                    
            </div>                
            <div class="col-md-4" id="contenedorEjercicio">
                <div class="input-group">
                    <span class="input-group-addon">Ejercicio</span>
                    <select class="form-control col-md-1" name="ejercicioBusqueda" id="ejercicioBusqueda"></select>
                </div>                    
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" id="mostrarFM">Mostrar Datos</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" id="limpiar">Limpiar</button>
            </div>
        </div>                   
    </div>
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Registro de Proyecto</strong></h3>
    </div>
    
    <div class="panel-body">    
        <div class="col-md-12 ">            
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Fuente: </label>                
                    <select class="form-control col-md-1" name="fuente" id="fuente"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Proyecto: </label>                
                    <textarea class="form-control" name="proyecto" id="proyecto" cols="90"></textarea>                    
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Ejercicio: </label>                
                    <select class="form-control col-md-1" name="ejercicio" id="ejercicio"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Sector: </label>                
                    <select class="form-control col-md-1" name="sector" id="sector" onchange="comboUE()"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Unidad Ejecutora: </label>                
                    <select class="form-control col-md-1" name="ue" id="ue"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Grupo Social: </label>                
                    <select class="form-control col-md-1" name="grupoSocial" id="grupoSocial"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Observaciones: </label>                
                    <textarea class="form-control" name="observaciones" id="observaciones" cols="90"></textarea>                    
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            
            
            <div class="row form-inline col-md-12">                
                <div>
                    <label class="col-md-2 text-right" >Avance F&iacute;sico: </label>                
                    <input type="text" id="avanceFisico" name="avanceFisico" value=""  class="form-control col-md-2" size="5" style='text-align: right'/>
                    
                    <label class="col-md-3 control-label" for="terminado">  
                        <input id='terminado' name='terminado' type="checkbox" value="1" />
                        <div style="vertical-align: middle; height: 35px; display: inline-block">Terminado</div>
                    </label>    
                </div>                
            </div>
            <div class="col-md-12 ">&nbsp;</div>               
            <div class="col-md-12 ">&nbsp;</div>   
            <button type="button" class="btn btn-success col-md-offset-2" id="btnGuardarDatos" name="btnGuardarDatos">Guardar</button>                    
            <button type="button" class="btn btn-success col-md-offset-2" id="btnModificarDatos" name="btnModificarDatos">Guardar Cambios</button>
            <button type="button" class="btn btn-success col-md-offset-2" id="btnNuevoEjercicio" name="btnNuevoEjercicio">Guardar Ejercicio</button>
        </div>               
    </div>
</div> 


<style type="text/css">
.mensajeRojo{
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    color: #E70030;
    line-height: 30px;
}
#fecha{
      background-color: white;
      cursor: pointer;
}
</style>    