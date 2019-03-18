<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis trabajos</title>
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
           menu_cliente('t');
         }
     }else{
        header('Location: acceder.php');
     }

        $id_sesion=$_SESSION['id'];//guardo el id que contiene session en una variable
        $nombre_sesion=$_SESSION['nombre'];//guardo el nombre que contiene session en una variable
  ?>
    <!-- Trabajos adquiridos por el cliente-->
          <?php 
            $conexion = conexion();
            $consulta = "select id, imagen, titulo, descripcion, precio, cliente 
                   from trabajos where cliente = $id_sesion";
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
                echo "<table class='table table-striped'";
                echo "<thead><tr><th>Imagen</th><th>Título</th><th>Descripción</th><th>Ver trabajo</th></tr></thead>";
                while ($fila = mysqli_fetch_array($trabajos,MYSQLI_ASSOC)) {
                   $id=$fila['id'];
                  echo "<tbody><tr><td><img src='$fila[imagen]' style='max-width:100px'></td><td>$fila[titulo]</td><td>$fila[descripcion]</td>
                      <td><a href='vertrabajo.php?vertrabajo=si&id=$id'>
                      <button class='form-control btn btn-md btn-primary' type='submit' name='vertrabajo'><span class='glyphicon glyphicon-eye-open'></span></button>
                      </a></td>";
                }
                echo "</table></div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div></div>";
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