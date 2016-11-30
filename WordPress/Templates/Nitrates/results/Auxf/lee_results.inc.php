<?php
global $wpdb;

$lineas = array();
$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

//$variab = array ('perct', 'percp', 'nlixt');

//$areap = $wpdb->get_var('SELECT `area` FROM `'.$wpdb->prefix . 'p2012` where `idp` = "'.$idp.'"');

	$lineas = file($ruta."res_swap.inc");
	$k = 28; // Simulaciones que empiezan un año antes


		foreach ($meses as $mes) { // procesa las lineas de datos del año
		$balv = explode(",", $lineas[$k]);
		$p[] = - $balv[14]* 10; // Resultados a m3 por ha
		$k++;
								}
								
	$perc = array_combine($meses, $p);
	
	
	//Rellena perct
	
	$wpdb->insert( $wpdb->prefix.'perct', array (
	'idp' => $idp,
	'oct' => $perc['oct'],
	'nov' => $perc['nov'],
	'dic' => $perc['dic'],
	'ene' => $perc['ene'],
	'feb' => $perc['feb'],
	'mar' => $perc['mar'],
	'abr' => $perc['abr'],
	'may' => $perc['may'],
	'jun' => $perc['jun'],
	'jul' => $perc['jul'],
	'ago' => $perc['ago'],
	'sep' => $perc['sep'],
	'area' => $area
	));
			

?>