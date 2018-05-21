<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SWAP-Ejecuta</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css"> 
#caja { 
width:80%; 
height:20px; 
border:1px solid black;
margin-top:10px;
margin-bottom:4px;
margin-left: auto;
margin-right: auto;
border-radius: 5px;
background-color:white;
 } 
#barrap {
background-color:red; 
height:14px;
margin-top:2px;
margin-bottom:2px;
border-radius: 3px;
}
</style> 
<body>

  
<p>
  <?php
session_start();
include ('encabez.inc.php');

	
	if ($_SESSION['j']<=$_SESSION['nump']) {  // Aun quedan parcelas para simular
	
		$j = $_SESSION['j'];
		
		$idp = $_SESSION['idps'][$j];
		$_SESSION['idp'] = $idp;
		
				
				$percent = $_SESSION['j']*100/$_SESSION['nump'];
				echo '<img class="imder" src="images/loading.GIF" alt="Procesando parcelas.." width="65" height="65" />';
				echo '<div class="boton"><h3>Progreso de la ejecuci&oacute;n: ' . number_format($percent, 1).'% de un total de '.$_SESSION['nump'].' simulaciones</h3></div>'; 
				
				
	
		?>
		<div id="caja" >
  				<div id="barrap" style="width:<?php echo number_format($percent,1) ?>%">
            	</div>
        	</div>		
		<script type="text/javascript">
		window.location = "http://localhost/Navarra/exepar_SWAP.php"
		</script>
		
		<?php
	} // Fin del if hay parcelas
	else
	{
$_SESSION['fin'] = true;
header("Location: http://localhost/Navarra/index_ex.php");
}

?>


</body>
</html>

