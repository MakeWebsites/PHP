<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SWAP-Ejecuta</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<style type="text/css"> 
#caja { 
width:80%; 
height:30px; 
border:2px solid black;
margin-top:2px;
margin-bottom:4px;
margin-left:10%;
border-radius: 25px;
background-color:white;
 } 
#barrap {
background-color:red; 
height:24px;
margin-top:3px;
margin-bottom:3px;
border-radius: 10px;
}
</style> 
</head>
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
				//echo '<img class="imder" src="images/loading.GIF" alt="Procesando parcelas.." width="65" height="65" />';			
				
	
		?>
        <div class="boton"><h3>Progreso de la ejecuci&oacute;n: <?php echo number_format($percent,1) ?>% de un total de <?php echo $_SESSION['nump'] ?> simulaciones</h3> 
			<div id="caja" >
  				<div id="barrap" style="width:<?php echo number_format($percent,0) ?>%">
            	</div>
        	</div>	
       	</div>
		<script type="text/javascript">
		window.location = "http://localhost/Navarra/calc_nitlix.php"
		</script>
		
		<?php
	} // Fin del if hay parcelas
	else
	{
$_SESSION['fin'] = true;
header("Location: http://localhost/Navarra/index_ex_nit.php");
}

?>


</body>
</html>

