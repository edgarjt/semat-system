<?php
session_start();
if(!empty($_SESSION)){
if(isset($_SESSION['id_usuario']) && ($_SESSION['tipo_usuario'] == 'ADMINISTRADOR' || $_SESSION['tipo_usuario'] == 'CAPTURA' || $_SESSION['tipo_usuario'] == 'GERENCIA' ) )
{
      include_once("../library/Componente_P1V2.php");
      include_once '../library/Indicacion.php';
      include_once '../library/TipoIndicacion.php';
      include_once '../library/Programa.php';
      include_once("../library/IndicacionFoto.php");
      include_once("../library/Consulta.php");
      include_once("../library/Avance.php");
      include_once("../library/Foto.php");
      $foto            = new Foto();
      $avance          = new Avance();
      $consulta        = new Consulta();
      $indicacion    = new Indicacion();
      $tipo_indicacion = new TipoIndicacion();
      $programa      = new Programa();
      $indicacion_foto = new IndicacionFoto();
      $id_programa   = $_GET['id_programa'];
      $programa->loadById($id_programa);
      $titulo      = "KM ".$programa->getKmInicial()." al km ".$programa->getKmFinal();
      ?>

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
                                                          echo $tipo_indicacion->getSimbologia();
                                                          $aaa = $tipo_indicacion->getSimbologia();
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
    <script type="text/javascript" src="../js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/tik/tiksluscarousel.js"></script>
    <script type="text/javascript" src="js/tik/rainbow.min.js"></script>
    <link rel="stylesheet" href="css/tik/normalize.css" />
    <link rel="stylesheet" href="css/tik/tiksluscarousel.css" />
    <link rel="stylesheet" href="css/tik/github.css" />
    <link rel="stylesheet" href="css/tik/animate.css" />

    
    <link rel="stylesheet" href="../js/graficas/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="../js/graficas/amcharts/themes/light.js"></script>
    <script type="text/javascript">
                  function cambiacolor_over(celda){ celda.style.backgroundColor="#F5BCA9" } 
                  function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }
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


