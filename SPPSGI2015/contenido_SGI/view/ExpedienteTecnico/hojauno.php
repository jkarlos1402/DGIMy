<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><strong> ANEXO 1</strong></h1>
    </div>
</div>
    
<div class="form-group" id="sp">
  <label class="col-md-3 control-label" for="solpre"><font color="red" size="7">* </font>Solicitud de presupuesto:</label>
  <div class="col-md-4">
      <select id="solpre" name="solpre" class="form-control obligatorioHoja1">
    </select>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar seg&uacute;n corresponda el tipo de tr&aacute;mite."></span>
</div>

<div class="form-group" id="sp2" hidden="true">
  <label class="col-md-3 control-label" for="solpre"><font color="red" size="7">* </font>Solicitud de presupuesto:</label>
  <div class="col-md-4">
      <input id="solpreval" name="solpreval" type="text" class="form-control input-md am-as" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="evasoc"><font color="red" size="7">* </font>Se Incluye Evaluaci&oacute;n Socioecon&oacute;mica:</label>
  <div class="col-md-2">
    <select id="evasoc" name="evasoc" class="form-control am-as obligatorioHoja1">
      <option value="">Seleccionar...</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Indicar si cuenta con Estudio 
        Socioecon&oacute;mico, en caso de ser afirmativo colocar el folio del Banco de Proyectos.">
  </span>
</div>
    
<div class="form-group" id="nes" hidden="true">
  <label class="col-md-3 control-label" for="nbp">No. Banco de Proyectos:</label>  
  <div class="col-md-2">
  <input id="nbp" name="nbp" type="text" class="form-control input-md am-as" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="idsol">No. Solicitud:</label>  
  <div class="col-md-2">
  <input id="idsol" name="idsol" type="text" placeholder="" class="form-control input-md" readonly />
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="De uso exclusivo de la Direcci&oacute;n 
        General de Inversi&oacute;n, para anotar el n&uacute;mero progresivo correspondiente al ingreso 
      del expediente T&eacute;cnico.">
  </span>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="ejercicio"><font color="red" size="7">* </font>Ejercicio:</label>
  <div class="col-md-2">
    <select id="ejercicio" name="ejercicio" class="form-control bnc am-as obligatorioHoja1 asigAdic">
    </select>
  </div>
</div>
    
<div class="form-group">
  <label class="col-md-3 control-label" for="noobra">No. de Obra:</label>  
  <div class="col-md-2">
    <input id="noobra" name="noobra" type="text" class="form-control input-md am-as" readonly />
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="N&uacute;mero de Control que identifica a la obra
        o acci&oacute;n y que se incluye en el documento Anexo al Oficio de Asignaci&oacute;n">
  </span>
</div>
    
