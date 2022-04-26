<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Database.php';

class IndicacionBitacora{
    
    private $id ;
    private $id_usuario ;
    private $usuario ;
    private $fecha ;
    
    private $conexion ;
    private $tabla ;
            
    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "indicacion_bitacora" ;
    }
    
    function insert( $id_usuario, $usuario ){
        $sql = "INSERT INTO $this->tabla VALUES(0,  $id_usuario ,'$usuario', now()  )  ";
    echo $sql ;
        $this->conexion->query($sql);
        return $sql;
    }
    
 

}

?>