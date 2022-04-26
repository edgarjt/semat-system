<?php
	include_once("Database.php");
	

	class Hallazgo{

		private $id ;
		private $clave_anomalia ;
		private $ubicacion_tecnica;
		private $denominacion ;
		private $periodo ;
		private $clase;
		private $km;
		private $tipo;
		private $anomalia;
		private $descripcion;
		private $cantidad;
		private $utm_e;
		private $utm_n;
		private $fecha_de_deteccion;
		private $foto1;
		private $foto2;
		private $denominacion_zona;
		private $idsector;
	
	
	

		private $tabla 		;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "hallazgo" ;
		}

		function insert( $hallazgo ) {
			$sql = "insert into $this->tabla values(
				0,
				'".strtoupper($hallazgo['claveanomalia'])."',
				'".strtoupper($hallazgo['denominacion'])."',
				'".strtoupper($hallazgo['periodo'])."',
				'".$hallazgo['clase']."',
				'".strtoupper($hallazgo['km'])."',
				'".$hallazgo['tipo']."',
				'".strtoupper($hallazgo['descripcion'])."',
				'".$hallazgo['cantidad']."',
				'".$hallazgo['utm_e']."',
				'".$hallazgo['utm_n']."',
				'".$hallazgo['fecha_de_deteccion']."',
				'".$hallazgo['foto1']."',
				'".$hallazgo['foto2']."',
				'".strtoupper($hallazgo['denominacion_zona'])."',
				".$hallazgo['idsector'].",
				".$hallazgo['idubicaciontecnica'].",
				".$hallazgo['idanomalia'].",
				".$hallazgo['idestatus']."
				)";

			mysql_query($sql, $this->conexion);
			return mysql_insert_id() ;
			//return $sql;
		}

		


		function update( $hallazgo ) {
			$sql = "update $this->tabla set 
				clave_anomalia 		      = '".$hallazgo['clave_anomalia']."',
				ubicacion_tecnica 		  = '".$hallazgo['ubicacion_tecnica']."',
				denominacion 		      = '".$hallazgo['denominacion']."',
				periodo      		      = '".$hallazgo['periodo']."',
				clase       		      = '".$hallazgo['clase']."',
				km 		      			  = '".$hallazgo['km']."',
				tipo        		      = '".$hallazgo['tipo']."',
				anomalia 		          = '".$hallazgo['anomalia']."',
				descripcion 		      = '".$hallazgo['descripcion']."',
				cantidad    		      = '".$hallazgo['cantidad']."',
				utm_e 		              = '".$hallazgo['utm_e']."',
				utm_n 		              = '".$hallazgo['utm_n']."',
				fecha_de_deteccion 		  = '".$hallazgo['fecha_de_deteccion']."',
				foto1 		              = '".$hallazgo['foto1']."',
				foto2 		              = '".$hallazgo['foto2']."',
				denominacion_zona 		  = '".$hallazgo['denominacion_zona']."',
				id_sector 		          = '".$hallazgo['id_sector']."'
				where idhallazgo =" . $hallazgo['idhallazgo'];

			return mysql_query($sql, $this->conexion) ;
				//return $sql;
		}

		function loadById( $hallazgo ) {
			$sql = "select * from $this->tabla where id_hallazgo = $hallazgo" ;
			$resultado = mysql_query($sql, $this->conexion);
			$rows = mysql_num_rows($resultado) ;
			if($rows>0){
				$registro 					= mysql_fetch_assoc($resultado);
				$this->id 					= $registro['idhallazgo'] ;
				$this->clave_anomalia   	= $registro['clave_anomalia'] ;
				$this->ubicacion_tecnica   	= $registro['ubicacion_tecnica'] ;
				$this->denominacion   	   	= $registro['denominacion'] ;
				$this->periodo   		   	= $registro['periodo'] ;
				$this->clase   			   	= $registro['clase'] ;
				$this->km   			   	= $registro['km'] ;
				$this->tipo   			   	= $registro['tipo'] ;
				$this->anomalia   		   	= $registro['anomalia'] ;
				$this->descripcion   		= $registro['descripcion'] ;
				$this->cantidad   			= $registro['cantidad'] ;
				$this->utm_e   				= $registro['utm_e'] ;
				$this->utm_n   				= $registro['utm_n'] ;
				$this->fecha_de_deteccion   = $registro['fecha_de_deteccion'] ;
				$this->foto1   				= $registro['foto1'] ;
				$this->foto2   				= $registro['foto2'] ;
				$this->denominacion_zona   	= $registro['denominacion_zona'] ;
				$this->id_sector  			= $registro['id_sector'] ;
			}
			return $rows ;
		}



		function getId(){
			return $this->id ;
		}

		
		function getClave_anomalia(){
			return $this->clave_anomalia ;
		}

		function getUbicacion_tecnica(){
			return $this->ubicacion_tecnica ;
		}

		function getDenomincacion(){
			return $this->denominacion ;
		}

		function getPeriodo(){
			return $this->periodo ;
		}

		function getClase(){
			return $this->clase ;
		}

		function getKm(){
			return $this->km ;
		}
		
		function getTipo(){
			return $this->tipo ;
		}

		function getAnomalia(){
			return $this->anomalia ;
		}


		function getDescripcion(){
			return $this->anomalia ;
		}

		function getCantidad(){
			return $this->cantidad ;
		}

		function getUtm_e(){
			return $this->utm_e ;
		}

		function getUtm_n(){
			return $this->utm_n ;
		}

		function getFecha_de_deteccion(){
			return $this->fecha_de_deteccion ;
		}

		function getFoto1(){
			return $this->foto1 ;
		}

		function getFoto2(){
			return $this->foto2 ;
		}

		function getDenominacion_Zona(){
			return $this->denominacion_zona ;
		}

		function getIdSector(){
			return $this->idsector ;
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

		function getAllUltimos(){
			$sql = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, "
			." hallazgo.utm_e, hallazgo.utm_n, hallazgo.denominacion_zona, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.descripcion as descanomalia, estatus.descripcion as descestatus "
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." order by idhallazgo desc LIMIT 100" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return $resultados ;
		}

	function getConsultaCuenta($datos){
			$cadena = "Select COUNT(hallazgo.idhallazgo) as p"
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." Where hallazgo.idsector = ".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena;
			$resultado = mysql_query($sql, $this->conexion) ;
			$row=mysql_fetch_assoc($resultado);
			return $row['p'];
			//return $sql;
		}	

	function getConsultaCuentaMapa($datos){
			$cadena = "Select COUNT(hallazgo.idhallazgo) as p"
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." Where hallazgo.idsector = ".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena . " and anomalia.nomenclatura not in('---')";
			$resultado = mysql_query($sql, $this->conexion) ;
			$row=mysql_fetch_assoc($resultado);
			return $row['p'];
			//return $sql;
		}	




	function getConsultaPunto($datos, $inicio, $paginacion){
			$cadena = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, hallazgo.utm_e, hallazgo.utm_n," 
			." hallazgo.denominacion_zona, hallazgo.idubicacion_tecnica, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.color as colores, anomalia.nomenclatura as descanomalia, estatus.descripcion as descestatus"
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." Where hallazgo.idsector = ".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena. " order by hallazgo.idubicacion_tecnica limit ".$inicio. "," .$paginacion ;
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

		function getConsultaCadena($datos){
			$cadena = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, hallazgo.utm_e, hallazgo.utm_n," 
			." hallazgo.denominacion_zona, hallazgo.idubicacion_tecnica, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.color as colores ,anomalia.nomenclatura as descanomalia, estatus.descripcion as descestatus"
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." Where hallazgo.idsector = ".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena;
			
			return $sql;
		}	

		function getConsultaCadenaMapa($datos){
			$cadena = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, hallazgo.utm_e, hallazgo.utm_n," 
			." hallazgo.denominacion_zona, hallazgo.fecha_de_deteccion, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.color as colores ,anomalia.nomenclatura as descanomalia, estatus.descripcion as descestatus"
			." from $this->tabla"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." Where hallazgo.idsector = ".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena .")";
			}
			
			$sql = $cadena . " and anomalia.nomenclatura not in('---')";
			
			return $sql;
		}	

		function getConsultaGraficaHallazgo($datos){
			$cadena = "SELECT anomalia.id_anomalia, anomalia.nomenclatura,count(hallazgo.idanomalia) as p, anomalia.color, anomalia.descripcion" 
			." from hallazgo , anomalia, ubicacion_tecnica, estatus"
			." Where hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica and hallazgo.idestatus = estatus.idestatus and hallazgo.idanomalia = anomalia.id_anomalia and hallazgo.idsector =".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			//$sql = $cadena. " group by hallazgo.idanomalia order by p desc" ;
			$sql = $cadena. " and anomalia.nomenclatura not in('---') group by hallazgo.idanomalia order by p desc" ;
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

		function getConsultaGraficaPiramiredHallazgo($datos){
			$cadena = "SELECT estatus.idestatus, estatus.descripcion,count(hallazgo.idestatus) as p " 
			." from hallazgo, anomalia, ubicacion_tecnica, estatus"
			." Where hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica and hallazgo.idanomalia = anomalia.id_anomalia and hallazgo.idestatus = estatus.idestatus and hallazgo.idsector =".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena. " group by hallazgo.idestatus order by p desc" ;
			//$sql = $cadena. " and estatus.descripcion not in('---') group by hallazgo.idestatus order by p desc" ;
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


		function getConsultaGraficaPiramiredHallazgoCuenta($datos){
			$cadena = "SELECT count(hallazgo.idestatus) as p " 
			." from hallazgo, anomalia, ubicacion_tecnica, estatus"
			." Where hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica and hallazgo.idanomalia = anomalia.id_anomalia and hallazgo.idestatus = estatus.idestatus and hallazgo.idsector =".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena;
			//$sql = $cadena. " and estatus.descripcion not in('---') group by hallazgo.idestatus order by p desc" ;
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

		function getConsultaGraficaPiramiredHallazgoCuentaCadena($datos){
			$cadena = "SELECT count(hallazgo.idestatus) as p " 
			." from hallazgo, anomalia, ubicacion_tecnica, estatus"
			." Where hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica and hallazgo.idanomalia = anomalia.id_anomalia and hallazgo.idestatus = estatus.idestatus and hallazgo.idsector =".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena;
			
			return $sql ;
			//return $sql;
		}

		function getConsultaGraficaPiramiredHallazgoCadena($datos){
			$cadena = "SELECT estatus.idestatus, estatus.descripcion,count(hallazgo.idestatus) as p " 
			." from hallazgo, anomalia, ubicacion_tecnica, estatus"
			." Where hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica and hallazgo.idanomalia = anomalia.id_anomalia and hallazgo.idestatus = estatus.idestatus and hallazgo.idsector =".$datos['idsector'];

			if ($datos['idubicaciontecnica'] <> 0) {
				$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
			}

			if ($datos['clase'] <> '%') {
				$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
			}

			if ($datos['tipo'] <> '%') {
				$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
			}

			if ($datos['kilometraje'] <> '') {
				$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
			}

			if ($datos['descripcion'] <> '') {
				$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
			}

			//$a = count($datos);

			$b=0;
			
			foreach ($datos as $value => $key) {
				$b++;
				if ($b>15) {
					if ($b==16) {
						$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
					} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
				}
			}

			if ($b>15) {
				$cadena = $cadena ." )";
			}
			
			$sql = $cadena;   //. " group by hallazgo.idestatus order by p desc" ;
			//$sql = $cadena. " and estatus.descripcion not in('---') group by hallazgo.idestatus order by p desc" ;
			//return $resultados ;
			return $sql;
		}

		function getConsultaGraficaPiramiredHallazgoSeleccionCuenta($sql){

			//$sql = $cadena. " and estatus.descripcion not in('---') group by hallazgo.idestatus order by p desc" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return json_encode($resultados) ;
			//return $sql;
		}


		function getConsultaGraficaPiramiredHallazgoSeleccion($datos){
			
			$sql = $datos. " group by hallazgo.idestatus order by p desc" ;
			//$sql = $cadena. " and estatus.descripcion not in('---') group by hallazgo.idestatus order by p desc" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return json_encode($resultados) ;
			//return $sql;
		}

		function getConsultaPuntoJson($datos){
			$sql = $datos;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			return json_encode($resultados) ; 
			//return $sql;
		}	



		function getConsultaPuntoJsonMapa($datos){
			include_once("Geoconv.php");
			$geoconv = new Geoconv();
			$sql = $datos;
			$resultado = mysql_query($sql, $this->conexion) ;
			$resultados = array();
			if(mysql_num_rows($resultado)){
				while($row = mysql_fetch_assoc($resultado)){
					$resultados[] = $row ;
				}
			}
			//print_r($resultados);

			$res2 = array();
			foreach ($resultados as $key ) {
				if ($key['utm_e'] <> '---' and $key['utm_n'] <> '---') {
					//ver si esta correcta las coordenadas
					if (is_numeric($key['utm_e'])) { 
					  if (is_numeric($key['utm_n'])) { 
							$pto=$geoconv->utm2geo ($key['idhallazgo'], $key['utm_e'], $key['utm_n'], 15,'N');

							$key['longi'] = $pto['longi'];
							$key['lat'] = $pto['lat'];
							
							//----------constriur tabla----------
							$foto=$this->getConsultaTabla($key['idhallazgo']);
							//print_r($foto);
							//-------------fin de construir tabla
							 					$contentString = '<div id="content">'.
		                                                          '<div id="siteNotice">'.
		                                                          '</div>'.
		                                                          '<h4  class="firstHeading">Clave anomalia:'.$key['clave_anomalia'].'</h4>'.
		                                                          '<h4  class="firstHeading">Kilometraje:'.$key['km'].'</h4>'.
		                                                          '<h4  class="firstHeading">Descripcion Inicial:'.$key['descripcion'].'</h4>'.
		                                                          '<h4  class="firstHeading">Fecha de Deteccion:'.$key['fecha_de_deteccion'].'</h4>'.
		                                                          '<h4  class="firstHeading">Clase:'.$key['clase'].'</h4>'.
		                                                          '<h4  class="firstHeading">Tipo:'.$key['tipo'].'</h4>'.
		                                                          '<h4  class="firstHeading">Denominacion:'.$key['denominacion'].'</h4>'.
		                                                          '<h4  class="firstHeading">Anomalia:'.$key['descanomalia'].'</h4>'.
		                                                          '<h4  class="firstHeading">Estatus:'.$key['descestatus'].'</h4>'.
		                                                          '</p>'.
		                                                          '</div>'.
		                                                          '</div>';

		                                         $contentString = $contentString . '<div id="content2">'.
		                                                         '<table>'.
		                                                           '<tr>';
		                                                            foreach ($foto as $value ) 
		                                                                    { 
		                                                                      if ($value['foto'] != "---") {
		                                                                          $contentString = $contentString . '<td><img src="../BD/'.$value['foto'].'" height="442" width="542">Fecha: '.$value['fecha_celaje'].' _'. $value['fichadesc'].'</td>';
		                                                                        };
		                                                                    }
		                                                                
		                                        $contentString = $contentString . '</tr>'.
		                                                         '</table>'.
		                                                         '</div>';
		                                        $key['cadena'] = $contentString;
		                                        $res2[] = $key;
		               }//is numeric
					}//is numeric
				}
				}
			return json_encode($res2) ; 
			//return $sql;
		}	

		function getConsultaTabla($id){
			$sql = "Select hallazgo.clave_anomalia, hallazgo.km, hallazgo.descripcion, hallazgo.clase, hallazgo.tipo, hallazgo.denominacion,"
			." anomalia.nomenclatura, anomalia.color, anomalia.descripcion as anodesc, estatus.descripcion as estatusdesc,"
			." ficha.foto, ficha.orden, ficha.descripcion as fichadesc, ficha.fecha_celaje" 
			." from hallazgo"
			." inner join ficha on hallazgo.idhallazgo = ficha.idhallazgo"
			." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
			." inner join estatus on hallazgo.idestatus = estatus.idestatus"
			." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
			." where hallazgo.idhallazgo =".$id."  order by ficha.orden";
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

		function getConsultaGraficaHallazgoSectores(){
					include_once("Sector.php");
					include_once("Anomalia.php");
					$sector = new Sector();
					$anomalia = new Anomalia();

					$res2= array();	
					$sectores = $sector->getAll();
					$anomalias = $anomalia->getAll();
					foreach ($anomalias as $value) {
								$res= array();	
								foreach ($sectores as $key) {
									$sql = "SELECT count(hallazgo.idhallazgo) as p ".
									"from hallazgo ".
									"Where idanomalia = ". $value['id_anomalia']. " and idsector= " .$key['idsector'];
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['descripcion']]= $c;
								}
								$res['anomalia']= $value['nomenclatura'];
								$res['idanomalia']= $value['id_anomalia'];
								$res2[] = $res;
					}
					return $res2 ;
					//return $sql;
				}	


				function getConsultaGraficaHallazgoSectoresSeleccion($anomalias){
					include_once("Sector.php");
					include_once("Anomalia.php");
					$sector = new Sector();
					$anomalia = new Anomalia();

					$res2= array();	
					$sectores = $sector->getAll();
					//$anomalias = $anomalia->getAll();
					foreach ($anomalias['myCheckboxes'] as $value) {
								$anomalia->loadById($value);
								$res= array();	
								foreach ($sectores as $key) {
									//echo $value;
									$sql = "SELECT count(hallazgo.idhallazgo) as p ".
									"from hallazgo ".
									"Where idanomalia = ". $value. " and idsector= " .$key['idsector'];
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['descripcion']]= $c;
								}

								$res['anomalia']=$anomalia->getNomenclatura() ;
								$res2[] = $res;						
					} 
					return json_encode($res2) ;

				}	

				
				function getConsultaGraficaHallazgoSectoresEstatusSeleccion($estatuss){
					include_once("Sector.php");
					include_once("Estatus.php");
					$sector = new Sector();
					$estatus = new Estatus();

					$res2= array();	
					$sectores = $sector->getAll();
					//$estatuss = $estatus->getAll();
					foreach ($estatuss['myCheckboxes2'] as $value) {
								$estatus->loadById($value);
								$res= array();	
								foreach ($sectores as $key) {
									$sql = "SELECT count(hallazgo.idhallazgo) as p ".
									"from hallazgo ".
									"Where idestatus = ". $value . " and idsector= " .$key['idsector'];
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['descripcion']]= $c;
								}
								$res['estatus']= $estatus->getDescripcion();
								//$res['idestatus']= $value['idestatus'];
								$res2[] = $res;
					}
					return json_encode($res2) ;
					//return $sql;
				}	
				

				function getConsultaGraficaHallazgoSectoresEstatus(){
					include_once("Sector.php");
					include_once("Estatus.php");
					$sector = new Sector();
					$estatus = new Estatus();

					$res2= array();	
					$sectores = $sector->getAll();
					$estatuss = $estatus->getAll();
					foreach ($estatuss as $value) {
								$res= array();	
								foreach ($sectores as $key) {
									$sql = "SELECT count(hallazgo.idhallazgo) as p ".
									"from hallazgo ".
									"Where idestatus = ". $value['idestatus']. " and idsector= " .$key['idsector'];
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['descripcion']]= $c;
								}
								$res['estatus']= $value['descripcion'];
								$res['idestatus']= $value['idestatus'];
								$res2[] = $res;
					}
					return $res2 ;
					//return $sql;
				}	

				function getConsultaGraficaHallazgoUbicaciones($sector){
					include_once("Ubicacion_Tecnica.php");
					include_once("Anomalia.php");
					$ubicacion_tecnica = new Ubicacion_Tecnica();
					$anomalia = new Anomalia();

					$res2= array();	
					$ubicaciones = $ubicacion_tecnica->getAll();
					$anomalias = $anomalia->getAll();
					foreach ($anomalias as $value) {
						if ($value['nomenclatura']<>'---') {
								$res= array();	
								foreach ($ubicaciones as $key) {
									$sql = "SELECT count(hallazgo.idhallazgo) as p ".
									"from hallazgo ".
									"Where idanomalia = ". $value['id_anomalia']. " and idubicacion_tecnica= " .$key['idubicacion_tecnica']. " and idsector=".$sector;
									$resultado = mysql_query($sql, $this->conexion) ;
									$row=mysql_fetch_assoc($resultado);
									$c= $row['p'];
									$res[$key['alias']]= $c;
								}
								$res['anomalia']= $value['nomenclatura'];
								$res2[] = $res;
						}
						//$res2[] = $res;
					}
					return $res2 ;
					//return $sql;
			}


			function getJsonInsertarFoto( $foto ) {
						$sql = "insert into ficha values(
							0,
							'".strtoupper($foto['clave_anomalia'])."',
							'".strtoupper($foto['descripcion'])."',
							'".'/IMAGENES/'.$foto['nombre_foto']."',
							'".$foto['fecha']."',
							'" ."',
							".$foto['idhallazgo']."
							)";

						mysql_query($sql, $this->conexion);
						return mysql_insert_id() ;
						//return $sql;
					}

			function getFotografiaId($id){
					$sql = "Select * from ficha Where idhallazgo= ". $id ;
					$resultado = mysql_query($sql, $this->conexion) ;
					$resultados = array();
					if(mysql_num_rows($resultado)){
						while($row = mysql_fetch_assoc($resultado)){
							$resultados[] = $row ;
						}
					}
					return $resultados ;
			}


			function getJsonEliminarFotografia($idficha){
					$sql = "delete from ficha where idficha=$idficha";
					return mysql_query($sql, $this->conexion);
			}	

			function getJsonUpdateFotografia( $ficha ) {
			$sql = "update ficha set 
				descripcion 		      = '".strtoupper($ficha['descripcion'])."',
				fecha_celaje 		      = '".$ficha['fecha']."'
				where idficha             = ". $ficha['idfotografia'];
			
			return mysql_query($sql, $this->conexion) ;
				//return $sql;
			}

			function getConsultaFotoJson($id){
					$sql = "Select * from ficha Where idhallazgo= ". $id ;
					$resultado = mysql_query($sql, $this->conexion) ;
					$resultados = array();
					if(mysql_num_rows($resultado)){
						while($row = mysql_fetch_assoc($resultado)){
							$resultados[] = $row ;
						}
					}
					return json_encode($resultados) ;
			}

			function getJsonMaxconsecutivo($idubicacion_tecnica){
					$sql = "SELECT MAX(CONVERT(substring_index(clave_anomalia,'_',-1),DECIMAL)) p FROM $this->tabla where idubicacion_tecnica = ". $idubicacion_tecnica ;
					$resultado = mysql_query($sql, $this->conexion) ;
					$resultados = array();
					if(mysql_num_rows($resultado)){
						while($row = mysql_fetch_assoc($resultado)){
							$resultados[] = $row ;
						}
					}
					return json_encode($resultados)  ;
			}

			function getJsonHallazgo($hallazgo){
					$sql = $cadena = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, hallazgo.utm_e, hallazgo.utm_n, f.ultimadescripcion, f.fecha_celaje," 
									." hallazgo.denominacion_zona, hallazgo.idubicacion_tecnica, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.color as colores ,anomalia.nomenclatura as descanomalia, estatus.descripcion as descestatus"
									." from $this->tabla"
									." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
									." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
									." inner join estatus on hallazgo.idestatus = estatus.idestatus"
									." INNER JOIN (select descripcion as ultimadescripcion, idhallazgo, idficha, fecha_celaje from ficha order by idficha desc) as f on hallazgo.idhallazgo = f.idhallazgo"
					                ." Where hallazgo.idsector= ". $hallazgo['idsector'] . ' and hallazgo.idubicacion_tecnica = '. $hallazgo['idubicacion_tecnica'] ." and hallazgo.km like '%". $hallazgo['km']. "%'"
					                ." group by hallazgo.idhallazgo";
					$resultado = mysql_query($sql, $this->conexion) ;
					$resultados = array();
					if(mysql_num_rows($resultado)){
						while($row = mysql_fetch_assoc($resultado)){
							$resultados[] = $row ;
						}
					}
					return json_encode($resultados) ;
					//return $sql;
			}



			function getConsultaImprimirC7($datos){
					$cadena = "Select hallazgo.idhallazgo, hallazgo.clave_anomalia, hallazgo.denominacion, hallazgo.clase, hallazgo.km, hallazgo.tipo, hallazgo.descripcion, hallazgo.utm_e, hallazgo.utm_n, hallazgo.cantidad," 
					." hallazgo.fecha_de_deteccion, hallazgo.denominacion_zona, hallazgo.idubicacion_tecnica, ubicacion_tecnica.descripcion as descubicaciontecnica, anomalia.color as colores, anomalia.nomenclatura as descanomalia, estatus.descripcion as descestatus"
					." from $this->tabla"
					." inner join ubicacion_tecnica on hallazgo.idubicacion_tecnica = ubicacion_tecnica.idubicacion_tecnica"
					." inner join anomalia on hallazgo.idanomalia = anomalia.id_anomalia"
					." inner join estatus on hallazgo.idestatus = estatus.idestatus"
					." Where hallazgo.idsector = ".$datos['idsector'];

					if ($datos['idubicaciontecnica'] <> 0) {
						$cadena = $cadena . " and hallazgo.idubicacion_tecnica = ".$datos['idubicaciontecnica'];
					}

					if ($datos['clase'] <> '%') {
						$cadena = $cadena . " and hallazgo.clase = '".$datos['clase']."'";
					}

					if ($datos['tipo'] <> '%') {
						$cadena = $cadena . " and hallazgo.tipo = '".$datos['tipo']."'";
					}

					if ($datos['kilometraje'] <> '') {
						$cadena = $cadena . " and hallazgo.km = '".$datos['kilometraje']."'";
					}

					if ($datos['descripcion'] <> '') {
						$cadena = $cadena . " and hallazgo.descripcion like '%".$datos['descripcion']."%'";
					}

					if ($datos['denominacion_zona'] <> '') {
						$cadena = $cadena . " and hallazgo.denominacion_zona like '%".$datos['denominacion_zona']."%'";
					}

					//$a = count($datos);

					$b=0;
					
					foreach ($datos as $value => $key) {
						$b++;
						if ($b>8) {
							if ($b==9) {
								$cadena = $cadena ." and ( hallazgo.idanomalia = " .$value;
							} else { $cadena = $cadena ." or hallazgo.idanomalia = " .$value; }				
						}
					}

					if ($b>8) {
						$cadena = $cadena ." )";
					}
					
					$sql = $cadena. " order by hallazgo.idubicacion_tecnica" ;
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

		}
?>