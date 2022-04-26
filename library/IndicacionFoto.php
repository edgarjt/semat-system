<?php
	include_once ("Database.php");

	class IndicacionFoto
	{
		private $id_indicacion_foto ;
		private $id_indicacion;
		private $archivo;
		private $descripcion;
		
		private $conexion ;
		private $tabla ;

		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "indicacion_foto" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				".$registro['id_indicacion'].",
				'0',
				'".strtoupper($registro['descripcion'])."',
				1			
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
				id_indicacion      				 =  ".$registro['id_indicacion'].",
				archivo      				 	 = '".$registro['archivo']."',
				descripcion      				 = '".strtoupper($registro['descripcion'])."'
				WHERE id_indicacion_foto 		 =  ".$registro['id_indicacion_foto']."; 
			";
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function updateFoto($registro, $valor)
		{
			$sql =
			"
				UPDATE $this->tabla
				SET 
				reporte      				 =  $valor
				WHERE id_indicacion_foto 		 =  $registro";
				echo $sql ;
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function delete($id_indicacion_foto)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE id_indicacion_foto = ".$id_indicacion_foto.";
			";
				return 	$this->conexion->query($sql) ;
	}

	function deleteByIdIndicacion($id_indicacion)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE id_indicacion = ".$id_indicacion.";
			";
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}


	function loadById($id_indicacion_foto)
	{
			$sql = "select * from $this->tabla where id_indicacion_foto = $id_indicacion_foto" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_indicacion_foto   = $row['id_indicacion_foto'] ;
				$this->id_indicacion 		= $row['id_indicacion'] ;
				$this->archivo 		  		= $row['archivo'] ;
				$this->descripcion    		= $row['descripcion'] ;
			}
			return $resultado->num_rows ;
	}

	function loadByIdIndicacion($id_indicacion)
	{
			$sql = "select * from $this->tabla where id_indicacion = $id_indicacion" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc() ;
				$this->id_indicacion_foto   = $row['id_indicacion_foto'] ;
				$this->id_indicacion 		= $row['id_indicacion'] ;
				$this->archivo 		  		= $row['archivo'] ;
				$this->descripcion    		= $row['descripcion'] ;
			}
			return $resultado->num_rows ;
	}

	function getAll()
	{
		$sql = "select * from $this->tabla " ;
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

	function getAllByIdIndicacion($id_indicacion)
	{
		$sql = "select * 
				from $this->tabla 
				where id_indicacion = ".$id_indicacion."";
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

	function getAllByIdIndicacionArray($id_indicacion)
	{
		$sql = "select indicacion_foto 
				from $this->tabla 
				where id_indicacion = ".$id_indicacion."";
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


	function getFotoIdPrograma($id_programa)
	{
		$sql = "select * from $this->tabla 
				inner join indicacion on indicacion_foto.id_indicacion = indicacion.id_indicacion
				inner join programa on indicacion.id_programa = programa.id_programa
				where programa.id_programa = ".$id_programa;
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

	function getCountAllByIdIndicacion($id_indicacion)
	{
			$sql =
				 "
					SELECT count(*) as p
					from $this->tabla 
					where id_indicacion = ".$id_indicacion." 
				 ";
					$resultado = $this->conexion->query($sql) ;
					$row       = $resultado->fetch_assoc();
					$num       = $row['p'];
					return $num ;
					//return $sql;
	}
	
	function getJsonByIndicacion($id_indicacion)
	{
		$sql = 
		"
		select archivo 
		from indicacion_foto 
		where id_indicacion = ".$id_indicacion."
		";
		$resultado = $this->conexion->query($sql) ;
		$contratos = array() ;
		if($resultado->num_rows>0)
		{
			while ($row = $resultado->fetch_assoc() )
			{
				$contratos[] = $row ;
			}
		}
			return json_encode($contratos, true);
	}

	function getJson()
	{
		return json_encode($this->getAll(), true);
	}

	function getIdIndicacionFoto()
	{
		return $this->id_indicacion_foto ;
	}

	function getIdIndicacion()
	{
		return $this->id_indicacion ;
	}

	function getArchivo()
	{
		return $this->archivo ;
	}

	function getDescripcion()
	{
		return $this->descripcion ;
	}
}
?>