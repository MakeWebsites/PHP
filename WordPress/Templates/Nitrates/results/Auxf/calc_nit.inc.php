<?php

$initr = 70; // Contenido  inicial de nitrogeno
$cl = 0.3; // coeficiente de lixiviado segun Tabla

$ips = array();
$percs = array();
$p = array();


$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

$fert = $_SESSION['fert'];
$bal = $_SESSION['bal'];



$percs = $perc;

$bn['oct'] = $initr - $fert['oct'] * 0.11076 + $fert['oct'] + $bal['oct'];
			if ($bn['oct'] < 0) $bn['oct'] = 0;
		$nl['oct'] = $bn['oct'] * $cl * ($percs['oct']/100);
			if ($nl['oct'] < 0) $nl['oct'] = 0;
//echo 'Para la parcela '.$idp.' el balance de oct es '.$bn['oct'].' y el lixiviado es '.$nl['oct'].'<br>';
			
for ($j = 1; $j < 12; $j++) {
			$bn[$meses[$j]] = $bn[$meses[$j-1]] - $fert[$meses[$j]] * 0.11076 + $fert[$meses[$j]] + $bal[$meses[$j]] - $nl[$meses[$j-1]];
				if ($bn[$meses[$j]] < 0) $bn[$meses[$j]] = 0;
			$nlix[$meses[$j]] = ($bn[$meses[$j]] * $cl) * ($percs[$meses[$j]]/100); 
				if ($nlix[$meses[$j]] < 0) $nlix[$meses[$j]] = 0;
				$nl[$meses[$j]] = strval(number_format($nlix[$meses[$j]], 2));
			//echo 'Para el mes de '.$meses[$j].' el balance  es '.$bn[$meses[$j]].' y el lixiviado es '.$nl[$meses[$j]].'<br>';
			}
		
			// calcula el balance
/*foreach ($meses as $mes) {
$baln = $inic - $fert[$mes] * 0.11076 + $fert[$mes] + $bal[$mes] - $nlix;
	if ($baln < 0) $baln = 0;
$nlix = $inic * $cl * ($percs[$mes]/100);
	if ($nlix < 0) $nlix = 0;
$nl[$mes] = strval(number_format($nlix,2));
$inic = $baln;
}*/

		// Graba las tablas
		
$wpdb->insert( $wpdb->prefix.'nlixt', array (
	'idp' => $idp,
	'oct' => $nl['oct'],
	'nov' => $nl['nov'],
	'dic' => $nl['dic'],
	'ene' => $nl['ene'],
	'feb' => $nl['feb'],
	'mar' => $nl['mar'],
	'abr' => $nl['abr'],
	'may' => $nl['may'],
	'jun' => $nl['jun'],
	'jul' => $nl['jul'],
	'ago' => $nl['ago'],
	'sep' => $nl['sep'],
	'area' => $area
	));


?>