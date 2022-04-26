<?php
include_once ("Database.php");
include_once ("IndicacionBitacora.php");
class Indicacion
{
		private $id_indicacion ;
		private $id_programa;
		private $elemento;
		private $no_indicacion;
		private $sold_pos_referencia;
		private $distancia_sold_referencia;
		private $horario_tecnico;
		private $largo;
		private $ancho;
		private $profundidad;
		private $espesor_minimo_zona_sana;
		private $espesor_maximo_zona_sana;
		private $espesor_remanente;
		private $porcentaje_perdida;
		private $diametro;
		private $id_tipo_indicacion;
		private $fecha_inspeccion;

		private $conexion ;
		private $tabla ;

	function __construct()
	{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "indicacion" ;
	}

	function insert(
		$elemento,
		$no_indicacion,
		$sold_pos_referencia,
		$distancia_sold_referencia,
		$horario_tecnico,
		$id_tipo_indicacion,
		$largo,         
		$ancho,
		$profundidad,
		$espesor_minimo_zona_sana,
		$espesor_maximo_zona_sana,
		$espesor_remanente,
		$porcentaje_perdida,
		$fecha_inspeccion,
		$diametro,
		$id_programa,
		$orden,
		$id_usuario,
		$usuario	)
	{
		$ib = new IndicacionBitacora();
			$sql = 
			"
			insert into $this->tabla values(
				0, 
				".$id_programa.",
				'".$elemento."',
				'".$no_indicacion."',
				'".$sold_pos_referencia."',
				'".$distancia_sold_referencia."',
				'".$horario_tecnico."',
				'".$largo."',
				'".$ancho."',
				'".$profundidad."',
				'".$espesor_minimo_zona_sana."',
				'".$espesor_maximo_zona_sana."',
				'".$espesor_remanente."',
				'".$porcentaje_perdida."',
				'".$diametro."',
			 	 ".$id_tipo_indicacion.",
				'".$fecha_inspeccion."',
				".$orden."
				)";
		$this->conexion->query($sql) ;
		 $ib->insert($id_usuario, $usuario);
		return $this->conexion->insert_id ;
		//return $sql;
	}

	function update(
		$elemento,
		$no_indicacion,
		$sold_pos_referencia,
		$distancia_sold_referencia,
		$horario_tecnico,
		$id_tipo_indicacion,
		$largo,         
		$ancho,
		$profundidad,
		$espesor_minimo_zona_sana,
		$espesor_maximo_zona_sana,
		$espesor_remanente,
		$porcentaje_perdida,
		$fecha_inspeccion,
		$diametro,
		$id_programa,
		$id_indicacion,
		$orden,
		$id_usuario,
		$usuario
		)
	{
		$ib = new IndicacionBitacora();
			$sql =
			"
				UPDATE $this->tabla
				SET 
				id_programa      				 =  ".$id_programa.",
				elemento      				 	 = '".$elemento."',
				no_indicacion      				 = '".$no_indicacion."',
				sold_pos_referencia      		 = '".$sold_pos_referencia."',
				distancia_sold_referencia      	 = '".$distancia_sold_referencia."',
				horario_tecnico      			 = '".$horario_tecnico."',
				largo      				 		 = '".$largo."',
				ancho      				 		 = '".$ancho."',
				profundidad      				 = '".$profundidad."',
				espesor_minimo_zona_sana      	 = '".$espesor_minimo_zona_sana."',
				espesor_maximo_zona_sana      	 = '".$espesor_maximo_zona_sana."',
				espesor_remanente      			 = '".$espesor_remanente."',
				porcentaje_perdida      		 = '".$porcentaje_perdida."',
				diametro      				 	 = '".$diametro."',
				id_tipo_indicacion      		 =  ".$id_tipo_indicacion.",
				fecha_inspeccion      			 = '".$fecha_inspeccion."',
				orden 			     			 =  ".$orden."
				WHERE id_indicacion 			 =  ".$id_indicacion."; 
			";
			 $ib->insert($id_usuario, $usuario);
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function insertListaTabla($registro,$id_programa)
	{
		$sql =
		"
		insert into $this->tabla values
		(
				0,
				".$id_programa.",
				'".strtoupper($registro['elemento'])."',
				'".strtoupper($registro['no_indicacion'])."',
				'".strtoupper($registro['sold_pos_referencia'])."',
				'".strtoupper($registro['distancia_sold_referencia'])."',
				'".strtoupper($registro['horario_tecnico'])."',
				'".strtoupper($registro['largo'])."',
				'".strtoupper($registro['ancho'])."',
				'".strtoupper($registro['profundidad'])."',
				'".strtoupper($registro['espesor_minimo_zona_sana'])."',
				'".strtoupper($registro['espesor_maximo_zona_sana'])."',
				'".strtoupper($registro['espesor_remanente'])."',
				'".strtoupper($registro['porcentaje_perdida'])."',
				'".strtoupper($registro['diametro'])."',
				 ".$registro['id_tipo_indicacion'].",
				'".strtoupper($registro['fecha_inspeccion'])."'
		)";
				 $this->conexion->query($sql);
        		 return $this->conexion->insert_id;
				//return $sql;
	}

	function updateListaTabla($registro)
	{
			$sql =
			"
				UPDATE $this->tabla
				SET 
				id_programa      				 =  ".$registro['id_programa'].",
				elemento      				 	 = '".strtoupper($registro['elemento'])."',
				no_indicacion      				 = '".strtoupper($registro['no_indicacion'])."',
				sold_pos_referencia      		 = '".strtoupper($registro['sold_pos_referencia'])."',
				distancia_sold_referencia  		 = '".strtoupper($registro['distancia_sold_referencia'])."',
				horario_tecnico      			 = '".strtoupper($registro['horario_tecnico'])."',
				largo      				 		 = '".strtoupper($registro['largo'])."',
				ancho      				 		 = '".strtoupper($registro['ancho'])."',
				profundidad      				 = '".strtoupper($registro['profundidad'])."',
				espesor_minimo_zona_sana      	 = '".strtoupper($registro['espesor_minimo_zona_sana'])."',
				espesor_maximo_zona_sana      	 = '".strtoupper($registro['espesor_maximo_zona_sana'])."',
				espesor_remanente      			 = '".strtoupper($registro['espesor_remanente'])."',
				porcentaje_perdida      		 = '".strtoupper($registro['porcentaje_perdida'])."',
				diametro      				 	 = '".strtoupper($registro['diametro'])."',
				id_tipo_indicacion      		 =  ".$registro['id_tipo_indicacion'].",
				fecha_inspeccion      			 = '".strtoupper($registro['fecha_inspeccion'])."'
				WHERE id_indicacion 			 =  ".$registro['id_indicacion']."; 
			";
				return $this->conexion->query($sql) ;
				//return $sql;
	}

	function delete($id_indicacion)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE id_indicacion = ".$id_indicacion.";
			";
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function deleteByIdPrograma($id_programa)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE id_programa = ".$id_programa.";
			";
				return 	$this->conexion->query($sql) ;
	}

