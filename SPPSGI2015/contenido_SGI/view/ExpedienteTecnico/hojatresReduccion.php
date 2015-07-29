<div class="panel panel-default" id="clictotal">
    <div class="panel-heading">
        <h1 class="panel-title"><strong> HOJA 3</strong></h1>
    </div>
    <div class="panel-body">
        <div>
            <p class="panel-title"><strong><h5>PRESUPUESTO DE LA OBRA O ACCI&Oacute;N  </h5></strong></p>
        </div>	
    </div>
    <div class="panel panel-default">

        <div class="form-group">
            <div><p class="panel-title">&nbsp;</p></div>
            <div class="row col-xs-16 col-md-12">
                <div class="col-xs-2 col-md-1">

                </div>
                <div class="col-xs-2 col-md-4">
                    <div class="col-md-6">
                        <div class="input-group" id="pp">
                            <span class="input-group-addon">
                                <input type="checkbox" id="pariPassu" checked="checked">
                            </span>
                            <input type="text" readonly class="form-control col-lg-1" aria-label="pariPassu" placeholder="Pari passu ">
                        </div><!-- /input-group -->
                    </div>

                </div>
                <div class="col-xs-2 col-md-2">
                    <span class="btn btn-default" id="abreModal">Agregar</span></a>
                </div>
                <div class="col-xs-2 col-md-5"></div>
            </div>
        </div> 

        <div class="container-fluid " id="divReduccion">
            <table class='table table-bordered' id="tablaConceptosReduccion" style="font-size: 12px;">
                <thead>
                    <tr tyle=" text-align:center;">
                        <th >id</th>
                        <th style=" text-align:center; font-size: 10px;">Clave<br>objeto de gasto</th>
                        <th>Concepto</th>
                        <th>Unidad<br>de<br>Medida</th>
                        <th>Cantidad</th>
                        <th>Precio<br>Unitario</th>
                        <th>Importe sin I.V.A</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Fuente</th>
                        <th>Relacion</th>
                        <th></th>
                        <th>Disponible</th>
                        <th>Reducci&oacute;n</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td ></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">Total:</td>
                        <td><span id="totalSinIva" class="number">0.00</span></td>
                        <td><span id="totalIva" class="number">0.00</span></td>
                        <td><span id="total" class="number">0.00</span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total:</td>
                        <td><span id="totalReduccion" class="number">0.00</span></td>
                    </tr>  
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div id="modalConcepto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></span>
                <h4 class="modal-title" id="myModalLabel">Cat&aacute;logo de Conceptos</h4>
            </div>		  
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon1">Clave por objeto de gasto:</span>
                            <input type="text" class="form-control" aria-describedby="sizing-addon1" id="clave" name="clave" value="" maxlength="40">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="input-group ">
                            <span class="input-group-addon" id="sizing-addon2">Concepto:</span>
                            <textarea class="form-control" id="concepto" name="concepto" rows="2" aria-describedby="sizing-addon2"></textarea>
                        </div>
                    </div>
                </div>    

                <div class="row form-group">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon3">Unidad de Medida:</span>
                            <input type="text" class="form-control" placeholder="" id="unidadm" name="unidadm"  maxlength="40" aria-describedby="sizing-addon3">
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon4">Cantidad:</span>
                            <input type="text" class="form-control number" placeholder="" id="cantidad" name="cantidad" value="" maxlength="40" aria-describedby="sizing-addon4">
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->

                <div class="row form-group">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon5">Precio Unitario:</span>
                            <input type="text" class="form-control number" placeholder="" id="preciou" name="preciou" value="" maxlength="40" aria-describedby="sizing-addon3">
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon6">Importe sin I.V.A.:</span>
                            <input type="text" class="form-control number" id="impsiniva" name="impsiniva" value="0.00" readonly="true" aria-describedby="sizing-addon4">
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->

                <div class="row form-group">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" aria-label="check" id="ivaCheck">
                                <input type="hidden" class="number" id="iva" name="iva">
                            </span>
                            <input type="text" readonly class="form-control col-lg-1" aria-label="ivaCheck" placeholder="I.V.A.">
                        </div><!-- /input-group -->
                    </div>
                    <div class="col-lg-9">
                        <div id="fte" style="display:none;">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon7">Fuente:</span>
                                <select id="ftes" class="form-control" aria-describedby="sizing-addon7"></select>
                            </div>            
                        </div>
                    </div>
                </div>
                
                <div class="row form-group" id="camposReduccion" style="display:none;">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon5">Monto Disponible:</span>
                            <input type="text" class="form-control number" placeholder="" id="reduccionEjercido" name="reduccionEjercido" value="" maxlength="40" readonly="true" aria-describedby="sizing-addon3">
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon6">Monto de Reducci&oacute;n:</span>
                            <input type="text" class="form-control number" id="reduccionMonto" name="reduccionMonto" aria-describedby="sizing-addon4">
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-2"><label class="col-lg-3 control-label">TOTAL:</label></div>
                            <div class="col-xs-4 col-md-3">
                                <label class="col-lg-3 control-label number" id="totalConcepto">0.00</label> </div>
                            <div class="col-xs-4 col-md-7">
                                <span   id="actualizarConcepto" name="actualizarConcepto" class="btn btn-primary" onclick="modificarConceptoReduccion()">Actualizar</span>
                                <input type="hidden" id="idContrato"/>
                                <input type="hidden" id="idFte"/>
                                <span   id="cancelarConcepto" name="cancelarConcepto" class="btn btn-primary ">Cancelar</span>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>