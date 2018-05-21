<?php

//Crea tablas de salida
	
	$variab = array ('escorrentia', 'perc', 'etp', 'etr', 'lluvia', 'riego', 'ndis', 'nlix');
	$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");
	
	$dni = new mysqli("localhost", "root", "cubanito", "navarra_sim");

	for ($k= 0; $k<8; $k++) { // ejecuta para todas las variables
	
	/*$queryi = "DROP TABLE IF EXISTS`".$variab[$k]."`";
	$dni->query($queryi);*/
	

		$queryc = "CREATE TABLE IF NOT EXISTS  `".$variab[$k]."` ( `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,";
		$queryc .= "`idp` VARCHAR( 30 ) COLLATE utf8_spanish_ci NOT NULL , ";
	
			for ($y = 7; $y<= 12; $y++) { // Todos los años
				for ($j = 0; $j < 12; $j++) {
				$queryc .= "`".$meses[$j].$y."` DOUBLE DEFAULT NULL ,"; }
			}
		
		$queryc .= " PRIMARY KEY (  `id` ) ) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci ";
	
		$dni->query($queryc); 
	}
// Fin de creacion de tablas


?>