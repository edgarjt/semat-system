<?php
session_start();
if(!empty($_SESSION)){
if(isset($_SESSION['id_usuario']) ){
include_once("../library/Componente_P1V2.php");
include_once("../Library/Ddv.php");
include_once("../Library/Consulta.php");
include_once("../Library/Indicacion.php");
include_once("../Library/TipoIndicacion.php");
include_once("../Library/Linea.php");
include_once("../library/Programa.php") ;
include_once("../library/Contrato.php");
include_once("../library/TipoTrabajo.php");
include_once("../library/Compania.php");

$ddv             = new Ddv();
$consulta        = new Consulta();
$indicacion      = new Indicacion();
$tipo_indicacion = new TipoIndicacion();
$linea           = new Linea();
$compania        = new Compania();
$contrato        = new Contrato();
$programa        = new Programa();
$tipo_trabajo    = new TipoTrabajo();

$programas = json_encode(array());
$contratos=$contrato->getAll();
$companias=$compania->getAll();
$tipos_trabajos= $tipo_trabajo->getAll();

$op_subdireccion = '' ;
$op_contrato = '' ;
$op_tipo_trabajo = '' ;
$op_compania = '' ;
$cto =0;
$tt  =0;
$sub =0;
$cia =0;
$totindut = 0;
$totindvt = 0;
$actvidades_resumen= $consulta->getConsulta_actividad_resumen();
$lineas = array();
$tipos_indicaciones= array();
$tipos_indicaciones2= array();
$indexternas = array();
$indinternas = array();

if(isset($_POST['subdireccion']) && isset($_POST['contrato']) && isset($_POST['tipo_trabajo']) ) {
    $op_tipo_trabajo = $_POST['tipo_trabajo'] ;
    $op_contrato = $_POST['contrato'] ;
    $op_subdireccion = $_POST['subdireccion'] ;
}


            if (!empty($_POST)) {
                $cto =$_POST['contrato'];
                $tt  =$_POST['tipo_trabajo'];
                $sub =$_POST['subdireccion'];
                $cia =$_POST['compania'];
                $tipos_indicaciones= $tipo_indicacion->getAllTipoInspeccion('VT');
                $tipos_indicaciones2= $tipo_indicacion->getAllTipoInspeccion('UT');
                $totindvt=$indicacion->getIndicacionesDuctoCountTotal('VT',$cto, $tt, $sub, $cia);
                $totindut=$indicacion->getIndicacionesDuctoCountTotal('UT',$cto, $tt, $sub, $cia);
                $programas = $programa->getAllCoord2( $_POST['subdireccion'], $_POST['tipo_trabajo'], $_POST['contrato'], $_POST['compania']) ;
                $consulta_kml = $programa->getKmlContrato($_POST['contrato']);
                $j_consulta_kml = json_encode($consulta_kml);
               // print_r($programas);
                $consultas  = $consulta->getConsulta_avance($_POST['contrato'], $_POST['subdireccion'], $_POST['tipo_trabajo'], $_POST['compania']);
                //print_r($consultas);
                $arreglo = array();
                $foto    = array();
                $docto   = array();
                $ddv_via = array();
                $tipotrabajo = array();
                $lineas = array();
                $acta    = array();
                    
                    
                            if (!empty($consultas)) {
                                  foreach ($consultas as $value) {
                                      $referencia= $value['km_inicial'].'-'.$value['km_final'];
                                      $foto[$value['id_programa']]=$consulta->getConsulta_avance_detalle($value['id_programa']);    
                                      $acta[$value['id_programa']]=$consulta->getConsulta_acta($value['id_programa']);            //agrege esta linea   
                                      $docto[$value['id_programa']]=$consulta->getConsulta_docto($value['id_programa']);
                        
                                  } // foreach ($consultas as $value) { 
                                     
                                      $j_foto= json_encode($foto);          
                                      $j_acta= json_encode($acta);  //agrege esta linea
                                      $j_docto= json_encode($docto);
                        
                                     //--------obtener los derechos de via ----------------
                                      foreach ($consultas as $value) {
                                          $array_derechovia[]=$value['alias'];
                                          $array_disciplina[]=$value['descripcion'];
                                          $array_linea[]=$value['id_linea'];
                                      }
                                      $ddv_via=array_unique($array_derechovia);
                                      $tipotrabajo=array_unique($array_disciplina);
                                      $lineas=array_unique($array_linea);
                                     //----------fin de obtener los derechos de via--------
                                }
              }
?>
<link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
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
                                            <div ><SELECT id="subdireccion" NAME="subdireccion" SIZE=1 class="form-control" onchange="changeContratos()">
                                                    <OPTION VALUE="-1" >Seleccionar una sub-direccion</OPTION>
                                                    <?php
                                                        foreach ($contrato->subdirecciones as $value) {
                                                            ?>
                                                            <option value="<?php echo $value; ?>" <?php echo ($value==$op_subdireccion) ? "selected='selected'" : '' ; ?> ><?php echo $value ; ?></option>
                                                            <?php
                                                        }
                                                   ?>
                                                    </SELECT> </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-6 control-label">Tipo de trabajo</label>
                                            <div ><SELECT id="tipo_trabajo" NAME="tipo_trabajo" SIZE=1 class="form-control">
                                                    <option value="-1">Todos</option> 
                                                    <?php foreach ($tipos_trabajos as $value) { ?>
                                                      <option value="<?php echo $value['id_tipo_trabajo']; ?>" <?php echo ($value['id_tipo_trabajo'] == $op_tipo_trabajo) ? "selected='selected'" : '' ; ?> >
                                                         <?php echo $value['descripcion']; ?> </option>
                                                    <?php } ?>
                                                    </SELECT>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group"><label class="col-sm-6 control-label">Contrato</label>
                                            <div ><SELECT id="contrato" NAME="contrato" SIZE=1 class="form-control" >
                                                    <option value="-1">Todos</option>
                                                      <?php 
                                                      foreach ($contratos as $value) { 
                                                      ?>
                                                          <option value="<?php echo $value['id_contrato']; ?>" <?php echo ($value['id_contrato'] == $op_contrato) ? "selected='selected'" : '' ; ?> >
                                                          <?php 
                                                          echo $value['numero'] . " - " . $value['subdireccion']; ?> 
                                                          </option>
                                                      <?php 
                                                      } 
                                                      ?>
                                                    </SELECT></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div ><button class="btn btn-primary" type="submit">Consultar</button></div>
                                        </div> 
                                    </div> 

                                    <div class="col-md-4">
                                        <div class="form-group"><label class="col-sm-6 control-label">Compañia</label>
                                            <div ><SELECT id="compania" NAME="compania" SIZE=1 class="form-control" >
                                                    <option value="-1">Todos</option>
                                                    <?php 
                                                    foreach ($companias as $value) { 
                                                    ?>
                                                        <option value="<?php echo $value['id_compania']; ?>" <?php echo ($value['id_compania'] == $op_compania) ? "selected='selected'" : '' ; ?> >
                                                        <?php 
                                                              echo $value['alias']; ?> 
                                                        </option>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    </SELECT></div>
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
            </div>


         <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ubicacion georeferenciada de los puntos intervenidos</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                    <div class="col-lg-12">
                                        <div id="map" class="google-map"></div>
                                         <div class="ibox-content">
                                         <table class="table table-striped">
                                              <tr>
                                                 <!-- <td bgcolor="#A9D0F5">
                                                      <img width="20" height="20" src="../img/PROGRAMA.png"> Pendiente:
                                                      <?php echo $programa->t_programado ; ?>
                                                  </td>
                                                  <td bgcolor="#A9D0F5">
                                                      <img width="20" height="20" src="../img/PROCESO.png">  En Proceso:
                                                          <?php echo $programa->t_proceso;?>
                                                  </td>
                                                  <td bgcolor="#A9D0F5">
                                                      <img width="20" height="20" src="../img/TERMINADO.png"> Terminado sin Acta:
                                                          <?php echo $programa->t_terminado; ?>
                                                  </td>
                                                  <td bgcolor="#A9D0F5">
                                                      <img width="20" height="20" src="../img/ACTA.png"> Terminado con Acta:
                                                          <?php echo $programa->t_acta;?>
                                                  </td>-->
                                                  <td COLSPAN="5" bgcolor="#A9D0F5"><strong>
                                                      Total: 
                                                          <?php echo $programa->t_puntos;?>
                                                      </strong>
                                                  </td>
                                              </tr>
                                              <tr bgcolor="#A9F5BC">
                                                <td><img width="30" height="30" src="../img/ETB.png">Envolvente tipo "B" (ETB)</td>
                                                <td><img width="30" height="30" src="../img/ECB.png">Envolvente tipo "B" CON Boyler (ECB)</td>
                                                <td><img width="30" height="30" src="../img/BRE.png">Envolvente tipo "B+RE" (BRE)</td>
                                                <td><img width="30" height="30" src="../img/GMP.png">Grapa metalica tipo PLIDCO (GMP)</td>
                                                <td><img width="30" height="30" src="../img/HABITAT.png">Habitat</td>
                                              </tr>
                                            </table>
                                         <div>
                                    </div>
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
                            <h5>Lineas Intervenidas</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
                            <div class="table-responsive">
                            <?php
                                $c=count($actvidades_resumen);
                                $c=$c+10;
                                 $arreglo_totales_lineas = array();
                                 for($j=0; $j<$c;$j++){
                                     $arreglo_totales_lineas[$j] = 0 ;
                                 }  
                            ?>
                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                           placeholder="Buscar linea">
                            <table class="footable table table-striped"  data-page-size="20" data-filter=#filter id="myTable">
                                <thead>
                                <tr>
                                    <th>
                                        No.
                                    </th>
                                    <th>
                                        LINEA 
                                    </th>
                                    <?php
                                    foreach ($actvidades_resumen as $key_actividad) {
                                    ?>
                                        <th>
                                           <Center> <?php echo $key_actividad['descripcion'].'<br>'.'('.$key_actividad['unidad'].')';?></Center>
                                        </th> 
                                    <?php

                                    }
                                    ?>
                                    <th><center>PUNTOS</center></th>
                                    <th><center>IND. EXT.</center></th>
                                    <th><center>IND. INT.</center></th>
                                    <th><center>TOTAL IND.</center></th>
                                    <th><center>PERDIDA <br> (MENOR a 10%) </center></th>
                                    <th><center>PERDIDA <br> (10 al 29.99)% </center></th>
                                    <th><center>PERDIDA <br>(30 al 79.99)% </center></th>
                                    <th><center>PERDIDA <br>(MAYOR al 80)% </center></th>
                                    <!--<th>ACCIONES</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
                            $cont=0;
                            $cont2=0;
                            
                            foreach ($lineas as $value) {
                                $cont++;
                                $linea->loadById($value);
                                ?>
                                <tr class="<?php echo ($cont %2 == 0) ? "row_par" : "row_impar" ; ?>" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo $cont;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <a target="_blank" href="avance_linea_detalles.php?id_linea=<?php echo $linea->getId();?>&contrato=<?php echo $_POST['contrato'];?>&subdireccion=<?php echo $_POST['subdireccion'];?>&tipo_trabajo=<?php echo $_POST['tipo_trabajo'] ?>">
                                                <?php echo $linea->getNombre();?>
                                            </a>
                                        </strong>
                                    </td>
                                    
                                <?php
                                $contador_provisional = 2 ;
                                foreach ($actvidades_resumen as $key_actividad) {
                                ?>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php 
                                                $val = round ($consulta->getConsulta_actividad_ducto($value, $_POST['contrato'], $_POST['tipo_trabajo'], $key_actividad['id_actividad'], $_POST['compania']),2) ;
                                                echo $val ;
                                                $arreglo_totales_lineas[$contador_provisional]+=$val ;
                                                $contador_provisional ++ ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <?php
                                    }
                                    ?>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php
                                                $puntos=$consulta->getPuntoLinea($value, $_POST['contrato'], $_POST['tipo_trabajo'], $_POST['compania']) ;
                                                echo $puntos ; 
                                                $arreglo_totales_lineas[$contador_provisional++] += $puntos ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td> 
                                    <td>
                                        <strong>
                                            <center>
                                                <?php 
                                                $temp = date ($indicacion->getIndicacionesDuctoCount($value,'VT',$_POST['contrato'], $_POST['tipo_trabajo'], $_POST['compania'])) ;
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php
                                                $temp = date($indicacion->getIndicacionesDuctoCount($value,'UT',$_POST['contrato'], $_POST['tipo_trabajo'], $_POST['compania'])) ;
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php
                                                $temp = date ($indicacion->getIndicacionesDuctoCount2($value,$_POST['contrato'], $_POST['tipo_trabajo'], $_POST['compania'])) ;
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php 
                                                $temp = $indicacion->getIndicacionesDuctoCountPorcentaje($value,$_POST['contrato'], $_POST['tipo_trabajo'],0.1,9.99, $_POST['compania']);
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php 
                                                $temp = $indicacion->getIndicacionesDuctoCountPorcentaje($value,$_POST['contrato'], $_POST['tipo_trabajo'],10,29.99, $_POST['compania']);
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php
                                                $temp = $indicacion->getIndicacionesDuctoCountPorcentaje($value,$_POST['contrato'], $_POST['tipo_trabajo'],30,79.99, $_POST['compania']);
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php 
                                                $temp = $indicacion->getIndicacionesDuctoCountPorcentaje($value,$_POST['contrato'], $_POST['tipo_trabajo'],80,100, $_POST['compania']);
                                                echo $temp ;
                                                $arreglo_totales_lineas[$contador_provisional++] += $temp ;
                                                ?>
                                            </center>
                                        </strong>
                                    </td>
                                   <!--<td>
                                      <img border="0" alt="Ver Ptos" src="../img/icono/VER.png" width="25" height="25" onclick="verpuntoslinea(<?php echo $linea->getId().",".$_POST['contrato'].",'".$_POST['subdireccion']."',". $_POST['tipo_trabajo'] ?>);">
                                    </td>-->
                                </tr>   
                            <?php
                                $cont2=$cont2+$puntos;
                            }
                            ?>
                            <tr class="row_total">
                                <td colspan="2">
                                    <strong>
                                        <center>
                                            TOTALES
                                        </center>
                                    </strong>
                                </td>
                                <?php
                                $contador_provisional = 2 ;
                                foreach ($actvidades_resumen as $key_actividad) {
                                ?>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 2) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                <?php
                                }
                                ?>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <center>
                                                <?php echo number_format($arreglo_totales_lineas[$contador_provisional++], 0) ;?>
                                            </center>
                                        </strong>
                                    </td>
                                </tr>                             
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

                          <div class="col-lg-6">
                          <div class="ibox float-e-margins">
                              <div class="ibox-content">
                                  <strong>Indicaciones externas<?php echo ' '.number_format($totindvt); ?></strong>
                                  <div id="chartdiv1" style="width:100%; height: 700px;"></div>
                        
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-6">
                          <div class="ibox float-e-margins">
                              <div class="ibox-content">
                                  <strong>Indicaciones internas<?php echo ' '.number_format($totindut); ?></strong>
                                  <div id="chartdiv2" style="width:100%; height: 700px;"></div>
                        
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
                        <h5>Indicaciones Externas <?php echo number_format($totindvt);?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped"  >
                                <thead>
                                <tr>
                                    <th>TIPO</th>
                                    <th>SIMBOLOGIA</th> 
                                    <th>CANTIDAD</th>
                                    <th><center>PERDIDA <br> (MENOR a 10%) </center></th>
                                    <th><center>PERDIDA <br> (10 al 29.99)% </center></th>
                                    <th><center>PERDIDA <br>(30 al 79.99)% </center></th>
                                    <th><center>PERDIDA <br>(MAYOR al 80)%</center></th>                            
                                </tr>
                                </thead>
                                <tbody>
                                   <?php
                                      $cont_row = 0;
                                      $c2=0;
                                      foreach ($tipos_indicaciones as $value) { 
                                          $cont_row ++ ;
                                          ?>
                                          <tr class="<?php echo ($cont %2 == 0) ? "row_par" : "row_impar" ; ?>" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                                              <td>
                                                  <strong>
                                                      <?php echo $value['descripcion']; ?>
                                                  </strong>
                                              </td>
                                              <td>
                                                  <strong>
                                                      <center>
                                                          <?php 
                                                              echo $value['simbologia']; 
                                                          ?>
                                                      </center>
                                                  </strong>
                                              </td>
                                              <td>
                                                  <strong>
                                                      <center>
                                                          <?php 
                                                              $color = substr(md5(time()), 0, 6);
                                                              $indexternas[$c2]['simbologia']=$value['simbologia'];
                                                              $indexternas[$c2]['descripcion']=$value['descripcion'];
                                                              $indexternas[$c2]['color']='#'.$color;
                                                              $indexternas[$c2]['cantidad']=$indicacion->getIndicacionesDuctoCountTipo($value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'], $_POST['subdireccion'], $_POST['compania']);
                                                             
                                                              echo number_format($indexternas[$c2]['cantidad']);
                                                               $c2++;

                                                          ?>
                                                      </center>
                                                  </strong>
                                              </td>
                                                <!--ver que indicaciones tienen perdida-->
                                              <?php
                                                  $tipo_indicacion->loadById($value['id_tipo_indicacion']);
                                                  if ($tipo_indicacion->getEvaluacion()==1) {
                                              ?>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],0.1, 9.99, $_POST['compania'])); ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],10, 29.99, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],30, 79.99, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],80, 100, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <?php   
                                                  } 
                                                  else { 
                                                      ?>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                  <?php
                                                  }
                                                  ?>

                                          </tr>
                                      <?php   
                                      }
                                      ?>                    
                                </tbody>
                            </table>   
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Indicaciones Internas <?php echo number_format($totindut);?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped"  >
                                <thead>
                                <tr>
                                    <th>TIPO</th>
                                    <th>SIMBOLOGIA</th> 
                                    <th>CANTIDAD</th>
                                    <th><center>PERDIDA <br> (MENOR a 10%) </center></th>
                                    <th><center>PERDIDA <br> (10 al 29.99)% </center></th>
                                    <th><center>PERDIDA <br>(30 al 79.99)% </center></th>
                                    <th><center>PERDIDA <br>(MAYOR al 80)%</center></th>                            
                                </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                      $cont_row = 0;
                                      $c2 = 0;
                                      foreach ($tipos_indicaciones2 as $value) { 
                                          $cont_row ++ ;
                                          ?>
                                          <tr class="<?php echo ($cont %2 == 0) ? "row_par" : "row_impar" ; ?>" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                                              <td>
                                                  <strong>
                                                      <?php echo $value['descripcion']; ?>
                                                  </strong>
                                              </td>
                                              <td>
                                                  <strong>
                                                      <center>
                                                          <?php 
                                                              echo $value['simbologia']; 
                                                          ?>
                                                      </center>
                                                  </strong>
                                              </td>
                                              <td>
                                                  <strong>
                                                      <center>
                                                          <?php 
                                                          $indinternas[$c2]['simbologia']=$value['simbologia'];
                                                          $indinternas[$c2]['descripcion']=$value['descripcion'];
                                                          $indinternas[$c2]['color']='#'.$color;
                                                          $indinternas[$c2]['cantidad']=$indicacion->getIndicacionesDuctoCountTipo($value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'], $_POST['subdireccion'], $_POST['compania']);
                                                              echo number_format($indinternas[$c2]['cantidad']);
                                                              $c2++;
                                                          ?>
                                                      </center>
                                                  </strong>
                                              </td>
                                                <!--ver que indicaciones tienen perdida-->
                                              <?php
                                                  $tipo_indicacion->loadById($value['id_tipo_indicacion']);
                                                  if ($tipo_indicacion->getEvaluacion()==1) {
                                              ?>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],0.1, 9.99, $_POST['compania'])); ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],10, 29.99, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],30, 79.99, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  <?php 
                                                                      echo number_format($indicacion->getIndicacionesDuctoCountTipoPorcentaje($_POST['subdireccion'],$value['simbologia'],$_POST['contrato'], $_POST['tipo_trabajo'],80, 100, $_POST['compania'])); 
                                                                  ?>
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <?php   
                                                  } 
                                                  else { 
                                                      ?>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                      <td>
                                                          <strong>
                                                              <center>
                                                                  -
                                                              </center>
                                                          </strong>
                                                      </td>
                                                  <?php
                                                  }
                                                  ?>

                                          </tr>
                                      <?php   
                                      }
                                      ?>                    
                                </tbody>
                            </table>   
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
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
                                                                    <h4 class="text-center m">
                                                                        Fotografias del hallazgo
                                                                    </h4>
                                                                    <div id="myFoto">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                                                    </div>
                                                   <input type="hidden" id="idhallazgo" name="idhallazgo"> 
                                                   <input type="hidden" id="clave_anomalia" name="clave_anomalia" > 
                                                   <input type="hidden" id="nombre_foto" name="nombre_foto" value="<?php echo date("YmdHis").rand(1,90); ?>" >
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
   
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70&signed_in=true&callback=initMap"></script>

    <script src="../js/graficas/amcharts/amcharts.js"></script>
    <script src="../js/graficas/amcharts/pie.js"></script>
    <script src="../js/graficas/amcharts/serial.js"></script>
    <script src="../js/graficas/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="../js/graficas/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="../js/graficas/amcharts/themes/light.js"></script>
    <script type="text/javascript">
       
                //---------------------------------------parte new-------------------------------
                function changeContratos()
                    {
                        
                        var combo_contratos = document.getElementById("contrato");
                        var subdireccion = document.getElementById("subdireccion").value ;
                        
                        while(combo_contratos.length > 1)
                        {
                            combo_contratos.options[combo_contratos.length-1] = null;
                        }
                        
                        var contador = 1;

                        $.getJSON('extraeContratos.php?subdireccion='+subdireccion+'&id_usuario='+<?php echo $_SESSION['id_usuario']; ?>,function (contratos)
                        {      
                            for (var i = 0; i < contratos.length; i++) 
                            { 
                                combo_contratos.options[contador] = new Option();
                                combo_contratos.options[contador].text = contratos[i].numero + ' - ' + contratos[i].subdireccion ;
                                combo_contratos.options[contador].value = contratos[i].id_contrato;
                                contador++;
                            }
                        });
                    }  




                    function initialize() {
                          var marcadores = <?php echo $programas ; ?>;
                          var arreglo_kml=<?php echo $j_consulta_kml; ?>;

                          var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 4,
                            center: new google.maps.LatLng(18.027225, -93.285687),
                            mapTypeId: google.maps.MapTypeId.SATELLITE
                          });
                      
                          capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA_E.kmz');
                          capa.setMap(map);
                          
                          
                        for(i=0;i<arreglo_kml.length;i++){
                          capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/'+arreglo_kml[i]['archivo']);
                          capa.setMap(map);
                        }
                        
                        

                          var infowindow = new google.maps.InfoWindow({
                            maxWidth: 550
                          });
                          var marker, i;
                          for (i = 0; i < marcadores.length; i++) {  
                            var image = {
                                url: '../img/' + marcadores[i][3] + '.png' ,
                                scaledSize: new google.maps.Size( marcadores[i][4] , marcadores[i][4]  ) 

                              } ;
                            marker = new google.maps.Marker({
                              position: new google.maps.LatLng(marcadores[i][1], marcadores[i][2]),
                              map: map,
                              title: marcadores[i][5] ,
                              icon: image
                            });
                            
                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                              return function() {
                                infowindow.setContent(marcadores[i][0]);
                                infowindow.open(map, marker);
                              }
                            })(marker, i));
                            
                          }
                        }


                       function cambiacolor_over(celda){ celda.style.backgroundColor="#F5BCA9" } 
                       function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }

                       function verpuntoslinea(idlinea, contrato, subdireccion, tipotrabajo){
                          alert(idlinea+'-'+contrato+'-'+subdireccion+'-'+tipotrabajo);
                          $("#myModal").modal();

                       }

                       //----------------Graficas de pastel----------------------------------

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
                      } );
                     
                       //------------------------------fin de segunda grafica-----------------
                //----------------------------------------fin parte new---------------------------------
        </script>

        <script async defer
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhJncgjTivouYlHxTSPT2cCSODP5JEP4w&signed_in=true&callback=initialize">
        </script>
   
    
<?php
 }
 }//if(isset($_SESSION['id_usuario'])) {
?>


