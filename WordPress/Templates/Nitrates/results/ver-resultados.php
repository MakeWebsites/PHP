<?php
session_start();
global $wpdb;

/*if ($_SESSION['varb'] == 'Infiltracion') {
$vs = 'perc';
$pos = 'p'; }
else {
$vs = 'nlix';
$pos = 'n'; }*/

$_SESSION['res'] = get_permalink();
$casod = $_SESSION['casod'];
$casov = $_SESSION['varb'];

include_once ('pre-process.inc.php');


switch ($casov) {

case 18: 
	$tits = "Total infiltration (m3)";
	$titp = "Average Infiltration (m3/ha)";
	$tit = 'Deep infiltration (means in m<sup>3</sup>/ha and totals in m<sup>3</sup>)';
	$vs2 = 'pt12';
	break;
case 20: 
	//$vs2 = 'nlt12'; 
	$vs2 = 'nlixt'; 
	$tits = "Leached Nitrogen (kg)";
	$titp = "Average Leached Nitrogen (kg/ha)";
	$tit = 'Leached Nitrogen (means in kg/ha and totals in kg)';
	break;
case 22: 
	$vs2 = 'etrt12';
	$tits = "ET (m3)";
	$titp = "ET mean (m3/ha)";
	$tit = 'Simulated actual Evapotranspiration (means in m<sup>3</sup>/ha and totals in m<sup>3</sup>)';
	break;

}

$adem = ademas($casod);
$mensz = mensz($casod);

$_SESSION['pos'] = get_permalink();

/*$gcultt = array('Alfalfa',	'Arroz',	'Barbecho',	'Cebada',	'Cereales',	'Forraje',	'Frutales',	'Gramineas',	'Hortalizas',	'Leguminosas',	'Maiz',	'Olivar',	'Trigo',	'Tuberculos',	'Uva');*/

//$gcult = array('Maiz', 'Trigo', 'Hortalizas', 'Cebada', 'Uva', 'Alfalfa', 'Olivar',	'Frutales');
$gcult = array('Maize', 'Wheat', 'Vegetables', 'Barley', 'Vineyard', 'Alfalfa', 'Olives',	'Fruits');


/*$frutales = array ('albaricoquero',	'Almendro',	'avellano',	'cerezo',	'ciruelo',	'higuera',	'manzano',	'melocotonero',	'melon',	'membrillero',	'nispero',	'nogal',	'otrosfrutales',	'Peral');

$hortalizas = array ('acelga',	'ajo',	'Alcachofa',	'apio',	'Berenjena',	'berza',	'Broculi',	'Calabazaycalabacin',	'Cardo',	'cebolla',	'cebolleta',	'Coliflor',	'Colyrepollo',	'escarola',	'Esparrago',	'espinaca',	'lechuga',	'otrashortalizas',	'Pimiento',	'puerro',	'Tomate');

$leguminosas = array('altramuz', 'garbanzos',	'guindilla',	'Guisanteseco',	'Guisantesverdes',	'Habassecas',	'Habasverdes',	'judiassecas',	'Judiasverdes',	'lentejas',	'otrasleguminosas',	
'soja',	'vezagrano');

$cereales = array('avena',	'centeno',	'otros',	'otroscereales', 'triticale');

$gramineas = array('girasol', 'Otrasgramineas',	'sorgo');

$tuberculos = array ('otrostuberculos',	'Patata',	'remolacha',	'zanahoria');

$forraje = array ('Colza', 'vezaforrajera');*/


$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");
$months = array("oct", "nov", "dec", "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep");



//echo $qt.'<br>';

	$ntg = $wpdb->get_var('SELECT count(*) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Gravedad"'.$adem);
	$ntp = $wpdb->get_var('SELECT count(*) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Presion"'.$adem);
	$nts = $wpdb->get_var('SELECT count(*) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Secano"'.$adem);
	$atg = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Gravedad"'.$adem);
	$atp = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Presion"'.$adem);
	$ats = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Secano"'.$adem);

