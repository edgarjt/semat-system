<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Database.php';

class Foto{
    
    private $id ;
    private $descripcion ;
    private $archivo ;
    private $avance ;
    private $foto ;
    
    private $conexion ;
    private $tabla ;
            
    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "foto" ;
    }
    
    function insert( $foto ){
        $sql = "INSERT INTO $this->tabla VALUES(0, '"
                . strtoupper( $foto['descripcion'] ) . "' ,"
                . "'". $foto['archivo'] . "',"
                . "'". $foto['fecha'] . "',"
                . $foto['id_avance']
                . "  )" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($foto){
        $sql = "UPDATE $this->tabla SET "
                . " FECHA = '" . $foto['fecha'] . "',"
                . " DESCRIPCION = '" . strtoupper( $foto['descripcion'] ). "',"
                . " ARCHIVO = '" . $foto['archivo'] . "',"
                . " ID_AVANCE = " . $foto['id_avance']
                . " WHERE ID_FOTO = " . $foto['id_foto'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($foto){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_FOTO = " . $foto;
        return $this->conexion->query($sql);
    }
    
    function loadById( $foto ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_FOTO = $foto " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_foto'] ;
            $this->fecha = $row['fecha'] ;
            $this->descripcion = $row ['descripcion'] ;
            $this->archivo = $row ['archivo'] ;
            $this->avance = $row['id_avance'] ;
            return true ;
        }
        else{
            return false ;
        }
    }
    
    function getByAvance($id_avance){
        $sql = "SELECT * FROM $this->tabla where id_avance = $id_avance order by fecha asc" ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
        
    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla order by fecha asc" ;
        $resultado = $this->conexion->query($sql);
        $array = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $array[] = $row ;
            }
            return $array ;
        }
        else{
            return $array ;
        }
    }
    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }
    
    function getId(){
        return $this->id;
    }

    function getFecha(){
        return $this->fecha ;
    }
    
    function getDescripcion(){
        return $this->descripcion;
    }
    
    function getArchivo(){
        return $this->archivo;
    }
    
    function getAvance(){
        return $this->avance ;
    }
    

}

?>