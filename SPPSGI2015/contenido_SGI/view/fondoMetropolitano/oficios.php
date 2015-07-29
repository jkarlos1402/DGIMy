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

<script type="text/javascript" src="contenido_SGI/view/js/fondoMetropolitano/funcionesFondoMetropolitanoOficios.js"></script>

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Registro de Oficios</strong></h3>
    </div>
    
    <div class="panel-body">    
        <div class="col-md-12 "> 
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Ejercicio: </label>                
                    <select class="form-control col-md-3" name="ejercicio" id="ejercicio" onchange="comboSesion(); listaProyectos()"></select>                                                                                                                                 
                </div>
                <div>                                                                              
                    <label class="text-right col-md-3">Fuente: </label>                
                    <select class="form-control col-md-1" name="fuente" id="fuente"></select>                                                                                                                                 
                </div>                
            </div>                        
            <div class="col-md-12 ">&nbsp;</div>  
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Tipo de Oficio: </label>                
                    <select class="form-control col-md-1" name="tipOfi" id="tipOfi"></select>                                                                                                                                 
                </div>
                <div>                                                                              
                    <label class="col-md-3 text-right" >Fecha: </label>                
                    <input type="text" id="fecha" name="fecha" value=""  class="form-control" readonly='true' />
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Sesi&oacute;n: </label>                
                    <select class="form-control col-md-1" name="sesion" id="sesion"></select>                                                                                                                                 
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
                    <select class="form-control col-md-1" name="ue" id="ue" ></select>                                                                                                                                 
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Titular : </label>                
                    <textarea class="form-control col-md-3" name="titular" id="titular" cols="39" rows="5"></textarea>                    
                </div>            
                <div>                                                                              
                    <label class="text-right col-md-1">C.c.p : </label>                
                    <textarea class="form-control col-md-3" name="ccp" id="ccp" cols="39" rows="5"></textarea>                    
                </div>
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <div class="row form-inline">                
                <div>                                                                              
                    <label class="text-right col-md-2">Texto : </label>                
                    <textarea class="form-control col-md-3" name="texto" id="texto" cols="105" rows="4"></textarea>                                        
                </div>                            
            </div>
            <div class="col-md-12 ">&nbsp;</div>   
            <div class="row form-inline">                
                <div>
                    <button type="button" class="btn btn-success col-md-offset-8" id="btnCargarTextos" name="btnCargarTextos">Cargar Textos</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Movimientos</strong></h3>
    </div>
    
    <div class="panel-body">    
        <table width="100%">
            <tr>
                <td width="40%">
                    <table width='90%'>
                        <tr>
                            <th width='20px'>&nbsp;</th>
                            <th width='100px'>Clave</th>
                            <th>Proyecto</th>
                            <th width='100px'>Monto</th>    
                        </tr>
                        <tbody id="tablaProyectos"></tbody>
                    </table>
                </td>
                <td width='10%'>
                    <button type="button" class="btn ads" id="btnAgregar" name="btnAgregar">Agregar >></button>
                    <br /><br />
                    <button type="button" class="btn ads" id="btnQuitar" name="btnQuitar"> << Quitar</button>
                </td>
                <td width='45%'>
                    <table width='100%'>
                        <tr>
                            <th width='20px'>&nbsp;</th>
                            <th width='100px'>Clave</th>
                            <th>Proyecto</th>
                            <th width='100px'>Monto</th>    
                        </tr>
                        <tbody id="tablaagregados"></tbody>
                    </table>
                    <div class="col-md-12 ">&nbsp;</div>              
                    <div class="row form-inline">                
                        <div>                                                                                                  
                            <label class="text-right col-md-6">Numero de Proyectos: <span id="numProyectos">0</span></label>                
                            <label class="text-right col-md-6">Total: <span id="totalProyectos">0</span></label>                
                        </div>
                    </div>    
                </td>
            </tr>
        </table>        
        
        <div class="col-md-12 ">&nbsp;</div>              
        <button type="button" class="btn btn-success col-md-offset-9" id="btnGuardarOficio" name="btnGuardarOficio">Guardar</button>                                
        <div class="col-md-12 ">&nbsp;</div>              
        <form name="pdf" method="post" action="contenido_SGI/view/fondoMetropolitano/pdfOficio.php" target='_blank'>
            <input type='hidden' name='idOfiFon' id='idOfiFon' value='' class='idOfiFon'/>
            <button type="submit" class="btn btn-success col-md-offset-9" id="btnPdf" name="btnPdf" style='display: none'>PDF</button>                                
        </form>
        <div class="col-md-12 ">&nbsp;</div>              
        <form name="word" method="post" action="contenido_SGI/libs/phpWord/write/wordOficio.php" target='_blank'>
            <input type='hidden' name='idOfiFon' id='idOfiFon' value='' class='idOfiFon'/>
            <button type="submit" class="btn btn-success col-md-offset-9" id="btnWord" name="btnWord" style='display: none'>Word</button>        
        </form>    
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

.ads{
    font-size: 10px;
    min-width: 80px;
}
</style>    
