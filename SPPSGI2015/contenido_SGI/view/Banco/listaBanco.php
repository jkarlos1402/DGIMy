<?php session_start(); ?>
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="contenido_sgi/view/js/jquery.mask.min.js" type="text/javascript"></script>
<script src='contenido_SGI/view/js/DT_bootstrap.js' type='text/javascript'></script>
<script src='contenido_SGI/view/js/banco/funcionesBanco.js' type='text/javascript'></script>
<!--<link href="contenido_SGI/view/css/styleAplicacion.css" rel="stylesheet">-->
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>

<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/styleAplicacion.css" rel="stylesheet">
<style type="text/css">

    #lista tr:first-child td{
        font-weight: bold;
    }

    #lista td{
        width: 100px;
        font-size: 12px;
    }

    #lista2 tr:first-child td{
        font-weight: bold;
    }
    #lista2 td{             
        font-size: 12px;
    }
    #lista2 td:first-child{        
        width: 250px;        
    }
    .negrita{
        font-weight: bold !important;
    }
    .mto{
        text-align: right;
    }

    /*
    #dialog1{
        position: absolute;
        top: 250px;
        background-color: #FFF;
        border: solid 1px #CCC;
        text-align: center
    }*/
</style>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <strong>Nuevos: </strong>
                <strong id="total"></strong>
            </h3>
            <center><h3 class="panel-title"><strong>Consulta de Banco</strong></h3></center>
        </div>
    </div>    
    <div class="col-sm-12">
        <div class="panel panel-default">
<!--            <div class="panel-heading">
                Listado de Solicitudes
            </div>-->
            <div class="panel-body">
                <div class="form-group">
                    <div id="conbco">
                        <table class='table table-bordered' id='tablaObservaciones'>
                            <thead>
                                <tr>
                                    <th style="width: 5%">No. Banco</th>
                                    <th style="width: 5%">No. Dictaminaci&oacute;n</th>
                                    <th style="width: 20%">Obra</th>
                                    <th style="width: 20%">Unidad Ejecutora</th>
                                    <th style="width: 10%">Fecha Movimiento</th>
                                    <th style="width: 10%">Estatus</th>
                                    <th style="width: 10%" class="number-int">Monto</th>                                    
                                    <th style="width: 5%"></th>
                                    <th style="display: none;" hidden="true"></th>
                                </tr>  
                            </thead>
                            <tbody id="resConsulta">
                            </tbody>
                        </table>
                    </div>
                </div>                                
                <div class="row"></div>                
            </div>
        </div>
    </div>
</div>

<div id="dialog1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Hist&oacute;rico de Observaciones del estudio socioecon&oacute;mico</h4>
            </div>
            <div class="modal-body" id="dialog1Contenido">
                <table id='lista' class='table table-bordered'>
                    <thead>
                        <tr>
                            <th width='100px'>Fecha</th>
                            <th width='100px'>Versi&oacute;n del estudio</th>               
                            <th width='100px'>Observaciones generales</th>                            
                            <th></th>
                        </tr> 
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">                                   
                <button id="cacelafor3" name="cacelafor3" data-dismiss="modal" class="btn btn-primary" >Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Observaciones del socioecon&oacute;mico</h4>
            </div>
            <div class="modal-body" id="dialog2Contenido">
                <table id='lista2' class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Inciso</th>
                            <th>P&aacute;gina</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">                                   
                <button id="cacelafor3" name="cacelafor3" data-dismiss="modal" class="btn btn-primary" >Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="formPdfDic" style="display: none"></div>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<form id="formFichaBco" method="post" action="contenido_SGI/view/Banco/fichaTecnica_pdf.php" target="_blank">
    <input type="hidden" name="idBcoFicha" id="idBcoFicha" />
</form>