<fieldset id="exptec">
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><strong> HOJA 1</strong></h1>
    </div>
</div> 
    
<div class="form-group" id="nes">
  <label class="col-md-3 control-label" for="nbp">No. Banco de Proyectos:</label>  
  <div class="col-md-2">
      <input id="nbp" name="nbp" type="text" class="form-control input-md" disabled="disabled">
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Folio del Banco de Proyectos.">
  </span>
</div>

<div class="form-group" hidden="true">
  <label class="col-md-3 control-label" for="idsol">No. Solicitud:</label>  
  <div class="col-md-2">
  <input id="idsol" name="idsol" type="text"  value="" placeholder="" class="form-control input-md" readonly>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Folio del Expediente T&eacute;cnico.">
  </span>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="ejercicio"><font color="red" size="7">* </font>Ejercicio:</label>
  <div class="col-md-2">
    <select id="ejercicio" name="ejercicio" class="form-control obligatorio">
    </select>
  </div>
</div>
    
<div class="form-group">
  <label class="col-md-3 control-label" for="vidaPry">Vida &uacute;til del proyecto:</label>  
  <label class="col-md-1 control-label">A&ntilde;os</label>  
  <div class="col-md-1">
      <input id="vidaPry" name="vidaPry" type="text" onkeypress="return justNumbers(event);" class="form-control input-sm" maxlength="2">
  </div>
</div>
    
<div class="form-group">
  <label class="col-md-3 control-label" for="nomobra"><font color="red" size="7">* </font>Nombre de la obra:</label>
  <div class="col-md-7">                     
    <textarea class="form-control obligatorio" id="nomobra" name="nomobra" rows="2"></textarea>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Anotar la denominaci&oacute;n de la obra o 
        acci&oacute;n, de tal manera que permita identificar con claridad los trabajos a realizar y su 
        ubicaci&oacute;n.">
  </span>
</div>

    
<div id="depnoruni" hidden="true">
        <div class="form-group">
        <label class="col-md-3 control-label" for="ue">Unidad Ejecutora:</label>  
        <div class="col-lg-7" id="ue0">
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
        <div class="col-lg-7" id="ur0">
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
          <select id="ue2" name="ue2" class="form-control">
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
          <select id="ur2" name="ur2" class="form-control">
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
        <input id="ue3" name="ue3" type="text" placeholder="" class="form-control input-md" readonly>
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
        <input id="ur3" name="ur3" type="text" placeholder="" class="form-control input-md" readonly>
        </div>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Secretar&iacute;a de acuerdo a su 
              denominaci&oacute;n en la Ley Org&aacute;nica de la Administraci&oacute;n P&uacute;blica, de la
              Consejer&iacute;a Jur&iacute;dica, Procuradur&iacute;a General de Justicia o del &Oacute;rgano
              Aut&oacute;nomo, a la cual este adscrita la Unidad Ejecutora y quien tendr&aacute; la
              responsabilidad de coordinar y evaluar su desempe&ntilde;o en el ejercicio del presupuesto asignado.">
        </span>
    </div>
</div>

