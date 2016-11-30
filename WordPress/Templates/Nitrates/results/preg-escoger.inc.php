<?php
	
function cult($valor) { // Seleccionar cultivos

$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$cultivos = array ('Maiz'=>'Maizgrano',	'Trigo'=>'trigoblando',	'Cebada'=>'Cebada',	'Alfalfa'=>'alfalfa' );
$i = 0;
?>
<form name="cult" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
<p>Select among the main crops in the zona:<?php  if (isset($valor))  echo $preg1ra;  ?></p>
  <?php foreach ($cultivos as $key => $val) { ++$i; ?>
  <label><input type="radio" name="cult" id="cult" value=<?php echo $val ?>
  <?php  if ($valor == $val) echo 'checked="checked"'; ?> />
  <?php echo $key ?></label></br>
  <?php /*if (is_int($i/2)) echo '</tr><tr>';*/ } ?>
 
  <?php if (!isset($valor)) { ?><br>
    <p>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label>
      <br>
    </p>
    <?php } ?>
</form></p>
    <?php } // termina la funcion Cultivos
	
	
function casosd($valor) { // Seleccionar casos
$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$casosd = array( 1 => 'All data', 2 => 'Modelling Sectors', 3 => 'Nitrates Vulnerable Zones');
$i = 0;
  ?>
<form name="casod" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
    <p>Select one from the following outputs:<?php if (isset($valor)) echo $preg1ra; ?></p>
    
    <?php foreach ($casosd as $casod) { ?>
    <label>
    <input type="radio" name="casod" value="<?php echo $casod ?>" id=" <?php echo 'cd_'.$i ?>"
    <?php  if ($valor == $casod) echo 'checked="checked"'; ?> />
    <?php echo $casod ?></label> <br>
   <?php ++$i; } if (!isset($valor)) { ?><br>
    <p>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label>
    <?php } 
	else echo '<br>'; ?>
</form>
<?php 
} // termina la funcion casosd


function zns($valor) { // Seleccionar cultivos
$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$zonasv = array (/*0 => 'Toda la zona',*/ 1=>'Ebro Tudela Alagon',	2=>'Rioja Mendavia',	3=>'Cidacos',	4=>'Non-vulnerable zones');
$i = 0;
?>
<form name="zns" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
<p>Select de Nitrates Vulnerable Zone:<?php  if (isset($valor)) echo $preg1ra ?></p>
    <?php foreach ($zonasv as $zv) { ?>
    <label>
    <input type="radio" name="zns" value="<?php echo $zv ?>" id=" <?php echo 'zv_'.$i ?>"
    <?php  if ($valor == $zv) echo 'checked="checked"'; ?> />
    <?php echo $zv ?></label> <br>
   <?php } if (!isset($valor)) { ?><br>
    <p>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label></p>
    <?php }  ?>
</form>
    <?php } // termina la funcion ZNS
	
function sector($valor) { // Seleccionar cultivos
$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$sectores = array (/*0 => 'Toda la zona',*/ 1=>'Viana-Mendavia',	2=>'Lodosa-Azagra',	3=>'Azagra-Tudela',	
	4=>'Aluvial Arag&oacute;n', 5=>'Tudela-Cortes', 6=>'Cidacos');
$i = 1;
?>
<form name="sector" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
<p>Select the Modelling sector:<?php  if (isset($valor)) echo $preg1ra ?></p>
<table>
<tr>
    <?php foreach ($sectores as $key => $value) { ?>
    <td>
    <label>
    <input type="radio" name="sector" value="<?php echo $key ?>" id=" <?php echo 's_'.$i ?>"
    <?php  if ($valor == $key) echo 'checked="checked"'; ?> />
    <?php echo $sectores[$key] ?></label> </td>
   <?php if (is_int($i/3)) echo '</tr>';
   ++$i;	} ?>
   </tr>
   </table>
   <?php if (!isset($valor)) { ?><br>
    <p>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label></p>
    <?php }  ?>
</form>
    <?php } // termina la funcion Sector
	
function triego($valor) { // Seleccionar riego
$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$tiposr = array( 1 => 'Gravedad', 2 => 'Presion');
$i = 0;
  ?>
<form name="triego" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
    <p>Seleccione el tipo de riego:<?php if (isset($valor)) echo $preg1ra; ?></p>
    <?php foreach ($tiposr as $triego) { ?>
    <label>
    <input type="radio" name="triego" value="<?php echo $triego ?>" id=" <?php echo 'tr_'.$i ?>"
    <?php  if ($valor == $triego) echo 'checked="checked"'; ?> />
    <?php echo $triego ?></label> <br>
   <?php ++$i; } if (!isset($valor)) { ?><br>
    <p>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label>
    <?php } 
	else echo '<br>'; ?>
</form>
<?php 
} // termina la funcion triego

function varb($valor) { // Seleccionar casos
$preg1ra = '     <img src="'. home_url(). '/results/images/icon_accept.gif" class="imgizq"/>';
$varbc = array( 18 => 'Infiltration', 20 => 'Leached Nitrogen', 22 => 'Crop water use'); //Paginas de cada caso
$i = 0;
  ?>
<form name="varb" method="post" action= "<?php echo $_SESSION['pos'] ?>#preg">
    <p>Select the ouptput variable:<?php if (isset($valor)) echo $preg1ra; ?></p>
    
    <?php foreach ($varbc as $k => $vbc) { ?>
    <label>
    <input type="radio" name="varb" value="<?php echo $k ?>" id=" <?php echo 'vbc_'.$i ?>"
    <?php  if ($valor == $k) echo 'checked="checked"'; ?> />
    <?php echo $vbc ?></label> <br>
   <?php ++$i; } if (!isset($valor)) { ?><br>
      <label>
      <input type="submit" name="Submit" id="Submit" value="Submit">
      </label>
    <?php }  ?>
</form>
<?php  } // termina la funcion varb
