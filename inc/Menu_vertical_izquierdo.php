<?php
    //------------
?>

<link rel="stylesheet" href="tendina_menu_style.css">

<style type="text/css">

  .mnu-inicio{
    height: 25px;
    background: #2B2B2B;    
    color: #F7F7F7;
    padding: 2px 10px;
  }

</style>

<ul class="dropdown">

   <div class="mnu-inicio"><span class="glyphicon glyphicon-list"></span> M&oacute;dulos</div> 
    <!-- <ul class="mnu-inicio"> -->
        <!-- <li><a class="pry_3" href="javascript:cambia_contenido(0,0)"><span class="glyphicon glyphicon-list"> </span> Inicio</a></li> -->
        

        <!-- <li><a class="pry_3" href="#"><span class="glyphicon glyphicon-list"> </span> M&oacute;dulos</a></li> -->
    <!-- </ul> -->
    <!-- <div class="separador"></div> -->
    <!-- modulo 1 -->  
    <li>
    <a class="ant" href="#"><i class="fa fa-caret-right"></i>&nbsp; Anteproyecto</a>
    <ul>
      <li>
        <a class="pry_3" href="#">Planeaci&oacute;n</a>
        <ul>
          <li><a id="pry_pla_1" href="#">item_3_1</a></li>
          <li><a class="pry_pla_2" href="#">item_3_2</a></li>
        </ul>
      </li>
      <li>
        <a class="pry_3" href="#">Presupuesto</a>  
        <ul>

        </ul>
      </li>
      <li>
        <a class="pry_3" href="#"><i class="fa fa-angle-right"></i>&nbsp; Inversi&oacute;n</a>
        <ul>
            <li><a class="ant_1" href="javascript:cambia_contenido(1,21)">. <? print $avMnuGE[1][21] ?></a></li>
            <li><a class="ant_2" href="javascript:cambia_contenido(1,22)">. <? print $avMnuGE[1][22] ?></a></li>      
            <li><a class="ant_4" href="javascript:cambia_contenido(1,23)">. <? print $avMnuGE[1][23] ?></a></li>  
            <li><a class="ant_5" href="javascript:cambia_contenido(1,24)">. <? print $avMnuGE[1][24] ?></a></li>  
            <li><a class="ant_5" href="javascript:cambia_contenido(1,25)">. <? print $avMnuGE[1][25] ?></a></li>             
        </ul>
      </li>
    </ul>
    </li>

  <!-- modulo 2 -->  
  <li>
    <a class="pry" href="#"><i class="fa fa-caret-right"></i>&nbsp; Proyecto</a>
    <ul>
      <li><a class="pry_1" href="javascript:cambia_contenido(2,21)"><? print $avMnuGE[2][21] ?></a></li>
      <li><a class="pry_2" href="#">item-2</a></li>
      <li>
        <a class="pry_3" href="#">item-3</a>
        <ul>
          <li><a id="pry_3_1" href="#">item_3_1</a></li>
          <li><a class="pry_3_2" href="#">item_3_2</a></li>
        </ul>
      </li>
    </ul>
  </li>
    
  <!-- modulo 3 -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp; Redefinici&oacute;n</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>

  <!-- modulo 4 -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp; Calendarizaci&oacute;n</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>

  <!-- modulo 5 -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp; Informes</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>

  <!-- modulo 6 -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp; Adecuaciones</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>

<div class="separador"></div>
  <!-- modulo  -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp;  Banco de proyectos</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>
<!-- modulo  -->    
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp;  SIAVAMEN</a>
    <ul>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>

      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
      <li><a class="rdf_1" href="#">item_1</a></li>
      <li><a class="rdf_2" href="#">item_2</a></li>
    </ul>
  </li>
<div class="separador"></div>

  <!-- modulo 7 -->
  <li>
    <a class="rdf" href="#"><i class="fa fa-caret-right"></i>&nbsp;  Herramientas</a>
    <ul>      
      <li><a class="rdf_2" href="javascript:cambia_contenido(7,2)"><? print $avMnuGE[7][2] ?></a></li>      
    </ul>
  </li>

<div class="separador"></div>
    <ul>
        <li><a class="pry_3" href="contenido/LogOut.php"><span class="glyphicon glyphicon-off "> </span> <? print $avMnuGE[7][1] ?></a></li>
    </ul>    
<div class="separador"></div>

</ul>


<br>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="tendina.min.js"></script>
<script>
  $('.dropdown').tendina({
    animate: true,
    speed: 500,
    onHover: false,
    hoverDelay: 300,
    activeMenu: $('.gin-lemon'),
    openCallback: function(clickedEl) {
      //console.log('Hey dude!');
      console.log('Hi');
    },
    closeCallback: function(clickedEl) {
      // console.log('Bye dude!');
      console.log('Bye!');
    }
  })
</script>