//echo 'la tabla es '.$wpdb->prefix . $vs2.'<br>';	
	
		foreach ($meses as $mes) { // Todos los meses
			$sg = $wpdb->get_var('SELECT sum(`'.$mes.'`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Gravedad"'.$adem);
			$sug[$mes] = $sg;
			$avg [$mes] = $sg/$atg;
			$sp = $wpdb->get_var('SELECT sum(`'.$mes.'`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Presion"'.$adem);
			$sup[$mes] = $sp;
			$avp [$mes] = $sp/$atp;
			$ss = $wpdb->get_var('SELECT sum(`'.$mes.'`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Secano"'.$adem);
			$sus[$mes] = $ss;
			$avs[$mes] = $ss/$ats;
							
			} // Fin del foreach
			
	$tsg =  array_sum($sug); //$wpdb->get_var('SELECT sum(`Total`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Gravedad"'.$adem);
	$tsp =  array_sum($sup); //$wpdb->get_var('SELECT sum(`Total`) FROM `'.$wpdb->prefix . $vs2.'` where `riego`= "Presion"'.$adem);
	$tpg =  $tsg/$atg;
	$tpp =  $tsp/$atp;
	
	$titt = 'Total';
	$tittp = 'Average';

	
$nmes = implode(",", $months);
$g1pm = implode(",", $avg);
$g2pm = implode(",", $avp);
$g3pm = implode(",", $avs);
$g1sm = implode(",", $sug);
$g2sm = implode(",", $sup);
$g3sm = implode(",", $sus);

echo do_shortcode('[framed_box bgColor="378de5" textColor="ffffff" rounded="true"]You have selected results from '.$mensz.'. Area under surface irrigation is '.number_format($atg).' ha. Sprinkler irrigation can be found in '.number_format($atp).' ha and '. number_format($ats). ' ha correspond to rainfed crops. [/framed_box]');


$apm = '[easychart type="line" width="75" title="'.$titp.'" groupnames="Surface, Sprinkler, Rainfed"  valuenames="'.$nmes.'" group1values="'.$g1pm.'"  group2values="'.$g2pm.'" group3values="'.$g3pm.'"]';
echo do_shortcode ($apm);

$apm = '[easychart type="vertbar" width="75" title="'.$tits.'" groupnames="Surface, Sprinkler, Rainfed"  valuenames="'.$nmes.'" group1values="'.$g1sm.'"  group2values="'.$g2sm.'" group3values="'.$g3sm.'"]';
echo do_shortcode ($apm);

echo '<h5>'.$tit.'</h5>';
?>

<table width="400" border="1">
  <tr>
    <th></th>
    <th style="text-align: center"><?php echo $tittp ?> Surface</th>
    <th style="text-align: center"><?php echo $tittp ?> Sprinkler</th>
    <th style="text-align: center"><?php echo $titt ?> Surface</th>
    <th style="text-align: center"><?php echo $titt ?> Sprinkler</th>
  </tr>
<?php
$ms = 0;
	foreach ($meses as $mes) { // Todos los meses
?>
	<tr>
    <td><?php echo str_pad(ucfirst ($months[$ms]), 10, " ", STR_PAD_BOTH)  ?></td>
    <td style="text-align: center"><?php echo number_format($avg[$mes])?></td>
    <td style="text-align: center"><?php echo number_format($avp[$mes])?></td>
    <td style="text-align: center"><?php echo number_format($sug[$mes])?></td>
    <td style="text-align: center"><?php echo number_format($sup[$mes])?></td>
   </tr>
<?php
$ms++;
	}
?>
<tr>
    <td>Year</td>
    <td style="text-align: center"><?php echo number_format($tpg)?></td>
    <td style="text-align: center"><?php echo number_format($tpp)?></td>
    <td style="text-align: center"><?php echo number_format($tsg)?></td>
    <td style="text-align: center"><?php echo number_format($tsp)?></td>    
  </tr>
</table>

<?php


/*$frut = "'".implode("', '", $frutales)."'";
$hort = "'".implode("', '", $hortalizas)."'";*/
$gctvo = implode(',', $gcult);



