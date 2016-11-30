<?php
function ademas ($casod) {

switch ($casod) {

	case 'All data':
        $adem = "";
		break;
	case 'Nitrates Vulnerable Zones':
	// Se ha seleccionado por zona vulnerable
		$zns = $_SESSION['zns'];
		switch ($zns) {
    		case 'Ebro Tudela Alagon':
				$adem = " and `ZNV` = 'Ebro Tudela_Alag'";
				break;
			case 'Rioja Mendavia':
				$adem = " and `ZNV` = 'Rioja_Mendavia'";
				break;
			case 'Cidacos':
				$adem = " and `ZNV` = 'Cidacos'";
				break;
			case 'Non-vulnerable zones':
				$adem = " and `ZNV` = 'NO'";
				break; 	}
		break;
	case 'Modelling Sectors':
	// Se ha seleccionado por zona vulnerable
		$sector = $_SESSION['sector'];
		switch ($sector) {
    		case 1:
				$adem = " and `Sector` = 1";
				break;
			case 2:
				$adem = " and `Sector` = 2";
				break;	
			case 3:
				$adem = " and `Sector` = 3";
				break;
			case 4:
				$adem = " and `Sector` = 4";
				break;	
			case 5:
				$adem = " and `Sector` = 5";
				break;
			case 6:
				$adem = " and `Sector` = 6";
				break;			
				}
		break;
} // Fin del switch casod	

return $adem; } // Fin de function adem

function mensz ($casod) {

switch ($casod) {

	case 'All data':
		$mensz = ' all the zone';
        break;
	case 'Nitrates Vulnerable Zones':
	// Se ha seleccionado por zona vulnerable
		$zns = $_SESSION['zns'];
		switch ($zns) {
    		case 'Ebro Tudela Alagon':
				$mensz = ' Nitrates Vulnerable Zone Ebro Tudela Alagon';
				break;
			case 'Rioja Mendavia';
				$mensz = ' Nitrates Vulnerable Zone Rioja Mendavia';
				break;
			case 'Cidacos':
				$mensz = ' Nitrates Vulnerable Zone Cidacos';
				break;
			case 'Non-vulnerable zones':
				$mensz = ' all plots located in Non-vulnerable zones';
				break; 	}
		break;
	case 'Modelling Sectors':
	// Se ha seleccionado por zona vulnerable
		$sector = $_SESSION['sector'];
		switch ($sector) {
    		case 1:
				$mensz = ' sector Viana-Mendavia';
				break;
			case 2:
				$mensz = ' sector Lodosa-Azagra';
				break;	
			case 3:
				$mensz = ' sector Azagra-Tudela';
				break;
			case 4:
				$mensz = ' sector Aluvial Arag&oacute;n';
				break;	
			case 5:
				$mensz = ' sector Tudela-Cortes';
				break;
			case 6:
				$mensz = ' sector Cidacos';
				break;			
				}
		break;
} // Fin del switch casod	

return $mensz; } // Fin de function adem

function datcult ($nomt, $cropn) {
global $wpdb;
$dcults = array();
$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");
$dcs = $wpdb->get_row ('SELECT * FROM `'.$wpdb->prefix . $nomt.'` where `idc`= "'.$cropn.'"', ARRAY_A);

	foreach ($meses as $mes)
	$dcults[$mes] = $dcs[$mes];
	
	if (isset($dcs['frecuencia']))
	$dcults['f'] = $dcs['frecuencia'];
	
return $dcults; } // Fin de la funcion datcult

function dfert($valor, $cropn, $cultivo) { // Seleccionar fertilizacion

$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");

$fertm = datcult('nfert',$cropn); 

$ferts = $valor;
?>
<br />Datos de fertilizaci&oacute;n (kg/ha) mensuales, considerados actualmente para <?php echo $cultivo ?>:
<table>
<tr>
<?php 	foreach ($meses as $mes) echo '<th>'.$mes.'</th>'; ?>
<th>Total</th>
</tr>
<tr>
<?php 	foreach ($meses as $mes) echo '<td>'.number_format($fertm[$mes],0).'</td>'; 
echo '<td>'.number_format(array_sum($fertm),0, ',', ' ').'</td>';
?>
</tr>
</table>
<form name="dfert" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
Seleccione la fertilizaci&oacute;n (kg/ha) mensual para <?php echo $cultivo ?>:<?php  if (isset($valor))  echo $preg1ra;  ?>
<table>
<tr>
<?php 	foreach ($meses as $mes) echo '<th>'.$mes.'</th>'; if (isset($valor))  echo '<th>Total</th>' ?>
</tr>
<tr>
  <?php foreach ($meses as $mes) { ?>
   <td><label><input type="text" name="<?php echo 'dfert['.$mes.']' ?>" id="<?php echo 'dfert['.$mes.']' ?>" size="2" 
   value=<?php if (!isset ($valor)) echo number_format($fertm[$mes],0); else echo number_format($ferts[$mes],0); ?> /></label></td>
  <?php  } if (isset($valor))  echo '<td>'.number_format(array_sum($ferts),0).'</td>'; ?>
</tr>
</table> 
  <?php if (!isset($valor)) { ?>
      <label>
      <input type="submit" name="enviar" id="enviar" value="Enviar">
      </label>
    <?php } ?>
</form>
    <?php } // termina la funcion dfert
	
