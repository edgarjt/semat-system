<?php

include_once 'Database.php';

class Programa{
    
    private $id ;
    private $consecutivo ;
    private $km_inicial ;
    private $km_final ;
    private $longitud ;
    private $tipo_zona ;
    private $fecha_inicio ;
    private $fecha_fin ;
    private $fecha_inicio_real ;
    private $fecha_fin_real ;
    private $utm_n ;
    private $utm_e ;
    private $estatus ;
    private $coordinador ;
    private $permiso_paso ;
    private $orden_servicio ;
    private $segmento ;
    private $observaciones ;


    public $t_programado = 0 ;
    public $t_puntos = 0 ;
    public $t_proceso = 0 ;
    public $t_terminado = 0 ;
    public $t_acta = 0 ;
    
     
    private $tabla ;
    private $conexion ;
    
    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "programa" ;
    }
    
    function insert( $programa ){
        $sql = "INSERT INTO $this->tabla VALUES(0, "
                . $programa['consecutivo'] . ","
                . "'" . $programa['segmento'] . "',"
                . "'" . strtoupper( $programa['km_inicial'] ) . "',"
                . "'" . strtoupper( $programa['km_final'] ) . "',"
                . $programa['longitud']  .","
                . "'" . strtoupper( $programa['tipo_zona'] ) . "',"
                . "'" .  $programa['fecha_inicio']  . "',"
                . "'" .  $programa['fecha_fin']  . "',"
                . "'" .  $programa['fecha_inicio_real']  . "',"
                . "'" .  $programa['fecha_fin_real']  . "',"
                . "'" .  $programa['utm_n']  . "',"
                . "'" .  $programa['utm_e']  . "',"
                . "'" .  $programa['estatus']  . "',"
                . "'---' , "
                .  $programa['id_coordinador']  . ","
                .  $programa['id_permiso_paso']  . ","
                .  $programa['id_orden_servicio'] .", 
                NULL,'".  $programa['observaciones']."'" 
                . "  )" ;
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
       // return $sql;
    }
    
    function update($programa){
        $sql = "UPDATE $this->tabla SET "
                . " CONSECUTIVO =" . $programa['consecutivo'] . ","
                . " SEGMENTO = '" .  $programa['segmento'] . "',"
                . " KM_INICIAL = '" .  $programa['km_inicial'] . "',"
                . " KM_FINAL = '" .  $programa['km_final'] . "',"
                . " LONGITUD = " .  $programa['longitud'] . ","
                . " TIPO_ZONA = '" .  $programa['tipo_zona'] . "',"
                . " FECHA_INICIO = '" .  $programa['fecha_inicio'] . "',"
                . " FECHA_FIN = '" .  $programa['fecha_fin'] . "',"
                . " FECHA_INICIO_REAL = '" .  $programa['fecha_inicio_real'] . "',"
                . " FECHA_FIN_REAL = '" .  $programa['fecha_fin_real'] . "',"
                . " UTM_N = '" .  $programa['utm_n'] . "',"
                . " UTM_E = '" .  $programa['utm_e'] . "',"
                . " ESTATUS = '" .  $programa['estatus'] . "',"
                . " ID_COORDINADOR      = " . $programa['id_coordinador']."," 
                . " ID_ORDEN_SERVICIO   = " . $programa['id_orden_servicio'].","
                . " OBSERVACIONES       = '". $programa['observaciones']."'" 
                . " WHERE ID_PROGRAMA   = " . $programa['id_programa'] ;

        return $this->conexion->query($sql);
    }
    
    function updateEstatus($programa, $estatus_nuevo){
        $sql = "UPDATE $this->tabla SET "
                
                . " ESTATUS = '" .  $estatus_nuevo ."'" 
                . " WHERE ID_PROGRAMA = " . $programa ;
        return $this->conexion->query($sql);
    }
    
    function delete($programa){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_PROGRAMA = " . $programa['id_programa'] ;
        return $this->conexion->query($sql);
    }


    function getLast( $programa ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_PROGRAMA = $programa " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_programa'] ;
            $this->consecutivo['consecutivo'] ;
            $this->km_inicial = $row ['km_inicial'] ;
            $this->km_final = $row['km_final'] ;
            $this->longitud = $row['longitud'] ;
            $this->tipo_zona = $row['tipo_zona'] ;
            $this->fecha_inicio = $row['fecha_inicio'] ;
            $this->fecha_fin = $row['fecha_fin'] ;
            $this->fecha_inicio_real = $row['fecha_inicio_real'] ;
            $this->fecha_fin_real = $row['fecha_fin_real'] ;
            $this->utm_n = $row['utm_n'] ;
            $this->utm_e = $row['utm_e'] ;
            $this->estatus = $row['estatus'] ;
            $this->coordinador = $row['id_coordinador'] ;
            $this->permiso_paso = $row['id_permiso_paso'] ;
            $this->orden_servicio = $row['id_orden_servicio'] ;
            $this->segmento = $row['segmento'] ;
            $this->observaciones = $row['observaciones'] ;

            return true ;
        }
        else{
            return false ;
        }
    }


    
    function loadById( $programa ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_PROGRAMA = $programa " ;

        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_programa'] ;
            $this->consecutivo=$row['consecutivo'] ;
            $this->km_inicial = $row ['km_inicial'] ;
            $this->km_final = $row['km_final'] ;
            $this->longitud = $row['longitud'] ;
            $this->tipo_zona = $row['tipo_zona'] ;
            $this->fecha_inicio = $row['fecha_inicio'] ;
            $this->fecha_fin = $row['fecha_fin'] ;
            $this->fecha_inicio_real = $row['fecha_inicio_real'] ;
            $this->fecha_fin_real = $row['fecha_fin_real'] ;
            $this->utm_n = $row['utm_n'] ;
            $this->utm_e = $row['utm_e'] ;
            $this->estatus = $row['estatus'] ;
            $this->coordinador = $row['id_coordinador'] ;
            $this->permiso_paso = $row['id_permiso_paso'] ;
            $this->orden_servicio = $row['id_orden_servicio'] ;
            $this->segmento = $row['segmento'] ;
            $this->observaciones = $row['observaciones'] ;

            return true ;
        }
        else{
            return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla order by id_orden_servicio, consecutivo" ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }
	
	
	function getAllCoord2( $subdireccion, $tt, $cto, $cia){
	
		
		if($subdireccion == -1){
			if($cto ==-1){
				if($tt != -1){
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones, 
					linea.nombre as nombre,
					linea.id_linea,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where tipo_trabajo.id_tipo_trabajo = $tt and programa.estatus <> 'PROGRAMA' " ;
				}
				else{
					
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea ,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato 
					join compania on compania.id_compania =contrato.id_compania
                    where programa.estatus <> 'PROGRAMA'";
					
				}

			}
			else{
				if($tt != -1){
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where tipo_trabajo.id_tipo_trabajo = $tt and orden_servicio.id_contrato = $cto and programa.estatus <> 'PROGRAMA' " ;
				}
				else{
					
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea ,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where orden_servicio.id_contrato = $cto and programa.estatus <> 'PROGRAMA' " ;


				}
			}
		}
		else{
			if($cto ==-1){
				if($tt != -1){
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where tipo_trabajo.id_tipo_trabajo = $tt and contrato.subdireccion = '$subdireccion' and programa.estatus <> 'PROGRAMA' "  ;
				}
				else{
					
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea ,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where contrato.subdireccion = '$subdireccion' and programa.estatus <> 'PROGRAMA' " ;


				}

			}
			else{
				if($tt != -1){
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,
					linea.nombre as nombre,
					linea.id_linea,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where tipo_trabajo.id_tipo_trabajo = $tt and orden_servicio.id_contrato = $cto and programa.estatus <> 'PROGRAMA' " ;
				}
				else{
					
					$sql = "SELECT 
					programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus, programa.observaciones,					linea.nombre as nombre,
					linea.id_linea ,
					contrato.numero as numero_contrato,
					orden_servicio.numero_orden  as no, 
					tipo_trabajo.descripcion as trabajo
					FROM $this->tabla 
					join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
					join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
					join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
					join linea on linea.id_linea = linea_has_contrato.id_linea
					join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
					join compania on compania.id_compania =contrato.id_compania 
					where orden_servicio.id_contrato = $cto and programa.estatus <> 'PROGRAMA' " ;


				}
			}
		}
		
		//$consultita=$cia;
		if ($cia <> -1){
			//$slq=$sql." and compania.id_compania=". $cia;
			$consultita=$sql . ' and compania.id_compania='. $cia;
		} else { $consultita= $sql; }
		
        //echo $consultita;
        $resultado = $this->conexion->query($consultita);
        $array = array() ;
       // $consultita= $sql;
        if($resultado->num_rows > 0){
		
            while( $row = $resultado->fetch_assoc() ){

                $km = ''  ;
                $observacion = $row['observaciones'];
                if($row['km_final'] != '-'){
                    $km = $row['km_inicial'] . ' - ' . $row['km_final'] ;
                }
                else{
                    $km = $row['km_inicial'] ;
                }


                $tamanio_marker = 15 ;
                $indicaciones = '' ;
                $sql_indicacion = "select max(indicacion.porcentaje_perdida) as porcentaje, tipo_indicacion.descripcion as indicacion, indicacion.espesor_remanente as remanente, indicacion.fecha_inspeccion as fecha from indicacion join tipo_indicacion on tipo_indicacion.id_tipo_indicacion = indicacion.id_tipo_indicacion where id_programa = " . $row['id_programa'] ;
                $resultado_indicacion = $this->conexion->query($sql_indicacion);
                if($resultado_indicacion->num_rows > 0){

                    $ind_row = $resultado_indicacion->fetch_assoc() ;
                    if($ind_row['porcentaje'] > 0 ){

                        $colorFondoPorcentaje = '#000000';
                        $colorLetraPorcentaje = "#000000" ;
                        if ($ind_row['porcentaje'] >= 0 && $ind_row['porcentaje'] <=10){
                            $colorFondoPorcentaje = '#00FF00' ;
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else if ($ind_row['porcentaje'] >10 && $ind_row['porcentaje'] <=29.99){
                            $colorFondoPorcentaje = '#F9FF72';
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else if ($ind_row['porcentaje'] > 29.99 && $ind_row['porcentaje'] <=79.99){
                            $colorFondoPorcentaje = '#FCAE05';
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else{
                            $colorFondoPorcentaje = '#FF0000' ;
                            $colorLetraPorcentaje = '#FFF' ;
                        }


                        if ($ind_row['porcentaje'] >= 0 && $ind_row['porcentaje'] <=20){
                            $tamanio_marker = 25 ;
                        }else if ($ind_row['porcentaje'] > 20 && $ind_row['porcentaje'] <=40){
                            $tamanio_marker = 30 ;
                        }else if ($ind_row['porcentaje'] > 40 && $ind_row['porcentaje'] <=60){
                            $tamanio_marker = 35 ;
                        }else if ($ind_row['porcentaje'] > 60 && $ind_row['porcentaje'] <80){
                            $tamanio_marker = 40 ;
                        }else if ($ind_row['porcentaje'] >= 80 ){
                            $tamanio_marker = 45 ;
                        }



                        $indicaciones = '<tr><td style="border: 1px solid #0000FF; background-color:'.$colorFondoPorcentaje.'; color:'.$colorLetraPorcentaje.';" colspan="2"><center><strong> '.$ind_row['indicacion'].' <br> Máximo porcentaje de pérdida: '. round( $ind_row['porcentaje'], 2).' % <br> Espesor remanente:'.$ind_row['remanente'].' <br> Fecha de inspección'.$ind_row['fecha'].'  </strong></center></td></tr>' ;    
                    }
                    else{
                        $indicaciones = '<tr><td style="border: 1px solid #0000FF;" colspan="2"><center><strong> Sin registro de indicaciones.  </strong></center></td></tr>' ;
                    }

                    
                }
                



                
                $cadena = '<div style="width:500px; overflow-x:hidden;">'.
                      '<div style="width:490px;" > '.
                      '<table  style="width:470px;" > 
                        <tr><td style="border: 1px solid #0000FF; background-color:#0000FF; color:#FFFFFF;" colspan="2"><center><strong>'.$row['nombre'].'</strong></center></td></tr>
                        <tr><td style="border: 1px solid #0000FF; background-color:#0000FF; color:#FFFFFF;" colspan="2"><center><strong>'.$row['numero_contrato'].'</strong></center></td></tr>
                        <tr><td style="border: 1px solid #0000FF; " colspan="2"><center><strong>'.$row['trabajo'].'</strong></center></td></tr>                       
                        <tr><td style="border: 1px solid #0000FF;" width:50%;"><center>'.$km.'</center></td><td style="border: 1px solid #0000FF; width:50%;"><center>'.$row['no'].'</center></td></tr>';
                      

                        $cadena = $cadena . $indicaciones ;
                        $cadena = $cadena . '<tr><td style="border: 1px solid #0000FF; background-color:#BDBDBD; color:#0000FF; " colspan="2"><center><strong>'.$observacion.'</strong></center></td></tr>';

                      	if($row['estatus'] == 'ACTA'){
							$sql_acta = "select * from acta_reparacion where id_programa = " . $row['id_programa'] ;
							$resultado_acta = $this->conexion->query($sql_acta);

							$no_acta = $resultado_acta->num_rows ;
							$row_acta = $resultado_acta->fetch_assoc() ;

							if (isset($row_acta)) {
								 $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong><a href="../../avance_contrato/captura/actas/'.$row_acta['archivo'].'" target="_blank">ACTA</a></strong></center></td></tr>' ;
							}
                           
                        }
                        else{
                            $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong>'.$row['estatus'].'</strong></center></td></tr>' ;  
                        }

                      

                        $cadena=$cadena .'<tr><td style="border: 1px solid #0000FF; " colspan="2"><center><a target="_blank" href="indicacion_tabla.php?linea='.$row['id_linea'].'&id_programa='.$row['id_programa'].'&bge=1">FICHA TÉCNICA</a></center></td></tr>';

                        
/**
        Inicio Bloque Documentos
    */
                    $sql_documentos = "select * from documento where id_programa = " . $row['id_programa'] ;
                    $resultado_documentos = $this->conexion->query($sql_documentos);

                    $no_documentos = $resultado_documentos->num_rows ;

                    if($no_documentos>0){

                        if($no_documentos == 1){
                            $row_documento = $resultado_documentos->fetch_assoc() ;
                            $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong><a href="../../avance_contrato/captura/documentos/'.$row_documento['archivo'].'" target="_blank">'.$row_documento['descripcion'].'</a></strong></center></td></tr>' ;
                        }
                        else{
                            $division = round($no_documentos / 2, 0, PHP_ROUND_HALF_UP) ;

                            $cadena = $cadena . '<tr><td style="border: 1px solid #0000FF;"><ul>' ;
                            $contador_columna = 1 ;
                            while ($row_documento = $resultado_documentos->fetch_assoc()) {
                                
                                $cadena = $cadena. '<li><a href="../../avance_contrato/captura/documentos/'.$row_documento['archivo'].'" target="_blank">'.$row_documento['descripcion'].'</a></li>' ;
                                if($contador_columna == $division){
                                    $cadena = $cadena.'</ul></td><td style="border: 1px solid #0000FF;"><ul>' ;
                                }
                                $contador_columna ++;
                            }
                        }
                    }

/**
        Fin Bloque Documentos
    */


                        $cadena = $cadena . '</table></div>' ;


/**
        Inicio Bloque Fotos
    */

                $sql = "select foto.archivo, foto.descripcion, actividad.icono from foto
                join avance on foto.id_avance = avance.id_avance
				join actividad on avance.id_actividad = actividad.id_actividad
                join programa on programa.id_programa = avance.id_programa
                where programa.id_programa = " . $row['id_programa'] ;
                 
                $res = $this->conexion->query($sql);
                $arreglo_fotos = array() ;
                
                if($res->num_rows > 0){
                    while( $reg = $res->fetch_assoc() ){
                        $arreglo_fotos[] = array("archivo"=>$reg['archivo'], "descripcion"=>$reg['descripcion'], "icono"=>$reg['icono'])  ;
                    }   
                }

                $tabla = "'<table><tr>" ;
				$icono_actividad = '' ;            
                foreach ($arreglo_fotos as $value) {
                    $a = preg_replace("[\n|\r|\n\r]", '', $value['descripcion']);
                    $tabla = $tabla . '<td><img src="../../avance_contrato/captura/files/'.$value['archivo'].'" style="height:350px;" > <br><center>'.$a.'</center></td>' ;
				
					if($value['icono']!='---'){
						$icono_actividad = $value['icono'] ;
					}
					
                }
                $tabla = $tabla . "</tr></table>'" ;

    /**
        Fin Bloque Fotos
    */
                      
                      $cadena = $cadena .'<div id="bodyContent" style="width:470px; overflow:auto;" >'.
                       $tabla .
                      '</div>'.
                      '</div>';



                switch ($row['estatus']) {
                    case 'PROGRAMA':
                        $this->t_programado ++ ;
                        break;
                    case 'PROCESO':
                        $this->t_proceso ++ ;
                        break;
                    case 'TERMINADO':
                        $this->t_terminado ++ ;
                        break;
                    case 'ACTA':
                        $this->t_acta ++ ;
                        break;
                }
                $this->t_puntos ++ ;
	
				
				if($icono_actividad!=''){
					$row['estatus'] = $row['estatus'] . '_' . $icono_actividad ;
				}
				

                $array[] = array( $cadena , $row['utm_n'] , $row['utm_e'], $row['estatus'], $tamanio_marker, $km ); 
            }
        }
 
          return json_encode( $array ) ;
		  //return $consultita;
			
    }

    function getAllCoord($tt, $cto){


        
        if($tt != -1){
            $sql = "SELECT 
            programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus,
            linea.nombre as nombre,
            linea.id_linea,
            contrato.numero as numero_contrato,
            orden_servicio.numero_orden  as no, 
            tipo_trabajo.descripcion as trabajo
            FROM $this->tabla 
            join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
            join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
            join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
            join linea on linea.id_linea = linea_has_contrato.id_linea
            join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
            where tipo_trabajo.id_tipo_trabajo = tt and orden_servicio.id_contrato = $cto" ;
        }
        else{
            
            $sql = "SELECT 
            programa.id_programa, programa.km_inicial, programa.km_final, programa.utm_e, programa.utm_n, programa.estatus,
            linea.nombre as nombre,
            linea.id_linea ,
            contrato.numero as numero_contrato,
            orden_servicio.numero_orden  as no, 
            tipo_trabajo.descripcion as trabajo
            FROM $this->tabla 
            join orden_servicio  on orden_servicio.id_orden_servicio = $this->tabla.id_orden_servicio 
            join tipo_trabajo on tipo_trabajo.id_tipo_trabajo = orden_servicio.id_tipo_trabajo 
            join linea_has_contrato on linea_has_contrato.id_linea_has_contrato=orden_servicio.id_linea_has_contrato
            join linea on linea.id_linea = linea_has_contrato.id_linea
            join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
            where orden_servicio.id_contrato = $cto" ;


        }

        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){

                $km = ''  ;
                if($row['km_final'] != '-'){
                    $km = $row['km_inicial'] . ' - ' . $row['km_final'] ;
                }
                else{
                    $km = $row['km_inicial'] ;
                }


                $tamanio_marker = 15 ;

                $indicaciones = '' ;
                $sql_indicacion = "select max(indicacion.porcentaje_perdida) as porcentaje, tipo_indicacion.descripcion as indicacion, indicacion.espesor_remanente as remanente, indicacion.fecha_inspeccion as fecha from indicacion join tipo_indicacion on tipo_indicacion.id_tipo_indicacion = indicacion.id_tipo_indicacion where id_programa = " . $row['id_programa'] ;
                $resultado_indicacion = $this->conexion->query($sql_indicacion);
                if($resultado_indicacion->num_rows > 0){

                    $ind_row = $resultado_indicacion->fetch_assoc() ;
                    if($ind_row['porcentaje'] > 0 ){

                        $colorFondoPorcentaje = '#000000';
                        $colorLetraPorcentaje = "#000000" ;
                        if ($ind_row['porcentaje'] >= 0 && $ind_row['porcentaje'] <=10){
                            $colorFondoPorcentaje = '#00FF00' ;
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else if ($ind_row['porcentaje'] >10 && $ind_row['porcentaje'] <=29.99){
                            $colorFondoPorcentaje = '#F9FF72';
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else if ($ind_row['porcentaje'] > 29.99 && $ind_row['porcentaje'] <=79.99){
                            $colorFondoPorcentaje = '#FCAE05';
                            $colorLetraPorcentaje = '#000' ;
                        }
                        else{
                            $colorFondoPorcentaje = '#FF0000' ;
                            $colorLetraPorcentaje = '#FFF' ;
                        }


                        if ($ind_row['porcentaje'] >= 0 && $ind_row['porcentaje'] <=20){
                            $tamanio_marker = 20 ;
                        }else if ($ind_row['porcentaje'] > 20 && $ind_row['porcentaje'] <=40){
                            $tamanio_marker = 25 ;
                        }else if ($ind_row['porcentaje'] > 40 && $ind_row['porcentaje'] <=60){
                            $tamanio_marker = 30 ;
                        }else if ($ind_row['porcentaje'] > 60 && $ind_row['porcentaje'] <80){
                            $tamanio_marker = 35 ;
                        }else if ($ind_row['porcentaje'] >= 80 ){
                            $tamanio_marker = 40 ;
                        }



                        $indicaciones = '<tr><td style="border: 1px solid #0000FF; background-color:'.$colorFondoPorcentaje.'; color:'.$colorLetraPorcentaje.';" colspan="2"><center><strong> '.$ind_row['indicacion'].' <br> Máximo porcentaje de pérdida: '. round( $ind_row['porcentaje'], 2).' % <br> Espesor remanente:'.$ind_row['remanente'].' <br> Fecha de inspección'.$ind_row['fecha'].'  </strong></center></td></tr>' ;    
                    }
                    else{
                        $indicaciones = '<tr><td style="border: 1px solid #0000FF;" colspan="2"><center><strong> Sin registro de indicaciones.  </strong></center></td></tr>' ;
                    }

                    
                }
                



                
                $cadena = '<div style="width:500px; overflow-x:hidden;">'.
                      '<div style="width:490px;" > '.
                      '<table  style="width:470px;" > 
                        <tr><td style="border: 1px solid #0000FF; background-color:#0000FF; color:#FFFFFF;" colspan="2"><center><strong>'.$row['nombre'].'</strong></center></td></tr>
                        <tr><td style="border: 1px solid #0000FF; background-color:#0000FF; color:#FFFFFF;" colspan="2"><center><strong>'.$row['numero_contrato'].'</strong></center></td></tr>
                        <tr><td style="border: 1px solid #0000FF; " colspan="2"><center><strong>'.$row['trabajo'].'</strong></center></td></tr>
                        <tr><td style="border: 1px solid #0000FF;" width:50%;"><center>'.$km.'</center></td><td style="border: 1px solid #0000FF; width:50%;"><center>'.$row['no'].'</center></td></tr>';
                      

                        $cadena = $cadena . $indicaciones ;


                      if($row['estatus'] == 'ACTA'){
                            $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong><a href="../captura/actas/260.pdf" target="_blank">ACTA</a></strong></center></td></tr>' ;
                        }
                        else{
                            $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong>'.$row['estatus'].'</strong></center></td></tr>' ;  
                        }

                        $cadena=$cadena .'<tr><td style="border: 1px solid #0000FF;" colspan="2"><center><a target="_blank" href="indicacion_tabla.php?linea='.$row['id_linea'].'&id_programa='.$row['id_programa'].'&bge=1">FICHA TÉCNICA</a></center></td></tr>';

                        
/**
        Inicio Bloque Documentos
    */
                    $sql_documentos = "select * from documento where id_programa = " . $row['id_programa'] ;
                    $resultado_documentos = $this->conexion->query($sql_documentos);

                    $no_documentos = $resultado_documentos->num_rows ;

                    if($no_documentos>0){

                        if($no_documentos == 1){
                            $row_documento = $resultado_documentos->fetch_assoc() ;
                            $cadena = $cadena . '<tr><td colspan="2" style="border: 1px solid #0000FF;"><center><strong><a href="../captura/documentos/'.$row_documento['archivo'].'" target="_blank">'.$row_documento['descripcion'].'</a></strong></center></td></tr>' ;
                        }
                        else{
                            $division = round($no_documentos / 2, 0, PHP_ROUND_HALF_UP) ;

                            $cadena = $cadena . '<tr><td style="border: 1px solid #0000FF;"><ul>' ;
                            $contador_columna = 1 ;
                            while ($row_documento = $resultado_documentos->fetch_assoc()) {
                                
                                $cadena = $cadena. '<li><a href="../captura/documentos/'.$row_documento['archivo'].'" target="_blank">'.$row_documento['descripcion'].'</a></li>' ;
                                if($contador_columna == $division){
                                    $cadena = $cadena.'</ul></td><td style="border: 1px solid #0000FF;"><ul>' ;
                                }
                                $contador_columna ++;

                            }

                        }
                    }

/**
        Fin Bloque Documentos
    */



                        $cadena = $cadena . '</table></div>' ;


/**
        Inicio Bloque Fotos
    */

                $sql = "select foto.archivo, foto.descripcion from foto
                join avance on foto.id_avance = avance.id_avance
                join programa on programa.id_programa = avance.id_programa
                where programa.id_programa = " . $row['id_programa'] ;
                 
                $res = $this->conexion->query($sql);
                $arreglo_fotos = array() ;
                
                if($res->num_rows > 0){
                    while( $reg = $res->fetch_assoc() ){
                        $arreglo_fotos[] = array("archivo"=>$reg['archivo'], "descripcion"=>$reg['descripcion'])  ;
                    }   
                }

                $tabla = "'<table><tr>" ;
            
                foreach ($arreglo_fotos as $value) {
                    $a = preg_replace("[\n|\r|\n\r]", '', $value['descripcion']);
                    $tabla = $tabla . '<td><img src="../captura/files/'.$value['archivo'].'" style="height:350px;" > <br><center>'.$a.'</center></td>' ;
                }
                $tabla = $tabla . "</tr></table>'" ;

    /**
        Fin Bloque Fotos
    */
                      
                      $cadena = $cadena .'<div id="bodyContent" style="width:470px; overflow:auto;" >'.
                       $tabla .
                      '</div>'.
                      '</div>';



                switch ($row['estatus']) {
                    case 'PROGRAMA':
                        $this->t_programado ++ ;
                        break;
                    case 'PROCESO':
                        $this->t_proceso ++ ;
                        break;
                    case 'TERMINADO':
                        $this->t_terminado ++ ;
                        break;
                    case 'ACTA':
                        $this->t_acta ++ ;
                        break;
                }
                $this->t_puntos ++ ;



                $array[] = array( $cadena , $row['utm_n'] , $row['utm_e'], $row['estatus'], $tamanio_marker, $km ); 
            }
        }
 
            return json_encode( $array ) ;
    }
	
	function getKmlContrato($id_contrato){
		if($id_contrato==-1){
			$sql = "SELECT distinct(archivo) FROM kml_contrato " ;
		} else {
			$sql = "SELECT distinct(archivo)  FROM kml_contrato where id_contrato =". $id_contrato ;
			}
        $resultado = $this->conexion->query($sql);
        $arrayActividades = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayActividades[] = $row ;
            }
            return $arrayActividades ;
        }
        else{
            return $arrayActividades ;
        }
    }
    
	
	function getAvanceProgramado(){
        $sql = "SELECT count(longitud) FROM $this->tabla where fecha_inicio < now()" ;
        $resultado = $this->conexion->query($sql);
		$longitud_programada = 0 ;
        
        if($resultado->num_rows > 0){
            $row = $resultado->fetch_array()  ;
             $longitud_programada = $row[0] ;
        }
		
		return $longitud_programada ;
    }

    function getAllByFecha(){
        $sql = "SELECT * FROM $this->tabla where fecha_inicio < now() order by id_orden_servicio, consecutivo" ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }





    function getAllReporte(){
        
        $orden = array(2,3,5,1,4,6);
        $array = array() ;

        foreach ($orden as $value) :

        $sql = "SELECT * FROM $this->tabla where id_orden_servicio = $value order by consecutivo" ;
        $resultado = $this->conexion->query($sql);
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
        }

        endforeach;
            return $array ;
    }




    
    function getByOS($os){
        $sql = "SELECT * FROM $this->tabla where id_orden_servicio = $os order by segmento " ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }

    function getByContrato($id_contrato,$estatus)
    {
            if ($estatus == -1) {
                $estatus = null;
            }

            if ($estatus == 'DOCUMENTO') 
            {
                    $sql = 
                    "
                    select DISTINCT programa.id_programa, linea.nombre as nombre_linea, programa.* 
                    from   programa, linea,orden_servicio,linea_has_contrato,documento
                    where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    programa.id_programa                 = documento.id_programa
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    orden_servicio.id_contrato           = ".$id_contrato."
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    order  by programa.id_orden_servicio, programa.segmento
                    ";    
                        $resultado = $this->conexion->query($sql);
                          //  return $sql;
                       $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
            }
            else{
                    $sql = "

                        select linea.nombre as nombre_linea, programa.* 
                        from   programa, linea,orden_servicio,linea_has_contrato
                        where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                        and    (programa.estatus                    LIKE '%".$estatus."%' OR programa.estatus is null)
                        and    orden_servicio.id_contrato           = ".$id_contrato."
                        and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                        and    linea_has_contrato.id_linea          = linea.id_linea
                        order  by programa.id_orden_servicio, programa.segmento
                        ";
                        $resultado = $this->conexion->query($sql);
                          //  return $sql;
                       $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
            }
    }

    function getByContratoSector($id_contrato,$id_sector,$estatus)
    {
            if ($estatus == -1) {
                $estatus = null;
            }

            if ($estatus == 'DOCUMENTO') 
            {
                    $sql = 
                    "
                    select DISTINCT programa.id_programa, linea.nombre as nombre_linea, programa.* 
                    from   programa, linea,orden_servicio,linea_has_contrato,documento
                    where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    programa.id_programa                 = documento.id_programa
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    orden_servicio.id_contrato           = ".$id_contrato."
                    and    orden_servicio.id_sector             = ".$id_sector."
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    order  by programa.id_orden_servicio, programa.segmento
                    ";    
                        $resultado = $this->conexion->query($sql);
                          //  return $sql;
                       $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
            }
            else{
                    $sql = "

                        select linea.nombre as nombre_linea, programa.* 
                        from   programa, linea,orden_servicio,linea_has_contrato
                        where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                        and    (programa.estatus                    LIKE '%".$estatus."%' OR programa.estatus is null)
                        and    orden_servicio.id_contrato           = ".$id_contrato."
                        and    orden_servicio.id_sector             = ".$id_sector."
                        and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                        and    linea_has_contrato.id_linea          = linea.id_linea
                        order  by programa.id_orden_servicio, programa.segmento
                        ";
                        $resultado = $this->conexion->query($sql);
                          //  return $sql;
                       $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
            }
    }

    function getByOS_($contrato,$sector,$orden_servicio,$estatus)
    {
          if ($estatus == -1)
          {
                    $estatus = null;
          }
          if ($estatus == 'DOCUMENTO')
          {
                $sql = "
                        select DISTINCT programa.id_programa, linea.nombre as nombre_linea, programa.* 
                        from   programa, linea,orden_servicio,linea_has_contrato,documento
                        where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                        and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                        and    linea_has_contrato.id_linea          = linea.id_linea
                        and    orden_servicio.id_contrato           = ".$contrato."
                        and    orden_servicio.id_sector             = ".$ector."
                        and    programa.id_orden_servicio           = ".$orden_servicio."
                        and    programa.id_programa                 = documento.id_programa
                        order  by programa.id_orden_servicio, programa.segmento
                        ";
                    $resultado = $this->conexion->query($sql);
                    $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc())
                        {
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
          }else{
                    $sql = 
                    "
                    select linea.nombre as nombre_linea, programa.* 
                    from   programa, linea,orden_servicio,linea_has_contrato
                    where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    and    orden_servicio.id_contrato           = ".$contrato."
                    and    orden_servicio.id_sector             = ".$sector."
                    and    programa.id_orden_servicio           = ".$orden_servicio."
                    and   (programa.estatus                     LIKE '%".$estatus."%'         OR programa.estatus is null)
                    order  by programa.id_orden_servicio, programa.segmento
                    ";
                    
                    $resultado = $this->conexion->query($sql);
                    $array = array() ;
                    
                    if($resultado->num_rows > 0){
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
          }
    }

     function getByOS_P($contrato,$orden_servicio,$estatus)
    {
          if ($estatus == -1)
          {
                    $estatus = null;
          }
          if ($estatus == 'DOCUMENTO')
          {
                $sql = "
                        select DISTINCT programa.id_programa, linea.nombre as nombre_linea, programa.* 
                        from   programa, linea,orden_servicio,linea_has_contrato,documento
                        where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                        and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                        and    linea_has_contrato.id_linea          = linea.id_linea
                        and    orden_servicio.id_contrato           = ".$contrato."
                        and    programa.id_orden_servicio           = ".$orden_servicio."
                        and    programa.id_programa                 = documento.id_programa
                        order  by programa.id_orden_servicio, programa.segmento
                        ";
                    $resultado = $this->conexion->query($sql);
                    $array = array() ;
                    if($resultado->num_rows > 0)
                    {
                        while( $row = $resultado->fetch_assoc())
                        {
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
          }else{
                    $sql = 
                    "
                    select linea.nombre as nombre_linea, programa.* 
                    from   programa, linea,orden_servicio,linea_has_contrato
                    where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    and    orden_servicio.id_contrato           = ".$contrato."
                    and    programa.id_orden_servicio           = ".$orden_servicio."
                    and   (programa.estatus                     LIKE '%".$estatus."%'         OR programa.estatus is null)
                    order  by programa.id_orden_servicio, programa.segmento
                    ";
                    
                    $resultado = $this->conexion->query($sql);
                    $array = array() ;
                    
                    if($resultado->num_rows > 0){
                        while( $row = $resultado->fetch_assoc() ){
                            $array[] = $row ;
                        }
                        return $array ;
                    }
                    else{
                        return $array ;
                    }
          }
    }





    function getByEstatus($estatus)
    {

      if($estatus == -1)
      {
                $estatus = null;
      }

      if ($estatus == 'DOCUMENTO') 
      {
            $sql = "
                    select DISTINCT programa.id_programa,linea.nombre as nombre_linea, programa.* 
                    from   programa, documento, linea,orden_servicio,linea_has_contrato
                    where  programa.id_programa                 = documento.id_programa
                    and    programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    order by programa.id_programa
                    " ;
                $resultado = $this->conexion->query($sql);
                $array = array() ;
                
                if($resultado->num_rows > 0)
                {
                    while( $row = $resultado->fetch_assoc() )
                    {
                        $array[] = $row ;
                    }
                    return $array;
                }
                else{
                    return $array ;
                }
      }else{
                $sql = "

                    select linea.nombre as nombre_linea, programa.* 
                    from   programa, linea,orden_servicio,linea_has_contrato
                    where  programa.estatus like '%".$estatus."%' 
                    and    programa.id_orden_servicio           = orden_servicio.id_orden_servicio
                    and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                    and    linea_has_contrato.id_linea          = linea.id_linea
                    order by programa.id_orden_servicio, programa.segmento
                 " ;
                $resultado = $this->conexion->query($sql);
                $array = array() ;
                
                if($resultado->num_rows > 0)
                {
                    while( $row = $resultado->fetch_assoc() )
                    {
                        $array[] = $row ;
                    }
                    return $array;
                }
                else{
                    return $array ;
                }
        }
    }


     function getPuntosContratoLinea($id_linea, $id_contrato, $id_tipo_trabajo){
        if ($id_contrato<>-1) {
            $wer=' and orden_servicio.id_contrato='.$id_contrato;
        } else {
            $wer='';
        }

        if ($id_tipo_trabajo<>-1) {
            $wer2= ' and orden_servicio.id_tipo_trabajo='.$id_tipo_trabajo;
        } else {
            $wer2='';
        }

        $sql = "select * FROM $this->tabla 
        inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
        inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
        where linea_has_contrato.id_linea=".$id_linea.$wer.$wer2 ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }


    function getGraficaPtoMap($id_programa){
        $sql = "select  programa.id_programa, programa.km_inicial, programa.km_final, foto.archivo, foto.descripcion, foto.fecha FROM $this->tabla 
        inner join avance on programa.id_programa = avance.id_programa
        inner join foto on avance.id_avance = foto.id_avance
        where programa.id_programa=".$id_programa ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }

    function getGraficaPtoDocumento($id_programa){
        $sql = "select * FROM documento  where id_programa=".$id_programa ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }

    function getActaPunto($id_programa){
        $sql = "select * FROM acta_reparacion where id_programa=".$id_programa ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }

    function getIconoPunto($id_programa){
        $sql = "select * FROM $this->tabla "
        ."inner join avance on programa.id_programa = avance.id_programa "
        ."inner join actividad on avance.id_actividad = actividad.id_actividad "
        ." where programa.id_programa=".$id_programa ." and actividad.icono <>'---'";
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }




    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }
    
    function getId(){
        return $this->id;
    }

    function getConsecutivo(){
        return $this->consecutivo ;
    }
    
    function getKmInicial(){
        return $this->km_inicial;
    }
    
    function getKmFinal(){
        return $this->km_final ;
    }
    
    function getLongitud(){
        return $this->longitud ;
    }
    
    function getTipoZona(){
        return $this->tipo_zona ;
    }
    
    function getFechaIicio(){
        return $this->fecha_inicio ;
    }
    
    function getFechaFin(){
        return $this->fecha_fin ;
    }
    
    function getFechaIicioReal(){
        return $this->fecha_inicio_real ;
    }
    
    function getFechaFinReal(){
        return $this->fecha_fin_real ;
    }
    
    function getUtm_n(){
        return $this->utm_n ;
    }
    
    function getUtm_e(){
        return $this->utm_e;
    }
    
    function getEstatus(){
        return $this->estatus ;
    }
    
    function getCoordinador(){
        return $this->coordinador;
    }
    
    function getPermisoPaso(){
        return $this->permiso_paso;
    }
    
    function getOrdenServicio(){
        return $this->orden_servicio;
    }

    function getSegmento(){
        return $this->segmento ;
    }

    function getObservaciones(){
        return $this->observaciones ;
    }
}
?>