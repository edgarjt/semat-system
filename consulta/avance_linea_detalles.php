<?php
session_start();
if(!empty($_SESSION)){
if(isset($_SESSION['id_usuario']) ){
      include_once("../library/Ddv.php");
      include_once("../library/Contrato.php");
      include_once("../library/Consulta.php");
      include_once("../library/TipoTrabajo.php");
      include_once("../library/Indicacion.php");
      include_once("../library/TipoIndicacion.php");
      include_once("../library/Linea.php");
      include_once("../library/Programa.php");
      include_once("../library/OrdenServicio.php");
      include_once("../library/Componente_P1V2.php");

      $ddv              = new Ddv();
      $contrato         = new Contrato();
      $consulta         = new Consulta();
      $tipo_trabajo     = new TipoTrabajo();
      $indicacion       = new Indicacion();
      $tipo_indicacion  = new TipoIndicacion();
      $linea            = new Linea();
      $programa         = new Programa();
      $orden_servicio   = new OrdenServicio();
      $linea->loadById($_GET['id_linea']);
      $contratos = array();
      $tipos_indicaciones= $tipo_indicacion->getAllTipoInspeccion('VT');

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
                            <h5>Puntos Intervenidos:<?php echo ' ' .$linea->getNombre(); ?></h5>
                            <input type="hidden" id="nomlinea" value="<?php echo $linea->getNombre(); ?>">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                            <div class="ibox-content">
                            <div class="table-responsive">
                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                           placeholder="Buscar kilometraje">
                            <table class="footable table table-striped"  data-page-size="20" data-filter=#filter id="myTable">
                                <thead>
                                   <tr>
                                    <th>No.</th>
                                    <th>ID</th>
                                    <th>KM INICIAL</th>
                                    <th>KM FINAL</th>
                                    <th>C1</th>
                                    <th>C2</th>
                                    <th>TIPO TRABAJO </th>
                                    <th>CONTRATO </th>
                                    <th>IND. EXT.</th>
                                    <th>IND. INT.</th>
                                    <th>TOTAL</span></th>
                                    <th>PERDIDA <br>(MENOR a 10%) </th>
                                    <th>PERDIDA <br>(10 al 29.99)% </th>
                                    <th>PERDIDA <br>(30 al 79.99)% </th>
                                    <th>PERDIDA <br>(MAYOR al 80)% </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php 
                              $puntosx= $programa->getPuntosContratoLinea($_GET['id_linea'], $_GET['contrato'], $_GET['tipo_trabajo']);
                              $i= 0;
                              foreach ($puntosx as $value) {
                                 $puntos[$i]['id_programa'] = $value['id_programa'];
                                 $puntos[$i]['km_inicial'] = $value['km_inicial'];
                                 $puntos[$i]['km_final'] = $value['km_final'];
                                 $puntos[$i]['id_linea'] = $value['id_linea'];
                                 $puntos[$i]['utm_n'] = $value['utm_n'];
                                 $puntos[$i]['utm_e'] = $value['utm_e'];
                                 $puntos[$i]['id_orden_servicio'] = $value['id_orden_servicio'];
                                 $puntos[$i]['estatus'] = $value['estatus'];
                                 $iconos=$programa-> getIconoPunto($value['id_programa']);
                                 if (!empty($iconos)) {
                                    $puntos[$i]['icono1']= $value['estatus'].'_'.$iconos[0]['icono'];
                                 } else {
                                    $puntos[$i]['icono1']= $value['estatus'];
                                 }
                                
                                 $puntos[$i]['porcentaje'] = $indicacion->getMaxPorcentajeIndicacionPrograma2($value['id_programa']);
                                 if ($puntos[$i]['porcentaje'] >= 0 && $puntos[$i]['porcentaje'] <=20){
                                      $puntos[$i]['marker'] = 20 ;
                                  }else if ($puntos[$i]['porcentaje'] > 20 && $puntos[$i]['porcentaje'] <=40){
                                      $puntos[$i]['marker'] = 25 ;
                                  }else if ($puntos[$i]['porcentaje'] > 40 && $puntos[$i]['porcentaje'] <=60){
                                      $puntos[$i]['marker'] = 30 ;
                                  }else if ($puntos[$i]['porcentaje'] > 60 && $puntos[$i]['porcentaje'] <80){
                                      $puntos[$i]['marker'] = 35 ;
                                  }else if ($puntos[$i]['porcentaje'] >= 80 ){
                                      $puntos[$i]['marker'] = 40 ;
                                  }
                                 $i++;
                              }
                              //print_r($puntos);

                              $cont=0;
                              $c1=0;$c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;

                              foreach ($puntos as $value) {
                                $cont++;
                                $orden_servicio->loadById($value['id_orden_servicio']);
                                $tipo_trabajo->loadById($orden_servicio->getTipoTrabajo());
                                $contrato->loadById($orden_servicio->getContrato());
                               ?>
                               <tr <?php echo ($cont % 2 == 0) ? 'class="row_par"' : 'class="row_impar"' ; ?> onmouseover="cambiacolor_over(this);" onmouseout="cambiacolor_out(this);">
                                  <td>
                                    <strong>
                                      <a href="indicacion_tabla.php?id_programa=<?php echo $value['id_programa']; ?>&linea=<?php echo $value['id_linea']; ?>&subdireccion=<?php echo $_GET['subdireccion']; ?>">
                                   <?php echo $cont;?>
                                      </a>
                                    </strong>
                                  </td>
                                  <td><strong><?php echo $value['id_programa'];?></strong></td>
                                  <?php 
                                      $titulo = "'".$value['km_inicial']."'";
                                      $estatus= "'".$value['estatus']."'";
                                      $icono = "'".$value['icono1']."'";
                                  ?>
                                  <td onclick="addMarker(<?php echo $value['utm_n'].','.$value['utm_e'].','. $titulo.','.$icono.','.$value['id_programa'].','.$value['marker'];?>);"><strong><?php echo $value['km_inicial'];?></strong></td>
                                  <td><strong><?php echo $value['km_final'];?></strong></td>
                                  <!--<td><?php echo $value['icono1'] ?></td>-->
                                  <td><?php echo $value['utm_n'] ?></td>
                                  <td><?php echo $value['utm_e'] ?></td>
                                  <td><strong><?php echo $tipo_trabajo->getDescripcion();?></strong></td>
                                  <td><strong><?php echo $contrato->getNumero(); ?></strong></td>
                                  <td><strong><center><?php echo $indicacion->getAllCountProgramaTipoInspeccion($value['id_programa'], 'VT'); $c1=$c1+$indicacion->getAllCountProgramaTipoInspeccion($value['id_programa'], 'VT'); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getAllCountProgramaTipoInspeccion($value['id_programa'], 'UT'); $c2=$c2+$indicacion->getAllCountProgramaTipoInspeccion($value['id_programa'], 'UT'); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getAllCountByIdPrograma($value['id_programa']); $c3=$c3+$indicacion->getAllCountByIdPrograma($value['id_programa']); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getIndicacionesProgramaLinea($value['id_programa'], 0, 9.99); $c4=$c4+$indicacion->getIndicacionesProgramaLinea($value['id_programa'],0,9.99); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getIndicacionesProgramaLinea($value['id_programa'], 10, 29.99); $c5=$c5+$indicacion->getIndicacionesProgramaLinea($value['id_programa'],10,9.99); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getIndicacionesProgramaLinea($value['id_programa'], 30, 79.99); $c6=$c6+$indicacion->getIndicacionesProgramaLinea($value['id_programa'],30,79.99); ?></center></strong></td>
                                  <td><strong><center><?php echo $indicacion->getIndicacionesProgramaLinea($value['id_programa'], 80, 100); $c7=$c7+$indicacion->getIndicacionesProgramaLinea($value['id_programa'],80,100); ?></center></strong></td>
                                </tr>
                              <?php
                                  }
                              ?>
                                <tr class="row_total">
                                    <td colspan="5" onclick="addAllMarker(1);"><strong><center><p >Totales...</p></strong></center></td>
                                    <td><strong><center><?php echo $c1; ?></strong></center></td>
                                    <td><strong><center><?php echo $c2; ?></strong></center></td>
                                    <td><strong><center><?php echo $c3; ?></strong></center></td>
                                    <td><strong><center><?php echo $c4; ?></strong></center></td>
                                    <td><strong><center><?php echo $c5; ?></strong></center></td>
                                    <td><strong><center><?php echo $c6; ?></strong></center></td>
                                    <td><strong><center><?php echo $c7; ?></strong></center></td>
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
                                        <div id="floating-panel">
                                          <input onclick="clearMarkers();" type=button value="Ocultar">
                                          <input onclick="showMarkers();" type=button value="Mostrar">
                                          <input onclick="deleteMarkers();" type=button value="Borrar">
                                        </div>
                                        <div id="map" class="google-map"></div>
                                         <div class="ibox-content">
                                         <table class="table">
                                              <tr>
                                                  <td bgcolor="#A9D0F5">
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
                                                  </td>
                                                  <td bgcolor="#A9D0F5"><strong>
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


             <!-- modal -->
            <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-camera modal-icon"></i>
                                            <h4 class="modal-title">Documentos </h4>
                                        </div>
                                        <div class="modal-body">
                                                <form id="form" >
                                                    <div class="form-group">
                                                          <div id="actareparacion"><center></center></div>
                                                          <div class="row">
                                                                <div class="ibox-content">
                                                                      <table id="myTable2">
                                                                        <tbody>
                                                                            <tr class="gradeX">
                                                                            </tr> 
                                                                        </tbody>
                                                                      </table>
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
   
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
     
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>

    <script src="../js/graficas/amcharts/amcharts.js"></script>
    <script src="../js/graficas/amcharts/pie.js"></script>
    <script src="../js/graficas/amcharts/serial.js"></script>
    <script src="../js/graficas/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="../js/graficas/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="../js/graficas/amcharts/themes/light.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=
AIzaSyD0jULw6KYXZl0YSsLBABqdsy_gcDUU1IY
&callback=initMap"></script>
    <script type="text/javascript">
                  function cambiacolor_over(celda){ celda.style.backgroundColor="#F5BCA9" } 
                  function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }
               //-------------------junio------------------------------------------

      var map;
      var markers = [];

      function initMap() {
        //var haightAshbury = {lat: 37.769, lng: -122.446};

        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: new google.maps.LatLng(17.479460, -93.364310),
          mapTypeId: google.maps.MapTypeId.SATELLITE
        });

        capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA_4_AGD.kmz');
                          capa.setMap(map);

        capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA_4_CRD.kmz');
                          capa.setMap(map);

        capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA_E.kmz');
                          capa.setMap(map);

        capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA3_GENERAL.kmz');
                          capa.setMap(map);

         capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/ZONAS.kmz');
                          capa.setMap(map);
                  

                  }
        /*capa = new google.maps.KmlLayer('http://www.semat.mx/avance_contrato/kml/SISTEMA_4_AGD.kmz');
                          capa.setMap(map);
                  }*/


      // Adds a marker to the map and push to the array.
      function addMarker(lat, lon, titulo, est, id, marker) {

        //----------------------------consulta de las fotos----------------------------------
        //alert(id);
        id_programa = parseFloat(id);
        tamanio = parseFloat(marker);
         $.getJSON('extraeFotoPunto.php?id_programa='+id_programa, function (puntos)
                                                  { 
                                                      var linea =  document.getElementById('nomlinea').value
                                                      var contentString = '<div id="content">'+
                                                      '<div id="siteNotice">'+
                                                      '</div>'+
                                                      '<h3 id="firstHeading" class="firstHeading">'+linea+'</h3>'+
                                                      '<h3 id="firstHeading" class="firstHeading">'+puntos[0].km_inicial+'-'+puntos[0].km_final+'</h3>'+
                                                      '<div id="bodyContent">'+
                                                      '<table  style="width:470px;" >';

                                                      contentString =contentString +'<tr><td><p  onclick="mostrardocumento('+puntos[0].id_programa+');">Documentos</p></tr></td>'
                                                                                           
                                                      contentString =contentString +'</table>'+
                                                      '<table><tr>';
                                                      for (i = 0; i < puntos.length; i++) {  
                                                          contentString =contentString +'<td><img src="../../avance_contrato/captura/files/'+puntos[i].archivo+'" style="height:350px;" </img></td>'
                                                      }

                                                      contentString =contentString +'</tr><tr>';
                                                      for (i = 0; i < puntos.length; i++) {  
                                                          contentString =contentString +'<td>'+puntos[i].descripcion+'</td>'
                                                      }

                                                      contentString =contentString +'</tr></table></div>'+
                                                      '</div>';

                                                  var infowindow = new google.maps.InfoWindow({
                                                    content: contentString
                                                  });


                                                  var image = {
                                                              url: '../img/'+est+'.png' ,
                                                              scaledSize:new google.maps.Size(tamanio, tamanio) } ;
                                                  var marker = new google.maps.Marker({
                                                  position: new google.maps.LatLng(lat, lon),
                                                  map: map,
                                                  title: titulo,
                                                  icon: image  
                                                  });

                                                  marker.addListener('click', function() {
                                                    infowindow.open(map, marker);
                                                  });

                                                  markers.push(marker);
                                                                                                
                                                  });
        //----------------------------fin consulta de las fotos-------------------------------

       
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      function mostrardocumento(id){
        document.getElementById('actareparacion').innerHTML="";
         $.getJSON('extraeActaPunto.php?id_programa='+id, function (actas)
                  { 
                       document.getElementById('actareparacion').innerHTML='<center><a href="../../avance_contrato/captura/actas/'+actas[0].archivo+'" target="_blank">ACTA DE REPARACION No.:'+actas[0].numero+'</center>';  
                  });
       
        $("#myModal2").find("tr:gt(0)").remove();
         $.getJSON('extraeDocumentoPunto.php?id_programa='+id, function (puntos)
                                                  { 
                                                    for (var i = 0; i < puntos.length; i++) 
                                                          { 
                                                           var fila = '<tr class="gradeX" >'
                                                                      +'<td>'
                                                                      +'<a href="../../avance_contrato/captura/documentos/'+puntos[i].archivo+'" target="_blank">'+puntos[i].descripcion+'</a>'
                                                                      +'</td>'
                                                                      +'<td>'
                                                                      +'<a href="../../avance_contrato/captura/documentos/'+puntos[i].archivo+'" target="_blank">'+puntos[i].numero+'</a>'
                                                                      +'</td>'
                                                                      +'</tr>';
                                                                      $('#myTable2').append(fila);
                                                          }
                                                  });

        $("#myModal2").modal();
      }

      function addAllMarker(idlinea){
          //alert(idlinea);
          var puntomaps=<?php echo json_encode($puntos); ?>;
          for (var i = 0; i < puntomaps.length; i++) 
                { 
                    addMarker(puntomaps[i].utm_n, puntomaps[i].utm_e, puntomaps[i].km_inicial, puntomaps[i].icono1, puntomaps[i].id_programa, puntomaps[i].marker)
                }
      }

              //------------------- fin de junio-----------------------------------------
       

        </script>
        
    
<?php
 }
 }//if(isset($_SESSION['id_usuario'])) {
?>