<div class="form-group">
  <label class="col-md-3 control-label" for="nomobra"><font color="red" size="7">* </font>Nombre de la obra:</label>
  <div class="col-md-7">                     
    <textarea class="form-control bnc am-as obligatorioHoja1" id="nomobra" name="nomobra" rows="2"></textarea>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la denominaci&oacute;n de la obra o 
        acci&oacute;n, de tal manera que permita identificar con claridad los trabajos a realizar y su 
        ubicaci&oacute;n.">
  </span>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="objeto">Para qu&eacute; se requiere:</label>

  <div class="col-md-7"> 
    <label class="checkbox-inline" for="obj-0">
        <input type="checkbox" name="obj0" id="obj-0" value="1" class="am-as"/>
      Estudio Socioecon&oacute;mico
    </label> 
    <label class="checkbox-inline" for="obj-1">
      <input type="checkbox" name="obj1" id="obj-1" value="1" class="am-as"/>
      Proyecto Ejecutivo
    </label> 
    <label class="checkbox-inline" for="obj-2">
      <input type="checkbox" name="obj2" id="obj-2" value="1" class="am-as"/>
      Liberaci&oacute;n del Derecho de V&iacute;a
    </label>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="objeto"></label>
  <div class="col-md-6">
     <label class="checkbox-inline" for="obj-3">
      <input type="checkbox" name="obj3" id="obj-3" value="1" class="am-as"/>
      Manifestaci&oacute;n del Impacto Ambiental
    </label> 
    <label class="checkbox-inline" for="obj-4">
      <input type="checkbox" name="obj4" id="obj-4" value="1" class="am-as"/>
      Obra
    </label> 
    <label class="checkbox-inline" for="obj-5">
      <input type="checkbox" name="obj5" id="obj-5" value="1" class="am-as"/>
      Acci&oacute;n
    </label>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="objeto"></label>
  <div class="col-md-6">
    <label class="checkbox-inline" for="obj-6">
      <input type="checkbox" name="obj6" id="obj-6" value="1" class="am-as"/>
      Otro
    </label>
    <div class="col-md-6" id="otro" hidden="true">
      <input id="otroobs" name="otroobs" type="text" placeholder="" class="form-control input-md am-as" />
    </div>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Marcar el cuadro(s) que corresponda al 
        prop&oacute;sito que se pretenda dar al presupuesto solicitado.">
  </span>
</div>
    
<div id="depnoruni" hidden="true">
        <div class="form-group">
        <label class="col-md-3 control-label" for="ue">Unidad Ejecutora:</label>  
        <div class="col-lg-7 am-as" id="ue0">
          </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al 
              Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
              o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal 
              y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan, 
              programa o acci&oacute;n.">
        </span>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="ur">Sector:</label>  
        <div class="col-lg-7 am-as" id="ur0">
          </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su 
              denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
              Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
              Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
              responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
        </span>
      </div>
</div>
    
<div id="usuariouni" hidden="true">
    <div class="form-group">
        <label class="col-md-3 control-label" for="ue2">Unidad Ejecutora:</label>
        <div class="col-md-8">
          <select id="ue2" name="ue2" class="form-control am-as">
          </select>
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al 
              Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
              o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal 
              y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan, 
              programa o acci&oacute;n.">
        </span>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="ur2">Sector:</label>
        <div class="col-md-4">
          <select id="ur2" name="ur2" class="form-control am-as">
          </select>
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su 
              denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
              Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
              Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
              responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
        </span>
    </div>
</div>
    
<div id="usuedit" hidden="true">
    <div class="form-group">
        <label class="col-md-3 control-label" for="ue3">Unidad Ejecutora:</label>  
        <div class="col-md-6">
        <input id="ue3" name="ue3" type="text" placeholder="" class="form-control input-md" readonly />
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Unidad Administrativa de acuerdo al 
              Cat&aacute;logo de Centros de Costo, a nivel jer&aacute;rquico de una Direcci&oacute;n General
              o de un Organismo Auxiliar (Organismo Descentralizado, Empresa de Participaci&oacute;n Estatal 
              y Fideicomiso P&uacute;blico) que estar&aacute; a cargo directo del desarrollo del plan, 
              programa o acci&oacute;n.">
        </span>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="ur3">Sector:</label>  
        <div class="col-md-6">
        <input id="ur3" name="ur3" type="text" placeholder="" class="form-control input-md" readonly />
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su 
              denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
              Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
              Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
              responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
        </span>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-7 control-label">Acciones de Gobierno Estatal</label>
    <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opci&oacute;n(es) de tres 
          letras, tres n&uacute;meros y texto completo que identifican la(s) Acci&oacute;n(es) de Gobierno.">
    </span>
</div>

