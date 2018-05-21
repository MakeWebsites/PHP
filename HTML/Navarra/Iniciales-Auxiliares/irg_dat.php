<?php
function asig_irrif ($cropn, $case) {

$nomfr = substr($cropn, 0, 7).$case;
return $nomfr;
}

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

$casos = array ('P', 'G');

$cultivos_ant = array ("Alcachofa", "apio", "avena", "Cardo", "Cebada", "centeno", "Colza", 
"Habasverdes", "otroscereales", "Otrasgramineas", "trigoblando", "trigoduro", "triticale", "vezaforrajera", "vezagrano", "zanahoria");


$dn = new mysqli("localhost", "root", "", "navarra_general");

$dct = $dn->query("SELECT `idc`, `mes_s`, `dia_s`, `dia_c`, `mes_c` FROM dcultivos");
//$dct = $dn->query("SELECT `mes_s`, `mes_c` FROM dcultivos where `idc`= 'acelga'");

echo '<table>';

while ($rcrop = mysqli_fetch_assoc($dct)) { 

$cropn = $rcrop['idc'];
//$cropn = 'acelga';

$year = 2007;
$messk = array_search(strtolower($rcrop['mes_s']), $meses);
$mesck = array_search(strtolower($rcrop['mes_c']), $meses);
$dcos = $rcrop['dia_c'];
$ds = $rcrop['dia_s'];

//for ($j = 0; $j<= 1; $j++) { 

	//$case = $casos[$j];
	$case = $casos[1];
	
	$rdat = $dn->query("SELECT * FROM  `riego".strtolower($case)."` WHERE  `cultivo` =  '$cropn'");
	$dr = mysqli_fetch_array($rdat);
	
	$f = $dr[2];
	if ($f == 30)
	$f = 29;
	
	if ($f > 0) { // Hay un regadio
		
	$irrif = asig_irrif($cropn, $case).'.IRG';
	
	$ruta = 'C:\\wamp\\www\\Navarra\\Datos\\riego\\';
	
	$irg = fopen($ruta.$irrif, "w");
	
	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* Filename: Project.IRG".PHP_EOL);
	fwrite($irg, "* Contents: SWAP 2.0 - Fixed irrigations".PHP_EOL);
	fwrite($irg, "* Comments: File prepared with Pearl v1.1.f".PHP_EOL);
	fwrite($irg, "* Project = 'Navarra'  Tipo de riego: ".$case.PHP_EOL);
	fwrite($irg, "* Frecuencia de riego mensual: ".$f.PHP_EOL);
	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* --- start of table".PHP_EOL);
	fwrite($irg, "* date_irg      depth  conc      sua".PHP_EOL);
	fwrite($irg, "*              (mm !!)  mg/cm3".PHP_EOL);
	fwrite($irg, "     IRDATE   IRDEPTH  IRCONC    IRTYPE".PHP_EOL);
	
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
				fwrite($irg, esc_dia($dia)."-".$meses[$i-3]."-".($year-1).str_pad($dosis, 8, " ", STR_PAD_LEFT)."     0.0       ".$tr.PHP_EOL);
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
		
		if ($i == $messk + 3 and $ds>1 and $case='P') // dia de siembra mayor que inicio de mes
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
			fwrite($irg, esc_dia($dia)."-".$meses[$i-3]."-".$year.str_pad($dosis, 8, " ", STR_PAD_LEFT)."     0.0       ".$tr.PHP_EOL);
			$dia = $dia + $intd;	
			$dosis_ac = $dosis_ac + $dosis;
			$stop = detiene_esc($dia, $limit, $i, $mesck+3, $dcos);
				} while ($stop);
			
		
		}	// If
				
	} // For
	
fclose($irg);	

//echo 'El riego total para el '.$cropn.'  es '.$dosis_ac.'. La dosis es '.$dosis.' y la frecuencia '.$f.' el producto debia ser '.$f*$dosis.'. El intervalo es '.$intd.'<br>';
echo '<tr><td>'.$cropn.'</td><td>'.$dosis_ac.'</td></tr>';
} // Fin del If hay regadio

mysqli_free_result($rdat);

  // }  // Fin del For tipo riego   


} // Fin del while a todos los cultivos

echo '</table>';

mysqli_free_result($dct);

?>
