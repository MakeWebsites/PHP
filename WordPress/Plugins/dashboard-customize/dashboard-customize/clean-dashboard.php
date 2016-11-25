<?php

function mw_usern(){
    $user = wp_get_current_user();
    return $user->display_name;
}

add_action( 'admin_title' , 'change_dashboard_title' );
function change_dashboard_title( $admin_title) {
	global $current_screen;
	global $title;
	$usern = mw_usern();
	if( $current_screen->id != 'dashboard' ) {
			return $admin_title; }
	$change_title = __( 'Dashboard' ).' '.__('for').' '.$usern;
	
	$title = $change_title;
 
	$admin_title = str_replace( __( 'Dashboard' ) , $change_title , $admin_title );
 
return $admin_title; }
	

// Delete the Wordpress Welcome message
remove_action('welcome_panel', 'wp_welcome_panel');

/*  //Custom welcome panel
function mw_welcome_panel($usern) {
echo
'<div class="welcome-content">'
.'<h3>Welcome '.$usern->display_name.'</h3>'.'</div>';
} 

add_action('welcome_panel','mw_welcome_panel'); */

function remove_dashboard_widgets() { // Delete menu widgets 
	
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
    remove_meta_box('dashboard_right_now', 'dashboard', 'core');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
    remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal;'); 
    remove_meta_box('blc_dashboard_widget', 'dashboard', 'normal;'); 
    remove_meta_box('powerpress_dashboard_news', 'dashboard', 'normal;');
    // disable Simple:Press dashboard widget
    remove_meta_box('sf_announce', 'dashboard', 'normal');
	
	echo '<style>	.metabox-holder .postbox-container .empty-container { border: 0 !important } 	</style>';
	echo '<style>   div#dashboard-widgets .empty-container {     display: none !important; } </style>';
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


// Remove the pointer scripts
function remove_pointer_scripts() {
	remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
}

add_action('admin_init', 'remove_pointer_scripts');

	
function hide_personal_options(){ // Delete personal option in profile
echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";
}
add_action('admin_head','hide_personal_options');

add_action( 'personal_options', array ( 'Hide_Profile_Bio_Box', 'start' ) );

// Captures the part with the biobox in an output buffer and removes it.
class Hide_Profile_Bio_Box
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


function mytheme_admin_bar_render() { // Delete the page options
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('new-content');
	$wp_admin_bar->remove_node('wp-logo');
	//$wp_admin_bar->remove_node('site-name');
	$wp_admin_bar->remove_node('comments');
	
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


function remove_screen_options(){ // Elimina las opciones de pantalla
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options');


// Delete the wordpress updating messages
add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );

function change_admin_footer(){
	 echo '<span id="footer-note">Thanks for working with <a href="http://www.make-websites.co.uk/" target="_blank">Make-Websites</a>.</span>';
	}
add_filter('admin_footer_text', 'change_admin_footer');


?>