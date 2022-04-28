<?php
	//include_once ("Database.php");

	class Compania{
		private $id ;
		private $nombre;
		private $alias;


		private $conexion ;

		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "compania" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'". strtoupper( $registro['nombre'] ) ."',
				'". strtoupper( $registro['alias'] ) ."'
				)";
		$this->conexion->query($sql) ;
		return $this->conexion->insert_id ;
		//return $sql;
		}


		function update($registro,$id_compania)
	{
			$sql =
			"
				UPDATE $this->tabla
				SET 
				nombre      				 = '".strtoupper($registro['nombre'])."',
				alias       				 	 = '".strtoupper($registro['alias'])."'
				WHERE id_compania 			 		 =  ".$id_compania."; 
			";
				return 	$this->conexion->query($sql) ;
				//return $sql;
	}

	function delete($id_compania)
	{
			$sql =
			"
				DELETE FROM $this->tabla
				WHERE id_compania = ".$id_compania.";
			";
				return 	$this->conexion->query($sql) ;
	}



		function loadById($elemento){
			$sql = "select * from $this->tabla where id_compania = $elemento" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id = $row['id_compania'] ;
				$this->nombre = $row['nombre'] ;
				$this->alias = $row['alias'] ;
				
			}
			return $resultado->num_rows ;
		}

	function getAll(){
		$sql = "select * from $this->tabla " ;
		$resultado = $this->conexion->query($sql) ;
		$companias = array() ;
		if($resultado->num_rows>0){
			while ($row = $resultado->fetch_assoc() ) {
				$companias[] = $row ;
			}
		}

		return $companias ;
	}

	function getJson(){
			return json_encode($this->getAll(), true);
		}

	function getId(){
		return $this->id ;
	}

	function getnombre(){
		return $this->nombre ;
	}

	function getAlias(){
		return $this->alias ;
	}

}
?>