<div id="accfed">
    <div class="form-group">
        <label class="col-lg-7 control-label">Acciones de Gobierno Federal</label>
        <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la(s) opci&oacute;n(es) de tres 
            letras, tres n&uacute;meros y texto completo que identifican la(s) Acci&oacute;n(es) de Gobierno.">
        </span>
    </div>

    <div id="mult">
        <div class="panel-body">
            <div class="col-sm-12" id="aF">
                <select name="origen2[]" id="origen2" multiple="multiple">
                </select>
            </div>
        </div>
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
        <div class="col-sm-12" id="aE">
            <select name="origen[]" id="origen" multiple="multiple">
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><font color="red" size="7">* </font>Justificaci&oacute;n de la obra:</label>
    <div class="col-lg-8"><textarea class="form-control obligatorio" name="jusobr" rows="2" id="jusobr"></textarea></div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="modalidad"><font color="red" size="7">* </font>Modalidad de ejecuci&oacute;n:</label>
  <div class="col-md-2">
    <select id="modalidad" name="modalidad" class="form-control obligatorio">
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
    <select id="tipobr" name="tipobr" class="form-control obligatorio">
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
        <input type="text" class="form-control text-right obligatorio" id="montin" name="montoInversion" readonly/>
      </div>
      <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la Fuente de financiamiento para 
            llevar a cabo la obra o acci&oacute;n. En caso de ser m&aacute;s de una fuente, deber&aacute;
            colocar el importe que corresponda a cada una de ellas.">
      </span>
    </div>

  <div class="form-group ftefederal">
      <label class="col-lg-3 control-label" id="labelfed">Federal: </label>
      <div class="col-lg-3">
        <input type="text" class="form-control monfed text-right" name="federal[]" value="" />
      </div>

    <!--<div id="catffed">-->
      <label class="col-lg-1 control-label">Fuente:</label>
          <div class="col-lg-4">
              <select name="ffed[]" class="form-control numftef" >
              </select>
          </div>
    <!--</div>-->
      
      <input class="bt_ftefed input-sm" type="button" value="+"/>
  </div>
    
<div class="form-group fteestatal">
  <label class="col-lg-3 control-label" id="labeles">Recursos Fiscales (Estatal): </label>
  <div class="col-lg-3">
    <input type="text" class="form-control monest text-right" name="estatal[]" value="" />
  </div>

<!--<div id="catfest">-->
  <label class="col-lg-1 control-label">Fuente:</label>
      <div class="col-lg-4">
          <select name="fest[]" class="form-control numftee" >
          </select>
      </div>
<!--</div>-->
    <input class="bt_fteest input-sm" type="button" value="+" />
</div>
    
    <div class="form-group">
      <label for="ejemplo_password_3" class="col-lg-3 control-label" id="labelmu">Municipal: </label>
      <div class="col-lg-3">
        <input type="text" class="form-control monmun text-right" id="mu" name="municipal" value=""/>
      </div>

    <div id="catfmun">
      <label class="col-lg-1 control-label">Fuente:</label>
          <div class="col-lg-4">
             <input type="text" class="form-control numftem" id="fmun" name="fmun" maxlength="30">
          </div>
    </div>

    </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="caract"><font color="red" size="7">* </font>Principales caracter&iacute;sticas:</label>
  <div class="col-md-7">                     
    <textarea class="form-control obligatorio" id="caract" name="caract" rows="2"></textarea>
  </div>
  <span class="glyphicon glyphicon-question-sign ayuda" title="Describir las principales caracter&iacute;sticas 
        de la obra o acci&oacute;n.">
  </span>
</div>

<div class="form-group">
  <label class="col-lg-3 control-label">Grupo Social:</label>
  <div class="col-lg-4">
      <select id="gsoc" class="form-control" name="grupoSocial">
      </select>
  </div>
</div>

<div class="form-group">
      <label class="col-lg-5 control-label">Metas a lograr</label>
      <span class="glyphicon glyphicon-question-sign ayuda" title="Seleccionar la unidad de medida que 
            corresponda a la meta que se alcanzar&aacute; al concluirse la obra o acci&oacute;n.">
      </span>
    </div>
    <div class="form-group">
      <label class="col-lg-3 control-label"><font color="red" size="7">* </font>U. Medida:</label>
        <div class="col-lg-3">
           
          <select class="form-control obligatorio" id="metas" name="metas">
          </select>
        
        </div>
        
        <div class="col-lg-1">
         <label class="col-lg-2 control-label">Cantidad:</label>
        </div>
        <div class="col-lg-2">
         <input type="text" class="form-control text-right number-int" name="textmetas" id="mecant" placeholder="0">
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
          <select class="form-control"  id="beneficiario" name="beneficiario">
          </select>
        </div>
        
        <div class="col-lg-1">
         <label class="col-lg-2 control-label">Cantidad:</label>
        </div>
        
        <div class="col-lg-2">
         <input type="text" name="textbeneficiario" class="form-control number-int text-right" id="becant" placeholder="0">
      
      </div>
      </div>
    
    <div class="form-group">
        <label class="col-lg-3 control-label">Duraci&oacute;n de la Obra:</label>
        <label class="col-lg-1 control-label"><font color="red" size="7">* </font>A&ntilde;os:</label>
        <div class="col-lg-1"><input type="text" id="anios" name="anios" class="form-control tiempo text-right" onkeypress="return justNumbers(event);" placeholder="0" maxlength="2"></div>
        <label class="col-lg-1 control-label"><font color="red" size="7">* </font>Meses:</label>
        <div class="col-lg-1">
            <select id="meses" name="meses" class="form-control">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
            </select>
        </div>
    </div>
    
