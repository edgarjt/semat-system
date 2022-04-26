<?php
	include_once("Database.php");

	class Estatus{

		private $id ;
		private $descripcion;
	
		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "estatus" ;
		}

		function insert( $estatus ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$estatus['descripcion']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}



		function update( $estatus ) {
			$sql = "update $this->tabla set 
				nomenclatura 		      = '".$estatus['nomenclatura']."',
				where idestatus =" . $estatus['idestatus'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $estatus ) {
			$sql = "select * from $this->tabla where idestatus = $estatus" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 					= mysql_fetch_assoc($resultado);
				$this->id 					= $registro['idestatus'] ;
				$this->descripcion   		= $registro['descripcion'] ;
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