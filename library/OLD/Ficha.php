<?php
	include_once("Database.php");

	class Ficha{

		private $id ;
		private $clave_anomalia ;
		private $descripcion ;
		private $foto ;
		private $fecha_celaje ;
		private $orden;

	
	

		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ficha" ;
		}

		function insert( $ficha ) {
			$sql = "insert into $this->tabla values(
				0,
				'".$ficha['clave_anomalia']."',
				'".$ficha['descripcion']."',
				'".$ficha['foto']."',
				'".$ficha['fecha_celaje']."',
				'".$ficha['orden']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}

		function updateReferenciaficha($id, $ficha){
			$sql= "update $this->tabla set ficha=".$ficha."
			where idficha= $id";
			mysql_query($sql,$this->conexion);
			//return $sql;
		}


		function update( $ficha ) {
			$sql = "update $this->tabla set 
				clave_anomalia 		      = '".$ficha['clave_anomalia']."',
				descripcion 			  = '".$ficha['descripcion']."',
				foto		              = '".$ficha['foto']."',
				fecha_celaje		      = '".$ficha['fecha_celaje']."',
				orden  			          = '".$ficha['orden']."'
				where idficha             = " . $ficha['idficha'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $ficha ) {
			$sql = "select * from $this->tabla where idficha = $ficha" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 				= mysql_fetch_assoc($resultado);
				$this->id 				= $registro['idficha'] ;
				$this->clave_anomalia 	= $registro['clave_anomalia'] ;
				$this->descripcion 		= $registro['descripcion'] ;
				$this->foto 			= $registro['foto'] ;
				$this->fecha_celaje 	= $registro['fecha_celaje'] ;
				$this->orden 		   	= $registro['orden'] ;
			}
			return $rows ;
		}

		function fechacelaje( $ficha ) {
			$sql = "select * from $this->tabla where idhallazgo = $ficha order by idficha desc limit 1" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 				= mysql_fetch_assoc($resultado);
				$this->fecha_celaje 	= $registro['fecha_celaje'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		function getClave_anomalia(){
			return $this->clave_anomalia ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getfoto(){
			return $this->Foto ;
		}

		function getFecha_Celaje(){
			return $this->fecha_celaje ;
		}

		function getorden(){
			return $this->Orden ;
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