	function loadById($id_indicacion)
	{
			$sql = "select * from $this->tabla where id_indicacion = $id_indicacion" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_indicacion        	= $row['id_indicacion'] ;
				$this->id_programa 				= $row['id_programa'] ;
				$this->elemento 		  		= $row['elemento'] ;
				$this->no_indicacion    		= $row['no_indicacion'] ;
				$this->sold_pos_referencia  	= $row['sold_pos_referencia'] ;
				$this->distancia_sold_referencia= $row['distancia_sold_referencia'] ;
				$this->horario_tecnico    		= $row['horario_tecnico'] ;
				$this->largo    				= $row['largo'] ;
				$this->ancho    				= $row['ancho'] ;
				$this->profundidad    			= $row['profundidad'] ;
				$this->espesor_minimo_zona_sana = $row['espesor_minimo_zona_sana'] ;
				$this->espesor_maximo_zona_sana = $row['espesor_maximo_zona_sana'] ;
				$this->espesor_remanente    	= $row['espesor_remanente'] ;
				$this->porcentaje_perdida    	= $row['porcentaje_perdida'] ;
				$this->diametro    				= $row['diametro'] ;
				$this->id_tipo_indicacion    	= $row['id_tipo_indicacion'] ;
				$this->fecha_inspeccion    		= $row['fecha_inspeccion'] ;
			}
			return $resultado->num_rows ;
		}

	function loadByIdPrograma($id_programa)
	{
			$sql = "select * from $this->tabla where id_programa = $id_programa" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_indicacion        	= $row['id_indicacion'] ;
				$this->id_programa 				= $row['id_programa'] ;
				$this->elemento 		  		= $row['elemento'] ;
				$this->no_indicacion    		= $row['no_indicacion'] ;
				$this->sold_pos_referencia  	= $row['sold_pos_referencia'] ;
				$this->distancia_sold_referencia= $row['distancia_sold_referencia'] ;
				$this->horario_tecnico    		= $row['horario_tecnico'] ;
				$this->largo    				= $row['largo'] ;
				$this->ancho    				= $row['ancho'] ;
				$this->profundidad    			= $row['profundidad'] ;
				$this->espesor_minimo_zona_sana = $row['espesor_minimo_zona_sana'] ;
				$this->espesor_maximo_zona_sana = $row['espesor_maximo_zona_sana'] ;
				$this->espesor_remanente    	= $row['espesor_remanente'] ;
				$this->porcentaje_perdida    	= $row['porcentaje_perdida'] ;
				$this->diametro    				= $row['diametro'] ;
				$this->id_tipo_indicacion    	= $row['id_tipo_indicacion'] ;
				$this->fecha_inspeccion    		= $row['fecha_inspeccion'] ;
			}
			return $resultado->num_rows ;
	}

	function getAll()
	{
		$sql = "select * from $this->tabla order by orden asc" ;
		$resultado = $this->conexion->query($sql) ;
		$indicacion_foto = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$indicacion_foto[] = $row ;
			}
		}
		return $indicacion_foto ;
	}
	
	function loadByIdProgramaTipoInspeccion($id_programa,$tipo_inspeccion)
	{
			$sql = 
			"
			select * from indicacion,tipo_indicacion 
			where indicacion.id_programa = $id_programa 
			and indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
			and tipo_indicacion.tipo_inspeccion = '$tipo_inspeccion'
			" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_indicacion        	= $row['id_indicacion'] ;
				$this->id_programa 				= $row['id_programa'] ;
				$this->elemento 		  		= $row['elemento'] ;
				$this->no_indicacion    		= $row['no_indicacion'] ;
				$this->sold_pos_referencia  	= $row['sold_pos_referencia'] ;
				$this->distancia_sold_referencia= $row['distancia_sold_referencia'] ;
				$this->horario_tecnico    		= $row['horario_tecnico'] ;
				$this->largo    				= $row['largo'] ;
				$this->ancho    				= $row['ancho'] ;
				$this->profundidad    			= $row['profundidad'] ;
				$this->espesor_minimo_zona_sana = $row['espesor_minimo_zona_sana'] ;
				$this->espesor_maximo_zona_sana = $row['espesor_maximo_zona_sana'] ;
				$this->espesor_remanente    	= $row['espesor_remanente'] ;
				$this->porcentaje_perdida    	= $row['porcentaje_perdida'] ;
				$this->diametro    				= $row['diametro'] ;
				$this->id_tipo_indicacion    	= $row['id_tipo_indicacion'] ;
				$this->fecha_inspeccion    		= $row['fecha_inspeccion'] ;
			}
			return $resultado->num_rows ;
	}
	
	function getAllProgramaTipoInspeccion($id_programa,$tipo_inspeccion)
	{
		$sql =
		"
		select indicacion.*
		from indicacion,tipo_indicacion
		where indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
		and tipo_indicacion.tipo_inspeccion = '".$tipo_inspeccion."'
		and indicacion.id_programa = ".$id_programa."
		order by orden asc
	
		" ;
		$resultado = $this->conexion->query($sql) ;
		$indicacion_foto = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$indicacion_foto[] = $row ;
			}
		}
		return $indicacion_foto ;
	}

	function getAllPrograma($id_programa)
	{
		$sql =
		"
		select indicacion.*
		from indicacion,tipo_indicacion
		where indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
		and indicacion.id_programa = ".$id_programa."
		order by indicacion.orden, tipo_indicacion.simbologia  asc	
		" ;
		$resultado = $this->conexion->query($sql) ;
		$indicacion_foto = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$indicacion_foto[] = $row ;
			}
		}
		return $indicacion_foto ;
	}

	function getAllCount()
	{
			$sql = 
				"
					SELECT count(*) as contador
					from $this->tabla 
				";
					$resultado = $this->conexion->query($sql) ;
					$row = $resultado->fetch_assoc();
					$num = $row['contador'];
					return $num;
	}

	function getAllCountByIdPrograma($id_programa)
	{
			$sql = 
				"
					SELECT count(*) as contador
					from $this->tabla
					where id_programa = ".$id_programa." 
				";

				$num = 0 ;

					$resultado = $this->conexion->query($sql) ;
					if($resultado->num_rows > 0) :
						$row = $resultado->fetch_assoc();
						$num = $row['contador'];
					endif;
					
					return $num;
	}

	function getAllCountProgramaTipoInspeccion($id_programa,$tipo_inspeccion)
	{
		$sql =
		"
					select count(*) as contador
					from indicacion,tipo_indicacion
					where indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
					and tipo_indicacion.tipo_inspeccion = '".$tipo_inspeccion."'
					AND indicacion.id_programa = ".$id_programa.";
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

function getCountIndicacionesProgramaUT($id_programa)
	{
		$sql =
				"
					select count(*) as contador 
					from indicacion,tipo_indicacion,programa
					where indicacion.id_programa = $id_programa
                    and indicacion.id_programa = programa.id_programa
                    and indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
					and tipo_indicacion.tipo_inspeccion = 'UT'
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getCountIndicacionesProgramaVT($id_programa)
	{
		$sql =
				"
					select count(*) as contador 
					from   indicacion,tipo_indicacion,programa
					where  indicacion.id_programa = $id_programa
                    and    indicacion.id_programa = programa.id_programa
                    and    indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
					and    tipo_indicacion.tipo_inspeccion = 'VT'
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getCountIndicacionesProgramaDS($id_programa)
	{
		$sql =
				"
					select count(*) as contador 
					from   indicacion_desalineamiento,tipo_indicacion,programa
					where  indicacion_desalineamiento.id_programa 		    = $id_programa
                    and    indicacion_desalineamiento.id_programa 	 	    = programa.id_programa
                    and    indicacion_desalineamiento.id_tipo_indicacion 	= tipo_indicacion.id_tipo_indicacion
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getCountIndicacionesPrograma($id_programa)
	{
		$sql =
		"
					select count(*) as contador
					from indicacion
					where id_programa = ".$id_programa.";
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getMaxPorcentajeIndicacionPrograma($id_programa)
	{
		$sql =
		"
					select max(porcentaje_perdida) as perdida
					from indicacion
					where id_programa = ".$id_programa.";
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['perdida'];
		return $num;
	}

	function getMaxPorcentajeIndicacionPrograma2($id_programa)
	{
		$sql ="Select IFNULL(Max(porcentaje_perdida),0) as perdida
					from indicacion
					where id_programa = ".$id_programa;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['perdida'];
		return $num;
		//return $sql;
	}

	

	function getMinIndicacionOrden($id_programa,$tipo_inspeccion)
	{
		$sql =
				"
					select min(indicacion.orden) as min
					from indicacion,tipo_indicacion
					where indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion 
					and tipo_indicacion.tipo_inspeccion = '".$tipo_inspeccion."'
					and indicacion.id_programa 			= ".$id_programa.";
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['min'];
		return $num;
	}

	function getMaxIndicacionOrden($id_programa,$tipo_inspeccion)
	{
		$sql =
				"
					select max(indicacion.orden) as max
					from   indicacion,tipo_indicacion
					where  indicacion.id_tipo_indicacion    = tipo_indicacion.id_tipo_indicacion 
					and    tipo_indicacion.tipo_inspeccion  = '".$tipo_inspeccion."'
					and    indicacion.id_programa 			= ".$id_programa.";
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['max'];
		return $num;
	}
	
	function getMaxIndicacionTipo($id_programa,$tipo_indicacion)
	{
		$sql =
				"
					SELECT max(porcentaje_perdida) as max FROM indicacion where id_programa=".$id_programa." and id_tipo_indicacion=".$tipo_indicacion;
				
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['max'];
		return $num;
		//return $sql;
	}

	function getIndicacionOrdenPrograma($id_indicacion,$id_programa,$tipo_inspeccion)
	{
			$sql =
				"
					select indicacion.orden as orden
					from   indicacion,tipo_indicacion
					where  indicacion.id_tipo_indicacion 	= tipo_indicacion.id_tipo_indicacion
					and    tipo_indicacion.tipo_inspeccion 	= '".$tipo_inspeccion."'
					and    id_programa 	  					=  ".$id_programa."
					and    id_indicacion  					=  ".$id_indicacion."
					order  by orden
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['orden'];
		return $num;
	}

	function getIdIndicacionOrdenPrograma($orden,$id_programa,$tipo_inspeccion)
	{
			$sql =
				"
					select indicacion.id_indicacion as indicacion
					from   indicacion,tipo_indicacion
					where  indicacion.id_tipo_indicacion 	= tipo_indicacion.id_tipo_indicacion
					and    tipo_indicacion.tipo_inspeccion  = '".$tipo_inspeccion."'
					and    indicacion.id_programa 	  		=  ".$id_programa."
					and    indicacion.orden 		  		=  ".$orden."
					order  by orden
				";
		
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['indicacion'];
		
		return $num;
	}

	function getIndicacionesParaEvaluacion($id_programa)
	{
		$sql =
		"
					select count(*) as contador
					from indicacion
					inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
					where indicacion.id_programa 		= ".$id_programa."
					and tipo_indicacion.evaluacion_nfr = 1
					 ;
				";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}


	function getIndicacionId($idindicacion){
        $sql = "SELECT * FROM $this->tabla" 
        ." WHERE id_indicacion = ".$idindicacion;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }

	function getJson()
	{
		return json_encode($this->getAll(), true);
	}

	function getIdIndicacion()
	{
		return $this->id_indicacion ;
	}

	function getIdPrograma()
	{
		return $this->id_programa ;
	}

	function getElemento()
	{
		return $this->elemento ;
	}

	function getNoIndicacion()
	{
		return $this->no_indicacion ;
	}

	function getSoldPosReferencia()
	{
		return $this->sold_pos_referencia ;
	}

	function getDistanciaSoldReferencia()
	{
		return $this->distancia_sold_referencia ;
	}

	function getHorarioTecnico()
	{
		return $this->horario_tecnico ;
	}

	function getLargo()
	{
		return $this->largo ;
	}

	function getAncho()
	{
		return $this->ancho ;
	}

	function getProfundidad()
	{
		return $this->profundidad ;
	}

	function getEspesorMinimoZonaSana()
	{
		return $this->espesor_minimo_zona_sana ;
	}

	function getEspesorMaximoZonaSana()
	{
		return $this->espesor_maximo_zona_sana ;
	}

	function getEspesorRemanente()
	{
		return $this->espesor_remanente ;
	}

	function getPorcentajePerdida()
	{
		return $this->porcentaje_perdida ;
	}

	function getDiametro()
	{
		return $this->diametro ;
	}

	function getIdTipoIndicacion()
	{
		return $this->id_tipo_indicacion ;
	}

	function getFechaInspeccion()
	{
		return $this->fecha_inspeccion ;
	}

	function getDiametroPulgadas()
	{
		$diametro = 
				array(
					2.375,
					3.500,
					4.500,
					6.625,
					8.625,
					10.750,
					12.750,
					14.000,
					16.000,
					18.000,
					20.000,
					24.000,
					30.000,
					36.000,
					42.000,
					48.000,
				);
		return $diametro;
	}


 function getIndicacion_Orden($id_programa){
        $sql = "select indicacion.id_tipo_indicacion, indicacion.id_indicacion,  indicacion.id_programa, indicacion.elemento, indicacion.no_indicacion, indicacion.sold_pos_referencia, indicacion.horario_tecnico, indicacion.largo, indicacion.ancho,
                indicacion.profundidad, indicacion.espesor_minimo_zona_sana, indicacion.espesor_maximo_zona_sana, indicacion.espesor_remanente, indicacion.porcentaje_perdida, indicacion.diametro, tipo_indicacion.evaluacion_nfr
                FROM  indicacion 
                inner join programa on indicacion.id_programa = programa.id_programa
                inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
                where programa.id_programa=".$id_programa." and tipo_indicacion.evaluacion_nfr=1 order by orden asc";
        $resultado = $this->conexion->query($sql);
        $arrayindicaciones = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayindicaciones[] = $row ;
            }
            return $arrayindicaciones ;
        }
        else{
            return $arrayindicaciones ;
        }
    }

    function getEspesor_Remanente_Minimo($id_programa)
                {
                            
                            $sql = 
                            "
                            select espesor_remanente as p
                            from indicacion
                            where indicacion.espesor_remanente=(SELECT MIN(espesor_remanente) from indicacion where indicacion.id_programa=".$id_programa.")";
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }


    function getProfundidad_maxima($id_programa)
                {
                            
                        /*    $sql = 
                            "
                            select indicacion.profundidad as p, tipo_indicacion.evaluacion_nfr, tipo_indicacion.id_tipo_indicacion, indicacion.id_tipo_indicacion 
                            from indicacion
                            inner join tipo_indicacion on tipo_indicacion.id_tipo_indicacion = indicacion.id_tipo_indicacion
                            where indicacion.profundidad=(SELECT MAX(profundidad) from indicacion where indicacion.id_programa=".$id_programa." and tipo_indicacion.evaluacion_nfr=1)";
            */
                            $sql = "
								SELECT MAX(profundidad)  as p
								from indicacion
								inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion 
								where tipo_indicacion.evaluacion_nfr=1 and indicacion.id_programa=$id_programa
								";

            $resultado = $this->conexion->query($sql) ;
           
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            
            //return $sql;
            }


//---------------------------------consulta de indicaciones por ductos--------------------


 function getCuentaIndicacionesDucto($id_ducto, $id_tipo_indicacion)
                {
                            $sql = 
                            "select COUNT(indicacion.id_indicacion) as p
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            where linea.id_linea =".$id_ducto." and indicacion.id_tipo_indicacion=".$id_tipo_indicacion;
                        
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }

function getIndicacionesDucto($id_ducto)
                {
                            $sql = 
                            "select linea.id_linea, linea.nombre, orden_servicio.numero_orden, programa.id_programa, programa.km_inicial, km_final, 
                            indicacion.id_indicacion, indicacion.no_indicacion, indicacion.elemento, indicacion.sold_pos_referencia, indicacion.horario_tecnico, indicacion.largo,
                            indicacion.ancho, indicacion.profundidad, indicacion.espesor_minimo_zona_sana, indicacion.espesor_maximo_zona_sana, indicacion.espesor_remanente,
                            indicacion.porcentaje_perdida, indicacion.diametro, tipo_indicacion.id_tipo_indicacion, tipo_indicacion.simbologia, tipo_indicacion.evaluacion, tipo_indicacion.evaluacion_nfr
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            where linea.id_linea = ".$id_ducto. " and tipo_indicacion.evaluacion_nfr=1 order by orden asc";
            $resultado = $this->conexion->query($sql) ;
            $arrayindicaciones = array() ;         
            if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayindicaciones[] = $row ;
            }
            	return $arrayindicaciones ;
            }
            else{
               return $arrayindicaciones ;
            }
            //return $sql;
            }

function getIndicacionesDuctoCount($id_ducto,$tipo,$id_contrato,$tipo_trabajo, $id_compania)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else {
                		$wer='';
                	}

                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
					
					if ($id_compania<>-1) {
                		$wer3= " and compania.id_compania=".$id_compania;
                	} else { $wer3=''; }
					
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            join contrato on linea_has_contrato.id_contrato = contrato.id_contrato
							join compania on contrato.id_compania = compania.id_compania
							where linea_has_contrato.id_linea = ".$id_ducto. " and tipo_indicacion.tipo_inspeccion= '".$tipo."'".$wer.$wer2.$wer3." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			             //return $sql;
            	}

function getIndicacionesDuctoCountTipo($tipo,$id_contrato,$tipo_trabajo, $subdireccion, $id_compania)
                {
                	
    
    
    $condition = "and" ;

        if($id_contrato != -1){
            if($subdireccion != -1 || $tipo_trabajo!=-1 ){
                $condition = $condition . " c.id_contrato = $id_contrato and"  ; 
            }
            else {
                $condition = $condition . " c.id_contrato = $id_contrato "  ; 
            }

        }

        if($subdireccion != -1){
            if($tipo_trabajo!=-1){
                $condition = $condition." c.subdireccion = '$subdireccion' and" ;
            }
            else{
                $condition = $condition." c.subdireccion = '$subdireccion' " ;
            }

        }

        if($tipo_trabajo != -1){
            $condition = $condition." orden_servicio.id_tipo_trabajo = $tipo_trabajo" ;
        }
		
		if ($id_compania != -1){
			if ($subdireccion !=-1 or $id_contrato !=-1 or $tipo_trabajo){
				$condition = $condition." and cia.id_compania = ". $id_compania;
			} else { $condition = $condition." cia.id_compania = ". $id_compania; }
		}




        $sql = "select count(indicacion.id_indicacion) as p
                from indicacion
                join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
                join programa on indicacion.id_programa = programa.id_programa
                join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                join contrato as c on c.id_contrato = linea_has_contrato.id_contrato
				join compania as cia on c.id_compania = cia.id_compania
                where tipo_indicacion.simbologia = '$tipo' " ;

        if($condition != 'and') {

            $sql = $sql . $condition ;

        }

			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            return $num;
					  // return $sql;
                                    
            	}


function getIndicacionesDuctoCount2($id_ducto,$id_contrato,$tipo_trabajo,$id_compania)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
					
					if ($id_compania<>-1) {
                		$wer3= " and compania.id_compania=".$id_compania;
                	} else { $wer3=''; }
					
					
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            join contrato on linea_has_contrato.id_contrato = contrato.id_contrato
							join compania on contrato.id_compania = compania.id_compania
							where linea_has_contrato.id_linea = ".$id_ducto. " and tipo_indicacion.tipo_inspeccion <> 'D'".$wer.$wer2.$wer3." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			             //return $sql;
            	}
				/***************************
					Diego
				*/
