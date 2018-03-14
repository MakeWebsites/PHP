<?php
$_SESSION['url_ofertas'] = get_bloginfo('url');

// Borrado de variables de sesion
//unset ($_SESSION['pais']);
//unset ($_SESSION['lugar']);
//unset ($_SESSION['titulo']);
//unset ($_SESSION['categoria']);
//unset ($_SESSION['salario']);
//unset ($_SESSION['descripcion']);
//unset ($_SESSION['contacto']);
//unset ($_SESSION['email']);
//unset ($_SESSION['freekeyw']);
//unset ($_SESSION['mens']);
//unset ($_SESSION['url_ofertas']);

function oferta_dashboard_widget_function() {
// Formulario para oferta de trabajo
$cont = true;


$categorias = array (
1 => 'Administracion', 2 => 'Educacion', 3 => 'Ingenieros', 4 => 'Sanidad', 5 => 'Informatica',
6 => 'Construccion', 7 => 'Turismo y Hosteleria', 8 => 'Comercio', 9 => 'Servicios domesticos',
10 => 'Agricultura', 11 => 'Idiomas y Traduccion', 12 => 'Transportes', 13 => 'Fabricas', 14 => 'Seguridad',
15 => 'Finanzas', 16 => 'Arte y Espectaculos', 17 => 'Contabilidad', 18 => 'Atencion al Cliente', 19 => 'Abogados',
20 => 'Investigacion y Desarrollo', 21 => 'Licenciados', 22 => 'Au Pair');
include( 'functions.inc.php');
$llenarpost = false;
$borrado = false;
$user = wp_get_current_user();
	$userid = $user->ID;
$udata = get_userdata($userid);

// Pregunta 1
if ($cont) {
$cont = false;
  // if (current_user_can('manage_options')) { // Es el admin
	if (!isset($_SESSION['pais'])) // No se ha contestado la pregunta 1
  		call_user_func ('pais', null);
 	else {
  	call_user_func ('pais', $_SESSION['pais']);
	$cont = true;   }  // }
	//else   { // es un autor
	//$_SESSION['pais'] = get_user_meta( $userid, 'tf_pais', true );
    //$cont = true;   }
 } // fin de pregunta 1 ?>
 
<table cellpadding="5">
<tr>
<td valign="top">
<?php 
// Preguna 2
if ($cont) {
$cont = false;
if (!isset($_SESSION['lugar'])) // No se ha contestado la pregunta 2
	call_user_func ('qlugar', null);
	else {
	$_SESSION['lugar'] = esc_attr($_SESSION['lugar']);
	call_user_func ('qlugar', $_SESSION['lugar']);
	$cont = true;
	}
 } // fin de pregunta 2 ?>

<?php 
// Preguna 3
if ($cont) {
$cont = false;
if (!isset($_SESSION['categoria'])) // No se ha contestado la pregunta 4
	call_user_func ('qcategoria', null);
	else {
	call_user_func ('qcategoria', $_SESSION['categoria']);
	$cont = true; 
	}
 } // fin de pregunta 3 ?> 


 </td>
<td valign="top">

<?php
 // Preguna 4
if ($cont) {
$cont = false;
if (!isset($_SESSION['freekeyw'])) // No se ha contestado la pregunta 4
	call_user_func ('freekeyw', null);
else {
	//$_SESSION['freekeyw'] = remove_accents($_SESSION['freekeyw']);
	call_user_func ('freekeyw', $_SESSION['freekeyw']);
	$cont = true; 
	}
 } // fin de pregunta 4 ?>


<?php 
// Preguna 5
if ($cont) {
$cont = false;
if (!isset($_SESSION['salario'])) // No se ha contestado la pregunta 5
	call_user_func ('qsalario', null);
	else {
	call_user_func ('qsalario', $_SESSION['salario']);
	$cont = true; }
 } // fin de pregunta 5 ?>
<?php 
// Preguna 6
if ($cont) {
$cont = false;
if (!isset($_SESSION['descripcion'])) // No se ha contestado la pregunta 6
	call_user_func ('descrip', null);
	else {
	//$_SESSION['descripcion'] = remove_accents($_SESSION['descripcion']));
	call_user_func ('descrip', $_SESSION['descripcion']);
	$cont = true; 
	}
 } // fin de pregunta 6 ?>

</td>
</tr>
</table>

<?php 

// Preguna 7
if ($cont) {
$cont = false;
if  (current_user_can('manage_options')) { // Comienza parte para administrador
    if (!isset($_SESSION['contacto'])) // No se ha contestado la pregunta 7
	call_user_func ('qcontacto', null);
	else {
	call_user_func ('qcontacto', $_SESSION['contacto']);
	$cont = true; 	}   }
	else { // Es un autor
	$_SESSION['contacto'] =  $udata -> tf_comprec;
	$cont = true; 	}
 } // fin de pregunta 7 ?>

<?php 
// Preguna 8
if ($cont) {
$cont = false;
if  (current_user_can('manage_options')) { // Comienza parte para administrador
    if (!isset($_SESSION['email'])) // No se ha contestado la pregunta 8
	call_user_func ('qemail', null);
	else {
	call_user_func ('qemail', $_SESSION['email']);
	$llenarpost = true; }    }
	else { // Es un autor
	$_SESSION['email'] =  $udata -> user_email;
	$llenarpost = true; 	}
 } // fin de pregunta 8
 
 
     $text_info = '<p class="button-secondary">'.__('Please email', 'ofertas-plugin').' <a href="mailto:admin@trabajarfuera.es" title="'. __('Email us', 'ofertas-plugin').'"><u>Trabajar Fuera';
     $text_info .= '</u></a>'.' '. __('with any further enquiry', 'ofertas-plugin').'</p>';
     echo $text_info;
 
// Fin del formulario
if ($llenarpost) {
 // Ya existen datos del formulario
// se crea el post
// Se agrega el contenido
if (isset($_SESSION['categoria'])) {
$numc = count($_SESSION['categoria']);
$categ = $_SESSION['categoria']; 
	if ($numc < 2)
	$contd = 'Categor&iacute;a: ';
	else 
	$contd = 'Categor&iacute;as:';
	$cats = ' ';
	for ($i = 1; $i <= sizeof ($categorias); $i++) {
	if (IsChecked ($categ, $i))
	$cats .= $categorias [$i].' - '; } // fin del For
	$contd .= substr_replace ($cats, '', strlen($cats)-2); // Fin del else
} // Fin del if categoria

if (isset($udata -> user_url)) // Hay una web de la empresa
$_SESSION['contacto'] = '<a href="'.$udata -> user_url.'" title="Web del Empleador" rel="nofollow">'.$_SESSION['contacto'].'</a>';


$contd .= '<h3>Contacto: '.$_SESSION['contacto'].'</h3>';
$contd .= '<h3>Correo electr&oacute;nico: <a href="mailto:'.$_SESSION['email'].'">'.$_SESSION['email'].'</a></h3>';
if ($_SESSION['pais'] == 'Reino Unido')
$moneda = ' &pound;';
else
$moneda = ' &euro;';
if ($_SESSION['salario']>0)
$contd .= '<h4>Salario anual aproximado: '.$_SESSION['salario'].$moneda.'</h4>';
$contd .= '<h4>Descripci&oacute;n de la oferta:</h4>';
$contd .= $_SESSION['descripcion'];
$nueva_oferta = array (
	'post_type' => 'oferta',
	'post_content' => $contd,
);
// Se crea el logo
if  (!current_user_can('manage_options') && isset($udata ->tf_logop))
$logo_id = $udata ->tf_logop;
else
$logo_id = 4084;
// Insert the post into the database
$oferta_id = wp_insert_post( $nueva_oferta );
$tituloc = 'Trabajo en '.esc_attr($_SESSION['lugar']);
$tfreek = $_SESSION['freekeyw'];
$titulo = $tituloc.' | '.$tfreek;
$contdf = '<h2>'.$tituloc.', '.$_SESSION['pais'].' | '.$tfreek.'</h2>'.$contd;
// Se actualiza el titulo de la oferta
$oferta_updated = array ();
$oferta_updated ['ID'] = $oferta_id;
$oferta_updated ['post_title'] = esc_html($titulo);
$oferta_updated ['post_content'] = wp_kses_post ($contdf);
$oferta_updated ['post_status'] = 'draft';
wp_update_post( $oferta_updated );
// Se agrega la Taxonomy custom
wp_set_object_terms($oferta_id,'Ofertas de trabajo en '.$_SESSION['pais'],'empleo');
if (isset($categ)) {
$catkw = array();
for ($i = 1; $i <= sizeof ($categorias); $i++) {
	if (IsChecked ($categ, $i))
	$catkw[] = $categorias[$i];
	wp_set_object_terms($oferta_id, $catkw, 'trabajo-en'); } }
// Se agrega la metadata
set_post_thumbnail( $oferta_id, $logo_id );
add_post_meta($oferta_id, 'lugar', $_SESSION['lugar'], true);
add_post_meta($oferta_id, 'pais', $_SESSION['pais'], true);
add_post_meta($oferta_id, 'contacto', $_SESSION['contacto'], true);
add_post_meta($oferta_id, 'email', $_SESSION['email'], true);

$borrado = true; } // Fin del llenado del post

if ($borrado) {

// Borrado de variables de sesion
unset ($_SESSION['pais']);
unset ($_SESSION['lugar']);
unset ($_SESSION['titulo']);
unset ($_SESSION['categoria']);
unset ($_SESSION['salario']);
unset ($_SESSION['descripcion']);
unset ($_SESSION['contacto']);
unset ($_SESSION['email']);
unset ($_SESSION['freekeyw']);
unset ($_SESSION['mens']);
unset ($_SESSION['url_ofertas']);


$njob = __('New Job', 'ofertas-plugin');
$vjob = __('View Job', 'ofertas-plugin');
$ejob = __('Edit Job', 'ofertas-plugin');
?>

<table width="400" cellpadding="5">
<tr>
<td>
<form id="ver_post" name="ver_post" method="post" action=<?php echo get_permalink( $oferta_id ); ?>>
  <input type="submit" name="ver_post" id="ver_post" value=<?php echo $vjob ?> class="button-primary"/>
</form>
</td>
<td>
<form id="edit_post" name="edit_post" method="post" action=<?php echo get_edit_post_link( $oferta_id ); ?>>
  <input type="submit" name="edit_post" id="edit_post" value=<?php echo $ejob ?> class="button-primary"/>
</form>
</td>
</tr>
</table>


<?php }
 } // Termina la funcion oferta_dashboard_widget_function


function oferta_add_dashboard_widgets() {

	wp_add_dashboard_widget('oferta_dashboard_widget', __('Job Offer Form', 'ofertas-plugin'),
    'oferta_dashboard_widget_function');
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'oferta_add_dashboard_widgets');


?>
