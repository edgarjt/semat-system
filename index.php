<?php
session_start() ;
     include_once("library/Usuario.php");
     include_once("library/Compania.php");
     include_once("library/Contrato.php");
     $usuario  = new Usuario();
     $compania = new Compania();
     $contrato = new Contrato();
     $a        = "Inicio de sesión";
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SMT</title>

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
                <br>
                <br>
                <img src="img/logo2.png" alt="Smiley face" height="112" width="282">
                <br>
                 <!--<h1 class="logo-name">PAN</h1>-->

            </div>
            
            <form method="post" class="m-t" role="form" action="index.php">
               
                <div class="form-group">
                    <input name ="usuario" type="text" class="form-control" placeholder="Usuario" required="">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Acceder</button>
                <!--<a href="registro.php"><h2>Registrarse</h2></a>-->
                
            </form>

            <?php
              if(!empty($_POST)){
                if( $usuario->loadForLogin($_POST['usuario'], $_POST['password']) )
                {
                  $_SESSION['id_usuario'] = $usuario->getId() ;
                  $_SESSION['nombre'] = $usuario->getNombre() ;
                  $_SESSION['usuario'] = $usuario->getLogin() ;
                  $_SESSION['tipo_usuario'] = $usuario->getTipoUsuario() ;
                ?>
                  <script type="text/javascript">
                  window.location = 'intro.php';
                  </script>
                <?php }
                else{
                  ?>
                  <script type="text/javascript">
                  alert("Usuario o Contraseña incorrecto");
                  window.location = 'index.php';
                  </script>
                  <?php
                }
              }
              ?>
            <p class="m-t"> <small>Servicios Marinos Y Terrestres S.A. de C.V. &copy; 2016-2017</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
    
    
</body>

</html>
