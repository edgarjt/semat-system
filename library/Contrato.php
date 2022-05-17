<?php

//include_once 'Database.php';
class Contrato
{    
    private $id ;
    private $numero ;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $monto_minimo;
    private $monto_maximo;     
    private $tabla ;
    private $conexion ;
    private $subdireccion ;
    
    public $subdirecciones = array("GTDH", "GMIL", "PEMEX LOGISTICA", "OTRO") ;

    function __construct()
    {
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "contrato" ;
    }
    
    function insert( $contrato ){
        $sql = "INSERT INTO $this->tabla VALUES(0, "
                ."'".  strtoupper( $contrato['numero']      ) . "',"
                ."'".  strtoupper( $contrato['descripcion'] ) . "',"
                ."'".              $contrato['fecha_inicio']  . "',"
                ."'".              $contrato['fecha_fin']     . "',"
                ."'".              $contrato['monto_minimo']  . "',"
                ."'".              $contrato['monto_maximo']  . "',"
                ."'". $contrato['subdireccion'] ."'"
                . ")" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($contrato)
    {
        $sql = "UPDATE $this->tabla SET "
                . " numero            = '" . strtoupper( $contrato['numero'] )       . "',"
                . " descripcion       = '" . strtoupper( $contrato['descripcion'] )  . "',"
                . " fecha_inicio      = '" . strtoupper( $contrato['fecha_inicio'] ) . "',"
                . " fecha_fin         = '" . strtoupper( $contrato['fecha_fin'] )    . "',"
                . " monto_minimo      = '" . strtoupper( $contrato['monto_minimo'] ) . "',"
                . " monto_maximo      = '" . strtoupper( $contrato['monto_maximo'] ) . "',"
                . "subdireccion        = '" . strtoupper( $contrato['subdireccion']) ."'"
                . " where id_contrato =  " . $contrato['id_contrato'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($contrato){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_CONTRATO = " . $contrato['id_contrato'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $contrato ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_CONTRATO = $contrato " ;
        $resultado = $this->conexion->query($sql)      ;
        if($resultado->num_rows > 0) 
        {
            $row = $resultado->fetch_assoc();
            $this->id           = $row['id_contrato']  ;
            $this->numero       = $row['numero']       ;
            $this->descripcion  = $row['descripcion']  ;
            $this->fecha_inicio = $row['fecha_inicio'] ;
            $this->fecha_fin    = $row['fecha_fin']    ;
            $this->monto_minimo = $row['monto_minimo'] ;
            $this->monto_maximo = $row['monto_maximo'] ;
            $this->subdireccion = $row['subdireccion'] ;
            return true ;
        }
        else
        {
            return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT c.id_contrato, c.numero, c.descripcion, c.fecha_inicio, c.fecha_fin, c.monto_maximo, c.monto_minimo, c.subdireccion ".
		"FROM $this->tabla as c ".
		"join usuario_has_contrato as uhc on uhc.id_contrato = c.id_contrato ".
		"where uhc.id_usuario = " . $_SESSION['id_usuario']  ;
		
        $resultado = $this->conexion->query($sql);
        $arrayContratos = array() ;
        if($resultado->num_rows > 0)
        {
            while( $row = $resultado->fetch_assoc())
            {
                $arrayContratos[] = $row ;
            }
        }

            return $arrayContratos ;

    }
    
    function getContratoNumero($numero)
    {
            $sql = "
                    SELECT count(*) as contador
                    from contrato 
                    where numero = ".$numero." 
                    ";
                    $resultado = $this->conexion->query($sql) ;
                    $row = $resultado->fetch_assoc();
                    $num= $row['contador'];
                    return $num ;
    }

    function getCountAll()
    {
            $sql = "
                    SELECT count(*) as contador
                    from contrato 
                    ";
                    $resultado = $this->conexion->query($sql) ;
                    $row = $resultado->fetch_assoc();
                    $num= $row['contador'];
                    return $num ;
    }

    function getCountAllByLinea($id_contrato,$id_linea)
    {
            $sql = "
                    select  count(*) as contador 
                    from    linea,contrato,linea_has_contrato
                    where   linea.id_linea                  = linea_has_contrato.id_linea
                    and     linea_has_contrato.id_contrato  = contrato.id_contrato
                    and     linea.id_linea                  = $id_linea
                    and     contrato.id_contrato            = $id_contrato
                    ";
                    $resultado = $this->conexion->query($sql) ;
                    $row = $resultado->fetch_assoc();
                    $num= $row['contador'];
                    return $num ;
    }

    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }


    function getJsonContratosU($sub, $u){
        $sql = "SELECT 
            contrato.id_contrato as id_contrato,
            contrato.numero as numero,
            contrato.descripcion as descripcion,
            contrato.fecha_inicio as fecha_inicio,
            contrato.fecha_fin as fecha_fin,
            contrato.subdireccion as subdireccion 

            FROM $this->tabla 
            join usuario_has_contrato as uhc on contrato.id_contrato = uhc.id_contrato
            where contrato.subdireccion='$sub' and uhc.id_usuario = $u" ;
            
        $resultado = $this->conexion->query($sql);
        $arrayContratos = array() ;
        if($resultado->num_rows > 0)
        {
            while( $row = $resultado->fetch_assoc())
            {
                $arrayContratos[] = $row ;
            }
        }

            return json_encode($arrayContratos) ;
    }
    
    function getJsonContratos($sub){
        $sql = "SELECT * FROM $this->tabla where subdireccion='$sub'" ;
        $resultado = $this->conexion->query($sql);
        $arrayContratos = array() ;
        if($resultado->num_rows > 0)
        {
            while( $row = $resultado->fetch_assoc())
            {
                $arrayContratos[] = $row ;
            }
        }

            return json_encode($arrayContratos) ;
    }
    
    function getId(){
        return $this->id ;
    }
    
    function getNumero(){
        return $this->numero ;
    }
    
    function getDescripcion(){
        return $this->descripcion ;
    }

    function getFechaInicio(){
        return $this->fecha_inicio ;
    }

    function getFechaFin(){
        return $this->fecha_fin ;
    }

    function getMontoMinimo(){
        return $this->monto_minimo ;
    }

    function getMontoMaximo(){
        return $this->monto_maximo ;
    }
    
    function getSubdireccion(){
        return $this->subdireccion ;
    }
}
?>