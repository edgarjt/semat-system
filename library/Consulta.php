<?php
	include_once ("Database.php");
	class Consulta{

		private $conexion = '' ;

		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
		}

//---------------------consulta RLC---------------------------
		function getConsulta_avance($id_contrato, $subdireccion, $id_tipo_trabajo, $id_compania)
		{
                    $condition = "where" ;
                                                        
                    if($id_contrato != -1){
                        if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                            $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                        }
                        else {
                            $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                        }

                    }

                    if($subdireccion != -1){
                        if($id_tipo_trabajo!=-1){
                            $condition = $condition." contrato.subdireccion = '$subdireccion' and" ;
                        }
                        else{
                            $condition = $condition." contrato.subdireccion = '$subdireccion' " ;
                        }

                    }

                    if($id_tipo_trabajo != -1){
                        $condition = $condition." tipo_trabajo.id_tipo_trabajo = $id_tipo_trabajo" ;
                    }
					
					 if($id_compania != -1){
						if($id_tipo_trabajo != -1 or $subdireccion != -1 or $id_contrato != -1 ){
							$condition = $condition." and compania.id_compania = $id_compania" ;
						}  else
						{
						  $condition = $condition." compania.id_compania = $id_compania" ;
						}
                    }


                    $sql = 
                    "
                    select programa.id_programa, programa.segmento, programa.km_inicial, programa.km_final, programa.fecha_fin_real, programa.longitud, programa.utm_n, programa.utm_e, programa.estatus, programa.docto, 
                    orden_servicio.numero_orden, linea.nombre,compania.id_compania, compania.icono, compania.alias, 
                    linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real, tipo_trabajo.id_tipo_trabajo, tipo_trabajo.descripcion, ddv.id_ddv, ddv.alias, contrato.numero
                    from programa
                    inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
                    inner join contrato on coordinador.id_contrato = contrato.id_contrato 
                    inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                    inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
                    inner join linea on linea_has_contrato.id_linea = linea.id_linea 
                    inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
                    inner join ddv on linea.id_ddv = ddv.id_ddv
					inner join compania on contrato.id_compania = compania.id_compania
                    " ;

                    if($condition != 'where') {

                        $sql = $sql . $condition ;

                    }
					
                    
                   // echo "<br><br>".$sql."<br><br>" ;
                    	
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
                                    
                                    $row['porcentaje_perdida'] = 0 ;
                                        $row['tipo_indicacion'] = 'NO HAY REGISTRO DE INDICACIONES' ;
                                        $row['espesor'] = '-' ;
                                        $row['fecha_inspeccion'] = '-' ;
                                    
                                    
                                    $sql = "select i.id_indicacion as id, i.espesor_remanente as espesor, i.fecha_inspeccion as fecha, max(i.porcentaje_perdida)as porcentaje_perdida, t.descripcion as descripcion from indicacion as i 
                                            join tipo_indicacion as t
                                                on t.id_tipo_indicacion = i.id_tipo_indicacion
                                            where t.evaluacion = 1 and id_programa = " . $row['id_programa'] ;
                                    
                                   // echo $sql ;
                                    $res2 = $this->conexion->query($sql);
                                    
                                    
                                    
                                    if ($res2->num_rows>0){
                                        $r = $res2->fetch_assoc() ;
                                        if($r['descripcion'] != ''){
                                            $row['porcentaje_perdida'] = number_format($r['porcentaje_perdida'], 2)  ;
                                            $row['tipo_indicacion'] = $r['descripcion'] ;
                                            $row['espesor'] = $r['espesor'] ;
                                            $row['fecha_inspeccion'] = $r['fecha'] ;
                                        }
                                        
                                        
                                    }
                                    
                                  //  echo $row['tipo_indicacion'] . '......' . $row['id_programa'] . '.....' . $r['descripcion'] . '<br>' ;
                                    
                                    
					$contratos[] = $row ;
				}
			}
			return $contratos ;
		}
                
		function getConsulta_avance2($id_contrato, $subdireccion, $id_tipo_trabajo, $id_coordinador)
		{
                    $condition = "where" ;
                                                        
                    if($id_contrato != -1){
                        if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                            $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                        }
                        else {
                            $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                        }

                    }

                    if($subdireccion != -1){
                        if($id_tipo_trabajo!=-1){
                            $condition = $condition." orden_servicio.id_orden_servicio = '$subdireccion' and" ;
                        }
                        else{
                            $condition = $condition." orden_servicio.id_orden_servicio = '$subdireccion' " ;
                        }

                    }

                    if($id_tipo_trabajo != -1){
                        $condition = $condition." tipo_trabajo.id_tipo_trabajo = $id_tipo_trabajo" ;
                    }
					
					if($id_coordinador != -1){
                        $condition = $condition." and coordinador.id_coordinador = $id_coordinador" ;
                    }


                    $sql = 
                    "
                    select programa.id_programa, programa.segmento, programa.km_inicial, programa.km_final, programa.fecha_fin_real, programa.longitud, programa.utm_n, programa.utm_e, programa.estatus, programa.docto, 
                    orden_servicio.numero_orden, linea.nombre,
                    linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real, tipo_trabajo.id_tipo_trabajo, tipo_trabajo.descripcion, ddv.id_ddv, ddv.alias, contrato.numero
                    from programa
                    inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
                    inner join contrato on coordinador.id_contrato = contrato.id_contrato 
                    inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                    inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
                    inner join linea on linea_has_contrato.id_linea = linea.id_linea 
                    inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
                    inner join ddv on linea.id_ddv = ddv.id_ddv
                    " ;

                    if($condition != 'where') {

                        $sql = $sql . $condition ;

                    }
					
                    
                   // echo "<br><br>".$sql."<br><br>" ;
                    	
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
                                    
                                    $row['porcentaje_perdida'] = 0 ;
                                        $row['tipo_indicacion'] = 'NO HAY REGISTRO DE INDICACIONES' ;
                                        $row['espesor'] = '-' ;
                                        $row['fecha_inspeccion'] = '-' ;
                                    
                                    
                                    $sql = "select i.id_indicacion as id, i.espesor_remanente as espesor, i.fecha_inspeccion as fecha, max(i.porcentaje_perdida)as porcentaje_perdida, t.descripcion as descripcion from indicacion as i 
                                            join tipo_indicacion as t
                                                on t.id_tipo_indicacion = i.id_tipo_indicacion
                                            where t.evaluacion = 1 and id_programa = " . $row['id_programa'] ;
                                    
                                   // echo $sql ;
                                    $res2 = $this->conexion->query($sql);
                                    
                                    
                                    
                                    if ($res2->num_rows>0){
                                        $r = $res2->fetch_assoc() ;
                                        if($r['descripcion'] != ''){
                                            $row['porcentaje_perdida'] = number_format($r['porcentaje_perdida'], 2)  ;
                                            $row['tipo_indicacion'] = $r['descripcion'] ;
                                            $row['espesor'] = $r['espesor'] ;
                                            $row['fecha_inspeccion'] = $r['fecha'] ;
                                        }
                                        
                                        
                                    }
                                    
                                  //  echo $row['tipo_indicacion'] . '......' . $row['id_programa'] . '.....' . $r['descripcion'] . '<br>' ;
                                    
                                    
					$contratos[] = $row ;
				}
			}
			return $contratos ;
		}
		
		
		
		
		function getConsultaLineaByPrograma($id_programa){

							$sql = 
							"
							select linea.nombre as linea
							from programa,orden_servicio,linea_has_contrato,linea
							where programa.id_orden_servicio = orden_servicio.id_orden_servicio
							and orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							and linea_has_contrato.id_linea = linea.id_linea
							and programa.id_programa = ".$id_programa."
							";			
			
							$resultado = $this->conexion->query($sql) ;
							$row = $resultado->fetch_assoc();
							$num = $row['linea'];
							
							return $num ;
		}


		function getConsultaLineaDetallesUT($id_linea,$id_contrato, $id_orden_servicio, $id_tipo_trabajo)
		{
							$wer="";
							if ($id_contrato<>-1) {
								$wer= "Where contrato.id_contrato= ".$id_contrato;

								if ($id_orden_servicio<>-1) {
									$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
								}

								if ($id_tipo_trabajo<>-1) {
									$wer= $wer." And tipo_trabajo.id_tipo_trabajo= ".$id_tipo_trabajo;
								}
							} else {
								if ($id_tipo_trabajo<>-1) {
									$wer= " Where tipo_trabajo.id_tipo_trabajo= ".$id_tipo_trabajo;
								}
							}
							$sql = 
							"
							select programa.id_programa, programa.segmento, programa.km_inicial, programa.km_final, programa.fecha_fin_real, programa.longitud, programa.utm_n, programa.utm_e, programa.estatus, programa.docto, 
							orden_servicio.numero_orden, linea.nombre,
							linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real, tipo_trabajo.id_tipo_trabajo, tipo_trabajo.descripcion, ddv.id_ddv, ddv.alias
							from programa
							inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
							inner join contrato on coordinador.id_contrato = contrato.id_contrato 
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
							inner join linea on linea_has_contrato.id_linea = linea.id_linea 
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							inner join ddv on linea.id_ddv = ddv.id_ddv
							".$wer;
							
							
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
		}

		function getConsulta_avance_estatus($id_contrato, $id_orden_servicio, $estatus)
		{
							$wer="";
							if ($id_contrato<>-1) {
								$wer= "Where contrato.id_contrato= ".$id_contrato;

								if ($id_orden_servicio<>-1) {
								$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
								}
							}

							if ($wer=="") {
								$wer= "Where estatus='".$estatus."'";
							} else { 
								$wer= $wer." And estatus= '".$estatus."'"; 
									}
							$sql = 
							"
							select programa.id_programa, programa.segmento, programa.km_inicial, programa.km_final, programa.fecha_fin_real, programa.utm_n, programa.utm_e, programa.longitud, programa.estatus, programa.docto, orden_servicio.numero_orden, linea.nombre,
							linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real
							from programa
							inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
							inner join contrato on coordinador.id_contrato = contrato.id_contrato 
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
							inner join linea on linea_has_contrato.id_linea = linea.id_linea 
							".$wer;
							
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}
			
			
			function getConsulta_avance_pemex($id_contrato, $id_orden_servicio)
				{
							$wer="";
							if ($id_contrato<>-1) {
								$wer= "Where contrato.id_contrato= ".$id_contrato;

								if ($id_orden_servicio<>-1) {
								$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
								}
							}
							$sql = 
							"
							select programa.id_programa, programa.fecha_inicio, programa.fecha_fin, programa.km_inicial, programa.km_final, programa.utm_n, programa.utm_e, programa.estatus, programa.segmento, programa.longitud, orden_servicio.numero_orden, linea.nombre,
							linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real
							from programa
							inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
							inner join contrato on coordinador.id_contrato = contrato.id_contrato 
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
							inner join linea on linea_has_contrato.id_linea = linea.id_linea 
							".$wer;
							
							
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}

				function getConsulta_avance_pemex_estatus($id_contrato, $id_orden_servicio, $estatus)
				{
							$wer="";
							if ($id_contrato<>-1) {
								$wer= "Where contrato.id_contrato= ".$id_contrato;

								if ($id_orden_servicio<>-1) {
								$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
								}
							}

							if ($wer=="") {
								$wer= "Where estatus='".$estatus."'";
							} else { 
								$wer= $wer." And estatus= '".$estatus."'"; 
									}
							$sql = 
							"
							select programa.id_programa, programa.fecha_inicio, programa.fecha_fin, programa.km_inicial, programa.km_final, programa.utm_n, programa.utm_e, programa.estatus, programa.segmento, programa.longitud, orden_servicio.numero_orden, linea.nombre,
							linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real
							from programa
							inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
							inner join contrato on coordinador.id_contrato = contrato.id_contrato 
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
							inner join linea on linea_has_contrato.id_linea = linea.id_linea 
							".$wer;
							
							
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}



			function getConsulta_avance_detalle($id_programa)
				{
							
							$sql = 
							"
							select avance.fecha, foto.descripcion, foto.archivo, actividad.icono, actividad.id_actividad
							from avance
							inner join foto on avance.id_avance = foto.id_avance
							inner join actividad on actividad.id_actividad = avance.id_actividad
							Where avance.id_programa =".$id_programa ." order by foto.id_foto";
							//Where avance.id_programa =".$id_programa ." order by actividad.orden";
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}
			
			function getConsulta_acta($id_programa)
				{
							
							$sql = 
							"
							select acta_reparacion.id_acta_reparacion, acta_reparacion.numero, acta_reparacion.archivo
							from acta_reparacion
							Where acta_reparacion.id_programa =".$id_programa;

			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}



			function getConsulta_docto($id_programa)
				{
							
							$sql = 
							"select documento.id_documento, documento.descripcion, documento.archivo, documento.id_programa
							from documento
							Where documento.id_programa =".$id_programa;

			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}


			function getConsulta_avance_diario($id_contrato, $id_orden_servicio, $fecha_inicial, $fecha_final)
				{
							$wer="";
							if ($id_contrato<>-1) {
								$wer= "Where contrato.id_contrato= ".$id_contrato;

								if ($id_orden_servicio<>-1) {
								$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
								}
							}
							$sql = 
							"
							select avance.id_avance, avance.descripcion
							from avance
							inner join programa on avance.id_programa = programa.id_programa
							inner join actividad on avance.id_actividad = actividad.id_actividad
							inner join disciplina on actividad.id_disciplina = disciplina.id_disciplina
							".$wer;
							
							
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}

			function getConsulta_porcentaje($id_programa, $id_actividad)
				{
							
							$sql = 
							"
							select avance.porcentaje as p
							from avance
							where avance.id_avance=(SELECT MAX(id_avance) from avance where avance.id_programa=".$id_programa." and avance.id_actividad=".$id_actividad.")";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			function getConsulta_porcentaje2($id_programa, $id_actividad)
				{
							
							$sql = 
							"
							select avance.longitud as p
							from avance
							where avance.id_avance=(SELECT MAX(id_avance) from avance where avance.id_programa=".$id_programa." and avance.id_actividad=".$id_actividad.")";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			function getConsultaFechaBitacora($id_programa)
				{
							
							$sql = 
							"
							select avance_bitacora.fecha_edicion as p
							from avance_bitacora
							where avance_bitacora.id_avance_bitacora=(SELECT MAX(id_avance_bitacora) from avance_bitacora where avance_bitacora.id_programa=".$id_programa.")";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			function getConsultaFechaExcavacion($id_programa)
				{
							
							$sql = 
							"
							SELECT avance.fecha as p FROM programa
								inner join avance on programa.id_programa = avance.id_programa
								where programa.id_programa =" .$id_programa ." and avance.id_actividad=5";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			
			function getConsulta_estatus($id_programa)
				{
							
							$sql = 
							"
							select programa.estatus as p
							from programa
							where programa.id_programa=".$id_programa;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getConsulta_actividad_actual($id_programa)
				{
							
							$sql = 
							"
							SELECT MAX(actividad.orden) as p
								from actividad
								inner join avance on actividad.id_actividad= avance.id_actividad
								where avance.id_programa=".$id_programa;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getConsulta_actividad_actual_2($orden)
				{
							
							$sql = 
							"
							SELECT descripcion as p
								from actividad
								where orden=".$orden;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getCuentaActividades()
				{
							
							$sql = 
							"
							SELECT COUNT(descripcion) as p
								from actividad
								";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			
			function getConsulta_acta_2($id_programa)
				{
							
							$sql = 
							"
							select archivo as p
							from acta_reparacion
							where id_programa=".$id_programa;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getConsulta_Actividad_No_Aplica($id_programa, $id_actividad)
				{
							
							$sql = 
							"
							select id_actividad_no_aplica as p
							from actividad_no_aplica
							where id_programa=".$id_programa." and id_actividad= ". $id_actividad;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getConsulta_Actividad_No_Aplica_Conta($id_programa)
				{
							
							$sql = 
							"
							select COUNT(id_actividad_no_aplica) as p
							from actividad_no_aplica
							where id_programa=".$id_programa;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

			function getConsulta_actividad_resumen()
				{
							
							$sql = 
							"
							select * from actividad
							
							Where resumen_ejecutivo =1";

			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$contratos[] = $row ;
				}
			}
			return $contratos ;
			//return $sql;
			}

			function getConsulta_actividad_disciplina($descripcion, $id_tipo_trabajo, $id_contrato, $subdireccion)
				{
					$num=-1;
                                        $condition = "and" ;
                                                        
                                                        if($id_contrato != -1){
                                                            if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                                                            }
                                                            else {
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                                                            }
                                                            
                                                        }
                                                        
                                                        if($subdireccion != -1){
                                                            if($id_tipo_trabajo!=-1){
                                                                $condition = $condition." contrato.subdireccion = '$subdireccion' and" ;
                                                            }
                                                            else{
                                                                $condition = $condition." contrato.subdireccion = '$subdireccion' " ;
                                                            }
                                                            
                                                        }
                                                        
                                                        if($id_tipo_trabajo != -1){
                                                            $condition = $condition." tipo_trabajo.descripcion = '$id_tipo_trabajo'" ;
                                                        }
                                                        
                                                        $sql = 
							"
							select SUM(avance.longitud) as p
							from avance
							join actividad on avance.id_actividad = actividad.id_actividad
							join programa on avance.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                                                        join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
							Where actividad.descripcion ='".$descripcion."' "; 
                                                        
                                                        if($condition != 'and') {
                                                            
                                                            $sql = $sql . $condition ;
                                                            
                                                        }
                                        
					$resultado = $this->conexion->query($sql) ;

					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
					
					
					return $num ;

				}


                                
                                
				function getConsulta_actividad_ddv($descripcion, $id_ddv, $id_contrato, $subdireccion)
				{
					$num=-1;
                                        
                                        

                                        $condition = "and" ;
                                                        
                                                        if($id_contrato != -1){
                                                            if($subdireccion != -1 ){
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                                                            }
                                                            else {
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                                                            }
                                                            
                                                        }
                                                        
                                                        if($subdireccion != -1){

                                                                $condition = $condition." contrato.subdireccion = '$subdireccion' " ;                                                            
                                                        }
                                                        
   

							$sql = 
							"
							select COUNT(programa.id_programa) as p
							from programa
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                                                        join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
							inner join linea on linea_has_contrato.id_linea = linea.id_linea
							inner join ddv on linea.id_ddv = ddv.id_ddv
							Where tipo_trabajo.descripcion ='".$descripcion."' and ddv.alias='".$id_ddv."' "; 
                                                        
                                                        if($condition != 'and') {
                                                            
                                                            $sql = $sql . $condition ;
                                                            
                                                        }
                                        
                                        
                                        
                                       // echo $sql ;
                                        
                                        
                                        
                                        
                                        
        /*                                

							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and linea_has_contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}
							
							$sql = 
							"
							select COUNT(programa.id_programa) as p
							from programa
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							inner join linea on linea_has_contrato.id_linea = linea.id_linea
							inner join ddv on linea.id_ddv = ddv.id_ddv
							Where tipo_trabajo.descripcion='".$descripcion."' and ddv.alias='".$id_ddv."'".$wer;
                                                        
*/
					$resultado = $this->conexion->query($sql) ;
					
					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
					return $num ;
				//return $sql;
				}

				function getConsulta_actividad_ddv2($id_ddv, $id_contrato, $subdireccion, $id_tipo_trabajo)
				{
					$num=-1;
                                        
                                        
                                        
                                         $condition = "and" ;
                                                        
                                                        if($id_contrato != -1){
                                                            if($subdireccion != -1 ){
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                                                            }
                                                            else {
                                                                $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                                                            }
                                                            
                                                        }
                                                        
                                                        if($subdireccion != -1){

                                                                $condition = $condition." contrato.subdireccion = '$subdireccion' " ;                                                            
                                                        }
                                                        
   

							$sql = 
							"
							select COUNT(programa.id_programa) as p
							from programa
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                                                        inner join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
							inner join linea on linea_has_contrato.id_linea = linea.id_linea
							inner join ddv on linea.id_ddv = ddv.id_ddv
							Where ddv.alias='".$id_ddv."' "; 
                                                        
                                                        if($condition != 'and') {
                                                            
                                                            $sql = $sql . $condition ;
                                                            
                                                        }
                                        
                                          
                                        
                      

					$resultado = $this->conexion->query($sql) ;
					
                                        

                                        
                                        
                                        
					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
				return $num ;
				//return $sql;
				}

                                
                                
				function getConsulta_actividad_ddv_total($id_contrato, $subdireccion, $id_tipo_trabajo)
				{
					$num=-1;

                                                        $condition = "where" ;
                                                        
                                                        if($id_contrato != -1){
                                                            if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                                                                $condition = $condition . " c.id_contrato = $id_contrato and"  ; 
                                                            }
                                                            else {
                                                                $condition = $condition . " c.id_contrato = $id_contrato "  ; 
                                                            }
                                                            
                                                        }
                                                        
                                                        if($subdireccion != -1){
                                                            if($id_tipo_trabajo!=-1){
                                                                $condition = $condition." c.subdireccion = '$subdireccion' and" ;
                                                            }
                                                            else{
                                                                $condition = $condition." c.subdireccion = '$subdireccion' " ;
                                                            }
                                                            
                                                        }
                                                        
                                                        if($id_tipo_trabajo != -1){
                                                            $condition = $condition." tipo_trabajo.id_tipo_trabajo = $id_tipo_trabajo" ;
                                                        }
                                                        
                                                        
                                                        
                                                        
                                                        $sql = ""
                                                                . "select COUNT(programa.id_programa) as p
							from programa
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
							inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							inner join linea on linea_has_contrato.id_linea = linea.id_linea
							inner join ddv on linea.id_ddv = ddv.id_ddv
                                                        inner join contrato as c on c.id_contrato = linea_has_contrato.id_contrato " ;
                                                        
                                                        if($condition != 'where') {
                                                            
                                                            $sql = $sql . $condition ;
                                                            
                                                        }


					$resultado = $this->conexion->query($sql) ;
					//echo $sql ;
					if ($resultado->num_rows>0) {
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
				return $num ;
				//return $sql;
				}
                                
                                

				function getPuntoLinea($id_ducto, $id_contrato, $id_tipo_trabajo, $id_compania)
				{
					$num=-1;
					$bandera=0;
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and linea_has_contrato.id_contrato='.$id_contrato;
							}

							if ($id_tipo_trabajo==- 1) {
								$wer2='';
							} else {
								$wer2= ' and orden_servicio.id_tipo_trabajo='.$id_tipo_trabajo; 
							}
							
							if ($id_compania==-1) {
								$wer3='';
							} else {
								$wer3= ' and compania.id_compania='.$id_compania;
							}

							

							$sql ="select count(programa.id_programa) as p
							from programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							join contrato on contrato.id_contrato = linea_has_contrato.id_contrato
							join compania on compania.id_compania = contrato.id_compania
							where linea_has_contrato.id_linea=".$id_ducto.$wer.$wer2.$wer3;

					$resultado = $this->conexion->query($sql) ;
                                       // echo $sql ;
					
					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
				return $num ;
				//return $sql;
				}


				function getConsulta_actividad_ducto($id_linea, $id_contrato, $id_tipo_trabajo,$id_actividad, $id_compania)
				{
					$num=-1;
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and l.id_contrato='.$id_contrato;
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tt.id_tipo_trabajo='.$id_tipo_trabajo;
							}
							
							if ($id_compania==-1) {
								$wer3='';
							} else {
								$wer3= ' and cia.id_compania='.$id_compania;
							}

							$sql = 
							"
							select SUM(a.longitud) as p from actividad as ac
							join avance as a on a.id_actividad = ac.id_actividad
							join programa as p on a.id_programa = p.id_programa
							join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
							join tipo_trabajo as tt on os.id_tipo_trabajo = tt.id_tipo_trabajo
							join linea_has_contrato as l on l.id_linea_has_contrato = os.id_linea_has_contrato
							join contrato as c on c.id_contrato = l.id_contrato
							join compania as cia on cia.id_compania = c.id_compania
							Where l.id_linea=".$id_linea.$wer.$wer2.$wer3.' and ac.id_actividad='.$id_actividad;

					$resultado = $this->conexion->query($sql) ;
				
					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
				return $num ;
				//return $sql;
				}

				function getConsulta_actividad_ducto_total($id_contrato, $id_tipo_trabajo,$id_actividad, $subdireccion)
				{
					$num=-1;
					
                                        
                                        $condition = "where" ;
                                                        
                                                        if($id_contrato != -1){
                                                            if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                                                                $condition = $condition . " c.id_contrato = $id_contrato and"  ; 
                                                            }
                                                            else {
                                                                $condition = $condition . " c.id_contrato = $id_contrato "  ; 
                                                            }
                                                            
                                                        }
                                                        
                                                        if($subdireccion != -1){
                                                            if($id_tipo_trabajo!=-1){
                                                                $condition = $condition." c.subdireccion = '$subdireccion' and" ;
                                                            }
                                                            else{
                                                                $condition = $condition." c.subdireccion = '$subdireccion' " ;
                                                            }
                                                            
                                                        }
                                                        
                                                        if($id_tipo_trabajo != -1){
                                                            $condition = $condition." tt.id_tipo_trabajo = $id_tipo_trabajo" ;
                                                        }
                                                        
                                                        
                                                        
                                                        
                                                        $sql = "select SUM(a.longitud) as p from actividad as ac
							join avance as a on a.id_actividad = ac.id_actividad
							join programa as p on a.id_programa = p.id_programa
							join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
							join tipo_trabajo as tt on os.id_tipo_trabajo = tt.id_tipo_trabajo
							join linea_has_contrato as l on l.id_linea_has_contrato = os.id_linea_has_contrato
                                                        join contrato as c on c.id_contrato = l.id_linea_has_contrato 
                                                        " ;
                                                        
                                                        if($condition != 'where') {
                                                            
                                                            $sql = $sql . $condition ;
                                                            
                                                        }
                                        
                                        
                                        
                                        
                                      
                                        
                                        
                                        /*
                                        
                                        if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and l.id_contrato='.$id_contrato;
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tt.id_tipo_trabajo='.$id_tipo_trabajo;
							}

							$sql = 
							"
							select SUM(a.longitud) as p from actividad as ac
							join avance as a on a.id_actividad = ac.id_actividad
							join programa as p on a.id_programa = p.id_programa
							join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
							join tipo_trabajo as tt on os.id_tipo_trabajo = tt.id_tipo_trabajo
							join linea_has_contrato as l on l.id_linea_has_contrato = os.id_linea_has_contrato
							and ac.id_actividad=".$id_actividad.$wer.$wer2;
                                                        
                                                        */
                                                        
                                                        

					$resultado = $this->conexion->query($sql) ;
				
					if ($resultado->num_rows>0) {
						# code...
						$row = $resultado->fetch_assoc();
						$num= $row['p'];
					}
				return $num ;
				//return $sql;
				}


//---------------------fin consulta RLC-----------------------


function getJson($id_contrato, $id_orden_servicio){
			return json_encode($this->getConsulta_avance($id_contrato, $id_orden_servicio), true);
		}

function getJsonAvance($id_programa){
			return json_encode($this->getConsulta_avance_detalle($id_programa), true);
		}
//-----------------------------segunda etapa-----------------------------------------
function getAvance_fisico($id_actividad, $id_contrato, $id_orden_servicio)
{
					$wer="Where programa.estatus <> 'PROGRAMA' and actividad.id_actividad= ".$id_actividad;
					if ($id_contrato<>-1)
					{
						$wer = $wer." And contrato.id_contrato= ".$id_contrato;

						if ($id_orden_servicio<>-1)
						{
							$wer= $wer." And programa.id_orden_servicio= ".$id_orden_servicio;
						}
					}
					$wer = $wer." order by programa.id_programa, actividad.id_actividad, avance.id_avance desc";
					$sql = 
					"
					select programa.id_programa, avance.id_avance, avance.id_actividad, avance.longitud, actividad.descripcion
					from programa 
					inner join avance on programa.id_programa = avance.id_programa
					inner join actividad on avance.id_actividad = actividad.id_actividad
					inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
					inner join contrato on orden_servicio.id_contrato= contrato.id_contrato
					".$wer;
										
	$resultado = $this->conexion->query($sql) ;
	$contratos = array() ;
	if($resultado->num_rows>0)
	{
		while ($row = $resultado->fetch_assoc())
		{
			$contratos[] = $row ;
		}
	}
	return $contratos ;
	//return $sql;
}

	function getAvance_fisico_grafica($id_actividad, $id_contrato)
		{
					$wer="Where programa.estatus <> 'PROGRAMA' and actividad.id_actividad= ".$id_actividad;
					if ($id_contrato<>-1) {
						$wer= $wer." And contrato.id_contrato= ".$id_contrato;
					}
					$wer= $wer." order by programa.id_programa, actividad.id_actividad, avance.id_avance desc";
					$sql = 
					"
					select programa.id_programa, avance.id_avance, avance.id_actividad, avance.longitud, actividad.descripcion
					from programa 
					inner join avance on programa.id_programa = avance.id_programa
					inner join actividad on avance.id_actividad = actividad.id_actividad
					inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
					inner join contrato on orden_servicio.id_contrato= contrato.id_contrato
					".$wer;
					
					
	$resultado = $this->conexion->query($sql) ;
	$contratos = array() ;
	if($resultado->num_rows>0)
	{
		while ($row = $resultado->fetch_assoc())
		{
			$contratos[] = $row ;
		}
	}
	return $contratos ;
	//return $sql;
	}

	function getAvance_fisico_grafica_coordinador($id_actividad, $id_contrato)
		{
					$wer="Where programa.estatus <> 'PROGRAMA' and actividad.id_actividad= ".$id_actividad;
					if ($id_contrato<>-1) {
						$wer= $wer." And coordinador.id_coordinador= ".$id_contrato;
					}
					$wer= $wer." order by programa.id_programa, actividad.id_actividad, avance.id_avance desc";
					$sql = 
					"
					SELECT avance.longitud, avance.id_avance, avance.descripcion, programa.id_programa, coordinador.id_coordinador, actividad.id_actividad, actividad.descripcion
					FROM avance 
					inner join programa on avance.id_programa = programa.id_programa
					inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
					inner join actividad on avance.id_actividad = actividad.id_actividad
					".$wer;
					
					
	$resultado = $this->conexion->query($sql) ;
	$contratos = array() ;
	if($resultado->num_rows>0)
	{
		while ($row = $resultado->fetch_assoc())
		{
			$contratos[] = $row ;
		}
	}
	return $contratos ;
	//return $sql;
	}


	function getDanger()
		{
					$sql = 
					"
					SELECT * FROM programa where ESTATUS<>'ACTA' and estatus<>'terminado' and estatus <> 'programa'
					";		
	$resultado = $this->conexion->query($sql) ;
	$contratos = array() ;
	if($resultado->num_rows>0)
	{
		while ($row = $resultado->fetch_assoc())
		{
			$contratos[] = $row ;
		}
	}
	return $contratos ;
	//return $sql;
	}

 function insert( $id, $act){
        $sql = "INSERT INTO actividad_no_aplica VALUES(0, "
                .  $act . ","
                . $id
                . "  )" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }/**/



			
		/**
			INICIO CONSULTAS DE DIEGO
		*/
			function getConsultaLongitud($id_contrato)
			{
							$sql = 
							"
								    select sum(programa.longitud) as longitud
									from   programa
									inner  join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
									where  orden_servicio.id_contrato = ".$id_contrato."
									and   (estatus like 'TERMINADO' OR estatus like 'ACTA')
							";

							$resultado = $this->conexion->query($sql) ;
							$longitud  = array() ;
							if($resultado->num_rows>0)
							{
								while ($row = $resultado->fetch_assoc())
								{
									$longitud[] = $row ;
								}
							}
							return $longitud ;
			}

			function getConsultaComparaFechaMenorProgramada($fecha_actual)
			{
				$sql = 
							"
									SELECT programa.id_programa, programa.longitud
									FROM   programa 
									where  programa.fecha_fin    < '".$fecha_actual."' 
									;
							";
							$resultado = $this->conexion->query($sql) ;
							$longitud  = array() ;
							if($resultado->num_rows>0)
							{
								while ($row = $resultado->fetch_assoc())
								{
									$longitud[] = $row ;
								}
							}
							return $longitud ;
							//return $sql;
			}

function getConsultaActividadNoAplica($id_programa, $id_actividad)
{
			

			$sql = "SELECT count(id_actividad_no_aplica) as p
					from actividad_no_aplica 
					where id_actividad = ".$id_actividad." 
					and id_programa = ".$id_programa."

					";

					$resultado = $this->conexion->query($sql) ;
					$row = $resultado->fetch_assoc();
					$num= $row['p'];
					return $num ;
}

function getConsultaFechaActualEntreDosFechas($fecha_actual)
{
	$sql =  "
			SELECT *
			FROM programa 
			where '".$fecha_actual."' BETWEEN programa.fecha_inicio  and programa.fecha_fin;
			";	
			$resultado = $this->conexion->query($sql) ;
							$longitud  = array() ;
							if($resultado->num_rows>0)
							{
								while ($row = $resultado->fetch_assoc())
								{
									$longitud[] = $row ;
								}
							}
							return $longitud ;
}

function getConsultaContarActividadNoAplica($id_programa, $id_actividad)
{
			$sql = "
					SELECT count(*) as contador
					from actividad_no_aplica 
					where id_actividad = ".$id_actividad." 
					and id_programa = ".$id_programa."
					";
					$resultado = $this->conexion->query($sql) ;
					$row = $resultado->fetch_assoc();
					$num= $row['contador'];
					return $num ;
}

function getImagenIndicacion($id_indicacion)
{
			$sql = "
					
						SELECT id_indicacion_foto as contador 
						FROM avance_contrato.indicacion_foto 
						where id_indicacion = ".$id_indicacion.";

					";
					$resultado = $this->conexion->query($sql) ;
					$row = $resultado->fetch_assoc();
					$num= $row['contador'];
					return $num ;
}

function getJsonExtraeLineas()
{
			$sql 	  = "
							select linea.id_linea,contrato.id_contrato,contrato.numero,linea.nombre 
							from   contrato,linea_has_contrato,linea
							where  contrato.id_contrato 				= linea_has_contrato.id_contrato
							and    linea_has_contrato.id_linea 			= linea.id_linea
							order  by linea.diametro asc
			 			" ;
			$resultado = $this->conexion->query($sql) ;
			$linea = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$linea[] = $row ;
				}
			}
			return json_encode($linea, true);
}

function getJsonExtraeKm()
{
			$sql 	  = "
							select linea.id_linea,programa.id_programa,programa.km_inicial,contrato.numero,linea.nombre 
							from   contrato,linea_has_contrato,linea,orden_servicio,programa
							where  contrato.id_contrato 				= linea_has_contrato.id_contrato
							and    linea_has_contrato.id_linea 			= linea.id_linea
							and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							and    orden_servicio.id_orden_servicio 	= programa.id_orden_servicio
			 			" ;
			$resultado = $this->conexion->query($sql) ;
			$linea = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$linea[] = $row ;
				}
			}
			return json_encode($linea, true);
}


function getCuentaIndicacion($id_programa, $tipo)
				{
							
							$sql = 
							"
							SELECT COUNT(indicacion.id_indicacion) as p
								from indicacion 
								inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
								Where indicacion.id_programa=".$id_programa." and tipo_indicacion.tipo_inspeccion='".$tipo."'";
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}

function getCuentaIndicacionFoto($id_programa)
				{
							
							$sql = 
							"
							SELECT COUNT(indicacion_foto.id_indicacion_foto) as p
								from indicacion_foto 
								inner join indicacion on indicacion_foto.id_indicacion = indicacion.id_indicacion
								Where indicacion.id_programa=".$id_programa;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}




/**
			FIN DE CONSULTAS DE DIEGO
*/
/**
	INICIO FILTROS POR TECNICAS
*/

function getFiltroTecnicaC($contrato,$orden_servicio,$estatus,$tipo_trabajo ){
		$where_os = ' id_orden_servicio > 0 ' ;
		$where_c  = ' id_contrato > 0 ' ;
		$where_tt = ' id_tipo_trabajo > 0 ' ;
		$where_s  = ' id_sector > 0 ' ;

		$where_est = " estatus <> '' " ;
		if($contrato!= -1){
			$where_c = " id_contrato = $contrato " ;
		}
		if($orden_servicio != -1){
			$where_os = " id_orden_servicio = $orden_servicio " ;
		}
		if($tipo_trabajo != -1){
			$where_tt = " id_tipo_trabajo = $tipo_trabajo " ;
		}
		if($estatus != -1){
			$where_est = "programa.estatus = '$estatus' " ;
		}
		
		$sql_os    = "select * from orden_servicio where " . $where_os ." and " .$where_c." and ". $where_tt ." and ". $where_s ;
		$resultado = $this ->conexion->query($sql_os);
		$arreglo   = array() ;
		if($resultado->num_rows > 0)
		{
			while ($row = $resultado->fetch_assoc()) 
			{
				$sql_p = 
				"
					select linea.nombre as nombre_linea, programa.* 
					from   programa, linea,orden_servicio,linea_has_contrato
					where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
					and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
					and    linea_has_contrato.id_linea          = linea.id_linea
					and    orden_servicio.id_orden_servicio = " . $row['id_orden_servicio'] ." 
					and
				" . $where_est ;
			/*	select * from programa 
				where id_orden_servicio = " . $row['id_orden_servicio'] ." 
				and */
			//	echo $sql_p . "<br><br>" ;
				$res = $this->conexion->query($sql_p); 
			//	echo $res->num_rows ."<br><br>" ;
				if($res->num_rows > 0) {

					while ($fila = $res->fetch_assoc()) 
					{
						$arreglo[] = $fila ;
						//print_r($arreglo) ;
					}
				}
				//print_r($arreglo) ;
			}
		}
//		print_r($arreglo) ;
		return $arreglo ;
	}

	function getFiltroTecnica($contrato,$sector,$orden_servicio,$estatus,$tipo_trabajo ){
		$where_os = ' id_orden_servicio > 0 ' ;
		$where_c  = ' id_contrato > 0 ' ;
		$where_tt = ' id_tipo_trabajo > 0 ' ;
		$where_s  = ' id_sector > 0 ' ;

		$where_est = " estatus <> '' " ;
		if($contrato!= -1){
			$where_c = " id_contrato = $contrato " ;
		}
		if($orden_servicio != -1){
			$where_os = " id_orden_servicio = $orden_servicio " ;
		}
		if($tipo_trabajo != -1){
			$where_tt = " id_tipo_trabajo = $tipo_trabajo " ;
		}
		if($estatus != -1){
			$where_est = "programa.estatus = '$estatus' " ;
		}
		if($sector != -1){
			$where_s = "id_sector = '$sector' " ;
		}

		$sql_os    = "select * from orden_servicio where " . $where_os ." and " .$where_c." and ". $where_tt ." and ". $where_s ;
		$resultado = $this ->conexion->query($sql_os);
		$arreglo   = array() ;
		if($resultado->num_rows > 0)
		{
			while ($row = $resultado->fetch_assoc()) 
			{
				$sql_p = 
				"
					select linea.nombre as nombre_linea, programa.* 
					from   programa, linea,orden_servicio,linea_has_contrato
					where  programa.id_orden_servicio           = orden_servicio.id_orden_servicio
					and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
					and    linea_has_contrato.id_linea          = linea.id_linea
					and    orden_servicio.id_orden_servicio = " . $row['id_orden_servicio'] ." 
					and
				" . $where_est ;
			
			/*	select * from programa 
				where id_orden_servicio = " . $row['id_orden_servicio'] ." 
				and */

			//	echo $sql_p . "<br><br>" ;
				$res = $this->conexion->query($sql_p); 
			//	echo $res->num_rows ."<br><br>" ;

				if($res->num_rows > 0) {

					while ($fila = $res->fetch_assoc()) {

						$arreglo[] = $fila ;
						//print_r($arreglo) ;
					}
				}
				//print_r($arreglo) ;
			}
		}
//		print_r($arreglo) ;

		return $arreglo ;



	}
/**
	FIN FILTROS POR TECNICAS
*/

	//-------------calculo nrf--------------------------------------------
		function CalculoL2_Dt($L, $D, $t){
			$calculo= (pow($L, 2))/($D*$t);
			return $calculo;
		}

		function CalculoCriterio($L2_Dt){
			if ($L2_Dt>20) {
				$criterio='RSTRENG-1' ;
			} else {
				$criterio='ASME B31.G' ;
			}
			return $criterio;
		}

		function CalculoAsme_a($L, $D, $t){
			 $asme_a=round(0.893*($L/sqrt($D*$t)),3);
			 return $asme_a;
		}

		function CalculoAsme_m($L, $D, $t){
			 $asme_m=round(sqrt(1+((pow(0.893, 2))* ((pow($L,2))/($D*$t)))),2);
			 return $asme_m;
		}

		function CalculoAsme_a_mayor($asme_a, $asme_m, $d, $t, $smys, $D){
					$aux=(2*$d)/(3*$t);                  
                    $aux2 = (1-$aux);
                    $aux3 = pow($asme_m, -1);
                    $aux4 = 1-($aux * $aux3);
                    $aux5 = $aux2/$aux4;
                    $p1   = 1.1*((2*$t*$smys)/$D); 
                    $asme_pf1 = round($p1*$aux5,2);
                    $asme_a_mayor=$asme_pf1;
			 return $asme_a_mayor;
		}

		function CalculoAsme_a_menor($asme_a, $d, $t, $smys, $D){
					$aux=1-($d/$t);
                    $aux2= (2*$t*$smys)/$D;
                    $asme_pf2=round(1.1*$aux*$aux2,2);
                    $asme_a_menor=$asme_pf2;
			 return $asme_a_menor;
		}

		function CalculoL2Dt($L, $D, $t){
					$L2Dt=(pow($L,2))/($D*$t);
			 return $L2Dt;
		}

		function CalculoRstreng_m_mayor($L, $D, $t){
					$aux= $L/(sqrt($D*$t));
					$aux2= 1+(0.6275*pow($aux, 2));
	                $aux3= 0.003375*pow($aux, 4);
	                $rstreng_m1=round (sqrt($aux2-$aux3),3);
	                $rstreng_m2='---';
	                $rstreng_m_mayor=$rstreng_m1;							

			 return $rstreng_m_mayor;
		}

		function CalculoRstreng_m_menor($L, $D, $t){
					$aux= $L/(sqrt($D*$t));
					$rstreng_m_menor=round (3.3+(0.032*pow($aux, 2)),3);							
			 return $rstreng_m_menor;
		}

		function CalculoRstreng_presion($D, $t, $d, $rstreng_m, $smys){
					 $aux=1-(0.85*($d/$t));
                     $aux2=pow($rstreng_m, -1);
	                 $aux3=1-((0.85*($d/$t))*$aux2);
                     $aux4=$aux/$aux3; //ok
                     $aux5=(2*($smys+10000)*$t)/$D;
                     $rstreng_presion=round($aux4*$aux5,2);							
			 return $rstreng_presion;
		}



		
	//-------------fin de calculos nrf------------------------------------

	
			/**

		Grafica De Avances
		*/

function getResumenContratoVolumenesActividades($subdireccion, $contrato, $tipo_trabajo){
	$actividades = array() ;
    $kms = array() ;
    
    $sql = "select * from actividad where grafica_competencia = 1 order by orden asc" ;
    
    $res_act = $this->conexion->query($sql);
    
    while ( $r = $res_act->fetch_assoc() ):
        $actividades[] = $r ;
    endwhile;
    
    $sql = "select * from programa as p 
    		join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
    		join contrato as c on c.id_contrato = os.id_contrato
    		where c.id_contrato = $contrato and p.estatus<>'PROGRAMA' " ;
			
	if($tipo_trabajo != -1){
		$sql = $sql . "    and os.id_tipo_trabajo = $tipo_trabajo" ;
	}
			
    $rs = $this->conexion->query($sql) ;
   
    while ($a = $rs->fetch_assoc()){
        $kms[] = $a ;
    }

    $arreglo = array() ;
    $acum = 0 ;
    
    foreach ($actividades as $v):
    	foreach ($kms as $val){   

            $sql = "select longitud as longit from avance where id_programa = ". $val['id_programa'] ." and id_actividad = " . $v['id_actividad'];
            
                    $resultado = $this->conexion->query($sql);
                  //  echo $sql ."<br><br>";
                    if($resultado->num_rows>0){
                    while ($row = $resultado->fetch_assoc()){
                        
                        if($row['longit'] == null){
                            $row['longit'] = 0 ;
                        }
                      $acum+= $row['longit'] ;
                      /*echo $v['descripcion'] ;
                        print_r($row) ;
                        echo "<br>" ; */
                    }
                }
        
    }
    $arreglo[$v['descripcion']] = $acum ;
        $acum = 0 ;
        endforeach;
    
	return $arreglo ;        
    }


	/**

		Grafica De Avances
		*/
//-----------------------------------------inicia cambios de grafica-----------------------
function getResumenContratoVolumenesActividades_2($subdireccion, $contrato, $tipo_trabajo, $coordinador, $actividad){
	$actividades = array() ;
    $kms = array() ;
    
    $sql = "select * from actividad where tabla_resumen =".$actividad." order by orden asc" ;
    
    $res_act = $this->conexion->query($sql);
    
    while ( $r = $res_act->fetch_assoc() ):
        $actividades[] = $r ;
    endwhile;
    
    $sql = "select * from programa as p 
    		join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
    		join contrato as c on c.id_contrato = os.id_contrato
    		where c.id_contrato = $contrato and p.estatus<>'PROGRAMA' " ;
			
	if($tipo_trabajo != -1){
		$sql = $sql . "    and os.id_tipo_trabajo = $tipo_trabajo" ;
	}
	
	if($coordinador!= -1){
		$sql = $sql . " and p.id_coordinador= $coordinador";
	}
			
    $rs = $this->conexion->query($sql) ;
   
    while ($a = $rs->fetch_assoc()){
        $kms[] = $a ;
    }

    $arreglo = array() ;
    $acum = 0 ;
    
    foreach ($actividades as $v):
    	foreach ($kms as $val){   

            $sql = "select longitud as longit from avance where id_programa = ". $val['id_programa'] ." and id_actividad = " . $v['id_actividad'];
            
                    $resultado = $this->conexion->query($sql);
                  //  echo $sql ."<br><br>";
                    if($resultado->num_rows>0){
                    while ($row = $resultado->fetch_assoc()){
                        
                        if($row['longit'] == null){
                            $row['longit'] = 0 ;
                        }
                      $acum+= $row['longit'] ;
                      /*echo $v['descripcion'] ;
                        print_r($row) ;
                        echo "<br>" ; */
                    }
                }
        
    }
    $arreglo[$v['descripcion']] = $acum ;
        $acum = 0 ;
        endforeach;
    
	return $arreglo ;        
    }
	//-------
	function getResumenContratoVolumenesActividades_3($subdireccion, $contrato, $tipo_trabajo, $coordinador){
	$actividades = array() ;
    $kms = array() ;
    
    $sql = "select * from actividad where comparativa <> 0 order by comparativa, orden asc" ;
    
    $res_act = $this->conexion->query($sql);
    
    while ( $r = $res_act->fetch_assoc() ):
        $actividades[] = $r ;
    endwhile;
    
    $sql = "select * from programa as p 
    		join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
    		join contrato as c on c.id_contrato = os.id_contrato
    		where c.id_contrato = $contrato and p.estatus<>'PROGRAMA' " ;
			
	if($tipo_trabajo != -1){
		$sql = $sql . "    and os.id_tipo_trabajo = $tipo_trabajo" ;
	}
	
	if($coordinador!= -1){
		$sql = $sql . " and p.id_coordinador= $coordinador";
	}
			
    $rs = $this->conexion->query($sql) ;
   
    while ($a = $rs->fetch_assoc()){
        $kms[] = $a ;
    }

    $arreglo = array() ;
    $acum = 0 ;
    
    foreach ($actividades as $v):
    	foreach ($kms as $val){   

            $sql = "select longitud as longit from avance where id_programa = ". $val['id_programa'] ." and id_actividad = " . $v['id_actividad'];
            
                    $resultado = $this->conexion->query($sql);
                  //  echo $sql ."<br><br>";
                    if($resultado->num_rows>0){
                    while ($row = $resultado->fetch_assoc()){
                        
                        if($row['longit'] == null){
                            $row['longit'] = 0 ;
                        }
                      $acum+= $row['longit'] ;
                      /*echo $v['descripcion'] ;
                        print_r($row) ;
                        echo "<br>" ; */
                    }
                }
        
    }
    $arreglo[$v['descripcion']] [$v['comparativa']]= $acum ;
        $acum = 0 ;
        endforeach;
    
	return $arreglo ;        
    }
	
	//-----
	function getResumenContrato_2($subdireccion, $contrato, $tipo_trabajo, $coordinador){
    
    $actividades = array() ;
    $kms = array() ;
    
    $sql = "select * from actividad where grafica_competencia = 1 order by orden asc" ;
    
    $res_act = $this->conexion->query($sql);
    
    while ( $r = $res_act->fetch_assoc() ):
        $actividades[] = $r ;
    endwhile;
    
    $sql = "select * from programa as p 
    		join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
    		join contrato as c on c.id_contrato = os.id_contrato
    		where c.id_contrato = $contrato  " ;	
	if($tipo_trabajo != -1){
		$sql = $sql . "    and os.id_tipo_trabajo = $tipo_trabajo" ;
	}
	
	if($coordinador != -1){
		$sql = $sql . "    and p.id_coordinador = $coordinador" ;
	}
	
    $rs = $this->conexion->query($sql) ;
   
    while ($a = $rs->fetch_assoc()){
        $kms[] = $a ;
    }
    
    
    $array = array() ;
    $graphs = array() ;
    
      
    
    
    $cont = 0 ;
    foreach ($actividades as $v){
        $graphs[$cont]['balloonText'] = "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]:<br> <b>[[value]] %</b></span>" ;
        if($v['id_actividad']==1 ){
			$graphs[$cont]["labelText"] ='ETB' ;
		} 
		
		if($v['id_actividad']==2 ){
			$graphs[$cont]["labelText"] ='B+RE' ;
		} 
		
		if($v['id_actividad']==22 ){
			$graphs[$cont]["labelText"] ='ECB' ;
		} 
		$graphs[$cont]["fillAlphas"] = 0.6 ;
        //$graphs[$cont]["labelText"] = '[[value]]' ;
		//$graphs[$cont]["labelText"] =$v['id_actividad'];
        $graphs[$cont]["lineAlpha"] = 0.3 ;
        $graphs[$cont]['title'] = $v['descripcion'] ;
        $graphs[$cont]['type'] = "column" ;
        $graphs[$cont]['color'] = "#000000" ;
	
        $graphs[$cont]['valueField'] = $v['id_actividad'] ;
        $cont ++ ;
}
 
    
    
    
    
    
    
    $cont = 0 ;
    foreach ($kms as $val){
    	if($val['km_final'] =='-'){
			if($val['segmento'] == 'AFP'){
				$array[$cont]['km'] = $val['segmento'] . '-'. $val['km_inicial'] ;	
			}
			else{
				$array[$cont]['km'] = $val['km_inicial'] ;	
			}
    	}
    	else{
		if($val['segmento'] == 'AFP'){
			$array[$cont]['km'] = $val['segmento'] .'-'. $val['km_inicial'].'-'.$val['km_final'] ;
		}
		else{
    		$array[$cont]['km'] = $val['km_inicial'].'-'.$val['km_final'] ;
			}
    	}
        
        
        
        foreach ($actividades as $v):
         
            $sql = "select avance.porcentaje as longit from avance where id_programa = ". $val['id_programa'] ." and id_actividad = " . $v['id_actividad'];
            
                    $resultado = $this->conexion->query($sql);
                  //  echo $sql ."<br><br>";
                    if($resultado->num_rows>0){
                    while ($row = $resultado->fetch_assoc()){
                        
                        if($row['longit'] == null){
                            $row['longit'] = 0 ;
                        }
                      //  print_r($row);
                        
                        $array[$cont][$v['id_actividad']] = round($row['longit'], 2)  ;
                    }
                }
        
        endforeach;
        $cont ++ ;
    }

   // print_r($array) ;
    
    return $ar = array($array, $graphs);
    
   // print_r($graphs) ;
    
}

//----------------------------------
function getForPastelEstatusGeneral_2($id_contrato, $id_tipo_trabajo, $id_coordinador){
		$array_estatus = array( 'PROGRAMA', 'PROCESO', 'TERMINADO', 'ACTA') ;
		
		$array_porcentaje = array() ;
		$total = 0 ;
		
		foreach($array_estatus as $estatus){
		
			$sql = "select count(*) from programa as p
					join orden_servicio as os on p.id_orden_servicio = os.id_orden_servicio
					join contrato as c on c.id_contrato = os.id_contrato
					where os.id_contrato = $id_contrato  and p.estatus = '$estatus'  " ;
			
			if($id_tipo_trabajo != -1){
				$sql = $sql . "    and os.id_tipo_trabajo = $id_tipo_trabajo" ;
			}
			
			if($id_coordinador != -1){
				$sql = $sql . "    and p.id_coordinador = $id_coordinador" ;
			}
					
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$r = $resultado->fetch_array() ;
				$total += $r['0'] ;
				$array_porcentaje[] = array("estatus"=>$estatus, "cantidad"=>$r['0']) ;
			}
			
		}
		
		return $array_porcentaje ;
		//return $sql;
	}
//--------------------------
function getTipoTrabajo( $id ){
        $sql = "SELECT * FROM tipo_trabajo WHERE id_tipo_trabajo = $id " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return $row ['descripcion'] ;
        }
        else{
            return false ;
        }
    }
	
