<?php 
set_time_limit(0);

$dn = new mysqli("localhost", "root", "cubanito", "navarra_general");

$ds30 = $dn->query("SELECT `Punto`, `X`, `Y` FROM suelos30");

//$year = 2007;

//$dy = new mysqli("localhost", "root", "", "navarra_".strval($year));
$dy = new mysqli("localhost", "root", "cubanito", "navarra_sim");


/*$py = 'p'. strval($year);
$sy = 'sim'. strval($year);*/

$py = 'ns_p2014';
$sy = 'ns_s2014';

$est_nombre = array();
$est_x = array();
$est_y = array();

$est_nombre[1] = "Artajona";
$est_nombre[2] = "Bargota";
$est_nombre[3] = "Cadreita";
$est_nombre[4] = "Carrascal";
$est_nombre[5] = "Falces";
$est_nombre[6] = "Fitero";
$est_nombre[7] = "Miranda";
$est_nombre[8] = "Murillo";
$est_nombre[9] = "Sartaguda";
$est_nombre[10] = "Tafalla";
$est_nombre[11] = "Tudela";
$est_nombre[12] = "Traibuenas";

$est_x[1] = 599328;
$est_x[2] = 557811;
$est_x[3] = 605909;
$est_x[4] = 609766;
$est_x[5] = 599450;
$est_x[6] = 595987;
$est_x[7] = 597966;
$est_x[8] = 624623;
$est_x[9] = 578235;
$est_x[10] = 608781;
$est_x[11] = 614130;
$est_x[12] = 611394;

$est_y[1] = 4715487;
$est_y[2] = 4703462;
$est_y[3] = 4673851;
$est_y[4] = 4726608;
$est_y[5] = 4697636;
$est_y[6] = 4655954;
$est_y[7] = 4707438;
$est_y[8] = 4693814;
$est_y[9] = 4690609;
$est_y[10] = 4708670;
$est_y[11] = 4691051;
$est_y[12] = 4665526;

//require_once('progress2.php');

$dps = $dy->query("SELECT `idp`, `x`, `y` FROM $py");
/* determinar el número de parcelas */
$nump = $dps->num_rows;
/* determinar el número de puntos de suelo */
$numps = $ds30->num_rows;


$xt = array();
$yt = array();
$dpt = array();
$at = array();
$bt = array();
$idps = array();

while ($dsf30 = mysqli_fetch_assoc($ds30)) { // Descarga los puntos en arrays
	$xt[] = $dsf30['X'];
	$yt[] = $dsf30['Y'];
	$dpt[] = $dsf30['Punto']; }

$cont = 0;

while ($dparc = mysqli_fetch_assoc($dps)) { // Descarga las parcelas en arrays
	$a = $dparc ['x'];
	$b = $dparc['y'];
	$id_p = $dparc['idp']; 

$ps = 0;
$md = 60000;

		for ($i = 0; $i < $numps; $i++) {
		
		$x = $xt[$i];
		$y = $yt[$i];
		$dp = $dpt[$i];
		
			$d = sqrt( pow(($a-$x),2) + pow(($b-$y), 2));
			
				if ($d < $md) {
				$md = $d;
				$ps = $dp;
				}
			}
// Fin del Loop en suelos

// Asignacion de estacion


$de = 50000;

for ($i = 1; $i <= 12; $i++) {
	$x = $est_x[$i];
	$y = $est_y[$i];
	$estv = $est_nombre[$i];
	
	$d = sqrt( pow(($a-$x),2) + pow(($b-$y), 2));
	
	if ($d < $de) {
		$de = $d;
		$est = $estv;
		}
}
// Cierre del loop de la estacion
	
$dy->query("INSERT INTO $sy (idp, ids, dist_ps, estacion) VALUES('$id_p', '$ps', '$md', '$est')");

$cont++;

} // Fin del Loop para las parcelas

echo '<h1>He terminado. Procese '.$nump.' parcelas y hay '.$numps.' puntos de suelo y he escrito '.$cont.' datos</h1>';

mysqli_free_result($dps);


mysqli_free_result($ds30);

?>