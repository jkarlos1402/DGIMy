<?php
/**
 * Footer file
 */
if (CLI) {
    return;
}
?>
</div>
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
    //funcion para abrir automaticamente el word
    $( document ).ready(function() {
        window.location.href = $('a').attr('href');        
    });
</script>
</body>

</html>

