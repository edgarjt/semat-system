<?php
	include_once("Database.php");

	class Ubicacion_Tecnica{

		private $id ;
		private $descripcion ;
		private $idsector;
		private $denominacion_zona;
	
		private $tabla 	;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ubicacion_tecnica" ;
		}

		function insert( $ubicacion_tecnica ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$ubicacion_tecnica['descripcion']."',
				'".$ubicacion_tecnica['idsector']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}



		function update( $ubicacion_tecnica ) {
			$sql = "update $this->tabla set 
				descripcion 		      = '".$ubicacion_tecnica['descripcion']."',
				idsector 		  		  = '".$ubicacion_tecnica['idsector']."'
				where idubicacion_tecnica =" . $ubicacion_tecnica['idubicacion_tecnica'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $ubicacion_tecnica ) {
			$sql = "select * from $this->tabla where idubicacion_tecnica = $ubicacion_tecnica" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 					= mysql_fetch_assoc($resultado);
				$this->id 					= $registro['idubicacion_tecnica'] ;
				$this->descripcion       	= $registro['descripcion'] ;
				$this->idsector   			= $registro['idsector'] ;
				$this->denominacion_zona    = $registro['denominacion_zona'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		
		function getDescripcion(){
			return $this->descripcion ;
		}

		function getIdSector(){
			return $this->idsector ;
		}

		function getDenominacion_zona(){
			return $this->denominacion_zona;
		}


		function getAll(){
			$sql = "Select * from $this->tabla order by idsector" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
		}

		function getUbicacionSector($sector){
			$sql = "Select * from $this->tabla Where idsector = ".$sector ." order by idsector" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
		}

		function getJsonUbicacion($idsector){
			$sql = "Select * from $this->tabla Where idsector = ". $idsector ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return json_encode($resultados)  ;
		}

		function getJsonAlias($idubicacion_tecnica){
			$sql = "Select * from $this->tabla Where idubicacion_tecnica = ". $idubicacion_tecnica ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return json_encode($resultados)  ;
		}


	}
?>