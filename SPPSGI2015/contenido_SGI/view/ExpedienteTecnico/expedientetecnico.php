<?php session_start();?>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/tablaCalendario.css" rel="stylesheet">
<link href="contenido_SGI/view/css/multi-select.css" rel="stylesheet">
<link href="contenido_SGI/view/css/ExpedienteTecnico/expedienteTecnico.css" rel="stylesheet">
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/jquery.validate.js" type="text/javascript" ></script>
<script src="contenido_SGI/view/js/additional-methods.min.js" type="text/javascript" ></script>
<script src="contenido_sgi/view/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootbox.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="contenido_sgi/view/js/jquery.mask.min.js" type="text/javascript"></script>
<script src='contenido_SGI/view/js/DT_bootstrap.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/fileuploader.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/autoNumeric.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src = "contenido_SGI/view/js/gmap3.js" type = "text/javascript" ></script>
<script src="contenido_SGI/view/js/expedienteTecnico/expedienteTecnico.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaUno.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaDos.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojatres.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojacuatro.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaCinco.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaSiete.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/Notificaciones/notificaciones.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#formGral").keypress(function (e) {
            if (e.which == 13) {
                return false;
            }
        });
    });
</script>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <p class="navbar-text">No. Solicitud:</p>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control text-right num" placeholder="Buscar" id="nosolicitud" name="nosolicitud" value="<?php echo $prueba; ?>">
                </div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalMostrarD" id="mostraredit">
                    Mostrar Datos
                </button>
                <button type="button" id="btnRefresh" class="btn btn-primary" >
                    Limpiar
                </button>
            </form>
        </div>
    </div>
</nav>

<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#h1"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 1</a></li>
    <li><a href="#h2"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 2</a></li>
    <li><a href="#h3"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 3</a></li>
    <li><a href="#h4"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 4</a></li>
    <li><a href="#h5"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 5</a></li>
    <li><a href="#h6"  role="tab" data-toggle="tab" onclick="bloqueaTabs();">Hoja 6</a></li>
</ul>

<form id="formGral" class="form-horizontal">
    <div class="tab-content">
        <div class="tab-pane active" id="h1">
            <?php include ('hojauno.php') ?>
        </div>
        <div class="tab-pane" id="h2">
            <?php include ('hojados.php') ?>
        </div>
        <div class="tab-pane" id="h3">
            <?php include ('hojatres.php') ?>
        </div>
        <div class="tab-pane" id="h4">
            <?php include ('hojacuatro.php') ?> 
        </div> 
        <div class="tab-pane" id="h5">
            <?php include ('hojacinco.php') ?>
        </div>
        <div class="tab-pane" id="h6">
            <?php include ('hojasiete.php') ?>
        </div>
    </div>
</form>
<input type="hidden" id="modulo" value="1"/>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<div id="containerBotones" style="width: 300px;height: 50px;padding: 5px;position: fixed; bottom:50px; right: 50px;opacity: 0.4;background-color: #DFF0D8;z-index: 99;">
    <span class="btn btn-default" id="btnAtras" style="display:none;"><< Anterior</span>
    <span class="btn btn-default" id="btnGuardarParcial">Guardar</span>
    <span  class="btn btn-default" id="btnSiguiente">Siguiente >></span>
    <input type="hidden" id="pagSiguiente" value="1">
    <!--<input type="hidden" id="pagActiva">-->
</div>


<form id="imprime2" method="post" target="_blank" action="contenido_sgi/model/expedienteTecnico/ImpresionCaratula.php">
    <input id="ejercicioCaratula" name="ejercicioCaratula" type="hidden" />
    <input id="ueCaratula" name="ueCaratula" type="hidden" />
    <input id="idsolCaratula" name="idsolCaratula" type="hidden" />
    <input id="nomobraCaratula" name="nomobraCaratula" type="hidden" /> 
    <input id="tiposolCaratula" name="tiposolCaratula" type="hidden" />
    <input id="montofedCaratula" class="number" name="montofedCaratula" type="hidden" />
    <input id="montoestCaratula" class="number" name="montoestCaratula" type="hidden" />
    <input id="montomunCaratula" name="montomunCaratula" type="hidden" /> 
    <input id="montototalCaratula" name="montototalCaratula" type="hidden" /> 
    <input id="marcaAgua" name="marcaAgua" type="hidden" /> 
    <!--<input id="fechaingCaratula" name="fechaingCaratula" type="text" />--> 
</form>
