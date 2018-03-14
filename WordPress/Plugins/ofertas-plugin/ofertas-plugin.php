<?php
/*
Plugin name: Ofertas-plugin
Plugin URI: http://make-websites.co.uk/plugins/oferta
Description: Manejo de las ofertas de empleo, custom posts, taxonomies y users
Version: 1.0
Author: Angel Utset
Author URI: http://make-websites.co-uk
License: GPLv2
*/

/*  Copyright 2012  Angel Utset  (email : we@make-websites.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

session_start();
if (!defined('OFERTAS_PATH'))
define( 'OFERTAS_PATH', plugin_dir_path(__FILE__) );
if (!defined('OFERTAS_URL'))
define( 'OFERTAS_URL', plugin_dir_url(__FILE__) );

function tf_frontend_locale() {
if (!is_admin() or empty( $locale )) { // solo se activa si no es una pagina del backend o si no existe locale
 	$locale = 'es_ES';
 	return $locale; }

}
// Trigger this function every time WP checks the locale value
add_filter( 'locale', 'tf_frontend_locale' );

// Functions para hook init

function custom_oferta_init() { // Crea el customn post oferta

  $labels = array(
    'name' => __('Job Offers', 'ofertas-plugin'),
    'singular_name' => __('Job Offer', 'ofertas-plugin'),
    'edit_item' => __('Edit Jobs', 'ofertas-plugin'),
    'all_items' => __('All Jobs', 'ofertas-plugin'),
    'view_item' => __('View Jobs', 'ofertas-plugin'),
    'search_items' => __('Search Jobs', 'ofertas-plugin'),
    'not_found' =>  __('No Jobs', 'ofertas-plugin'),
    'not_found_in_trash' => __('Not in the trash'),
    'parent_item_colon' => '',
    'menu_name' => __('Edit Jobs', 'ofertas-plugin')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
	'taxonomies' => array('empleo', 'trabajo-en'),
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'oferta',
	//'menu_icon' => plugins_url('ofertas-plugin/images/tools2.png'), // 16px16
	'capabilities' => array(
				'publish_posts' => 'publish_ofertas',
				'edit_posts' => 'edit_ofertas',
				'edit_others_posts' => 'edit_others_ofertas',
				'delete_posts' => 'delete_ofertas',
				'delete_others_posts' => 'delete_others_ofertas',
				'edit_published_posts' => 'edit_published_ofertas',
				'delete_published_posts' => 'delete_published_ofertas',
			),
	'map_meta_cap'    => true,
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 2,
	'has_archive' => 'ofertas',
    'supports' => array( 'title', 'editor', 'genesis-seo', 'custom-fields', 'thumbnail','genesis-cpt-archives-settings' ),
  );
  register_post_type('oferta',$args);

}
add_action( 'init', 'custom_oferta_init' );


//hook into the init action and call create_ofertas_taxonomies when it fires
add_action( 'init', 'create_ofertas_taxonomies', 0 );

//create two taxonomies, oferta_p and oferta_k for the post type "oferta"
function create_ofertas_taxonomies()
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => __('Jobs', 'ofertas-plugin'),
    'singular_name' => __('Job', 'ofertas-plugin'),
    'edit_item' => __('Edit Job', 'ofertas-plugin'),
    'update_item' => __('Update Job', 'ofertas-plugin'),
    'add_new_item' => __('New Job', 'ofertas-plugin'),
    'new_item_name' => __('New Job Name', 'ofertas-plugin'),
    'menu_name' => __('Jobs', 'ofertas-plugin'),
  );

  register_taxonomy('empleo',array('oferta'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
	'show_in_nav_menus' => true,
    'query_var' => 'empleo',
	/*'rewrite' => array('slug' => '/%oferta%/'),*/
  ));

  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => 'trabajos-en',
    'singular_name' =>  'trabajo-en',
    'search_items' =>  'Search trabajo-en',
    'popular_items' => 'Popular trabajo-en',
    'all_items' => 'All trabajo-en',
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __('Edit trabajo-en', 'ofertas-plugin'),
    'update_item' => __('Update trabajo-en', 'ofertas-plugin'),
    'add_new_item' => __('Add New trabajo-en', 'ofertas-plugin'),
    'new_item_name' => __('New trabajo-en Name', 'ofertas-plugin'),
    'menu_name' => 'trabajo-en',
  );

  register_taxonomy('trabajo-en','oferta', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'trabajo-en' ),
  ));
}

