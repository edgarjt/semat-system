<?php
session_start();
if(!empty($_SESSION)){
if(isset($_SESSION['id_usuario']) && ($_SESSION['tipo_usuario'] == 'ADMINISTRADOR' || $_SESSION['tipo_usuario'] == 'CAPTURA' || $_SESSION['tipo_usuario'] == 'GERENCIA' ) )
{
      include_once("../library/Componente_P1V3.php");
      include_once '../library/Indicacion.php';
      include_once '../library/TipoIndicacion.php';
      include_once '../library/Programa.php';
      include_once("../library/IndicacionFoto.php");
      include_once("../library/Consulta.php");
      include_once("../library/Avance.php");
      include_once("../library/Foto.php");
      include_once("../library/Linea.php");
      $linea           = new Linea();
      $foto            = new Foto();
      $avance          = new Avance();
      $consulta        = new Consulta();
      $indicacion    = new Indicacion();
      $tipo_indicacion = new TipoIndicacion();
      $programa      = new Programa();
      $indicacion_foto = new IndicacionFoto();
      $id_programa   = $_GET['id_programa'];
      $idlinea       = $_GET['linea'];
      $programa->loadById($id_programa);
      $linea->loadById($idlinea);
      $titulo      =$linea->getNombre(). " KM ".$programa->getKmInicial()." al km ".$programa->getKmFinal();
      ?>
 <div>  
         <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $titulo; ?></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                            <div class="ibox-content">
                            <!--- inicio -->
                            <div class="div_tabla"> 
                                <?php
                                    if(!isset($_GET['bge']))
                                    {
                                        ?>
                                        <a href="avance_linea_detalles.php?id_linea=<?php echo $_GET['id_linea']?>&contrato=-1&subdireccion=<?php echo $_GET['subdireccion']; ?>&tipo_trabajo=-1">Volver</a>                          
                                        <?php
                                    }
                                ?>
                                              
                              <div id="tabs">
                                <ul>
                                  <li><a href="#tabs-3">Registro de Indicaciones</a></li>
                                  <li><a href="#tabs-2">Registro Fotográfico Indicaciones</a></li>
                                  <li><a href="#tabs-1">Registro Fotográfico Obra</a></li>
                                </ul>
                                <div id="tabs-1">
                                          <div>
                                              <p> Avances </p>
                                              <div class="wrapper">
                                                          <div class="indicaciones">
                                                              <ul>
                                                              <?php
                                                              foreach ($avance->getByPrograma($_GET['id_programa']) as $avan)
                                                              {                                    
                                                                 foreach ($foto->getByAvance($avan['id_avance']) as $key) 
                                                                 {
                                                                   echo "<li><img src='../../avance_contrato/captura/files/".$key['archivo']."'/></li>";
                                                                 }

                                                              }
                                                              ?>  
                                                              </ul>
                                                          </div> 
                                                  </div>
                                          </div>
                                </div>
                                <div id="tabs-2">
                                            <div>
                                              <p> Indicaciones</p>
                                              <div class="wrapper">
                                                          <div class="indicaciones">

                                                              <ul>
                                                              <?php
                                                              foreach ($indicacion->getAllPrograma($_GET['id_programa']) as $resultado)
                                                              {

                                                                 foreach ($indicacion_foto->getAllByIdIndicacion($resultado['id_indicacion']) as $key) 
                                                                 {
                                                                      echo "

                                                                      <li>
                                                                      <img src='../../avance_contrato/evaluacion/ind_fotos/".$key['archivo']."'/>
                                                                      </li>

                                                                      ";
                                                                      
                                                                 } 
                                                              }
                                                              ?>  
                                                              </ul>
                                                          </div> 
                                                  </div>
                                          </div>
                                </div>
                                <div id="tabs-3">
                                    <div class="d_simbologia" >
                                          <table class="simbologia">
                                              <tr>
                                                  <td class="ind_amarillo"></td>
                                                  <td class="ind_texto">INDICACIÓN > 10% Y ≤ 30%</td>
                                                  <td class="ind_naranja"></td>
                                                  <td class="ind_texto">INDICACIÓN > 30% Y ≤ 80%</td>
                                                  <td class="ind_rojo"></td>
                                                  <td class="ind_texto">INDICACIÓN > 80%</td>
                                              </tr>
                                          </table>
                                      </div>
                                    <br>
                                  <div class="div_tabla">        
                                                  <table class="footable table table-striped"  data-page-size="10" data-filter=#filter id="myTable">
                                                    <thead>
                                                      <tr>
                                                          <th class="observacion">ELEMENTO</th>
                                                          <th class="observacion">No.</th>
                                                          <th class="observacion">SOLD. REF.</th>
                                                          <th class="observacion">DISTANCIA SOLD.</th>
                                                          <th class="observacion">HORARIO TEC.</th>
                                                          <th class="observacion">INDICACION</th>
                                                          <th class="observacion">LARGO</th>
                                                          <th class="observacion">ANCHO</th>
                                                          <th class="observacion">PROFUNDIDAD</th>
                                                          <th class="observacion">ESPESOR MIN.</th>
                                                          <th class="observacion">ESPESOR MAX.</th>
                                                          <th class="observacion">ESPESOR REM.</th>
                                                          <th class="observacion">% PERDIDA</th>
                                                      </tr>
                                                  </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($indicacion->getAllPrograma($_GET['id_programa']) as $resultado)
                                                    {
                                                    ?>
                                                  <tr class="row_par" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                                                      <!--  <td class="centrado"> <?php //echo $resultado['id_indicacion']; ?> </td> -->
                                                      <td><center> <?php echo $resultado['elemento']; ?> </center></td>  
                                                      <td><center> <?php echo $resultado['no_indicacion']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['sold_pos_referencia']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['distancia_sold_referencia']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['horario_tecnico']; ?> </center></td>
                                                      <td><center>
                                                          <?php 
                                                          $tipo_indicacion->loadById($resultado['id_tipo_indicacion']);
                                                          $aaa = $tipo_indicacion->getSimbologia();
                                                          if ($aaa == 'CE' or $aaa=='CI') {
                                                            ?>
                                                                <p onclick ="graficarintegridad(<?php echo $resultado['id_indicacion'].','.$idlinea;?>);"><?php echo $tipo_indicacion->getSimbologia();?></p>
                                                            <?php
                                                          } else {
                                                                 echo $tipo_indicacion->getSimbologia();
                                                          }
                                                          
                                                          ?> </center>
                                                      </td> 
                                                      <td><center> <?php echo $resultado['largo']; ?></center></td>
                                                      <td><center> <?php echo $resultado['ancho']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['profundidad']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['espesor_minimo_zona_sana']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['espesor_maximo_zona_sana']; ?> </center></td>
                                                      <td><center> <?php echo $resultado['espesor_remanente']; ?> </center></td>
                                                      <?php 
                                                          if (round($resultado['porcentaje_perdida'],2)       > 10 && round($resultado['porcentaje_perdida'],2) < 30 )
                                                          {
                                                              $bgcolor = "yellow";
                                                          }elseif(round($resultado['porcentaje_perdida'],2)   > 30 && round($resultado['porcentaje_perdida'],2) < 80)
                                                          {
                                                              $bgcolor = "orange";
                                                          }elseif(round($resultado['porcentaje_perdida'],2)   > 80 && round($resultado['porcentaje_perdida'],2) <= 100)
                                                          {
                                                              $bgcolor = "red";
                                                          }else{
                                                              $bgcolor = "#FFFFFF";
                                                          }
                                                          $arrayFotos = array();
                                                          foreach ($indicacion_foto->getAllByIdIndicacion($resultado['id_indicacion']) as $key)
                                                          {
                                                             $arrayFotos=$key['id_indicacion_foto'];
                                                          }
                                                      ?>

                                                      <td bgcolor="<?php echo $bgcolor; ?>"><center>
                                                          <a href="#" id="open" onclick="abrir(<?php echo $resultado['id_indicacion']; ?>,<?php echo round($resultado['porcentaje_perdida'],2); ?>,'<?php echo $aaa; ?>')" >
                                                              <?php echo round($resultado['porcentaje_perdida'],2); ?>% 
                                                          </a></center>
                                                      </td>
                                                  </tr>
                                              <?php 
                                              }
                                              ?>
                                              </tbody>
                                              <tfoot>
                                                  <tr>
                                                      <td colspan="13">
                                                          <ul class="pagination pull-right"></ul>
                                                      </td>
                                                  </tr>
                                              </tfoot>
                                              </table>
                                              </div>

                                              </div> <!-- tab 3 -->
                                              </div><!--div tabs -->
                                              </div><!-- div tabla -->
                            <!-- fin -->
                        <!--   -->
                
                      </div>
                    </div>
                </div>
            </div>
</div>




          <!-- modal -->
            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-camera modal-icon"></i>
                                            <h4 class="modal-title">Fotografias</h4>
                                           
                                        </div>
                                        <div class="modal-body">
                                                <form id="form" >
                                                    <div class="form-group">
                                                          <div class="row">
                                                            <div class="col-lg-10 col-lg-offset-1">
                                                                <div class="ibox">
                                                                    <table id="myTable12" class="table table-stripped" data-page-size="38" >
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                                                    </div>
                                             </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal" >Cerrar</button>
                                           
                                        </div>
                                    </div>
                                </div>
              </div>
            <!-- fin modal -->

             <!-- modal -->
            <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-sitemap modal-icon"></i>
                                            <h4 class="modal-title">Grafica de integridad</h4>
                                        </div>
                                        <div class="modal-body">
                                                <form id="form" >
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Diametro:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="diametro" name="diametro"></div>
                                                                    </div>
                                                           
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Esp. Max.:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="espesor" name="espesor"></div>
                                                                    </div>
                                                            </div>

                                                             <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">SMYS (PSI):</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="smys" name="smys" required></div>
                                                                    </div>
                                                           
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Presion (Kg/cm²):</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="presion" name="presion"></div>
                                                                    </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Fecha Op.:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="fechaoperacion" name="fechaoperacion" required></div>
                                                                    </div>

                                                                    <div class="form-group"><label class="col-sm-6 control-label">FCP:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="fcp" name="fcp" required></div>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">F. Insp.:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="fechainspeccion" name="fechainspeccion"></div>
                                                                    </div>
                                                           
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Años Pro.:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="anosproyeccion" name="anosproyeccion" value="5"></div>
                                                                    </div>
                                                            </div>

                                                             <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Long. Tramo:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="logitudtramo" name="logitudtramo" value="12"></div>
                                                                    </div>
                                                           
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Long. Grafica:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="longitudaxialgrafica" name="longitudaxialgrafica" value="420"></div>
                                                                    </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Fecha Actual:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="fechaactual" name="fechaactual" value="<?php echo date("Y-m-d")?>"></div>
                                                                    </div>
                                                           
                                                                    <div class="form-group"><label class="col-sm-6 control-label">Años de Operacion:</label>
                                                                        <div class="col-sm-6"><input type="text"  class="form-control" id="anooperacion" name="anooperacion" value="420"></div>
                                                                    </div>
                                                            </div>
                                                            <input  type="hidden"  class="form-control" id="profundidad" name="profundidad">
                                                            <input  type="hidden"  class="form-control" id="longitud" name="longitud">
                                                            <button type="button" class="btn btn-white" data-dismiss="modal" >Cerrar</button>
                                                            <button type="button"  class="btn btn-primary" onclick="graficardatos()" >Graficar</button>
                                                            </div>

                                                    </div>
                                                    
                                                    <div class="ibox-content">
                                                          <strong>Indicaciones externas</strong>
                                                          <div id="container" style="width: 100%; height: 600px; margin: 0 auto"></div>
                                                    </div>
                                             </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
              </div>
            <!-- fin modal -->  

        
<?php 
include_once("../library/Componente_P2V2.php");
 
?>
    <style type="text/css">
    .d_simbologia{
        clear: both;
        padding-right: 45px;
    }

    .simbologia{
        font-size: 10px;
        float: right;
    }

    .simbologia tr .ind_amarillo{
        width: 20px;
        background-color:  #FFFF00 ;
        border: 1px solid #0000FF ;
    }
    .simbologia tr .ind_naranja{
        width: 20px;
        background-color:  #FF9900 ;
        border: 1px solid #0000FF ;
    }

    .simbologia tr .ind_rojo{
        width: 20px;
        background-color:  #FF0000 ;
        border: 1px solid #0000FF ;
    }

    .ind_texto{
        color:#000000;
        font-style: strong;
    }

    
    .wrapper{
    margin:auto;
    width:80%;
    }
    
    .indicaciones{
    border:2px solid #000;
    }
    </style>
    <script type="text/javascript" src="js/tik/tiksluscarousel.js"></script>
    <link rel="stylesheet" href="css/tik/tiksluscarousel.css" />

    <script src="../js/highcharts/highcharts.js"></script>
    <script src="../js/highcharts/modules/exporting.js"></script>

    <script src="../js/moment.min.js"></script>
    <script type="text/javascript">
                  function cambiacolor_over(celda){ celda.style.backgroundColor="#F5BCA9" } 
                  function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }

                  function graficardatos(){
                    var diametro ;
                    var espesor ;
                    var especificacion ;
                    var smys ;
                    var presion ;
                    var profundidad ;
                    var longitud ;
                    var anios ;
                    var anios_operacion ;
                    var factor ;
                    var presion_falla ;
                    var pprima ;
                    var presion_kg ;
                    var m ;
                    var nombre_completo = '---';

                    diametro = parseFloat(document.getElementById("diametro").value) ;
                    espesor = parseFloat(document.getElementById("espesor").value );
                    especificacion = parseFloat(document.getElementById("smys").value );
                    smys = parseFloat(document.getElementById("smys").value );
                    presion = parseFloat(document.getElementById("presion").value );
                    profundidad = parseFloat(document.getElementById("profundidad").value );
                    longitud = parseFloat(document.getElementById("longitud").value );
                    anios = parseFloat(document.getElementById("anosproyeccion").value );
                    anios_operacion = parseFloat(document.getElementById("anooperacion").value );
                    factor = parseFloat(document.getElementById("fcp").value );

                        if( (presion * 14.22) > (2*espesor*smys * factor) / diametro  ) {
                            alert ("Presión de operacion es mayor que presion de diseño")
                        }
                        else{

                    var perdida ;
                    var largo_maximo = 472.44 ;
                    var pprima_nueva ;
                    var largos = new Array(70);
                    var perdidas = new Array(70);
                    var perdida_permitida = new Array(70);
                    var contador = 0 ;


                    for (var i = 10; i <= 80; i++ ) {
                        var resultado = largo_maximo ;
                        perdida = i/100 ;
                        profundidad = perdida * espesor ;
                            var largo2 = largo_maximo;
                            var encontrado = 0 ;
                            while(largo2 > 0 && encontrado != 1 ){
                            
                            if (Math.pow(largo2,2) /  (diametro * espesor) > 20 ) {
                                m = 3.3 + 0.032 * Math.pow( (largo2 /  Math.sqrt( diametro * espesor ) ) , 2 ) ;
                                var p1 = 1 - 0.85 * ( profundidad / espesor ) ;
                                var p2 = 1 - 0.85 * ( (profundidad / espesor) * (1/m) ) ;
                                var p3 = ( 2 * (smys+10000) * espesor ) / diametro ;
                                presion_falla = p3 * ( p1 / p2 ) ;
                                presion_kg = presion_falla / 14.223 ;
                                pprima = presion_falla * factor ;
                            }
                            else{
                                m = Math.sqrt(1+ ( Math.pow(0.893,2) *(Math.pow(largo2,2) /(diametro*espesor) ) ) ) ;
                                var p1 = 1 - ( (2*profundidad) / (3*espesor) ) ;
                                var p2 = 1-( ( (2*profundidad) / (3*espesor) ) * (1/m) ) ;
                                var p3 = (2 * espesor * smys ) / diametro ;
                                presion_falla = 1.1 * p3 * (p1 / p2) ;
                                presion_kg = presion_falla / 14.223 ;
                                pprima = presion_falla * factor ;
                            }

                            if (pprima >= ( presion * 14.22) ) {
                                if (largo2 < largo_maximo) {
                                    resultado = largo2
                                }
                                else{
                                    resultado = largo_maximo ;
                                }
                                encontrado = 1 ;
                            }
                            largo2 = largo2-0.1 ;

                        }
                        resultado = parseInt(resultado*1000) ;
                        resultado = parseFloat(resultado/1000) ;
                        largos[contador] =  resultado ;
                        perdidas[contador] = i ;
                        perdida_permitida[contador] = perdidas[contador]*0.75 ;
                        contador++ ;
                        
                    }
                    largos[contador] = 0 ;
                    perdidas[contador] = 80;
                    perdida_permitida[contador]=80*0.75 ;

                    var largos_final = new Array(71) ;
                    var perdidas_final = new Array(71) ;
                    var p_permitida_final = new Array(71) ;
                    var proyeccion = new Array(71) ;
                    var pf = parseFloat(document.getElementById("profundidad").value );
                    var vcrd = pf / anios_operacion ;
                    var d_proyectada =  ( (pf + (vcrd * anios) ) / espesor) *100 ;
                    var longit = longitud / anios_operacion ;
                    var long_proyectada =  longitud + (longit * anios) ;

                    var cont = 0 ;
                    var puntos = new Array(71) ;
                    var p1 = ( parseFloat(document.getElementById("profundidad").value ) / espesor) * 100 ;
                   

                    for (var i = 71; i >= 0; i-- ) {
                        largos_final[cont] = largos[i] ;
                        perdidas_final[cont] = new Array( largos[i], perdidas[i]) ;
                        p_permitida_final[cont] = new Array( largos[i], perdida_permitida[i])  ;
                        puntos[cont] = new Array(longitud, p1) ;
                        proyeccion[cont] = new Array(long_proyectada, d_proyectada) ;
                       /* punto3[cont] = new Array(longitud2, p5) ;
                        punto4[cont] =  new Array(longitud_proyectada2, profundidad_proyectada) ;*/
                        cont++;
                    }

                }

                //var ex = 

                $('#container').highcharts({
                    chart: {
                        type: 'areaspline'
                    },
                    title: {
                        text: 'Gráfica de Análisis de Integridad'
                    },
                    subtitle: {
                        text: nombre_completo
                    },
                     credits: {
                              text: 'SEMAT',
                             // href: 'http://www.boock.ch/meteo-villarzel.php'
                            },
                    xAxis: {
                        max: document.getElementById("longitudaxialgrafica").value,
                        title:{
                           text: "Longitud Axial de la Indicación (Pulg.)"
                        },
                        minorGridLineColor: "#00000"
                    },
                    yAxis: {
                       max:100,
                       title:{
                           text: "Profundidad de la Indicación (d/t) % "
                        },
                        plotLines: [{
                          value:0,
                          width: 5,
                          color: '#808080'
                      }]
                    },

                    tooltip: {
                        pointFormat: 'Porcentaje de Pérdida : <b>{point.y:,.0f}</b><br/>Longitud {point.x}'
                    },
                    plotOptions: {
                        area: {
                            pointStart: 0,
                            marker: {
                                enabled: true,
                                symbol: 'circle',
                                radius: 5,
                                states: {
                                    hover: {
                                        enabled: true
                                    }
                                }
                            }
                        },
                        area: {
                            fillOpacity: 0.6,
                            marker: {
                                 	 radius:0,
                                    }
                        }
                    },
                    colors: [
           '#99ccff', 
           '#0080ff', 
           '#00ff00', 
           '#000066', 
           '#ff0000', 
           '#ff8000'
        ],
        //-----------------------------------------------------------------------------
                                  area: {
                                      pointStart: 0,
                                      marker: {
                                          enabled: false,
                                          symbol: 'circle',
                                          radius: 0
                                            }
                                        },
//--------------------------------------------------------------------------------
                    series: [{
                        name: 'Pérdida',
                        data: perdidas_final,
                        type: 'area'
                    }, {
                        name: 'Pérdida(+tolerancia 25%)(Zona Segura)',
                        data: p_permitida_final,
                        type: 'area',
                    },{
                        name: 'Indicación actual',
                        data: puntos
                    },
                    {
                        name: 'Indicación Proyectada',
                        data: proyeccion
                    }
                    ]
                });

              }


                  function graficarintegridad(idindicacion, idlinea)
                  {
                      document.getElementById('container').innerHTML='';
                      $.getJSON('extraeEspesores.php?id_linea='+idlinea,function (espesor)
                              {
                                   document.getElementById('espesor').value = espesor[0]['maximo'];
                              });

                      $.getJSON('extraeIdLinea.php?id_linea='+idlinea,function (espesor)
                              {
                                   document.getElementById('diametro').value = espesor[0]['diametro_exterior'];
                                   document.getElementById('smys').value = espesor[0]['smys'];
                                   document.getElementById('fcp').value = espesor[0]['fcp'];
                                   document.getElementById('presion').value = espesor[0]['presion_actual'];
                                   document.getElementById('fechaoperacion').value = espesor[0]['fecha_inicio_operacion'];
                                   fecha1 =  moment(document.getElementById('fechaoperacion').value);
                                   fecha2 =  moment(document.getElementById('fechaactual').value) ;
                                   anios = fecha2.diff(fecha1, 'years');
                                   document.getElementById('anooperacion').value = anios;

                              });

                      $.getJSON('extraeIdIndicacion.php?id_indicacion='+idindicacion,function (espesor)
                              {
                                  document.getElementById('fechainspeccion').value = espesor[0]['fecha_inspeccion'];
                                  document.getElementById('profundidad').value = espesor[0]['profundidad'];
                                  document.getElementById('longitud').value = espesor[0]['largo'];
                              });
                      
                      $("#myModal2").modal();
                  }
               //-------------------junio------------------------------------------

      $(function()
      {
        $(".indicaciones").tiksluscarousel({width:1150,height:480,nav:'thumbnails'});
        $( "#tabs" ).tabs();
        $('#close').click(function()
        {
                            $('#popup').fadeOut('slow');
                            $('.popup-overlay').fadeOut('slow');
                            window.location="indicacion_tabla.php?id_programa=<?php echo $_GET['id_programa']; ?>";
                            return false;
        });
    });
    
    function abrir(id_indicacion,por,ind)
    {
        $("#myModal").modal();
        $("#myTable12").find("tr:gt(0)").remove();

        var fila = '<tr class="gradeX" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" >'
                                    +'<td>'
                                    +'Tipo de Indicacion.. <strong>'+ind+'</strong> Porcentaje de Perdida.. <strong>'+por+'</strong>';
                                    +'</td>'           
                                    +'</tr>';
                                    $('#myTable12').append(fila);

        $.getJSON('extraeFotosInd.php?id_indicacion='+id_indicacion,function (id_foto)
        {
                for (var i = 0; i < id_foto.length; i++) 
                {     
                    var fig ='<img border="0" src="../../avance_contrato/evaluacion/ind_fotos/'+id_foto[i]['archivo']+'" width="365" height="365">';
                    var fila = '<tr class="gradeX" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" >'
                                    +'<td>'
                                    +'<center>'+fig+'</center>'
                                    +'</td>'           
                                    +'</tr>';
                                    $('#myTable12').append(fila);
                    
                }
        }); 

    }
        </script>
<?php
 }
 }//if(isset($_SESSION['id_usuario'])) {
?>