//--------------------------
function getNombreCoordinador( $id ){
        $sql = "SELECT * FROM coordinador WHERE id_coordinador = $id " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return $row ['nombre'] ;
        }
        else{
            return false ;
        }
    }
	
//------
function getTotalProgramado_2($id_contrato, $id_tipo_trabajo, $id_coordinador){
		
		$total = 0 ;
			$sql = "select sum(p.longitud) from programa as p
					join orden_servicio as os on p.id_orden_servicio = os.id_orden_servicio
					where os.id_contrato = $id_contrato   " ;
			
			if($id_tipo_trabajo != -1){
				$sql = $sql . "    and os.id_tipo_trabajo = $id_tipo_trabajo" ;
			}
			
			if($id_coordinador != -1){
				$sql = $sql . "    and p.id_coordinador = $id_coordinador" ;
			}
					
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$r = $resultado->fetch_array() ;
				$total = $r['0'] ;
				
			}
			
		
		
		return $total ;
	}
	
	
//-------------------------------------------------termina cambios de grafica----------

function getResumenContrato($subdireccion, $contrato, $tipo_trabajo){
    
    $actividades = array() ;
    $kms = array() ;
    
    $sql = "select * from actividad where grafica_competencia = 1 order by orden asc" ;
    
    $res_act = $this->conexion->query($sql);
    
    while ( $r = $res_act->fetch_assoc() ):
        $actividades[] = $r ;
    endwhile;
    
    $sql = "select * from programa as p 
    		join orden_servicio as os on os.id_orden_servicio = p.id_orden_servicio
    		join contrato as c on c.id_contrato = os.id_contrato
    		where c.id_contrato = $contrato  " ;	
	if($tipo_trabajo != -1){
		$sql = $sql . "    and os.id_tipo_trabajo = $tipo_trabajo" ;
	}
    $rs = $this->conexion->query($sql) ;
   
    while ($a = $rs->fetch_assoc()){
        $kms[] = $a ;
    }
    
    
    $array = array() ;
    $graphs = array() ;
    
      
    
    
    $cont = 0 ;
    foreach ($actividades as $v){
        $graphs[$cont]['balloonText'] = "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]:<br> <b>[[value]] %</b></span>" ;
        if($v['id_actividad']==1 ){
			$graphs[$cont]["labelText"] ='ETB' ;
		} 
		
		if($v['id_actividad']==2 ){
			$graphs[$cont]["labelText"] ='B+RE' ;
		} 
		
		if($v['id_actividad']==22 ){
			$graphs[$cont]["labelText"] ='ECB' ;
		} 
		$graphs[$cont]["fillAlphas"] = 0.6 ;
        //$graphs[$cont]["labelText"] = '[[value]]' ;
		//$graphs[$cont]["labelText"] =$v['id_actividad'];
        $graphs[$cont]["lineAlpha"] = 0.3 ;
        $graphs[$cont]['title'] = $v['descripcion'] ;
        $graphs[$cont]['type'] = "column" ;
        $graphs[$cont]['color'] = "#000000" ;
	
        $graphs[$cont]['valueField'] = $v['id_actividad'] ;
        $cont ++ ;
}
 
    
    
    
    
    
    
    $cont = 0 ;
    foreach ($kms as $val){
    	if($val['km_final'] =='-'){
			if($val['segmento'] == 'AFP'){
				$array[$cont]['km'] = $val['segmento'] . '-'. $val['km_inicial'] ;	
			}
			else{
				$array[$cont]['km'] = $val['km_inicial'] ;	
			}
    	}
    	else{
		if($val['segmento'] == 'AFP'){
			$array[$cont]['km'] = $val['segmento'] .'-'. $val['km_inicial'].'-'.$val['km_final'] ;
		}
		else{
    		$array[$cont]['km'] = $val['km_inicial'].'-'.$val['km_final'] ;
			}
    	}
        
        
        
        foreach ($actividades as $v):
         
            $sql = "select avance.porcentaje as longit from avance where id_programa = ". $val['id_programa'] ." and id_actividad = " . $v['id_actividad'];
            
                    $resultado = $this->conexion->query($sql);
                  //  echo $sql ."<br><br>";
                    if($resultado->num_rows>0){
                    while ($row = $resultado->fetch_assoc()){
                        
                        if($row['longit'] == null){
                            $row['longit'] = 0 ;
                        }
                      //  print_r($row);
                        
                        $array[$cont][$v['id_actividad']] = round($row['longit'], 2)  ;
                    }
                }
        
        endforeach;
        $cont ++ ;
    }

   // print_r($array) ;
    
    return $ar = array($array, $graphs);
    
   // print_r($graphs) ;
    
}


