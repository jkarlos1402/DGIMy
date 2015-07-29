<meta charset="UTF-8">
<link href="contenido_sgi/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_sgi/view/css/datepicker3.css" rel="stylesheet">
<!--<link href="contenido_sgi/view/css/styleAplicacion.css" rel="stylesheet">-->
<script type="text/javascript" src="contenido_sgi/view/js/jquery-1.9.1.min.js"></script> 
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-datepicker.js"></script> 
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/autoNumeric.js" type="text/javascript"></script>
<script type="text/javascript" src="contenido_SGI/view/js/autorizacionPago/funcionesAplEnv.js"></script>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Env&iacute;o de Autorizaciones de Pago</strong></h3>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="folioAp">AP:</label><input type="text" id="folioAp"/>
                        </div>
                        <div class="col-sm-2" style="margin-top:25px;">
                            <span class="btn btn-default" style="display: none;" id='AgregarAp'>Agregar >></span>
                        </div>
                        <!--
                        <div class="col-sm-6">
                            <label for="acuerdo">Acuerdo:</label><input type="text" id="acuerdo"/>
                        </div>
                        -->
                    </div>
                    <div class="row"></div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="relacion">Relaci&oacute;n</label><input type="text" id="relacion" />
                        </div>
                    </div>
                </div>
                <input type="text" id="idAps" class="din" style="display:none;"/>
                <input type="text" id="CveAps" class="din" style="display:none;"/>
                <input type="text" id="idTipAps" class="din" style="display:none;"/>
                <input type="text" id="TipoFte" class="din" style="display:none;"/>
                <input type="text" id="monto" class="din" style="display:none;"/>
                <input type="text" id="montoAmortizacion" class="din" style="display:none;"/>
                <input type="text" id="NomUe" class="din" style="display:none;"/>
                <input type="text" id="idUe" class="din" style="display:none;"/>
                <input type="text" id="NomSec" class="din" style="display:none;"/>
                <input type="text" id="idSec" class="din" style="display:none;"/>
                <input type="text" id="NomEmp" class="din" style="display:none;"/>
                <input type="text" id="EjAp" class="din" style="display:none;"/>
                
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table id="tabla1" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th >idAps</th>
                                        <th>Autorizaci&oacute;n de Pago</th>
                                        <th >Tipo Ap</th>
                                        <th >Tipo fuente</th>
                                        <th >Monto</th>
                                        <th >Monto Amortizado</th>
                                        <th >Nom UE</th>
                                        <th >id UE</th>
                                        <th >Sector</th>
                                        <th >id Sector</th>
                                        <th >Beneficiario</th>
                                        <th >Ejercicio</th>                                        
                                        <th >idRelAps</th>                                        
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"></div>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">

                            <div class="col-sm-2">
                                <label for="ejercicio">Ejercicio</label><select id="ejercicio"></select>
                            </div>
                            <div class="col-sm-2">
                                <label for="fecEnvio" >Fecha de Env&iacute;o</label><input type="text" id="fecEnvio" />
                            </div>
                            <div class="col-sm-3">
                                <label for="tipoRelacion" >Tipo de Relaci&oacute;n</label><select id="tipoRelacion"></select>
                            </div>
                            <div class="col-sm-3">
                                <label for="oficioEnvio" >Oficio de Env&iacute;o</label><input type="text" id="oficioEnvio" value="DGI/DRCI/DRC"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-inline">                        
                        <div class="col-md-2 col-md-offset-10">
                            <span class="btn btn-success col-md-12" id='btnEnviar'>Guardar</span>
                        </div>
                        <div class="col-md-2 col-md-offset-10" >
                            <span class="btn btn-success col-md-12" id='btnPdf' style="display: none">PDF</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="FormularioPdf" style='display: none'>
    <form name='pdfEnvio' id='pdfEnvio' method='POST' action='contenido_SGI/model/autorizacionPago/envioAutorizacionPago.php' target='new'>

    </form>
</div>