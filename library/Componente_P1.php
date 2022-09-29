<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?php 
        //header('content-type: application/json; charset=utf-8');
         header("access-control-allow-origin: *"); 
         ?>

    <title>SEMAT</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="css/plugins/dropzone/dropzone.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" width="125" height="65"  src="img/logo2.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION["tipo_usuario"]; ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $_SESSION["nombre"]; ?> <b class="caret"></b></span> </span> </a>   
                    </div>
                    <div class="logo-element">
                       SMT
                    </div>
                </li>
                <?php if ($_SESSION['tipo_usuario'] == "ADMINISTRADOR" or $_SESSION['tipo_usuario'] == "CAPTURA" or $_SESSION['tipo_usuario'] == "GERENCIA") { ?>
                <li>
                    <a href="#"><i class="fa fa-signal"></i> <span class="nav-label">Consultas</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="consulta/resumen.php">Puntos Intervenidos</a></li>      
                        <li><a href="consulta/estadistica.php">Estadisticas Generales</a></li>   
                        <li><a href="consulta/video.php">Videos</a></li>                   
                    </ul>
                </li>
                <?php  } ?>

               
               
        </div>
    </nav>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Control de avances" class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">SMT</span>
                </li>

                <li>
                    <a href="logouth.php">
                        <i class="fa fa-sign-out"></i> Login
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>
        </nav>
        </div>