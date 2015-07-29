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

<script type="text/javascript" src="contenido_SGI/view/js/fondoMetropolitano/funcionesFondoMetropolitanoSesiones.js"></script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Sesiones</strong></h3>
    </div>
</div>

<div class="panel panel-default">
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
                    <label class="col-md-2 text-right" >Fecha: </label>                
                    <input type="text" id="fecha" name="fecha" value=""  class="form-control" readonly='true' />
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <div class="row form-inline">                
                <div>
                    <label class="col-md-2 text-right">Sesi&oacute;n: </label>                
                    <input type="text" id="sesion" name="sesion" value="" class="form-control" size="120" />
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <button type="button" class="btn btn-success col-md-offset-2" id="btnGuardarSesion" name="btnGuardarSesion">Guardar</button>                    
        </div>               
    </div>
</div> 

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Lista de Sesiones</strong></h3>
    </div>
    <div class="panel-body">
        <table border="1" width="100%" class="tablaSesiones">
            <thead>
                <tr>                    
                    <th width="70px">Ejercicio</th>
                    <th width="70px">Fecha</th>
                    <th>Sesion</th>                                        
                    <th width="70px">&nbsp;</th>
                </tr>
            </thead>
            <tbody id='infoSesiones'>
                <tr><td colspan="3" class="mensajeRojo">A&uacute;n no se tienen registros</td></tr>
            </tbody>
        </table>        
    </div>              
</div>    

<style type="text/css">
.tablaSesiones th{
    font-weight: bold;
    font-size: 13px;
    min-width: 100px;        
}

.tablaSesiones td{
    padding: 3px;        
    min-width: 100px;        
}

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