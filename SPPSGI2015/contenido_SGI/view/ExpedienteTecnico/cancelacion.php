<br><br>

<form id="formcan" class="form-horizontal">
    
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><strong>Montos Asignados, Autorizados y disponibles para Cancelaci&oacute;n</strong></h1>
    </div>
</div>
    
    <div class="col-md-11 panel">
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">Fuente Federal: </span>
                    <input class="form-control" name="ffed[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Monto Asignado: </span>
                    <input class="form-control" name="fedasig[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Monto Autorizado: </span>
                    <input class="form-control" name="fedaut[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font>Monto a Cancelar: </span>
                    <input class="form-control obligatorioCan" name="fedcan[]" aria-describedby="basic-addon1" onkeypress="return justNumbers(event);"/>
                </div>
            </div>
            <input hidden="true" name="idfed[]"/>
            <input hidden="true" name="f[]" class="oculto"/>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon">Fuente Estatal: </span>
                    <input class="form-control" name="fest[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Monto Asignado: </span>
                    <input class="form-control" name="estasig[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Monto Autorizado: </span>
                    <input class="form-control" name="estaut[]" aria-describedby="basic-addon1" readonly="true"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon"><font color="red" size="7">* </font>Monto a Cancelar: </span>
                    <input class="form-control obligatorioCan" name="estcan[]" aria-describedby="basic-addon1" onkeypress="return justNumbers(event);"/>
                </div>
            </div>
            <input hidden="true" name="idest[]"/>
            <input hidden="true" name="e[]" class="oculto"/>
        </div>
    </div>
    <div class="form-group col-md-10">
        <label class="col-lg-6 control-label"></label>
        <h6><font color="red" size="7">* </font>Campos obligatorios.</h6>
    </div>
    
    <input hidden="true" name="solicitud" id="solicitud"/>
    <input hidden="true" id="accion" name="accion" value="cancelarMontos"/>
</form>