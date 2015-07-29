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

<script type="text/javascript" src="contenido_SGI/view/js/fondoMetropolitano/funcionesFondoMetropolitanoDepositos.js"></script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Depositos</strong></h3>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">    
        <div class="col-md-12 ">            
            
            <div class="row form-inline">                
                <div>
                    <label class="col-md-2 text-right" >Clave: </label>                
                    <input type="text" id="clave" name="clave" value=""  class="form-control" />
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
                    <label class="col-md-2 text-right" >Proyecto: </label>  
                    <textarea id="proyecto" name="proyecto" class="form-control" cols="70"></textarea>                    
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>                          
        </div>               
    </div>
</div> 

<div class="panel panel-default">
   
    <div class="panel-body">
        <table border="1" width="80%" class="tablaDepositos">            
            <tr>
                <td width="30%">
                    <div class="row form-inline">                
                        <div>
                            <label class="col-md-3 text-right" >Fecha:</label>                
                            <input type="text" id="fecha" name="fecha" value=""  class="form-control" readonly="true" size="15"/>
                        </div>
                    </div>
                    <div class="col-md-12 ">&nbsp;</div>                          
                    <div class="row form-inline">                
                        <div>
                            <label class="col-md-3 text-right" >Monto:</label>                
                            <input type="text" id="monto" name="monto" value=""  class="form-control" size="15" style='text-align: right'/>
                        </div>
                    </div>
                    <div class="col-md-12 ">&nbsp;</div>        
                </td>
                <td width='10%'>
                    <div class="row form-inline">                
                        <div>
                            <button type="button" class="btn ads" id="btnAgregar" name="btnAgregar">Agregar >></button>                            
                        </div>
                    </div>
                    <div class="col-md-12 ">&nbsp;</div>        
                    <div class="row form-inline">                
                        <div>
                            <button type="button" class="btn ads" id="btnQuitar" name="btnQuitar"> << Quitar</button>
                        </div>
                    </div>                   
                </td>
                <td width="40%" >
                    <table width='90%'>
                        <thead>
                            <tr>
                                <th width='50px'>&nbsp;</th>
                                <th width='170px'>Fecha</th>
                                <th width='200px'>Monto</th>                                                            
                            </tr>
                        </thead>    
                        <tbody id="tabladepositosbody"></tbody>                        
                    </table>                                                 
                    <table width='90%'>                        
                        <tr>                        
                            <td width='130px'>N&uacute;m Depositos:</td>
                            <td width='30px' id='etiquetaDepositos'>0</td>
                            <td style='width: 40px'>Total:
                            <td width='200px' id='etiquetaTotal' style='text-align: right'>0.00</td>
                        </tr>                        
                    </table>
                </td>                
            </tr>            
        </table>        
        <div class="col-md-12 ">&nbsp;</div>   
        <button type="button" class="btn btn-success col-md-offset-8" id="btnGuardarDepositos" name="btnGuardarDepositos">Guardar Depositos</button>                    
    </div>              
    
</div>    

<style type="text/css">
.tablaDepositos th{
    font-weight: bold;
    font-size: 13px;
    min-width: 100px;        
}

.tablaDepositos td{
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