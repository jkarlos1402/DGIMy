<?php session_start(); ?>
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/estilosGenerales.css">
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/bootstrap/css/bootstrap-duallistbox.css"> 
<link rel="stylesheet" type="text/css" href="contenido_SGI/view/css/datepicker3.css" rel="stylesheet">
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/jquery.bootstrap-duallistbox.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/jquery.validate.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="contenido_sgi/view/js/autoNumeric.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/bootbox.min.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/Obra/funcionesObras.js"></script>
<script type="text/javascript" src="contenido_SGI/view/js/Notificaciones/notificaciones.js"></script>
<script>
//    $(document).ready(function () {
//        $("#obra").keypress(function (e) {
//            if (e.which == 13) {
//                return false;
//            }
//        });
//    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Control de Obras</strong></h3>
    </div>
</div>

<form id="obra">
    <div class="col-md-11 panel">
        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Acci&oacute;n a seguir:</span>
                    <select class="form-control obligatorio" aria-describedby="basic-addon1" id="acc" name="acc">
                        <option value="">Selecciona...</option>
                        <option value="1">Creaci&oacute;n de Obra</option>
                        <option value="2">Modificaci&oacute;n de Obra</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3" hidden="true" id="sol">
                <div class="input-group">
                    <span class="input-group-addon">No. Solicitud:</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="solicitudObra" name="solicitudObra"/>
                </div>
            </div>
            <div class="col-md-3" hidden="true" id="obr">
                <div class="input-group">
                    <span class="input-group-addon">No. de Obra:</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="noObra" name="noObra"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">Ejercicio:</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="ejercicioObra" name="ejercicioObra" readonly="true"/>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <p class="input-group-addon">Nombre de la Obra:</p>
                    <textarea class="form-control" id="nombreObra" rows="3" readonly="true"></textarea>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Justificaci&oacute;n de la Obra:</span>
                    <textarea class="form-control" id="justifiObra" rows="3" readonly="true"></textarea>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Principales Caracter&iacute;sticas:</span>
                    <textarea class="form-control" id="priCarObra" rows="3" readonly="true"></textarea>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Tipo de Cobertura:</span>
                    <span class="form-control" id="tipoCobObra" readonly="true"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <textarea class="form-control" id="valreg" rows="2" readonly="true"></textarea>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Localidad:</span>
                    <textarea class="form-control" id="localidadObra" rows="2" readonly="true"></textarea>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Coordenadas Latitud Inicial:</span>
                    <span class="form-control" id="latIniObra" readonly="true"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Coordenadas Longitud Inicial:</span>
                    <span class="form-control" id="lonIniObra" readonly="true"></span>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Coordenadas Latitud Final:</span>
                    <span class="form-control" id="latFinObra" readonly="true"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Coordenadas Longitud Final:</span>
                    <span class="form-control" id="lonFinObra" readonly="true"></span>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Sector:</span>
                    <span class="form-control" id="sectorObra" readonly="true"></span>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Unidad Ejecutora:</span>
                    <span class="form-control" id="ueObra" readonly="true"></span>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Grupo Social:</span>
                    <span class="form-control" id="gpoSocObra" readonly="true"></span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Modalidad de Ejecuci&oacute;n:</span>
                    <span class="form-control" id="modEjecObra" readonly="true"></span>
                </div>
            </div>
        </div>

        <div class="row form-group" id="altprg">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font> Programa:</span>
                    <select class="form-control" aria-describedby="basic-addon1" id="prgObra" name="prgObra">
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row form-group" id="altpry">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font> Proyecto EP:</span>
                    <select class="form-control" aria-describedby="basic-addon1" id="pryObra" name="pryObra">
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row form-group" id="conprg">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Programa:</span>
                    <span class="form-control" id="cprgObra" readonly="true"></span>
                </div>
            </div>
        </div>
        
        <div class="row form-group" id="conpry">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Proyecto EP:</span>
                    <span class="form-control" id="cpryObra" readonly="true"></span>
                </div>
            </div>
        </div>
        
        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Clasificaci&oacute;n de la Obra:</span>
                    <select class="form-control obligatorio" aria-describedby="basic-addon1" id="clapry" name="clapry">
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Costo:</span>
                    <input class="form-control" id="costoObra" name="costoObra" aria-describedby="basic-addon1" readonly="true" style="text-align:right;"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">Tipo de Obra:</span>
                    <span class="form-control" id="tipoObraVal" readonly="true"></span>
                </div>
            </div>
        </div>
        
        <div class="row form-group" id="divFed">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Fuente: </span>
                    <input class="form-control" name="ffed[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Monto Federal: </span>
                    <input class="form-control" name="federal[]" aria-describedby="basic-addon1" readonly="true" style="text-align:right;"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font> No. cuenta: </span>
                    <input class="form-control obligatorio" name="ctafed[]" aria-describedby="basic-addon1"/>
                </div>
            </div>
            <input hidden="true" name="idfed[]"/>
        </div>
        
        <div class="row form-group" id="divEst">
            <div class="col-md-1"></div>
            <div class="col-md-11">
                <div class="input-group">
                    <span class="input-group-addon">Fuente: </span>
                        <input class="form-control" name="fest[]" aria-describedby="basic-addon1" readonly="true"/>
                    </select>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">Monto Estatal: </span>
                    <input class="form-control" name="estatal[]" aria-describedby="basic-addon1" readonly="true" style="text-align:right;"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font> No. cuenta: </span>
                    <input class="form-control obligatorio" name="ctaest[]" aria-describedby="basic-addon1"/>
                </div>
            </div>
            <input hidden="true" name="idest[]"/>
        </div>
        
        <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <label class="col-lg-6 control-label"></label>
                <h6><font color="red" size="7">* </font>Campos obligatorios.</h6>
            </div>
        </div>
    </div>
    <input hidden="true" id="accion" name="accion"/>
    <input hidden="true" id="valsol" name="valsol"/>
    <input hidden="true" id="valsolpre" name="valsolpre"/>
</form>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<div id="containerBotones" style="width: 170px;height: 45px;padding: 5px;position: fixed; bottom:50px; right: 50px;opacity: 0.4;background-color: #DFF0D8;z-index: 99">
    <span class="btn btn-success" id="btnGuardar" onclick="guardaObra()">Guardar</span>
    <span class="btn btn-default" id="btnLimpiar" onclick="location.reload();">Limpiar</span>
</div>