<div class="form-group">
    <label class="col-lg-5 control-label">Factibilidades</label>
</div>

<div class='panel panel-default'>
    <div class='panel-body'>			    	     
        <div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>
            <div class='panel panel-success'>
                <div class='panel-heading' role='tab' id='heading'>
                    <h4 class='panel-title'>
                        <a data-toggle='collapse' data-parent='#accordion' href='#collapse' aria-expanded='true' aria-controls='collapseOne'>
                            Factibilidad Legal
                        </a>
                    </h4>
                </div>
                <div id='collapse' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading'>
                    <div class='panel-body'>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="libder">Liberaci&oacute;n de Derecho de V&iacute;a:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="libder-0">
                                    <input type="radio" name="fl_cu_libder" id="libder-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="libder-1">
                                    <input type="radio" name="fl_cu_libder" id="libder-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="libder-2">
                                    <input type="radio" name="fl_cu_libder" id="libder-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="libder-3">
                                    <input type="radio" name="fl_cu_libder" id="libder-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="libter">Liberaci&oacute;n del Terreno (libre de gravamen):</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="libter-0">
                                    <input type="radio" name="fl_cu_libter" id="libter-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="libter-1">
                                    <input type="radio" name="fl_cu_libter" id="libter-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="libter-2">
                                    <input type="radio" name="fl_cu_libter" id="libter-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="libter-3">
                                    <input type="radio" name="fl_cu_libter" id="libter-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="cfe">Permisos de CFE:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="cfe-0">
                                    <input type="radio" name="fl_cu_cfe" id="cfe-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="cfe-1">
                                    <input type="radio" name="fl_cu_cfe" id="cfe-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="cfe-2">
                                    <input type="radio" name="fl_cu_cfe" id="cfe-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="cfe-3">
                                    <input type="radio" name="fl_cu_cfe" id="cfe-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="telmex">Permisos de TELMEX:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="telmex-0">
                                    <input type="radio" name="fl_cu_telmex" id="telmex-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="telmex-1">
                                    <input type="radio" name="fl_cu_telmex" id="telmex-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="telmex-2">
                                    <input type="radio" name="fl_cu_telmex" id="telmex-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="telmex-3">
                                    <input type="radio" name="fl_cu_telmex" id="telmex-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="pemex">Permisos de PEMEX:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="pemex-0">
                                    <input type="radio" name="fl_cu_pemex" id="pemex-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="pemex-1">
                                    <input type="radio" name="fl_cu_pemex" id="pemex-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="pemex-2">
                                    <input type="radio" name="fl_cu_pemex" id="pemex-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="pemex-3">
                                    <input type="radio" name="fl_cu_pemex" id="pemex-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="inah">Permisos del INAH:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="inah-0">
                                    <input type="radio" name="fl_cu_inah" id="inah-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="inah-1">
                                    <input type="radio" name="fl_cu_inah" id="inah-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="inah-2">
                                    <input type="radio" name="fl_cu_inah" id="inah-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="inah-3">
                                    <input type="radio" name="fl_cu_inah" id="inah-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="inba">Permisos del INBA:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="inba-0">
                                    <input type="radio" name="fl_cu_inba" id="inba-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="inba-1">
                                    <input type="radio" name="fl_cu_inba" id="inba-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="inba-2">
                                    <input type="radio" name="fl_cu_inba" id="inba-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="inba-3">
                                    <input type="radio" name="fl_cu_inba" id="inba-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="sep">Autorizaci&oacute;n de la SEP:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="sep-0">
                                    <input type="radio" name="fl_cu_sep" id="sep-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="sep-1">
                                    <input type="radio" name="fl_cu_sep" id="sep-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="sep-2">
                                    <input type="radio" name="fl_cu_sep" id="sep-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="sep-3">
                                    <input type="radio" name="fl_cu_sep" id="sep-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="isem">Permisos del ISEM:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="isem-0">
                                    <input type="radio" name="fl_cu_isem" id="isem-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="isem-1">
                                    <input type="radio" name="fl_cu_isem" id="isem-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="isem-2">
                                    <input type="radio" name="fl_cu_isem" id="isem-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="isem-3">
                                    <input type="radio" name="fl_cu_isem" id="isem-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="conagua">Permisos de CONAGUA:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="conagua-0">
                                    <input type="radio" name="fl_cu_conagua" id="conagua-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="conagua-1">
                                    <input type="radio" name="fl_cu_conagua" id="conagua-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="conagua-2">
                                    <input type="radio" name="fl_cu_conagua" id="conagua-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="conagua-3">
                                    <input type="radio" name="fl_cu_conagua" id="conagua-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="marcas">Registro de Marcas:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="marcas-0">
                                    <input type="radio" name="fl_cu_marcas" id="marcas-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="marcas-1">
                                    <input type="radio" name="fl_cu_marcas" id="marcas-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="marcas-2">
                                    <input type="radio" name="fl_cu_marcas" id="marcas-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="marcas-3">
                                    <input type="radio" name="fl_cu_marcas" id="marcas-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="producto">Uso del Producto:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="producto-0">
                                    <input type="radio" name="fl_cu_producto" id="producto-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="producto-1">
                                    <input type="radio" name="fl_cu_producto" id="producto-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="producto-2">
                                    <input type="radio" name="fl_cu_producto" id="producto-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="producto-3">
                                    <input type="radio" name="fl_cu_producto" id="producto-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="caem">Permisos de CAEM:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="caem-0">
                                    <input type="radio" name="fl_cu_caem" id="caem-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="caem-1">
                                    <input type="radio" name="fl_cu_caem" id="caem-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="caem-2">
                                    <input type="radio" name="fl_cu_caem" id="caem-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="caem-3">
                                    <input type="radio" name="fl_cu_caem" id="caem-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="jc">Permisos de la JC:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="jc-0">
                                    <input type="radio" name="fl_cu_jc" id="jc-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="jc-1">
                                    <input type="radio" name="fl_cu_jc" id="jc-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="jc-2">
                                    <input type="radio" name="fl_cu_jc" id="jc-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="jc-3">
                                    <input type="radio" name="fl_cu_jc" id="jc-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="autmun">Permisos de la Autoridad Municipal:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="autmun-0">
                                    <input type="radio" name="fl_cu_autmun" id="autmun-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="autmun-1">
                                    <input type="radio" name="fl_cu_autmun" id="autmun-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="autmun-2">
                                    <input type="radio" name="fl_cu_autmun" id="autmun-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="autmun-3">
                                    <input type="radio" name="fl_cu_autmun" id="autmun-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='panel panel-success'>
                <div class='panel-heading' role='tab' id='heading2'>
                    <h4 class='panel-title'>
                        <a data-toggle='collapse' data-parent='#accordion' href='#collapse2' aria-expanded='true' aria-controls='collapseOne'>
                            Factibilidad Ambiental
                        </a>
                    </h4>
                </div>
                <div id='collapse2' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading2'>
                    <div class='panel-body'>
                        <div class='panel-heading'>
                            <h4 class='panel-title'>Cambio de Uso de Suelo</h4>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="moda">Tr&aacute;mite Unificado de Cambio de Uso de Suelo Forestal. Modalidad A:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="moda-0">
                                    <input type="radio" name="fa_us_moda" id="moda-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="moda-1">
                                    <input type="radio" name="fa_us_moda" id="moda-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="moda-2">
                                    <input type="radio" name="fa_us_moda" id="moda-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="moda-3">
                                    <input type="radio" name="fa_us_moda" id="moda-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="solautcu">Solicitud de Autorizaci&oacute;n de Cambio de Uso de Suelo en Terrenos Forestales:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="solautcu-0">
                                    <input type="radio" name="fa_us_solautcu" id="solautcu-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="solautcu-1">
                                    <input type="radio" name="fa_us_solautcu" id="solautcu-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="solautcu-2">
                                    <input type="radio" name="fa_us_solautcu" id="solautcu-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="solautcu-3">
                                    <input type="radio" name="fa_us_solautcu" id="solautcu-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class='panel-heading'>
                            <h4 class='panel-title'>Manifestaci&oacute;n de Impacto Ambiental</h4>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="miariesgo">MIA con riesgo:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="miariesgo-0">
                                    <input type="radio" name="fa_ia_miariesgo" id="miariesgo-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="miariesgo-1">
                                    <input type="radio" name="fa_ia_miariesgo" id="miariesgo-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="miariesgo-2">
                                    <input type="radio" name="fa_ia_miariesgo" id="miariesgo-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="miariesgo-3">
                                    <input type="radio" name="fa_ia_miariesgo" id="miariesgo-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="miapart">MIA Particular:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="miapart-0">
                                    <input type="radio" name="fa_ia_miapart" id="miapart-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="miapart-1">
                                    <input type="radio" name="fa_ia_miapart" id="miapart-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="miapart-2">
                                    <input type="radio" name="fa_ia_miapart" id="miapart-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="miapart-3">
                                    <input type="radio" name="fa_ia_miapart" id="miapart-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="miapr">MIA Particular con Riesgo:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="miapr-0">
                                    <input type="radio" name="fa_ia_miapr" id="miapr-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="miapr-1">
                                    <input type="radio" name="fa_ia_miapr" id="miapr-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="miapr-2">
                                    <input type="radio" name="fa_ia_miapr" id="miapr-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="miapr-3">
                                    <input type="radio" name="fa_ia_miapr" id="miapr-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="infpre">Informe Preventivo:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="infpre-0">
                                    <input type="radio" name="fa_ia_infpre" id="infpre-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="infpre-1">
                                    <input type="radio" name="fa_ia_infpre" id="infpre-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="infpre-2">
                                    <input type="radio" name="fa_ia_infpre" id="infpre-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="infpre-3">
                                    <input type="radio" name="fa_ia_infpre" id="infpre-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="camb">Certificaci&oacute;n Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="camb-0">
                                    <input type="radio" name="fa_ia_camb" id="camb-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="camb-1">
                                    <input type="radio" name="fa_ia_camb" id="camb-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="camb-2">
                                    <input type="radio" name="fa_ia_camb" id="camb-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="camb-3">
                                    <input type="radio" name="fa_ia_camb" id="camb-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class='panel-heading'>
                            <h4 class='panel-title'>Modificaciones Extenciones y Avisos</h4>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="aamia">Aviso de Desistimiento de la Autorizaci&oacute;n en Materia de Impacto Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="aamia-0">
                                    <input type="radio" name="fa_ea_aamia" id="aamia-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="aamia-1">
                                    <input type="radio" name="fa_ea_aamia" id="aamia-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="aamia-2">
                                    <input type="radio" name="fa_ea_aamia" id="aamia-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="aamia-3">
                                    <input type="radio" name="fa_ea_aamia" id="aamia-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="actamia">Aviso de Cambio de Titularidad de la Autorizaci&oacute;n de Impacto Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="actamia-0">
                                    <input type="radio" name="fa_ea_actamia" id="actamia-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="actamia-1">
                                    <input type="radio" name="fa_ea_actamia" id="actamia-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="actamia-2">
                                    <input type="radio" name="fa_ea_actamia" id="actamia-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="actamia-3">
                                    <input type="radio" name="fa_ea_actamia" id="actamia-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="anramia">Aviso de No Requerimiento de Autorizaci&oacute;n en Materia de Impacto Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="anramia-0">
                                    <input type="radio" name="fa_ea_anramia" id="anramia-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="anramia-1">
                                    <input type="radio" name="fa_ea_anramia" id="anramia-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="anramia-2">
                                    <input type="radio" name="fa_ea_anramia" id="anramia-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="anramia-3">
                                    <input type="radio" name="fa_ea_anramia" id="anramia-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="sepmia">Solicitud de Exenci&oacute;n de la Presentaci&oacute;n de la Manifestaci&oacute;n de Impacto Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="sepmia-0">
                                    <input type="radio" name="fa_ea_sepmia" id="sepmia-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="sepmia-1">
                                    <input type="radio" name="fa_ea_sepmia" id="sepmia-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="sepmia-2">
                                    <input type="radio" name="fa_ea_sepmia" id="sepmia-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="sepmia-3">
                                    <input type="radio" name="fa_ea_sepmia" id="sepmia-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="mpamia">Modificaciones a Proyectos Autorizados en Materia de Impacto Ambiental:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="mpamia-0">
                                    <input type="radio" name="fa_ea_mpamia" id="mpamia-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="mpamia-1">
                                    <input type="radio" name="fa_ea_mpamia" id="mpamia-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="mpamia-2">
                                    <input type="radio" name="fa_ea_mpamia" id="mpamia-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="mpamia-3">
                                    <input type="radio" name="fa_ea_mpamia" id="mpamia-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="pcca">Permiso para la Combusti&oacute;n a Cielo Abierto:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="pcca-0">
                                    <input type="radio" name="fa_ea_pcca" id="pcca-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="pcca-1">
                                    <input type="radio" name="fa_ea_pcca" id="pcca-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="pcca-2">
                                    <input type="radio" name="fa_ea_pcca" id="pcca-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="pcca-3">
                                    <input type="radio" name="fa_ea_pcca" id="pcca-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="atscrp">Autorizaci&oacute;n para la Transferencia de Sitios Contaminados con Residuos Peligrosos:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="atscrp-0">
                                    <input type="radio" name="fa_ea_atscrp" id="atscrp-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="atscrp-1">
                                    <input type="radio" name="fa_ea_atscrp" id="atscrp-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="atscrp-2">
                                    <input type="radio" name="fa_ea_atscrp" id="atscrp-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="atscrp-3">
                                    <input type="radio" name="fa_ea_atscrp" id="atscrp-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="salfor">Salud Forestal:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="salfor-0">
                                    <input type="radio" name="fa_ea_salfor" id="salfor-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="salfor-1">
                                    <input type="radio" name="fa_ea_salfor" id="salfor-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="salfor-2">
                                    <input type="radio" name="fa_ea_salfor" id="salfor-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="salfor-3">
                                    <input type="radio" name="fa_ea_salfor" id="salfor-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="plca">Permiso de Liberaci&oacute;n Comercial al Ambiente:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="plca-0">
                                    <input type="radio" name="fa_ea_plca" id="plca-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="plca-1">
                                    <input type="radio" name="fa_ea_plca" id="plca-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="plca-2">
                                    <input type="radio" name="fa_ea_plca" id="plca-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="plca-3">
                                    <input type="radio" name="fa_ea_plca" id="plca-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="apfo">Aprovechamiento Forestal:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="apfo-0">
                                    <input type="radio" name="fa_ea_apfo" id="apfo-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="apfo-1">
                                    <input type="radio" name="fa_ea_apfo" id="apfo-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="apfo-2">
                                    <input type="radio" name="fa_ea_apfo" id="apfo-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="apfo-3">
                                    <input type="radio" name="fa_ea_apfo" id="apfo-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='panel panel-success'>
                <div class='panel-heading' role='tab' id='heading3'>
                    <h4 class='panel-title'>
                        <a data-toggle='collapse' data-parent='#accordion' href='#collapse3' aria-expanded='true' aria-controls='collapseOne'>
                            Factibilidad T&eacute;cnica
                        </a>
                    </h4>
                </div>
                <div id='collapse3' class='panel-collapse collapse off' role='tabpanel' aria-labelledby='heading3'>
                    <div class='panel-body'>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="antpry">Anteproyecto:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="antpry-0">
                                    <input type="radio" name="ft_cu_antpry" id="antpry-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="antpry-1">
                                    <input type="radio" name="ft_cu_antpry" id="antpry-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="antpry-2">
                                    <input type="radio" name="ft_cu_antpry" id="antpry-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="antpry-3">
                                    <input type="radio" name="ft_cu_antpry" id="antpry-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="pryeje">Proyecto Ejecutivo:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="pryeje-0">
                                    <input type="radio" name="ft_cu_pryeje" id="pryeje-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="pryeje-1">
                                    <input type="radio" name="ft_cu_pryeje" id="pryeje-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="pryeje-2">
                                    <input type="radio" name="ft_cu_pryeje" id="pryeje-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="pryeje-3">
                                    <input type="radio" name="ft_cu_pryeje" id="pryeje-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="mecsue">Mec&aacute;nica de Suelos:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="mecsue-0">
                                    <input type="radio" name="ft_cu_mecsue" id="mecsue-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="mecsue-1">
                                    <input type="radio" name="ft_cu_mecsue" id="mecsue-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="mecsue-2">
                                    <input type="radio" name="ft_cu_mecsue" id="mecsue-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="mecsue-3">
                                    <input type="radio" name="ft_cu_mecsue" id="mecsue-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="esth">Estudio Hidrol&oacute;gico:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="esth-0">
                                    <input type="radio" name="ft_cu_esth" id="esth-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="esth-1">
                                    <input type="radio" name="ft_cu_esth" id="esth-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="esth-2">
                                    <input type="radio" name="ft_cu_esth" id="esth-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="esth-3">
                                    <input type="radio" name="ft_cu_esth" id="esth-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="estt">Estudio Topogr&aacute;fico:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="estt-0">
                                    <input type="radio" name="ft_cu_estt" id="estt-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="estt-1">
                                    <input type="radio" name="ft_cu_estt" id="estt-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="estt-2">
                                    <input type="radio" name="ft_cu_estt" id="estt-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="estt-3">
                                    <input type="radio" name="ft_cu_estt" id="estt-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="estit">Estudio de Ingenier&iacute;a de Tr&aacute;nsito:</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="estit-0">
                                    <input type="radio" name="ft_cu_estit" id="estit-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="estit-1">
                                    <input type="radio" name="ft_cu_estit" id="estit-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="estit-2">
                                    <input type="radio" name="ft_cu_estit" id="estit-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="estit-3">
                                    <input type="radio" name="ft_cu_estit" id="estit-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="terref">T&eacute;rminos de Referencia</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="terref-0">
                                    <input type="radio" name="ft_cu_terref" id="terref-0" value="1">
                                    Si
                                </label> 
                                <label class="radio-inline" for="terref-1">
                                    <input type="radio" name="ft_cu_terref" id="terref-1" value="2">
                                    No
                                </label> 
                                <label class="radio-inline" for="terref-2">
                                    <input type="radio" name="ft_cu_terref" id="terref-2" value="3">
                                    En Proceso
                                </label>
                                <label class="radio-inline" for="terref-3">
                                    <input type="radio" name="ft_cu_terref" id="terref-3" value="4" checked="checked">
                                    N/A
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="form-group" id="nes">
  <label class="col-md-3 control-label" for="firmar">  
    <input id='firmar' name='firmar' type="checkbox" value="1">
    Enviar estudio socioecon&oacute;mico para dictaminar      
  </label>    
</div>
-->

<div class="form-group col-md-10">
    <label class="col-lg-6 control-label"></label>
    <h6><font color="red" size="7">* </font>Campos obligatorios.</h6>
</div>

</fieldset>

<input hidden="true" id="usuuni" name="usuuni">
<input hidden="true" id="sig2" name="guar">
<input hidden="true" id="rut" name="rut">
<input hidden="true" id="valsig" name="valsig">
<input hidden="true" id="accionGuardar" name='accion' value="guardadoHoja1EstSoc">


<script type="text/javascript">
$('#accordion').collapse({
  toggle: false
})
</script>
