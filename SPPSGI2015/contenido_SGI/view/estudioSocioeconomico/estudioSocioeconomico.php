<!--<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<link href="contenido_SGI/view/css/tablaCalendario.css" rel="stylesheet">
<link href="contenido_SGI/view/css/multi-select.css" rel="stylesheet">
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
<script src="contenido_SGI/view/js/estudioSocioeconomico/estudioSocioeconomico.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/estudioSocioeconomico/hojaUnoEstudioSocioeconomico.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/estudioSocioeconomico/hojaDosEstudioSocioeconomico.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/Notificaciones/notificaciones.js" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src = "contenido_SGI/view/js/gmap3.js" type = "text/javascript" ></script>


<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <p class="navbar-text">No. Banco de Proyectos:</p>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control text-right num" placeholder="Buscar" id="numerobanco" name="numerobanco" value="">
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
    <li class="active"><a href="#h1"  role="tab" data-toggle="tab">Hoja 1</a></li>
    <li><a href="#h2"  role="tab" data-toggle="tab">Hoja 2</a></li>  
</ul>

<form id="formGral" class="form-horizontal">
    <div class="tab-content">
        <div class="tab-pane active" id="h1">
            <?php include ('hojaunosocioeconomico.php') ?>
        </div>
        <div class="tab-pane" id="h2">
            <?php include ('hojados.php') ?>
        </div>        
    </div>
</form>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<div id="containerBotones" style="width: 400px;height: 50px;padding: 5px;position: fixed; bottom:50px; right: 50px;opacity: 0.4;background-color: #DFF0D8;z-index: 99;">
    <span class="btn btn-default" id="btnAtras" style="display:none;"><< Anterior</span>
    <span  class="btn btn-default" id="btnSiguiente">Siguiente >></span>    
    <span class="btn btn-default" id="btnGuardarParcial">Guardar</span>
    <span  class="btn btn-default" id="btnFirmar">Enviar para dictaminar</span>
    <span  class="btn btn-default" id="btnImpIngreso" onclick="">Imprimir ficha de ingreso</span>   
    <input type="hidden" id="pagSiguiente">
    <!--<input type="hidden" id="pagActiva">-->
</div>
<form id="formFichaBco" method="post" action="contenido_SGI/view/Banco/fichaTecnica_pdf.php" target="_blank">
    <input type="hidden" name="idBcoFicha" id="idBcoFicha" />
</form>
