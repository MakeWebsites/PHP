<?php

$dn = new mysqli("localhost", "root", "", "navarra");

for ($y = 2007; $y <= 2012; $y++) {
$ty = 'sim_'.$y;
$tq = "CREATE TABLE IF NOT EXISTS '$ty' (  `id` int(15) NOT NULL AUTO_INCREMENT, `idp` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,";
$tq = $tq . " `ids` int(11) NOT NULL,  `dist_ps` float NOT NULL,   `estacion` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,   PRIMARY KEY (`id`) )";

$pts = $dn->query($tq);
}

?>