<link href="contenido_SGI/view/css/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="contenido_sgi/view/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="contenido_sgi/view/js/jquery.mask.min.js" type="text/javascript"></script>
<script src='contenido_SGI/view/js/DT_bootstrap.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="contenido_sgi/view/js/expedienteTecnico/expedienteTecnico.js"></script>
<script src="contenido_sgi/view/js/expedienteTecnico/consultaExpediente.js"></script>

<fieldset>
    <center><legend>Consulta de Expediente T&eacute;cnico</legend></center>
    <br>
    <div class="form-group">
        <div class="col-md-2"></div>
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Entre Fecha:</span>
                <input type="text" class="form-control" aria-describedby="basic-addon1" id="fecIni" name="fecIni"/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Y Fecha:</span>
                <input type="text" class="form-control" aria-describedby="basic-addon1" id="fecFin" name="fecFin"/>
            </div>
        </div>
        <div class="col-md-2">
            <span id="mostrarObras" class="btn btn-primary">Mostrar Expedientes</span>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br><br><br>
    <div class="form-group">
        <div class="col-md-6">
            <legend>Listado de Solicitudes</legend>
            <div class="form-group">
                <div id="conbco">
                    <table class="table table-bordered" id='tablaObservaciones'>
                        <thead>
                            <tr>
                                <th style="width:20%">No. Sol.</th>
                                <th style="width:20%">Tipo</th>
                                <th style="width:50%">Obra</th>
                                <th style="width:5%">Estatus</th>
                                <th style="width:5%"></th>
                            </tr>  
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <legend>Observaciones</legend>
            <div class="form-group">
                <div id="obsCollapse">
                    
                    
                </div>
            </div>
        </div>
    </div>


</fieldset>
