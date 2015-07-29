<div class="panel panel-default" id="clictotal">
    <div class="panel-heading">
        <h1 class="panel-title"><strong> ANEXO 4</strong></h1>
    </div>
    <div class="panel-body">        
        <div class="form-group panel-body">                      
            <div class="row" id="rowContratosReduccion">
                <div class="col-md-12 panel-body">
                    <div class="panel panel-success">
                        <div class="panel-heading"><b>Datos generales de los contratos</b></div>
                        <div class="panel-body">
                            <table class="table table-hover" id="tablaContratosReduccion">
                                <thead>                     
                                    <tr>
                                        <th style="display: none;" >idContrato 0</th>
                                        <th >N&uacute;mero de Contrato</th>
                                        <th >Fecha de celebraci&oacute;n</th>
                                        <th style="display: none;">descripcion 3</th>
                                        <th style="display: none;">rfcEmp 4</th>
                                        <th style="display: none;">numPadron 5</th>
                                        <th >Nombre de la empresa</th>
                                        <th style="display: none;">tipoCont 7</th>
                                        <th style="display: none;">modAdj 8</th>                                        
                                        <th >Monto</th>
                                        <th style="display: none;">fecInicio 10</th>
                                        <th style="display: none;">fecTermino 11</th>
                                        <th style="display: none;">diasCont 12</th>
                                        <th style="display: none;">dispoInm 13</th>
                                        <th style="display: none;">motivosDispo 14</th>
                                        <th style="display: none;">fecDispo 15</th>
                                        <th style="display: none;">tipoObrCont 16</th>
                                        <th >Acci&oacute;nes</th>
                                        <th style="display: none;">conceptos 18</th>
                                        <th style="display: none;">garantia 19</th>
                                        <th style="display: none;">anticipo 20</th>
                                        <th style="display: none;">avance fisico 21</th>
                                        <th style="display: none;">avance financiero 22</th>
                                        <th style="display: none;">idRfc empresa 23</th>
                                        <th style="display: none;">idContratoPadre  24</th>                                        
                                        <th style="display: none;">montoAutActual  25</th>                                     
                                        <th style="display: none;">estatus  26</th>                                     
                                    </tr>
                                </thead>
                                <tbody >
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">                            
                            <span class="btn btn-default" id="addConvenioReduccion">Agregar convenio</span>
                        </div>
                    </div>
                </div>            
            </div>                  
        </div>       
    </div>    
</div>
<div id="modalAddConvenio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Datos generales del contrato</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idcontrato" name="idcontrato" />
                <input type="hidden" id="idcontratoPadre" name="idcontratoPadre" />
                <input type="hidden" id="indexTableContrato" name="indexTableContrato" />
                <input type="hidden" id="isEditContrato" name="isEditContrato" />                
                <input type="hidden" id="isConvenio" name="isConvenio" />                
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >N&uacute;mero:</span>
                            <input type="text" class="form-control obligatorioHoja4" placeholder="" aria-describedby="basic-addon1" id="noContrato" name="noContrato"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >F. de celebraci&oacute;n:</span>
                            <input type="text" class="form-control  fechaHoja4 obligatorioHoja4" placeholder="" id="fecCelebracion" name="fecCelebracion" readonly="true" style="background-color: white !important; cursor: pointer !important;"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <h4><span class="label label-default" >Objeto del convenio:</span></h4>
                    </div>                        
                    <div class="col-md-9">
                        <textarea class="form-control obligatorioHoja4" placeholder="" id="descContrato" name="descContrato"></textarea>
                    </div>                        
                </div>
                <div class="row form-group">                     
                    <div class="col-md-6">
                        <div title="RFC no existe" id="popRFC">
                            <div class="input-group">
                                <span class="input-group-addon" >RFC de empresa:</span>
                                <input type="hidden" id="idRFC" name="idRFC" />
                                <input type="text" class="form-control obligatorioHoja4" placeholder="" id="empresaRFC" name="empresaRFC" />                            
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Padr&oacute;n del contratista:</span>
                            <input type="text" class="form-control " placeholder="" id="numPadronContratista" name="numPadronContratista" />
                        </div>
                    </div>
                </div>   
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" >Empresa:</span>
                            <input type="text" class="form-control obligatorioHoja4" placeholder="" id="empresaContrato" name="empresaContrato" />
                        </div>
                    </div>
                </div>                              
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" >Unidad Ejecutora u organismo:</span>
                            <span class="form-control" id="orgOfObr"></span>
                        </div>
                    </div>                 
                </div>                
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Tipo de contrato:</span>
                            <select id="tipoContrato" class="form-control obligatorioHoja4">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>                                                      
                </div>                
