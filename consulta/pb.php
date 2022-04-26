<?php

/* -------------------------------------------
Insertaremos el Host a escanear en la URL

http://www.host.com/PortScan.php?host=xx.xxx.xx.xx;
http://www.host.com/PortScan.php?host=www.google.com;

*/

$Host = $_GET["host"];

//Volcamos el Listado de Puertos Scaneados en un tabla ...

echo '<table style="padding:8px;">';
echo '<tr style="background-color:gray;"><th style="font-size:14px; font-weight:bold;">Port</th> <th style="font-size:14px; font-weight:bold;">Estado</th> <th style="font-size:14px; font-weight:bold;">Mensaje</th></tr>';

for ($i=0;$i<100;$i++) {

if ($port = @fsockopen ($Host, $i, $errno, $errstr, 10)) {

$Msg = fgets($port, 1024);

if ($Msg==""){ $Mensaje = "Puerto abierto, no emite respuesta."; }else{ $Mensaje = $Msg; }

echo '<tr style="background-color:red; padding:8px; font-weight:bold;"><td>'.$i.'</td> <td>Abierto</td> <td>'.$Mensaje.'</td></tr>';

fclose ();

}else{

echo '<tr style="background-color:green; padding:8px; font-weight:bold;"><td>'.$i.'</td> <td>Cerrado</td> <td>El puerto está cerrado.</td></tr>';

}

fflush();

}

echo '</table>';

?>