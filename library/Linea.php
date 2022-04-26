<?php
include_once 'Database.php';

class Linea
{    
    private $id ;
    private $nombre ;
    private $diametro ;
    private $denominacion_tecnica ;
    private $ubicacion_tecnica ;
    private $ddv ;
    private $smys ;
    private $fcp ;
    private $fdis ;
    private $ftemp ;
    private $fjl ;
    private $presion_maxima_operacion ;
    private $presion_actual ;
    private $temperatura_maxima_operacion ;
    private $clase_localizacion ;
    private $tipo_producto ;
    private $servicio ;
    private $especificacion_material ;
    private $fecha_construccion ;
    private $fecha_inicio_operacion ;
    private $diametro_nominal ;
    private $diametro_exterior ;
    private $id_tipo_instalacion ;
    static  
    $array_clase_localizacion            
    = array
    (
        'N/E',
        '1 Y 2',
        '3 Y 4',
        '1',
        '2',
        '3',
        '4'
    );
    static 
     $array_tipo_producto                 
    = 
    array
    (
        'N/A',
        'ACEITE',
        'MAYA',
        'OLMECA',
        'OLMECA ISTMO/OLMECA',
        'ISTMO',
        'ALTAMIRA',
        'CRUDO',
        'CRUDO OLMECA',
        'CRUDO MAYA',
        'CRUDO TERCIARIO',
        'CRUDO ISTMO',
        'CRUDO ISTMO - OLMECA',
        'CRUDO LIGERO ISTMO',
        'GAS DULCE HUMEDO',
        'GAS HUMEDO',
        'ACEITE Y GAS',
        'GAS AMARGO',
        'GAS SECO',
        'GAS COMBUSTIBLE',
        'GAS RESIDUAL',
        'GASOLINA',
        'GAS TERCIARIO',
        'SALMUERA',
		'AMONIACO'
    );
    static  
    $array_servicio                      
    = array
    (
        'N/A',
        'OLEODUCTO',
        'GASODUCTO',
        'OLEOGASODUCTO',
        'GASOLINODUCTO',
        'SALMUERODUCTO',
        'ACUEDUCTO',
		'AMONIADUCTO'
    );
    static  
    $array_especificacion_material 
    = array
    (
        'N/A',
        'API-STD-5L-X-42',
        'API-5L-X46',
        'API-5L-X52',
        'API-5L-X56',
        'API-5L-X60',
        'API-5L-X65',
        'ASTM',
        'API-STD-5L-X56',
        'API-5L-GB',
        'API-STD-5L-X-52',
        'API-STD-5L-X-65',
        'API-STD-5L-X-46',
        'API-STD-SL-GR.B'
    );
    private $tabla ;
    private $conexion ;    
    function __construct(){
        $ob = new Database();
        $this->conexion = $ob->getConexion();
        $this->tabla = "linea" ;
    }
    
