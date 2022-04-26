<?php
session_start();
if(!empty($_SESSION)){
if(isset($_SESSION['id_usuario']) ){
include_once("../library/Componente_P1V2.php");
include_once("../library/Contrato.php");
include_once("../Library/Linea.php");

$contrato        = new Contrato();
$linea           = new Linea();

$lineas = $linea->getAll();

            if (!empty($_POST)) {
                    $lineas = $linea->getLineaSubdireccion($_POST['subdireccion']);       
              }
?>

<style>
#chartdiv1 {
  width   : 100%;
  height    :100%;
  font-size : 11px;
}         
</style>

        <div class="wrapper wrapper-content">   
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Consultas</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                          <form method="post" >         
                            <div class="row">
                                    <div class="col-lg-12">
                                    <div class="ibox-content">
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><label class="col-sm-2 control-label">Subdireccion:</label>
                                            <div ><SELECT id="subdireccion" NAME="subdireccion" SIZE=1 class="form-control">
                                                    <OPTION VALUE="0" >Seleccionar una sub-direccion</OPTION>
                                                    <?php
                                                        foreach ($contrato->subdirecciones as $value) {
                                                            ?>
                                                            <option value="<?php echo $value; ?>"><?php echo $value ; ?></option>
                                                            <?php
                                                        }
                                                   ?>
                                                    </SELECT> </div>
                                        </div>
                                    </div>

                                     <div class="col-md-4">
                                            <div ><button class="btn btn-primary" type="submit">Consultar</button></div>
                                    </div> 

                                  </div> 
                                  </div>
                                  </div>
                            </div>
                        </div>
                      </form>
                </div>
            </div>
            </div>
            </div>

         <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Lineas Intervenidas</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
                            <div class="table-responsive">
                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                           placeholder="Buscar linea">
                            <table class="footable table table-striped"  data-page-size="20" data-filter=#filter id="myTable">
                                <thead>
                                <tr>
                                    <th><center>No.</center></th>
                                    <th><center>ID LINEA.</center></th>
                                    <th><center>LINEA</center></th>
                                    <th><center>DENOMINACION TECNICA</center></th>
                                    <th><center>UBICACION TECNICA</center></th>
                                    <th><center>TIPO DE PRODUCTO</center></th>
                                    <th><center>DIAMETRO NOMINAL</center></th>
                                    <th><center>DIAMETRO EXTERIOR</center></th>
                                    <th><center>ACCIONES</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php 
                                          $c=1;
                                          foreach ($lineas as $value) {
                                      ?>
                                          <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                                              <td><?php echo $c; ?></td>
                                              <td><?php echo $value['id_linea']; ?></td>
                                              <td><?php echo $value['nombre']; ?></td>
                                              <td><center><?php echo $value['denominacion_tecnica']; ?></center></td>
                                              <td><center><?php echo $value['ubicacion_tecnica']; ?></center></td>
                                              <td><center><?php echo $value['tipo_producto']; ?></center></td>
                                              <td><center><?php echo $value['diametro_nominal']; ?></center></td>
                                              <td><center><?php echo $value['diametro_exterior']; ?></center></td>
                                              <td><img border="0" alt="Calibracion de equipos" src="../img/GRAFICA.png" width="42" height="23" onclick="graficarradar(<?php echo $value['id_linea'];?>);"></td>
                                          </tr>
                                      <?php
                                          $c++;
                                          }
                                      ?>                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="20">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>   
                        </div>
                        <!--   -->
                        <div class="btn-group">
                        
                        <div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </div>




        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                    <h5>Estadistica de indicaciones externas e internas</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                          <div class="col-lg-12">
                          <div class="ibox float-e-margins">
                              <div class="ibox-content">
                                  <strong>Grafica de</strong>
                                  <div id="chartdiv" style="width:100%; height: 700px;"></div>
                        
                              </div>
                          </div>
                      </div>

                     <!-- <div class="col-lg-6">
                          <div class="ibox float-e-margins">
                              <div class="ibox-content">
                                  <strong>grafica de</strong>
                                  <div id="chartdiv" style="width:600px; height:400px;"></div>
                        
                              </div>
                          </div>
                      </div>-->

          </div>
         </div>
        </div>

      
        
<?php 
include_once("../library/Componente_P2V2.php");
 
?>
   
  
    <script src="../js/graficas/amcharts/amcharts.js"></script>
    <script src="../js/graficas/amcharts/radar.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"></script>
    <script src="../js/graficas/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="../js/graficas/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="../js/graficas/amcharts/themes/light.js"></script>
    <script type="text/javascript">
       
                //---------------------------------------parte new-------------------------------

                       function cambiacolor_over(celda){ celda.style.backgroundColor="#F5BCA9" } 
                       function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }

                       function graficarradar(id){
                         $.getJSON('extraeIndicacionLinea.php?id_linea='+id+'&tipo_inspeccion=UT',function (puntos)
                              {     
                                 var chart = AmCharts.makeChart("chartdiv", {
                                                  type: "radar",
                                                  dataProvider: puntos,
                                                  theme: "light",

                                                  categoryField: "horario",
                                                  startDuration:2,


                                                  valueAxes: [{
                                                      axisAlpha: 0.15,
                                                      gridType: "circles",
                                                      minimum: 0,
                                                      dashLength: 3,
                                                      axisTitleOffset: 20,
                                                      gridCount: 5
                                                  }],

                                                 

                                                  legend: {
                                                    position: "right"
                                                  },

                                                  graphs: [{
                                                      title: "CI",
                                                      lineAlpha: 0,
                                                      valueField: "profundidad",
                                                      bullet: "round",
                                                      balloonText: "[[value]] ''"
                                                  }],
                                  "export": {
                                    "enabled": true,
                                    "libs": {
                                      "autoLoad": false
                                    }
                                  }

                                  });
                                  
                              });
                       }

                      
                       //----------------Graficas de pastel----------------------------------
/*
                        var chartData = <?php echo json_encode($indexternas); ?> 
                        var chart = AmCharts.makeChart( "chartdiv1", {
                        "type": "pie",
                        "theme": "light",
                        "dataProvider":chartData ,
                        "valueField": "cantidad",
                        "titleField": "simbologia",
                        "outlineAlpha": 0.4,
                        "depth3D": 18,
                        "balloonText": "[[descripcion]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                        "angle": 30,
                        "export": {
                          "enabled": true
                        }
                      } );
                       //-------------------fin de grafica de pastel-------------------------

                       //-----------------------------segunda grafica-------------------------
                       var chartData2 = <?php echo json_encode($indinternas); ?> 
                        var chart = AmCharts.makeChart( "chartdiv2", {
                        "type": "pie",
                        "theme": "light",
                        "dataProvider":chartData2 ,
                        "valueField": "cantidad",
                        "titleField": "simbologia",
                        "outlineAlpha": 0.4,
                        "depth3D": 18,
                        "balloonText": "[[descripcion]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                        "angle": 30,
                        "export": {
                          "enabled": true
                        }
                      } ); */
                     
                       //------------------------------fin de segunda grafica-----------------
                //----------------------------------------fin parte new---------------------------------
        </script>
<?php
 }
 }//if(isset($_SESSION['id_usuario'])) {
?>


