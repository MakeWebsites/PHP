<?php

$year = 2012;

$dn = new mysqli("localhost", "root", "", "navarra_general");
$dny = new mysqli("localhost", "root", "", "navarra_".strval($year));
$py = 'perc'.substr(strval($year),-2);

$initr = 70; // Contenido  inicial de nitrogeno
$cl = 0.3; // coeficiente de lixiviado segun Tabla

$ips = array();
$percs = array();

$meses = array ('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
$vb = array ('ndis', 'nlix');



// Crea las tabla
for ($k= 0; $k<2; $k++) { // ejecuta para todas las variables

	$queryc = "CREATE TABLE IF NOT EXISTS  `".$vb[$k].substr(strval($year), -2)."` ( `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,";
	$queryc .= "`idp` VARCHAR( 30 ) COLLATE utf8_spanish_ci NOT NULL , ";
	
		for ($j = 0; $j < 12; $j++) 
		$queryc .= "`".$meses[$j]."` DOUBLE DEFAULT NULL ,";
		
	$queryc .= " PRIMARY KEY (  `id` ) ) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci ";
	
	$dny->query($queryc); 
	}
// Fin de creacion de tablas


//$dperc = $dny->query("SELECT * FROM `perc`");
$dperc = $dny->query("SELECT * FROM  `perc` INNER JOIN p2012 ON perc.idp = p2012.idp AND (p2012.cultivo !=  'No_aplica') ");
$nump = $dperc->num_rows;

while ($dp = mysqli_fetch_assoc($dperc)) { // Descarga la tabla de percolaciones en arreglo
	$ips[] = $dp['idp']; // Identificador de parcela
		for ($j = 0; $j < 12; $j++) 
		$percs[$meses[$j]][] = $dp[$meses[$j]]; 
		}


for ($i = 0; $i < $nump; $i++) { 

	$ip = $ips[$i];
	
		
		for ($j = 0; $j < 12; $j++)
		$p[$meses[$j]] = $percs[$meses[$j]][$i];
		
	
	$cdat = $dny->query("SELECT `cultivo` FROM p".strval($year)." where `idp`= '$ip'");
	$cd = mysqli_fetch_assoc($cdat);
	$cropn = $cd['cultivo'];  // Cultivo en esa parcela
	
	
		// Datos de N para ese cultivo
		$nfdat = $dn->query("SELECT * FROM nfert where `idc`= '$cropn'");
		while ($nf = mysqli_fetch_assoc($nfdat)) { // Descarga la tabla de fertilizaciones en arreglo
				for ($j = 0; $j < 12; $j++)
				$fert[$meses[$j]] = $nf[$meses[$j]]; 
				
				}
		
			
		$nbdat = $dn->query("SELECT * FROM nbal where `idc`= '$cropn'");
		while ($nb = mysqli_fetch_assoc($nbdat)) { // Descarga la tabla de fertilizaciones en arreglo
			
				for ($j = 0; $j < 12; $j++)
				$bal[$meses[$j]] = $nb[$meses[$j]]; }
			
		$bn['ene'] = $initr - $fert['ene'] * 0.11076 + $fert['ene'] + $bal['ene'];
			if ($bn['ene'] < 0) $bn['ene'] = 0;
		$nl['ene'] = $bn['ene'] * $cl * ($p['ene']/100);
			if ($nl['ene'] < 0) $nl['ene'] = 0;
			
		
				for ($j = 1; $j < 12; $j++) {
			$bn[$meses[$j]] = $bn[$meses[$j-1]] - $fert[$meses[$j]] * 0.11076 + $fert[$meses[$j]] + $bal[$meses[$j]] - $nl[$meses[$j-1]];
				if ($bn[$meses[$j]] < 0) $bn[$meses[$j]] = 0;
			$nl[$meses[$j]] = ($bn[$meses[$j]] * $cl) * ($p[$meses[$j]]/100); 
				if ($nl[$meses[$j]] < 0) $nl[$meses[$j]] = 0;
			}
		
		$varv = array();
		
		$vv[0] = $bn;
		$vv[1] = $nl;	
		
		// Graba las tablas
		
		for ($k= 0; $k<2; $k++) { // ejecuta para todas las variables
				
		$queryl = "INSERT INTO `".$vb[$k].substr(strval($year), -2)."` (`idp`, ";
	
			foreach ($meses as $mes)
			$varm[] = "`".$mes."`";
			
			$queryl .= implode(", ",$varm);
		
		$queryl .= ") VALUES( '$ip', ";
			
			for($j=0; $j<12; $j++)
			$varv[] = number_format($vv[$k][$meses[$j]], 2);

			
			$queryl .= implode(", ",$varv);
			
			$queryl .= ")";
		
		$dny->query($queryl);
	
	unset($varm);
	unset($varv);
	
		} 		
		
		mysqli_free_result($cdat);
		mysqli_free_result($nfdat);
		mysqli_free_result($nbdat);
	

	} // Cierre del for para todas las parcelas con percolacion y cultivo

mysqli_free_result($dperc);
echo 'He terminado';

?>