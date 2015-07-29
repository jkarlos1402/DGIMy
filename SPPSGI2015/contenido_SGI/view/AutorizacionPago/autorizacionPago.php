 
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/jquery.bootstrap-touchspin.css" rel="stylesheet">
<!--<link href="contenido_SGI/view/css/styleAplicacion.css" rel="stylesheet">-->
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script> 
<script src="contenido_sgi/view/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src='contenido_SGI/view/js/DT_bootstrap.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/bootstrap-datepicker.js" type="text/javascript"></script> 
<script src="contenido_SGI/view/js/jquery.bootstrap-touchspin.js" type="text/javascript"></script> 
<script src="contenido_SGI/view/js/autoNumeric.js" type="text/javascript"></script>
<script type="text/javascript" src="contenido_SGI/view/js/nl.js"></script> 
<script type="text/javascript" src="contenido_SGI/view/js/autorizacionPago/funcionesAp.js"></script>
<style>
    .datepicker{z-index:1151 !important;}
    thead{background-color: #eee;}
    /*    .tabOficios tr {
        width: 100%;
        display: inline-table;
        }
        .tabOficios tbody{
          overflow-y: scroll;
          height: 100px;
          width: 100%;
         display:block;
        }*/
    .selected td{
        background-color: #C8EDAE ;
    }
    .bld td{
        background-color: #C8EDAE ;
    }
    .fondoBlanco td{
        background-color: white !important;
    }
    .number{
        text-align: right;
    }
</style>

<div class="container-fluid">
    <div class="panel-body form">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Registro de Autorizaciones de Pago</strong></h3>
            </div>
        </div>
        <div class="row form-horizontal col-md-offset-1">
            <div class="form-group ">
                <label class="col-md-1 control-label" for="accion">Acci&oacute;n:</label>
                <div class="col-sm-2">
                    <select id="accion" name="accion" class="form-control">
                        <option value="-1">Seleccione...</option>
                        <option value="1">Creaci&oacute;n</option>
                        <option value="2">Modificaci&oacute;n</option>
                        <!--                        <option value="3">Devoluci&oacute;n</option>-->
                    </select>
                </div>
                <div id="divobra" style="display:none;">
                    <label class="col-md-1 control-label" for="idObra">Obra:</label>
                    <div class="col-sm-2">
                        <input id="idObra" name="idObra" type="text" placeholder="" class="form-control input-md enc">
                    </div>
                </div>
                <div id="divfolio" style="display:none;">
                    <label class="col-md-1 control-label" for="cveAp">Folio:</label> 
                    <div class="col-sm-2">
                        <input id="cveAp" name="cveAp" type="text" placeholder="" class="form-control input-md enc" value="">
                    </div>
                </div>
                <div id="divperiodo" style="display:none;">
                    <label class="col-md-1 control-label" for="periodo">Periodo:</label> 
                    <div class="col-sm-2">
                        <select id="periodo" name="periodo" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <span id="btnbuscar" class="btn btn-default">Buscar</span>
                </div>
                <div class="col-sm-2" style="display:none;">
                    <span id="btnReload" class="btn btn-danger">Limpiar</span>
                </div>
                <!--                <div id="fechaF" style="display:none;">
                                    <label for="fecha" class="col-sm-1 control-label">Fecha:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="fecha"/>
                                    </div>
                                </div>-->
            </div>
        </div>
    </div>

    <div class="row"></div>

    <div id="conGeneral" style="display:none;">
        <div class="panel panel-default">
            <div class="panel-heading">
                Datos Generales
            </div>
            <div class="panel-body form">
                <div class="row form-group">
                    <label for="estimacionAp" class="col-sm-1 control-label">Estimaci&oacute;n:</label>
                    <div class="col-md-1">
                        <input type="text" id="estimacionAp" value="0"/>
                    </div>

                    <label for="ejecutoraAp" class="col-sm-1 control-label">Ejecutora:</label>
                    <div class="col-sm-9">
                        <input type="text" id="ejecutoraAp" readonly="true"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="rfcAp" class="col-sm-1 control-label">RFC:</label>
                    <div class="col-sm-2">
                        <input type="text" id="rfcAp"/><input type="text" id="idEmpAp" style="display:none;" />
                    </div>

                    <label for="beneficiarioAp" class="col-sm-1 control-label">Beneficiario:</label>
                    <div class="col-sm-8">
                        <input type="text" id="beneficiarioAp" readonly="true"/>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="observacionesAp" class="col-sm-1 control-label">Observaciones:</label>
                    <div class="col-sm-12">
                        <textarea id="observacionesAp"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row form-group col-md-offset-0">
            <label for="idTipAps" class="col-sm-1 control-label">Movimiento:</label>
            <div class="col-sm-3">
                <select id="idTipAps" name="idTipAps" class="form-control">
                </select>
            </div>
        </div>


        <div class="row form-group col-md-offset-0" id="divContratos" style="display:none;">
            <label for="contrato" class="col-sm-1 control-label">Contrato:</label>
            <div class="col-sm-9">
                <select id="contrato" name="contrato" class="form-control">
                </select>
                <input type="hidden" id="derechoAnticipo" value="0">
                <input type="hidden" id="porcentajeAnticipo" value="0" >
            </div>
        </div>

        <div class="row form-group col-md-offset-0" id="divContratoAnticipo" style="display:none;">
            <div class="row form-group col-md-offset-0">
                <label for="contratoAnticipo" class="col-sm-1 control-label">Contrato:</label>
                <div class="col-sm-9">
                    <select id="contratoAnticipo" name="contratoAnticipo" class="form-control">
                    </select>
                </div>
            </div>
        </div>

        <div class="row form-group col-md-offset-0" id="divAnticipoAdm" style="display:none;">
            <div class="row form-group col-md-offset-0">
                <label for="montoObraAdm" class="col-sm-2 control-label">Monto autorizado de la obra:</label>
                <div class="col-sm-2">
                    <input type="text" id="montoObraAdm" class="number" readonly="true"/>
                </div>
                <label for="montoDisponibleObraAdm" class="col-sm-2 control-label">Monto disponible de la obra:</label>
                <div class="col-sm-2">
                    <input type="text" id="montoDisponibleObraAdm" class="number" readonly="true"/>
                </div>
            </div>
            <div class="row form-group col-md-offset-0">
                <label for="montoAnticipoAdm" class="col-sm-1">Anticipo:</label>
                <!--                <div class="col-sm-2">
                                    <input type="text" id="porcentajeAnticipoAdm" value="0" onchange="calculaMontoAnticipoTotal(1)"/>
                                </div>-->
                <div class="col-sm-2">
                    <input type="text" class="number" id="montoAnticipoAdm" value="0.00"/>
                </div>
                <div class="col-sm-1">
                    <span class="btn btn-default" id="calcularAnticipoAdm" onclick="calculaAnticipoFuente()">Calcular</span>
                </div>
            </div>
        </div>
        <div class="row form-group col-md-offset-0">
            <div class="col-sm-9 col-md-offset-1">
                <table id="tablaFuentesAnticipo" class="table table-bordered" style="display:none;">
                    <thead>
                    <th>idFte</th>
                    <th>Fuente de financiamiento</th>
                    <th>Cuenta</th>
                    <th>Monto de anticipo</th>
                    <th>Folio A.P.</th>
                    </thead>
                </table>
            </div>
        </div>

        <div class="row form-group col-md-offset-0" id="divFuentes" style="display:none;">
            <label for="fuentes" class="col-sm-1 control-label">Fuente:</label>
            <div class="col-sm-9">
                <select id="fuentes" name="fuentes" class="form-control">
                </select>
            </div>
        </div>

        <div class="row form-group col-md-offset-0" id="divCombosParaAmortizar" style="display:none;">
            <div class="row form-group">
                <div class="col-sm-5">
                    <label for="foliosAmortizar" class="col-sm-5 control-label">Folio a amortizar:</label>
                    <div class="col-sm-7">
                        <select id="foliosAmortizar" name="foliosAmortizar" onchange="setDisponibleAmortizar();" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <label for="montoPorAmortizar" class="col-sm-5 control-label">Monto por amortizar:</label>
                    <div class="col-sm-5">
                        <input type="text" class="number" id="montoPorAmortizar" value="0.00" readonly="true"/>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-1 col-md-offset-3">
                    <span class="btn btn-default" id="generaAmortizacion">Comprobar</span>
                    <span class="btn btn-default" id="agregarAmortizacion" style="display:none;">Agregar</span>
                </div>
                <div class="col-sm-5 col-md-offset-1" id="divParaAmortizar" style="display:none;">
                    <label for="montoPorAmortizar" class="col-sm-5 control-label">Monto:</label>
                    <div class="col-sm-5">
                        <input type="text" class="number" id="montoParaAmortizar" onchange="verificaMontoAmort();" value="0.00"/>
                    </div>
                </div><!--
                -->
            </div>
        </div>

        <div class="row form-group col-md-offset-0" id="divFolioParaAmortizar" style="display:none;">
            <label for="CveApAmortizar" class="col-sm-5 control-label">Folio a amortizar: <span id="CveApAmortizar"></span></label>
            <input type="text" id="folioParaAmortizar" style="display:none;">
        </div>

        <div class="row form-group col-md-offset-0">
            <div id="divEstimar" class="col-md-2" style="display:none;">
                <span class="btn btn-primary" id="btnEstimar">Estimaciones</span>
            </div>

            <div id="divAmortizar" class="col-md-1" style="display:none;">
                <span class="btn btn-primary" id="btnAmortizar">Amortizaciones</span>
            </div>
            
            <div id="divPagos" class="col-md-1" style="display:none;">
                <span class="btn btn-primary" id="btnPagos">Pagos</span>
            </div>
        </div>

        <div class="col-sm-8" >
            <div class="panel panel-default" id="movimientos" style="display:none;">
                <div class="panel-heading">
                    Movimientos
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">

                        <div class="row"></div>
                        <div class="form-group col-sm-12">
                            <table id="tablaMovimientos" class="table table-bordered" style="font-size: 11px">
                                <thead style="text-align: center;">
                                <th>id movimiento</th>
                                <th>Ejercicio</th>
                                <th>Obra</th>
                                <th>Contrato</th>
                                <th>id tipo movimiento</th>
                                <th>Movimiento</th>
                                <th>Oficio</th>
                                <th>idFte</th>
                                <th>Fuente</th>
                                <th>Cuenta</th>
                                <th>Afectaci&oacute;n</th>
                                <th></th>
                                <th></th>
                                </thead>
                                <tbody style="text-align: center;">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-horizontal">

                <div class="col-sm-2" id="divGuardar">
                    <span id="btnGuardar" class="btn btn-success" onclick="guardarAp()">Guardar</span>
                </div>
                <div class="col-sm-2" id="divagregarAnticipo" style="display:none;">
                    <input type="hidden" id="montoTotalAnticipo"/>
                    <span class="btn btn-primary" id="agregarAnticipo"  onclick="agregarMovimiento()">Generar</span>
                </div>

                <div class="col-sm-3" id="divCerrar" style="display:none;">
                    <span id="btnCerrar" class="btn btn-success" onclick="cerrarAp();" >Cerrar registro</span>
                </div>
                <div class="col-sm-4" id="divComprobacion" style="display:none;">
                    <span class="btn btn-primary" id="btnComprobacion" >Documentaci&oacute;n Comprobatoria</span>
                </div>
                <div class="col-sm-2" id="divImpresion" style="display:none;">
                    <span id="btnImpresion" class="btn btn-default"  onclick="generaPDF();">Imprimir</span>
                </div>

            </div>
        </div>

        <div class="col-sm-4" id="divPresupuestal"  style="display:none;">
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
                                        <label for="sinivaAp">Importe sin IVA:</label><input type="text" id="sinivaAp" class="number afectPresu" readonly="true" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="icicAp">I.C.I.C (0.2%):</label><input type="text"  id="icicAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="amortizacionAp">Amortizaci&oacute;n:</label><input type="text" id="amortizacionAp" class="number afectPresu" readonly="true" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="cmicAp">C.M.I.C (0.5%):</label><input type="text" id="cmicAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="subtotalAp">Subtotal:</label><input type="text" id="subtotalAp" class="number afectPresu" readonly="true" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="supervisionAp">Supervisi&oacute;n (2%):</label><input type="text" id="supervisionAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="ivaAp">IVA:</label><input type="text" id="ivaAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="isptAp">ISPT:</label><input type="text" id="isptAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="afectacionAp">A. Presupuestal:</label><input type="text" id="afectacionAp" class="number afectPresu" readonly="true" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="otroAp">Otro:</label><input type="text" id="otroAp" class="number afectPresu edit" value="0.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="netoAp">Importe Neto:</label><input type="text" id="netoAp" class="number afectPresu" readonly="true" value="0.00"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="retencionesAp">Retenciones:</label><input type="text" id="retencionesAp" class="number afectPresu" readonly="true" value="0.00"/>
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
    </div>





</div>

<div class="modal fade" id="dialogEstimacion" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Estimaci&oacute;n de conceptos</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="container-fluid " id="divEstimaciones">
                        <div class="row form-group col-md-offset-0">
                            <span class="btn btn-default" id="btnAgregaConceptoEst">Agregar Concepto</span>
                        </div> 
                        <table class='table table-bordered' id="tablaMontosEst" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>idMov</th>
                                    <th>idPresu</th>
                                    <th style=" text-align:center;">Clave por objeto de gasto</th>
                                    <th>Concepto</th>
                                    <th>Importe sin I.V.A.</th>
                                    <th>I.V.A.</th>
                                    <th>Total</th>
                                    <th>Disponible</th>
                                    <th>Total a Estimar</th>
                                    <th>IVA Estimacion</th>
                                    <th>Total Estimacion con IVA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
<!--                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>  
                            </tfoot>-->
                        </table>
                    </div>
                </div>

                <div class="form-horizontal">
                    <input type="hidden" id="conceptoActual">
                    <input type="hidden" id="indexConceptos">
                    <div class="col-md-6">
                        <div class="panel panel-default" id="gridAfectacionPresupuestal" style="display:none;">
                            <div class="panel-heading">
                                Estimaci&oacute;n de Concepto
                            </div>
                            <div class="panel-body">
                                <div class="row form-group" id="stConcepto">
                                    <label for="totalEstCon" class="col-md-5 control-label">Subtotal:</label>
                                    <div class="col-md-7"> 
                                        <input type="text" id="totalEstCon" class="number inputAfectPresu" />
                                    </div> 
                                </div>  
                                <div class="row form-group" id="iConcepto">
                                    <label for="ivaEstCon" class="col-md-5 control-label">I.V.A:</label>
                                    <div class="col-md-7">
                                        <input type="text" id="ivaEstCon" class="number inputAfectPresu" />
                                    </div> 
                                </div>  
                                <div class="row form-group" id="tConcepto">
                                    <label for="totalEstIvaCon" class="col-md-5 control-label">Total:</label>
                                    <div class="col-md-7">
                                        <input type="text" id="totalEstIvaCon" class="number inputAfectPresu" />
                                    </div> 
                                </div>  

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default" id="estGeneral">
                            <div class="panel-heading">
                                Estimaci&oacute;n General
                            </div>
                            <div class="panel-body">
                                <div class="row form-group" id="stEstimar">
                                    <label for="subtotalEstimar" class="col-md-5 control-label">Subtotal:</label>
                                    <div class="col-md-7">
                                        <input type="text" id="totalEstimar" value="0" class="number" readonly="true"/>
                                    </div> 
                                </div>   
                                <div class="row form-group" id="iEstimar">
                                    <label for="ivaEstimar" class="col-md-5 control-label">I.V.A.:</label>
                                    <div class="col-md-7">
                                        <input type="text" id="ivaEstimar" value="0" class="number" readonly="true"/>
                                    </div>
                                </div>
                                <div class="row form-group" id="tEstimar">
                                    <label for="totalConIva" class="col-md-5 control-label">Total con I.V.A.:</label>
                                    <div class="col-md-7">
                                        <input type="text" id="totalConIva" value="0" class="number" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="col-md-4 bg-success panel-body" id="divInfAmort" style="display:none;">Monto por Amortizar: <span style="font-weight: bold;" id="mntAm"></span></div>
                    <span class="btn btn-primary" id="agregarMovimiento" onclick="agregarMovimiento('new')">Agregar</span>
                    <span class="btn btn-primary" id="updateMovimiento" style="display:none;">Actualizar</span>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogComprobantes" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Comprobantes</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group col-md-offset-0">
                    <span class="btn btn-default" id="btnAgregarFactura">Agregar Factura/Comprobante</span>
                </div> 
                <table class='table table-bordered' id="tablaComprobantes" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>idAp</th>
                            <th>No. Folio</th>
                            <th>Tipo de Documento</th>
                            <th>Importe</th>
                            <th>Partida Presupuestal</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-primary" id="btnAgregarComprobantes">Guardar</button>                    
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogFacturas" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Registro de Facturas/Comprobantes</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon1">No. Folio:</span>
                            <input type="text" class="form-control" aria-describedby="sizing-addon1" id="folioComprobante">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="input-group ">
                            <span class="input-group-addon" id="sizing-addon2">Tipo de Documento:</span>
                            <textarea class="form-control" id="tipoComprobante" rows="10" aria-describedby="sizing-addon2"></textarea>
                        </div>
                    </div>
                </div>    

                <div class="row form-group">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon5">Importe $:</span>
                            <input type="text" class="form-control number" placeholder="" id="importeComprobante" aria-describedby="sizing-addon3">
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon6">Partida Presupuestal:</span>
                            <input type="text" class="form-control" id="partidaComprobante" aria-describedby="sizing-addon4">
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->

                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-4 col-md-7">
                                <span id="agregaComprobante" class="btn btn-primary ">Agregar</span>
                                <span id="actualizarComprobante" class="btn btn-primary" style="display:none;">Actualizar</span>
                                <span class="btn btn-primary " data-dismiss="modal">Cancelar</span>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="dialogConceptos" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Conceptos</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid " id="divConceptos">
                    <table class='table table-bordered' id="tablaConceptos" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th style=" text-align:center;">Clave por objeto de gasto</th>
                                <th>Concepto</th>
                                <th>Unidad de Medida</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Importe sin I.V.A</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Disponible</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-success"  id="btnSeleccionarConceptos">Agregar</button>                    
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








<!--<div class="modal fade" id="dialogComprobantes" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Comprobantes</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group col-md-offset-0">
                    <span class="btn btn-default" id="btnAgregarFactura">Agregar Factura/Comprobante</span>
                </div> 
                <table class='table table-bordered' id="tablaFacturas" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>idFactura</th>
                            <th>No. Folio</th>
                            <th>Tipo de Factura</th>
                            <th>Importe</th>
                            <th>Partida Presupuestal</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogFacturas" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="tituloDialog">Registro de Facturas/Comprobantes</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label for="facturaComprobante" class="col-md-3 control-label">Factura/Comprobante:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="facturaComprobante" value="0"/>
                    </div>
                    <label for="fechaFactura" class="col-md-1 control-label">Fecha:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="fechaFactura" value="0"/>
                    </div>
                </div>
                <div class="row form-group col-md-offset-0">
                    <span class="btn btn-default" id="btnAgregarConceptoFactura">Agregar Concepto</span>
                </div> 
                <table class='table table-bordered' id="tablaConceptoFacturas" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th style=" text-align:center;">Clave por objeto de gasto</th>
                            <th>Concepto</th>
                            <th>Total a Estimar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td ></td>
                            <td></td>
                            <td>Total:</td>
                            <td></td>
                        </tr>  
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">                    
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarAviso">Cerrar</button>                    
                </div>
            </div>
        </div>
    </div>
</div>-->
<input type="hidden" id="nomObra">
<input type="hidden" id="preAutorizado">
<input type="hidden" id="modEje">
<input type="hidden" id="importeContrato">
<input type="hidden" id="noContrato">
<input type="hidden" id="fechaContrato">
<input type="hidden" id="fechaIniContrato">
<input type="hidden" id="fechaFinContrato">


<form id="impresionForm" style="display:none;" method="post" target="_blank" action="contenido_sgi/model/autorizacionPago/impresionAp.php">

</form>