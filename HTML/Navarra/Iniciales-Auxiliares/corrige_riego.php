<?php 
set_time_limit(0);

$dy = new mysqli("localhost", "root", "", "navarra_sim");

// Cultivos que solo se riegan a presion
$cult_presion = array('ajo', 'albaricoquero', 'Almendro', 'avellano', 'Berenjena', 'Calabazaycalabacin', 'centeno', 'cerezo', 'ciruelo', 'girasol', 'guindilla',
	'higuera', 'lechuga', 'melocotonero', 'melon', 'membrillero', 'nispero', 'nogal', 'Olivar', 'otrosfrutales', 'Peral', 'Pimiento', 'remolacha', 'Uvademesa', 'Uvaparavino', 'zanahoria');

$py = 'punicas';

$dps = $dy->query("SELECT * FROM $py");

while ($datp = mysqli_fetch_assoc($dps)) { // Datos de parcelas

	/*for ($i = 7; $i <= 12; $i++) {
		$cv = 'cultivo'.strval($i);
		$rv = 'riego'.strval($i);
		
		$cy = $datp[$cv];
		$ry = $datp[$rv];*/
		$c7 = $datp['cultivo7'];
		$c8 = $datp['cultivo8'];
		$c9 = $datp['cultivo9'];
		$c10 = $datp['cultivo10'];
		$c11 = $datp['cultivo11'];
		$c12 = $datp['cultivo12'];
		$r7 = $datp['riego7'];
		$r8 = $datp['riego8'];
		$r9 = $datp['riego9'];
		$r10 = $datp['riego10'];
		$r11 = $datp['riego11'];
		$r12 = $datp['riego12'];
		
		
		if ($r12 == 'Gravedad' and $r11 == 'Presion') {
			//echo 'A '.(2000+$i).' Parcela '.$datp['idp'].' cultivo '.$cy.' riego anterior '.$ry;
			/*echo "UPDATE `punicas` SET '".$r7."' = 'Gravedad' where '".$cv."' = 'No_aplica'<br>";*/
			$dy->query("UPDATE `punicas` SET `riego11` = 'Gravedad'"); // Cambia el riego a presion
			 }
			
		//} // fin del for
		
	} // fin del while

mysqli_free_result($dps);
echo 'He terminado';
?>