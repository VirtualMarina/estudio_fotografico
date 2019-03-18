<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Acceder</title>
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
           menu_admin('a');
         }else{
           menu_cliente('a');
         }
     }else{
        menu('a');
     }
  ?>

<!-- Formulario de inicio de sesión -->
    <div class="row">
      <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-4 col-lg-offset-4">
      <form class="form-signin" method="post" action="#">
        <h2 class="form-signin-heading">Iniciar sesión</h2>
        <label for="inputName" class="sr-only">Nombre</label>
        <input name="nombre" type="text" id="inputName" class="form-control" placeholder="Nombre" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input name="pass" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <div class="checkbox">
          <label>
            <input name="check" type="checkbox" value="remember-me"> Recordar mi usuario
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" name="iniciar" type="submit">Iniciar sesión</button>
      </form>
    </div>
  </div>
<?php
//Si se ha pulsado el boton iniciar sesion compruebo si existe un usuario con ese nick en la base de datos
if(isset($_POST['iniciar'])){
    $registrado=false;
    $conexion = conexion();
    $consulta = "select id, nombre, nick, password from clientes where nick='$_POST[nombre]'"; 
    $datos = mysqli_query($conexion,$consulta);
    
  if($fila=mysqli_fetch_array($datos)){
    //si existe compruebo si el nombre y contraseña coinciden
    if($_POST['nombre']==$fila['nick'] && $_POST['pass']==$fila['password']){
      //si coinciden guardo los datos en la sesion 
        $_SESSION['id']=$fila['id'];
        $_SESSION['nombre']=$fila['nombre'];
        $sesion=session_encode();
        //si se ha pulsado el check de mantener sesion almaceno los datos en una cookie con un año de caducidad
        if(isset($_POST['check'])){
            setcookie("sesion",$sesion,time()+(365*24*60*60),"/");
        }else{
          //si no quiere mantener la sesion creo una cookie que desaparezca al cerrar el navegador
            setcookie("sesion",$sesion,null,"/");
        }
        echo "<br><div class='row'>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                    <div class='alert alert-success'>
                      <strong><span class='glyphicon glyphicon-ok'></span></strong> ¡Todo correcto!.
                    </div>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div></div>";
        header('refresh:1;url=../index.php');
        //Si coincide el nombre pero no coincide la contraseña doy un aviso de contraseña incorrecta
    }elseif($_POST['nombre']==$fila['nick'] && $_POST['pass']!=$fila['password']){
      echo "<br><div class='row'>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                    <div class='alert alert-danger' style=text-align:center>
                         <strong>La contraseña no es correcta.</strong> Inténtalo de nuevo.
                    </div>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div></div>";
    }
  }else{
    //si el nick no pertenece a ningun usuario registrado le mando un aviso de que se puede dar de alta
      echo "<br><div class='row'>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                    <div class='alert alert-warning'>
                       <strong>No estas registrado.</strong>Ponte en contacto con nosotros para darte de alta como cliente.
                    </div>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'></div></div>";
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