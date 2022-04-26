<?php
include_once("../library/Linea.php");
$linea            = new Linea();
$arreglo = $linea->getLineaIndicacion($_GET);
$resulta = array();
$serie = array();
$c=0;
$longitud = 0;
//$resulta[$c]['horario']=0;
//$resulta[$c]['profundidad'] = 0.300;

$c++;
foreach ($arreglo as $value) {

	$longitud = strlen($value['horario_tecnico']);
	if ($longitud <=6) {
		$cadena = $value['horario_tecnico'];
		$hora = substr($cadena, 0,2)*30;
		$minuto = substr($cadena, -2)*0.5;
		$puntomedio = $hora+$minuto;
		$puntomedio = round($puntomedio,0);
		if ($puntomedio >12) {
			$puntomedio = $puntomedio-12;
		}
		$resulta[$c]['horario'] = $puntomedio;
		//$cadena = $cadena.round($hora+$minuto,0).','.$value['profundidad'];
		//$serie[]=round($hora+$minuto,0).','.$value['profundidad'];
	} else {
		$cadena = $value['horario_tecnico'];
		$hora1 = substr($cadena, -5);
		$horax = substr($hora1, 0,2)*30;
		$minutox = substr($hora1, -2)*0.5;
		$tiempox = round($horax+$minutox,0);
		$hora2 = substr($cadena, 0,5);
		$horay = substr($hora2, 0,2)*30;
		$minutoy = substr($hora2, -2)*0.5;
		$tiempoy = round($horay+$minutoy,0);
		$puntomedio = ($tiempoy + $tiempox)/2;

		if ($puntomedio >12) {
			$puntomedio = $puntomedio-12;
		}
		$resulta[$c]['horario'] = round($puntomedio,0);
		//$cadena = $cadena.round($puntomedio,0).','.$value['profundidad'];
		//$serie[]=round($puntomedio,0).','.$value['profundidad'];
	}
	$resulta[$c]['profundidad'] = $value['profundidad'];
	$resulta[$c]['horario_tecnico'] = $value['horario_tecnico'];
	$resulta[$c]['simbologia'] = $value['simbologia'];
	$resulta[$c]['descripcion'] = $value['descripcion'];
	$resulta[$c]['espesor_remanente'] = $value['espesor_remanente'];
	$resulta[$c]['tipo_inspeccion'] = $value['tipo_inspeccion'];
	$resulta[$c]['porcentaje_perdida'] =$value['porcentaje_perdida'];
	//$resulta[$c]['simbologia'] = $value['simbologia'];
	//$resulta[$c]['descripcion'] = $value['descripcion'];
	$c++;
}
	/*$resulta[$c]['profundidad'] = 0.6;
	$resulta[$c]['horario_tecnico'] =12;
	$resulta[$c]['simbologia'] ='Esp Max';
	$resulta[$c]['descripcion'] ='Esp. Maximo';
	$resulta[$c]['espesor_remanente'] = 0.6*/
//--------------------------indicaciones externas--------------------------
//------------------------------fin de indicaciones externas--------------

sort($resulta);
//print_r($resulta);
echo json_encode($resulta);
?>