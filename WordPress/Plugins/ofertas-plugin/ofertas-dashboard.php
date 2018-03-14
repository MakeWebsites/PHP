<?php

function remove_dashboard_widgets() { // Elimina los widgets del menu 
	
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
}


add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


// Remove the pointer scripts
function tf_remove_pointer_scripts() {
	remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
}

add_action('admin_init', 'tf_remove_pointer_scripts');

	
function remove_oferta_fields() {
 	remove_meta_box( 'postcustom' , 'oferta' , 'normal' );
	remove_meta_box( 'empleodiv' , 'oferta' , 'side' );
	remove_meta_box( 'tagsdiv-trabajo-en' , 'oferta' , 'side' );
}
add_action( 'admin_menu' , 'remove_oferta_fields' );

// Removing the thunmbnail meta box
add_action('do_meta_boxes', 'remove_thumbnail_box');
function remove_thumbnail_box() {
    remove_meta_box( 'postimagediv','oferta','side' );
}

function hide_personal_options(){ // Elimina opciones personales del perfil
echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";
}
add_action('admin_head','hide_personal_options');

add_action( 'personal_options', array ( 'tf_Hide_Profile_Bio_Box', 'start' ) );

// Captures the part with the biobox in an output buffer and removes it.
class tf_Hide_Profile_Bio_Box
{

    public static function start()
    {
        $action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
        add_action( $action, array ( __CLASS__, 'stop' ) );
        ob_start();
    }

    /**
     * Strips the bio box from the buffered content.
     *
     * @return void
     */
    public static function stop()
    {
        $html = ob_get_contents();
        ob_end_clean();

        // remove the headline
        $headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
        $html = str_replace( '<h3>' . $headline . '</h3>', '', $html );

        // remove the table row
        $html = preg_replace( '~<tr>\s*<th><label for="description".*</tr>~imsUu', '', $html );
        print $html;
    }
}


add_filter('get_sample_permalink_html', 'perm_oferta'); // Remove the edit permalink button

function perm_oferta($return){
        $ret2 = preg_replace('/<span id="edit-slug-buttons">.*<\/span>|<span id=\'view-post-btn\'>.*<\/span>/i', '', $return);

    return $ret2;
}


function text_menu_inicio( $menu ) {

$menu = str_ireplace( 'Escritorio', 'Nueva Oferta', $menu );
$menu = str_ireplace( 'Tableau de bord', 'Nouvel Emploi', $menu );
$menu = str_ireplace( 'Dashboard', 'New Job', $menu );
    return $menu;
}

add_filter('gettext', 'text_menu_inicio');
add_filter('ngettext', 'text_menu_inicio');



function mytheme_admin_bar_render() { // Quita la opcion de nueva pagina y otras en la barra de admin
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('new-content');
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('site-name');
	$wp_admin_bar->remove_node('comments');
	
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


add_action( 'admin_menu', 'remove_menu_ofertas'); // Quita todo el menu ofertas

	function remove_menu_ofertas() {
		//remove_menu_page('edit.php?post_type=oferta');
		remove_menu_page('edit.php');
		remove_menu_page('upload.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('edit.php?post_type=gallery');	
		remove_menu_page('tools.php');
		remove_menu_page('link-manager.php');
		
	}


add_action( 'admin_head', 'cpt_icons' );

function tf_remove_columns( $oferta_columns ) {
    unset( $oferta_columns['empleos'] );

    return $oferta_columns;
}

add_filter( 'manage_oferta_posts_columns', 'tf_remove_columns' );

function cpt_icons() {
    }



function hide_buttons() // Esconde la opcion de addnew en Editar oferta
{
  global $current_screen;
  
  echo '<style>.add-new-h2{display: none;}</style>';  
  
}
add_action('admin_head','hide_buttons');



function remove_screen_options(){ // Elimina las opciones de pantalla
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options');


function recruiter_redirect( $redirect_to, $request, $user ){
    return admin_url('index.php');
}
add_filter("login_redirect", "recruiter_redirect", 10, 3);

// Quita los mensajes de actualización de wordpress
add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );




