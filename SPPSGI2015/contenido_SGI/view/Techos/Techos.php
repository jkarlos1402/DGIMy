
<?php
	$vst_path = "contenido_sgi/vistas/Techos/";
	$lib_path = "contenido_sgi/libs/js/";
?>
    
<script type="text/javascript" src="<?php echo $vst_path ?>jscripts/techos-js.js"></script>
<script type="text/javascript" src="<?php echo $lib_path ?>jquery.mask.min.js"></script>
<script src="contenido_SGI/libs/js/jquery.validate.min.js" type="text/javascript" ></script>
<script src="contenido_SGI/libs/js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $lib_path ?>bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $lib_path ?>bootbox.min.js"></script>

<?php 
include("funciones/techos-fnc.php");
?>

<form class="form-horizontal" id="formgral">
<fieldset>

<legend>Techos Financieros</legend>

<div class="form-group">
  <label class="col-md-2 control-label" for="mov">Movimiento:</label>
  <div class="col-md-2">
    <select id="mov" name="mov" class="form-control">
      <!-- <option value="0">Seleccionar...</option> -->
      <?php echo movimiento($cnx);  ?> 
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="ejer">Ejercicio:</label>
  <div class="col-md-2">
    <select id="ejer" name="ejer" class="form-control">
      <!-- <option value="0">Seleccionar...</option> -->
       <?php echo ejercicio($cnx);  ?> 
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="sec">Sector:</label>
  <div class="col-md-3">
    <select id="sec" name="sec" class="form-control">
      <!-- <option value="0">Seleccionar...</option> -->
      <?php echo sector($cnx);  ?> 
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="ue">Unidad Ejecutora:</label>
  <div class="col-md-4">
    <select id="ue" name="ue" class="form-control">
      <option value="0">Selecciona...</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="fte">Fuente:</label>
  <div class="col-md-4">
    <select id="fte" name="fte" class="form-control">
      <!-- <option value="0">Seleccionar...</option> -->
      <?php echo fuente($cnx);  ?> 
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="inv">Inversi&oacute;n:</label>
  <div class="col-md-4">
    <select id="inv" name="inv" class="form-control">
      <!-- <option value="0">Seleccionar...</option> -->
      <?php echo inversion($cnx);  ?> 
    </select>
  </div>
</div>

<div class="form-group" id="proyecto" hidden="true">
  <label class="col-md-2 control-label" for="proy">Proyecto:</label>
  <div class="col-md-6">
    <select id="proy" name="proy" class="form-control">
      <option value="0">Selecciona...</option>
    </select>
  </div>
</div>

<div class="form-group" id="campotecho" hidden="true">
  <label class="col-md-2 control-label" for="monto">Techo:</label>  
  <div class="col-md-2">
  <input id="techo" name="techo" type="text" class="form-control input-md numero text-right" disabled>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="monto">Monto:</label>  
  <div class="col-md-2">
  <input id="monto" name="monto" type="text" placeholder="0.00" class="form-control input-md numero text-right">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="obs">Observaciones</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="obs" name="obs" maxlength="100"></textarea>
  </div>
</div>

</fieldset>
</form>
