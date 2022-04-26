<?php
session_start();
if(!empty($_SESSION)){
//if( $_SESSION['perfil'] == "Administrador" or $_SESSION['perfil'] == "Capturista" or $_SESSION['perfil'] == "Presentador"){
include_once("../library/Componente_P1V2.php");


?>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">



             

         <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>DRONE - REPARACIÓN DEFINITIVA DE ABOLLADURA EN RIO COCODRILOS</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
 												<iframe width="560" height="315" src="https://www.youtube.com/embed/GklxXlXmlf8?rel=0&modestbranding=1&cc_load_policy=1&showinfo=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


                        
                			</div>
           			 </div>
         		 </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>RENDER - REPARACIÓN DEFINITIVA DE ABOLLADURA EN RIO COCODRILOS</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/i2zYo_wvjcI?rel=0&modestbranding=1&cc_load_policy=1&showinfo=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                                
                        
                            </div>
                     </div>
                 </div>
        </div>

    


  
<?php 
include_once("../library/Componente_P2V2.php");
// }
 }//if(isset($_SESSION['id_usuario'])) {
?>
