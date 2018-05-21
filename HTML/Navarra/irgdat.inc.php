<?php

// Datos iniciales generales
function esc_dia ($dia) {
	
	$dia_s = strval($dia);
	if ($dia < 10)
	$dia_s = '0'.$dia_s;
	return $dia_s;	
}

function inicio ($ds, $mess, $i) {
$com = 2;
if ($mess == $i - 3 and $ds>2)
$com = $ds;
return $com;
}

function detiene_esc ($dia, $limit, $i, $mesc, $diac) {

$stop = ($dia <= $limit);
if ($mesc == $i and $diac < $limit) // No es aun el mes de la cosecha
$stop = ($dia <= $diac);
return $stop; 

}

$meses = array (0=>'jan', 1=>'feb', 2=>'mar', 3=>'apr', 4=>'may', 5=>'jun', 6=>'jul', 7=>'aug', 8=>'sep', 9=>'oct', 10=>'nov', 11=>'dec');

$dn = new mysqli("localhost", "root", "cubanito", "navarra_general");

	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* Filename: Project.IRG".PHP_EOL);
	fwrite($irg, "* Contents: SWAP 2.0 - Fixed irrigations".PHP_EOL);
	fwrite($irg, "* Comments: File prepared with Pearl v1.1.f".PHP_EOL);
	fwrite($irg, "* Project = 'LIFE Navarra' Parcela = ".$np.PHP_EOL);
	fwrite($irg, "* Cultivo = ".$cropn.PHP_EOL);
	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* --- start of table".PHP_EOL);
	fwrite($irg, "* date_irg      depth  conc      sua".PHP_EOL);
	fwrite($irg, "*              (mm !!)  mg/cm3".PHP_EOL);
	fwrite($irg, "     IRDATE   IRDEPTH  IRCONC    IRTYPE".PHP_EOL);

//Datos por año

for ($k=0; $k<=2; $k++) { // Escribe riego para tres años o mas

	$fse = explode ('-', $fs[$k]);
	$fce = explode ('-', $fc[$k]);
	
	$yl = 1999 + $k + $y;
	
	$messk = array_search(strtolower($fse[1]), $meses);
	$mesck = array_search(strtolower($fce[1]), $meses);
	$dcos = $fce[0];
	$ds = $fse[0];
	
	if ($riego == 'secano' or $riego == 'Secano' or $cropn == 'No_aplica') 
	fwrite($irg, "01-jan-".strval(1999 + $k + $y)."    0.000     0.0       1".PHP_EOL);
	
	else {
	
	$case = substr($riego, 0, 1);
	
	$rdat = $dn->query("SELECT * FROM  `riego".strtolower($case)."` WHERE  `cultivo` =  '$cropn'");
	$dr = mysqli_fetch_array($rdat);
	
	$f = $dr[2];
	if ($f == 30)
	$f = 29;
	
	if ($f == 0) // No hay riego para ese cultivo
	fwrite($irg, "01-jan-".strval(1999 + $k + $y)."    0.000     0.0       1".PHP_EOL);
	
	else {
	
			if ($case == 'P')
			$tr = 0; 
			else
			$tr = 1;
			
			$dosis_ac = 0;
			
			if (in_array($cropn, $cultivos_ant)) { // Hay riegos del año anterior
			
					for ($i = $messk+2; $i<=14; $i++) {
					
						if ($dr[$i] > 0) { // Hay riego ese Mes
						$dosis = number_format($dr[$i]/$f, 3);
						$intd = intval(31/$f);
						if ($meses[$i-3] == 'feb')
						$limit = 28;
						else
						$limit = 30;
						
						if ($i == $messk + 3 and $ds>1) // dia de siembra mayor que inicio de mes
						$dosis = number_format($dosis * (2 - 3/$ds), 3);
						
						$dia = inicio($ds, $messk, $i);
							Do {
							fwrite($irg, str_pad($dia."-".$meses[$i-3]."-".($yl-1), 12).str_pad($dosis, 8, " ", STR_PAD_LEFT)."     0.0       ".$tr.PHP_EOL);
							$dia = $dia + $intd;
							$dosis_ac = $dosis_ac + $dosis;	
							} while ($dia <= $limit);
							
						} // If dosis
					} // For
				} // If cult ant
		
					for ($i = 3; $i<=$mesck+3 ; $i++) {
					
					
					if ($dr[$i] > 0) { // Hay riego ese Mes
							
						$dosis = number_format($dr[$i]/$f, 3);
						$intd = intval(31/$f);
						
						if ($case == 'P') {
						
						if ($i == $messk + 3 and $ds>1) // dia de siembra mayor que inicio de mes
							$dosis = number_format($dosis * (2 - 3/$ds), 3);
						
						if ($i == $mesck+3 and $dcos<30) // Mes de cosecha y fecha de cosecha menor de fin de mes
							$dosis = number_format($dosis * (30/$dcos), 3);
							
						}
						
						if ($meses[$i-3] == 'feb')
						$limit = 28;
						else
						$limit = 30;
						
							
						$dia = inicio($ds, $messk, $i);
							Do {
							fwrite($irg, str_pad(esc_dia($dia)."-".$meses[$i-3]."-".$yl, 12).str_pad($dosis, 8, " ", STR_PAD_LEFT)."     0.0       ".$tr.PHP_EOL);
							$dia = $dia + $intd;	
							$dosis_ac = $dosis_ac + $dosis;
							$stop = detiene_esc($dia, $limit, $i, $mesck+3, $dcos);
								} while ($stop);
							
						
						}	// If
								
					} // For
		
		mysqli_free_result($rdat);
		
		} // Fin del else de frecuencia cero

	} // Fin del else de secano

} // Fin del for por año

fclose($irg);	

?>
