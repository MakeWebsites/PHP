<?php
/*
Plugin Name: Extended-MW
Description: Extensions to MW Genesis sites
Version: 1.0
Author: Make-Websites 
License: GPLv2
*/

//Registering bootstrap
function mw_registers () {
	wp_deregister_script('jquery'); //Deregister custom WordPress Jquery
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
	wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
	wp_enqueue_script( 'mw-js', get_stylesheet_directory_uri().'/mw.js');
	wp_enqueue_style( 'mw-css', get_stylesheet_directory_uri().'/mw.css');
}
add_action('wp_enqueue_scripts', 'mw_registers');

//Opening and closing Bootstrap container
add_action ('genesis_before', 'mw_open_container');
function mw_open_container() {
	echo '<div class="container">';
}
add_action ('genesis_after', 'mw_close_container');
function mw_close_container() {
	echo '</div>';
}

//Remove header
add_action('get_header', 'mw_remove_header');
function mw_remove_header() {
remove_action( 'genesis_header', 'genesis_do_header' );
}
//Custom header
add_action ('genesis_header', 'mw_custom_header');
function mw_custom_header() { ?>
<div style="padding:1%" class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<a href="<?php site_url() ?>/contact/" title="Contact Make-Websites team">
	<img  class="img-responsive pull-left" src="<?php site_url() ?>/images/make-websites.png" 
		alt="Make Websites: Customizing WordPress" width="80px"></a>
	<!--<h2><em><button type="button" style="margin-left:3px;" class="btn btn-success pull-left">We Make Websites</em></h2>-->
	<a href="mailto:we@make-websites.co.uk" title="Write us">
	<img  class="img-responsive pull-left" src="<?php site_url() ?>/images/email-mw.gif" 
		alt="Make Websites: Customizing WordPress" width="400px"></div></a>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	<a href="http://es.make-websites.co.uk/"> <img class="img-responsive pull-right" src="http://make-websites.co.uk/images/es.png" 
		alt="Make-Websites en español" title="Make-Websites en español"></a>
	</div>
</div> <?php
}

//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'mw_footer_creds_text' );
function mw_footer_creds_text() { ?>
	<div class="row">
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
	<div class="creds"><p>
	<?php echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot'; ?> <a href="http://make-websites.co.uk" title="Customizing WordPress Websites">Make Websites</a>
	</p></div></div>
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 pull-left">
	<a href="mailto:we@make-websites.co.uk" title="Write us"><img style="padding:3%;margin-top:-3%" class="img-responsive pull-right" src="<?php site_url() ?>/images/make-websites.png" 
		alt="Make Websites: Customizing WordPress" width="30%"></a></div></div> <?php
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

?>