// Functions para activacion del plugin

register_activation_hook( __FILE__, 'oferta_install' ); // Verifica que el plugin sea compatible con la version de wordpress instalada

function oferta_install() {
    if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) { // La version tiene que ser igual o mayor que la 3.1
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
    }

/* Get the default administrator role. */
        $role = get_role( 'administrator' );

        /* Add oferta capabilities to the administrator role. */
        if ( !empty( $role ) ) {
            $role->add_cap( 'edit_others_ofertas' );
            $role->add_cap( 'delete_ofertas' );
            $role->add_cap( 'delete_others_ofertas' );
            $role->add_cap( 'publish_ofertas' );
            $role->add_cap( 'edit_ofertas' );
            $role->add_cap( 'edit_published_ofertas' );
            $role->add_cap( 'delete_published_ofertas' );
            
        }

/* Get the author role. */
        $role = get_role( 'author' );

        /* Add oferta capabilities to the author role. */
        if ( !empty( $role ) ) {
            $role->remove_cap( 'edit_others_ofertas' );
            $role->remove_cap( 'delete_others_ofertas' );
            $role->add_cap( 'publish_ofertas' );
            $role->add_cap( 'edit_ofertas' );
            $role->add_cap( 'delete_ofertas' );
            $role->add_cap( 'edit_published_ofertas' );
            $role->add_cap( 'delete_published_ofertas' );
        }

}          // Fin de la funcion oferta_install



// Funciones para el hook plugins-loaded

function user_name_is() {
global $current_user;
 	if(is_user_logged_in()) {
		get_currentuserinfo();
		$_SESSION['usuario'] = $current_user->user_login; }
        }
add_action( 'plugins_loaded', 'user_name_is' );


function arregla_dashboard() {      // Arregla y ordena el dashboard para usuarios-recruiters
// Add to admin_init function
	add_action('manage_oferta_posts_custom_column', 'manage_oferta_columns');

	function manage_oferta_columns($column_name) {
	global $post;

	echo get_the_term_list( $post -> ID, 'empleo', '', ', ', '' );

	}

// remove the menu
add_action( 'admin_menu', 'oferta_hide_add_new_cpt_menu' );
function oferta_hide_add_new_cpt_menu() {
    global $submenu;
if ( isset( $submenu['edit.php?post_type=oferta'][10] ) ) {
unset( $submenu['edit.php?post_type=oferta'][10] );
}
}

function remove_footer_admin () {
    echo "Trabajar Fuera";
}

add_filter('admin_footer_text', 'remove_footer_admin');


function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
add_action('admin_head', 'hide_help');

function change_footer_version() {
  //return 'Ayudamos a buscar trabajo fuera de Espa&ntilde;a';
  return __('We help Spanish people to find a job abroad', 'ofertas-plugin');
}
add_filter( 'update_footer', 'change_footer_version', 9999 );

function single_screen_columns( $columns ) {
    $columns['dashboard'] = 1;
    return $columns;
}
add_filter( 'screen_layout_columns', 'single_screen_columns' );
function single_screen_dashboard(){return 1;}
add_filter( 'get_user_option_screen_layout_dashboard', 'single_screen_dashboard' );

// Add to admin_init function columnas de oferta
add_filter('manage_edit-oferta_columns', 'add_new_oferta_columns');

function add_new_oferta_columns($gallery_columns) {

		$new_columns['cb'] = '<input type="checkbox" />';
 		$new_columns['title'] = __('Job Offer', 'ofertas-plugin');
		$new_columns['author'] = __('Source', 'ofertas-plugin');
		if ( current_user_can ('manage_options'))   // the user is admin
		$new_columns['empleos'] = __('Jobs', 'ofertas-plugin');
		$new_columns['date'] = _x('Date', 'column name');

		return $new_columns;
	}

function tf_adminlang_set_user_locale() {
if (is_admin())  { // solo se activa si es una pagina del backend
	$user = wp_get_current_user();
	$userid = $user->ID;
	$locale = get_user_meta( $userid, 'tf_adminlang', true ); }
	else
	$locale = 'es_ES';
	return $locale;
}
 //Trigger this function every time WP checks the locale value
add_filter( 'locale', 'tf_adminlang_set_user_locale' );

include_once ('personal-options.inc.php'); // Opciones del perfil

// Limpia el dashboard para los autores
if (!current_user_can('manage_options'))
include_once( 'ofertas-dashboard.php');

//Create the function to output the form Dashboard Widget

include_once ('ofertas-formulario.php');

} // Fin de la funcion arregla_dashboard

