<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	  <meta charset="UTF-8">
	  <title>Contacto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estudio.css">
  <link rel="stylesheet" href="../css/font-awesome.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/botones.js"></script>
  <script type="text/javascript" src="../js/estudio.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
    <body>
    <div class="container-fluid"> 
      <?php
       include "funciones.php";
       
     if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
        if($_SESSION['id']==0){
           menu_admin('co');
         }else{
           menu_cliente('co');
         }
     }else{
       menu('co');
     }
      ?>
    <!-- Formulario de contacto -->
     <div class="container">
      <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <h2 id="contacto">Contactanos</h2>
            <form name="contactar" method='post' action='contacto.php' class="form-horizontal">
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input name="nombre" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input name="apellidos" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="tel">Teléfono</label>
                <input name="tel" type="text" class="form-control">
              </div>
              <div class='form-group'>
                <label for='asunto'>Asunto:</label>
                <input name='asunto' type='text' class='form-control'>
              </div>
              <textarea type="text" name="comentario" rows="5" cols="40" placeholder="Escribe aquí tu consulta." class="comentario"></textarea>
                <button name="enviar" type="submit" class="btn btn-default" value="Enviar Email" >
                  Contactar
                    <span class="glyphicon glyphicon-ok"></span>
                </button>
              <br>
            </form>
            <?php
              if(isset($_POST['enviar'])){
                echo "<h4>Mensaje enviado con éxito.</h4>";
              }else{
                echo " ";
              }
            ?>
          </div>
          <div class="mapa col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h2>Nuestra localización </h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3178.5846722339047!2d-3.6073575262069046!3d37.18634009810562!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2ses!4v1516608100898" width="800" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
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