<?php
session_start(); ?>
<style type="text/css"> 
#caja { 
width:80%; 
height:20px; 
border:1px solid black;
margin-top:2px;
margin-bottom:4px;
margin-left:10%;
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
<?php
global $wpdb;

include_once('\Auxf\funct.inc.php');


$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");

$cultivos_ant = array ("Alcachofa", "apio", "avena", "Cardo", "Cebada", "centeno", "Colza", 
"Habasverdes", "otroscereales", "Otrasgramineas", "trigoblando", "trigoduro", "triticale", "vezaforrajera", "vezagrano", "zanahoria");

$y = 12; // Se simula solo para el 2012

include_once('\Auxf\encab.inc.php');

$_SESSION['res'] = get_permalink();


$cropn = $_SESSION['cult'];


if ($_SESSION['j']<=$_SESSION['nump']) {  // Aun quedan parcelas para simular
	
		$j = $_SESSION['j'];
		
		
		$idp = $_SESSION['np'][$j];
		
		
		$percent = $_SESSION['j']*100/$_SESSION['nump'];	
		
		?>
        <div class="boton">Progreso de la ejecuci&oacute;n: <?php echo number_format($percent,1) ?>%
			<div id="caja" >
  				<div id="barrap" style="width:<?php echo number_format($percent,0) ?>%">
            	</div>
        	</div>	
       	</div>
<?php
$py = 'p2012';
$sy = 's2012';


// Estacion meteeorologica y suelos
$estm = $wpdb->get_var('SELECT `estacion` FROM `'.$wpdb->prefix . $sy.'` where `idp` = "'.$idp.'"');
$p_s =  $wpdb->get_var('SELECT `ids` FROM `'.$wpdb->prefix . $sy.'` where `idp` = "'.$idp.'"');

// Datos de suelo
$hr30 = $wpdb->get_var('SELECT `HR` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$hs30 = $wpdb->get_var('SELECT `HS` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$a30 = $wpdb->get_var('SELECT `ALFA` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$n30 = $wpdb->get_var('SELECT `N` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$k30 = $wpdb->get_var('SELECT `K` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$l30 = $wpdb->get_var('SELECT `L` FROM `'.$wpdb->prefix . 'suelos30` where `Punto` = "'.$p_s.'"');
$hr60 = $wpdb->get_var('SELECT `HR` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');
$hs60 = $wpdb->get_var('SELECT `HS` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');
$a60 = $wpdb->get_var('SELECT `ALFA` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');
$n60 = $wpdb->get_var('SELECT `N` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');
$k60 = $wpdb->get_var('SELECT `K` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');
$l60 = $wpdb->get_var('SELECT `L` FROM `'.$wpdb->prefix . 'suelos60` where `Punto` = "'.$p_s.'"');


// Datos de riego 
$riego= $_SESSION['triego'];
$area= $wpdb->get_var('SELECT `area` FROM `'.$wpdb->prefix . $py.'` where `ip` = "'.$idp.'"');

$ruta = dirname(__FILE__).'\Sim_SWAP\\Simdat\\';


$lat = asig_lat($estm);
$alt = asig_alt($estm);
$proph1 = propiedh(1, $hr30, $hs30, $a30, $n30, $k30, $l30);
$proph2 = propiedh(2, $hr60, $hs60, $a60, $n60, $k60, $l60);

$pond = "0.2";

	/*$fert = array();
	$bal = array();*/
	$fs = array();
	$fc = array();
		
	if (in_array($cropn, $cultivos_ant))
	$yeari = $y - 1;
	else
	$yeari = $y;

//Fechas de siembra y cosecha
	$ds = $wpdb->get_var('SELECT `dia_s` FROM `'.$wpdb->prefix . 'dcultivos` where `idc` = "'.$cropn.'"');
	$ms = $wpdb->get_var('SELECT `mes_s` FROM `'.$wpdb->prefix . 'dcultivos` where `idc` = "'.$cropn.'"');
	$dc = $wpdb->get_var('SELECT `dia_c` FROM `'.$wpdb->prefix . 'dcultivos` where `idc` = "'.$cropn.'"');
	$mc = $wpdb->get_var('SELECT `mes_c` FROM `'.$wpdb->prefix . 'dcultivos` where `idc` = "'.$cropn.'"');

$cropnr = substr($cropn, 0, 8);
	
	for ($k = 0; $k <= 2; $k++) { // Asigna la misma fecha de siembra y cosecha pero en tres años
		$fs[] = asig_fs($ds, $ms) . strval(1999 + $k + $yeari);
		$fc[] = asig_fc($dc, $mc) . strval(1999 + $k + $y);
	}
	

$irg = fopen($ruta.'riego.irg', "w");
include('\Auxf\irgdat.inc.php');

$swp = fopen($ruta.'SWAPs.swp', "w");
include('\Auxf\esc_SWP.php');

fclose($swp);

// Se crea el fichero BAT
$fbat = fopen($ruta.'SWAP.BAT', "w");
fwrite($fbat, "..\Executable\swap.exe SWAPs.SWP");
fclose($fbat);


// Ejecuta el SWAP
chdir($ruta.'/');
exec('SWAP.BAT');

$percs = array();

require ('\Auxf\lee_results.inc.php');
require ('\Auxf\calc_nit.inc.php');

$_SESSION['j']++;
?>

<script type="text/javascript">
		window.location = "http://localhost/Navarra-es/?page_id=249"
		</script>

<?php } 

else // Termino las simulaciones

{
$nmes = implode(",", $meses);


foreach ($meses as $mes) {
$perca[$mes] =  $wpdb->get_var('SELECT avg(`'.$mes.'`) FROM `'.$wpdb->prefix . 'perct`');
//$percs[$mes] =  $wpdb->get_var('SELECT sum(`'.$mes.'` * `area`/1000) FROM `'.$wpdb->prefix . 'perct`');
$nlixa[$mes] =  $wpdb->get_var('SELECT avg(`'.$mes.'`) FROM `'.$wpdb->prefix . 'nlixt`');
}

$percma = $_SESSION['percma'];
$g1ps = implode(",", $percma);
$g2ps = implode(",", $perca);

$apma = '[easychart type="vertbar" width="75" title="Infiltracion promedio (mm)" groupnames="Resultados anteriores, Nuevas simulaciones"  valuenames="'.$nmes.'" group1values="'.$g1ps.'"  group2values="'.$g2ps.'"]';
echo do_shortcode ($apma);

$nlixma = $_SESSION['nlixma'];
$g1ns = implode(",", $nlixma);
$g2ns = implode(",", $nlixa);

$anma = '[easychart type="vertbar" width="75" title="Lavado nitrogeno (kg/ha)" groupnames="Resultados anteriores, Nuevas simulaciones"  valuenames="'.$nmes.'" group1values="'.$g1ns.'"  group2values="'.$g2ns.'"]';
echo do_shortcode ($anma);

/*$percms = $_SESSION['percms'];
$g1pm = implode(",", $percms);
$g2pm = implode(",", $percs);

$apms = '[easychart type="vertbar" width="75" title="Infiltracion total (m3)" groupnames="Resultados anteriores, Nuevas simulaciones"  valuenames="'.$nmes.'" group1values="'.$g1pm.'"  group2values="'.$g2pm.'"]';
echo do_shortcode ($apms);*/
?>

<h5></h5>
<table width="400" border="1">
	<tr>
    <td rowspan="2"></td>
    <th colspan="2" style="text-align:center">Infiltraciones promedio (mm)</th>
    <!--<th colspan="2" style="text-align:center">Infiltraciones totales  (m<sup>3</sup>)</th>-->
    <th colspan="2" style="text-align:center">Lavado nitr&oacute;geno (kg/ha)</th>
  <tr>
    <th style="text-align: center">Resultados anteriores</th>
    <th style="text-align: center">Nuevas simulaciones</th>
    <th style="text-align: center">Resultados anteriores</th>
    <th style="text-align: center">Nuevas simulaciones</th>
  </tr>
<?php
	foreach ($meses as $mes) { // Todos los meses
?>
	<tr>
    <th><?php echo str_pad(ucfirst ($mes), 10, " ", STR_PAD_BOTH)  ?></th>
    <td style="text-align: center"><?php echo number_format($percma[$mes], 0, ',', ' ')?></td>
    <td style="text-align: center"><?php echo number_format($perca[$mes], 0, ',', ' ')?></td>
    <td style="text-align: center"><?php echo number_format($nlixma[$mes], 0, ',', ' ')?></td>
    <td style="text-align: center"><?php echo number_format($nlixa[$mes], 0, ',', ' ')?></td>
    <!--<td style="text-align: center"><?php //echo number_format($percms[$mes], 0, ',', ' ')?></td>
    <td style="text-align: center"><?php //echo number_format($percs[$mes], 0, ',', ' ')?></td>-->
   </tr>
<?php
	}
?>
<tr>
    <th>Total anual</th>
    <td style="text-align: center"><?php echo number_format(array_sum($percma), 0, ',', ' ')?></td>
    <td style="text-align: center"><?php echo number_format(array_sum($perca), 0, ',', ' ')?></td>  
    <td style="text-align: center"><?php echo number_format(array_sum($nlixma), 0, ',', ' ')?></td>
    <td style="text-align: center"><?php echo number_format(array_sum($nlixa), 0, ',', ' ')?></td>    
  </tr>
</table>

<?php
} // Fin de ver simulaciones

echo do_shortcode('[boton link="http://amaltea.co/es/lnitratos/?page_id=239&vuelve=true" self="true"]Realizar otras simulaciones[/boton]');
?>

		