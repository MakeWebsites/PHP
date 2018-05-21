<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LIFE Navarra - SWAP</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

      
<?php
include ('encabez.inc.php');
session_start();

function copydir($source,$destination) {
	
	if(!is_dir($destination))
	mkdir($destination, 01777); 
	
	$dir_handle = @opendir($source);
	while ($file = readdir($dir_handle)) 
	{
	if($file!="." && $file!=".." && !is_dir("$source/$file"))
	copy("$source/$file","$destination/$file");
	}
	closedir($dir_handle);
	}

if (!isset($_SESSION['fin'])) { // Comienza simulacion
	
	
	$y = 12;
	$year = strval(2000 + $y);
	$py = 'ns_p'.$year;
	//$py = 'dif208';
	$sy = 'ns_s'.$year;
	
	// Copia de ejecutable
	$ruta = '/Sim_SWAP'.$y;
	if (!is_dir($ruta))
	mkdir($ruta, 0777, true);
	chdir(__DIR__.'/Datos/executable');
	copy('SWAP.exe', $ruta.'/SWAP.exe');
	

	$dni = new mysqli("localhost", "root", "cubanito", "navarra_sim");
	$dnr = new mysqli("localhost", "root", "cubanito", "navarra_temp");
	
	//$dct = $dni->query("SELECT * FROM  `dcultivos`");
	$dp = $dni->query("SELECT `idp` FROM  $py ");
		$_SESSION['nump'] = $dp->num_rows;
	
	$j = 0;
	$idps = array();
	

		while ($pdat = mysqli_fetch_assoc($dp))  { // Aray de datos para las parcelas
		$j++;
		$idps[$j] = $pdat['idp']; 
		}
		
	$_SESSION['idps'] = $idps;
	
	$_SESSION['j'] = 1;
	

	//Copia de Datos 
	copydir (__DIR__.'/Datos/meteo', '/Sim_SWAP'.$y.'/Meteo');
	copydir (__DIR__.'/Datos/cultivos', '/Sim_SWAP'.$y.'/Cultivos');
	
	//Crea tablas de salida
	
	$variab = array ('escorrentia', 'perc', 'etp', 'etr', 'lluvia', 'riego', 'ndis', 'nlix');
	$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

	for ($k= 0; $k<8; $k++) { // ejecuta para todas las variables
	
	$queryi = "DROP TABLE IF EXISTS `". $variab[$k].$y."`";
	$dnr->query($queryi);

		$queryc = "CREATE TABLE  `".$variab[$k].$y."` ( `idp` VARCHAR( 30 ) COLLATE utf8_spanish_ci NOT NULL , ";
	
			//for ($y = 7; $y<= 12; $y++) { // Todos los años
				for ($j = 0; $j < 12; $j++) {
				$queryc .= "`".$meses[$j]."` DOUBLE(7,2) DEFAULT NULL ,"; //}
			}
		
		$queryc .= " PRIMARY KEY (  `idp` ) ) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci ";
	
		$dnr->query($queryc); 
	}
// Fin de creacion de tablas
	$_SESSION['y'] = $y;
	header("Location: http://localhost/Navarra/exe_SWAP.php");
	
	} 


else  // simulacion terminada

{
	 echo  '<h1>Ejecucion terminada </h1>';
unset ($_SESSION['fin']);
unset ($_SESSION['idps']);
unset ($_SESSION['nump']);
unset ($_SESSION['crops']);
unset ($_SESSION['riegos']);
unset ($_SESSION['j']);
unset ($_SESSION['idp']);
unset ($_SESSION['y']);
}

?>
</body>
</html>
