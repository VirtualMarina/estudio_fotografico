<?php
    session_start();
    session_destroy();
    $_SESSION=array();
    setcookie("sesion",null,null,"/");

    header('Location: ../index.php');

?>