function getByProgramaActividad($programa, $actividad){
        $sql = "SELECT * FROM actividad_no_aplica where id_programa = $programa and id_actividad = $actividad "  ;
        $resultado = $this->conexion->query($sql);
        $encontrado = false ;
        
        if($resultado->num_rows > 0){
            $encontrado = true ;
        }
        return $encontrado ;
    }
	
	function getForPastelEstatusGeneral($id_contrato, $id_tipo_trabajo){
		$array_estatus = array( 'PROGRAMA', 'PROCESO', 'TERMINADO', 'ACTA') ;
		
		$array_porcentaje = array() ;
		$total = 0 ;
		
		foreach($array_estatus as $estatus){
		
			$sql = "select count(*) from programa as p
					join orden_servicio as os on p.id_orden_servicio = os.id_orden_servicio
					where os.id_contrato = $id_contrato  and p.estatus = '$estatus'  " ;
			
			if($id_tipo_trabajo != -1){
				$sql = $sql . "    and os.id_tipo_trabajo = $id_tipo_trabajo" ;
			}
					
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$r = $resultado->fetch_array() ;
				$total += $r['0'] ;
				$array_porcentaje[] = array("estatus"=>$estatus, "cantidad"=>$r['0']) ;
			}
			
		}
		
		return $array_porcentaje ;
	}
	
	
	
	
	function getTotalProgramado($id_contrato, $id_tipo_trabajo){
		
		$total = 0 ;
		
		
		
			$sql = "select sum(p.longitud) from programa as p
					join orden_servicio as os on p.id_orden_servicio = os.id_orden_servicio
					where os.id_contrato = $id_contrato  and fecha_fin < now()  " ;
			
			if($id_tipo_trabajo != -1){
				$sql = $sql . "    and os.id_tipo_trabajo = $id_tipo_trabajo" ;
			}
					
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$r = $resultado->fetch_array() ;
				$total = $r['0'] ;
				
			}
			
		
		
		return $total ;
	}
	
	


		/**
	fin grafica de avances
		*/
	function getKmlContrato($id_contrato){
		if($id_contrato==-1){
			$sql = "SELECT * FROM kml_contrato " ;
		} else {
			$sql = "SELECT * FROM kml_contrato where id_contrato =". $id_contrato ;
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
	
	function getIcono($id_programa){
		$sql="select *
			from avance							
			inner join actividad on actividad.id_actividad = avance.id_actividad							
			Where avance.id_programa =".$id_programa. " order by actividad.orden";
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
	
	function getConsulta_metrosenv($id_actividad, $subdireccion, $id_contrato, $id_tipo_trabajo, $id_compania)
				{
							$cadena="";
							if($subdireccion!="-1"){
								$cadena=" and contrato.subdireccion = '".$subdireccion."'"; 
							}
							
							if($id_contrato!="-1"){
								$cadena=$cadena." and contrato.id_contrato = ".$id_contrato; 
							}
							
							if($id_tipo_trabajo!="-1"){
								$cadena=$cadena." and tipo_trabajo.id_tipo_trabajo = ".$id_tipo_trabajo; 
							}
							
							if($id_compania!="-1"){
								$cadena=$cadena." and compania.id_compania = ".$id_compania; 
							}
							
							
							$sql = 
							"
							SELECT SUM(AVANCE.LONGITUD) as p FROM PROGRAMA
							INNER JOIN AVANCE ON PROGRAMA.ID_PROGRAMA = AVANCE.ID_PROGRAMA
							INNER JOIN ACTIVIDAD ON AVANCE.ID_ACTIVIDAD = ACTIVIDAD.ID_ACTIVIDAD
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
							inner join compania on contrato.id_compania = compania.id_compania
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo 
							WHERE ACTIVIDAD.ID_ACTIVIDAD= ".$id_actividad. $cadena;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			function getConsulta_ptosenv($id_actividad, $subdireccion, $id_contrato, $id_tipo_trabajo, $id_compania)
				{
							$cadena="";
							if($subdireccion!="-1"){
								$cadena=" and contrato.subdireccion = '".$subdireccion."'"; 
							}
							
							if($id_contrato!="-1"){
								$cadena=$cadena." and contrato.id_contrato = ".$id_contrato; 
							}
							
							if($id_tipo_trabajo!="-1"){
								$cadena=$cadena." and tipo_trabajo.id_tipo_trabajo = ".$id_tipo_trabajo; 
							}
							
							if($id_compania!="-1"){
								$cadena=$cadena." and compania.id_compania = ".$id_compania; 
							}
							
							$sql = 
							"
							SELECT count(programa.id_programa) as p FROM PROGRAMA
							INNER JOIN AVANCE ON PROGRAMA.ID_PROGRAMA = AVANCE.ID_PROGRAMA
							INNER JOIN ACTIVIDAD ON AVANCE.ID_ACTIVIDAD = ACTIVIDAD.ID_ACTIVIDAD
							inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
							inner join compania on contrato.id_compania = compania.id_compania
							inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo 
							WHERE ACTIVIDAD.ID_ACTIVIDAD= ".$id_actividad. $cadena;
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}
			
			
	function getConsulta_avance_resumen($id_contrato, $subdireccion, $id_tipo_trabajo, $id_coordinador)
		{
                    $condition = "where" ;
                                                        
                    if($id_contrato != -1){
                        if($subdireccion != -1 || $id_tipo_trabajo!=-1 ){
                            $condition = $condition . " contrato.id_contrato = $id_contrato and"  ; 
                        }
                        else {
                            $condition = $condition . " contrato.id_contrato = $id_contrato "  ; 
                        }

                    }

                    if($subdireccion != -1){
                        if($id_tipo_trabajo!=-1){
                            $condition = $condition." orden_servicio.id_orden_servicio = '$subdireccion' and" ;
                        }
                        else{
                            $condition = $condition." orden_servicio.id_orden_servicio = '$subdireccion' " ;
                        }

                    }

                    if($id_tipo_trabajo != -1){
                        $condition = $condition." tipo_trabajo.id_tipo_trabajo = $id_tipo_trabajo" ;
                    }
					
					if($id_coordinador != -1){
                        $condition = $condition." and coordinador.id_coordinador = $id_coordinador" ;
                    }


                    $sql = 
                    "
                    select programa.id_programa, programa.segmento, programa.km_inicial, programa.km_final, programa.fecha_fin_real, programa.longitud, programa.utm_n, programa.utm_e, programa.estatus, programa.docto, 
                    orden_servicio.numero_orden, linea.nombre,
                    linea.id_linea, programa.fecha_inicio, programa.fecha_fin, programa.fecha_inicio_real, programa.fecha_fin_real, tipo_trabajo.id_tipo_trabajo, tipo_trabajo.descripcion, ddv.id_ddv, ddv.alias, contrato.numero
                    from programa
                    inner join coordinador on programa.id_coordinador = coordinador.id_coordinador
                    inner join contrato on coordinador.id_contrato = contrato.id_contrato 
                    inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                    inner join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato 
                    inner join linea on linea_has_contrato.id_linea = linea.id_linea 
                    inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
                    inner join ddv on linea.id_ddv = ddv.id_ddv 
					order by contrato.numero desc
                    " ;

                    if($condition != 'where') {

                        $sql = $sql . $condition ;

                    }
					
                    
                   // echo "<br><br>".$sql."<br><br>" ;
                    	
			$resultado = $this->conexion->query($sql) ;
			$contratos = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
                                    
                                    $row['porcentaje_perdida'] = 0 ;
                                        $row['tipo_indicacion'] = 'NO HAY REGISTRO DE INDICACIONES' ;
                                        $row['espesor'] = '-' ;
                                        $row['fecha_inspeccion'] = '-' ;
                                    
                                    
                                    $sql = "select i.id_indicacion as id, i.espesor_remanente as espesor, i.fecha_inspeccion as fecha, max(i.porcentaje_perdida)as porcentaje_perdida, t.descripcion as descripcion from indicacion as i 
                                            join tipo_indicacion as t
                                                on t.id_tipo_indicacion = i.id_tipo_indicacion
                                            where t.evaluacion = 1 and id_programa = " . $row['id_programa'] ;
                                    
                                   // echo $sql ;
                                    $res2 = $this->conexion->query($sql);
                                    
                                    
                                    
                                    if ($res2->num_rows>0){
                                        $r = $res2->fetch_assoc() ;
                                        if($r['descripcion'] != ''){
                                            $row['porcentaje_perdida'] = number_format($r['porcentaje_perdida'], 2)  ;
                                            $row['tipo_indicacion'] = $r['descripcion'] ;
                                            $row['espesor'] = $r['espesor'] ;
                                            $row['fecha_inspeccion'] = $r['fecha'] ;
                                        }
                                        
                                        
                                    }
                                    
                                  //  echo $row['tipo_indicacion'] . '......' . $row['id_programa'] . '.....' . $r['descripcion'] . '<br>' ;
                                    
                                    
					$contratos[] = $row ;
				}
			}
			return $contratos ;
		}	

		function getCuentaAvance($id_programa)
				{
							
							
							$sql = 
							"
							SELECT COUNT(id_avance) as p FROM avance
							WHERE id_programa= ".$id_programa;
							
							
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}	

		function getCuentaAvanceFoto($id_programa)
				{
							
							
							$sql = 
							"
							SELECT COUNT(foto.id_foto) as p FROM foto
							inner join avance on foto.id_avance = avance.id_avance
							WHERE avance.id_programa=".$id_programa;
							
							
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}	
		
		function getCuentaDocumento($id_programa)
				{
							
							
							$sql = 
							"
							SELECT COUNT(id_documento) as p FROM documento Where id_programa=".$id_programa;
							
							
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}	
			
		function getCuentaIndicacion2($id_programa)
				{
							
							
							$sql = 
							"
							SELECT COUNT(id_indicacion) as p FROM indicacion Where id_programa=".$id_programa;
							
							
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}	
		function getCuentaIndicacionFoto2($id_programa)
				{
							
							
							$sql = 
							"
							SELECT COUNT(indicacion_foto.id_indicacion_foto) as p from indicacion
							inner join indicacion_foto on indicacion.id_indicacion = indicacion_foto.id_indicacion
							Where indicacion.id_programa=".$id_programa;
							
							
							
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$num= $row['p'];
			
			return $num ;
			//return $sql;
			}	
	
}
?>