/*function driegog($valor, $cropn, $cultivo) { // Seleccionar riego

$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

	$riegom = datcult('riegog',$cropn);


$riegos = $valor;
?>
Riego (Gravedad) en mm mensuales y frecuencia (F) en n&uacute;mero de riegos cada mes, considerados actualmente para <?php echo $cultivo ?>:
    <table>
    <tr style="width:90px">
    <?php 	foreach ($meses as $mes) echo '<th>'.$mes.'</th>'; ?>
    <th>Total</th>
    <th>F</th></tr><tr style="width:90px">
    <?php 	foreach ($meses as $mes) echo '<td>'.number_format($riegom[$mes],0).'</td>'; 
    echo '<td>'.number_format(array_sum($riegom)-$riegom['f'],0, ',', ' ').'</td>';
	 echo '<td>'.number_format($riegom['f'],0).'</td>';
    ?>
    </tr>
    </table>
    
<form name="riegog" method="post" action= "<?php echo $_SESSION['pos'] ?>#pregc">
Seleccione la dosis de riego (mm) y la frecuencia (F) mensual para <?php echo $cultivo ?> (riego Gravedad):<?php  if (isset($valor))  echo $preg1ra;  ?>

<table>
<tr>
<?php 	foreach ($meses as $mes) echo '<th style="width:7px">'.$mes.'</th>'; ?>
<th style="width:7px">F</th>
<?php if (isset($valor))  echo '<th style="width:7px">Total</th></tr><tr>'; else echo '</tr><tr>';
  foreach ($meses as $mes) { ?>
   <td style="width:7px"><label><input type="text" name="<?php echo 'riegog['.$mes.']' ?>" id="<?php echo 'riegog['.$mes.']' ?>" size="1" 
   value=<?php if (!isset ($valor)) echo number_format($riegom[$mes],0); else echo number_format($riegos[$mes],0); ?> /></label></td>
   <?php } ?>
   <td style="width:7px"><label><input type="text" name="riegog[f]" id="riegog[f]" size = "1" 
   value=<?php if (!isset ($valor)) echo number_format($riegom['f'],0); else echo number_format($riegos['f'],0); ?> /></label></td>
  <?php  if (isset($valor))  echo '<td style="width:7px">'.number_format(array_sum($riegos)-$riegos['f'],0, ',', ' ').'</td>'; ?>
</tr>
</table> 
  <?php if (!isset($valor)) { ?>
      <label>
      <input type="submit" name="enviar" id="enviar" value="Enviar">
      </label>
    <?php } ?>
</form>
    <?php } // termina la funcion riego*/
	
function driego($valor, $cropn, $cultivo, $caso) { // Seleccionar riego

$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");

	$riegom = datcult('riego'.$caso,$cropn);
	
$riegos = $valor;
if ($caso == 'p')
$mr = 'Presi&oacute;n';
else
$mr = 'Gravedad';

?>
Riego (<?php echo $mr ?>) en mm mensuales y frecuencia (F) en n&uacute;mero de riegos cada mes, considerados actualmente para <?php echo $cultivo ?>:
    <table>
    <tr style="width:90px">
    <?php 	foreach ($meses as $mes) echo '<th>'.$mes.'</th>'; ?>
    <th>Total</th>
    <th>F</th></tr><tr style="width:90px">
    <?php 	foreach ($meses as $mes) echo '<td>'.number_format($riegom[$mes],0).'</td>'; 
   echo '<td>'.number_format(array_sum($riegom)-$riegom['f'],0, ',', ' ').'</td>';
	 echo '<td>'.number_format($riegom['f'],0).'</td>';
    ?>
    </tr>
    </table>
    
<form name="sriego" method="post" action= "<?php echo $_SESSION['pos'] ?>#pregc">
Seleccione la dosis de riego (mm) y la frecuencia (F) mensual para <?php echo $cultivo.' ('.$mr.'):';  if (isset($valor))  echo $preg1ra;  ?>

<table>
<tr>
<?php 	foreach ($meses as $mes) echo '<th style="width:7px">'.$mes.'</th>'; ?>
<th style="width:7px">F</th>
<?php if (isset($valor))  echo '<th style="width:7px">Total</th></tr><tr>'; else echo '</tr><tr>';
  foreach ($meses as $mes) { ?>
   <td style="width:7px"><label><input type="text" name="<?php echo 'sriego['.$mes.']' ?>" id="<?php echo 'sriego['.$mes.']' ?>" size="1" 
   value=<?php if (!isset ($valor)) echo number_format($riegom[$mes],0); else echo number_format($riegos[$mes],0); ?> /></label></td>
   <?php } ?>
   <td style="width:7px"><label><input type="text" name="sriego[f]" id="sriego[f]" size = "1" 
   value=<?php if (!isset ($valor)) echo number_format($riegom['f'],0); else echo number_format($riegos['f'],0); ?> /></label></td>
  <?php  if (isset($valor))  echo '<td style="width:7px">'.number_format(array_sum($riegos)-$riegos['f'],0, ',', ' ').'</td>'; ?>
</tr>
</table> 
  <?php if (!isset($valor)) { ?>
      <label>
      <input type="submit" name="enviar" id="enviar" value="Enviar">
      </label>
    <?php } ?>
</form>
    <?php } // termina la funcion driego

	
	