<!--                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Oficio de asignaci&oacute;n:</span>
                            <span id="numOfiAsiContrato" class="form-control"></span>
                        </div>
                    </div>                 
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Fecha de oficio de asignaci&oacute;n:</span>
                            <span id="fecOfiAsiContrato" class="form-control"></span>                                
                        </div>
                    </div>                 
                </div>                -->
                <div class="row form-group">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tblFuenteContrato">
                            <thead>
                                <tr class="success">
                                    <th>Fuente de financiamiento</th>
                                    <th>%</th>
                                    <th>Monto total</th>
                                    <th>Monto disponible</th>
                                </tr>
                            </thead>
                            <tbody>                               
                            </tbody>
                        </table>
                    </div>
                </div>                
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Modalidad de Adjudicaci&oacute;n:</span>
                            <select id="modAdjContrato" class="form-control obligatorioHoja4">
                                <option value="">Seleccione</option>
                            </select>                                                            
                        </div>
                    </div>
<!--                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Partida presupuestal:</span>
                            <span id="partidaContrato" name="partidaContrato" class="form-control" style="overflow-y: auto;"></span>                              
                        </div>
                    </div>-->
                </div>                
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >N&uacute;mero de obra:</span>
                            <span id="numObrContrato" class="form-control"></span>                                
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon" >Nombre de obra:</span>
                            <span id="nomObrContrato" class="form-control" style="overflow-y: auto;"></span>                                
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Cobertura:</span>
                            <span id="coberturaContrato" class="form-control">cobertura de la obra</span>                                
                        </div>
                    </div>                    
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <h4><span class="label label-default" >Despcripci&oacute;n de la obra:</span></h4>
                    </div>                        
                    <div class="col-md-9">
                        <span id="descObrContrato"></span>
                    </div>                   
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Monto del contrato (incluye IVA):</span>
                            <input type="text" id="montoContrato" name="montoContrato" class="form-control numero2" readonly="true"/>                                
                        </div>
                    </div>                    
<!--                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Asignaci&oacute;n inicial:</span>
                            <span type="text" id="asigIniContrato" name="montoContrato" class="form-control"></span>                                
                        </div>
                    </div>                    -->
                </div>                
                <div class="row form-group">                                        
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Disponibilidad del inmueble:</span>
                            <select id="dispInmuContrato" class="form-control obligatorioHoja4">
                                <option value="">Seleccione</option>
                                <option value="1">S&iacute;</option>
                                <option value="0">No</option>
                            </select>                                
                        </div>
                    </div>                    
                </div>
                <div class="row form-group" style="display: none;" id="rowMotivos">
                    <div class="col-md-7">
                        <div class="col-md-3">
                            <h4><span class="label label-default" >Motivos:</span></h4>
                        </div>                        
                        <div class="col-md-9">
                            <textarea class="form-control obligatorioHoja4" id="motivosNoDispContrato" name="motivosNoDispContrato"></textarea>
                        </div>  
                    </div>                    
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon" >Fecha de disponibilidad:</span>
                            <input type="text" id="fecDisponibilidadInm" name="fecDisponibilidadInm" class="form-control fechaHoja4 obligatorioHoja4" readonly="true" style="background-color: white !important; cursor: pointer !important;"/>                               
                        </div>
                    </div>                    
                </div>                               
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Tipo de obra (contrato):</span>
                            <select id="tipObrContr" class="form-control obligatorioHoja4">
                                <option value="">Seleccione</option>                                
                            </select>                                
                        </div>  
                    </div>                                                           
                </div>                               
            </div>
            <div class="modal-footer">                   
                <span  id="btnAddConvenio" name="btnAddConvenio" class="btn btn-primary col-md-offset-6" >Aceptar</span>
                <span id="btnCancelConvenio" name="btnCancelConvenio" data-dismiss="modal" class="btn btn-primary" >Cancelar</span>
            </div>
        </div>
    </div>
