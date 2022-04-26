<?php
	include_once("Database.php");

	class Anomalia{

		private $id ;
		private $nomenclatura ;
		private $descripcion;
		
		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "anomalia" ;
		}

		function insert( $anomalia ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$anomalia['nomenclatura']."',
				'".$anomalia['descripcion']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}



		function update( $anomalia ) {
			$sql = "update $this->tabla set 
				nomenclatura 		      = '".$anomalia['nomenclatura']."',
				descripcion 		  	  = '".$anomalia['descripcion']."'
				where idanomalia =" . $anomalia['idanomalia'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $anomalia ) {
			$sql = "select * from $this->tabla where id_anomalia = $anomalia" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 					= mysql_fetch_assoc($resultado);
				$this->id 					= $registro['id_anomalia'] ;
				$this->nomenclatura       	= $registro['nomenclatura'] ;
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

		function getNomenclatura(){
			return $this->nomenclatura ;
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