
<?php
session_start() ;
if(isset($_SESSION['id_usuario']) ){
include_once("library/Componente_P1.php");
?>
 <div>

            <br>
            <div class="ibox-content">
                 <div class="row">
                     <div class="col-lg-6">
                        <center>
                            <img src="img/SEMAT_72.png" height="222" width="333" >
                        </center>
                    </div>
                     <div class="col-lg-6">
                        <center>
                           <img src="img/PEMEX.png" height="222" width="333" >
                        </center>
                    </div>
                </div>
                <div class="row">
                         <br /><br /><br />
                         <center>
                                <p class="lead"><strong>CONTROL DE AVANCE DE OBRAS</strong></p>
                         </center>
     
                </div>
                <div class="row">
                    <div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
                        <li data-target="#inSlider" data-slide-to="1"></li>
                        <li data-target="#inSlider" data-slide-to="2"></li>
                        <li data-target="#inSlider" data-slide-to="3"></li>
                        <li data-target="#inSlider" data-slide-to="4"></li>
                        <li data-target="#inSlider" data-slide-to="5"></li>
                        <li data-target="#inSlider" data-slide-to="6"></li>
                        <li data-target="#inSlider" data-slide-to="7"></li>
                        <li data-target="#inSlider" data-slide-to="8"></li>
                        <li data-target="#inSlider" data-slide-to="9"></li>
                        <li data-target="#inSlider" data-slide-to="10"></li>
                        <li data-target="#inSlider" data-slide-to="11"></li>
                        <li data-target="#inSlider" data-slide-to="12"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="container">
                                <img src="img/carrusel/foto1.png" height="350" width="1200">
                            </div>
                            <!-- Set background for slide in css -->
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto2.png" height="350" width="1200">
                            </div>
                        </div>
                         <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto3.png" height="350" width="1200" >
                            </div>
                        </div>
                         <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto4.png" height="350" width="1200" >
                            </div>
                        </div>
                         <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto5.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto6.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto7.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto8.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto9.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto10.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto11.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto12.png" height="350" width="1200">
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <img src="img/carrusel/foto13.png" height="350" width="1200">
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                </div>

            </div>
          
            

        <!--<p><a href="http://www.asp.net" class="btn btn-primary btn-lg">Learn more &raquo;</a></p>-->
    </div>
<?php
include_once("library/Componente_P2.php");
}//if(isset($_SESSION['id_usuario'])) {
?>
