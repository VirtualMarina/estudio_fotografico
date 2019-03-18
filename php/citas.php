<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	  <meta charset="UTF-8">
	  <title>Citas</title>
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
           menu_admin('ci');
         }else{
           header('Location: ../miscitas.php');
         }
     }else{
        header('Location: ../acceder.php');
     }
      ?>
       
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 mostrarcentrado">
          <a href='citas.php?nuevacita=si'>
            <button class='btn btn-md btn-primary' type='submit' name='nuevacita' value='Nueva cita'>Añadir nueva cita</button>
          </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
      </div><br>
        
        <?php 
      //INSERTAR NUEVA CITA
     //Formulario que recoge los datos de la cita 
     if(isset($_GET['nuevacita'])){
      echo "<div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='nuevacita' method='post' action='citas.php' class='form-horizontal'>
          <h2>Nueva cita</h2>
              <div class='form-group'>
                <label for='fecha'>Fecha</label>
                <input name='fecha' type='date' id='fecha' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='hora'>Hora</label>
                <input name='hora' type='time' id='hora' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='lugar'>Lugar</label>
                <input name='lugar' type='text' id='lugar' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='motivo'>Motivo</label>
                <input name='motivo' type='text' id='motivo' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='cliente'>Cliente</label>
                <select name='cliente' id='cliente' class='form-control'>";
                //muestra en select los clientes registrados para elegir con cual es la cita
              $conexion = conexion();
              $consulta = 'select id, nombre, apellidos from clientes where id >0  order by nombre ASC';
              $clientes = mysqli_query($conexion,$consulta);
              while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                  echo "<option value='$fila[id]'>$fila[nombre] $fila[apellidos]</option>";
              }
              echo "</select></div>
                <button name='enviar' type='submit' class='btn btn-default' value='Guardar cita'>
                  Guardar cita
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
              <br>
            </form>
      </div>
  
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div>
      <br>";
    }
    //Guarda los datos de la nueva cita en la base de datos
        if (isset($_POST['enviar'])) {
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $lugar = $_POST['lugar'];
            $motivo = $_POST['motivo'];
            $cliente = $_POST['cliente'];

            $conexion = conexion();
            $consulta = "insert into citas values (null,'$fecha','$hora','$lugar','$motivo',$cliente)";
            $datos = mysqli_query($conexion,$consulta);
            if (!$datos) {
            echo "<p>No se han podido añadir los datos</p>";
            }else{
            echo "<p>Datos añadidos con exito</p>";
            mysqli_close($conexion);
            ?>
            <meta http-equiv="refresh" content="0;url=citas.php">
            <?php
            }
        }
   ?>
    
      <div class="row">
        <!-- Calendario -->
      
            
            <!-- PHP que muestra el calendario del mes pedido -->
            <?php 

              if(isset($_GET['mes'])){
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
          <h2 align="center">Próximas citas</h2>
          <?php 
            $conexion = conexion();
            $consulta = "select c.id id_cita,c.fecha fecha_cita,c.hora,c.motivo,c.lugar,c.cliente,cli.id,cli.nombre,cli.telefono1 
                          from citas c, clientes cli
                          where c.cliente = cli.id
                          order by fecha asc";
            $citas = mysqli_query($conexion,$consulta);
            $fila = mysqli_fetch_array($citas,MYSQLI_ASSOC);
            $num_filas = mysqli_num_rows($citas);
            if (!$citas) {
              echo "¡Error! No se han podido cargar las citas.";
            } else {
              //filtra solo las citas futuras
              $fecha_actual = date('Y-m-d');
              $fecha_actual_timestamp = strtotime(($fecha_actual));
                if ($num_filas == 0) {
                echo "<p align='center'>No hay citas para mostrar</p>";
                } else {
                echo "<table class='table table-striped'";
                echo "<thead><tr><th>Fecha</th><th>Hora</th><th>Lugar</th><th>Motivo</th><th>Cliente</th><th>Teléfono</th><th>Modificar</th><th>Borrar</th></tr></thead>";
                while ($fila = mysqli_fetch_array($citas,MYSQLI_ASSOC)) {
                  $id_cita=$fila['id_cita'];
                  $cita = strtotime($fila['fecha_cita']);
                  $fecha_formateada=date("d/m/Y",$cita);
                  $hora_cita=strtotime($fila['hora']);
                  $hora_formateada=date("G:H",$hora_cita);

                  if($cita >= $fecha_actual_timestamp){
                  echo "<tbody><tr>
                      <td>$fecha_formateada</td>
                      <td>$hora_formateada</td>
                      <td>$fila[lugar]</td>
                      <td>$fila[motivo]</td>
                      <td>$fila[nombre]</td>
                      <td>$fila[telefono1]</td>
                      <td><a href='citas.php?modcita=si&id_cita=$id_cita'>
                      <button class='form-control btn btn-md btn-primary' type='submit' name='modificar' value='Modificar'>Modificar
                      </button></td>
                      <td><a href='citas.php?borracita=si&id_cita=$id_cita'>
                      <button class='form-control btn btn-md btn-primary' type='submit' name='borrar' value='Borrar' id='borrar'>Borrar</button>
                      </a></td>
                      </tr></tbody>";
                }
              }
                echo "</table>";
              } 
              }
            
            ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
          </div>
      <?php
          //MODIFICAR CITA
        if(isset($_GET['modcita'])){
          $id_cita=$_GET['id_cita'];
          $conexion = conexion();
          $consulta = "select c.id num_cita,c.fecha fecha_cita, c.hora hora_cita,c.motivo motivo_cita, 
                        c.lugar lugar_cita,c.cliente cliente_cita,cli.id,cli.nombre cnom,
                         cli.apellidos cape, cli.telefono1 
                          from citas c, clientes cli
                          where c.cliente = cli.id and c.id=$id_cita";
          $citas = mysqli_query($conexion,$consulta);
          $fila = mysqli_fetch_array($citas,MYSQLI_ASSOC);


          echo "<div class='row'>
        <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5'></div>
        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
        <h2> Modificar cita</h2>
            <form name='cambiacita' method='post' action='citas.php' class='form-horizontal'>
              <div class='form-group'> 
                <input name='num_cita' type='hidden' readonly='readonly' value='$fila[num_cita]'>
              </div>
              <div class='form-group'>
                <label for='fecha'>Fecha</label>
                <input name='fecha' type='date' id='fecha' value='$fila[fecha_cita]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='hora'>Hora</label>
                <input name='hora' type='time' id='hora' placeholder='$fila[hora_cita]' value='$fila[hora_cita]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='lugar'>Lugar</label>
                <input name='lugar' type='text' id='lugar' placeholder='$fila[lugar_cita]' value='$fila[lugar_cita]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='motivo'>Motivo</label>
                <input name='motivo' type='text' id='motivo' placeholder='$fila[motivo_cita]' value='$fila[motivo_cita]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='cliente'>Cliente</label>
                <select name='cliente' id='cliente' class='form-control'>
                <option value='$fila[cliente_cita]'>$fila[cnom] $fila[cape]</option>";
            //muestra en select los clientes registrados para elegir con cual es la cita
              $conexion = conexion();
              $consulta2 = "select id, nombre, apellidos from clientes where id >0  order by nombre ASC";
              $clientes = mysqli_query($conexion,$consulta2);
              while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                  echo "<option value='$fila[id]'>$fila[nombre] $fila[apellidos]</option>";
              }
            echo "</select><span></span><p></p>
          </div>
          <div class='form-group'>
            <button name='enviamodificado' type='submit' class='btn btn-default' value='Guardar Cita'>
               Guardar cita
                    <span class='glyphicon glyphicon-ok'></span>
            </button>
          </div>
        <br>
        </form>";
      }
      echo "<div class='col-lg-5 col-md-5 col-sm-5 col-xs-5'></div></div>";
      //envia los datos ya modificados a la base de datos
      if (isset($_POST['enviamodificado'])) {
            $num_cita=$_POST['num_cita'];
            $fecha=$_POST['fecha'];
            $hora=$_POST['hora'];
            $lugar=$_POST['lugar'];
            $motivo=$_POST['motivo'];
            $cliente=$_POST['cliente'];

            $conexion = conexion();
            $consulta = "update citas set id=$num_cita, fecha='$fecha', hora='$hora', lugar='$lugar', motivo='$motivo',
             cliente=$cliente where id=$num_cita";
            $datos = mysqli_query($conexion,$consulta);
          if (!$datos) {
            echo "<p>No se han podido modificar los datos</p>";
          }else{
            echo "<p>Datos modificados con exito</p>";
            ?>
            <meta http-equiv="refresh" content="1;url=citas.php">
            <?php
          }
        }

    //BORRAR CITA
    if(isset($_GET['borracita'])){
      $id_cita=$_GET['id_cita'];
      echo "$id_cita";
      $conexion = conexion();
      $consulta = "delete from citas where id=$id_cita";
      $datos = mysqli_query($conexion, $consulta);
    if (!$datos) {
      echo "<p>No se han podido borrar los datos</p>";
    }else{
      echo "<p>Datos borrados con exito</p>";
      ?>
      <meta http-equiv="refresh" content="0;url=citas.php">
    <?php
    }
  }
  ?>
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