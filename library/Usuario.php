<?php


include_once 'Database.php';

class Usuario{
    
    private $id ;
    private $nombre ;
    private $login ;
    private $password ;
    private $tipoUsuario ;
    private $estatus ;
    
    private $tabla ;
    private $conexion ;
                function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "usuario" ;
    }
    
    function insert( $usuario ){
        $sql = "INSERT INTO $this->tabla VALUES(0, '"
                . strtoupper($usuario['nombre']) . "','"
                . $usuario['login'] . "','"
                . $usuario['password'] . "','"
                . $usuario ['tipo_usuario'] . "',"
                . "'ACTIVO',"
                ."1"
                . "  )" ;
        //echo $sql ;
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($usuario){
        $sql = "UPDATE $this->tabla SET "
                . " NOMBRE = '" . $usuario['nombre'] . "',"
                . " LOGIN = '" . $usuario['login'] . "',"
                . " PASSWORD = '" . $usuario['password'] . "',"
                . " TIPO_USUARIO = '" . $usuario['tipo_usuario'] . "',"
                . " ESTATUS = '" . $usuario['estatus'] . "'" 
                . " WHERE ID_USUARIO = " . $usuario['id_usuario'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($usuario){
        $sql = "UPDATE $this->tabla SET "
            . " ESTATUS = '" . $usuario['estatus'] ."'" 
            . " WHERE ID_USUARIO = " . $usuario['id_usuario'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $usuario ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_USUARIO = $usuario " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_usuario'] ;
            $this->nombre = $row['nombre'] ;
            $this->login = $row ['login'] ;
            $this->password = $row ['password'] ;
            $this->tipoUsuario = $row ['tipo_usuario'] ;
            $this->estatus = $row ['estatus'] ;
            return true ;
        }
        else{
            return false ;
        }
    }

    function loadForLogin($usuario_login, $password_login){
        $sql = "SELECT * FROM $this->tabla WHERE LOGIN = '".$usuario_login ."' AND PASSWORD = '".$password_login."' AND ESTATUS ='ACTIVO' "  ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $this->id = $row ['id_usuario'] ;
            $this->nombre = $row['nombre'] ;
            $this->login = $row ['login'] ;
            $this->password = $row ['password'] ;
            $this->tipoUsuario = $row ['tipo_usuario'] ;
            $this->estatus = $row ['estatus'] ;
            return true ;
        }
        else{
            return false ;
        }


    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla" ;
        $resultado = $this->conexion->query($sql);
        $arrayUsuarios = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayUsuarios[] = $row ;
            }
            return $arrayUsuarios ;
        }
        else{
            return $arrayUsuarios ;
        }
    }

    function closeSession(){
        session_destroy() ;
    }
    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }
    
    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre ;
    }
    
    function getLogin(){
        return $this->login;
    }
    
    function getPassword(){
        return $this->password ;
    }
    
    function getTipoUsuario(){
        return $this->tipoUsuario ;
    }
    
    function getEstatus(){
        return $this->estatus;
    }

    
}


?>