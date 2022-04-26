<?php
	class Database{

		private 	$servidor 	;
		private 	$usuario 	;
		private 	$password	;
		private 	$base_datos	;
		private 	$conexion	;

		function __construct(){
			$this->servidor 	= "localhost" 	;
			$this->usuario		= "root"		;
			$this->password 	= '$ematesaTI.072H'	;
			$this->base_datos	= 'avance_contrato' ;

			$this->conexion 	= new mysqli( $this->servidor, $this->usuario, $this->password, $this->base_datos );  
			
		}

		function getConexion(){
			$this->conexion->set_charset('utf8');
			return $this->conexion ;
		}


	}
?>