<?php
session_start();

if ($_SESSION['status_session']){
    header("Location: index.php");
}

include_once("library/Usuario.php");
include_once("library/Compania.php");
include_once("library/Contrato.php");
$usuario  = new Usuario();
$compania = new Compania();
$contrato = new Contrato();

if(!empty($_POST)){
    if( $usuario->loadForLogin($_POST['usuario'], $_POST['password']) )
    {
        $_SESSION['status_session'] = true;
        $_SESSION['id_usuario'] = $usuario->getId() ;
        $_SESSION['nombre'] = $usuario->getNombre() ;
        $_SESSION['usuario'] = $usuario->getLogin() ;
        $_SESSION['tipo_usuario'] = $usuario->getTipoUsuario() ;
    }

    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEMAT | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>
            <img src="img/logo2.png" alt="Smiley face" height="112" width="282">
        </div>

        <form method="post" class="m-t" role="form" action="login.php">
            <div class="form-group">
                <input name ="usuario" type="text" class="form-control" placeholder="Usuario" required="">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Acceder</button>
        </form>
        <p class="m-t"> <small>Servicios Marinos Y Terrestres S.A. de C.V. &copy; 2016-2018</small> </p>
    </div>
</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
