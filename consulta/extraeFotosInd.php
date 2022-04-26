<?php
include_once("../library/IndicacionFoto.php");
$indicacion_foto            = new IndicacionFoto();
echo $indicacion_foto->getJsonByIndicacion($_GET['id_indicacion']);
?>