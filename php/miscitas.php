<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	  <meta charset="UTF-8">
	  <title>Mis citas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estudio.css">
  <link rel="stylesheet" href="../css/font-awesome.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/botones.js"></script>
  <script type="text/javascript" src="../js/estudio.js"></script>
  </head>
  <body>
  <div class="container-fluid"> 
   
      <?php
        include "funciones.php";
    /*Si existe la cookie significa que alguien se ha logueado, muestro el menu distinto si es admin o no, ni no existe 
    la cookie redirijo al login*/
     if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
        if($_SESSION['id']==0){
           header('Location: ../index.php');
         }else{
           menu_cliente('ci','$nombre');
         }
     }else{
        header('Location: ../acceder.php');
     }

        $id_sesion=$_SESSION['id'];//guardo el id que contiene session en una variable
        $nombre_sesion=$_SESSION['nombre'];//guardo el nombre que contiene session en una variable
      ?>
  <div class="row">
        <!-- Calendario -->
            <!-- PHP que muestra el calendario del mes pedido -->
            <?php 
              if(isset($_GET['mes']))
              {
                $dia = "01";
                $mes = $_GET['mes'];
                if($mes == 0){
                  $mes = 12;
                  $anio = $_GET['anio']-1;
                }
                elseif($mes == 13){
                  $mes=1;
                  $anio = $_GET['anio']+1;
                }
                else
                  $anio = $_GET['anio']; 
              }else{
                $mes = date('m');
                $anio = date('Y');
                $dia = date('d');
              }
              //if($mes < 10) $mes = "0$mes";
              switch ($mes) {
        case 1:
          $nombre_mes='Enero';
          break;
        case 2:
          $nombre_mes='Febrero';
          break;
        case 3:
          $nombre_mes='Marzo';
          break;
        case 4:
          $nombre_mes='Abril';
          break;
        case 5:
          $nombre_mes='Mayo';
          break;
        case 6:
          $nombre_mes='Junio';
          break;
        case 7:
          $nombre_mes='Julio';
          break;
        case 8:
          $nombre_mes='Agosto';
          break;
        case 9:
          $nombre_mes='Septiembre';
          break;
        case 10:
          $nombre_mes='Octubre';
          break;
        case 11:
          $nombre_mes='Noviembre';
          break;  
        case 12:
          $nombre_mes='Diciembre';
          break;
        default:
          $nombre_mes='';
          break;
      }

          echo "<h2 align='center'>$nombre_mes $anio</h2>";

          mostrarCalendario($dia, $mes, $anio);
      ?>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
        </div><!--cierre del row--> 
        
        <!-- Listado de citas -->
        <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          <h2 align="center">Mis citas</h2>
          <?php 
            $conexion = conexion();
            $consulta = "select c.id,c.fecha fecha_cita,c.hora,c.motivo,c.lugar,cli.id,cli.nombre,cli.telefono1 
                          from citas c, clientes cli
                          where c.cliente = cli.id
                          and c.cliente =$id_sesion
                          order by fecha asc";
            $citas = mysqli_query($conexion,$consulta);
            if (!$citas) {
              echo "¡Error! No se han podido cargar las citas.";
            } else {
               $fecha_actual = date('Y-m-d');
              $fecha_actual_timestamp = strtotime(($fecha_actual));
              $num_filas = mysqli_num_rows($citas);
              if ($num_filas == 0) {
                echo "<p align='center'>No hay citas para mostrar</p>";
              } else {
                echo "<table class='table table-striped'";
                echo "<thead><tr><th>Fecha</th><th>Hora</th><th>Lugar</th><th>Motivo</th><th>Cliente</th><th>Teléfono</th></tr></thead>";
                while ($fila = mysqli_fetch_array($citas,MYSQLI_ASSOC)) {
                  $cita = strtotime($fila['fecha_cita']);
                  $fecha_formateada=date("d/m/Y",$cita);
                  $hora_cita=strtotime($fila['hora']);
                  $hora_formateada=date("G:H",$hora_cita);
                  echo "<tbody><tr>
                      <td>$fecha_formateada</td>
                      <td>$hora_formateada</td>
                      <td>$fila[lugar]</td>
                      <td>$fila[motivo]</td>
                      <td>$fila[nombre]</td>
                      <td>$fila[telefono1]</td>
                      </tr></tbody>";
                }
                echo "</table>";
              }
            }

           ?>
        
         </div>
    <!-- código HTMl botón subir (top)-->
      <a href="#" id="up" class="boton-subir">
      <!-- icono -->
      <i class="fa fa-arrow-up" aria-hidden="true"></i>
      </a>
    <!-- Pie de página -->
    <?php
      db_close();
      footer();
    ?>
    </div><!--cierre del div container general-->
  </body>
</html>