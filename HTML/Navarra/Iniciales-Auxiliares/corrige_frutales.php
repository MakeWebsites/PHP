<?php

$frut = array('albaricoquero',	'Almendro',	'cerezo',	'ciruelo',	'manzano',	'melocotonero',	'membrillero',	'nispero',	'nogal',	'Olivar',	'otrosfrutales',	
'Peral',	'Uvademesa',	'Uvaparavino');

$dnp = new mysqli("localhost", "root", "", "navarra_2008");

$npt = $dnp->query("SELECT * FROM p2008b");

	while ($npc = mysqli_fetch_assoc($npt)) {
	$c = $npc['cultivo'];
		if (in_array($c, $frut)) {
		$dnp->query("UPDATE  p2008b SET  `riego` =  'Presion' where `cultivo` = '$c'"); 
		}}
	echo 'He termiinado';

?>