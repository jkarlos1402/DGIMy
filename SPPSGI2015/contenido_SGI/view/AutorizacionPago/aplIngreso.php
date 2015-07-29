<meta charset="UTF-8">
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/styleAplicacion.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootstrap-datepicker.js"></script> 
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="contenido_SGI/view/js/autorizacionPago/funcionesApIng.js"></script>
<!--<script type="text/javascript" src="contenido_SGI/vistas/jscripts/jquery.tablesorter.js"></script>-->

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Ingreso de Autorizaciones de Pago</strong></h3>
        </div>
    </div>
    <div class="col-sm-3" >
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-horizontal col-sm-12">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="iFolio">Folio:</label>
                            <input type="text" id="iFolio"/>
                        </div>
                        <div class="col-sm-12">
                            <label for="sObservaciones">Observaciones:</label>
                            <textarea id="sObservaciones" rows="10"></textarea>
                        </div>
                        <div class="col-sm-12">
                            <label for="fIngreso">Ingreso:</label>
                            <input type="fecha" id="fIngreso" readonly="true">
                        </div>
                        <div class="row"></div>
                        <div class="col-sm-12">
                            <span id="btnIngresar" class="btn btn-success" style="display:none;">Ingresar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                Turnar Ap
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="iTurno" class="col-sm-4 control-label">Turno:</label>
                            <div class="col-sm-7">
                                <input type="text" id="iTurno" readonly="true"/>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <label for="sArea" class="col-sm-2 control-label">&Aacute;rea:</label>
                            <div class="col-sm-10">
                                <select id="sArea"><option value="-1">Seleccione una opci&oacute;n</option></select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="fTurnada" class="col-sm-4 control-label">Turnada:</label>
                            <div class="col-sm-8">
                                <input type="text" id="fTurnada" readonly="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"></div>

                <div class="row"></div>
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table id="tablaAp" class="table table-bordered">
                                <thead style="text-align: center;">
                                <th>idAps</th>
                                <th style="width:20%">Ap</th>
                                <th style="width:20%">Recepci&oacute;n</th>
                                <th>Turno</th>
                                <th>Observaciones</th>
                                <th>UE</th>
                                <th></th>
                                </thead>
                                <tbody style="text-align: center;">
                                </tbody>
                            </table>
                            <div id="listadoAp"></div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="form-group">
                        <div class="col-sm-3 col-md-offset-9">
                            <span id="btnTurnar" class="btn btn-success">Turnar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogAvisos" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Informaci&oacute;n</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="msgAviso"></p>             
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    

                </div>
            </div>
        </div>
    </div>
</div>

<input id="idAps" name="idAps" type="hidden" />
<input id="nomUE" name="nomUE" type="hidden" />
<form id="imprime" name="imprime" method="post" target="_blank" action="contenido_sgi/model/autorizacionPago/impresionTurno.php">
    <input id="Turno" name="Turno" type="hidden" />
    <input id="area" name="area" type="hidden" />
    <input id="fechaTurno" name="fechaTurno" type="hidden" />
</form>