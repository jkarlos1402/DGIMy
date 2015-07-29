<!-- @Maricarmen_Sotelo -->

<?php include("funciones/hojaocho-fnc.php"); ?>

<!-- <form class="form-horizontal"> -->
<br>

<font color="gray"><h6> *** Uso explusivo dictaminaci&oacute;n</h6></font>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div id="tecscsi">
  <div class="form-group">
    <label class="col-lg-4 control-label"><font color="red" size="7">* </font>Tipo de evaluaci&oacute;n:</label>
    <div class="col-lg-5">
      <select class="form-control"  id="tipeval" name="tipeva">
        <?php
          echo Tipoevaluacion();                               
        ?>
      </select>
    </div>
  </div>
</div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div id="tec1" hidden="true">

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Proyecto Ejecutivo :</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="pe1" id="pe1-1" value="1">Si</label>
    <label class="radio-inline" for="radios-1"><input type="radio" name="pe1" id="pe1-2" value="2" checked="checked">No</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Mec&aacute;nica de Suelos :</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="ms1" id="ms1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="ms1" id="ms1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="ms1" id="ms1-3" value="3"checked="checked">No aplica</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Estudios de Factibilidad del Sector:</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="efs1" id="efs1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="efs1" id="efs1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="efs1" id="efs1-3" value="3" checked="checked">No aplica</label>
  </div>
</div>

</div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div id="tec2" hidden="true">

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">T&eacute;rminos de Referencia :</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="tr1" id="tr1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="tr1" id="tr1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="tr1" id="tr1-3" value="3" checked="checked">No aplica</label>
  </div>
</div>

</div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div id="tec3" hidden="true">

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Manifestaci&oacute;n de Impacto Ambiental :</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="mia1" id="mia1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="mia1" id="mia1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="mia1" id="mia1-3" value="3" checked="checked">No aplica</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Liberaci&oacute;n del Terreno : </label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="ldt1" id="lt1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="ldt1" id="lt1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="ldt1" id="lt1-3" value="3" checked="checked">No aplica</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Derecho de V&iacute;a :</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0"><input type="radio" name="dv1" id="dv1-1" value="1">Si</label> 
    <label class="radio-inline" for="radios-1"><input type="radio" name="dv1" id="dv1-2" value="2">No</label> 
    <label class="radio-inline" for="radios-2"><input type="radio" name="dv1" id="dv1-3" value="3" checked="checked">No aplica</label>
  </div>
</div>

</div>

<!-- </form> -->

<div>
  <button type="button" class="btn btn-default" id="anth8">Guardar</button>
</div>