function getIndicacionesDuctoCountTipoTecnica($id_ducto,$id_contrato,$tipo_trabajo,$tecnica)
                {
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where linea_has_contrato.id_linea = ".$id_ducto. " 
							and tipo_indicacion.tipo_inspeccion = '".$tecnica."'".$wer.$wer2." 
							order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			             return $num;
			             //return $sql;
            	}

function getIndicacionesDuctoCountTipoTecnicaSimbologia($id_ducto,$id_contrato,$tipo_trabajo,$tecnica,$simbologia)
                {
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql = 
                           "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where linea_has_contrato.id_linea 	= ".$id_ducto. " 
							and tipo_indicacion.tipo_inspeccion = '".$tecnica."'".$wer.$wer2."
							and tipo_indicacion.simbologia 		= '".$simbologia."'
							
							order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			             //return $sql;
            	}
				
function getIndicacionesDuctoCountPorcentaje($id_ducto,$id_contrato,$tipo_trabajo,$value1,$value2, $id_compania)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
					
					if ($id_compania<>-1) {
                		$wer3= " and compania.id_compania=".$id_compania;
                	} else { $wer3=''; }
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
							join contrato on linea_has_contrato.id_contrato = contrato.id_contrato
							join compania on contrato.id_compania = compania.id_compania
                            where linea_has_contrato.id_linea = ".$id_ducto. " and tipo_indicacion.tipo_inspeccion <> 'D' and indicacion.porcentaje_perdida BETWEEN ". $value1 .' AND '. $value2.$wer.$wer2.$wer3." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			            //return $sql;
            	}

