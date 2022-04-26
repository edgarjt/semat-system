<?php
include_once("../library/Linea.php");
$linea            = new Linea();
$idlinea=$_GET['id_linea'];
echo json_encode($linea->getLineaId($idlinea));
?>