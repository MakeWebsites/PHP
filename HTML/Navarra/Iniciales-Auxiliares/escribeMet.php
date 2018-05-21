<?php



$dn = new mysqli("localhost", "root", "cubanito", "navarra_general");



$estaciones = array ('Artajona', 'Bargota',	'Cadreita',	'Carrascal', 'Falces', 'Fitero', 'Miranda', 'Murillo', 'Sartaguda', 'Tafalla', 'Traibuenas', 'Tudela');

$ruta = 'C:\\wamp\\www\\Navarra\\Datos\\meteo\\';

	$year = 2014;
		
		for ($i = 0; $i < 12; $i++) {
		
		$est = $estaciones[$i];
		$fmn = $est.'.'.substr(strval($year), -3);
		$fm = fopen($ruta.$fmn, "w");
		
		// Escribe encabezamiento
		
		fwrite($fm, "***************************************************************************".PHP_EOL);
		fwrite($fm, "* Filename: ".$fmn.PHP_EOL);
		fwrite($fm, "* Contents: SWAP - Meteorological data of ".$est." weather station".PHP_EOL);
		fwrite($fm, "***************************************************************************".PHP_EOL);
		fwrite($fm, "* Comment area: ".PHP_EOL);
		fwrite($fm, "*".PHP_EOL);
		fwrite($fm, "*".PHP_EOL);
		fwrite($fm, "***************************************************************************".PHP_EOL);
		fwrite($fm, "    Station   DD MM YYYY     RAD   Tmin   Tmax    HUM   WIND   RAIN   ETref".PHP_EOL);
		fwrite($fm, "*             nr nr   nr   kJ/m2      C      C    kPa    m/s     mm      mm".PHP_EOL);
		fwrite($fm, "***************************************************************************".PHP_EOL);		
		
		$dmet = $dn->query("SELECT * FROM dmeteo where year = '$year' and estacion = '$est'");
		
			while ($dm = mysqli_fetch_assoc($dmet)) { // Crea las lineas
			$linea = str_pad("'".$est."'", 14).str_pad($dm['dia'],2," ",STR_PAD_LEFT)." ".str_pad($dm['mes'],2," ",STR_PAD_LEFT)." ";
			$linea .= str_pad(strval($year),7).str_pad(number_format($dm['rad'],1, '.', ''),7," ",STR_PAD_LEFT)." ".str_pad(number_format($dm['tmin'],1),5," ",STR_PAD_LEFT)." ";
			$linea .= str_pad(number_format($dm['tmax'],1),5," ",STR_PAD_LEFT)."  ".str_pad(number_format($dm['hr'], 2),8).str_pad(number_format($dm['viento'], 2),5);
			$linea .= str_pad(number_format($dm['prec'],2), 6," ",STR_PAD_LEFT)."  ".'-99.9';
			fwrite($fm, $linea.PHP_EOL);
			} //cierre del while
		
		fclose($fm);
		mysqli_free_result($dmet);
		
		echo 'He escrito el fichero '.$fmn.'<br>';
		
		} // Cierre del for estaciones
		












?>
