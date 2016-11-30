<?php
session_start();
global $wpdb;

if (!defined('CAM'))
define ('CAM', home_url(). "/results/");
include_once( 'preg-escoger.inc.php');
include_once('pre-process.inc.php');

$_SESSION['pos'] = get_permalink();

$cultivos = array ('Maiz'=>'Maizgrano',	'Trigo'=>'trigoblando',	'Cebada'=>'Cebada',	'Alfalfa'=>'alfalfa' );
$meses = array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");

$termina = false;

//Formulario para seleccionar resultados


if ((isset($_GET["vuelve"]) and $_GET["vuelve"]==true) or (isset($_SESSION['res']) and $_SESSION['res'] <> get_permalink())){
	if (isset($_SESSION['cult']))
	unset($_SESSION['cult']);
	if (isset($_SESSION['casod']))
	unset($_SESSION['casod']);
	if (isset($_SESSION['zns']))
	unset($_SESSION['zns']);
	if (isset($_SESSION['sector']))
	unset($_SESSION['sector']);
	if (isset($_SESSION['varb']))
	unset($_SESSION['varb']);
	if (isset($_SESSION['fin']))
	unset($_SESSION['fin']);
	if (isset($_SESSION['res']))
	unset($_SESSION['res']);
	if (isset($_SESSION['dfert']))
	unset($_SESSION['dfert']);
	if (isset($_SESSION['triego']))
	unset($_SESSION['triego']);
	if (isset($_SESSION['sriego']))
	unset($_SESSION['sriego']);
	if (isset($_SESSION['nbal']))
	unset($_SESSION['nbal']);
	if (isset($_SESSION['percm']))
	unset($_SESSION['percm']);
	if (isset($_SESSION['percs']))
	unset($_SESSION['percs']);
	if (isset($_SESSION['np']))
	unset($_SESSION['np']);
	}
?>

<table style="line-height:135%;">
<tr>
<td style="vertical-align:top">        

<?php 

// Formulario
//Seleccion 

echo "<a id='preg'></a> ";

if (!isset($_SESSION['cult']) and !isset($_POST['cult']))   // Estamos al comienzo
  	call_user_func ('cult', null);
else {
	if (isset($_POST['cult']) and !isset($_SESSION['cult'])) $_SESSION['cult'] = $_POST['cult']; 
	call_user_func ('cult', $_SESSION['cult']); 
	echo '</td>'; // Fin de pregunta cult
	
echo '<td style="vertical-align:top">';	
		if (!isset($_SESSION['triego']) and !isset($_POST['triego']))   // Estamos al comienzo
			call_user_func ('triego', null);
		else {
			if (isset($_POST['triego']) and !isset($_SESSION['triego'])) $_SESSION['triego'] = $_POST['triego']; 
			call_user_func ('triego', $_SESSION['triego']); 
			echo '</td></tr><tr>'; // Fin de pregunta triego  	

		echo '<td style="vertical-align:top">';	
		if (!isset($_SESSION['casod']) and !isset($_POST['casod']))   // Estamos al comienzo
			call_user_func ('casosd', null);
		else {
			if (isset($_POST['casod']) and !isset($_SESSION['casod'])) $_SESSION['casod'] = $_POST['casod']; 
			call_user_func ('casosd', $_SESSION['casod']); 
			echo '</td>'; // Fin de pregunta casos  
			
		if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'Todos los datos') {
		echo '</tr>';
		$_SESSION['fin'] = true; }
		
	
				if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'Zonas Vulnerables a Nitratos') {  // Se ha escogido por zonas vulnerables
				?>
				<td style="vertical-align:top">
				<?php
				if (!isset($_SESSION['zns']) and !isset($_POST['zns'])) 
					call_user_func ('zns', null);
					else {
						if (isset($_POST['zns']) and !isset($_SESSION['zns'])) $_SESSION['zns'] = $_POST['zns']; 
						call_user_func ('zns', $_SESSION['zns']); // Ya se ha respondido
						$_SESSION['fin'] = true;
				echo '</td></tr>'; }}  // Fin del if zns
	
				
				
				if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'Sectores') {  // Se ha escogido por zonas vulnerables
					?>
					<td style="vertical-align:top">
					<?php
					if (!isset($_SESSION['sector']) and !isset($_POST['sector'])) 
						call_user_func ('sector', null);
						else {
							if (isset($_POST['sector']) and !isset($_SESSION['sector'])) $_SESSION['sector'] = $_POST['sector']; 
							call_user_func ('sector', $_SESSION['sector']); // Ya se ha respondido
							$_SESSION['fin'] = true;
					echo '</td></tr>'; }}  // Fin del if sector
					
 }}}

echo '</table>';
 // Fin del formulario

