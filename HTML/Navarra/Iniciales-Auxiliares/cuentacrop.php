<?php
/*
$cult = array("acelga",	"ajo",	"albaricoquero",	"Alcachofa",	"alfalfa",	"Almendro",	"altramuz",	"apio",	"Arroz",	"avellano",	"avena",	"Berenjena",	"berza",	"Broculi",	"Calabazaycalabacin",	"Cardo",	"Cebada",	"cebolla",	"cebolleta",	"centeno",	"cerezo",	"ciruelo",	"Coliflor",	"Colyrepollo",	"Colza",	"escarola",	"Esparrago",	"espinaca",	"garbanzos",	"girasol",	"Guisanteseco",	"Guisantesverdes",	"Habassecas",	"Habasverdes",	"judiassecas",	"Judiasverdes",	"lechuga",	"lentejas",	"Maizgrano",	"manzano",	"melocotonero",	"melon",	"membrillero",	"nispero",	"No_aplica",	"nogal",	"Olivar",	"Otrasgramineas",	"otrashortalizas",	"otrasleguminosas",	"otros",	"otroscereales",	"otrosfrutales",	"otrostubeculos",	"PLechuga",	"Ptomate",	"Patata",	"Peral",	"Pimiento",	"Pguindilla",	"Potrashortalizas",	"puerro",	"remolacha",	"soja",	"sorgo",	"Tomate",	"trigoblando",	"trigoduro",	"triticale",	"Uvademesa",	"Uvaparavino",	"vezaforrajera",	"vezagrano",	"zanahoria");*/


$dn = new mysqli("localhost", "root", "", "navarra");

$dct = $dn->query("SELECT `idc` FROM dcultivos");

$year = 2012;

$pyear = "p".strval($year);
$ncy = "nc".strval($year);

while ($rcrop = mysqli_fetch_assoc($dct)) { 

$cropn = $rcrop['idc'];

$result = $dn->query("SELECT * FROM $pyear WHERE  `cultivo` = '$cropn'");
$nc = mysqli_num_rows($result);
$dn->query("UPDATE dcultivos  SET $ncy = '$nc' WHERE `idc`= '$cropn'");

}
echo 'He copiado ya el '.$year.'<br>';


?>
