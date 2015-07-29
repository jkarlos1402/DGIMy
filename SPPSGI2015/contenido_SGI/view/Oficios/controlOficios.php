
<!-- Se incluye el archivo del bootstrap con los estilos -->
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<!--<link rel="stylesheet" href="contenido_SGI/view/css/jquery-ui-1.10.4.custom.css">-->
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/styleAplicacion.css" rel="stylesheet">

<!-- estilos especiales para el modulo autorizacion -->
<link href="contenido_SGI/view/css/estilosAutorizacion.css" rel="stylesheet">

<!-- Se incluye la libreria Jquery-->
<script type="text/javascript" src="contenido_sgi/view/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/jquery.bootstrap-duallistbox.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootbox.min.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootstrap-datepicker.js"></script> 




<!-- funciones javascript que desencadenan los eventos de los inputs en el template-->
<script type="text/javascript" src="contenido_SGI/view/js/oficios/funcionesControlOficios.js"></script>

<!-- Contenedor principal, se agrega un padding para que los campos no queden muy apretados -->
<div  class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>M&oacute;dulo de Control de Oficios</strong></h3>
        </div>
    </div>     
    
    <div class="panel panel-default">
        <div class="panel-body">    
            <div class="row form-inline">            
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Clave Oficio:</span>
                        <input type="text" class="form-control" aria-describedby="basic-addon1" id="cveOfi" name="cveOfi"/>
                    </div>                    
                </div>                    
                <div class="col-md-2">
                    <button class="btn btn-primary" id="mostrarOficio">Mostrar Datos</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="limpiar">Limpiar</button>
                </div>
            </div>           
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Informaci&oacute;n de oficio</strong></h3>
            </div>
            <div class="form-inline" role="form">                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Tipo de Oficio:</span>
                        <label class="form-control text-label" id="tipOfi"></label>
                    </div>                                                            
                </div>                    
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Ejercicio:</span>
                        <label class="form-control text-label" id="ejercicio"></label>
                    </div>                                                            
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Estatus:</span>
                        <label class="form-control text-label" id="status"></label>
                    </div>                                                            
                </div>
            </div>                                                                        
            
            <div class="row">&nbsp;</div>   
            
            <div class="form-inline" role="form">                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Fecha Oficio:</span>
                        <label class="form-control text-label" id="fecOfi"></label>
                    </div>                                                            
                </div>                    
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Fecha Firma:</span>
                        <label class="form-control text-label" id="fecFir"></label>
                    </div>                                                            
                </div>                               
            </div>  
            
            <div class="row">&nbsp;</div>
            <!--
            <div class="form-inline" role="form">                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Id Obra:</span>
                        <label class="form-control text-label" id="idObra"></label>
                    </div>                                                            
                </div>                    
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Nombre Obra:</span>
                        <label class="form-control" style="width: 530px" id="nombreObra"></label>
                    </div>                                                            
                </div>                               
            </div>  -->
        </div>    
    </div>    
    <div class="panel panel-default">
        <div class="panel-body">    
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Administraci&oacute;n Oficio</strong></h3>
            </div>                        
            
            <div class="form-inline" role="form">                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Fecha Firma:</span>                                                
                        <input type="text" class="form-control text-label" id="fechaFirma" value="" />
                    </div>                                                            
                </div>                    
                
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-warning" id="btnFirma">Cambiar Fecha</button>
                    </div>                                                            
                </div>                               
            </div> 
            
            <div class="row">&nbsp;</div>   
            
            <div class="form-inline" role="form">                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon etiqueta-label">Estatus:</span>                        
                        <select class="form-control text-label" id="statusId" disabled="disabled">
                            <option value="0">Selecciona una opci&oacute;n</option>
                            <option value="1">Aceptado</option>
                            <option value="2">Cancelado</option>
                            <option value="3">Proceso</option>
                        </select>
                    </div>                                                            
                </div>                                                    
            </div>                        
            <div class="row">&nbsp;</div>   
            <div class="form-inline" role="form">
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success btnAccion" id="btnAceptar">Aceptar Oficio</button>                                                                
                    </div>
                </div>                               
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-danger btnAccion" id="btnCancelar">Cancelar Oficio</button>
                    </div>
                </div>                               
                    
            </div>
        </div>    
    </div>
    
        
    
</div>    
<style type="text/css">
    .text-label{
        min-width: 200px;
    }
    .etiqueta-label{
        min-width: 100px;
    }
</style>    