function getIndicacionesDuctoCountPorcentajeSimbologia($simbologia,$tipo_inspeccion,$id_ducto,$id_contrato,$tipo_trabajo,$value1,$value2)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where linea_has_contrato.id_linea = ".$id_ducto. " 
							and tipo_indicacion.tipo_inspeccion = '".$tipo_inspeccion."'
							and tipo_indicacion.simbologia = '".$simbologia."'
							and indicacion.porcentaje_perdida BETWEEN ". $value1 .' AND '. $value2.$wer.$wer2." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			            //return $sql;
            	}
				
				
function getIndicacionesDuctoCountTipoPorcentaje($subdireccion, $tipo,$id_contrato,$tipo_trabajo,$value1,$value2, $id_compania)
                {

    
    
    $condition = " and" ;

        if($id_contrato != -1){
            if($subdireccion != -1 || $tipo_trabajo!=-1 ){
                $condition = $condition . " c.id_contrato = $id_contrato and"  ; 
            }
            else {
                $condition = $condition . " c.id_contrato = $id_contrato "  ; 
            }

        }

        if($subdireccion != -1){
            if($tipo_trabajo!=-1){
                $condition = $condition." c.subdireccion = '$subdireccion' and" ;
            }
            else{
                $condition = $condition." c.subdireccion = '$subdireccion' " ;
            }

        }

        if($tipo_trabajo != -1){
            $condition = $condition." orden_servicio.id_tipo_trabajo = $tipo_trabajo" ;
        }
		
		if ($id_compania!=-1){
			if($subdireccion != -1 or $id_contrato != -1 or $tipo_trabajo != -1 ){
				$condition = $condition. " and cia.id_compania=".$id_compania; 
			} else { $condition = $condition. " cia.id_compania=".$id_compania; }
		}




        $sql = "select count(indicacion.id_indicacion) as p
                from indicacion
                join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
                join programa on indicacion.id_programa = programa.id_programa
                join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                join contrato as c on c.id_contrato = linea_has_contrato.id_contrato
				join compania as cia on c.id_compania = cia.id_compania
                where tipo_indicacion.simbologia = '$tipo' and indicacion.porcentaje_perdida BETWEEN ". $value1 ." AND ". $value2 ;

        if($condition != ' and') {

            $sql = $sql . $condition ;

        }
    
    
    
 //   echo $sql ;
    
    
    
    /*
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where tipo_indicacion.simbologia='".$tipo."' and indicacion.porcentaje_perdida BETWEEN ". $value1 .' AND '. $value2.$wer.$wer2." order by indicacion.orden asc";
     * 
     * 
     */
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            return $num;

            	}

