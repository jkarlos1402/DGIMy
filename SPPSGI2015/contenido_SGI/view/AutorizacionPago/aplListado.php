
<link href="contenido_sgi/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_sgi/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_sgi/view/css/styleAplicacion.css" rel="stylesheet">
<script type="text/javascript" src="contenido_sgi/view/js/jquery-1.9.1.min.js"></script> 
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-datepicker.js"></script> 
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script type="text/javascript" src="contenido_sgi/view/js/dropdown.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/autorizacionPago/funcionesApList.js"></script>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Listado de Autorizaciones de Pago</strong></h3>
        </div>
    </div>
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="col-sm-2">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Filtro por: &Uacute;ltimo mes
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupDrop1">
                        <li><a href="#" id="porMes">&Uacute;ltimo mes</a></li>
                        <li><a href="#" id="porFecha">Fecha</a></li>
                        <li><a href="#" id="porFolio">Folio</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-5">
                <div id="filtroFecha" style="display:none;">
                    <label for="FecCre" class="col-sm-3 control-label">Fecha:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="FecCre">
                    </div>
                    <div class="col-sm-2">
                        <span id="buscaFecha" class="btn btn-success">Buscar</span>
                    </div>
                </div>

                <div id="filtroFolio" style="display:none;">
                    <label for="CveAps" class="col-sm-3 control-label">Folio:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="CveAps">
                    </div>
                    <div class="col-sm-3">
                        <span id="buscaCve" class="btn btn-success">Buscar</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="col-sm-5">
                <table id="listadoAp" class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Folio</td><td>Fecha</td><td>Estatus</td><td></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="contDev" style="display:none;" class="col-sm-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Detalle de devoluci&oacute;n</strong><button type="button" id="cerrar" class="close" data-dismiss="modal" aria-hidden="true" title="Cerrar">x</button></h3>
                        
                    </div>

                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-sm-4">
                                Folio: <input type="text" id="FolCve" value="" />
                            </div>
                            <div class="col-sm-4">
                                Oficio de Devoluci&oacute;n: <input type="text" id="OfiDev" value="" />
                            </div>
                            <div class="col-sm-4">
                                Fecha de Devoluci&oacute;n: <input type="text" id="FecDev" value="" />
                            </div>
                        </div>
                        <div class="row"></div>
                        <div class="form-horizontal">
                            <div class="col-sm-6">
                                Motivo: <span id="motivoDev"></span>
                            </div>
                        </div>
                        <div class="row"></div>
                        <div class="form-horizontal">
                            <div class="cols-sm-12">
                                Observaciones: <textarea id="ObsDev" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
