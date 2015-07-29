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
<script src='contenido_SGI/view/js/oficios/funcionesListadoOficios.js' type='text/javascript'></script>

<div class="container-fluid">
    <center><legend>Consulta de Oficios</legend></center>
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
            <span id="mostrarObras" class="btn btn-primary">Mostrar Oficios</span>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br><br><br>
    <div class="form-group">
        <legend>Listado de Oficios</legend>
        <!--<div class="col-sm-1"></div>-->
        <div class="col-md-12">
            <div class="form-group">
                <div id="conoficios">
                    <table class="table table-bordered" id='tablaOficios'>
                        <thead>
                            <tr>
                                <th style="width: 5%"><b>Cve.&nbsp;Oficio</b></th>                                    
                                <th style="width: 5%"><b>Tipo&nbsp;de&nbsp;Oficio.</b></th>
                                <th style="width: 5%"><b>Id&nbsp;Solicitud.</b></th>
                                <th style="width: 5%"><b>Ejercicio</b></th>
                                <th style="width: 5%"><b>id&nbsp;Obra</b></th>
                                <th style="width: 30%"><b>Nombre&nbsp;de&nbsp;Obra</b></th>                                    
                                <th style="width: 5%"><b>Estatus</b></th>
                                <th style="width: 15%"><b>Fuente</b></th>
                            </tr>  
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