function getIndicacionesDuctoCountPorcentajeTotal($id_contrato,$tipo_trabajo,$value1,$value2)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	} else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql = 
                            "select count(indicacion.id_indicacion) as p
							from indicacion
							join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where tipo_indicacion.tipo_inspeccion <> 'D' and indicacion.porcentaje_perdida BETWEEN ". $value1 .' AND '. $value2.$wer.$wer2." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            return $num;
			            //return $sql;
            	}

    function getIndicacionesDuctoCountTotal($tipo,$id_contrato,$tipo_trabajo, $subdireccion, $id_compania)
    {
    
        $condition = "and" ;

        if($id_contrato != -1){
            if($subdireccion != -1 || $tipo_trabajo!=-1 ){
                $condition = $condition . " c.id_contrato = $id_contrato and"  ; 
            }
            else {
                $condition = $condition . " c.id_contrato = $id_contrato "  ; 
            }

        }

        if($subdireccion != -1){
            if($tipo_trabajo!=-1){
                $condition = $condition." c.subdireccion = '$subdireccion' and" ;
            }
            else{
                $condition = $condition." c.subdireccion = '$subdireccion' " ;
            }

        }

        if($tipo_trabajo != -1){
            $condition = $condition." orden_servicio.id_tipo_trabajo = $tipo_trabajo" ;
        }
		
		if($id_compania!= -1){
			if ($subdireccion != -1 or $id_contrato != - 1 or $tipo_trabajo != -1 ){
				$condition = $condition ." and cia.id_compania = ". $id_compania ;
			}	else {
				$condition = $condition ." cia.id_compania = ". $id_compania ;
			}
		}




        $sql = "select count(indicacion.id_indicacion) as p
                from indicacion
                join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
                join programa on indicacion.id_programa = programa.id_programa
                join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
                join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                join contrato as c on c.id_contrato = linea_has_contrato.id_contrato
				join compania as cia on c.id_compania = cia.id_compania
                where tipo_indicacion.tipo_inspeccion = '$tipo' " ;

        if($condition != 'and') {

            $sql = $sql . $condition ;

        }


			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
						//return $sql;
                                    
                                    
                                    
            	}

 function getIndicacionesDuctoCountTotal2($id_contrato,$tipo_trabajo)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_contrato<>-1) {
                		$wer= ' and orden_servicio.id_contrato ='.$id_contrato;
                	}  else { $wer=''; }
                	
                	if ($tipo_trabajo<>-1) {
                		$wer2= " and orden_servicio.id_tipo_trabajo=".$tipo_trabajo;
                	} else { $wer2=''; }
                            $sql =
                            "select count(indicacion.id_indicacion) as p
							from indicacion
                            join tipo_indicacion on  indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
							join programa on indicacion.id_programa = programa.id_programa
							join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio
							join linea_has_contrato on orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
                            where tipo_indicacion.tipo_inspeccion<>'D'".$wer.$wer2." order by indicacion.orden asc";
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            
			            return $num;
			             //return $sql;
            	}


 function getEspesor_Remanente_Minimo_Ducto($id_ducto)
                {
                            $sql = 
                            "
                            select espesor_remanente as p
                            from linea 
                                inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea 
                                inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato 
                                inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio 
                                inner join indicacion on programa.id_programa = indicacion.id_programa 
                                inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion 
                            where indicacion.espesor_remanente=(SELECT MIN(espesor_remanente) from indicacion where linea.id_linea=".$id_ducto.")";
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }


function getProfundidad_Maxima_Ducto($id_ducto)
                {
                            $sql = 
                            "
                            select profundidad as p
                            from linea 
                                inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea 
                                inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato 
                                inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio 
                                inner join indicacion on programa.id_programa = indicacion.id_programa 
                                inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion 
                            where indicacion.profundidad=
                            (
                            	SELECT MAX(profundidad) 
                            	from indicacion 
								inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            	where linea.id_linea=".$id_ducto."
                           		and tipo_indicacion.evaluacion_nfr = 1 
                            )
                             ";
            
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            return $num ;
            //return $sql;
            }


//-------------------------fin de consulta por ductos-------------------------------------

//-------------------------Consulta por una o muchas referencias de una orden-------------------------------------            
function getIndicacionesOrden_Programa($id_orden, $id_programa, $tipo)
                {
                	$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                	if ($id_orden<>-1) {
                		$wer= $wer.' and orden_servicio.id_orden_servicio ='.$id_orden;
                	}
                	
                	if ($id_programa<>-1) {
                		$wer= $wer." and programa.id_programa=".$id_programa;
                	}
                            $sql = 
                            "select linea.id_linea, linea.nombre, orden_servicio.numero_orden, programa.id_programa, programa.km_inicial, km_final, 
                            indicacion.id_indicacion, indicacion.no_indicacion, indicacion.elemento, indicacion.sold_pos_referencia, indicacion.distancia_sold_referencia,indicacion.horario_tecnico, indicacion.largo,
                            indicacion.ancho, indicacion.profundidad, indicacion.espesor_minimo_zona_sana, indicacion.espesor_maximo_zona_sana, indicacion.espesor_remanente,
                            indicacion.porcentaje_perdida, indicacion.diametro, tipo_indicacion.id_tipo_indicacion, tipo_indicacion.simbologia, tipo_indicacion.evaluacion, tipo_indicacion.tipo_inspeccion
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            ".$wer;
            $resultado = $this->conexion->query($sql) ;
            $arrayindicaciones = array() ;         
            if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayindicaciones[] = $row ;
            }
            	return $arrayindicaciones ;
            }
            else{
              return $arrayindicaciones ;
            }
            //return $sql;
            }

