<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'Database.php';
class OrdenServicio
{    
    private $id ;
    private $numero_orden ;
    private $descripcion ;
    private $linea_has_contrato ;
    private $sector ;
    private $contrato ;
    private $tipo_trabajo ;
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
    private $archivo ;
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
        $this->tabla = "orden_servicio" ;
    }
    
    function insert( $orden_servicio ){
        $sql = "INSERT INTO $this->tabla VALUES(0, "
                . "'". strtoupper( $orden_servicio['numero_orden'] ) . "',"
                . "'". strtoupper( $orden_servicio['descripcion'] ) . "',"
                . $orden_servicio['id_sector'] . ","
                . $orden_servicio['id_contrato'] . ","
                . $orden_servicio['id_tipo_trabajo'] . ","
                . $orden_servicio['id_linea_has_contrato'] .","
                . $orden_servicio['smys'] . ","
                . $orden_servicio['fcp'] . ","
                . $orden_servicio['fdis'] . ","
                . $orden_servicio['ftemp'] . ","
                . $orden_servicio['fjl'] . ","
                . $orden_servicio['presion_maxima_operacion'] . ","
                . $orden_servicio['presion_actual'] . ","

                . $orden_servicio['temperatura_maxima_operacion'] . ","
                . "'". strtoupper( $orden_servicio['clase_localizacion'] ) . "',"
                . "'". strtoupper( $orden_servicio['tipo_producto'] ) . "',"
                . "'". strtoupper( $orden_servicio['servicio'] ) . "',"
                . "'". strtoupper( $orden_servicio['especificacion_material'] ) . "',"
                . "'".  $orden_servicio['fecha_construccion']  . "',"
                . "'".  $orden_servicio['fecha_inicio_operacion']  . "',"
                . $orden_servicio['diametro_nominal'] . ","
                . $orden_servicio['diametro_exterior'] . ","
                . " ''"
                . "  )" ;
        $this->conexion->query($sql);
        return $this->conexion->insert_id;
    }
    
    function update($orden_servicio){
        $sql = "UPDATE $this->tabla SET "
                . " NUMERO_ORDEN = '" . strtoupper( $orden_servicio['numero_orden'] ). "',"
                . " DESCRIPCION = '" . strtoupper( $orden_servicio['descripcion'] ). "',"
                . " ID_SECTOR = " . $orden_servicio['id_sector'] . ","
                . " ID_CONTRATO = " . $orden_servicio['id_contrato'] . ","
                . " ID_TIPO_TRABAJO = " . $orden_servicio['id_tipo_trabajo'] . ","
                . " ID_LINEA_HAS_CONTRATO = " . $orden_servicio['id_linea_has_contrato'] . ","
                . " SMYS = " . $orden_servicio['smys'] . ","
                . " FCP = " . $orden_servicio['fcp'] . ","
                . " FDIS = " . $orden_servicio['fdis'] . ","
                . " FTEMP = " . $orden_servicio['ftemp'] . ","
                . " FJL = " . $orden_servicio['fjl'] . ","
                . " PRESION_MAXIMA_OPERACION = " . $orden_servicio['presion_maxima_operacion'] . ","
                . " PRESION_ACTUAL = " . $orden_servicio['presion_actual'] . ","
                . " TEMPERATURA_MAXIMA_OPERACION = " . $orden_servicio['temperatura_maxima_operacion'] . ","
                . " CLASE_LOCALIZACION = '" . strtoupper( $orden_servicio['clase_localizacion'] ). "',"
                . " TIPO_PRODUCTO = '" . strtoupper( $orden_servicio['tipo_producto'] ). "',"
                . " SERVICIO = '" . strtoupper( $orden_servicio['servicio'] ). "',"
                . " ESPECIFICACION_MATERIAL = '" . strtoupper( $orden_servicio['especificacion_material'] ). "',"
                . " FECHA_CONSTRUCCION = '" .  $orden_servicio['fecha_construccion'] . "',"
                . " FECHA_INICIO_OPERACION = '" .  $orden_servicio['fecha_inicio_operacion'] . "',"
                . " DIAMETRO_NOMINAL = " . $orden_servicio['diametro_nominal'] . ","
                . " DIAMETRO_EXTERIOR = " . $orden_servicio['diametro_exterior'] 
                . " WHERE ID_ORDEN_SERVICIO = " . $orden_servicio['id_orden_servicio'] ;
        return $this->conexion->query($sql);
    }

    function updateArchivo($id_os, $archivo){
        $sql = "update $this->tabla set archivo = '".$archivo."' where id_orden_servicio = $id_os "  ;
        return $this->conexion->query($sql);
    }
    
    function delete($orden_servicio){
        $sql = "DELETE FROM $this->tabla "
            . " WHERE ID_ORDEN_SERVICIO = " . $orden_servicio['id_orden_servicio'] ;
        return $this->conexion->query($sql);
    }
    
    function loadById( $orden_servicio ){
        $sql = "SELECT * FROM $this->tabla WHERE ID_ORDEN_SERVICIO = $orden_servicio " ;
        $resultado = $this->conexion->query($sql) ;
        if($resultado->num_rows > 0) {
             $row = $resultado->fetch_assoc();
             $this->id = $row ['id_orden_servicio'] ;
             $this->numero_orden = $row ['numero_orden'] ;
             $this->descripcion = $row['descripcion'] ;
             $this->linea_has_contrato = $row['id_linea_has_contrato'] ;
             $this->sector = $row['id_sector'] ;
             $this->contrato = $row['id_contrato'] ;
             $this->tipo_trabajo = $row['id_tipo_trabajo'] ;
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
             $this->archivo = $row['archivo'] ;
            return true ;
        }
        else{
            return false ;
        }
    }
    
    function getAll(){
        $sql = "SELECT os.id_orden_servicio, os.numero_orden, os.descripcion, os.id_linea_has_contrato, os.id_sector, os.id_contrato, ".
		" os.id_tipo_trabajo, os.smys, os.fcp, os.fdis, os.ftemp, os.fjl, os.presion_maxima_operacion, os.presion_actual, os.temperatura_maxima_operacion, ".
		" os.clase_localizacion, os.tipo_producto, os.servicio, os.especificacion_material, os.fecha_construccion, os.fecha_inicio_operacion,".
		" os.diametro_nominal, os.diametro_exterior, os.archivo " .		
		"FROM $this->tabla as os  " .
		" join contrato as c on os.id_contrato = c.id_contrato " . 
		" join usuario_has_contrato as uhc on uhc.id_contrato = c.id_contrato " .
		" where uhc.id_usuario = " . $_SESSION['id_usuario'] ." order by os.numero_orden ";
        //echo $sql ;
        $resultado = $this->conexion->query($sql);
        $arrays = array() ;
        
        if($resultado->num_rows > 0){
            while( $row = $resultado->fetch_assoc() ){
                $arrays[] = $row ;
            }
        }
            return $arrays ;
    }

    function getAll_2(){
        $sql = "select * from $this->tabla " ;
        $resultado = $this->conexion->query($sql) ;
        $contratos = array() ;
        if($resultado->num_rows>0){
            while ($row = $resultado->fetch_assoc() ) {
                $contratos[] = $row ;
            }
        }

        return $contratos ;
    }

    function loadForFiltros($id_contrato, $id_tipo_trabajo){
        $where_c = " id_contrato > 0 " ;
        $where_tt = " id_tipo_trabajo > 0 " ;

        if($id_contrato > -1) {
            $where_c = " id_contrato = $id_contrato " ;
        }

        if($id_tipo_trabajo > -1) {
            $where_tt = " id_tipo_trabajo = $id_tipo_trabajo " ;
        }

        $sql = "select * from $this->tabla where $where_c and $where_tt " ;
        $resultado = $this->conexion->query($sql) ;
        $ordenes = array() ;
        if($resultado->num_rows>0){
            while ($row = $resultado->fetch_assoc() ) {
                $ordenes[] = $row ;
            }
        }

        return $ordenes ;

    }


    
    function getAllJson(){
        return json_encode($this->getAll(), true) ;
    }

    function getJson(){
            return json_encode($this->getAll_2(), true);
        }
    
    function getJsonBySector($id_sector,$id_contrato)
    {

        $sql       = 
        "
        select sector.id_sector,sector.descripcion, orden_servicio.numero_orden,orden_servicio.id_orden_servicio 
        from   orden_servicio,sector,contrato
        where  orden_servicio.id_sector = sector.id_sector
        and    sector.id_sector         = $id_sector
        and  orden_servicio.id_contrato = contrato.id_contrato
        and contrato.id_contrato        = $id_contrato
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
    
    function getId(){
        return $this->id;
    }
    
    function getNumeroOrden(){
        return $this->numero_orden;
    }
    
    function getDescripcion(){
        return $this->descripcion ;
    }
    
    function getLineaHasContrato(){
        return $this->linea_has_contrato ;
    }
    
    function getSector(){
        return $this->sector;
    }
    
    function getContrato(){
        return $this->contrato;
    }
    
    function getTipoTrabajo(){
        return $this->tipo_trabajo;
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

    function getArchivo(){
        return $this->archivo ;
    }

     function getClase_localizacion(){
        return $this->clase_localizacion;
    }

    function getTipo_producto(){
        return $this->tipo_producto;
    }

    function getEspecificacion_material(){
        return $this->especificacion_material;
    }

    function getFecha_construccion(){
        return $this->fecha_construccion;
    }

    function getFecha_inicio_operacion(){
        return $this->fecha_inicio_operacion;
    }

    function getDiametro_nominal(){
        return $this->diametro_nominal;
    }

    function getDiametro_exterior(){
        return $this->diametro_exterior;
    }

    function getPresion_maxima_operacion(){
        return $this->presion_maxima_operacion;
    }

    function getTemperatura_maxima_operacion(){
        return $this->temperatura_maxima_operacion;
    }   
}
?>