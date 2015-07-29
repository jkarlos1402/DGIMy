
<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css"> 
<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap-duallistbox.css"> 
<link rel="stylesheet" type="text/css" href="css/datepicker3.css" rel="stylesheet">

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bootstrap-duallistbox.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/autoNumeric.js"></script>
<script type="text/javascript" src="js/funcionesUser.js"></script>
<div class="panel panel-default">
    <div class="panel-heading">Control de usuarios</div>
    <div class="panel-body">
        <div>
            <ul class="nav nav-tabs" role="tablist" id="tabsUser">
                <li role="presentation" class="active"><a href="#addUser" role="tab" data-toggle="tab">Usuarios</a></li>
                <li role="presentation"><a href="#permissionUser" role="tab" data-toggle="tab">Permisos</a></li>  
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active panel-body" id="addUser">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php include 'inc/ctrlusuarios/abcUser.php'; ?>
                        </div>
                        <div class="panel-footer" id="footerButtons">
                            <div class="row">
                                <div class="col-md-2"><button type="button" class="btn btn-success" aria-expanded="false" id="btnGuardarUser">Guardar nuevo</button></div>
                                <div class="col-md-2"><button type="button" class="btn btn-default" aria-expanded="false" id="btnBuscarUser">Buscar</button></div>
                                <div class="col-md-2"><button type="button" class="btn btn-default" aria-expanded="false" id="btnActualizarUser" style="display: none;">Actualizar</button></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" aria-expanded="false" id="btnInhabilitarUser" style="display: none;">Inhabilitar usuario</button>
                                    <button type="button" class="btn btn-danger" aria-expanded="false" id="btnHabilitarUser" style="display: none;">Habilitar usuario</button>
                                </div>                                                             
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><button type="button" class="btn btn-default" aria-expanded="false" id="btnResetUser">Limpiar</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane panel-body" id="permissionUser">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php include 'inc/ctrlusuarios/abcPermisos.php'; ?>
                        </div>
                        <div class="panel-footer" id="footerButtons">
                            <div class="row">
                                <div class="col-md-2"><button type="button" class="btn btn-success" aria-expanded="false" id="btnBuscarUserPermisos">Buscar</button></div>
                                <div class="col-md-2"><button type="button" class="btn btn-default" aria-expanded="false" id="btnGuardarPermisos" style="display: none;">Guardar</button></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>                                                             
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><button type="button" class="btn btn-default" aria-expanded="false" id="btnLimpiarPermisos">Limpiar</button></div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div> 
        </div>
    </div>    
</div>
<div class="modal fade" id="modalAvisoUser" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel">Informaci&oacute;n</h4>
            </div>
            <div class="modal-body" id="infoBody">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>                
            </div>
        </div>
    </div>
</div>