function getIndicacionesOrden_Programa_Remanente_Minimo($id_orden, $id_programa)
                {
                    //$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                    if ($id_orden<>-1) {
                        $wer=' where orden_servicio.id_orden_servicio ='.$id_orden;
                    }
                    
                    if ($id_programa<>-1) {
                        $wer= $wer." and programa.id_programa=".$id_programa;
                    }
                            $sql = 

                            "select espesor_remanente as p
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            where indicacion.espesor_remanente=(SELECT MIN(espesor_remanente) from indicacion ".$wer.")";
                            
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }

function getIndicacionesOrden_Programa_Profundidad_Maxima($id_orden, $id_programa)
                {
                    //$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                    if ($id_orden<>-1) {
                        $wer=' Where orden_servicio.id_orden_servicio ='.$id_orden;
                    }
                    
                    if ($id_programa<>-1) {
                        $wer= $wer." and programa.id_programa=".$id_programa;
                    }
                            $sql = 

                            "select profundidad as p
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            where indicacion.profundidad=(SELECT MAX(profundidad) from indicacion ".$wer.")";
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            return $num ;
            //return $sql;
            }
//-------------------------Fin de Consulta por una o muchas referencias de una orden---------------------------------            

function getMaxFecha($id_programa)
                {
                            $sql = 
                            "
                            select fecha_inspeccion as p
                            from indicacion 
                            where fecha_inspeccion=(SELECT MAX(fecha_inspeccion) from indicacion where id_programa=".$id_programa.")";
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }


function getMaxFechaDucto($id_ducto)
{
                            $sql = 
                            "select fecha_inspeccion as p, linea.id_linea, linea.nombre, orden_servicio.numero_orden, programa.id_programa, programa.km_inicial, km_final, 
                            indicacion.id_indicacion, indicacion.no_indicacion, indicacion.elemento, indicacion.sold_pos_referencia, indicacion.horario_tecnico, indicacion.largo,
                            indicacion.ancho, indicacion.profundidad, indicacion.espesor_minimo_zona_sana, indicacion.espesor_maximo_zona_sana, indicacion.espesor_remanente,
                            indicacion.porcentaje_perdida, indicacion.diametro, tipo_indicacion.id_tipo_indicacion, tipo_indicacion.simbologia, tipo_indicacion.evaluacion
                            from linea
                            inner join linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea
                            inner join orden_servicio on linea_has_contrato.id_linea_has_contrato= orden_servicio.id_linea_has_contrato
                            inner join programa on orden_servicio.id_orden_servicio= programa.id_orden_servicio
                            inner join indicacion on programa.id_programa = indicacion.id_programa
                            inner join tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
                            where fecha_inspeccion=(SELECT MAX(fecha_inspeccion) from linea where id_linea=".$id_ducto.")";
            $resultado = $this->conexion->query($sql) ;
            $row = $resultado->fetch_assoc();
            $num= $row['p'];
            
            return $num ;
            //return $sql;
            }

function getFotografia_indicacion($id_indicacion)
{
                            $sql = 
                            "select * 
                            from indicacion_foto
							inner join indicacion on indicacion_foto.id_indicacion = indicacion.id_indicacion
							where indicacion.id_indicacion =".$id_indicacion;
            $resultado = $this->conexion->query($sql) ;
            $arrayindicaciones = array() ;         
            if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayindicaciones[] = $row ;
            }
            	return $arrayindicaciones ;
            }
            else{
              return $arrayindicaciones ;
            }
            
            return $num ;
            //return $sql;
            }

function getIndicacionesProgramaLinea($id_programa, $value1, $value2)
                {
                	//$wer="Where tipo_indicacion.tipo_inspeccion= '".$tipo."'";
                            $sql = 
                            "select count(id_indicacion) as p
							from indicacion
                            where porcentaje_perdida BETWEEN ". $value1 .' AND '. $value2. ' and id_programa='.$id_programa;
			             $resultado = $this->conexion->query($sql) ;
			             $row = $resultado->fetch_assoc();
			             $num= $row['p'];
			            return $num;
			           // return $sql;
            	}
}


?>