<div id="mult">
    <div class="panel-body">
        <div class="col-sm-12">
            <select name="origen" id="origen" multiple="multiple" class="selecmalo bnc am-as">
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><font color="red" size="7">* </font>Justificaci&oacute;n de la obra:</label>
    <div class="col-lg-8"><textarea class="form-control bnc am-as obligatorioHoja1" name="jusobr" id="jusobr" rows="2"></textarea></div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="modalidad"><font color="red" size="7">* </font>Modalidad de ejecuci&oacute;n:</label>
  <div class="col-md-2">
    <select id="modalidad" name="modalidad" class="form-control bnc am-as obligatorioHoja1">
    </select>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la opci&oacute;n 'Contrato' en el 
        caso de que la ejecuci&oacute;n de una obra o la prestaci&oacute;n de un servicio se encomienden a 
        una empresa; de igual manera la modalidad ser&aacute; por contrato, cuando se trate de la
        adquisici&oacute;n de un bien o servicio. Seleccionar la opci&oacute;n 'Administraci&oacute;n' cuando la obra
        o acci&oacute;n se realice por la Unidad Ejecutora, siempre y cuando cuente con los recursos humanos, 
        materiales y t&eacute;cnicos conforme a los lineamientos establecidos en el Libro D&e&eacute;cimo 
        Segundo del C&oacute;digo Administrativo y en su Reglamento. En este sentido deber&aacute; anexarse al
        Expediente, la informaci&oacute;n que sustente esta condici&oacute;n.">
  </span>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="tipobr"><font color="red" size="7">* </font>Tipo de obra:</label>
  <div class="col-md-2">
    <select id="tipobr" name="tipobr" class="form-control bnc am-as obligatorioHoja1">
    </select>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar 'Nueva' si la obra se ejecutar&aacute;
        con presupuesto del presente ejercicio fiscal y el cuadro 'Proceso' si el presupuesto para la
        ejecuci&oacute;n de la obra se asign&oacute; el a&ntilde;o o a&ntilde;os anteriores, o si se trata de
        una ampliaci&oacute;n o reducci&oacute;n de presupuesto.">
  </span>
</div>

<div id="todo">
      <div class="form-group">
      <label for="ejemplo_password_3" class="col-lg-3 control-label"><font color="red" size="7">* </font>Monto de la Inversi&oacuten: </label>
      <div class="col-lg-3" id="tres">
        <input type="text" class="form-control text-right obligatorioHoja1 asigAdic" id="montin" name="montoInversion" placeholder="0.00" readonly />
      </div>
      <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la Fuente de financiamiento para 
            llevar a cabo la obra o acci&oacute;n. En caso de ser m&aacute;s de una fuente, deber&aacute;
            colocar el importe que corresponda a cada una de ellas.">
      </span>
    </div>

  <div class="form-group ftefederal">
      <label class="col-lg-3 control-label" id="labelfed">Federal: </label>
      <div class="col-lg-3">
        <input type="text" class="form-control monfed sumarF text-right" name="federal[]" value="" />
      </div>

    <!--<div id="catffed">-->
      <label class="col-lg-1 control-label">Fuente:</label>
          <div class="col-lg-4">
              <select name="ffed[]" class="form-control numftef am-as" >
              </select>
          </div>
    <!--</div>-->
      <input hidden="true" name="fcta[]"/>
      <input hidden="true" name="f[]"/>
      <input hidden="true" name="f2[]" class="oculto"/>
      <input hidden="true" name="f3[]" class="sumarAAF"/>
      <input hidden="true" name="f4[]" class="inicial"/>
      <input class="bt_ftefed input-sm" type="button" value="+"/>
  </div>
    
<div class="form-group fteestatal">
  <label class="col-lg-3 control-label" id="labeles">Recursos Fiscales (Estatal): </label>
  <div class="col-lg-3">
    <input type="text" class="form-control monest sumarE text-right" name="estatal[]" value="" />
  </div>

<!--<div id="catfest">-->
  <label class="col-lg-1 control-label">Fuente:</label>
      <div class="col-lg-4">
          <select name="fest[]" class="form-control numftee am-as" >
          </select>
      </div>
