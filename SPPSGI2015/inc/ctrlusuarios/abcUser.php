<form id="formUser">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 panel-body">                
                <div class="input-group input-group-sm col-sm-12">  
                    <span class="input-group-addon">*Usuario:</span>
                    <input type="text" class="form-control obligatorio" placeholder="" id="lgnUser" name="lgnUser"/>                    
                </div> 
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm col-sm-12">  
                    <span class="input-group-addon">*Password:</span>
                    <input type="password" class="form-control obligatorio" placeholder="" id="passUser" name="passUser"/>                    
                </div>
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm col-sm-12">                      
                    <input type="password" class="form-control passEqual" placeholder="Confirmar password" id="passUser1" name="passUser1"/>                    
                    <span class="input-group-addon" id="errorPass"><span class="" id="errorPass">&nbsp;&nbsp;&nbsp;</span></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">*Sistemas a ingresar:</div>
                    <div class="panel-body">
                        <select multiple="multiple" size="3" name="sistUser[]" id="sistUser" class="form-control"></select>
                    </div>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*Nombre:</span>
                    <input type="text" class="form-control obligatorio" placeholder="" id="nombreUser" name="nombreUser"/>
                </div>
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*A. P.:</span>
                    <input type="text" class="form-control obligatorio" placeholder="Apellido Paterno" id="apPatUser" name="apPatUser"/>
                </div>
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">A. M.:</span>
                    <input type="text" class="form-control" placeholder="Apellido Materno" id="apMatUser" name="apMatUser"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*@:</span>
                    <input type="text" class="form-control obligatorio correo" placeholder="Correo electr&oacute;nico" id="emailUser" name="emailUser"/>
                </div>
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Tel.:</span>
                    <input type="text" class="form-control telef" placeholder="" id="telUser" name="telUser"/>
                </div>
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Ext.:</span>
                    <input type="text" class="form-control telef" placeholder="Extensi&oacute;n" id="extUser" name="extUser"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Desc.:</span>
                    <input type="text" class="form-control" placeholder="Descripci&oacute;n" id="descUser" name="descUser">
                </div>                     
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*Tipo de usuario:</span>
                    <select name="tipoUser" id="tipoUser" class="form-control seleccion">
                        <option value="-1">Seleccione</option>
                        <option value="IN">Interno</option>
                        <option value="EX">Externo</option>
                    </select>
                </div>            
            </div>
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*Nivel de usuario:</span>
                    <select name="nivelUser" id="nivelUser" class="form-control seleccion">
                        <option value="-1">Seleccione</option>
                        <option value="A">Administrador</option>
                        <option value="T">Tesorer&iacute;a</option>
                        <option value="J">Jefe de departamento</option>
                        <option value="D">Director de &aacute;rea</option>
                        <option value="O">Operativo</option>
                        <option value="PE">Personal externo</option>
                        <option value="EP">Ejecutora de los poderes</option>
                        <option value="R">Unidad responsable</option>
                        <option value="EC">Ejecutora central</option>
                        <option value="EA">Ejecutora auxiliar</option>
                        <option value="EO">Ejecutora aut&oacute;noma</option>
                        <option value="U">UIPPE</option>
                        <option value="RO">Responsable operativo</option>
                        <option value="EB">EB</option>
                        <option value="MUN">Municipio</option>
                        <option value="UE">Unidad Ejecutora</option>
                    </select>
                </div>    
            </div>
        </div>   
        <div class="row">
            <div class="col-sm-4 panel-body">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">*Rol:</span>
                    <select name="rolUser" id="rolUser" class="form-control seleccion">
                        <option value="-1">Seleccione</option>                        
                    </select>
                </div>    
            </div>
        </div>
        <div class="row" style="display: none;" id="rowUEs">
            <div class="col-sm-12 panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">*Unidad Ejecutora:</div>
                    <div class="panel-body">
                        <select name="ueUser" id="ueUser" class="form-control seleccion">
                            <option value='-1'>Seleccione</option>
                        </select>                    
                    </div>
                </div>     
            </div>
        </div>
        <div class="row" style="display: none;" id="rowSectores">
            <div class="col-sm-12 panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">*Sector(es):</div>
                    <div class="panel-body">
                        <select multiple="multiple" size="3" name="secUser[]" id="secUser" class="form-control"></select>                    
                    </div>
                </div>     
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">*Dependencia(s):</div>
                    <div class="panel-body">
                        <select multiple="multiple" size="3" name="depUser[]" id="depUser" class="form-control"></select>                    
                    </div>
                </div>     
            </div>
        </div>                
    </div>
    <input type="hidden" name="accionUser" id="accionUser" value=""/>
    <input type="hidden" name="idUser" id="idUser" value=""/>
</form>
