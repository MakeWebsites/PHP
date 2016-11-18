<?php
/*
Plugin Name: Extended-MW
Description: Extensions to MW Genesis sites
Version: 1.0
Author: Angel Utset
License: GPLv2
*/

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'mw_load_google_fonts' );
function mw_load_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}


//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://make-websites.co.uk" title="Affordable Multi Languaje Websites">Make Websites</a>';
	echo '</p></div>';
}

/** Load custom favicon to header */

add_filter( 'genesis_pre_load_favicon', 'custom_favicon_filter' );

function custom_favicon_filter( $favicon_url ) {

return get_stylesheet_directory_uri().'/images/make-websites-favicon.png';

}

function mw_login_logo() { // Customize login logo ?> 
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo-mw_fig.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'mw_login_logo' );

function mw_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'mw_login_logo_url' );

function mw_login_logo_url_title() {
    return 'Make Websites';
}
add_filter( 'login_headertitle', 'mw_login_logo_url_title' );

// HTML5
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );


?>