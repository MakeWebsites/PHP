<?php
$dni = new mysqli("localhost", "root", "", "navarra_sim");
$variab = array ('escorrentia', 'perc', 'etp', 'etr', 'lluvia', 'riego');
	$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");

	for ($k= 0; $k<6; $k++) { // ejecuta para todas las variables
	
	$queryi = "DROP TABLE IF EXISTS`".$variab[$k]."`";
	$dni->query($queryi);
	}
?>