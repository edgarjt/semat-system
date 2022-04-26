<?php
	include_once ("Database.php");
	class Ddv
	{
		private $id_ddv ;
		private $id_sector;
		private $descripcion ;
		private $alias;
		private $denominacion_tecnica ;
		private $longitud ;
		private $archivo_kmz ;
		private $conexion ;
		private $tabla ;

		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ddv" ;
		}

		function insert($registro)
		{
			$archivo_kmz  ="0";
			$sql_1 		  = "insert into $this->tabla 
			(
				descripcion,
				alias,
				denominacion_tecnica,
				longitud,
				archivo_kmz,
				id_sector
			)
			values
			(
				'".strtoupper($registro['descripcion'])."',
				'".strtoupper($registro['alias'])."',
				'".strtoupper($registro['denominacion_tecnica'])."',
				'".$registro['longitud']."',
				'0',
				".$registro['id_sector']."
			)";
				//return $sql_1;
					$this->conexion->query($sql_1) ;

					$archivo_kmz;
					$id_ddv 	= $this->conexion->insert_id ;
					$bandera 	= 1;
					$path 		= $_FILES['archivo_kmz']['name'];
					$ext 		= pathinfo($path, PATHINFO_EXTENSION);

			if($_FILES["archivo_kmz"]['tmp_name'] =="")
			{
					$archivo_kmz 	= 0;
					$bandera		= 0;
			}
			else if ($ext == 'kmz' && $id_ddv > 0 && $bandera != 0) 
			{
						//Este es el nombre de la carpeta, posiblemente el numero del ID
						$kmz			= $id_ddv;
						$subcarpeta 	= "ddv";
						$archivo_kmz 	= $subcarpeta."/".$kmz.".kmz";
						if (!empty($registro))  
						{	
							copy($_FILES["archivo_kmz"]['tmp_name'],$archivo_kmz);
							$bandera = 1;
						}
			}
			else
			{
				$bandera = 2;
			}
					$sql  = 
							"
								UPDATE $this->tabla
								SET 
								archivo_kmz			    = '".$archivo_kmz."'
								WHERE id_ddv    		=  ".$id_ddv."; 
							";
					 $this->conexion->query($sql) ;
					 return $bandera;
					 
		}

		function update($registro,$id_ddv)
		{
			$sql = 
					"
						SELECT archivo_kmz FROM $this->tabla
						WHERE id_ddv = ".$id_ddv."
					";
			$resultado = $this->conexion->query($sql) ;
			$row = $resultado->fetch_assoc();
			$existe_kmz	= $row['archivo_kmz'];

					$bandera=1;
					$archivo_kmz = $existe_kmz;
					$path 		 = $_FILES['archivo_kmz']['name'];
					$ext 		 = pathinfo($path, PATHINFO_EXTENSION);
	
			if($_FILES["archivo_kmz"]['tmp_name'] =="")
			{
					$bandera = 0;
			}
			else if ($ext == 'kmz' && $id_ddv > 0 && $bandera != 0) 
			{
						//Este es el nombre de la carpeta, posiblemente el numero del ID
						$kmz			= $id_ddv;
						$subcarpeta 	= "ddv";
						$archivo_kmz 	= $subcarpeta."/".$kmz.".kmz";
						if (!empty($registro))  
						{	
							copy($_FILES["archivo_kmz"]['tmp_name'],$archivo_kmz);
							$bandera = 1;
						}
			}
			else
			{
				$bandera = 2;
			}

			$sql  = 
			"
				UPDATE $this->tabla
				SET 
				id_sector 		=  ".$registro['id_sector'].",				
				descripcion 			= '".strtoupper($registro['descripcion'])."',
				alias 					= '".strtoupper($registro['alias'])."',
				denominacion_tecnica 	= '".strtoupper($registro['denominacion_tecnica'])."',
				longitud 			    = '".$registro['longitud']."',
				archivo_kmz 		    = '".$archivo_kmz."'
				WHERE id_ddv 			=  ".$id_ddv."; 
			";
				//return $sql;
				$this->conexion->query($sql) ;
				return $bandera;
				
		}

		function delete($id_ddv)
		{
			$path = "ddv/".$id_ddv.".kmz";
			unlink($path);
			$sql = 
			"
				DELETE FROM $this->tabla
				WHERE id_ddv = ".$id_ddv.";
			";
				return 	$this->conexion->query($sql) ;
		}

		function loadById($id_ddv)
		{
			$sql = "select * from $this->tabla where id_ddv = $id_ddv" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0)
			{
				$row = $resultado->fetch_assoc();
				$this->id_ddv 	   			= $row['id_ddv'] 		;
				$this->id_sector  			= $row['id_sector'] 	;
				$this->descripcion 	    	= $row['descripcion'] 	;
				$this->alias		 		= $row['alias']			;
				$this->denominacion_tecnica = $row['denominacion_tecnica'];
				$this->longitud 			= $row['longitud'] 		;
				$this->archivo_kmz 	   		= $row['archivo_kmz'] 	;
			}
			return $resultado->num_rows ;
		}

		function getAll()
		{
			$sql = "select * from $this->tabla order by alias " ;
			$resultado = $this->conexion->query($sql) ;
			$ddv = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$ddv[] = $row ;
				}
			}
			return $ddv ;
		}

		function getAllDDV($id_ddv)
		{
			$sql = 
			"
					SELECT * 																
					FROM  $this->tabla
					WHERE id_ddv = ".$id_ddv."
					ORDER BY id_ddv DESC
			" ;
			$resultado = $this->conexion->query($sql);
			$ddv = array();
			if($resultado->num_rows > 0)
			{
				while($row = $resultado->fetch_assoc())
				{
					$ddv[] = $row ;
				}
			}
			return $ddv ;
		}

		function getIdDdv()
		{
			return $this->id_ddv ;
		}

		function getIdSector()
		{
			return $this->id_sector ;
		}

		function getDescripcion()
		{
			return $this->descripcion ;
		}

		function getAlias()
		{
			return $this->alias ;
		}

		function getDenominacionTecnica()
		{
			return $this->denominacion_tecnica ;
		}

		function getLongitud()
		{
			return $this->longitud ;
		}

		function getArchivoKmz()
		{
			return $this->archivo_kmz ;
		}
}
?>