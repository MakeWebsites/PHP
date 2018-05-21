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


$cultivos_ant = array ("Alcachofa", "apio", "avena", "Cardo", "Cebada", "centeno", "Colza", 
"Habasverdes", "otroscereales", "Otrasgramineas", "trigoblando", "trigoduro", "triticale", "vezaforrajera", "vezagrano", "zanahoria");




$meses = array (0=>'jan', 1=>'feb', 2=>'mar', 3=>'apr', 4=>'may', 5=>'jun', 6=>'jul', 7=>'aug', 8=>'sep', 9=>'oct', 10=>'nov', 11=>'dec');

$casos = array ('P', 'G');



$dn = new mysqli("localhost", "root", "", "navarra_general");

//$dct = $dn->query("SELECT `idc`, `mes_s`, `mes_c` FROM dcultivos");
$dct = $dn->query("SELECT `mes_s`, `mes_c` FROM dcultivos where `idc`= 'membrillero'");


while ($rcrop = mysqli_fetch_assoc($dct)) { 

//$cropn = $rcrop['idc'];
$cropn = 'membrillero';

for ($year = 2007; $year< 2013; $year++) {

$messk = array_search(strtolower($rcrop['mes_s']), $meses);
$mesck = array_search(strtolower($rcrop['mes_c']), $meses);

for ($j = 0; $j<= 1; $j++) { 

	$case = $casos[$j];
	
	$rdat = $dn->query("SELECT * FROM  `riego".strtolower($case)."` WHERE  `cultivo` =  '$cropn'");
	$dr = mysqli_fetch_array($rdat);
	
	$f = $dr[2];
	if ($f > 0) { // Hay un regadio
		
	$irrif = asig_irrif($cropn, $case).'.IRG';
	
	$ruta = 'C:\\wamp\\www\\Navarra\\Datos\\riego\\'.strval($year).'\\';
	
	$irg = fopen($ruta.$irrif, "w");
	
	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* Filename: Project.IRG".PHP_EOL);
	fwrite($irg, "* Contents: SWAP 2.0 - Fixed irrigations".PHP_EOL);
	fwrite($irg, "* Comments: File prepared with Pearl v1.1.f".PHP_EOL);
	fwrite($irg, "* Project = 'Navarra'".PHP_EOL);
	fwrite($irg, "*".PHP_EOL);
	fwrite($irg, "*--------------------------------------------------------------------------------".PHP_EOL);
	fwrite($irg, "* --- start of table".PHP_EOL);
	fwrite($irg, "* date_irg      depth  conc      sua".PHP_EOL);
	fwrite($irg, "*              (mm !!)  mg/cm3".PHP_EOL);
	fwrite($irg, "     IRDATE   IRDEPTH  IRCONC    IRTYPE".PHP_EOL);
	
	if ($case == 'P')
	$tr = 0; 
	else
	$tr = 1;
	
	if (in_array($cropn, $cultivos_ant)) { // Hay riegos del año anterior
	
		for ($i = $messk+2; $i<=14; $i++) {
		
			if ($dr[$i] > 0) { // Hay riego ese Mes
			$dosis = number_format($dr[$i]/$f, 1);
			$intd = intval(30/$f);
			if ($meses[$i-3] == 'feb')
			$limit = 28;
			else
			$limit = 30;
			
			$dia = 2;
				Do {
				fwrite($irg, esc_dia($dia)."-".$meses[$i-3]."-".($year-1)."    ".str_pad($dosis, 8, " ", STR_PAD_LEFT)." 0.0       ".$tr.PHP_EOL);
				$dia = $dia + $intd;	
				} while ($dia <= $limit);
			} // If dosis
		} // For
	} // If cult ant
	

	for ($i = 3; $i<=$mesck+2 ; $i++) {
	
	
	if ($dr[$i] > 0) { // Hay riego ese Mes
			
		$dosis = number_format($dr[$i]/$f, 1);
		$intd = intval(30/$f);
		if ($meses[$i-3] == 'feb')
		$limit = 28;
		else
		$limit = 30;
			
		$dia = 2;
			Do {
			fwrite($irg, esc_dia($dia)."-".$meses[$i-3]."-".$year."    ".str_pad($dosis, 8, " ", STR_PAD_LEFT)." 0.0       ".$tr.PHP_EOL);
			$dia = $dia + $intd;	
			} while ($dia <= $limit);
		
		}	// If
				
	} // For
	
fclose($irg);	

} // Fin del If hay regadio

mysqli_free_result($rdat);

   }  // Fin del For tipo riego   
   
 }  //Fin del For por año   

} // Fin del while a todos los cultivos



mysqli_free_result($dct);

?>
