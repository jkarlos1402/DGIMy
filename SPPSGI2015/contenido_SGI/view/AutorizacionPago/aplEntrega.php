<meta charset="UTF-8">
<link href="contenido_sgi/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_sgi/view/css/datepicker3.css" rel="stylesheet">
<script type="text/javascript" src="contenido_sgi/view/js/jquery-1.9.1.min.js"></script> 
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-datepicker.js"></script> 
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/autoNumeric.js" type="text/javascript"></script>
<script type="text/javascript" src="contenido_SGI/view/js/autorizacionPago/funcionesApEnt.js"></script>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Entrega de Autorizaciones de Pago</strong></h3>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="fecEntrega">Fecha de Entrega:</label><input type="text" id="fecEntrega"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="folioAp">Folio:</label><input type="text" id="folioAp"/><input type="hidden" id="idAp"/>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-7">
                            <span class="btn btn-default" style="margin-top: 20%; display:none;" id='btnAgregar'>Agregar >></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="tabla1" class="table table-bordered">
                                <thead >
                                    <tr>
                                        <th></th>
                                        <th>Autorizaci&oacute;n de Pago</th>
                                        <th>Fecha</th>
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
            <div class="form-group">
                <div class="col-md-2 col-md-offset-10">
                    <span class="btn btn-success col-md-12" id='entregarAp'>Entregar</span>
                </div>
            </div>
        </div>
    </div>
</div>