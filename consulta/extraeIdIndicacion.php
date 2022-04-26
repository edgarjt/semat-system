<?php
include_once("../library/Indicacion.php");
$indicacion            = new Indicacion();
$idindicacion=$_GET['id_indicacion'];
echo json_encode($indicacion->getIndicacionId($idindicacion));
?>