<script src="contenido_SGI/view/js/expedienteTecnico/hojatres.js" type="text/javascript"></script>
<script src="contenido_SGI/view/js/expedienteTecnico/hojacuatro.js" type="text/javascript"></script>
<script>
    $("form,input").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
</script>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#h3"  role="tab" data-toggle="tab" onclick="cambiaHojaMP(3);">Conceptos</a></li>
    <li><a href="#h4" role="tab" data-toggle="tab" onclick="cambiaHojaMP(4);">Contratos</a></li>
</ul>

<form id="formGral" class="form-horizontal">
    <div class="tab-content">
        <div class="tab-pane active" id="h3">
            <?php include ('hojatres.php') ?>
        </div>
        <div class="tab-pane" id="h4">
            <?php include ('hojacuatro.php') ?>
            
        </div>
    </div>
</form>