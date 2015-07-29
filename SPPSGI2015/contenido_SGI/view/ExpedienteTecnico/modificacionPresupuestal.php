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
<script src="contenido_SGI/view/js/expedienteTecnico/expedienteTecnico.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/modificacionPresupuestal.js" type="text/javascript"></script>
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
<!--<script src="contenido_SGI/view/js/expedienteTecnico/hojaUno.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaDos.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojatres.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojacuatro.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaCinco.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojaSiete.js" type="text/javascript"></script>-->

<div class="navbar navbar-default">
    <div class="container-fluid">
        <p class="navbar-text">Tipo de Solicitud:</p>
        <div class="form-group col-md-2 navbar-form">
            <select id="tipoSolicitud" class="form-control">
                <option value="2">Autorizaci&oacute;n</option>
                <option value="12">Autorizaci&oacute;n de Ampliaci&oacute;n</option>
                <option value="4">Reducci&oacute;n</option>
                <option value="7">Cancelaci&oacute;n</option>
            </select>
        </div>
        <p class="navbar-text">No. Obra:</p>
        <div class="form-group col-md-2 navbar-form">
            <input type="text" class="form-control text-right num" placeholder="Buscar" id="noObra" name="nosolicitud">
        </div>
        <div class="form-group navbar-form">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalMostrarD" id="buscarObrSol">
                Mostrar Datos
            </button>
            <button type="button" id="btnRefresh" class="btn btn-primary" >
                Limpiar
            </button>
        </div>
    </div>
</div>
<div id="encabezado" style="display:none;">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="cambiaSpan();">
                        Datos de la Solicitud de Expediente T&eacute;cnico <span style="font-size:9px;" id="spanVariable">(Ocultar)</span>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body form">
                    <div class="row form-group">
                        <label class="col-md-2 control-label" for="nosolicitud">No. Solicitud:</label>  
                        <div class="col-md-2">
                            <input id="nosolicitud" name="nosolicitud" type="text" placeholder="" class="form-control input-md enc" readonly="true">
                        </div>

                        <label class="col-md-1 control-label" for="encejercicio">Ejercicio:</label>  
                        <div class="col-md-2">
                            <input id="encejercicio" name="encejercicio" type="text" placeholder="" class="form-control input-md enc" readonly="true">
                        </div>

                        <label class="col-md-1 control-label" for="encmonto">Monto:</label>  
                        <div class="col-md-3">
                            <input id="encmonto" name="encmonto" type="text" placeholder="" class="form-control input-md number enc" readonly="true">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <label class="col-md-2 control-label" for="encnoobra">No. Obra:</label>  
                        <div class="col-md-2">
                            <input id="encnoobra" name="encnoobra" type="text" placeholder="" class="form-control input-md enc" readonly="true">
                        </div>

                        <label class="col-md-2 control-label" for="encnomobr">Nombre de la Obra:</label>  
                        <div class="col-md-5">
                            <textarea id="encnomobr" name="encnomobr" placeholder="" class="form-control input-md enc" readonly="true"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label" for="encue">Unidad Ejecutora:</label>  
                        <div class="col-md-9">
                            <input id="encue" name="encue" type="text" placeholder="" class="form-control input-md enc" readonly="true">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3 control-label" for="encur">Sector:</label>  
                        <div class="col-md-8">
                            <input id="encur" name="encur" type="text" placeholder="" class="form-control input-md enc" readonly="true">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3 control-label" for="encmodeje">Modalidad de Ejecuci&oacute;n:</label>  
                        <div class="col-md-3">
                            <input type="text" id="encmodeje" name="encmodeje" class="form-control enc" readonly="true">
                        </div>

                        <label class="col-md-2 control-label" for="enctipobr">Tipo de Obra:</label>  
                        <div class="col-md-3">
                            <input type="text" id="enctipobr" name="enctipobr" class="form-control enc" readonly="true">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-md-offset-9">
                            <span class="btn btn-success" id="btnClonarSol" style="display:none;" >Generar Solicitud</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="modulo" value="3"/>
<div id="containerProceso">

</div>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<div id="containerBotones" style="width: 160px;height: 50px;padding: 5px;position: fixed; bottom:50px; right: 50px;opacity: 0.4;background-color: #DFF0D8; display:none;z-index: 9999;">
    <!--<span class="btn btn-default" id="btnAtrasMP" style="display:none;"><< Anterior</span>-->
    <span class="btn btn-default" id="btnGuardarParcialMP" onclick="guardarParcialMP()">Guardar</span>
    <span class="btn btn-success" id="btnEnviarMP">Enviar</span>
<!--    <span  class="btn btn-default" id="btnSiguienteMP">Siguiente >></span>-->
    <!--<input type="hidden" id="pagSiguienteMP" value="1">-->
    <input type="hidden" id="pagActiva">
</div>
<form id="imprime3" method="post" target="_blank" action="contenido_sgi/model/expedienteTecnico/ImpresionCaratula.php">
    <input id="ejercicioCaratula" name="ejercicioCaratula" type="hidden" />
    <input id="ueCaratula" name="ueCaratula" type="hidden" />
    <input id="idsolCaratula" name="idsolCaratula" type="hidden" />
    <input id="nomobraCaratula" name="nomobraCaratula" type="hidden" /> 
    <input id="tiposolCaratula" name="tiposolCaratula" type="hidden" />
    <input id="montototalCaratula" name="montototalCaratula" class="number" type="hidden" />
    <!--<input name="contratos" type="text" />--> 
    <input id="marcaAgua" name="marcaAgua" type="hidden" /> 
    <!--<input id="fechaingCaratula" name="fechaingCaratula" type="text" />--> 
</form>
