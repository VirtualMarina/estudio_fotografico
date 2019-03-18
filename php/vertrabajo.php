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
  <!-- Contenedor que abarca toda la pagina -->
    <div class="container-fluid"> 
    <?php
      include "funciones.php";

     if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
        if($_SESSION['id']==0){
           menu_admin('t');
            echo "<a href='trabajos.php'>
                <button class='btn btn-md btn-primary' type='submit' name='volver' value='Volver'>Volver</button></a>";
         }else{
           menu_cliente('t');
           echo "<a href='mistrabajos.php'>
                <button class='btn btn-md btn-primary' type='submit' name='volver' value='Volver'>Volver</button></a>";
         }
     }else{
        menu('t');
        echo "<a href='trabajos.php'>
                <button class='btn btn-md btn-primary' type='submit' name='volver' value='Volver'>Volver</button></a>";
     }
    ?>
   

      <?php
        if(isset($_GET['vertrabajo'])){
          $id=$_GET['id'];
          $conexion = conexion();
          $consulta = "select * from trabajos where id=$id";
          $datos = mysqli_query($conexion,$consulta);
          $fila=mysqli_fetch_array($datos);
          $num = mysqli_num_rows($datos);

        if ($num ==0) {
          echo "<p>No se han encontrado trabajos</p>";
              }else{
                $imagen=$fila['imagen'];
                echo "<div class='row'><div class='col-lg-2 col-md-20 col-sm-2 col-xs-0'></div>";
                echo "<div class='col-lg-10 col-md-10 col-sm-10 col-xs-12'>
                      <img src='$imagen' style='max-width:50%'>
                      <h1><b>$fila[titulo]</h1>
                      <h3>$fila[descripcion]</h3>
                      <h4>$fila[precio] €</h4></div>";
                echo "<div class='col-lg-2 col-md-20 col-sm-2 col-xs-0'></div></div>";
              }
        }else{
          echo "<h3>No se ha podido mostrar el trabajo</h3>";
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