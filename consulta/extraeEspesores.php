<?php
include_once("../library/Linea.php");
$linea            = new Linea();
echo json_encode($linea->getEspMaxMin($_GET));
?>