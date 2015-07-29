<meta charset="UTF-8">
<link href="contenido_SGI/vistas/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/vistas/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/vistas/css/styleAplicacion.css" rel="stylesheet">
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/jquery-2.1.1.min.js"></script> 
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="contenido_sgi/libs/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/autoNumeric.js"></script> 
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/funcionesAplicacionCtrl.js"></script>
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/jquery.tablesorter.js"></script>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Control de Autorizaciones de Pago</strong></h3>
        </div>
    </div>

    <div class="form-horizontal">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Datos Generales
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="folioAp">AP:</label><input type="text" id="folioAp"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Estado:</label><select id="estadoAp"></select>
                            </div>
                            <div class="col-sm-8">
                                <label for="beneficiarioAp">Beneficiario:</label><input type="text" id="beneficiarioAp" readonly="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="turnoAp">Turno:</label><input type="text" id="turnoAp"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Recepci&oacute;n:</label><input type="text" id="fecRecAp"/>
                            </div>
                            <div class="col-sm-8" style="margin-top: 2%;">
                                <div class="checkbox col-sm-2"><label><input type="checkbox" id="modAp">Modificable</label></div>
                                <div class="checkbox col-sm-2"><label><input type="checkbox" id="finiquitoAp">Finiquito</label></div>
                                <div class="checkbox col-sm-2"><label><input type="checkbox" id="desafectacionAp">Desafectaci&oacute;n</label></div>
                                <div class="checkbox col-sm-1"><label><input type="checkbox" id="cpAp">CP</label></div>
                                <div class="checkbox col-sm-1"> <label><input type="checkbox" id="errorAp">Error</label></div>
                                <div class="checkbox col-sm-4"><label><input type="checkbox" id="soloAp">S&oacute;lo Afectaci&oacute;n</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="relacion">Relaci&oacute;n</label><input type="text" id="relacion" />
                            </div>
                            <div class="col-sm-2">
                                <label for="fecEnvio" >Env&iacute;o</label><input type="text" id="fecEnvio" />
                            </div>
                            <div class="col-sm-2">
                                <label for="fecEntrega">Entrega:</label><input type="text" id="fecEntrega"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="observacionesAnalisis">Observaciones de an&aacute;lisis:</label><textarea id="observacionesAnalisis"></textarea>
                            </div>
                            <div class="col-sm-6" id="divCancel" style="display: none;">
                                <div class="panel panel-default" style="margin-top: -10%;">
                                    <div class="panel-heading">
                                        Cancelaci&oacute;n
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <label for="fechaCancel">Fecha:</label><input type="text" id="fechaCancel"/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="oficioCancel">Oficio/Orden:</label><input type="text" id="oficioCancel">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="observacionesCancel">Observaciones:</label><textarea id="observacionesCancel"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Aplicaci&oacute;n Presupuestal
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="sinivaAp">Importe sin IVA:</label><input type="text" id="sinivaAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="amortizacionAp">Amortizaci&oacute;n:</label><input type="text" id="amortizacionAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="icicAp">I.C.I.C (0.2%):</label><input type="text"  id="icicAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="isptAp">ISPT:</label><input type="text" id="isptAp" class="number" readonly="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="subtotalAp">Subtotal:</label><input type="text" id="subtotalAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="ivaAp">IVA:</label><input type="text" id="ivaAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="cmicAp">C.M.I.C (0.5%):</label><input type="text" id="cmicAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="otroAp">Otro:</label><input type="text" id="otroAp" class="number" readonly="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="afectacionAp">Afectaci&oacute;n Presupuestal:</label><input type="text" id="afectacionAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="netoAp">Importe Neto:</label><input type="text" id="netoAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="supervisionAp">Supervisi&oacute;n (2%):</label><input type="text" id="supervisionAp" class="number" readonly="true"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="totalAp">Total:</label><input type="text" id="totalAp" class="number" readonly="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table id="tablaAp" class="tablesorter table table-striped">
                                    <thead style="text-align: center;">
                                    <th>Ejercicio</th>
                                    <th>Obra</th>
                                    <th>Movimiento</th>
                                    <th>Oficio</th>
                                    <th>Referencia</th>
                                    <th>Fuente</th>
                                    <th>Inversi&oacute;n</th>
                                    <th>Recurso</th>
                                    <th>Afectaci&oacute;n</th>
                                    </thead>
                                    <tbody style="text-align: center;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-horizontal">
                                
                                    <div class="col-sm-2">
                                        <span id="btnReload" class="btn btn-danger">Limpiar</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <span id="btnImprimir" class="btn btn-default ">Imprimir</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <span id="btnGuardar" class="btn btn-success " style="display: none;">Actualizar</span>
                                    </div>

                                
                            </div>
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