<?php
	include_once("Database.php");

	class Bitacora{

		private $id ;
		private $idusuario ;
		private $tabla2 ;
		private $idtabla ;
		private $accion ;

		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "bitacora" ;
		}

		function insert( $bitacora ) {
			$sql = "insert into $this->tabla values(
				0,
				".$bitacora['idusuario'].",
				'".$bitacora['tabla']."',
				".$bitacora['idtabla'].",
				'".$bitacora['accion']."',
				'".$bitacora['fecha']."'
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}

		function updateReferenciabitacora($id, $bitacora){
			$sql= "update $this->tabla set bitacora=".$bitacora."
			where idbitacora= $id";
			mysql_query($sql,$this->conexion);
			//return $sql;
		}


		

		function loadById( $bitacora ) {
			$sql = "select * from $this->tabla where id_bitacora = $bitacora" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 				= mysql_fetch_assoc($resultado);
				$this->id 				= $registro['idbitacora'] ;
				$this->idusuario    	= $registro['idusuario'] ;
				$this->tabla2 			= $registro['tabla'] ;
				$this->idtabla 			= $registro['idtabla'] ;
				$this->accion 		 	= $registro['accion'] ;
				$this->fecha 		   	= $registro['fecha'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		function getIdUsuario(){
			return $this->idusuario ;
		}

		function getTabla(){
			return $this->tabla2 ;
		}

		function getIdTabla(){
			return $this->idtabla ;
		}

		function getAccion(){
			return $this->accion ;
		}

		function getFecha(){
			return $this->fecha ;
		}

		function getAllTablas(){
			$sql = "SELECT tabla FROM bitacora group by tabla order by tabla desc";
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
		}

		function getAvanceCaptura($f1){
			include_once("Usuario.php");
					//include_once("Bitacora.php");
					$usuario = new Usuario();
					//$bitacora = new Bitacora();

					$res2= array();	
					$usuarios = $usuario->getUsuarioActivos();
					$bitacoras = $this->getAllTablas();
					foreach ($bitacoras as $value) {
								$res= array();	
								foreach ($usuarios as $key) {
									$sql = "SELECT count(idbitacora) as p ".
									"from $this->tabla ".
									"Where idusuario = ". $key['idusuario'] ." and tabla='".$value['tabla']."' AND (fecha BETWEEN '".$f1['fecha1'] . "' AND '".$f1['fecha2']."')" ;
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['nombre']]= $c;
									}
								$res['tabla']= $value['tabla'];
								$res2[] = $res;
						}
					return $res2 ;
					//return $sql;
		}


		function getAvanceCaptura2(){
					include_once("Usuario.php");
					//include_once("Bitacora.php");
					$usuario = new Usuario();
					//$bitacora = new Bitacora();

					$res2= array();	
					$usuarios = $usuario->getUsuarioActivos();
					$bitacoras = $this->getAllTablas();
					foreach ($bitacoras as $value) {
								$res= array();	
								foreach ($usuarios as $key) {
									$sql = "SELECT count(idbitacora) as p ".
									"from $this->tabla ".
									"Where idusuario = ". $key['idusuario'] ." and tabla='".$value['tabla']."'";
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['nombre']]= $c;
								}
								$res['tabla']= $value['tabla'];
								$res2[] = $res;
						}
					return $res2 ;
					//return $sql;
			}

		function getContarAvance($f){
			$sql = "select COUNT(bitacora.idbitacora) as p, bitacora.idusuario, bitacora.tabla, usuario.nombre $this->tabla" 
				   ." inner join usuario on bitacora.idusuario = usuario.idusuario"
				   ." group by bitacora.tabla order by bitacora.tabla desc, bitacora.idusuario";
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			/*if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}*/
			//return $resultados ;
			return $sql;
		}

		function getContarAvance2(){
			$sql = "select COUNT(bitacora.idbitacora) as p, bitacora.idusuario, bitacora.tabla, usuario.nombre from " .$this->tabla
				   ." inner join usuario on bitacora.idusuario = usuario.idusuario"
				   ." group by bitacora.tabla order by bitacora.tabla desc, bitacora.idusuario";
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
			//return $sql;
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