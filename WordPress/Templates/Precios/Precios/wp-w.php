<?php  
session_start;
$price = 500;

if (!isset($_SESSION['npages']))
$_SESSION['npages'] = 3;

/*if (!isset($_SESSION['newsite']))
$_SESSION['newsite'] = false;
*/
// CSS según browser
function valid_np ($np) {
	$vp = false;
	if (filter_var($np, FILTER_VALIDATE_INT) and ($np > 2) and ($np < 11))
		$vp = true;
	return $vp;	
}
	
$info = $_SERVER['HTTP_USER_AGENT'];
 if(strpos($info,"Chrome") == true and strpos($info, "Edge") == false)  {
	$browser = "Chrome";
	$ancho = 100;
 }
 
	elseif (strpos($info,"Firefox") == true) {
		$browser = "Firefox";
		$ancho = 30;
	}
		elseif (strpos($info,"IE") == true)
		$browser = "IE";
		
			elseif (strpos($info,"Edge") == true)
			$browser = "Edge";
		
				else
				$browser = "Any other browser";	
			
//if ($browser != "Chrome") echo 'Estoy aqui en no chrome ';	
// Recalculating price
function calcprice ($varname, $cp) {
	if ($_SESSION[$varname])
		$_SESSION['price'] = $_SESSION['price'] + $cp;
		else
		$_SESSION['price'] = $_SESSION['price'] - $cp; }

if (isset($_POST['npages'])) {
		if ($browser != "Chrome") { // No es Chrome, hay que verificar la entrada
			 if (!valid_np($_POST['npages'])) { ?>
				<script>
				alert('El número de páginas debe ser un entero entre 3 y 10!!!')
				</script>
				<?php $_SESSION['npages'] = 3; } 
			else
				$_SESSION['npages'] = sanitize_text_field($_POST['npages']);
				 } 
		else // Si que es Chrome
		$_SESSION['npages'] = $_POST['npages']; }
	
if (isset($_POST['newpics']))
	$_SESSION['newpics'] = $_POST['newpics'] == 'true' ? true : false;

if (isset($_POST['ecommerce'])) 
	$_SESSION['ecommerce'] = $_POST['ecommerce'] == 'true' ? true : false;


if (isset($_POST['smedia'])) 
	$_SESSION['smedia'] = $_POST['smedia'] == 'true' ? true : false;

	// Calculo del precio
$price = $price + ($_SESSION['npages'] - 3) * 50;	
		if (isset($_SESSION['newpics'])) $price = $price + 325;
		if (isset($_SESSION['ecommerce'])) $price = $price + 450;
		if (isset($_SESSION['smedia'])) $price = $price + 275;

	?>
<div class="no-print"><a name="sprice"> </a></div><h3 style="margin-top:-2%">Total Presupuesto (sin IVA): <span style="color:blue;font-style: italic;float:right;">
<?php echo $price ?>&euro;</span></h3>
<?php echo do_shortcode('[divider]'); ?>
<h3 style="font-size: 150%;">Paquete B&aacute;sico (Para 3 p&aacute;ginas Web)</h3>
<table style="width:100%;margin-bottom:2%;line-height:100%">
  <tr>
    <td>Sitio web de 3 p&aacute;ginas utilizando WordPress Genesis (Framework).</td>
    <td class="no-print"><input name="content" type="checkbox"  disabled="disabled" checked /></td> 
  </tr>
  <tr>
	<td>Dominio dedicado.</td>
	<td class="no-print"><input name="metas" type="checkbox" disabled="disabled"  checked /></td>
  </tr>
  <tr>
	<td>Contenido de las webs y organización general optimizados.</td>
	<td class="no-print"><input name="keyw" type="checkbox" disabled="disabled"  checked /></td>
  </tr>
  <tr>
	<td>Sitio adaptable (responsive) para smartphones y tabletas.</td>
	<td class="no-print"><input name="badlinks" type="checkbox" disabled="disabled"  checked /></td>
  </tr>
  <tr>
	<td>Interacción con Facebook, RSSs, Twitter y otras redes sociales.</td>
	<td class="no-print"><input name="outbondl" type="checkbox" disabled="disabled"  checked /></td>
  </tr>
  <tr>
    <td>Evaluación del comportamiento del sitio durante un año.</td>
	<td class="no-print"><input name="analytics" type="checkbox" disabled="disabled"  checked /></td><td></td>
  </tr>
