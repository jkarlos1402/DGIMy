<!-- @Maricarmen_Sotelo -->
<link href="contenido_SGI/view/css/fileuploader.css" rel="stylesheet">
<!-- <form class="form-horizontal"> -->
<div class="form-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title"><strong> ANEXO 2</strong></h1>
        </div>
    </div>

    <div class="form-group col-md-10" id="tipcob1">
        <label for="ejercicio" class="col-md-3 control-label"><font color="red" size="7">* </font>Tipo de Cobertura: </label>
        <div class="col-md-2">
            <select id="tipoCobertura" name="tipoCobertura1" class="form-control bnc am-as obligatorioHoja2">
            </select>
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la cobertura y el nombre del 
              municipio(s) o regi&oacute;n(es) donde se llevar&aacute; a cabo la obra o acci&oacute;n.">
        </span>
    </div>

    <div id="mult1" hidden="hidden">
        <div class="panel-body">
            <div class="col-sm-12">
                <select name="disponiblesCobertura" id="disponiblesCobertura" multiple="multiple" class="bnc am-as">
                </select>
            </div>
        </div>
    </div>

    <div class="form-group col-md-10 " hidden="true" id="comloc">
        <div class="form-group">
            <label for="inputEmail3" class="col-md-3 control-label">Localidad: </label>
            <div class="col-md-5">
                <input type="text" class="form-control bnc am-as" id="inputEmail3" name="inputEmail3" maxlength="255">
            </div>
            <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el nombre de la(s) localidad(es)
                  donde se llevar&aacute; a cabo la obra o acci&oacute;n.">
            </span>
        </div>    
    </div>
    <div class="form-group col-md-10">
        <label for="idTipLoc" class="col-md-3 control-label"><font color="red" size="7">* </font>Tipo de Localidad: </label>
        <div class="col-md-3">
            <select id="tipLoc" name="tipLoc" class="form-control bnc am-as obligatorioHoja2"></select>                            
        </div>
    </div>
    <div class="form-group col-md-10">
        <label for="coord" class="col-lg-3 control-label"><font color="red" size="7">* </font>Coordenadas: </label>
        <div class="col-lg-2">
            <select id="coor" name="coor" class="form-control bnc am-as obligatorioHoja2">
                <option value="" selected>Seleccionar...</option>
                <option value="1">Si</option>
                <option value="2">No aplica</option>
            </select>
        </div>
        <div class="col-lg-5">
            <input type="text" name="obscoor" class="form-control bnc am-as" id="obscoor" maxlength="100" readonly>
            <div id="label3"></div>
        </div>
    </div>

    <div id="coordenadas" hidden="true">

        <div class="form-group">
            <label class="col-lg-6 control-label">Coordenadas Inicio</label>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><font color="red" size="7">* </font>LAT: </label>
            <div class="col-md-3">
                <input type="text" class="form-control text-right corde bnc am-as" id="lat" name="lat" placeholder="0.00">
            </div>
            <label class="col-md-2 control-label"><font color="red" size="7">* </font>LON: </label>
            <div class="col-md-3">
                <input type="text" class="form-control text-right corde bnc am-as" id="lon" name="lon" placeholder="0.00">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-6 control-label">Coordenadas Final</label>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">LAT: </label>
            <div class="col-md-3">
                <input type="text" class="form-control text-right corde bnc am-as" id="lat2" name="lat2" placeholder="0.00">
            </div>
            <label class="col-md-2 control-label">LON: </label>
            <div class="col-md-3">
                <input type="text" class="form-control text-right corde bnc am-as" id="lon2" name="lon2" placeholder="0.00">
            </div>
        </div>
        <div class="form-group col-md-10">
            <label class="col-lg-6 control-label"></label>
            <center><h6>Las coordenadas del Estado de M&eacute;xico se encuentran entre: (18.4999999,-100.7999999) y (20.39999999,-98.6999999) Latitud y Longitud</h6></center>
        </div>
        <div class="form-group col-md-12">
            <label class="col-md-2 control-label" for="Mapa">Mapa:</label>
            <div class="col-md-10">
                <div id="map"></div>
            </div>
        </div>

        <div class="form-group col-md-10">
            <label class="col-lg-6 control-label"></label>
            <center><h6>Las coordenadas finales solo se capturan para proyectos carreteros, de agua, electrificaci&oacute;n entre otros.</h6></center>
        </div>
    </div>

    <div class="form-group col-md-10">
        <label class="col-md-3 control-label" for="microlocalizacion">Microlocalizaci&oacute;n:</label>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Descripci&oacute;n gr&aacute;fica y 
              detallada de la ubicaci&oacute;n de una obra, nivel de localidad, considerando al menos los 
              accesos principales y referencias particulares. De ser el caso, se incluir&aacute;n los nombres 
              de las calles que la circundan.">
        </span>
        <div class="col-md-7">
            <div class="col-md-7">
                <div id="imgPrev"></div>
            </div>
            <div class="col-md-5">
                <div id="microlocalizacion" class="bnc am-as"></div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modalImagen" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <br>
                </div>
                <div class="modal-body" id="infoBody">
                    <div style="width:870px; height:550px; overflow: scroll;">
                        <center><img id="imgOriginal" /></center>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-md-10">
        <label class="col-lg-6 control-label"></label>
        <h6><font color="red" size="7">* </font>Campos obligatorios.</h6>
    </div>

    <input hidden="true" id="listcob" name="listcob" />
</div>