<!--</div>-->
    <input hidden="true" name="ecta[]"/>
    <input hidden="true" name="e[]"/>
    <input hidden="true" name="e2[]" class="oculto "/>
    <input hidden="true" name="e3[]" class="sumarAAE"/>
    <input hidden="true" name="e4[]" class="inicial"/>
    <input class="bt_fteest input-sm" type="button" value="+" />
</div>
    
    <div class="form-group">
      <label for="ejemplo_password_3" class="col-lg-3 control-label" id="labelmu">Municipal: </label>
      <div class="col-lg-3">
        <input type="text" class="form-control monmun text-right" onkeypress="return justNumbers(event);" id="mu" name="municipal" value="0.00" />
      </div>

    <div id="catfmun">
      <label class="col-lg-1 control-label">Fuente:</label>
          <div class="col-lg-4">
             <input type="text" class="form-control numftem am-as" id="fmun" name="fmun" maxlength="30" />
          </div>
    </div>

    </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="caract"><font color="red" size="7">* </font>Principales caracter&iacute;sticas:</label>
  <div class="col-md-7">                     
    <textarea class="form-control bnc am-as obligatorioHoja1" id="caract" name="caract" rows="2"></textarea>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Describir las principales caracter&iacute;sticas 
        de la obra o acci&oacute;n.">
  </span>
</div>

<div class="form-group">
      <label class="col-lg-5 control-label">Metas a lograr</label>
      <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la unidad de medida que 
            corresponda a la meta que se alcanzar&aacute; al concluirse la obra o acci&oacute;n.">
      </span>
    </div>
    <div class="form-group">
      <label class="col-lg-3 control-label">U. Medida:</label>
        <div class="col-lg-3">
        
          <select class="form-control bnc am-as" id="metas" name="metas">
          </select>
        
        </div>
        
        <div class="col-lg-1">
         <label class="col-lg-2 control-label">Cantidad:</label>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control text-right bnc am-as number-int" name="textmetas" id="mecant" placeholder="0" />
      </div>
      </div>

      <div class="form-group">
      <label class="col-lg-5 control-label">Beneficiarios</label>
      <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar el n&uacute;mero de personas 
            beneficiadas con la ejecuci&oacute;n de la obra o acci&oacute;n. Asimismo se anotar&aacute; la 
            unidad de medida que corresponda de acuerdo al cat&aacute;logo correspondien.">
      </span>
      </div>
      
      <div class="form-group">
      <label class="col-lg-3 control-label">U. Medida:</label>
        <div class="col-lg-3">
          <select class="form-control bnc am-as"  id="beneficiario" name="beneficiario">
          </select>
        </div>
        
        <div class="col-lg-1">
         <label class="col-lg-2 control-label">Cantidad:</label>
        </div>
        
        <div class="col-lg-2">
         <input type="text" name="textbeneficiario" class="form-control text-right number-int bnc am-as" id="becant" placeholder="0"/>
      
      </div>
      </div>

<div class="form-group col-md-10">
    <label class="col-lg-6 control-label"></label>
    <h6><font color="red" size="7">* </font>Campos obligatorios.</h6>
</div>

<input hidden="true" id="usuuni" name="usuuni" />
<input hidden="true" id="rut" name="rut" />
<input hidden="true" id="imagen" name="imagen" />
<input hidden="true" id="acc" name="acc" />
<input hidden="true" id="accion" name="accion"/>
<input hidden="true" id="porfed" name="porfed"/>
<input hidden="true" id="porest" name="porest"/>
<input hidden="true" id="montoTotalAA" name="montoTotalAA"/>
<input hidden="true" id="montoTotalAAe" name="montoTotalAAe"/>
<input hidden="true" id="banAm" name="banAm"/>
<input hidden="true" id="flujo" name="flujo"/>
<input hidden="true" id="montoInv" name="montoInv"/>
<input hidden="true" id="tipoSol" name="tipoSol"/>
