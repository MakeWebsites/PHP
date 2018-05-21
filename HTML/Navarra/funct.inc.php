<?php

function asig_lat($estm) { // Asigna la $latitud de la estacion

switch ($estm) {
case "Artajona":
$lat = 42.5;
break;
case "Bargota":
$lat = 42.3;
break;
case "Cadreita":
$lat = 42.1;
break;
case "Carrascal":
$lat = 42.4;
break;
case "Falces":
$lat = 42.2;
break;
case "Fitero":
$lat = 42.0;
break;
case "Miranda":
$lat = 42.3;
break;
case "Murillo":
$lat = 42.2;
break;
case "Sartaguda":
$lat = 42.2;
break;
case "Tafalla":
$lat = 42.3;
break;
case "Traibuenas":
$lat = 42.2;
break;
case "Tudela":
$lat = 42.1;
break;
} // fin del switch

return strval(number_format($lat, 1)); } // Fin de asig_lat

function asig_alt($estm) { // Asigna la altitud de la estacion

switch ($estm) {
case "Artajona":
$alt = 353; break;
case "Bargota":
$alt = 375; break;
case "Cadreita":
$alt = 267; break;
case "Carrascal":
$alt = 568; break;
case "Falces":
$alt = 290; break;
case "Fitero":
$alt = 450; break;
case "Miranda":
$alt = 343; break;
case "Murillo":
$alt = 393; break;
case "Sartaguda":
$alt = 307; break;
case "Tafalla":
$alt = 419; break;
case "Traibuenas":
$alt = 312; break;
case "Tudela":
$alt = 314; break;
} // fin del switch

return strval($alt).'.0'; } // Fin de asig_alt

/*function asig_irrif ($cropn, $tipo_r) {

if ($cropn == 'No_aplica')
	$nomfr = 'secano';

return ($nomfr); }*/

function asig_fs ($ds, $ms) {

if ($ds < 10)
$d_s = "0".strval($ds);
else
$d_s = strval($ds);

$fs = $d_s.'-'.$ms.'-';
return ($fs);
}

function asig_fc ($dc, $mc) {

if ($dc < 10)
$d_c = "0".strval($dc);
else
$d_c = strval($dc);

$fc = $d_c.'-'.$mc.'-';
return ($fc);
}


function propiedh($capa, $hr, $hs, $a, $n, $k, $l)  {


$linea = "       ".$capa."     ";
$linea .= str_pad(number_format($hr, 3), 8);
$linea .= str_pad(number_format($hs, 3), 8);
$linea .= str_pad(number_format($a, 4), 9);
$linea .= str_pad(number_format($n, 3), 9);
$linea .= str_pad(number_format($k, 2), 10);
$linea .= str_pad(number_format($l, 3), 8);
$linea .= str_pad(number_format($a, 4), 6);
$linea .= "   0.0   ";
$linea .= str_pad(number_format($k, 2), 10);

return ($linea); }

