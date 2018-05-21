<?php
session_start();


$np = $_SESSION['idp'];
$y = $_SESSION['y'];
$year = strval(2000 + $y);

$dng = new mysqli("localhost", "root", "cubanito", "navarra_general");
$dns = new mysqli("localhost", "root", "cubanito", "navarra_temp");
$dnp = new mysqli("localhost", "root", "cubanito", "navarra_sim");

$py = 'ns_p'.$year;

// Datos de cultivo 
$dpt = $dnp->query("SELECT * FROM $py where `idp` = '$np' ");
$dp = mysqli_fetch_assoc($dpt);
	$cropn = $dp['cultivo'];
	
$initr = 70; // Contenido  inicial de nitrogeno
$cl = 0.8; // coeficiente de lixiviado segun Tabla

$ips = array();
$percs = array();
$p = array();
$varv = array();

$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");
$vb = array ('ndis', 'nlix');
$pert = 'perc'.$y;


$dperc = $dns->query("SELECT * FROM $pert where `idp` = '$np'");
//$dperc = $dny->query("SELECT * FROM  `perc` INNER JOIN p2012 ON perc.idp = p2012.idp AND (p2012.cultivo !=  'No_aplica') ");

while ($dp = mysqli_fetch_assoc($dperc)) { // Descarga la tabla de percolaciones en arreglo
		/*for ($y = 7; $y<= 12; $y++)*/
		foreach ($meses as $mes) 
		$percs[$mes] = $dp[$mes]; 
		}


/*for ($y = 7; $y<= 12; $y++) {*/ // ejecuta para todos los años

	/*$cropn = $crops[$y];*/
	
	
		// Datos de N para ese cultivo
		$nfdat = $dng->query("SELECT * FROM nfert where `idc`= '$cropn'");
		$nresf = $nfdat->num_rows; 
		if ($nresf > 0) {
			while ($nf = mysqli_fetch_assoc($nfdat)) // Descarga la tabla de fertilizaciones en arreglo
				for ($j = 0; $j < 12; $j++)
				$fert[$meses[$j]] = $nf[$meses[$j]]; 
				}
		else 
			for ($j = 0; $j < 12; $j++)
			$fert[$meses[$j]] = 0; 
		
			
		$nbdat = $dng->query("SELECT * FROM nbal where `idc`= '$cropn'");
		$nresb = $nbdat->num_rows; 
		if ($nresb > 0) {
			while ($nb = mysqli_fetch_assoc($nbdat)) // Descarga la tabla de fertilizaciones en arreglo
				for ($j = 0; $j < 12; $j++)
				$bal[$meses[$j]] = $nb[$meses[$j]]; }
		else
			for ($j = 0; $j < 12; $j++)
			$bal[$meses[$j]] = 0;
			
			
			// calcula el balance
			
		$bn['oct'] = $initr - $fert['oct'] * 0.11076 + $fert['oct'] + $bal['oct'];
			if ($bn['oct'] < 0) $bn['oct'] = 0;
		$nl['oct'] = $bn['oct'] * $cl * ($percs['oct']/100);
			if ($nl['oct'] < 0) $nl['oct'] = 0;
		$v[$vb[0]]['oct'] = strval(number_format($bn['oct'],2));
		$v[$vb[1]]['oct'] = strval(number_format($nl['oct'],2));	
		//echo ' Calculando octubre, para la parcela '.$np.' y el cultivo '.$cropn.' la fert es '.$fert['oct'].' el balance es '.$bn['oct'].' y el nl es '.$nl['oct'].'<br>';	
		
				for ($j = 1; $j < 12; $j++) {
			$bn[$meses[$j]] = $bn[$meses[$j-1]] - $fert[$meses[$j]] * 0.11076 + $fert[$meses[$j]] + $bal[$meses[$j]] - $nl[$meses[$j-1]];
				if ($bn[$meses[$j]] < 0) $bn[$meses[$j]] = 0;
			$nl[$meses[$j]] = ($bn[$meses[$j]] * $cl) * ($percs[$meses[$j]]/100); 
				if ($nl[$meses[$j]] < 0) $nl[$meses[$j]] = 0;
			$v[$vb[0]][$meses[$j]] = strval(number_format($bn[$meses[$j]],2));
			$v[$vb[1]][$meses[$j]] = strval(number_format($nl[$meses[$j]],2));	
			}
			
		$initr = $bn['sep'];
		
		if ($nresf > 0) mysqli_free_result($nfdat);
		if ($nresb > 0) mysqli_free_result($nbdat);
		
		//} // fin del cfor por años
		
		// Graba las tablas
		
		for ($k= 0; $k<2; $k++) { // ejecuta para las dos variables
		
			$queryl = "INSERT INTO `".$vb[$k].$y."` (`idp`, ";
					
					/*for ($y = 7; $y<= 12; $y++)*/
					foreach ($meses as $mes)
					$varm[] = "`".$mes."`";
					
					$queryl .= implode(", ",$varm);
				
				$queryl .= ") VALUES( '$np', ";
				
									
					/*for ($y = 7; $y<= 12; $y++)*/
					foreach ($meses as $mes)
					$varv[] = $v[$vb[$k]][$mes];
		
					
					$queryl .= implode(",",array_values($varv));
					
				
								
				
				
			$queryl .= ")";
						
			$dns->query($queryl);
			//echo $queryl.'<br>';
			
			unset($varm);
			unset($varv);
		
		} // Fin del For variables
				
		mysqli_free_result($dperc);

if ($_SESSION['j']<=$_SESSION['nump']) {  // Aun debe calcular más
 $_SESSION['j']++; }


header("Location: http://localhost/Navarra/exe_SWAP_nit.php");
?>