foreach ($gcult as $gc) {
$ng = $wpdb->get_var('SELECT count(*) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Gravedad"'.$adem);
$ngc[] = $ng;
$np = $wpdb->get_var('SELECT count(*) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Presion"'.$adem);
$npc[] = $np;
$ag = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Gravedad"'.$adem);
$agc[] = $ag;
$ap = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Presion"'.$adem);
$apc[] = $ap;
$gg = $wpdb->get_var('SELECT sum(`Total`) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Gravedad"'.$adem);
$gsg[] =  $gg;
$gp = $wpdb->get_var('SELECT sum(`Total`) FROM `'.$wpdb->prefix . $vs2.'` where `Gcult`= "'.$gc.'" and `riego`= "Presion"'.$adem);
$gsp[] =  $gp;
	
		if ($ag > 0) $gpg[] = $gg/$ag;
		else $gpg[] = 0;
		if ($ap > 0) $gpp[] = $gp/$ap;
		else $gpp[] = 0;
		
 }

// Principales cultivos en gravedad - suma
$i = 0;
$cpg = '[easychart type="pie" width="75" title="'.$tits.' of the main crops - Surface" groupnames="'.$gctvo.'"  ';
	foreach ($gsg as $sg) {
	$i++;
	$cpg .=  'group'.$i.'values="'.$sg.'"  ';
	}
$cpg .= 'hidechartdata ="true" chartfadecolor="FFFFFF"]';

echo do_shortcode ($cpg);

// Principales cultivos en Presion - suma

$i = 0;
$cpg = '[easychart type="pie" width="75" title="'.$tits.' of the main crops - Sprinkler" groupnames="'.$gctvo.'"  ';
	foreach ($gsp as $sp) {
	$i++;
	$cpg .=  'group'.$i.'values="'.$sp.'"  ';
	}
$cpg .= 'hidechartdata ="true" chartfadecolor="FFFFFF"]';

echo do_shortcode ($cpg);

// Principales cultivos en gravedad - Promedio

$i = 0;
$cpg = '[easychart type="pie" width="75" title="'.$titp.' by crop - Surface" groupnames="'.$gctvo.'"  ';
	foreach ($gpg as $pg) {
	$i++;
	$cpg .=  'group'.$i.'values="'.$pg.'"  ';
	}
$cpg .= 'hidechartdata ="true" chartfadecolor="FFFFFF"]';

echo do_shortcode ($cpg);

// Principales cultivos en Presion - Promedio

$i = 0;
$cpg = '[easychart type="pie" width="75" title="'.$titp.' by crop - Sprinkler" groupnames="'.$gctvo.'"  ';
	foreach ($gpp as $pp) {
	$i++;
	$cpg .=  'group'.$i.'values="'.$pp.'"  ';
	}
$cpg .= 'hidechartdata ="true" chartfadecolor="FFFFFF"]';

echo do_shortcode ($cpg);


echo '<h5>'.$tit.' by crop</h5>';
?>
<table border="1">
  <tr>
    <th>Crop</th>
    <th style="text-align: center">Surface plots</th>
    <th style="text-align: center">Sprinkler plots</th>
    <th style="text-align: center"><?php echo $tittp ?> Surface</th>
    <th style="text-align: center"><?php echo $tittp ?> Sprinkler</th>
    <th style="text-align: center"><?php echo $titt ?> Surface</th>
    <th style="text-align: center"><?php echo $titt ?> Sprinkler</th>
  </tr>
  <?php for ($j = 0; $j < count($gcult); $j++) { ?>
	<tr>
    <td><?php echo $gcult[$j] ?></th>
    <td style="text-align: center"><?php echo number_format($ngc[$j])?></td>
    <td style="text-align: center"><?php echo number_format($npc[$j])?></td>
    <td style="text-align: center"><?php echo number_format($gpg[$j])?></td>
    <td style="text-align: center"><?php echo number_format($gpp[$j])?></td>
    <td style="text-align: center"><?php echo number_format($gsg[$j])?></td>
    <td style="text-align: center"><?php echo number_format($gsp[$j])?></td>
  </tr>
<?php }
echo '</table>';

echo do_shortcode('[boton link="http://amaltea.co/en/lnitrates/?page_id=122&vuelve=true" self="true"]Select other results[/boton]');

/*unset($_SESSION['casod']);
if (isset($_SESSION['cult']))
unset($_SESSION['cult']);
if (isset($_SESSION['zns']))
unset($_SESSION['zns']);
unset($_SESSION['triego']);
unset($_SESSION['varb']);
*/

?>