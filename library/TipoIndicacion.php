<?php
	//include_once ("Database.php");

	class TipoIndicacion
	{
		private $id_tipo_indicacion ;
		private $descripcion;
		private $simbologia;
		private $tipo_inspeccion;
		private $evaluacion;
		private $evaluacion_nfr;
		

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "tipo_indicacion" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".strtoupper($registro['descripcion'])."',
				'".strtoupper($registro['simbologia'])."',
				'".strtoupper($registro['tipo_inspeccion'])."',			
				".$registro['evaluacion'].",
				".$registro['evaluacion_nfr']."
				
				)";
		$this->conexion->query($sql) ;
		return $this->conexion->insert_id ;
		//return $sql;
		}

		function update($registro)
		{
			$sql =
			"
				UPDATE $this->tabla
				SET 
				descripcion      				 	 = '".strtoupper($registro['descripcion'])."',
				simbologia      				 	 = '".strtoupper($registro['simbologia'])."',
				tipo_inspeccion      				 = '".strtoupper($registro['tipo_inspeccion'])."',
				evaluacion      				 	 =  ".$registro['evaluacion'].",
				evaluacion_nfr     				 	 =  ".$registro['evaluacion_nfr']."
				WHERE id_tipo_indicacion 			 =  ".$registro['id_tipo_indicacion']."; 
			";
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function delete($id_tipo_indicacion)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE  id_tipo_indicacion = ".$id_tipo_indicacion.";
			";
				return 	$this->conexion->query($sql) ;
	}

	function loadById($id_tipo_indicacion)
	{
			$sql = "select * from $this->tabla where id_tipo_indicacion = $id_tipo_indicacion" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_tipo_indicacion = $row['id_tipo_indicacion'] ;
				$this->descripcion 		  = $row['descripcion'] ;
				$this->simbologia 		  = $row['simbologia'] ;
				$this->tipo_inspeccion    = $row['tipo_inspeccion'] ;
				$this->evaluacion 		  = $row['evaluacion'] ;
				$this->evaluacion_nfr  	  = $row['evaluacion_nfr'] ;
			}
			return $resultado->num_rows ;
			//return $sql;
	}

	function loadBySimbologia($simbologia)
	{
			$sql = "select * from $this->tabla where simbologia = '$simbologia'" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_tipo_indicacion = $row['id_tipo_indicacion'] ;
				$this->descripcion 		  = $row['descripcion'] ;
				$this->simbologia 		  = $row['simbologia'] ;
				$this->tipo_inspeccion    = $row['tipo_inspeccion'] ;
				$this->evaluacion 		  = $row['evaluacion'] ;
				$this->evaluacion_nfr 	  = $row['evaluacion_nfr'] ;

			}
			return $resultado->num_rows ;
			//return $sql;
	}



	function getAll()
	{
		$sql = "select * from $this->tabla order by tipo_inspeccion asc " ;
		$resultado = $this->conexion->query($sql) ;
		$tipo_indicacion = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$tipo_indicacion[] = $row ;
			}
		}
		return $tipo_indicacion ;
	}

	function getAllOrder()
	{
		$sql = "select * from $this->tabla order by  tipo_inspeccion,simbologia asc " ;
		$resultado = $this->conexion->query($sql) ;
		$tipo_indicacion = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$tipo_indicacion[] = $row ;
			}
		}
		return $tipo_indicacion ;
	}
	
	function getAllTipoInspeccion($tipo_inspeccion)
	{
		$sql =
		"
		select *
		from $this->tabla
		WHERE tipo_inspeccion = '".$tipo_inspeccion."'
		" ;
		$resultado = $this->conexion->query($sql) ;
		$tipo_indicacion = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$tipo_indicacion[] = $row ;
			}
		}
		return $tipo_indicacion ;
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
	
	function getAllCountTipoInspeccion($tipo_inspeccion)
	{
		$sql =
		"
		SELECT count(*) as contador
		FROM $this->tabla
		WHERE tipo_inspeccion = '".$tipo_inspeccion."'
		";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getJson()
	{
			return json_encode($this->getAll(), true);
	}

	function getIdTipoIndicacion()
	{
		return $this->id_tipo_indicacion ;
	}

	function getDescripcion()
	{
		return $this->descripcion ;
	}

	function getSimbologia()
	{
		return $this->simbologia ;
	}

	function getTipoInspeccion()
	{
		return $this->tipo_inspeccion ;
	}

	function getEvaluacion()
	{
		return $this->evaluacion ;
	}

	function getEvaluacionNfr()
	{
		return $this->evaluacion_nfr ;
	}

/**


********/

	function getAllTipoInspeccionPrograma($id_programa)
	{
		$sql = "
		select distinct tipo_indicacion.simbologia from tipo_indicacion,indicacion
		where indicacion.id_programa = $id_programa
		and indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion";
		$resultado = $this->conexion->query($sql) ;
		$tipo_indicacion = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc())
			{
				$tipo_indicacion[] = $row ;
			}
		}
		//return $sql;
		return $tipo_indicacion ;
	}

	function getAllCountSimbologiaPrograma($simbologia,$id_programa)
	{
		$sql =
		"
		select count(*) as contador
		from tipo_indicacion,indicacion
		where indicacion.id_programa = $id_programa
		and indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
		and tipo_indicacion.simbologia = '$simbologia'
		";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}

	function getAllCountSimbologia($simbologia)
	{
		$sql =
		"
		select count(*) as contador
		from   tipo_indicacion,indicacion
		where  indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion
		and    tipo_indicacion.simbologia 	 = '$simbologia'
		";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
	}
/*
	function getAllCountSimbologiaContratoOrdenTrabajo($simbologia, $id_contrato, $id_orden, $id_tipo_trabajo)
	{
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(*) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
		where tipo_indicacion.simbologia = '".$simbologia."'".$wer.$wer2;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
		//return $sql;
	}
*/
	function getAllCountSimbologiaLineaContratoOrdenTrabajo($simbologia,$id_linea, $id_contrato, $id_orden, $id_tipo_trabajo)
	{
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(*) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo

		inner join linea_has_contrato on contrato.id_contrato = contrato.id_contrato
        inner join linea on linea_has_contrato.id_linea = linea.id_linea

		where tipo_indicacion.simbologia = '".$simbologia."'".$wer.$wer2."
		and   linea.id_linea = ".$id_linea;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
		//return $sql;
	}

	/*function getAllCountContratoOrdenTrabajo($id_contrato, $id_orden, $id_tipo_trabajo, $inspeccion)
	{
							$simbologia='%';
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(indicacion.id_indicacion) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
		where tipo_indicacion.simbologia = '".$simbologia."'".$wer.$wer2." and tipo_indicacion.tipo_inspeccion='".$inspeccion."'";
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		//return $sql;
		return $num;
		
	}*/

	function getAllCountLineaContratoOrdenTrabajo($id_linea,$id_contrato, $id_orden, $id_tipo_trabajo, $inspeccion)
	{
							$simbologia='%';
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(*) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo

		inner join linea_has_contrato on contrato.id_contrato = linea_has_contrato.id_contrato
        inner join linea on linea_has_contrato.id_linea = linea.id_linea

		where tipo_indicacion.simbologia like '".$simbologia."'".$wer.$wer2." 
		and   tipo_indicacion.tipo_inspeccion='".$inspeccion."'
        and   linea.id_linea = '".$id_linea."' "
		 ;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		//return $sql;
		return $num;		
	}

	function getAllCountSimbologiaContratoOrdenTrabajoPorcentaje($simbologia, $id_contrato, $id_orden, $id_tipo_trabajo, $p_inicial, $p_final)
	{
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(*) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
		where tipo_indicacion.simbologia = '".$simbologia."'".$wer.$wer2.' and indicacion.porcentaje_perdida BETWEEN '.$p_inicial .' and '.$p_final;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
		//return $sql;
	}

	function getAllCountSimbologiaLineaContratoOrdenTrabajoPorcentaje($simbologia,$id_linea,$id_contrato, $id_orden, $id_tipo_trabajo, $p_inicial, $p_final)
	{
							if ($id_contrato==-1) {
								$wer='';
							} else {
								$wer=' and contrato.id_contrato='.$id_contrato;
								if ($id_orden<>-1) {
									$wer=$wer.' and orden_servicio.id_orden_servicio='.$id_orden;
								}
							}

							if ($id_tipo_trabajo==-1) {
								$wer2='';
							} else {
								$wer2= ' and tipo_trabajo.id_tipo_trabajo='.$id_tipo_trabajo;
							}
		$sql =
		"
		select count(*) as contador
		from   indicacion
		inner join tipo_indicacion on indicacion.id_tipo_indicacion= tipo_indicacion.id_tipo_indicacion
		inner join programa on indicacion.id_programa = programa.id_programa
		inner join orden_servicio on programa.id_orden_servicio = orden_servicio.id_orden_servicio 
		inner join contrato on orden_servicio.id_contrato = contrato.id_contrato
		inner join tipo_trabajo on orden_servicio.id_tipo_trabajo = tipo_trabajo.id_tipo_trabajo
		
		inner join linea_has_contrato on contrato.id_contrato = contrato.id_contrato
        inner join linea on linea_has_contrato.id_linea = linea.id_linea
        
		where tipo_indicacion.simbologia = '".$simbologia."'".$wer.$wer2.' 
		and indicacion.porcentaje_perdida BETWEEN '.$p_inicial .' 
		and linea.id_linea = '.$id_linea.'
		and '.$p_final;
		$resultado = $this->conexion->query($sql) ;
		$row = $resultado->fetch_assoc();
		$num = $row['contador'];
		return $num;
		//return $sql;
	}
	
}
?>