<?php

function tf_dcomprec ($user) { // Nombre de la Emporesa del recruiter
	
	$userid = $user->ID;
	$comprec = get_user_meta( $userid, 'tf_comprec', true );
	?>
	
<h3><?php _e('About your Recruiter Activity', 'ofertas-plugin') ?></h3>
	
	
	<table class="form-table">
	<tbody>
        <th><label for = "tf_comprec"><?php _e('Recruiter company name', 'ofertas-plugin') ?>:</label></th>
		<td><input id="tf_comprec" name="tf_comprec" value="
		<?php if (isset($comprec)) echo $comprec ?>" class="regular-text"> </td>
	</tr>
	</tbody>
	</table>
	
<?php
}

add_action( 'show_user_profile', 'tf_dcomprec');

 //Add and fill an extra input field to user's profile
function tf_recruiter_lang ($user ) {

	$userid = $user->ID;
	$lang = get_user_meta( $userid, 'tf_adminlang', true );

	 // Preferred language     ?>
    <table class="form-table">
	<tbody>
 	<tr>
		<th><?php _e('Preferred Language', 'ofertas-plugin')  ?></th>
		<td>
			<select name="tf_adminlang_lang">
				<option value="en_US" <?php selected( 'en_US', $lang); ?>>English</option>
				<option value="es_ES" <?php selected( 'es_ES', $lang); ?>>Espa&ntilde;ol</option>
				<option value="fr_FR" <?php selected( 'fr_FR', $lang); ?>>Fran&ccedil;ais</option>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
	
	<?php
}

add_action( 'show_user_profile', 'tf_recruiter_lang');

function tf_recruiter_pais ($user ) {

	$userid = $user->ID;
 	$paiss = get_user_meta( $userid, 'tf_pais', true );
 	?>

	 <table class="form-table">
	<tbody>
 	<tr>
        <th><?php _e('Country for the job offers', 'ofertas-plugin') ?></th>
		<td>
			<select name="tf_pais">
				<option value="Reino Unido"<?php selected('Reino Unido', $paiss); ?>>
                <?php _e('United Kingdom', 'ofertas-plugin') ?> </option>
                <option value="Francia"<?php selected('Francia', $paiss); ?>>
                <?php _e('France', 'ofertas-plugin') ?> </option>
                <option value="Alemania"<?php selected('Alemania', $paiss); ?>>
                <?php _e('Germany', 'ofertas-plugin') ?> </option>
				<option value="Belgica"<?php selected('Belgica', $paiss); ?>>
                <?php _e('Belgium', 'ofertas-plugin') ?> </option>
				<option value="Suiza"<?php selected('Suiza', $paiss); ?>>
                <?php _e('Switzerland', 'ofertas-plugin') ?> </option>
				<option value="multipais"<?php selected('multipais', $paiss); ?>>
                <?php _e('Any available country', 'ofertas-plugin') ?> </option>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
	<?php
}

add_action( 'show_user_profile', 'tf_recruiter_pais');


// Monitor form submits and update user's setting if applicable 
function tf_pcomprec ( $userid ) {
	// Nombre de la agencia de empleo
	if( isset( $_POST['tf_comprec'] ) )
	update_user_meta( $userid, 'tf_comprec', $_POST['tf_comprec'] );
	}
add_action( 'personal_options_update', 'tf_pcomprec' );


function tf_recruiter_update_lang( $userid ) {

         //  Preferred language
	if( isset( $_POST['tf_adminlang_lang'] ) ) {
		switch ($_POST['tf_adminlang_lang']) {
		case ('es_ES') : $lang = 'es_ES'; break;
		case ('fr_FR') : $lang = 'fr_FR'; break;
		case ('en_US') : $lang = 'en_US'; break; }
		update_user_meta( $userid, 'tf_adminlang', $lang );
	}
 }
add_action( 'personal_options_update', 'tf_recruiter_update_lang' );

function tf_recruiter_update_pais( $userid ) {

if( isset( $_POST['tf_pais'] ) )
	update_user_meta( $userid, 'tf_pais', $_POST['tf_pais'] );
}
add_action( 'personal_options_update', 'tf_recruiter_update_pais' );




?>