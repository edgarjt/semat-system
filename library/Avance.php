<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once 'Database.php';

class Avance{
    
    private $id ;
    private $fecha ;
    private $fecha_fin ;
    private $estatus ;
    private $descripcion ;
    private $porcentaje ;
    private $longitud ;
    private $programa ;
    private $actividad ;
     
    private $tabla ;
    private $conexion ;
    
    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "avance" ;
    }
    
    function insert( $avance ){
        $sql = "INSERT INTO $this->tabla VALUES(0,"
                . "'". $avance['fecha'] . "',"
                . "'". $avance['fecha_fin'] . "',"
                . "'". strtoupper( $avance['estatus'] ) . "',"
                . "'". strtoupper( $avance['descripcion'] ) . "',"
                .  $avance['porcentaje']  .","
                .  $avance['longitud']  .","
                .  $avance['id_programa']  . ","
                .  $avance['id_actividad'] 
                . "  )" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($avance){
        $sql = "UPDATE $this->tabla SET "
                . " FECHA = '" . strtoupper( $avance['fecha'] ). "',"
                . " FECHA_FIN = '" . strtoupper( $avance['fecha_fin'] ). "',"
                . " ESTATUS = '" . strtoupper( $avance['estatus'] ). "',"
                . " DESCRIPCION = '" . strtoupper( $avance['descripcion'] ). "',"
                . " PORCENTAJE = " . strtoupper( $avance['porcentaje'] ). ","
                . " LONGITUD = " . strtoupper( $avance['longitud'] ). ","
                . " ID_PROGRAMA = " . strtoupper( $avance['id_programa'] ). ","
                . " ID_ACTIVIDAD = " . strtoupper( $avance['id_actividad'] )
                . " WHERE ID_AVANCE = " . $avance['id_avance'] ;
                
        return $this->conexion->query($sql);
    }
    
    function delete($avance){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_AVANCE = " . $avance['id_avance'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $avance ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_AVANCE = $avance " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_avance'] ;
            $this->fecha = $row ['fecha'] ;
            $this->fecha_fin = $row ['fecha_fin'] ;
            $this->estatus = $row['estatus'] ;
            $this->descripcion = $row['descripcion'] ;
            $this->porcentaje = $row['porcentaje'] ;
            $this->longitud = $row['longitud'] ;
            $this->programa = $row['id_programa'] ;
            $this->actividad = $row['id_actividad'] ;
            
            return true ;
        }
        else{
            return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla" ;
        $resultado = $this->conexion->query($sql);
        $arrayAvances = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayAvances[] = $row ;
            }
            return $arrayAvances ;
        }
        else{
            return $arrayAvances ;
        }
    }
    
    function getByPrograma($id_programa){
        $sql = "SELECT * FROM $this->tabla where id_programa = $id_programa" ;
        $resultado = $this->conexion->query($sql);
        $arrayAvances = array() ;
        if($resultado->num_rows > 0)
        {
            while( $row = $resultado->fetch_assoc() )
            {
                $arrayAvances[] = $row ;
            }
            return $arrayAvances ;
        }
        else{
            return $arrayAvances ;
        }
    }

    function getVolumenByActividad( $id_actividad ){
        $sql = "SELECT sum(longitud) as suma FROM $this->tabla where id_actividad = $id_actividad" ;
        $resultado = $this->conexion->query($sql);
        $total = 0 ;
        if($resultado->num_rows > 0)
        {
            $row = $resultado->fetch_assoc() ;
            $total = $row['suma'] ;
        }
            return $total ;
    }

    function getByProgramaReporte($id_programa){
        $sql = "SELECT * FROM $this->tabla where id_programa = $id_programa order by id_actividad asc" ;
        $resultado = $this->conexion->query($sql);
        $arrayAvances = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayAvances[$row['id_actividad']] = $row ;
            }
            return $arrayAvances ;
        }
        else{
            return $arrayAvances ;
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

    function getFechaFin(){
        return $this->fecha_fin ;
    }
    
    function getEstatus(){
        return $this->estatus ;
    }
            
    function getDescripcion(){
        return $this->descripcion;
    }
    
    function getPorcentaje(){
        return $this->porcentaje ;
    }
    
    function getLongitud(){
        return $this->longitud ;
    }
    
    function getPrograma(){
        return $this->programa;
    }
    
    function getActividad(){
        return $this->actividad;
    }
    
}


?>