</table>

<h3 style="font-size: 150%;">Opciones adicionales al paquete b&aacute;sico:</h3>
<form method="POST" action = "<?php echo get_permalink() ?>#sprice">
<table style="width:100%;margin-bottom:2%;line-height:100%">
  <tr>
    <td>Hasta 10 p&aacute;ginas para su sitio: (<span style="color:#008A2F;font-weight: bold;">50&euro; por p&aacute;gina</span>):</td>
    <td><div class="alignright"  style="width:<?php echo $ancho ?>%"><input <?php if ($browser=="Chrome") echo 'type="number" min="3" max="10"'; else  echo 'type= ·"text"' ?> 
	name="npages" value="<?php echo $_SESSION['npages'] ?>"  style="padding:4%;text-align: center;" onChange='this.form.submit()'></div></td>
  </tr>
  <tr>
	<td>Dise&nacute;o de logos, figuras y/o contenido multimedia (<span style="color:#008A2F;font-weight: bold;">325€</span>):</td>
	<td><input name="newpics" id="newpics" type="checkbox" class="alignright" value="true" onChange='this.form.submit()' <?php if ($_SESSION['newpics']) echo 'checked' ?> /></td>
  </tr>
  <tr>
	<td>Comercio electr&oacute;nico (<span style="color:#008A2F;font-weight: bold;">450€</span>):</td>
	<td><input name="ecommerce" id='ecommerce' type="checkbox" class="alignright" value="true" onChange='this.form.submit()' <?php if ($_SESSION['ecommerce']) echo 'checked' ?>/>
	</td>
  </tr>
  <tr>
	<td>Cuentas en redes sociales y actualización por un a&nacute;o (<span style="color:#008A2F;font-weight: bold;">275€</span>):</td>
	<td><input name="smedia" id="smedia" type="checkbox" class="alignright" value="true" onChange='this.form.submit()'<?php if ($_SESSION['smedia']) echo 'checked'; 
if ($browser == 'Firefox') echo 'style="display:inline"' ?> /> 
	</td>
</form>
</table>
<div class="no-print">
<h3 style="font-size: 150%;" >&iquest;Interesado?</h3>
<?php 

$emailt = '?subject=Diseño%20sitio%20WordPress%20&amp;';
$emailt .= 'body=Estimado%20Diseñador%20Make-Website%20%3A%0A%0AEstoy%20interesado%20en%20su%20diseño%20WordPress%20por%20un%20precio%20de%20%C2%A3';
$emailt .= $price;
$emailt .= '.%20%0APara%20';
$emailt .= $_SESSION['npages'];
$emailt .= '%20páginas.';
	if ($_SESSION['newpics']) 
	$emailt .= '%20%0AAdemás%2C%20desearía%20diseñar%20nuevos%20logos%20figuras.';
	 if ($_SESSION['ecommerce'])
	 $emailt .= '%20%0AMe%20gustaría%20incluir%20plugins%20para%20comercio%20electrónico.';
	 if ($_SESSION['smedia'])
	 $emailt .= '%20También%20quisiera%20cuentas%20en%20redes%20sociales.'; 
 $emailt .= '%0A%0APor%20favor%20contactarme%20en%20este%20correo%20para%20proceder%20con%20el%20contrato.%0A%0A%20%0AUn%20saludo%2C';
echo do_shortcode( '[boton link="mailto:admin@make-websites.co.uk'.$emailt.'"]'.' Enviar presupuesto por email'. '[/boton]');
echo '<a href="" class="boton alignright" onClick="javascript:window.print()"/>Imprimir presupuesto</a>';
?>
</div>