add_action( 'plugins_loaded', 'arregla_dashboard' );

// Traducciones del plugin de ofertas
add_action( 'plugins_loaded', 'tf_traducciones' );

Function tf_traducciones () {

         load_plugin_textdomain( 'ofertas-plugin', false, 'ofertas-plugin/languages' );

          }

// functions para usuarios


function tf_custom_logo() { ?>
	<style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/tf_login.gif);
            padding-bottom: 15px;
        }
    </style>
	<?php 
//echo '
//<style type="text/css">
        //h1 a { background-image:url('.get_bloginfo('template_directory').'/images/tf_logo2.gif) !important; }
   // </style>';
}

// Sub-plugin con email to recruiters
//include_once ('email-recruiters.inc.php');


//hook into the administrative header output
add_action('login_enqueue_scripts', 'tf_custom_logo');

function tf_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'tf_login_logo_url' );

function tf_login_logo_url_title() {
    return 'Trabajar Fuera de Espa&ntilde;a';
}
add_filter( 'login_headertitle', 'tf_login_logo_url_title' );

add_filter ("wp_mail_content_type", "correo_oferta_status_content_type");
function correo_oferta_status_content_type() {
	return "text/html";
}

add_filter ("wp_mail_from", "correo_oferta_status_from");
function correo_oferta_status_from() {
	return "admin@trabajarfuera.es";
}
	
add_filter ("wp_mail_from_name", "correo_oferta_status_from_name");
function correo_oferta_status_from_name() {
	return "TrabajarFuera";
}
// Hook for post status changes
add_filter('transition_post_status', 'oferta_status',10,3);

function oferta_status($new_status, $old_status, $post) {

global $current_user;

$nueva_oferta = "";
$contributor = get_userdata($post->post_author);
$tipo = get_post_type( $post );
$autortf = $contributor->display_name;
$exentostf = array ('Trabajar Fuera', 'TF');

if ($tipo == 'oferta') { // Solo para ofertas

 if (!in_array($autortf, $exentostf)) {   // Envia email porque no es fuente conocida
	
	 if ($old_status != 'pending' && $new_status == 'pending')
	 $nueva_oferta = "Pendiente";
	 elseif ($old_status != 'publish' && $new_status == 'publish')
	 $nueva_oferta = "Publicada";

    if (!empty($nueva_oferta)) {
	$to = 'admin@trabajarfuera.es';
	$subject  = 'Oferta de trabajo '.$nueva_oferta;   
        ob_start();
?>

<html>
	<body>
		
		
			<div style="font-family:georgia;font-weight:500;font-size:16px; width:750px; padding:0 20px 20px 20px; margin:0 auto; border:3px #000 solid;
				moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; color:#454545;line-height:1.5em; " id="email_content">
				
				<h1 style="padding:5px 0 0 0; font-family:georgia;font-weight:500;font-size:24px;color:#000;border-bottom:1px solid #bbb">
					Hay una oferta en Trabajarfuera que debes revisar
				</h1>
				
				<p>
					T&iacute;tulo de la oferta: <?php echo $post->post_title ?>
				</p>
				<p>
					Autor de la Oferta: <?php echo $autortf ?>
				</p>
				
				<p style="">
					<a href="<?php echo wp_login_url() ?>">Entra a Trabajarfuera para revisarla</a>
					
				</p>
				
				<div style="text-align:left; border-top:1px solid #eee;padding:5px 0 0 0;" id="email_footer"> 
					<small style="font-size:14px; color:#999; line-height:14px;">
						<p>El status actual de la oferta es: <b><?php echo $post -> post_status ?></b></p>
                                                <a href="http://trabajarfuera.es/" style="color:#666">Visitar trabajarfuera.es</a>
					</small>
				</div>
				
			</div>
		</div>
	</body>
</html>

<?php
$mensaje_correo = ob_get_contents();
ob_end_clean(); 

wp_mail($to, $subject, $mensaje_correo );
      }
}
}
}

