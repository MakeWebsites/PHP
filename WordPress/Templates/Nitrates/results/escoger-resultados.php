<?php
session_start();

if (!defined('CAM'))
define ('CAM', home_url(). "/results/");
include_once( 'preg-escoger.inc.php');

$_SESSION['pos'] = get_permalink();

//Formulario para seleccionar resultados

$fin = false;
$cont = false;

if ((isset($_GET["vuelve"]) and $_GET["vuelve"]==true) or (isset($_SESSION['res']) and $_SESSION['res'] <> get_permalink())){
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
	unset($_SESSION['res']);
	}

?>

<table style="line-height:135%;">
<tr>
<td style="vertical-align:top">        

<?php 

/*if (isset($_SESSION['find']))
$find = $_SESSION['find'];
else
$find = false;
*/

//Seleccion 
echo "<a id='preg'></a> ";
if (!isset($_SESSION['casod']) and !isset($_POST['casod']))   // Estamos al comienzo
  	call_user_func ('casosd', null);
else {
	if (isset($_POST['casod']) and !isset($_SESSION['casod'])) $_SESSION['casod'] = $_POST['casod']; 
	call_user_func ('casosd', $_SESSION['casod']); 
	echo '</td>'; // Fin de pregunta casos 
	
	if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'Nitrates Vulnerable Zones') {  // Se ha escogido por zonas vulnerables
	?>
    <td style="vertical-align:top">
    <?php
	if (!isset($_SESSION['zns']) and !isset($_POST['zns'])) 
		call_user_func ('zns', null);
		else {
			if (isset($_POST['zns']) and !isset($_SESSION['zns'])) $_SESSION['zns'] = $_POST['zns']; 
			call_user_func ('zns', $_SESSION['zns']); // Ya se ha respondido
			$cont = true;
	echo '</td></tr>'; }}  // Fin del if zns

if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'All data') $cont = true;

if (isset($_SESSION['casod']) and $_SESSION['casod'] == 'Modelling Sectors') {  // Se ha escogido por zonas vulnerables
	?>
    <td style="vertical-align:top">
    <?php
	if (!isset($_SESSION['sector']) and !isset($_POST['sector'])) 
		call_user_func ('sector', null);
		else {
			if (isset($_POST['sector']) and !isset($_SESSION['sector'])) $_SESSION['sector'] = $_POST['sector']; 
			call_user_func ('sector', $_SESSION['sector']); // Ya se ha respondido
			echo "<a id='preg'></a> ";
			$cont = true;;
	echo '</td></tr>'; }}  // Fin del if sector
 
// Seleccion variable a visualizar
 echo '<tr><td style="vertical-align:top">';
 if ($cont) {
  if (!isset($_SESSION['varb']) and !isset($_POST['varb']))  // Estamos al comienzo
  	call_user_func ('varb', null);
  	else {
	if (isset($_POST['varb']) and !isset($_SESSION['varb'])) $_SESSION['varb'] = $_POST['varb']; 
  	call_user_func ('varb', $_SESSION['varb']); // Ya se ha respondido
	echo "<a id='fin'></a> "; 
	$fin = true;
	?>
	</td>
    </tr>
    

<?php } }  }  

echo '</table>';
if ($fin) {
echo '<p>';
	$mens = 'Please wait a moment....We are processing your request....';
	echo do_shortcode('[boton]'.$mens.'[/boton]');
	//echo "<div class='divider'></div>";
	echo '<br><br></p>'
    ?>
<script type="text/javascript">
		window.location = "http://amaltea.co/en/lnitrates/?page_id=<?php echo $_SESSION['varb']; ?>"
		</script>
<?php } ?>