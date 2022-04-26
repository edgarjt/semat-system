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
                            <table class="footable table table-striped"  data-page-size="8" data-filter=#filter id="myTable">
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
                                              <td>
                                              		<img border="0" alt="Calibracion de equipos" src="../img/GRAFICA.png" width="23" height="23" onclick="graficarradar(<?php echo $value['id_linea'];?>);">
                                              </td>
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
                    <div class="ibox-content">
                            <div class="table-responsive">
                            <table class="footable table table-striped"  id="myTable2">
                                <thead>
                                <tr>
                                    <th><center>ESPESOR MAXIMO.</center></th>
                                    <th><center><P id="espmaximo">?</P></center></th>
                                    <th><center>ESPESOR MINIMO</center></th>
                                    <th><center><P id="espminimo">?</P></center></th>
                                </tr>
                                </thead>
                                <tbody>
                                     
                                </tbody>
                            </table>   

                        </div>
                        <div id="chartdiv" style="width:100%; height: 500px;"></div>
                        <!--   -->
                        <div class="btn-group">
                        
                        <div>
                      </div>
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
                            <h5>Grafica de indicaciones por linea</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
                                <div id="chartdiv3" style="width:100%; height:500px;"></div>
                        <div class="btn-group">
                        
                        <div>
                      </div>
                    </div>
                </div>
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

                       function graficarintegridad(id){
                       		$("#myModal").modal();
                       }

                      

                       function graficarradar(id){
                       	var limite = 0;
                       	

                        $.getJSON('extraeEspesores.php?id_linea='+id,function (espesor)
                              {
                                   document.getElementById('espminimo').innerText = espesor[0]['minimo'];
                                   document.getElementById('espmaximo').innerText = espesor[0]['maximo'];
                                   limite =  espesor[0]['maximo']-0.1;
                                   limite2 =  espesor[0]['maximo'];
                                  
                              
                         $.getJSON('extraeIndicacionLinea.php?id_linea='+id+'&tipo_inspeccion=VT',function (puntos)
                              {   
                              	//seriex =[[95.5,0.088],[5,0.047],[6,0.05],[8,0.087]];
                              	serie1x=[];
                                serie2x=[];
                                serie3x=[];
                              	serie1y=[];
                                serie2y=[];
                                serie3y=[];
                              	for (var i = 0 ; i < puntos.length; i++) {
                              		if ([puntos[i].tipo_inspeccion]=='VT') {

                                    if ([puntos[i].porcentaje_perdida]>=80) {
                                  			hora = parseFloat([puntos[i].horario]);
                                  			prof = parseFloat(puntos[i].espesor_remanente);
                                  			serie1x.push([hora,prof]);
                                    }

                                    if (([puntos[i].porcentaje_perdida]>=31) && ([puntos[i].porcentaje_perdida]<=79)) {
                                        hora = parseFloat([puntos[i].horario]);
                                        prof = parseFloat(puntos[i].espesor_remanente);
                                        serie2x.push([hora,prof]);
                                    }

                                     if ([puntos[i].porcentaje_perdida]<=30) {
                                        hora = parseFloat([puntos[i].horario]);
                                        prof = parseFloat(puntos[i].espesor_remanente);
                                        serie3x.push([hora,prof]);
                                    }

                              		} else {

                                     if ([puntos[i].porcentaje_perdida]>=80) {
                                  			hora = parseFloat([puntos[i].horario]);
                                  			prof = parseFloat(puntos[i].profundidad);
                                  			serie1y.push([hora,prof]);
                                      }

                                      if (([puntos[i].porcentaje_perdida]>=31) && ([puntos[i].porcentaje_perdida]<=79)) {
                                        hora = parseFloat([puntos[i].horario]);
                                        prof = parseFloat(puntos[i].profundidad);
                                        serie2y.push([hora,prof]);
                                      }

                                      if ([puntos[i].porcentaje_perdida]<=30) {
                                        hora = parseFloat([puntos[i].horario]);
                                        prof = parseFloat(puntos[i].profundidad);
                                        serie3y.push([hora,prof]);
                                      }
                              		}
                              	}
                              	//console.log(seriex);
                                var chart = AmCharts.makeChart("chartdiv", {
                                                  type: "radar",
                                                  dataProvider: puntos,
                                                  theme: "light",
                                                  //radius: document.getElementById('pgrafica1').value,
                                                  colors: ["#088A08","#2E64FE","#8258FA","#FF4000","#BF00FF","#000000"],
                                                  startDuration:1,
                                                  color: "#FFFFFg",
                                                   polarScatter: {
                        												   minimum: 0,
                        												   maximum: 359,
                        												   step: 0.5
                        												  },


                                                  valueAxes: [{
                                                      axisAlpha: 0.0,
                                                      gridType: "circles",
                                                      minimum: 0,
                                                      dashLength: 3,
                                                      axisTitleOffset: 40,
                                                      minimum: -0.1,
                                                      axisTitleOffset: 1,
                                                      gridCount: 10
                                                  }],

                                                  balloon: {
                                                    disableMouseEvents: false,
                                                    fadeOutDuration: 2
                                                  },

                                                  legend: {
                                                    position: "right"
                                                  },

                                                  graphs: [{
                                                      title: "Corrosiones Externas (con perdida mayor al 80%)",
                                                      balloonText: "Espesor Remanente: [[value]]",
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie1x
                                                  },{
                                                  title: "Corrosiones Externas (con perdida 30% al 80%)",
                                                      balloonText: "Espesor Remanente: [[value]]",
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie2x
                                                  },{
                                                  title: "Corrosiones Externas (con perdida hasta el 30%)",
                                                      balloonText: 'Espesor Remanente: [[value]]',
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie3x
                                                  },
                                                  {
                                                      title: "Corrosiones Internas (con perdida mayor al 80%)",
                                                      balloonText: "Profundidad: [[value]]",
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie1y
                                                  },
                                                  {
                                                      title: "Corrosiones Internas (con perdida 30% al 80%)",
                                                      balloonText: "Profundidad: [[value]]",
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie2y
                                                  },
                                                  {
                                                      title: "Corrosiones Internas (con perdida hasta el 30%)",
                                                      balloonText: "Profundidad: [[value]]",
                                                      bullet: "round",
                                                      lineAlpha: 0,
                                                      series: serie3y
                                                  }]

                                                  ,

                                                 guides: [{
                                                      angle:0,
                                                      tickLength:0,
                                                      toAngle:360,
                                                      value:0,
                                                      toValue:-0.1,
                                                      fillColor:"#FF0000",
                                                      fillAlpha:0.3
                                                  }],
                                  "export": {
                                    "enabled": true,
                                    "libs": {
                                      "autoLoad": false
                                    }
                                  }

                                  });
                                  
                              });
                         //----------------------------------------------------------grafica de indicaciones internas----------------------------------
                        
                         });

                         //---------------------------------------fin de indicaciones internas----------------------------------------------------------

                         //---------------------------------------------------grafica de barras----------------------------------------------------------
                          $.getJSON('extraeIndicacionBarra.php?id_linea='+id,function (puntos)
                              {   
                          var chart = AmCharts.makeChart("chartdiv3", {
                                                  type: "serial",
                                                  dataProvider: puntos,
                                                  theme: "light",
                                                  categoryField: "simbologia",
                                                  startDuration:2,


                                                  valueAxes: [{
                                                      title: "Numero de indicaciones"
                                                  }],


                                                  categoryAxis:{
                                                      autoRotateAngle:90
                                                  },

                                                  graphs: [{
                                                      fillAlphas: 1,
                                                      id: "AmGraph-1",
                                                      title:  "graph 1",
                                                      type: "column",
                                                      valueField: "totind",
                                                      balloonText: "<b>[[descripcion]]</b></br><b>[[value]]</b>",
                                                  }],

                                                  guides: [],
                                  "export": {
                                    "enabled": true,
                                    "libs": {
                                      "autoLoad": false
                                    }
                                  }

                                  });
                                });
                         //------------------------------------------------------fin de grafica de barras--------------------------------------------------
                       }

                       //----------------Graficas de pastel----------------------------------

                     
                      //------------------------------fin de segunda grafica-----------------
                //----------------------------------------fin parte new---------------------------------
        </script>
<?php
 }
 }//if(isset($_SESSION['id_usuario'])) {
?>


