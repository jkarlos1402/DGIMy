<form id="formPermisos">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 panel-body">                
                <div class="input-group input-group-sm col-sm-12">  
                    <span class="input-group-addon">*Usuario:</span>
                    <input type="text" class="form-control obligatorio" placeholder="" id="userPermiso" name="userPermiso"/>                    
                    <input type="text" style="display: none;"/>                    
                </div> 
            </div>
            <div class="col-sm-4 panel-body">                
                <div class="input-group input-group-sm col-sm-12"> 
                    <span class="input-group-addon">Nombre</span>                            
                    <span id="nombrePer" class="form-control"></span>                                  
                </div> 
            </div>            
        </div>
        <div class="row" id="permisosSGI" style="display: none;">  
            <div class="panel panel-default">
                <div class="panel-heading">M&oacute;dulos SGI</div>
                <div class="panel-body">
                    <div class="container-fluid" id="contenidoModulosSGI">
                        <div class="row">
                            <div class="col-sm-4 panel-body">  
                                <div class="input-group input-group-sm col-sm-12">
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="todosModulosSGI"/>
                                    </span>
                                    <span class="form-control">Todos</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>        
    </div>    
    <input type="hidden" name="accionUser"/>
    <input type="hidden" name="sistemasUserPermiso" id="sistemasUserPermiso"/>
    <input type="hidden" name="idUserPermiso" id="idUserPermiso"/>
</form>
