<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	  <meta charset="UTF-8">
	  <title>Noticias</title>
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
           menu_admin('n');
         }else{
           header('Location: ../index.php');
         }
     }else{
        header('Location: ../acceder.php');
     }
      ?>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
         <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
           <a href='noticias.php?insertanoticia=si'>
            <button class='btn btn-md btn-primary' type='submit' name='nuevocliente' value='Nueva Noticia'>Añadir nueva noticia</button>
          </a>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-2 busqueda">
          <form name="buscarnoticia" action="noticias.php" method="post">
          <input name="barrabusqueda" type="text" placeholder="Buscar..">
          <button type="submit" name="buscar"><i class="fa fa-search"></i></button>
        </form></div>
      </div><br>
    
  <?php
  //BUSCAR NOTICIA
    if(isset($_POST['buscar'])){
      $buscar=$_POST['barrabusqueda'];
      $conexion=conexion();
      $consulta="select * from noticias where titular like '%$buscar%'";
      $datos=mysqli_query($conexion,$consulta);
      if (mysqli_num_rows($datos)==0) {
        echo "Noticia no encontrada";
      }else{
        echo "<div class='row'>
        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>
        <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
          <h2 align='center'>Resultado de búsqueda</h2>
          <table class='table table-striped'>
          <thead><tr>
          <th>Ver más</th>
          <th>Titular</th>
          <th>Fecha</th>
          </tr></thead>";
          while ($fila = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
          $id=$fila['id'];
          echo "<tbody><tr><td><a href='vernoticia.php?vermas=si&id=$id'>
                <button class='form-control btn btn-md btn-primary' type='submit' name='vermas'>Ver más</button>
                </a></td>
                <td>$fila[titular]</td>
                <td>$fila[fecha]</td>
                </tr></tbody>";
                }
                echo "</table></div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
              }
            
      mysqli_close($conexion);
}
  //INSERTAR NUEVA NOTICIA
  if(isset($_GET['insertanoticia'])){
      echo "<div class='container-fluid'>
      <div class='row'>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
        <form name='insertarnoticia' method='post' action='noticias.php' enctype='multipart/form-data' class='form-horizontal'>
         <h2>Nueva Noticia</h2>
         <div class='form-group'>
            <label for='titular'>Titular</label>
            <input name='titular' type='text' id='titular' class='form-control'>
          </div>
          <div class='form-group'>
          <label for='imagen'>Imagen</label>
            <input name='foto' type='file' id='imagen' class='form-control'>
          </div>
          <div class='form-group'>
            <label for='contenido'>Contenido</label>
            <input name='contenido' type='text' id='contenido' class='form-control'>
          </div>
          <div class='form-group'>
            <label for='fecha'>Fecha</label>
            <input name='fecha' type='date' id='fecha' class='form-control'>
          </div>
            <button name='guardarnoticia' type='submit' class='btn btn-default' value='Guardar Noticia'>
                  Guardar noticia
                    <span class='glyphicon glyphicon-ok'></span>
                </button>
              <br>
            </form>
      </div>
      <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
      </div>
      <br>";
    }
    //Inserta noticias en la base de datos 
      if (isset($_POST['guardarnoticia'])) {
          $titular = $_POST['titular'];
          $nombre_imagen = $_FILES['foto']['name'];
          $temp_name = $_FILES['foto']['tmp_name'];
          $contenido = $_POST['contenido'];
          $fecha = $_POST['fecha'];
    //Comprueba si existe la carpeta destino de la imagen, si no existe la crea y mueve la imagen a ella
      if(!file_exists("./noticias")){
          mkdir("./noticias");
      }else{
          $ruta="noticias/$nombre_imagen";
          move_uploaded_file($temp_name, "$ruta");
      }
        $conexion = conexion();
        //inserta los datos de la noticia y ruta de la imagen
        $consulta = "insert into noticias values (null,'$titular','$contenido','$ruta','$fecha')";
        $datos = mysqli_query($conexion,$consulta);
        //Comprueba si se ha realizado la inserción de datos y devuelve un mensaje
        if (!$datos) {
          echo "<p>No se han podido añadir los datos</p>";
        }else{ 
          echo "<p>Datos añadidos con exito</p>";
            mysqli_close($conexion);
        ?>
        <meta http-equiv="refresh" content="1;url=noticias.php">
    <?php
        }
  }
  //BORRAR UNA NOTICIA
  if(isset($_GET['borranoticia'])){
    $id=$_GET['id'];
    $conexion = conexion();
    $consulta = "delete from noticias where id=$id";
    $datos = mysqli_query($conexion, $consulta);
    if (!$datos) {
      echo "<p>No se han podido borrar los datos</p>";
    }else{
      echo "<p>Datos borrados con exito</p>";
        mysqli_close($conexion);
      ?>
      <meta http-equiv="refresh" content="1;url=noticias.php">
    <?php
    }
  }?>

    <!-- MUESTRA LAS NOTICIAS -->
    <div id="noticias">
    <h2 align="center">Noticias</h2>
    <?php

    //saco la fecha actual
    $fecha_actual=mktime(0,0,0,date("m"),date("d"),date("Y"));
      $conexion = conexion();
      if(!isset($_GET['num_pag']))
      {
      	$inicio = 0;
      }
      else
      {
      	$inicio = $_GET['num_pag']*3;
      }
      $consulta = "select * from noticias limit $inicio,3";//muestra las noticias de tres en tres 
      $datos = mysqli_query($conexion,$consulta);
      $num = mysqli_num_rows($datos);
        if ($num ==0) {
          echo "<p>No se han encontrado noticias</p>";
              }else{
                echo "<div class='row'>";
                while($fila=mysqli_fetch_array($datos)){
                  $fecha_noticia=strtotime($fila['fecha']);
                  $fecha_base=mktime(0,0,0,date("m",$fecha_noticia),date("d",$fecha_noticia),date("Y",$fecha_noticia));

                  if ($fecha_base<=$fecha_noticia) {
                   $imagen=$fila['imagen'];
                   $id=$fila['id'];
                   $fecha_formateada=date("j/m/Y",$fecha_noticia);
                        echo "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                        <a href='vernoticia.php?vermas=si&id=$id'>
                          <img src='$imagen' style='max-width:100%'>
                        <h3><b>$fila[titular]</h3>
                        <h5>$fila[contenido]</h5>
                        <p>$fecha_formateada</p></a>
                                <a href='noticias.php?borranoticia=si&id=$id'>
                                <button class='form-control btn btn-md btn-primary' type='submit' name='borrar' value='Borrar' id='borrar'>Borrar</button>
                                </a></div>";
                  }
                }
                echo "</div>";
              }
           
            if($inicio==0){
            	$siguiente=1;
            	echo "<ul class='pager'><li><a href='noticias.php?num_pag=$siguiente'><button class='btn btn-md btn-primary' type='submit' name='siguiente' value='siguiente'>Siguiente</button></a></li></ul>";
            }else{
            	$siguiente=$_GET['num_pag']+1;
            	$anterior=$_GET['num_pag']-1;
            	echo "<ul class='pager'><li><a href='noticias.php?num_pag=$anterior'><button class='btn btn-md btn-primary' type='submit' name='anterior' value='anterior'>Anterior</button></a></li>";
              echo "<li><a href='noticias.php?num_pag=$siguiente'><button class='btn btn-md btn-primary' type='submit' name='siguiente' value='siguiente'>Siguiente</button></a></li></ul>";
            }

    echo "<br>";

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
    </div>
  </body>
</html>