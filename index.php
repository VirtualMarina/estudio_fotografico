<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estudio.css">
  <link rel="stylesheet" href="css/font-awesome.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/botones.js"></script>
  <script type="text/javascript" src="js/estudio.js"></script>
</head>
<body>
  <!-- Contenedor que abarca toda la pagina -->
    <div class="container-fluid"> 
    <?php
    include "php/funciones.php";
   /*Si existe la cookie significa que alguien se ha logueado, muestro el menu distinto si es admin o no, ni no existe 
    la cookie redirijo al login*/
     if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
        if($_SESSION['id']==0){
           menu_admin('0');
         }else{
           menu_cliente('0');
         }
     }else{
        menu('0');
     }
      
    //Muestra imagenes aleatorias
      imagen_aleatoria();

      $fecha_actual=date('Y-m-d');
      $conexion=conexion();
      $consulta="select id, titular, imagen,fecha from noticias where fecha<='$fecha_actual' order by fecha desc limit 3";
      $datos=mysqli_query($conexion,$consulta);

      //muestra las tres ultimas noticias
      echo "<div class='container-fluid'><div class='row'>";
      while($fila=mysqli_fetch_array($datos)){
        $id=$fila['id'];
        $imagen=$fila['imagen'];
        $imagen="php/".$imagen;
        $fecha_noticia=strtotime($fila['fecha']);
        $fecha_formateada=date("d/m/Y",$fecha_noticia);
         echo "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                  <a href='./php/vernoticia.php?vermas=si&id=$id'>
                    <img src='$imagen' style='max-width:100%'>
                    <h3><b>$fila[titular]</h3>
                    <p>$fecha_formateada</p></a>
                    <a href='php/vernoticia.php?vermas=si&id=$id'>
                      <button class='btn btn-default' type='submit' name='vermas' value='>Ver más'>Ver más ></button>
                    </a>
                </div>";
      }
      echo "</div></div>";
      
    ?>
<!-- código HTMl botón subir (top)-->
<a href="#" id="up" class="boton-subir">
  <!-- icono -->
  <i class="fa fa-arrow-up" aria-hidden="true"></i>
</a>
  <!-- Pie de página -->
    <?php
      footer();
    ?>
  </div>
</body>
</html>


