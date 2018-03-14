<?php

add_action('admin_menu', 'email_recruiters_submenu'); // Crea el submenu Email recruiters
function email_recruiters_submenu() {
add_submenu_page(
    'edit.php?post_type=oferta',
    'Email to Recruiters', /*page title*/
    'Email-Recruiters', /*menu title*/
    'manage_options', /*roles and capabiliyt needed*/
    'emails_recruiters',
    'emails_to_recruiters' 
); }

function rec_contactados_table() { // Crea la tabla de recruiters contactados
   global $wpdb;

   $table_name = $wpdb->prefix . "rec_contacts";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  email_r VARCHAR(90) NOT NULL,
  UNIQUE KEY id (id)
    );";
    

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );

}

register_activation_hook( __FILE__, 'rec_contactados_table' );

function ultimas_ofertas_procesadas ($pais) {
	
	$fechap = get_option( 'fechap_email_rec' );
	
	if (isset($fechap)) 	{
		// Existe una fecha anterior y por lo tanto no se consideran todas las ofertas

		function ultimas_ofertas_p_fecha( $where = '', $fechap ) {  // Obtiene las ofertas con los metadatos despues de la fecha
		global $wpdb;
		
		$where .= $wpdb->prepare( " AND post_date > %s", $fechap );
		return $where;
		}
	 
		add_filter( 'posts_where', 'ultimas_ofertas_p_fecha' );
				} 
 
	$args = array (
	'post_type' => 'oferta',
	'suppress_filters' => false,
	'meta_key' => 'pais',
	'meta_value' => $pais // Pais para el que se esta considerando los emails
	);
	
       $ofertas_sinp = get_posts( $args ); // Retrieve all the data from ofertas sin procesar
       return $ofertas_sinp;

	if (isset($fechap))  
	remove_filter( 'posts_where', 'ultimas_ofertas_p_fecha' );// Important to avoid modifying other queries
	
	
 
	} // Fin de ultimas_ofertas_procesadas
	
function email_rec_oferta ($oferta) { // Extrae el email del recruiter del meta dato de la oferta
	
	
}

function envia_email ($email_r) { // Envia el email al recruiter segun la tabla de emails
	
}

// Parte principal de email-recruiters
	
	?>
	<div class = "wrap">
		<?php screen_icon('plugins') ?>
	<h2>Envio de emails a recruiters</h2>
	
	<?php if(!isset($_POST['pais'])) { // No existe la designacion de pais por lo que se pregunta cuál ?>
	
	<form method="post" id="pais" name="pais" action="">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="pais">Pais de los empleadores:</label></th>
				<td>
				<input type="radio" name="pais" value="Reino Unido" />
					<?php _e('United Kingdom', 'ofertas-plugin') ?>
				<input type="radio" name="pais" value="Francia" />
					<?php _e('France', 'ofertas-plugin') ?>
				<input type="radio" name="pais" value="Alemania" />
					<?php _e('Germany', 'ofertas-plugin') ?>
				</td>
			</tr>
	<form method="post" id="opciones" name="opciones" action="">
		<table class="form-table">
			<tr valign="top">
				<td>
				<input type="submit" name="save" value="Guardar Opciones" class="button-primary">
				</td>
			</tr>
		</table>
	</form>
		
	<?php }
	else 	{
	echo "<h3>Procesando la información de recruiters</h3>";
	$pais = $_POST['pais'];
	$ofertas_r = ultimas_ofertas_procesadas ($pais); // Obtiene las ofertas para el pais elegido a partir de la ultima fecha
		foreach ($ofertas_r as $oferta_r) : // Se procesa cada oferta del array de ofertas
			$email_r = email_rec_oferta ($oferta_r); // Obtiene el email de la oferta
			envia_email ($email_r);	// Envia el email si no existe y actualiza la tabla	
		endforeach;
	update_option ('fechap_email_rec', getdate()); // Actualiza la fecha del ultimo procesamiento	
		} // Fin del procesamiento
	 
	

	
?>
	</div> <?php // Fin de wrapp
 // Fin de email-recruiters