if ($_SESSION['fin'] == true) {  // Procesamiento

$_SESSION['percm'] = array();
$_SESSION['nlixm'] = array();

$casod = $_SESSION['casod'];

$cropn = $_SESSION['cult'];

$adem = ademas($casod);
$mensz = mensz($casod);
$cultivo = array_search($cropn, $cultivos);

$py = 'pmt';

$sqlp = 'SELECT COUNT(*) FROM `'.$wpdb->prefix . $py.'` where `Cultivo`= "'.$cropn.'" and `riego`= "'.$_SESSION['triego'].'"'.$adem;

if ($wpdb->get_var($sqlp) < 20)
echo do_shortcode('[boton link="http://localhost/Navarra-es/?page_id=239&vuelve=true" self="true"]No hay suficientes datos. Haga click aqu&iacute; para reiniciar[/boton]');

else {




$mens = 'Selecci&oacute;n de datos de cultivo para la simulaci&oacute;n';
	echo do_shortcode('[boton]'.$mens.'[/boton]');

?>

<div class="divider"></div>

<?php 
$caso = strtolower(substr($_SESSION['triego'], 0, 1)); // coge la primera letra como G o P

if (!isset($_SESSION['dfert']) and !isset($_POST['dfert']))   // Estamos al comienzo
  	call_user_func ('dfert', null, $cropn, $cultivo);
else {
	if (isset($_POST['dfert']) and !isset($_SESSION['dfert'])) $_SESSION['dfert'] = $_POST['dfert']; 
	$ferts = $_SESSION['dfert'];
	call_user_func ('dfert',$ferts, $cropn, $cultivo, $ferts); 
echo "<a id='pregc'></a>";   
    if (!isset($_SESSION['sriego']) and !isset($_POST['sriego']))   // Estamos al comienzo
  	call_user_func ('driego', null, $cropn, $cultivo, $caso);
	else {
		if (isset($_POST['sriego']) and !isset($_SESSION['sriego'])) $_SESSION['sriego'] = $_POST['sriego'];
		$riegos = $_SESSION['sriego'];
		call_user_func ('driego',$riegos, $cropn, $cultivo, $caso); 
		$termina = true;

 }}

if ($termina) {

$fert = array();
$bal = array();

foreach ($meses as $mes) { // Datos de fert y bal
$fert[$mes] =  $wpdb->get_var('SELECT `'.$mes.'` FROM `'.$wpdb->prefix . 'nfert` where `idc`= "'.$cropn.'"');
$bal[$mes] =  $wpdb->get_var('SELECT `'.$mes.'` FROM `'.$wpdb->prefix . 'nbal` where `idc`= "'.$cropn.'"');
}	

$_SESSION['fert'] = $fert;
$_SESSION['bal'] = $bal;

$sqlq = 'SELECT `idp` FROM `'.$wpdb->prefix . $py.'` where `Cultivo`= "'.$cropn.'" and `riego`= "'.$_SESSION['triego'].'"'.$adem.' ORDER BY RAND() LIMIT 100';


$nps = $wpdb->get_results ($sqlq);
	foreach ($nps as $ps) {
	$j++;
	$np[$j] = $ps->idp;
	}
$_SESSION['nump'] = count($np);
$_SESSION['np'] = $np;	


$idps = "'".implode("', '", $np)."'";


$adp = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . 'pmt` where `idp` in ('.$idps.')')/10000;
$atp = $wpdb->get_var('SELECT sum(`area`) FROM `'.$wpdb->prefix . 'pmt` where `Cultivo`= "'.$cropn.'" and `riego`= "'.$_SESSION['triego'].'" '.$adem)/10000;

//$percm = array();
foreach ($meses as $mes) {
//$percms[$mes] =  $wpdb->get_var('SELECT sum(`'.$mes.'` * `area`/1000) FROM `'.$wpdb->prefix . 'pmt` where `Cultivo`= "'.$cropn.'" and `riego`= "'.$_SESSION['triego'].'" and `idp` in ('.$nps.')'.$adem); 
$percma[$mes] =  $wpdb->get_var('SELECT avg(`'.$mes.'`) FROM `'.$wpdb->prefix . 'pmt` where `idp` in ('.$idps.')'); 
$nlixma[$mes] =  $wpdb->get_var('SELECT avg(`'.$mes.'`) FROM `'.$wpdb->prefix . 'nmt` where `idp` in ('.$idps.')'); 
}
//$_SESSION['percms'] = $percms;
$_SESSION['percma'] = $percma;
$_SESSION['nlixma'] = $nlixma;
//$_SESSION['nbal'] = $wpdb->get_row ('SELECT * FROM `'.$wpdb->prefix . 'nbal` where `idc`= "'.$cropn.'"', ARRAY_A);

$_SESSION['j'] = 1;
$_SESSION['mens'] = 'Ha escogido los resultados de '.$mensz.' para '.$cultivo.' ('.$_SESSION['triego'].'). El &aacute;rea de las '.$_SESSION['nump'].
' parcelas seleccionadas para la simulaci&oacute;n es de '.number_format($adp, 0, ',', ' ').' ha, que constituye el '.number_format($adp*100/$atp, 3, ',', ' ').'% de la zona, cultivo y tipo de riego seleccionados ('.
number_format($atp, 0, ',', ' ').' ha).';

$variab = array ('perct', /*'etpt', 'etrt', 'aguatt',*/ 'nlixt');

	foreach ($variab as $v) { // ejecuta para todas las variables
	
	$wpdb->query("DROP TABLE IF EXISTS `". $wpdb->prefix.$v."`");
	
		$queryc = "CREATE TABLE IF NOT EXISTS  `".$wpdb->prefix.$v."` ( `idp` VARCHAR( 30 ) COLLATE utf8_spanish_ci NOT NULL , ";
				for ($j = 0; $j < 12; $j++) {
				$queryc .= "`".$meses[$j]."` DOUBLE(7,2) DEFAULT NULL ,"; //}
			}
		$queryc .= "`area` DOUBLE(7,2) DEFAULT NULL ,";
		$queryc .= " PRIMARY KEY (  `idp` ) ) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci ";
	
	$wpdb->query($queryc);
	} // fin del for para variables
	
echo '<div class="divider"></div>';
echo do_shortcode('[boton link="http://localhost/Navarra-es/?page_id=249" self="true"]Simular con estos datos[/boton]');	
echo '<div style="float:right">'.do_shortcode('[boton link="http://localhost/Navarra-es/?page_id=239&vuelve=true" self="true"]Escoger otros datos[/boton]').'</div>';
}
    ?>

<?php } }?>