    function insert( $linea )
    {
        $sql = "INSERT INTO $this->tabla VALUES(0, '"
                . strtoupper( $linea['nombre'] ) . "',"
                . $linea['diametro'] .","
                . "'" . strtoupper($linea['denominacion_tecnica']) ."',"
                . "'" . strtoupper($linea['ubicacion_tecnica']) ."',"
                . $linea['id_ddv'] . ','
                . $linea['smys'] .  ","
                . $linea['fcp'] . ","
                . $linea['fdis'] . ","
                . $linea['ftemp'] . ","
                . $linea['fjl'] . ","
                . $linea['presion_maxima_operacion'] . ","
                . $linea['presion_actual'] . ","
                . $linea['temperatura_maxima_operacion'] . ","
                . "'". strtoupper( $linea['clase_localizacion'] ) . "',"
                . "'". strtoupper( $linea['tipo_producto'] ) . "',"
                . "'". strtoupper( $linea['servicio'] ) . "',"
                . "'". strtoupper( $linea['especificacion_material'] ) . "',"
                . "'".  $linea['fecha_construccion']  . "',"
                . "'".  $linea['fecha_inicio_operacion']  . "',"
                . $linea['diametro_nominal'] . ","
                . $linea['diametro_exterior'].","
                . $linea['id_tipo_instalacion'] 
                . "  )" ;
        
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($linea){
        $sql = "UPDATE $this->tabla SET "
                . " NOMBRE = '" . strtoupper( $linea['nombre'] ). "',"
                . " DIAMETRO = " . strtoupper( $linea['diametro'] ). ","
                . " DENOMINACION_TECNICA = '" . strtoupper( $linea['denominacion_tecnica'] ). "',"
                . " UBICACION_TECNICA = '" . strtoupper( $linea['ubicacion_tecnica'] ). "',"
                . " ID_DDV = " . strtoupper( $linea['id_ddv'] ) .","
                . " SMYS = " . $linea['smys'] . ","
                . " FCP = " . $linea['fcp'] . ","
                . " FDIS = " . $linea['fdis'] . ","
                . " FTEMP = " . $linea['ftemp'] . ","
                . " FJL = " . $linea['fjl'] . ","
                . " PRESION_MAXIMA_OPERACION = " . $linea['presion_maxima_operacion'] . ","
                . " PRESION_ACTUAL = " . $linea['presion_actual'] . ","
                . " TEMPERATURA_MAXIMA_OPERACION = " . $linea['temperatura_maxima_operacion'] . ","
                . " CLASE_LOCALIZACION = '" . strtoupper( $linea['clase_localizacion'] ). "',"
                . " TIPO_PRODUCTO = '" . strtoupper( $linea['tipo_producto'] ). "',"
                . " SERVICIO = '" . strtoupper( $linea['servicio'] ). "',"
                . " ESPECIFICACION_MATERIAL = '" . strtoupper( $linea['especificacion_material'] ). "',"
                . " FECHA_CONSTRUCCION = '" .  $linea['fecha_construccion'] . "',"
                . " FECHA_INICIO_OPERACION = '" .  $linea['fecha_inicio_operacion'] . "',"
                . " DIAMETRO_NOMINAL = " . $linea['diametro_nominal'] . ","
                . " DIAMETRO_EXTERIOR = " . $linea['diametro_exterior'] . ","
                . " id_tipo_instalacion = " . $linea['id_tipo_instalacion'] 
                . " WHERE ID_LINEA = " . $linea['id_linea'] ;
        return $this->conexion->query($sql);
    }
    
    function delete($linea){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_LINEA = " . $linea['id_linea'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById($linea)
    {
        $sql = "SELECT * FROM $this->tabla WHERE ID_LINEA = $linea " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
             $row = $resultado->fetch_assoc();
             $this->id = $row ['id_linea'] ;
             $this->nombre = $row ['nombre'] ;
             $this->diametro = $row['diametro'] ;
             $this->denominacion_tecnica = $row['denominacion_tecnica'] ;
             $this->ubicacion_tecnica    = $row['ubicacion_tecnica'] ;
             $this->ddv = $row['id_ddv'] ;
             $this->smys = $row['smys'] ;
             $this->fcp= $row['fcp'] ;
             $this->fdis = $row['fdis'] ;
             $this->ftemp= $row['ftemp'] ;
             $this->fjl= $row['fjl'] ;
             $this->presion_maxima_operacion= $row['presion_maxima_operacion'] ;
             $this->presion_actual= $row['presion_actual'] ;
             $this->temperatura_maxima_operacion= $row['temperatura_maxima_operacion'] ;
             $this->clase_localizacion= $row['clase_localizacion'] ;
             $this->tipo_producto= $row['tipo_producto'] ;
             $this->servicio= $row['servicio'] ;
             $this->especificacion_material= $row['especificacion_material'] ;
             $this->fecha_construccion= $row['fecha_construccion'] ;
             $this->fecha_inicio_operacion= $row['fecha_inicio_operacion'] ;
             $this->diametro_nominal= $row['diametro_nominal'] ;
             $this->diametro_exterior= $row['diametro_exterior'] ;
             $this->id_tipo_instalacion= $row['id_tipo_instalacion'] ;
            return true ;
        }
        else
        {
         return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT * FROM $this->tabla" ;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
            return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
    }

    function getAllByDiametro(){
        $sql = "SELECT * FROM $this->tabla order by diametro asc" ;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
            return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
    }
    function getByDdv($id_ddv){
        $sql = "SELECT * FROM $this->tabla where id_ddv = $id_ddv order by diametro asc" ;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
            return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
    }
    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }

     function getJsonLoadById($id_linea){

        $sql = "SELECT * FROM $this->tabla where id_linea = $id_linea" ;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
        return json_encode($arrayLineas, true) ;
         // return $arrayLineas ;

        }
        else{
            return $arrayLineas ;
        }
    }

