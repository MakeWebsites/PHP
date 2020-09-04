<?php
/*
Plugin Name: Extended-amaltea
Description: Extensions to Amaltea Genesis site
Version: 1.0
Author: Angel Utset
Author URI: http://strangework.com
License: GPLv2
*/

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'utset_css' );
function utset_css() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
	wp_register_style( 'utsets-style', plugins_url('utsets.css', __FILE__) );
}


//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://amaltea.co" title="A water and environment Consultancy">Zeta Amaltea</a>';
	echo '</p></div>';
}

/** Load custom favicon to header */

add_filter( 'genesis_pre_load_favicon', 'custom_favicon_filter' );

function custom_favicon_filter( $favicon_url ) {

return 'http://amaltea.co/img/z-amaltea-favicon.png';

}

function utset_login_logo() { // Customize login logo ?> 
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo_80x80.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'utset_login_logo' );

function utset_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'utset_login_logo_url' );

function utset_login_logo_url_title() {
    return 'Zeta Amaltea: A water and environment consultancy';
}
add_filter( 'login_headertitle', 'utset_login_logo_url_title' );

//* Customize the post info function
add_filter( 'genesis_post_info', 'utset_post_info_filter' );
function utset_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = 'New released on: [post_date] [post_comments] [post_edit]';
	return $post_info;
}}

//* Show only Post tags in entry meta for single Posts
add_filter( 'genesis_post_meta', 'utset_post_meta_filter' );
function utset_post_meta_filter($post_meta) {
 
	if ( is_singular('post') ) :
		$post_meta = '[post_tags]';
	else :
	endif;
	return $post_meta;
}

//* Shortocodes

function theme_sc_framed_box($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'width' => '',
		'height' => '',
		'bgcolor' => '',
		'textcolor' => '',
		'rounded' => 'false',
	), $atts));
	
	$width = $width?'width:'.$width.';':'';
	$height = $height?'height:'.$height.';':'';

	if(!empty($width)){
		$style = ' style="'.$width.'"';
	}else{
		$style = '';
	}

	$bgcolor = $bgcolor?'background-color:#'.$bgcolor.';':'';
	$textcolor = $textcolor?'color:#'.$textcolor:'';
	$rounded = ($rounded == 'true')?' rounded':'';
	if( !empty($height) || !empty($bgcolor) || !empty($textcolor)){
		$content_style = ' style="'.$height.$bgcolor.$textcolor.'"';
	}else{
		$content_style = '';
	}
	
	return '<div class="framed-box' .$rounded. '"'.$style.'><div class="framed-box-content"'.$content_style.'>' . do_shortcode($content) . '<div class="clear"></div></div></div>';
}
add_shortcode('framed_box','theme_sc_framed_box');

function sc_boton ($attr, $contenido) {
	
	$contenido = esc_html($contenido);
	
	if ((isset($attr['self'])) && $attr['self'] == true)
	$target = '""';
	else
	$target = '" target="_blank" ';
	
	if (isset($attr['titulo']))
	$titulo = esc_html($attr['titulo']);
	else
	$titulo = $contenido;
	
	if (isset($attr['link']))
		$link = 'href="'.$attr['link'].$target.' rel="nofollow"';
	else
		$link = '""';
		
	
	$content = '<a class="boton" '.$link.' title= "'.$titulo.'" >'.$contenido.'</a>';
	return $content;
	
}

add_shortcode('boton','sc_boton');


function utset_divider() {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'utset_divider');


add_action('publish_post', 'email_para_admin'); // Se le envia un email al admin cada vez que se publique una entrada y no sea el mismo admin el que la publica

function email_para_admin($post_id){

$post = get_post($post_id);
$autor = get_userdata($post->post_author);

if ($autor->user_email <> 'autset@consulclima.com') {

    $to = 'autset@amaltea.com';
    $subject = 'Se ha publicado una entrada';
    $message = "Hay una nueva entrada publicada en: ".get_permalink($post_id).'<br>';
	$message .= 'Publicada por '.$autor->display_name;
    wp_mail($to, $subject, $message );
	}
	
}

add_filter ("wp_mail_content_type", "amaltea_mail_content_type");
function amaltea_mail_content_type() {
	return "text/html";
}
	
add_filter ("wp_mail_from", "amaltea_mail_from");
function amaltea_mail_from() {
	return "amaltea@amaltea.co";
}
	
add_filter ("wp_mail_from_name", "amaltea_mail_from_name");
function amaltea_mail_from_name() {
	return "Zeta Amaltea";
}

function wp_new_user_notification($user_id, $plaintext_pass) {
	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);
	
	$email_subject = "Bienvenido a Amaltea ";
	
	ob_start();

	include("email-header.php");
	
	?>
	
	<p>Hola . Bienvenido al "backend" de Wordpress de Zeta Amaltea.</p>
	<p>Tu nombre de usuario es: <strong style="color:blue"> <?php echo $user_login ?></strong></p>
	<p>Tu contrase&ntilde;a actual es <strong style="color:blue"><?php echo $plaintext_pass ?></strong> aunque puedes cambiarla cuando quieras en tu perfil de Amaltea.
	</p>
	
	<p>
		Con estos datos puedes entrar cuando quieras a nuestro "backend" 
        El enlace para hacerlo es: <a href="http://amaltea.co/es/wp-login.php">http://amaltea.co/es/wp-login.php</a>
	</p>
	
	
	<?php
	include("email-footer.php");
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($user_email, $email_subject, $message);

}

?>