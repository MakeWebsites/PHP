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
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'); // Registering Google lib
	wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'); // Registering Bootstrap 4
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	wp_enqueue_script( 'mw-js', get_stylesheet_directory_uri().'/mw.js');
	wp_enqueue_script( 'mw-ajax', plugin_dir_url( __FILE__ ).'prices/ajax-prices.js');
	//wp_localize_script( 'mw-ajax', 'mw', $ajax_params);
	wp_enqueue_style( 'mw-css', get_stylesheet_directory_uri().'/mw.css');
	/*wp_enqueue_script('bootstrap_validator_js', '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js');
	wp_enqueue_style('bootstrap_validator_css', '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css');*/
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
<div class="pt-1">
<a href="<?php site_url() ?>/contact/" title="Contact Make-Websites team">
	<img  class="img-fluid float-left align-middle" src="<?php site_url() ?>/images/make-websites.png" 
		alt="Make Websites: Customizing WordPress" width="75px"></a>
	<a href="http://es.make-websites.co.uk/"> <img class="img-fluid float-right align-top" src="http://make-websites.co.uk/images/es.png" 
		alt="Make-Websites en español" title="Make-Websites en español"></a>
</div>
	 <?php
}

//* Customize the Genesis credits and footer
add_filter( 'genesis_footer_creds_text', 'mw_footer_creds_text' );
function mw_footer_creds_text() { ?>
	<div class="row">
	<div class="col-7">
	<div class="creds"><p>
	<?php echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot'; ?> <a href="http://make-websites.co.uk" title="Customizing WordPress Websites">Make Websites</a>
	</p></div></div>
	<div class="col-5">
	<a href="mailto:we@make-websites.co.uk" title="Write us"><img class="img-fluid float-right" src="<?php site_url() ?>/images/email-mw.gif" 
		alt="Make Websites: Write us" width="300px"></a></div></div> <?php
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

// Processing the prices forms
add_action( 'wp_ajax_mw_prices_form', 'mw_prices_form' );
add_action( 'wp_ajax_nopriv_mw_prices_form', 'mw_prices_form' );
function mw_prices_form() {
	$response = array();
	$response['error'] = false;
    
		if (!is_numeric($_POST['npages']) or intval($_POST['npages']) != $_POST['npages']) {
		$response['error'] = true;
    	$response['error_message'] = 'Number of pages must be an integer number'; }
 	
		elseif ($_POST['npages'] > 10 or $_POST['npages'] < 3) {
		$response['error'] = true;
    	$response['error_message'] = 'Number of pages must be between 3 and 10';
		}
	
		else {
		include_once plugin_dir_path( __FILE__ ).'prices/price-add.php';
		$npages = $_POST['npages'];
		$pcase = $_POST['pcase'];
		$response['pcase'] = $pcase;
		$np = new price_add($npages, $pcase);
		$response['price'] = $np->get_price();
		}

    wp_send_json(json_encode($response));
}

?>