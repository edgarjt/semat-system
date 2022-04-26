<?php
	include_once("Database.php");

	class Sector{

		private $id ;
		private $descripcion ;
	
		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "sector" ;
		}

		function insert( $sector ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$sector['descripcion']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}



		function update( $sector ) {
			$sql = "update $this->tabla set 
				descripcion 		      = '".$sector['descripcion']."'
				where idsector =" . $sector['idsector'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $sector ) {
			$sql = "select * from $this->tabla where idsector = $sector" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 				= mysql_fetch_assoc($resultado);
				$this->id 				= $registro['idsector'] ;
				$this->descripcion 		= $registro['descripcion'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		
		function getDescripcion(){
			return $this->descripcion ;
		}

		

	
	

		function getAll(){
			$sql = "Select * from $this->tabla" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
		}



	

	}
?>