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
/*session_start();*/

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

$nficp = 'SWAP_c.swp';
$swp = fopen($nficp, "w");

// current directory
	
	// Copia de ejecutable
	$ruta = dirname(__FILE__).'/Sim_SWAP';
	if (!is_dir($ruta))
	mkdir($ruta, 0777, true);
	//chdir(dirname(__FILE__).'/Datos/executable');
	//copy(dirname(__FILE__).'/Datos/executable/swap.exe', $ruta.'/SWAP.exe');
	

	//Copia de Datos 
	copydir (dirname(__FILE__).'/Datos/executable', $ruta.'/Executable');
	copydir (dirname(__FILE__).'/Datos/meteo', $ruta.'/Meteo');
	copydir (dirname(__FILE__).'/Datos/cultivos', $ruta.'/Cultivos');
	
	
		
	//header("Location: http://localhost:8080/Navarra/exe_SWAP.php");
	
	//} 


/*else  // simulacion terminada

{
	 echo  '<h1>Ejecucion terminada </h1>';
unset ($_SESSION['fin']);
unset ($_SESSION['idps']);
unset ($_SESSION['nump']);
unset ($_SESSION['crops']);
unset ($_SESSION['riegos']);
unset ($_SESSION['j']);
unset ($_SESSION['idp']);
}
*/
?>
</body>
</html>
