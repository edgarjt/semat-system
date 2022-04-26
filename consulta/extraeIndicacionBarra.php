<?php
include_once("../library/Linea.php");
$linea            = new Linea();
echo json_encode($linea->getGraficaBarra($_GET));
?>