</div>

<div id="modalDetalleContrato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Datos generales del convenio</h4>
            </div>
            <div class="modal-body">                            
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >N&uacute;mero:</span>
                            <span class="form-control" placeholder="" aria-describedby="basic-addon1" id="noContratoC"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >F. de celebraci&oacute;n:</span>
                            <span type="text" class="form-control" id="fecCelebracionC" ></span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <h4><span class="label label-default" >Objeto del convenio:</span></h4>
                    </div>                        
                    <div class="col-md-9">
                        <span id="descContratoC" ></span>
                    </div>                        
                </div>
                <div class="row form-group">                     
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >RFC de empresa:</span>
                            <span class="form-control" id="empresaRFCC"></span>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Padr&oacute;n del contratista:</span>
                            <span class="form-control" id="numPadronContratistaC"></span>
                        </div>
                    </div>
                </div>   
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" >Empresa:</span>
                            <span class="form-control" id="empresaContratoC"></span>
                        </div>
                    </div>
                </div>                              
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" >Unidad Ejecutora u organismo:</span>
                            <span class="form-control" id="orgOfObrC"></span>
                        </div>
                    </div>                 
                </div>                
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Tipo de contrato:</span>
                            <span id="tipoContratoC" class="form-control"></span>
                        </div>
                    </div>                                                      
                </div>                
<!--                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Oficio de asignaci&oacute;n:</span>
                            <span id="numOfiAsiContratoC" class="form-control"></span>
                        </div>
                    </div>                 
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Fecha de oficio de asignaci&oacute;n:</span>
                            <span id="fecOfiAsiContratoC" class="form-control"></span>                                
                        </div>
                    </div>                 
                </div>                -->
                <div class="row form-group">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tblFuenteContratoC">
                            <thead>
                                <tr class="success">
                                    <th>Fuente de financiamiento</th>
                                    <th>%</th>
                                    <th>Monto total</th>
                                    <th>Monto disponible</th>
                                </tr>
                            </thead>
                            <tbody>                               
                            </tbody>
                        </table>
                    </div>
                </div>                
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Modalidad de Adjudicaci&oacute;n:</span>
                            <span id="modAdjContratoC" class="form-control"></span>                                                            
                        </div>
                    </div>
<!--                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Partida presupuestal:</span>
                            <span id="partidaContratoC" class="form-control" style="overflow-y: auto;"></span>                              
                        </div>
                    </div>-->
                </div>                
                <div class="row form-group">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon" >N&uacute;mero de obra:</span>
                            <span id="numObrContratoC" class="form-control"></span>                                
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon" >Nombre de obra:</span>
                            <span id="nomObrContratoC" class="form-control" style="overflow-y: auto;"></span>                                
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Cobertura:</span>
                            <span id="coberturaContratoC" class="form-control"></span>                                
                        </div>
                    </div>                    
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <h4><span class="label label-default" >Despcripci&oacute;n de la obra:</span></h4>
                    </div>                        
                    <div class="col-md-9">
                        <span id="descObrContratoC"></span>
                    </div>                   
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Monto del convenio (incluye IVA):</span>
                            <span id="montoContratoC" class="form-control numero2"></span>                                
                        </div>
                    </div>                    
<!--                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Asignaci&oacute;n inicial:</span>
                            <span id="asigIniContratoC" class="form-control"></span>                                
                        </div>
                    </div>                    -->
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">Plazo de ejecuci&oacute;n</div>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Fecha de inicio:</span>
                                            <span class="form-control" id="fecInicioContrC"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Fecha de t&eacute;rmino:</span>
                                            <span class="form-control" id="fecTerminoContrC"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon" >D&iacute;as calendario:</span>
                                            <span id="diasContratoC" class="form-control"></span>                                
                                        </div> 
                                    </div>
                                </div>                                
                            </div>
                        </div>                             
                    </div>                    
                </div>
                <div class="row form-group">                                        
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Disponibilidad del inmueble:</span>
                            <span id="dispInmuContratoC" class="form-control"></span>                                
                        </div>
                    </div>                    
                </div>
                <div class="row form-group" style="display: none;" id="rowMotivosC">
                    <div class="col-md-7">
                        <div class="col-md-3">
                            <h4><span class="label label-default" >Motivos:</span></h4>
                        </div>                        
                        <div class="col-md-9">
                            <span id="motivosNoDispContratoC" ></span>
                        </div>  
                    </div>                    
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon" >Fecha de disponibilidad:</span>
                            <span id="fecDisponibilidadInmC" class="form-control" ></span>                               
                        </div>
                    </div>                    
                </div>                               
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" >Tipo de obra (contrato):</span>
                            <span id="tipObrContrC" class="form-control"></span>                                
                        </div>  
                    </div>                                                           
                </div>                               
            </div>
            <div class="modal-footer">                   
                <span  id="btonCerrarDetalleContr" class="btn btn-primary col-md-offset-6" >Cerrar</span>               
            </div>
        </div>
    </div>
