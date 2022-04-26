<?php
	include_once("Database.php");

	class Acta{

		private $id ;
		private $acta ;
		private $clave_anomalia ;


	
	

		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "acta" ;
		}

		function insert( $acta ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$acta['acta']."',
				'".$acta['clave_anomalia']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}

		function updateReferenciaacta($id, $acta){
			$sql= "update $this->tabla set acta=".$acta."
			where id_acta= $id";
			mysql_query($sql,$this->conexion);
			//return $sql;
		}


		function update( $acta ) {
			$sql = "update $this->tabla set 
				acta 		      = '".$acta['acta']."',
				clave_anomalia 	   = '".$acta['clave_anomalia']."',
				where idacta =" . $acta['idacta'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $acta ) {
			$sql = "select * from $this->tabla where id_acta = $acta" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 				= mysql_fetch_assoc($resultado);
				$this->id 				= $registro['idacta'] ;
				$this->acta 		    = $registro['acta'] ;
				$this->clave_anomalia   = $registro['clave_anomalia'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		function getActa(){
			return $this->acta ;
		}

		function getClave_Anomalia(){
			return $this->clave_anomalia ;
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