<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Database.php';

class TipoTrabajo{
    
    private $id ;
    private $descripcion ;
    private $alias ;
     
    private $tabla ;
    private $conexion ;
    
    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "tipo_trabajo" ;
    }
    
    function insert( $tipo_trabajo ){
        $sql = "INSERT INTO $this->tabla VALUES(0, '"
                . strtoupper( $tipo_trabajo['descripcion'] ) . "','"
                . strtoupper( $tipo_trabajo['alias'] ) ."'"
                . "  )" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($tipo_trabajo){
        $sql = "UPDATE $this->tabla SET "
                . " DESCRIPCION = '" . strtoupper( $tipo_trabajo['descripcion'] ). "',"
                . " ALIAS       = '" . strtoupper( $tipo_trabajo['alias'] ). "'"
                . " WHERE ID_TIPO_TRABAJO = " . $tipo_trabajo['id_tipo_trabajo'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($tipo_trabajo){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_TIPO_TRABAJO = " . $tipo_trabajo['id_tipo_trabajo'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $tipo_trabajo ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_TIPO_TRABAJO = $tipo_trabajo " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_tipo_trabajo'] ;
            $this->descripcion = $row ['descripcion'] ;
            $this->alias = $row ['alias'] ;

            return true ;
        }
        else{
            return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla" ;
        $resultado = $this->conexion->query($sql);
        $arrayTipoTrabajos = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayTipoTrabajos[] = $row ;
            }
            return $arrayTipoTrabajos ;
        }
        else{
            return $arrayTipoTrabajos ;
        }
    }
    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }
    
    function getId(){
        return $this->id;
    }
    
    function getDescripcion(){
        return $this->descripcion;
    }

    function getAlias(){
        return $this->alias;
    }
}

?>
