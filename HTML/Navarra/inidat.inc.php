<?php

$dnp = new mysqli("localhost", "root", "cubanito", "navarra_sim");
$dng = new mysqli("localhost", "root", "cubanito", "navarra_general");
$py = 'ns_p'.$year;
$sy = 'ns_s'.$year;

// Estacion meteeorologica y suelos
$dst = $dnp->query("SELECT `ids`, `estacion` FROM $sy where `idp` = '$np' ");

$dsm = mysqli_fetch_assoc($dst);
$estm = $dsm['estacion'];
$p_s = $dsm['ids'];

// Datos de suelo

$dats30 = $dng->query("SELECT `HR`, `HS`, `ALFA`, `N`, `K`, `L` FROM suelos30 where `Punto` = '$p_s' ");
$ds30 = mysqli_fetch_assoc($dats30);
$hr30 = $ds30['HR'];
$hs30 = $ds30['HS'];
$a30 = $ds30['ALFA'];
$n30 = $ds30['N'];
$k30 = $ds30['K'];
$l30 = $ds30['L'];


$dats60 = $dng->query("SELECT `HR`, `HS`, `ALFA`, `N`, `K`, `L` FROM suelos60 where `Punto` = '$p_s' ");
$ds60 = mysqli_fetch_assoc($dats60);
$hr60 = $ds60['HR'];
$hs60 = $ds60['HS'];
$a60 = $ds60['ALFA'];
$n60 = $ds60['N'];
$k60 = $ds60['K'];
$l60 = $ds60['L'];

// Datos de cultivo 
$dpt = $dnp->query("SELECT * FROM $py where `idp` = '$np' ");
$dp = mysqli_fetch_assoc($dpt);

	
	$cropn = $dp['cultivo'];
	$riego = $dp['riego'];
		

?>