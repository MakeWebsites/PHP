<?php
/*
Plugin Name: CC-by-country
Description: Shows Google charts of anual temperature and precipitations during last century, as well as future changes
according to A2 and B1 scenarios
Version: 1.0
Author: ClimaRisk
License: GPLv2
*/

session_start();

function cc_by_c_scripts() {
wp_register_script( 'ajax_google', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
wp_register_script( 'cc_bc', plugin_dir_url( __FILE__ ) .  'includes/js/cc-bc.js'); }

add_action('template_redirect', 'cc_by_c_scripts');

// Loading the translation files
add_action( 'plugins_loaded', 'cc_by_country_load_textdomain' );
function cc_by_country_load_textdomain() {
  load_plugin_textdomain( 'cc-by-country', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

//Creating the shortcode and showing the graphs
function showg ($atts) {
	
	// Enqueue the registered scripts
	wp_enqueue_script('ajax_google');
	wp_enqueue_script('cc_bc');
	
	$atts = shortcode_atts( // Defaults include trends and links to ClimaRisk post 
		array(
			'trend' => 'true', // Including the tren chart - Default true
			'ccchart' => 'true', // Including the Climate change chart - Default true
			'cclink' => 'true' // Including a link to Climaisk post - Default true
		), $atts, 'cc-by-country' );
		
		//Shortcode options
		($atts['trend'] == false) ? $trend = 'false' : $trend = $atts['trend'];
		($atts['ccchart'] == false) ? $ccchart = 'false' : $ccchart = $atts['ccchart'];
		($atts['cclink'] == false) ? $cclink = 'false' : $cclink = $atts['cclink'];
		
		include_once "includes/country_ip.php";
		// Selecting c2
		if(filter_has_var(INPUT_POST, 'country2')) { // Selection by form
			$c2 = filter_input(INPUT_POST, 'country2'); 
			} 
		elseif (isset($_SESSION['c2'])) {
			$c2 = $_SESSION['c2'];
		}
		else { // Selection by IP
			$c2d = new country_ip();
			$c2 = $c2d->getC2(); } 
		    $_SESSION['c2'] = $c2;

		// Estimating c3
		if (!isset($_SESSION['c3']) or filter_has_var(INPUT_POST, 'country2')) {
		include_once 'includes/convC3.php';
		$c3d = new convC3($c2);
		$c3 = $c3d->getC3($c2);
		$_SESSION['c3'] = $c3; }
		else {
			$c3 = $_SESSION['c3'];
		}
		

	if(filter_has_var(INPUT_POST, 'mvar')) { // Selecting met var by form 
	$mvar = filter_input(INPUT_POST, 'mvar'); } 
	else
	$mvar = 'tas';

	include_once "includes/cctitle.php";
	$sci = '<div class="row"><div class="col-md-8">';
		$sci .= new cctitle($_SESSION['c2'], $_SESSION['c3'], $mvar);
		$sci .= '</div><div class="col-md-4">';
		if ($cclink != 'false') { //Not set false the link
		$clink = 'http://climarisk.com/'. __("en/climate-change-effects-country/", "cc-by-country");
		$sci .= '<a href="'.$clink.'" target="_blank">
		<img style="padding-right:1%" src="http://climarisk.com/en/wp-content/plugins/shortcodes-cr/img/icon_info.gif">'.__("More information", "cc-by-country").'</a>';
		}
		$sci .= '</div></div>';

	include_once "includes/gcm.php";
	include_once "includes/gcc.php";
	
	
	if ($trend != 'false') {	// Trend has not deselected	
		$gcm = new gcm($c3, $mvar); 
		$scm = '<h5>'. __('Trend in the last 100 years', 'cc-by-country') . '</h5>';
		$scm .= '<div id='.$gcm->gDmv().'></div>';
	}
	else $scm = "";
	
	if ($ccchart != 'false') {	// CC chart not deselected
		$gcc = new gcc($c3, $mvar);
		$scc = '<h5>'. __('Expected differences during this century according to A2 and B1 emission scenarios', 'cc-by-country').'</h5>';
		$scc .= '<div id='.$gcc->gDmv().'></div>';
	}
	else $scc = "";
	
	if (($trend == 'false') and ($ccchart == 'false')) {
		$scv = "<h4>".__("Please select any chart to display in the shortcode options", "cc-by-country")."</h4>";
		$scf = "";
;	}
	else {
		$scv = '<form id="fms" class="form-inline csub" method="POST" action="'.get_permalink().'#ccg"><div class="form-group">';
		if ($mvar == 'pr') {
		$scv .= '<label class="form-check-label">
		<input class="form-check-input csubm" type="radio" name="mvar" id="temp" value="tas">';
		$scv .= __('Select Temperature', 'cc-by-country');
		$scv .= '</label>';  }
		else {
		$scv .=  '<label class="form-check-label">
		<input class="form-check-input csubm" type="radio" name="mvar" id="prec" value="pr">';
		$scv .= __('Select Precipitation', 'cc-by-country');
		$scv .= '</label>'; }
		$scv .= '</form></br>';
		
		$scf = '<form class="form-inline" method="POST" action="'.get_permalink().'#ccg"><div class="form-group">';
		$scf .= '<select class="custom-select" id="country2" name="country2"><option selected>'.__('Select other country....', 'cc-by-country').'</option>';
		$scf .= file_get_contents(plugins_url( 'includes/country_select.php', __FILE__ ));
		$scf .= '</div><button type="submit" class="btn btn-primary">'.__('Submit', 'cc-by-country').'</button></form>';
	}
	

return $sci.$scm.$scc.$scv.$scf;
	
}

add_shortcode('cc_by_country', 'showg')	; 

function cr_unset_session() {
if (session_status() === PHP_SESSION_ACTIVE)
   session_unset;
} 
add_action('wp_logout', 'cr_unset_session');
