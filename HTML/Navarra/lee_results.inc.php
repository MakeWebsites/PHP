<?php

$dnr = new mysqli("localhost", "root", "cubanito", "navarra_temp");


$lineas = array();
$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");
$vb = array ('escorrentia', 'perc', 'etp', 'etr', 'lluvia', 'riego');



	$lineas = file($rutaf."res_swap.inc");
	$top = 28; // Simulaciones que empiezan tres años antes

		for ($j=$top; $j<$top+13; $j++) { // procesa las lineas de datos del año
			$balv = explode(",", $lineas[$j]);
			$v[0][] = $balv[8]* 10;
			$v[1][] = - $balv[14]*10;
			$v[2][] = $balv[9] + $balv[11]* 10;
			$v[3][] = $balv[10] + $balv[12]* 10;
			$v[4][] = $balv[3]* 10;
			$v[5][] = $balv[5]* 10;		
		}
	

	// Llenado de las Tablas sql
	
		for ($k= 0; $k<6; $k++) { // ejecuta para todas las variables
		
			$queryl = "INSERT INTO `".$vb[$k].$y."` (`idp`, ";
					
					/*for ($y = 7; $y<= 12; $y++)*/
					foreach ($meses as $mes)
					$varm[] = "`".$mes."`";
					
					$queryl .= implode(", ",$varm);
				
				$queryl .= ") VALUES( '$np', ";
				
									
					for($j=0; $j<12; $j++)
					$varv[] = $v[$k][$j];
		
					
					$queryl .= implode(",",$varv);
					
				
								
				
				
			$queryl .= ")";
			//echo $queryl.'<br>';
			$dnr->query($queryl);
			
			unset($varm);
			unset($varv);
		
		} // Fin del For variables

?>