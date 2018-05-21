<?php

$dni = new mysqli("localhost", "root", "cubanito", "navarra_sim");
/*$dpt = $dni->query("SELECT `idp` FROM  `put2`");
*/


$cult_u = array ('No_aplica',	'manzano',	'otrashortalizas',	'Cebada',	'Alcachofa',	'melocotonero',	'trigoblando',	
'otrosfrutales',	'Alfalfa',	'Olivar',	'Uvaparavino',	'Almendro',	'Peral',	'Maizgrano',	'cerezo',	'Esparrago',	
'albaricoquero',	'ciruelo',	'Arroz',	'lechuga',	'nogal');

$cult_r = array('acelga',	'ajo',	'avena',	'Berenjena',	'berza',	'Broculi',	'Calabazaycalabacin',	'Cardo',	'cebolla',	
'cebolleta',	'centeno',	'Coliflor',	'Colyrepollo',	'escarola',	'espinaca',	'girasol',	'guindilla',	'Guisanteseco',	'Guisantesverdes',	
'Habassecas',	'Habasverdes',	'higuera',	'Judiasverdes',	'melon',	'membrillero',	'Otrasgramineas',	'otros',	'otroscereales',	
'otrostuberculos',	'Patata',	'Pimiento',	'remolacha',	'sorgo',	'Tomate',	'trigoduro',	'triticale',	'Uvademesa',	'vezaforrajera',	'vezagrano');


// $dp = mysqli_fetch_assoc($dpt);
	// for ($y=7; $y<=13; $y++) { 	
			// $cultivos[$y] = $dp['cultivo'.strval($y)];
			// $riegos[$y] = $dp['riego'.strval($y)];
	/*	// }
	for  ($i = 7; $i <= 11; $i++) {
		for ($j = 0; $j < 21; $j++) {
		$querya = 'UPDATE `put2a` SET `cultivo'.$i.'`= `cultivo12` where `cultivo12` = "'.$cult_u[$j].'" and `cultivo'.$i.'` is null';
		//echo $querya.'<br>';
		$dni->query($querya);
		}}*/
		/*$querya = 'UPDATE `put2a` SET `rotacion` = CONCAT(';
	for  ($i = 7; $i <= 13; $i++)
		$querya .= '`cultivo'.$i.'`, "-", ';
		//$querya = 'UPDATE `put2a` SET `= "Broculi" where `cultivo'.$i.'` = "Br';
		$querya = substr($querya, 0, -7).')';
		echo $querya.'<br>';*/
		//$dni->query($querya);
	
	/*for  ($i = 7; $i <= 11; $i++) {
		for ($j = 0; $j < 21; $j++) {
		$querya = 'UPDATE `put2a` SET `cultivo'.$i.'`= `cultivo12` where `cultivo12` = "'.$cult_u[$j].'" and `cultivo'.$i.'` is null';
		//echo $querya.'<br>';
		$dni->query($querya);
		}}*/	
	
	// Calcula la frecuencia de las rotaciones para todos los cultivos no unicos
	
/*$idp = array();
$rot = array();
for  ($i = 0; $i < 39; $i++) {

  $querya = 'SELECT * FROM `put2b` WHERE `cultivo12` = "'.$cult_r[$i].'" and `cultivo9` is null';
  $cultc = $dni->query($querya);
  $numc = $cultc ->num_rows;
   while ($dc = mysqli_fetch_assoc($cultc)) { 
		$idp[] = $dc['idp']; }
  
	$queryb = 'SELECT `rotacion`, count(`rotacion`) as num_r FROM `pumasrot` where `cultivo12` = "'.$cult_r[$i].'" group by `rotacion` ORDER BY count(`rotacion`) desc';
	$rotd = $dni->query($queryb);
	$numtr = $rotd ->num_rows;
		while ($dr = mysqli_fetch_assoc($rotd)) { 
		$rot[] = $dr['rotacion'];
		 }
		
		$cr = round(0 + rand(0,$numtr));
		for($k=0; $k<$numc; $k++) {
			$r = $rot[$cr];
			$cult = explode( '-', $r);
			$queryc = 'UPDATE `put2b` SET ';
				for ($n = 7; $n<=11; $n++)
				$queryc .= '`cultivo'.$n.'` = "'.$cult[$n-7].'", ';
				$queryc = substr($queryc, 0, -2);
				$queryc .= ' where `cultivo12` = "'.$cult_r[$i].'" and `idp` = "'.$idp[$k].'"';
			$dni->query($queryc);
			//echo $queryc.'<br>';
		 }
unset ($idp);
unset ($rot);
unset ($nr);		 
	 }*/
			
		
$cultivos_rest = array(	'higuera'.	'vezagrano'.	'Guisantesverdes'.	'Uvademesa'.	'sorgo'.	'guindilla'.	'remolacha'.	'cebolleta'.	'berza'.	'otros'.	'otroscereales'.	'Berenjena'.	'Judiasverdes'.	'Colyrepollo'.	'Patata');

$nc = count($cultivos_rest);

for($k=0; $k<$nc; $k++) {

$query1 = 'SELECT ';

	for($i = 7; $i<12; $i++) 
	$query1 .= '`cultivo'.$i.'` , ';
	
	$query1 = substr($query1, 0, -3);
	
	$query1 .= ' from `pumasrot` where `cultivo12` = "'.$cultivos_rest[$k].'"';
	
	echo $query1.'<br>';
	
	}
		
?>