<?php 
function IsChecked($chkname,$value)
    {
        if(!empty($chkname))
        {
            foreach($chkname as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }

function Pais($valor) { // Seleccionar país
$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';
$preg1rb = '     <img src='. OFERTAS_URL. '/images/action_stop.gif alt="Error!" title="Error"/>';
$paises = array( 1 => __('United Kingdom', 'ofertas-plugin'), 2 => __('France', 'ofertas-plugin'),
3 => __('Germany', 'ofertas-plugin'));
$i = 0;


  ?>
<p><form name="pais" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <p><?php _e('Country of the job offer', 'ofertas-plugin') ?>:
    <?php if (isset($valor)) echo $preg1ra; ?></p>
    <?php foreach ($paises as $pais) { ?>
    <label>
    <input type="radio" name="pais" value="<?php echo $pais ?>" id=" <?php echo 'pais_'.$i ?>"
    <?php  if ($valor == $pais) echo 'checked="checked"'; ?> />
    <?php echo $pais ?></label> <br>
   <?php ++$i; } if (!isset($valor)) { ?>
    <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <br>
    </p>
    <?php } ?>
</form></p>
<?php } // termina la funcion pais

function qlugar($valor) { // Lugar dentro de pais
$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';
?>
<form id="qlugar" name="qlugar" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <label><?php _e('Location', 'ofertas-plugin').':' ?>
    <input name="lugar" type="text" id="lugar" maxlength="30" 
    <?php if (isset($valor)) {
	echo 'value="  '.esc_attr($valor).'"'; ?>
	/>  </label>
    <?php echo $preg1ra; }
   else { ?>
  <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label><br>
      <?php _e('City or region of the job', 'ofertas-plugin'); ?>
      <br>
    </p>
    <?php } ?>
</form>
  <?php } // termina la funcion Lugar 
  
function qcategoria($valor) { // Seleccionar categoria de trabajo
$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';
$mensaje = __('Choose one or more categories that fit the job', 'ofertas-plugin');
$categoria = array (
1 => __('Administration', 'ofertas-plugin'), 2 => __('Education', 'ofertas-plugin'), 3 => __('Engineers', 'ofertas-plugin'),
4 => __('Health', 'ofertas-plugin'), 5 => __('Computers', 'ofertas-plugin'), 6 => __('Construction', 'ofertas-plugin'),
7 => __('Tourism', 'ofertas-plugin'), 8 => __('Trade and retail', 'ofertas-plugin'), 9 => __('House services', 'ofertas-plugin'),
10 => __('Agriculture', 'ofertas-plugin'), 11 => __('Languages and Translation', 'ofertas-plugin'),
12 => __('Transports', 'ofertas-plugin'), 13 => __('Factories', 'ofertas-plugin'), 14 => __('Security', 'ofertas-plugin'),
15 => __('Finances', 'ofertas-plugin'), 16 => __('Arts and Entertainment', 'ofertas-plugin'),
17 => __('Accounting', 'ofertas-plugin'), 18 => __('Customer Relations', 'ofertas-plugin'), 19 => __('Lawyers', 'ofertas-plugin'),
20 => __('Research & Development', 'ofertas-plugin'), 21 => __('Graduates', 'ofertas-plugin'), 22 => 'Au Pair');
asort($categoria);
$i = 0;
?>
<p><form name="qcat" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
<?php echo $mensaje ?><?php  if (isset($valor)) echo $preg1ra ?>
<table width="500">
  <tr>
  <?php foreach ($categoria as $key => $val) { ++$i; ?>
  <td><label><input type="checkbox" name="categoria[]" id="categoria[]" value=<?php echo $key ?>
  <?php  if (IsChecked($valor, $key)) echo 'checked="checked"' ?> />
  <?php echo $val ?></label></td>
  <?php if (is_int($i/3)) echo '</tr>'; } ?>
  </tr>
  </table>
  <?php if (!isset($valor)) { ?>
    <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <br>
    </p>
    <?php } ?>
</form></p>
    <?php } // termina la funcion pregunta3 
	
function freekeyw($valor) { // Free Keyword
 $preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';
//switch ($leng) {
//case ('es_ES') : $label = 'Titulo'; $mensaje = 'Introduzca un titulo para la oferta de hasta 30 caracteres';
//				$error_t = 'Texto demasiado largo. Solamente 30 caracteres'; $enviar = 'Enviar'; break;
//case ('fr_FR') : $label = 'Tirtre'; $mensaje = "Entrez un tirtre d'un maximum de 30 caract&egrave;res";
//				$error_t = "Texte trop long. Seulement 30 caract&egrave;res"; $enviar = 'Valider'; break;
$label = __('Job title', 'ofertas-plugin');
$mensaje = __('Enter a title for this job of up to 30 characters', 'ofertas-plugin');
$error_t = __('Text too long. Only 30 characters', 'ofertas-plugin');
?>

<form id="freekeyw" name="freekeyw" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <p><label><?php echo $label.':' ?>
    <input name="freekeyw" type="text" id="lugar" size="30" maxlength="30" 
    <?php if (isset($valor)) {
	echo 'value="  '.esc_attr($valor).'"'; ?>
	/>  
    </label>
    <?php echo $preg1ra.'</p>'; }
   else { ?>
  <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label><br>
      <?php echo "($mensaje)"; ?></p>
      <br>
    </p>
    <?php } ?>
</form>
  <?php } // termina la funcion freekeyw

function qsalario($valor) { // Lugar dentro de pais
$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';

//case ('es_ES') : $salario = 'Salario anual aproximado'; $mensaje='Entre Cero si no se incluye salario en la oferta';
//				$error_t = 'El salario anual debe ser un n&uacute;mero entero'; $enviar = 'Enviar';
//break;
//case ('fr_FR') : $salario = 'Salaire annuel approximatif'; $mensaje= "Entrez nulle '0' si l'offer d'emploi non compris pas le salaire";
//				$error_t = "Le salaire annuel doit &ecirc;tre un entier"; $enviar = 'Valider';
//break;
$salario = __('Approximate annual Salary', 'ofertas-plugin');
$mensaje=  __('Enter zero if wage is not included in the job post', 'ofertas-plugin');
$error_t = __('The annual salary must be an integer', 'ofertas-plugin');
$preg1rb = '     <img src='. OFERTAS_URL. '/images/action_stop.gif alt="Error!" title="Error"/>';

?>

<form id="qsalario" name="qsalario" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <label><?php echo $salario ?>: 
    <input name="salario" type="text" id="salario" size="10" maxlength="10" 
    <?php if (isset($valor)) {
	echo 'value="  '.esc_attr($valor).'"'; ?>
	/>  </label>
 		<?php	echo $preg1ra.'</p>'; }
   else { ?>
  <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <?php if (isset($_SESSION['mens']) && ($_SESSION['mens']  == 'sal'))
			echo $preg1rb.'<br>'.$error_t;
			else echo "<br>($mensaje)"; ?>
      <br>
    </p>
    <?php } ?>
</form>
  <?php } // termina la funcion qsalario 
  
function descrip($valor) { // Descricion
$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';

//case ('es_ES') : $descrip = 'Descripci&oacute;n'; $mensaje = ''; $enviar = 'Enviar';
//break;
//case ('fr_FR') : $descrip = 'Description de poste'; $mensaje = "Entrez la description compl&egrave;te de l'emploi (en Fran&ccedil;ais)";
//				$enviar = 'Valider';
//break;
$descrip = __('Job description', 'ofertas-plugin');
$mensaje = __('Enter the complete description of the job (in English)', 'ofertas-plugin');
?>
<form name="descrip" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <p></p>
    <?php echo $descrip.':'; if (isset($valor)) echo $preg1ra; ?><br>
      <textarea name="descripcion" cols="55" rows="5" id="descripcion">
      <?php if (isset($valor)) echo ($valor).'</textarea>'; 
	  else { ?>
      </textarea>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label><br>
      <?php echo $mensaje; } ?>
</form>
    <?php } // termina la funcion descripcion 


function qcontacto($valor) { // Contacto

$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="'.__('Option selected!', 'ofertas-plugin').'"
title='.__('Option selected!', 'ofertas-plugin').'!"/>';
?>
<form id="qcontacto" name="qcontacto" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <label>Contacto: 
    <input name="contacto" type="text" id="contacto" size="30" maxlength="50" 
    <?php if (isset($valor)) {
	echo 'value="  '.$valor.'"'; ?>
	/>
  </label>
    <?php echo $preg1ra; }
   else { ?>
  <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <br>
    </p>
    <?php } ?>
</form>
  <?php } // termina la funcion qcontacto


function qemail($valor) { // Contacto

$preg1ra = '     <img src='. OFERTAS_URL. '/images/icon_accept.gif alt="Opci&oacute;n elegida!" title="Opci&oacute;n elegida!"/>';
?>
<form id="qemail" name="qemail" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <p></p><label>Correo electr&oacute;nico: 
    <input name="email" type="text" id="contacto" size="50" maxlength="70" 
    <?php if (isset($valor)) {
	echo 'value="  '.$valor.'"'; ?>
	/>
    </label>
    <?php echo $preg1ra; }
   else { ?>
  <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <br>
    </p>
    <?php } ?>
</form>
  <?php } // termina la funcion qemail 
  
   function publicar() { // Define publicacion ?>
<form name="publicar" method="post" action= <?php echo OFERTAS_URL. "/process_oferta.php" ?>>
    <p><?php _e('Publish now?', 'ofertas-plugin') ?>:</p>
    <label>
    <input type="radio" name="publicar" value='publish' id="pub_1"  />
      <?php _e('Yes', 'ofertas-plugin') ?></label>
    <br>
    <label>
    <input type="radio" name="publicar" value='draft' id="pub_2"  />
	<?php _e('No', 'ofertas-plugin') ?></label>
    <br>
    <p>
      <label>
      <input type="submit" name="enviar" id="enviar" value="<?php _e('Submit') ?>">
      </label>
      <br>
    </p>
</form>
<?php } // termina la funcion publicar 


?>
