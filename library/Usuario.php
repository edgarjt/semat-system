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

    function __construct()
    {
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
                . " nombre = '" . $usuario['nombre'] . "',"
                . " login = '" . $usuario['login'] . "',"
                . " password = '" . $usuario['password'] . "',"
                . " tipo_usuario = '" . $usuario['tipo_usuario'] . "',"
                . " estatus = '" . $usuario['estatus'] . "'"
                . " WHERE id_usuario = " . $usuario['id_usuario'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($usuario){
        $sql = "UPDATE $this->tabla SET "
            . " estatus = '" . $usuario['estatus'] ."'"
            . " WHERE id_usuario = " . $usuario['id_usuario'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $usuario ){
        $sql = "SELECT * FROM $this->tabla WHERE id_usuario = $usuario " ;
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
        $sql = "SELECT * FROM $this->tabla WHERE login = '".$usuario_login ."' AND password = '".$password_login."' AND estatus ='ACTIVO' "  ;
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