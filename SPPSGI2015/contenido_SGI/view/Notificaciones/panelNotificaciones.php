<?php session_start(); ?>
<script src="contenido_sgi/view/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/bootstrap.min.js" type="text/javascript"></script>
<script src='contenido_sgi/view/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src='contenido_SGI/view/js/DT_bootstrap.js' type='text/javascript'></script>
<script src="contenido_SGI/view/js/Notificaciones/notificaciones.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/Notificaciones/panelNotificaciones.js" type="text/javascript"></script>

<link href="contenido_SGI/view/css/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href='contenido_sgi/view/css/jquery.dataTables.min.css' rel='stylesheet'/>
<link href="contenido_SGI/view/css/bootstrap/css/bootstrap.css" rel="stylesheet"/>

<div class="panel panel-default">
    <div class="panel-heading"><b>Centro de notificaciones</b></div>
    <div class="panel-body">        
        <table class="table" id="tablaNotificaciones">
            <thead>
                <tr>                    
                    <th>Fecha</th>
                    <th>Mensaje</th>
                    <th>Vigencia</th>
                    <th>Le&iacute;do</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <p style="text-align: right; padding: 10px;">*Se despliegan las notificaciones no le&iacute;das de los &uacute;ltimos 30 d&iacute;as naturales</p>
    </div>    
</div>
<input type="hidden" id="idUsuarioSession" value="<?php echo $_SESSION['USERID']; ?>"/>
<input type="hidden" id="idRolUsuarioSession" value="<?php echo $_SESSION['USERIDROL']; ?>"/>
<div id="panelBotonesNotificacion" style="padding: 5px;position: fixed; bottom:50px; right: 15px;">
    <span class="btn btn-default" id="btnRefrescarNotificaciones">Refrescar</span>
</div>

