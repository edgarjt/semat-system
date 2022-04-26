
<?php
include_once("../library/Programa.php");
$programa            = new Programa();
$id = $_GET['id_programa'];
echo json_encode($programa->getActaPunto($id));
?>