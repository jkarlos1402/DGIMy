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

<script type="text/javascript" src="contenido_SGI/view/js/fondoMetropolitano/funcionesFondoMetropolitanoPlantillas.js"></script>

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Registro de Plantillas para Oficios</strong></h3>
    </div>
    
    <div class="panel-body">    
        <div class="col-md-12 "> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Ejercicio: </label>                
                    <select class="form-control col-md-1" name="ejercicio" id="ejercicio"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Fuente: </label>                
                    <select class="form-control col-md-1" name="fuente" id="fuente"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Tipo de Oficio: </label>                
                    <select class="form-control col-md-1" name="tipOfi" id="tipOfi"></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Texto : </label>                
                    <textarea class="form-control" name="texto" id="texto" cols="90"></textarea>                    
                </div>
            </div>            
            <div class="col-md-12 ">&nbsp;</div>              
            <button type="button" class="btn btn-success col-md-offset-2" id="btnGuardarPlantilla" name="btnGuardarPlantilla">Guardar</button>                                
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
