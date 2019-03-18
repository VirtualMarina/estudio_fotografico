<?php

function conexion(){
  $conect = mysqli_connect('us-cdbr-iron-east-03.cleardb.net','bddde377aed8ea','acac307d','heroku_63242dc8ae565d2');
	mysqli_set_charset($conect, 'utf8');
		return $conect;
}
function db_close(){
  $conexion=conexion();
    mysqli_close($conexion);
}
//Creo una funcion de menú para cada tipo de usuario(administrador,cliente y usuario sin loguear)
function menu($seccion){ 
		echo "<div class='row'>
			          </div>
		             <div class='row'>
		               <div class='col-sm-12'>
			            <nav class='navbar navbar-default' class='col-sm-12'>
		                  <div class='container-fluid'>
		                    <ul class='nav navbar-nav'>";
		if($seccion == '0'){
				echo "<li class='active'><a href='index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";
        echo "<li><a href='./php/trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
        echo "<li><a href='./php/contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li></ul>";
        echo "<ul class='nav navbar-nav navbar-right'><li><a href='./php/acceder.php'><span class='glyphicon glyphicon-user'></span> Acceder</a></li></ul>";
		}else{
			echo "<li><a href='../index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";

      if($seccion == 't'){
        echo "<li class='active'><a href='./trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
      }else{
        echo "<li><a href='./trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
      }

      if($seccion == 'co'){
        echo "<li class='active'><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }else{
        echo "<li><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }
    
      if($seccion == 'a'){
       echo "</ul><ul class='nav navbar-nav navbar-right'><li class='active'><a href='./acceder.php'><span class='glyphicon glyphicon-user'></span> Acceder</a></li></ul>";
      }else{
        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='./acceder.php'><span class='glyphicon glyphicon-user'></span> Acceder</a></li></ul>";
      }
		}
		echo " </div>
		           </nav>
		      </div>
		    </div>";       
	}
function menu_admin($seccion){ 
    echo "<div class='row'>
                </div>
                 <div class='row'>
                   <div class='col-sm-12'>
                  <nav class='navbar navbar-default' class='col-sm-12'>
                      <div class='container-fluid'>
                        <ul class='nav navbar-nav'>";
    if($seccion == '0'){
        echo "<li class='active'><a href='index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";
        echo "<li><a href='./php/noticias.php'><span class='glyphicon glyphicon-list-alt'></span> Noticias</a></li>";
        echo "<li><a href='./php/clientes.php'><span class='glyphicon glyphicon-briefcase'></span> Clientes</a></li>";
        echo "<li><a href='./php/trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
        echo "<li><a href='./php/citas.php'><span class='glyphicon glyphicon-calendar'></span> Citas</a></li>";
        echo "<li><a href='./php/contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li></ul>";
        echo "<ul class='nav navbar-nav navbar-right'><li><a href='./php/salir.php'><span class='glyphicon glyphicon-log-out'></span> Cerrar sesión de administrador</a></li></ul>";
    }else{
      echo "<li><a href='../index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";

      if($seccion == 'n'){
        echo "<li class='active'><a href='./noticias.php'><span class='glyphicon glyphicon-list-alt'></span> Noticias</a></li>";
      }else{
        echo "<li><a href='./noticias.php'><span class='glyphicon glyphicon-list-alt'></span> Noticias</a></li>";
      }

      if($seccion == 'cl'){
        echo "<li class='active'><a href='./clientes.php'><span class='glyphicon glyphicon-briefcase'></span> Clientes</a></li>";
      }else{
        echo "<li><a href='./clientes.php'><span class='glyphicon glyphicon-briefcase'></span> Clientes</a></li>";
      }

      if($seccion == 't'){
        echo "<li class='active'><a href='./trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
      }else{
        echo "<li><a href='./trabajos.php'><span class='glyphicon glyphicon-camera'></span> Trabajos</a></li>";
      }

      if($seccion == 'ci'){
       echo "<li class='active'><a href='./citas.php'><span class='glyphicon glyphicon-calendar'></span> Citas</a></li>";
      }else{
        echo "<li><a href='./citas.php'><span class='glyphicon glyphicon-calendar'></span> Citas</a></li>";
      }

      if($seccion == 'co'){
        echo "<li class='active'><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }else{
        echo "<li><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }
    
      if($seccion == 'a'){
       echo "</ul><ul class='nav navbar-nav navbar-right'><li class='active'><a href='./salir.php'><span class='glyphicon glyphicon-log-out'></span> Cerrar sesión de administrador</a></li></ul>";
      }else{
        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='./salir.php'><span class='glyphicon glyphicon-log-out'></span> Cerrar sesión de administrador</a></li></ul>";
      }
    }
    echo " </div>
               </nav>
          </div>
        </div>";       
  }
  function menu_cliente($seccion){ 
    $nombre=$_SESSION['nombre'];
    echo "<div class='row'>
                </div>
                 <div class='row'>
                   <div class='col-sm-12'>
                  <nav class='navbar navbar-default' class='col-sm-12'>
                      <div class='container-fluid'>
                        <ul class='nav navbar-nav'>";
    if($seccion == '0'){
        echo "<li class='active'><a href='index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";
        echo "<li><a href='./php/mistrabajos.php'><span class='glyphicon glyphicon-camera'></span> Mis trabajos</a></li>";
        echo "<li><a href='./php/misdatos.php'><span class='glyphicon glyphicon-edit'></span> Mis datos</a></li>";
        echo "<li><a href='./php/miscitas.php'><span class='glyphicon glyphicon-calendar'></span> Mis citas</a></li>";
        echo "<li><a href='./php/contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li></ul>";
        echo "<ul class='nav navbar-nav navbar-right'><li><a href='./php/salir.php'><span class='glyphicon glyphicon-log-out'></span> Cerrar sesión de $nombre</a></li></ul>";
    }else{
      echo "<li><a href='../index.php'><span class='glyphicon glyphicon-home'></span> Inicio</a></li>";

      if($seccion == 't'){
        echo "<li class='active'><a href='./mistrabajos.php'><span class='glyphicon glyphicon-camera'></span> Mis trabajos</a></li>";
      }else{
        echo "<li><a href='./mistrabajos.php'><span class='glyphicon glyphicon-camera'></span> Mis trabajos</a></li>";
      }

      if($seccion == 'cl'){
        echo "<li class='active'><a href='./misdatos.php'><span class='glyphicon glyphicon-edit'></span> Mis datos</a></li>";
      }else{
        echo "<li><a href='./misdatos.php'><span class='glyphicon glyphicon-edit'></span> Mis datos</a></li>";
      }

      if($seccion == 'ci'){
       echo "<li class='active'><a href='./miscitas.php'><span class='glyphicon glyphicon-calendar'></span> Mis citas</a></li>";
      }else{
        echo "<li><a href='./miscitas.php'><span class='glyphicon glyphicon-calendar'></span> Mis citas</a></li>";
      }

      if($seccion == 'co'){
        echo "<li class='active'><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }else{
        echo "<li><a href='./contacto.php'><span class='glyphicon glyphicon-phone-alt'></span> Contacto</a></li>";
      }
    
      if($seccion == 'a'){
       echo "</ul><ul class='nav navbar-nav navbar-right'><li class='active'><a href='./salir.php'><span class='glyphicon glyphicon-log-out'></span> Salir</a></li></ul>";
      }else{
        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='./salir.php'><span class='glyphicon glyphicon-log-out'></span> Cerrar sesión de $nombre</a></li></ul>";
      }
    }
    echo " </div>
               </nav>
          </div>
        </div>";       
  }

 function mostrarCalendario($dia, $mes, $año) {
      $semana = 1;
     $id_cliente=$_SESSION['id'];
      for ( $i=1;$i<=date( 't', strtotime( $año."-".$mes."-".$dia) );$i++ ) { // dia 1 al numero de dias del mes
        $dia_semana = date( 'N', strtotime(  $año."-".$mes."-".$i )  );// numero del dia
        $calendario[$semana][$dia_semana] = $i; //Guardo el mes en un array
        if ( $dia_semana == 7 ) // si el dia de la semana es 7 cambio de semana
        $semana++;
      }

      $citas_mes = array();
      $conexion = conexion();
      if($_SESSION['id']==0){
        $consulta = "select fecha from citas where fecha like '$año-$mes-%'";
      }else{
        $consulta = "select fecha from citas where fecha like '$año-$mes-%' and cliente=$id_cliente";

      }
      $fechas = mysqli_query($conexion,$consulta);



      if (!$fechas) {
        echo "Error al cargar las fechas de las citas...";
      } else {
        while ($fila = mysqli_fetch_array($fechas,MYSQLI_ASSOC)) {
          $fe_marca = strtotime($fila['fecha']);
          $mesA = date('n',$fe_marca);
          $diaA = date('d',$fe_marca);
          $citas_mes[]=$diaA;
        }
      }

      // muestro el calendario del mes
      $mes_antes = $mes-1;
      if($_SESSION['id']==0){
      echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><ul class='pager'>
              <li><a href='citas.php?mes=$mes_antes&anio=".$año."'><span class='glyphicon glyphicon-menu-left'></span></a></li>
          </ul></div>";
      }else{
        echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><ul class='pager'>
              <li><a href='miscitas.php?mes=$mes_antes&anio=".$año."'><span class='glyphicon glyphicon-menu-left'></span></a></li>
          </ul></div>";
      }
      echo "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'><table class='table'>";
        echo "<tbody>";
        echo "<tr bgcolor='#b2b6b9'><th>LUNES</th><th>MARTES</th><th>MIERCOLES</th><th>JUEVES</th><th>VIERNES</th><th>SABADO</th><th>DOMINGO</th></tr>";
        //$fe_marca = strtotime($fila['fecha']);
        //$fecha_base=mktime(0,0,0,date("m",$fe_marca),date("d",$fe_marca),date("Y",$fe_marca));
        //$fecha_actual=mktime(0,0,0,date("m"),date("d"),date("Y"));

        foreach ($calendario as $dias_mes) { // cojo los días del mes almacenados en el array
          echo "<tr>";
          for ($i = 1; $i <= 7; $i++) {

            if (isset($dias_mes[$i])) {
              //busca en el array citas el día por el que va i para comprobar si hay alguna
           
              if (in_array($dias_mes[$i],$citas_mes)) {
                  echo "<td bgcolor='#65c3c6' align='center'>".$dias_mes[$i]."</td>";
              }elseif($dias_mes[$i] == date('d') && $mes == date('n')){
                echo "<td bgcolor='red' align='center'>".$dias_mes[$i]."</td>";
              } else {
                echo "<td bgcolor='white' align='center'>".$dias_mes[$i]."</td>";
              }
            } else {
              echo "<td></td>";
            }
          }
          echo "</tr>";
        }
        echo "</tbody>";
      echo "</table></div>";

    $mes_antes = $mes-1;
    $mes_despues = $mes+1;

    if($_SESSION['id']==0)
      echo " <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><ul class='pager'>
              <li><a href='citas.php?mes=$mes_despues&anio=".$año."'><span class='glyphicon glyphicon-menu-right'></span></a></li>
           </ul></div>";
    else{
      echo " <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><ul class='pager'>
              <li><a href='miscitas.php?mes=$mes_despues&anio=".$año."'><span class='glyphicon glyphicon-menu-right'></span></a></li>
           </ul></div>";
    }
  }


    function imagen_aleatoria(){
    $aleatorio="select id, imagen from trabajos order by rand() limit 1";
    $conexion= conexion();
    $datos=mysqli_query($conexion,$aleatorio);
    $fila=mysqli_fetch_array($datos);
    $id=$fila['id'];
    $imagen=$fila['imagen'];
    $imagen="php/".$imagen;
      echo "<div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                  <div class='panel panel-default'>
                      <div class='estilofoto' style='background-image: url($imagen)'></div>
                  </div>
                </div>
              </div>";
    mysqli_close($conexion);
}

function footer(){
  echo "<div class='row' id='footer'>
          <footer class='footer'>
            <div class='col-xs-12 col-md-4'>
              <text id='centrado'> @Hazzatumbo </text>
            </div>
            <div class='col-xs-12 col-md-4'>
               <ul class='list-inline' id='centrado'>
                  <li><a href='https://twitter.com/Hazzatumbo' target='_blank'><i class='fa fa-twitter fa-2x'></i></a></li>
                  <li><a href='https://es-es.facebook.com/' target='_blank'><i class='fa fa-facebook fa-2x'></i></a></li>
                  <li><a href='https://www.instagram.com/hazzatumbo/' target='_blank'><i class='fa fa-instagram fa-2x'></i></a></li>
                </ul>
            </div>
            <div class='col-xs-12 col-md-4'>
              <text id='centrado'>Teléfonos de contacto: 958656429 / 661359358</text>
            </div>
          </footer>
        </div>";
}
      
?>