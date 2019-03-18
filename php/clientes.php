<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	 <meta charset="UTF-8">
	 <title>Clientes</title>
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
           menu_admin('cl');
         }else{
           header('Location: ../misdatos.php');
         }
     }else{
        header('Location: ../acceder.php');
     }
	?>
    <div class="row">
        <div class="col-lg-2 col-md-1 col-sm-0 col-xs-0"></div>
        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
          <a href='clientes.php?insertacliente=si'>
            <button class='btn btn-md btn-primary' type='submit' name='nuevocliente' value='Nuevo Cliente'>Añadir nuevo cliente</button>
          </a>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-2 busqueda">
          <form name="buscarcliente" action="clientes.php" method="post">
          <input name="barrabusqueda" type="text" placeholder="Buscar..">
          <button type="submit" name="buscar"><i class="fa fa-search"></i></button>
        </form>
        </div>
      </div>
      <br>
    <?PHP
    //BUSCAR CLIENTE
    if(isset($_POST['buscar'])){
      $buscar=$_POST['barrabusqueda'];
      $conexion=conexion();
      $consulta="select * from clientes where nombre like '%$buscar%' 
      or apellidos like  '%$buscar%' 
      or telefono1 like '%$buscar%' 
      or telefono2 like '%$buscar%'";
      $datos=mysqli_query($conexion,$consulta);
      if (mysqli_num_rows($datos)==0) {
        echo "Cliente no encontrado";
      }else{
        echo "<div class='row'>
        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>
        <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
          <h2 align='center'>Resultado de búsqueda</h2>
          <table class='table table-striped'>
          <thead><tr>
          <th>Modificar</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Dirección</th>
          <th>Teléfono 1</th>
          <th>Teléfono 2</th>
          </tr></thead>";
          while ($fila = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
          $id=$fila['id'];
          echo "<tbody><tr><td><a href='clientes.php?modcliente=si&id=$id'>
                <button class='form-control btn btn-md btn-primary' type='submit' name='modificar'><span class='glyphicon glyphicon-pencil'></span></button>
                </a></td>
                <td>$fila[nombre]</td>
                <td>$fila[apellidos]</td>
                <td>$fila[direccion]</td>
                <td>$fila[telefono1]</td>
                <td>$fila[telefono2]</td>
                </tr></tbody>";
                }
                echo "</table></div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
              }
            
      mysqli_close($conexion);
}
	//INSERTAR UN NUEVO CLIENTE
	//Formulario que recoge los datos del nuevo cliente	
	if(isset($_GET['insertacliente'])){
    echo "<div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='insertarcliente' method='post' action='clientes.php' class='form-horizontal'>
          <h2>Nuevo cliente</h2>
              <div class='form-group'>
                <label for='nombre'>Nombre</label>
                <input name='nombre' type='text' id='nombre' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='apellidos'>Apellidos</label>
                <input name='apellidos' type='text' id='apellidos' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='direccion'>Dirección</label>
                <input name='direccion' type='text' id='direccion' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='telefono1'>Teléfono Nº1</label>
                <input name='telefono1' type='text' id='telefono1' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='telefono2'>Teléfono Nº2*</label>
                <input name='telefono2' type='text' id='telefono2' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='nick'>Nick</label>
                <input name='nick' type='text' id='nick' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='pass'>Contraseña</label>
                <input name='pass' type='text' id='pass' class='form-control'>
              </div>
                <button name='guardacliente' type='submit' class='btn btn-default' value='Guardar Cliente'>
                  Guardar Cliente
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
                <text>  *Este campo es opcional.</text>
              <br>
            </form>
      </div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div>
      <br>";
    }
    //Guarda los datos del nuevo cliente en la base de datos
	if (isset($_POST['guardacliente'])) {
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$direccion = $_POST['direccion'];
		$telefono1 = $_POST['telefono1'];
		$telefono2 = $_POST['telefono2'];
		$nick = $_POST['nick'];
		$pass = $_POST['pass'];

		$conexion = conexion();
		if(!$telefono2){
			$consulta = "insert into clientes values (null,'$nombre','$apellidos','$direccion',$telefono1,null,'$nick','$pass')";
		}else{
			$consulta = "insert into clientes values (null,'$nombre','$apellidos','$direccion',$telefono1,$telefono2,'$nick','$pass')";
		}
		$datos = mysqli_query($conexion,$consulta);
		if (!$datos) {
			echo "<p>No se han podido añadir los datos</p>";
		}else{
			echo "<p>Datos añadidos con exito</p>";
				mysqli_close($conexion);
			?>
			<meta http-equiv="refresh" content="1;url=clientes.php">
		<?php
		}
	}
		//MODIFICAR CLIENTE
        if(isset($_GET['modcliente'])){
          $id=$_GET['id'];
          $conexion = conexion();
          $consulta = "select id, nombre, apellidos, direccion, telefono1, telefono2, nick, password 
                       from clientes
                       where id=$id";
          $cliente = mysqli_query($conexion,$consulta);
          $fila = mysqli_fetch_array($cliente,MYSQLI_ASSOC);
          
          echo "<div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='cambiacliente' method='post' action='clientes.php' class='form-horizontal'>
          <h2>Modificar cliente</h2>
              <input name='id' type='hidden' readonly='readonly' value='$fila[id]' class='form-control'>
              <div class='form-group'>
                <label for='nombre'>Nombre</label>
                <input name='nombre' type='text' id='nombre' value='$fila[nombre]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='apellidos'>Apellidos</label>
                <input name='apellidos' type='text' id='apellidos' value='$fila[apellidos]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='direccion'>Dirección</label>
                <input name='direccion' type='text' id='direccion' value='$fila[direccion]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='telefono1'>Teléfono Nº1</label>
                <input name='telefono1' type='text' id='telefono1' value='$fila[telefono1]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='telefono2'>Teléfono Nº2*</label>
                <input name='telefono2' type='text' id='telefono2' value='$fila[telefono2]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='nick'>Nick</label>
                <input name='nick' type='text' id='nick' value='$fila[nick]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='pass'>Contraseña</label>
                <input name='pass' type='text' id='pass' value='$fila[password]' class='form-control'>
              </div>
                <button name='enviamodificado' type='submit' class='btn btn-default' value='Guardar Datos'>
                  Guardar Datos
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
                <text>  *Este campo es opcional.</text>
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
            $password=$_POST['pass'];


            $conexion = conexion();
            $consulta = "update clientes set id=$id, nombre='$nombre', apellidos='$apellidos', 
            					direccion='$direccion', telefono1=$telefono1, telefono2=$telefono2, 
            					nick='$nick',password='$password' where id=$id";
                      echo "$consulta";
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
           
            ?><meta http-equiv="refresh" content="2;url=clientes.php"><?php
          }
        }?>
	<!-- Clientes y Modificar -->
        <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          <h2 align="center">Listado de clientes</h2>
          <?php 
            $conexion = conexion();
            $consulta = "select * from clientes where id not in (0)";
            $clientes = mysqli_query($conexion,$consulta);
            if (!$clientes) {
              echo "¡Error! No se han podido cargar los clientes.";
            } else {
              $num_filas = mysqli_num_rows($clientes);
              if ($num_filas == 0) {
                echo "<p align='center'>No hay clientes para mostrar</p>";
              } else {
                echo "<p align='center'><b>Se han listado $num_filas clientes</b></p>";
                echo "<table class='table table-striped'";
                echo "<thead><tr><th>Modificar</th><th>Nombre</th><th>Apellidos</th><th>Dirección</th><th>Teléfono 1</th><th>Teléfono 2</th></tr></thead>";
                while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                	$id=$fila['id'];
                  echo "<tbody><tr><td><a href='clientes.php?modcliente=si&id=$id'>
                      <button class='form-control btn btn-md btn-primary' type='submit' name='modificar'><span class='glyphicon glyphicon-pencil'></span></button>
                     </a></td>
                      <td>$fila[nombre]</td>
                      <td>$fila[apellidos]</td>
                      <td>$fila[direccion]</td>
                      <td>$fila[telefono1]</td>
                      <td>$fila[telefono2]</td>
                      </tr></tbody>";
                }
                echo "</table>";
              }
            }
           ?>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
          </div>
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
</div> <!--cierra el div container-fluid que abarca toda la pagina-->
</body>
</html>