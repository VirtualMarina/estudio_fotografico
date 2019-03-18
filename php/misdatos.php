<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	 <meta charset="UTF-8">
	 <title>Mis datos</title>
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
           menu_cliente('cl');
         }
     }else{
        header('Location: acceder.php');
     }
     
        $id_sesion=$_SESSION['id'];//guardo el id que contiene session en una variable
        $nombre_sesion=$_SESSION['nombre'];//guardo el nombre que contiene session en una variable  
    ?>
	<!-- MUESTRA LOS DATOS DEL CLIENTE -->
        <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          <h2 align="center">Mis datos</h2>
          <?php 
            $conexion = conexion();
            $consulta = "select * from clientes where id not in (0) and id=$id_sesion";
            $clientes = mysqli_query($conexion,$consulta);
            $fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC);
            if (!$clientes) {
              echo "¡Error! No se han podido cargar los datos.";
            } else {
              $num_filas = mysqli_num_rows($clientes);
              if ($num_filas == 0) {
                echo "<p align='center'>No hay datos para mostrar</p>";
              } else {
                echo "<table class='table table-striped'";
                echo "<thead><tr><th>Modificar</th><th>Nombre</th><th>Apellidos</th><th>Dirección</th><th>Teléfono 1</th><th>Teléfono 2</th></tr></thead>";
                  echo "<tbody><tr><td><a href='misdatos.php?modcliente=si'>
                      <button class='form-control btn btn-md btn-primary' type='submit' name='modificar'><span class='glyphicon glyphicon-pencil'></span></button>
                     </a></td>
                      <td>$fila[nombre]</td>
                      <td>$fila[apellidos]</td>
                      <td>$fila[direccion]</td>
                      <td>$fila[telefono1]</td>
                      <td>$fila[telefono2]</td>
                      </tr></tbody>";
            
                echo "</table>";
              }
            }
           ?>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
          </div>
         </div>
    <?php
    if(isset($_GET['modcliente'])){
          $conexion = conexion();
          $consulta = "select id, nombre, apellidos, direccion, telefono1, telefono2, nick, password 
                       from clientes
                       where id=$id_sesion";
          $cliente = mysqli_query($conexion,$consulta);
          $fila = mysqli_fetch_array($cliente,MYSQLI_ASSOC);
          
           echo "<div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='cambiacliente' method='post' action='misdatos.php' class='form-horizontal'>
          <h2 style=text-align:center>Modificar datos</h2>
              <div class='form-group'>
                <input name='id' type='hidden' readonly='readonly' value='$fila[id]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='nombre'>Nombre</label>
                <input name='nombre' type='text' id='nombre' readonly='readonly' value='$fila[nombre]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='apellidos'>Apellidos</label>
                <input name='apellidos' type='text' id='apellidos' readonly='readonly' value='$fila[apellidos]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='direccion'>Dirección</label>
                <input name='direccion' type='text' id='direccion' value='$fila[direccion]' class='form-control'>
              </div>
               <div class='form-group'>
                <label for='telefono1'>Telefono Nº1</label>
                <input name='telefono1' type='text' id='telefono1' value='$fila[telefono1]' class='form-control'>
              </div>
               <div class='form-group'>
                <label for='telefono2'>Telefono Nº2</label>
                <input name='telefono2' type='text' id='telefono2' value='$fila[telefono2]' class='form-control'>
              </div>
               <div class='form-group'>
                <label for='nick'>Nick</label>
                <input name='nick' type='text' id='nick' readonly='readonly' value='$fila[nick]' class='form-control'>
              </div>
               <div class='form-group'>
                <label for='password'>Contraseña</label>
                <input name='password' type='text' id='password' value='$fila[password]' class='form-control'>
              </div>
                <button name='enviamodificado' type='submit' class='btn btn-default' value='Guardar datos'>
                  Guardar datos
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
              <br>
            </form>
      </div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div>
      <br>";
      }
      //envia los datos ya modificados a la base de datos
      if (isset($_POST['enviamodificado'])) {
            $id=$_POST['id'];
            $nombre=$_POST['nombre'];
            $apellidos=$_POST['apellidos'];
            $direccion=$_POST['direccion'];
            $telefono1=$_POST['telefono1'];
            $telefono2=$_POST['telefono2'];
            $nick=$_POST['nick'];
            $password=$_POST['password'];

            $conexion = conexion();
            $consulta = "update clientes set id=$id, nombre='$nombre', apellidos='$apellidos', 
                      direccion='$direccion', telefono1=$telefono1, telefono2=$telefono2, 
                      nick='$nick',password='$password' where id=$id";
            $datos = mysqli_query($conexion,$consulta);
          if (!$datos) {
            echo "<div class='row'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>
              <div col-lg-8 col-md-8 col-sm-8 col-xs-8 style='color:red'>
              <h2 align='center'><span class='glyphicon glyphicon-remove'></span>No se han podido modificar los datos</h2>
              </div>
              <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
          }else{
            echo "<div class='row'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>
              <div col-lg-8 col-md-8 col-sm-8 col-xs-8 style='color:green'>
              <h2 align='center'><span class='glyphicon glyphicon-ok'></span>Datos modificados con éxito</h2>
              </div>
              <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
            mysqli_close($conexion);
            ?><meta http-equiv="refresh" content="2;url=misdatos.php"><?php
          }
        }?>
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
</div> <!--cierra el div container-fluid que abarca toda la pagina-->
</body>
</html>