</div>

<div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Principales Conceptos de Trabajo</h4>
            </div>		  
            <div class="modal-body">
                <!--                <form class="form-horizontal" method="POST" id="formdemodal1">-->
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-4">Concepto de Trabajo:</div>
                            <div class="col-xs-16 col-md-8">
                                <input type="text" class="form-control " placeholder="Ingresa" id="contrato" name="contrato" value=""/>
                                <input type="hidden" id="isEdit" name="isEdit" value="0"/>
                                <input type="hidden" id="indexTable" name="indexTable" value="0"/>
                                <input type="hidden" id="valIndex0" name="valIndex0" value="0"/>
                                <input type="hidden" id="isAdmin" name="isAdmin" value="0"/>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">ENE:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="ene" name="ene"  maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">FEB:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="feb" name="feb"  maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">MAR:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="mar" name="mar" value="" maxlength="40"/>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">ABR:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="abr" name="abr" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">MAY:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="may" name="may" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">JUN:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="jun" name="jun" value="" maxlength="40"/>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">JUL:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="jul" name="jul" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">AGO:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="ago" name="ago" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">SEP:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="sep" name="sep" value="" maxlength="40"/>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-1">OCT:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="oct" name="oct" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">NOV:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="nov" name="nov" value="" maxlength="40"/>
                            </div>
                            <div class="col-xs-2 col-md-1">DIC:</div>
                            <div class="col-xs-4 col-md-3">
                                <input type="text" class="form-control numerote mesFinanciero" placeholder="" id="dic" name="dic" value="" maxlength="40"/>
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-xs-18 col-md-12">
                            <div class="col-xs-2 col-md-2"><label class="col-lg-3 control-label">TOTAL:</label></div>
                            <div class="col-xs-4 col-md-3">
                                <label class="col-lg-3 control-label" id="totaldecontra">&nbsp;</label>                                    
                            </div>
                            <div class="col-xs-4 col-md-7">
                                <span id="agregamodal1" name="agregamodal1" class="btn btn-primary ">Agregar</span>                                    
                                <span   id="cancelarmodal1" name="cancelarmodal1" data-dismiss="modal" class="btn btn-primary ">Cancelar</span>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--                </form>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalConceptosContrato">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Conceptos</h4>
            </div>
            <div class="modal-body">
                <table class='table table-bordered' id="tablaConceptosHoja4" >
                    <thead>
                        <tr style="font-size: 10px;">
                            <th style="display: none;">id</th>
                            <th style=" text-align:center;">Clave por objeto de gasto</th>
                            <th>Concepto</th>
                            <th>Unidad de Medida</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Importe sin I.V.A</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th>Fuente</th>
                            <th style="display: none;">Relacion</th>
                            <th></th>
                            <th style="display: none;"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="btn btn-default" id="btnAcpetarConceptoContr">Aceptar</span>
                <span class="btn btn-primary" id="btnCancelConceptoContr">Cancelar</span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSeleccionContrato">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecci&oacute;n de contrato</h4>
            </div>
            <div class="modal-body">
                <table class='table table-bordered' id="tablaContratosToSelect">
                    <thead>
                        <tr>
                            <th>N&uacute;mero de Contrato</th>
                            <th>Fecha de celebraci&oacute;n</th>
                            <th>Nombre de la empresa</th>
                            <th>Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="btn btn-default" data-dismiss="modal">Cancelar</span>
                <span class="btn btn-success" id="btnAceptarContratoSelected">Aceptar</span>
            </div>
        </div>
    </div>
</div>

