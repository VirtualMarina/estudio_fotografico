<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Trabajos</title>
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

     if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
        if($_SESSION['id']==0){
           menu_admin('t');
           echo "<div class='row'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div> 
           <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
           <a href='trabajos.php?nuevotrabajo=si'>
            <button class='btn btn-md btn-primary' type='submit' name='nuevotrabajo' value='Nuevo Trabajo'>Añadir nuevo trabajo</button>
             </a>
           </div>";
         }else{
           header('Location: ../mistrabajos.php');
         }
     }else{
        menu('t');
        echo "<div class='row'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>";
     }
	?>
        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 busqueda">
          <form name="buscartrabajo" action="trabajos.php" method="post">
          <input name="barrabusqueda" type="text" placeholder="Buscar..">
          <button type="submit" name="buscar"><i class="fa fa-search"></i></button>
        </form></div>
      </div>
      <br>
	<?php
  //BUSCAR TRABAJO
    if(isset($_POST['buscar'])){
      $buscar=$_POST['barrabusqueda'];
      $conexion=conexion();
      $consulta="select * from trabajos where descripcion like '%$buscar%' or cliente like '%$buscar%' 
                  or precio like '%$buscar%'";
      $datos=mysqli_query($conexion,$consulta);
      if (mysqli_num_rows($datos)==0) {
        echo "Trabajo no encontrado";
      }else{
        echo "<div class='row'>
        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>
        <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
          <h2 align='center'>Resultado de búsqueda</h2>
          <table class='table table-striped'>
          <thead><tr>
          <th>Ver trabajo</th>
          <th>Titulo</th>
          <th>Descripcion</th>
          <th>Precio</th>
          </tr></thead>";
          while ($fila = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
          $id=$fila['id'];
          echo "<tbody><tr><td><a href='vertrabajo.php?vertrabajo=si&id=$id'>
                <button class='form-control btn btn-md btn-primary' type='submit' name='vertrabajo'>Ver trabajo</button>
                </a></td>
                <td>$fila[titulo]</td>
                <td>$fila[descripcion]</td>
                <td>$fila[precio]</td>
                </tr></tbody>";
                }
                echo "</table></div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
              }
            
      mysqli_close($conexion);
}
  //INSERTAR UN NUEVO TRABAJO 
  if(isset($_GET['nuevotrabajo'])){
      echo "<div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='insertartrabajo' method='post' action='trabajos.php' enctype='multipart/form-data' class='form-horizontal'>
          <h2>Nuevo trabajo</h2>
              <div class='form-group'>
                <label for='imagen'>Imagen</label>
                <input name='foto' type='file' id='imagen' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='titulo'>Titulo</label>
                <input name='titulo' type='text' id='titulo' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='descripcion'>Descripción</label>
                <input name='descripcion' type='text' id='descripcion' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='precio'>Precio</label>
                <input name='precio' type='text' id='precio' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='cliente'>Cliente</label>
                <select name='cliente' id='cliente' class='form-control'>";
                //muestra en select los clientes registrados
                $conexion = conexion();
                $consulta = "select id, nombre, apellidos from clientes order by nombre ASC";
                $clientes = mysqli_query($conexion,$consulta);
                while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                  echo "<option value='$fila[id]'>$fila[nombre] $fila[apellidos]</option>";
                }
               echo "</select>
              </div>
                <button name='guardatrabajo' type='submit' class='btn btn-default' value='Guardar Trabajo'>
                  Guardar Trabajo
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
              <br>
            </form>
            </div>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div><br>";
    }
    //Inserta trabajos en la base de datos 
      if (isset($_POST['guardatrabajo'])) {
          $titulo = $_POST['titulo'];
          $nombre_imagen = $_FILES['foto']['name'];
          $temp_name = $_FILES['foto']['tmp_name'];
          $descripcion = $_POST['descripcion'];
          $precio = $_POST['precio'];
          $cliente = $_POST['cliente'];
    //Comprueba si existe la carpeta destino de la imagen, si no existe la crea y mueve la imagen a ella
      if(!file_exists("./trabajos")){
          mkdir("./trabajos");
      }else{
          $ruta="trabajos/$nombre_imagen";
          move_uploaded_file($temp_name, "$ruta");
      }

        $conexion = conexion();
        //inserta los datos del trabajo y ruta de la imagen
        $consulta = "insert into trabajos values (null,'$ruta','$titulo','$descripcion','$precio','$cliente')";
        $datos = mysqli_query($conexion,$consulta);
        //Comprueba si se ha realizado la inserción de datos y devuelve un mensaje
        if (!$datos) {
          echo "<p>No se han podido añadir los datos</p>";
        }else{ 
          echo "<p>Datos añadidos con exito</p>";
            mysqli_close($conexion);
        ?>
       <meta http-equiv="refresh" content="1;url=trabajos.php">
    <?php
        }       
    }  
  
  //MODIFICAR UN TRABAJO
    if(isset($_GET['modtrabajo'])){
      $id_trabajo=$_GET['id'];
      $conexion = conexion();
      $consulta = "select id, imagen, titulo, descripcion, precio, cliente 
                       from trabajos
                       where id=$id_trabajo";
        $datos = mysqli_query($conexion,$consulta);
        $fila = mysqli_fetch_array($datos,MYSQLI_ASSOC);
        echo "<div class='row'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='cambiatrabajo' method='post' action='trabajos.php' enctype='multipart/form-data' class='form-horizontal'>
          <h2>Modificar trabajo</h2>
              <div class='form-group'>
                <input name='id' type='hidden' readonly='readonly' value='$fila[id]' class='form-control'>
              </div>
              <div class='form-group'>
                <input name='foto' type='hidden' id='imagen' value='$fila[imagen]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='titulo'>Titulo</label>
                <input name='titulo' type='text' id='titulo' value='$fila[titulo]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='descripcion'>Descripción</label>
                <input name='descripcion' type='text' id='descripcion' value='$fila[descripcion]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='precio'>Precio</label>
                <input name='precio' type='text' id='precio' value='$fila[precio]' class='form-control'>
              </div>
              <div class='form-group'>
                <label for='cliente'>Cliente</label>
                <select name='cliente' id='cliente' value='$fila[cliente]' class='form-control'>";
                //muestra en select los clientes registrados
                $conexion = conexion();
                $consulta = "select id, nombre, apellidos from clientes order by nombre ASC";
                $clientes = mysqli_query($conexion,$consulta);
                while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                  echo "<option value='$fila[id]'>$fila[nombre] $fila[apellidos]</option>";
                }
               echo "</select>
              </div>
                <button name='enviamodificado' type='submit' class='btn btn-default' value='Guardar Trabajo'>
                  Guardar Trabajo
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
              <br>
            </form>
            </div>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div><br>";
      }
      //envia los datos ya modificados a la base de datos
      if (isset($_POST['enviamodificado'])) {
          $id=$_POST['id'];
          $titulo = $_POST['titulo'];
          $nombre_imagen = $_POST['foto'];
          $descripcion = $_POST['descripcion'];
          $precio = $_POST['precio'];
          $cliente = $_POST['cliente'];

          
            $conexion = conexion();
            $consulta = "update trabajos set id=$id, imagen='$nombre_imagen', titulo='$titulo', 
                      descripcion='$descripcion', precio=$precio, cliente=$cliente where id=$id";
            $datos = mysqli_query($conexion,$consulta);
          if (!$datos) {
            echo "<p>No se han podido modificar los datos</p>";
          }else{
            echo "<p>Datos modificados con exito</p>";
            mysqli_close($conexion);
            ?><meta http-equiv="refresh" content="20;url=trabajos.php"><?php
          }
        }
        ?>
    <!-- Trabajos y Modificar -->
      <h2 align="center">Trabajos</h2>
          <?php 
            $conexion = conexion();
            $consulta = "select t.id id_trabajo, t.imagen, t.titulo, t.descripcion, t.precio, t.cliente, cli.id id_cli, cli.nombre nomcli, cli.apellidos ape
            			 from trabajos t, clientes cli
                          where t.cliente = cli.id";
            $trabajos = mysqli_query($conexion,$consulta);
            
            if (!$trabajos) {
              echo "¡Error! No se han podido cargar los trabajos.";
            } else {
              $num_filas = mysqli_num_rows($trabajos);
              if ($num_filas == 0) {
                echo "<p align='center'>No hay trabajos para mostrar</p>";
              } else {
                echo "<div class='row'>";
                echo" <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>";
                echo "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>";
                echo "<p align='center'><b>Se han listado $num_filas trabajos</b></p>";
                echo "<table class='table table-striped'";
                if(isset($_COOKIE['sesion'])){
                      session_decode($_COOKIE['sesion']);
                    if($_SESSION['id']==0){
                      echo "<thead><tr><th>Imagen</th><th>Título</th><th>Descripción</th><th>Cliente</th><th>Ver trabajo</th><th>Modificar</th><th>Borrar</th></tr></thead><tbody>";
                      while ($fila = mysqli_fetch_array($trabajos,MYSQLI_ASSOC)) {
                        $id=$fila['id_trabajo'];
                         $id_comprador=$fila['id_cli'];
                        echo "<tr><td><img src='$fila[imagen]' style='max-width:100px'></td><td>$fila[titulo]</td><td>$fila[descripcion]</td><td>$fila[nomcli]</td>
                        <td><a href='vertrabajo.php?vertrabajo=si&id=$id'>
                        <button class='form-control btn btn-md btn-primary' type='submit' name='vertrabajo'><span class='glyphicon glyphicon-eye-open'></span></button>
                       </a></td>";
                          if($id_comprador==0){
                            echo "<td><a href='trabajos.php?modtrabajo=si&id=$id'>
                              <button class='form-control btn btn-md btn-primary' type='submit' name='modificar'><span class='glyphicon glyphicon-pencil'></span>
                              </button></a></td>
                              <td><a href='trabajos.php?borratrabajo=si&id=$id'>
                              <button class='form-control btn btn-md btn-primary' type='submit' name='borrar' value='Borrar' id='borrar'><span class='glyphicon glyphicon-remove'></span></button>
                              </a></td></tr></tbody>";
                          }else{
                            echo "<td></td>
                            <td><a href='trabajos.php?borratrabajo=si&id=$id'>
                            <button class='form-control btn btn-md btn-primary' type='submit' name='borrar' value='Borrar' id='borrar'><span class='glyphicon glyphicon-remove'></span></button>
                            </a></td></tr></tbody>";
                          }
                      }
                    }
                  }else{
                    echo "<thead><tr><th>Imagen</th><th>Título</th><th>Descripción</th><th>Cliente</th><th>Ver trabajo</th></tr></thead><tbody>";
                      while ($fila = mysqli_fetch_array($trabajos,MYSQLI_ASSOC)) {
                        $id=$fila['id_trabajo'];
                        $id_comprador=$fila['id_cli'];
                        echo "<tr><td><img src='$fila[imagen]' style='max-width:100px'></td><td>$fila[titulo]</td><td>$fila[descripcion]</td>"; 
                        if($id_comprador==0){
                          echo "<td>$fila[nomcli]</td>";
                        }else{
                           echo "<td>Vendido</td>";
                        }
                        echo "<td><a href='vertrabajo.php?vertrabajo=si&id=$id'>
                        <button class='form-control btn btn-md btn-primary' type='submit' name='vertrabajo'><span class='glyphicon glyphicon-eye-open'></span></button>
                       </a></td>";
                      }
                  }
                  
                
                echo "</tbody></table></div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
              }
            }

  
//BORRAR UN TRABAJO
  if(isset($_GET['borratrabajo'])){
    $id_trabajo=$_GET['id'];
    echo "$id";
    $conexion = conexion();
    $consulta = "delete from trabajos where id=$id_trabajo";
    $datos = mysqli_query($conexion, $consulta);
    if (!$datos) {
      echo "<p>No se han podido borrar los datos</p>";
    }else{
      echo "<p>Datos borrados con exito</p>";
        mysqli_close($conexion);
      ?>
      <meta http-equiv="refresh" content="1;url=trabajos.php">
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

</div>
</body>
</html>