     function getJsonLoadByIdLineaHasContrato($id_linea){

        $sql = "
                select linea.* from linea,linea_has_contrato
                where linea_has_contrato.id_linea = linea.id_linea
                and linea_has_contrato.id_linea_has_contrato = $id_linea
         " ;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
        return json_encode($arrayLineas, true) ;
         // return $arrayLineas ;

        }
        else{
            return $arrayLineas ;
        }
    }

    function getJsonByContratoSector($id_sector,$id_contrato)
    {
        $sql       = 
        "
       select  distinct
               contrato.id_contrato,
               contrato.numero,
               sector.id_sector,
               sector.descripcion,
               linea_has_contrato.id_linea_has_contrato as id_linea,linea.nombre 
        from   sector,contrato,linea,linea_has_contrato, ddv
        where  linea.id_ddv = ddv.id_ddv
        and    ddv.id_sector = $id_sector
        and    sector.id_sector            = $id_sector     
        and    linea_has_contrato.id_linea = linea.id_linea
        and    linea_has_contrato.id_contrato = $id_contrato
        and    contrato.id_contrato = $id_contrato
        order  by linea.diametro asc;
        " ;
        $resultado = $this->conexion->query($sql) ;
        $contratos = array() ;
        if($resultado->num_rows>0)
        {
                while ($row = $resultado->fetch_assoc() ) 
                {
                    $contratos[] = $row ;
                }
            }
            return json_encode($contratos, true);
    }

    function getJsonByContratoSector_($id_sector,$id_contrato)
    {

        $sql       = 
        "
        select distinct sector.descripcion, sector.id_sector, contrato.id_contrato, linea.id_linea, linea.nombre
        from   orden_servicio,sector,contrato,linea_has_contrato,linea
        where  orden_servicio.id_contrato = contrato.id_contrato
        and    contrato.id_contrato                 = $id_contrato
        and    orden_servicio.id_sector             = sector.id_sector
        and    sector.id_sector                     = $id_sector
        and    orden_servicio.id_linea_has_contrato = linea_has_contrato.id_linea_has_contrato
        and    linea_has_contrato.id_linea = linea.id_linea
        order by linea.nombre asc

        " ;
        $resultado = $this->conexion->query($sql) ;
        $contratos = array() ;
        if($resultado->num_rows>0)
        {
                while ($row = $resultado->fetch_assoc() ) 
                {
                    $contratos[] = $row ;
                }
            }
            return json_encode($contratos, true);
    }


    function getLineaSubdireccion($subdireccion){
        $sql = "SELECT * FROM $this->tabla" 
        ." INNER JOIN linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea"
        ." INNER JOIN contrato on linea_has_contrato.id_contrato = contrato.id_contrato"
        ." WHERE contrato.subdireccion = '".$subdireccion."'";
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }

    function getLineaId($idlinea){
        $sql = "SELECT * FROM $this->tabla" 
        ." WHERE id_linea = ".$idlinea;
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }

    function getLineaIndicacion($dato){
        $sql = "SELECT indicacion.profundidad, indicacion.horario_tecnico, indicacion.espesor_remanente, indicacion.porcentaje_perdida, tipo_indicacion.simbologia, tipo_indicacion.descripcion, tipo_indicacion.tipo_inspeccion FROM $this->tabla" 
        ." INNER JOIN linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea  "
        ." INNER JOIN orden_servicio on linea_has_contrato.id_linea_has_contrato = orden_servicio.id_linea_has_contrato"
        ." INNER JOIN programa on orden_servicio.id_orden_servicio = programa.id_orden_servicio"
        ." INNER JOIN indicacion on programa.id_programa = indicacion.id_programa"
        ." INNER JOIN tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion"
        ." WHERE linea.id_linea  = ".$dato['id_linea']." and tipo_indicacion.evaluacion = 1";
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }


    function getEspMaxMin($dato){
        $sql = "SELECT max(indicacion.espesor_maximo_zona_sana) as maximo, min(indicacion.espesor_minimo_zona_sana) as minimo FROM $this->tabla" 
        ." INNER JOIN linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea  "
        ." INNER JOIN orden_servicio on linea_has_contrato.id_linea_has_contrato = orden_servicio.id_linea_has_contrato"
        ." INNER JOIN programa on orden_servicio.id_orden_servicio = programa.id_orden_servicio"
        ." INNER JOIN indicacion on programa.id_programa = indicacion.id_programa"
        ." INNER JOIN tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion"
        ." WHERE linea.id_linea  = ".$dato['id_linea']." and tipo_indicacion.evaluacion = 1 ";
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }

    function getGraficaBarra($dato){
        $sql = "SELECT count(indicacion.id_indicacion) as totind, tipo_indicacion.simbologia, tipo_indicacion.descripcion FROM $this->tabla" 
        ." INNER JOIN linea_has_contrato on linea.id_linea = linea_has_contrato.id_linea  "
        ." INNER JOIN orden_servicio on linea_has_contrato.id_linea_has_contrato = orden_servicio.id_linea_has_contrato"
        ." INNER JOIN programa on orden_servicio.id_orden_servicio = programa.id_orden_servicio"
        ." INNER JOIN indicacion on programa.id_programa = indicacion.id_programa"
        ." INNER JOIN tipo_indicacion on indicacion.id_tipo_indicacion = tipo_indicacion.id_tipo_indicacion"
        ." WHERE linea.id_linea  = ".$dato['id_linea']." group by tipo_indicacion.simbologia";
        $resultado = $this->conexion->query($sql);
        $arrayLineas = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrayLineas[] = $row ;
            }
           return $arrayLineas ;
        }
        else{
            return $arrayLineas ;
        }
        //return $sql;
    }
    
    function getId(){
        return $this->id;
    }
    
    function getNombre(){
        return $this->nombre;
    }
    
    function getDiametro(){
        return $this->diametro ;
    }
    
    function getDenominacionTecnica(){
        return $this->denominacion_tecnica;
    }

    function getUbicacionTecnica(){
        return $this->ubicacion_tecnica;
    }
    
    function getDdv(){
        return $this->ddv;
    }

    function getSmys(){
        return $this->smys;
    }

    function getFcp(){
        return $this->fcp ;
    }

    function getFdis(){
        return $this->fdis ;
    }

    function getFtemp(){
        return $this->ftemp ;
    }

    function getFjl(){
        return $this->fjl ;
    }

    function getPresionMaximaOperacion(){
        return $this->presion_maxima_operacion ;
    }

    function getPresionActual(){
        return $this->presion_actual ;
    }
    
    function getTemperaturaMaximaOperacion(){
        return $this->temperatura_maxima_operacion ;
    }

    function getClaseLocalizacion(){
        return $this->clase_localizacion ;
    }

    function getTipoProducto(){
        return $this->tipo_producto ;
    }

    function getServicio(){
        return $this->servicio ;
    }

    function getEspecificacionMaterial(){
        return $this->especificacion_material ;
    }

    function getFechaConstruccion(){
        return $this->fecha_construccion ;
    }

    function getFechaInicioOperacion(){
        return $this->fecha_inicio_operacion ;
    }

    function getDiametroNominal(){
        return $this->diametro_nominal ;
    }

    function getDiametroExterior(){
        return $this->diametro_exterior ;
    }

    function getIdTipoInstalacion(){
        return $this->id_tipo_instalacion ;
    }
}
?>
