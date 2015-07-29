
<link href="contenido_SGI/vistas/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/vistas/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/vistas/css/styleAplicacion.css" rel="stylesheet">
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/jquery-2.1.1.min.js"></script> 
<script type="text/javascript" src="contenido_sgi/libs/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/autoNumeric.js"></script> 
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/nl.js"></script> 
<script type="text/javascript" src="contenido_SGI/vistas/jscripts/funcionesAplicacion.js"></script>
<style>
    .datepicker{z-index:1151 !important;}
</style>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Actualizaci&oacute;n de Autorizaciones de Pago</strong></h3>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Datos Generales
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-sm-9">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="checkbox col-sm-6">
                                        <label id="mod">
                                            <input type="checkbox" id="apRegistrada" title="Ingresar Ap ya registrada">Modificar AP
                                        </label>
                                    </div>
                                    <div class="row"></div>
                                    <div class="col-sm-6" style="visibility: hidden;">
                                        <label for="folioAp">AP:</label>
                                        <input type="text" id="folioAp" readonly="true"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Estimaci&oacute;n:</label><input type="text" id="estimacionAp" class="number" value="0"/>
                                    </div>
                                </div>
                                <div class="row"></div>
                                <div class="form-group">
                                    <div class="checkbox col-sm-6">
                                        <label id="error">
                                            <input type="checkbox" id="errorAp">Error
                                        </label>
                                    </div>
                                    <div class="checkbox col-sm-6">
                                        <label id="finiquito">
                                            <input type="checkbox" id="finiquitoAp">Finiquito
                                        </label>
                                    </div>
                                </div>
                                <div class="row"></div>
                                <div class="form-group">
                                    <div class="checkbox col-sm-6">
                                        <label id="cp">
                                            <input type="checkbox" id="cpAp">CP
                                        </label>
                                    </div>
                                    <div class="checkbox col-sm-6">
                                        <label id="desafect">
                                            <input type="checkbox" id="desafectacionAp">Desafectaci&oacute;n
                                        </label>
                                    </div>
                                </div>
                                <div class="row"></div>
                                <div class="form-group">
                                    <div class="checkbox col-sm-12">
                                        <label id="afect">
                                            <input type="checkbox" id="soloAp">S&oacute;lo para Afectaci&oacute;n Presupuestal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Estado:</label><input type="text" id="estadoAp" readonly="true"/>
                            </div>
                            <div class="form-group">
                                <label>Recepci&oacute;n:</label><input type="text" id="fecRecAp" readonly="true"/>
                            </div>
                            <div class="form-group">
                                <label>Env&iacute;o:</label><input type="text" id="fecEnAp" readonly="true"/>
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="form col-sm-12">
                        <div class="form-group">
                            <label for="ejecutoraAp">Ejecutora:</label><input type="text" id="ejecutoraAp" readonly="true"/>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="rfcAp">RFC:</label> <input type="text" id="rfcAp"/><input type="text" id="idEmpAp" style="display:none;" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiarioAp">Beneficiario:</label><input type="text" id="beneficiarioAp" readonly="true"/>
                        </div>
                        <div class="form-group">
                            <label for="observacionesAp">Observaciones:</label><textarea id="observacionesAp"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Aplicaci&oacute;n Presupuestal
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="col-sm-12">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="sinivaAp">Importe sin IVA:</label><input type="text" id="sinivaAp" class="number" readonly="true" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="icicAp">I.C.I.C (0.2%):</label><input type="text"  id="icicAp" class="number" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="amortizacionAp">Amortizaci&oacute;n:</label><input type="text" id="amortizacionAp" class="number" readonly="true" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cmicAp">C.M.I.C (0.5%):</label><input type="text" id="cmicAp" class="number" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="subtotalAp">Subtotal:</label><input type="text" id="subtotalAp" class="number" readonly="true" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="supervisionAp">Supervisi&oacute;n (2%):</label><input type="text" id="supervisionAp" class="number" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="ivaAp">IVA:</label><input type="text" id="ivaAp" class="number" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="isptAp">ISPT:</label><input type="text" id="isptAp" class="number" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="afectacionAp">Afectaci&oacute;n Presupuestal:</label><input type="text" id="afectacionAp" class="number" readonly="true" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="otroAp">Otro:</label><input type="text" id="otroAp" class="number" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="netoAp">Importe Neto:</label><input type="text" id="netoAp" class="number" readonly="true" value="0.00"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="retencionesAp">Retenciones:</label><input type="text" id="retencionesAp" class="number" readonly="true" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea id="letranetoAp" readonly="true"></textarea>
                                </div>
                            </div>
                        </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
    <div class="panel panel-default" id="movimientos">
        <div class="panel-heading">
            Movimientos
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-9">
                        <label for="obraAp" class="col-sm-1 control-label">Obra:</label>
                        <div class="col-sm-2">
                            <input type="text" id="obraAp"/> 
                            <input type="text" id="idDetObrAp" style="display:none;"/> 
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="nombreobraAp" readonly="true"/> 
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="sectorAp" class="col-sm-3 control-label">Sector:</label>
                        <div class="col-sm-9">
                            <input type="text" id="sectorAp" readonly="true"/> 
                        </div>
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group">
                    <div class="form-horizontal">
                        <div class="col-sm-4">
                            <label for="movimientoAp" class="col-sm-4 control-label">Movimiento:</label>
                            <div class="col-sm-8">
                                <select id="movimientoAp"></select> 
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <label for="disponibleAp" class="col-sm-2 control-label">Disponible:</label>
                            <div class="col-sm-3">
                                <input type="text" id="disponibleAp" class="number" readonly="true"/> 
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="ejercidoAp" class="number" readonly="true"/> 
                            </div>
                            <div id="ivaDiv" style="display:none;">
                                <label for="ivaAmortizacion" class="col-sm-1 control-label">Iva:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="ivaAmortizacion" class="number" /> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group">
                    <div class="col-sm-3">
                        <label for="partidaAp" class="col-sm-4 control-label">Partida:</label>
                        <div class="col-sm-8">
                            <select id="partidaAp"></select> 
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10">
                        <span class="btn btn-success col-sm-12" id="btnAgregar">Agregar</span>
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group" id="tab1">
                    <div class="col-sm-12">
                        <table id="tabla1" class="tablesorter table" style="display:none;">
                            <thead style="text-align: center;">
                            <th>Ejercicio</th>
                            <th>AP</th>
                            <th>Movimiento</th>
                            <th>Env&iacute;o</th>
                            <th>Oficio</th>
                            <th>Fuente</th>
                            <th>Inversi&oacute;n</th>
                            <th>Recurso</th>
                            <th>Ejercido</th>
                            </thead>
                            <tbody style="text-align: center;">
                            </tbody>
                        </table>
                        <table id="tabla2" class="tablesorter table" style="display:none;">
                            <thead style="text-align: center;">
                            <th>Ejercicio</th>
                            <th>Oficio</th>
                            <th>Movimiento</th>
                            <th>Firma</th>
                            <th>Fuente</th>
                            <th>Inversi&oacute;n</th>
                            <th>Recurso</th>
                            <th>Autorizado</th>
                            </thead>
                            <tbody style="text-align: center;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row"></div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <table id="tablaAp" class="tablesorter table">
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
                    <div class="col-sm-2">
                        <span id="btnTodos" class="btn btn-default col-md-12">Todos</span>
                        <span id="btnNinguno" class="btn btn-default col-md-12">Ninguno</span>
                        <span id="btnQuitar" class="btn btn-default col-md-12">Quitar</span>
                    </div>
                </div>
            </div>
            <div class="form-horizontal">
                <div class="col-sm-2">
                    <span id="btnReload" class="btn btn-danger">Limpiar</span>
                </div>
                <div class="col-sm-2">
                    <span id="btnDevolucion" class="btn btn-default">Devoluciones</span>
                </div>
                <div class="col-sm-2">
                    <span id="btnGuardar" class="btn btn-success">Guardar</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogDevolucion" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Devoluci&oacute;n</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="col-sm-12">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="fecDev">Fecha:</label><input type="text" id="fecDev"/>
                                </div>
                                <div class="col-sm-6">
                                    <label>Oficio:</label><input type="text" id="oficioDev"/>
                                </div>
                            </div>
                            <div class="row"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="obsDev">Observaciones:</label><textarea id="obsDev"></textarea>
                                </div>
                            </div>
                            <div class="row"></div>
                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-10">
                                    <span id="btnGuardarDevolucion" class="btn btn-success">Devolver</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>

                    <div class="col-sm-12">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <table id="tablaDev" class="tablesorter table">
                                        <thead style="text-align: center;">
                                        <th>Devoluci&oacute;n</th>
                                        <th>Oficio</th>
                                        <th>Devolvi&oacute;</th>
                                        <th>Observaciones</th>
                                        </thead>
                                        <tbody style="text-align: center;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    

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