// Redefine user notification function
if ( !function_exists('wp_new_user_notification') ) {

	function wp_new_user_notification( $user_id, $user_pass ) {

		$user = new WP_User( $user_id );

		$user_login = stripslashes( $user->user_login );
		$user_n = stripslashes( $user->first_name );
		$user_fn = stripslashes( $user->last_name );
		$user_email = stripslashes( $user->user_email );

	$nickname = $user_n[0].'. '.$user_fn;
	$logintf = wp_login_url();
	$subject  = 'Welcome to TrabajarFuera '.$nickname;   
        ob_start();
?>

<html>
	<body>
		
		
			<div style="font-family:georgia;font-weight:500;font-size:14px; width:750px; padding:0 20px 20px 20px; margin:0 auto; border:3px #000 solid;
				moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; color:#454545;line-height:1.5em; " id="email_content">
				
				<h3>The following information has been saved in our recruiters database:</h3>
				<p align="justify"><b><em>Username</em>: <?php echo $user_login ?></b>   -
				Please use this when logging in to our site</p>
				<p align="justify"><b><em>Password</em>: <?php echo $user_pass ?></b> -  Please use this password the first time you log in our site.
				You can change it later in your profile settings</p>
				<p align="justify"><b><em>Email</em>: <?php echo $user_email ?></b> -  The TrabajarFuera admin and the jobseekers
				will use this email to contact you. It can be changed in your Profile page, but you can not use
				other existing email address</p>
				
				<p>You can log in to TrabajarFuera at any time.</p>
				<p>Use the link:<a href="<?php echo $logintf ?>" target="_blank">
				<span style="color:red"><b><?php echo $logintf ?></b></span></a></p>
				
				<div style="text-align:left; border-top:1px solid #eee;padding:5px 0 0 0;" id="email_footer"> 
					<small style="font-size:14px; color:#999; line-height:14px;">
						<p>Please email <a href="mailto:admin@trabajarfuera.es" style="color:#666"title="Email us">
						<u>Trabajar Fuera administrator</u></a> with any further enquiry.</p>
					</small>
				</div>
				
			</div>
	</body>
</html>

<?php
$mensaje_correo = ob_get_contents();
ob_end_clean(); 

wp_mail($user_email, $subject, $mensaje_correo );

// Mensaje al administrador
$subject  = 'Registro de nuevo recruiter';   
        ob_start();
?>

<html>
	<body>
		
		
			<div style="font-family:georgia;font-weight:500;font-size:14px; width:550px; padding:0 20px 20px 20px; margin:0 auto; border:3px #000 solid;
				moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; color:#454545;line-height:1.5em; " id="email_content">
				
				<h3><?php echo $nickname ?> se ha registrado en Trabajar Fuera como Recruiter:</h3>
				<p align="justify"><b><em>Username</em>: <?php echo $user_login ?></b></p>
				<p align="justify"><b><em>Email</em>: <?php echo $user_email ?></b></p>
			</div>
	</body>
</html>

<?php
$mensaje_correo = ob_get_contents();
ob_end_clean(); 

wp_mail(get_option('admin_email'), $subject, $mensaje_correo );

}  }

?>
