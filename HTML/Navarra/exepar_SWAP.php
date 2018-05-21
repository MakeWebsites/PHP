<?php 
session_start();

//$months = array (0=>'Jan', 1=>'Feb', 2=>'Mar', 3=>'Apr', 4=>'May', 5=>'Jun', 6=>'Jul', 7=>'Aug', 8=>'Sep', 9=>'Oct', 10=>'Nov', 11=>'Dec');
$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

$cultivos_ant = array ("Alcachofa", "apio", "avena", "Cardo", "Cebada", "centeno", "Colza", 
"Habasverdes", "otroscereales", "Otrasgramineas", "trigoblando", "trigoduro", "triticale", "vezaforrajera", "vezagrano", "zanahoria");

$dng = new mysqli("localhost", "root", "cubanito", "navarra_general");

$np = $_SESSION['idp'];
$y = $_SESSION['y'];
$year = strval(2000 + $y);


require_once('funct.inc.php');

include('inidat.inc.php');



//Crea el fichero SWP 
$ruta = '/Sim_SWAP'.$y.'/'.$np;
if (!is_dir($ruta))
mkdir($ruta, 0777, true);
$rutaf = 'C:\\Sim_SWAP'.$y.'\\'.$np.'\\';

$lat = asig_lat($estm);
$alt = asig_alt($estm);
$proph1 = propiedh(1, $hr30, $hs30, $a30, $n30, $k30, $l30);
$proph2 = propiedh(2, $hr60, $hs60, $a60, $n60, $k60, $l60);

$pond = "0.2";

	$fert = array();
	$bal = array();
	$fs = array();
	$fc = array();
		
	if (in_array($cropn, $cultivos_ant))
	$yeari = $y - 1;
	else
	$yeari = $y;
	
	$dct = $dng->query("SELECT * FROM dcultivos where `idc` = '$cropn' ");
	$ic = mysqli_fetch_assoc($dct);
	$ds = $ic['dia_s'];
	$ms = $ic['mes_s'];
	$dc = $ic['dia_c'];
	$mc = $ic['mes_c'];
	
	/*// Datos de N para ese cultivo
		$nfdat = $dng->query("SELECT * FROM nfert where `idc`= '$cropn'");
		while ($nf = mysqli_fetch_assoc($nfdat)) { // Descarga la tabla de fertilizaciones en arreglo
				for ($j = 0; $j < 12; $j++)
				$fert[$meses[$j]] = $nf[$meses[$j]]; 
				
				}
		
			
		$nbdat = $dng->query("SELECT * FROM nbal where `idc`= '$cropn'");
		while ($nb = mysqli_fetch_assoc($nbdat)) { // Descarga la tabla de fertilizaciones en arreglo
			
				for ($j = 0; $j < 12; $j++)
				$bal[$meses[$j]] = $nb[$meses[$j]]; }*/
				
			
	if ($cropn == "Arroz") {
	$pond = "20.0";
	$proph1 = propiedh(1, $hr30, $hs30, $a30, $n30, $k30/15, $l30);
	}

	$years = 2000 + $y;

	$cropnr = substr($cropn, 0, 8);
	
	for ($k = 0; $k <= 2; $k++) { // Asigna la misma fecha de siembra y cosecha pero en tres años
		$fs[] = asig_fs($ds, $ms) . strval(1999 + $k + $yeari);
		$fc[] = asig_fc($dc, $mc) . strval(1999 + $k + $y);
	}
	
	mysqli_free_result($dct);

//} // Fin de las variables por año

$irg = fopen($rutaf.'riegop.irg', "w");

require('irgdat.inc.php');

$nficp = 'SWAP_c.swp';
$swp = fopen($rutaf.$nficp, "w");

require('esc_SWP.php');

fclose($swp);

// Limpia los sql

mysqli_free_result($dpt);
mysqli_free_result($dst);
mysqli_free_result($dats30);
mysqli_free_result($dats60);
	

// Se crea el fichero BAT
$fbat = fopen($rutaf.'SWAP.BAT', "w");
fwrite($fbat, "..\swap.exe SWAP_c.SWP");
fclose($fbat);


// Ejecuta el SWAP
chdir($ruta.'/');
exec('SWAP.BAT');

 // Fin de la ejecucion
 
 require ('lee_results.inc.php');
 require ('calc_nit.inc.php');

if ($_SESSION['j']<=$_SESSION['nump']) {  // Aun debe calcular más
 $_SESSION['j']++; }


header("Location: http://localhost/Navarra/exe_SWAP.php");

?>
