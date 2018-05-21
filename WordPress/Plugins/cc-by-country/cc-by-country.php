<?php

/*
Plugin Name: cc-by-country
Plugin URI: 
Description: Observed by-country changes in temperatures and precipitations 
Version: 1.0.0
Author: ClimaRisk
Author URI: www.climarisk.com
License: GPLv2
*/

function cc_by_c_scripts() {
wp_register_script( 'gct', plugin_dir_url( __FILE__ ) .  '/includes/js/gct.js');
}
add_action('template_redirect', 'cc_by_c_scripts');

// Loading the translation files
add_action( 'plugins_loaded', 'cc_by_country_load_textdomain' );
function cc_by_country_load_textdomain() {
  load_plugin_textdomain( 'cc-by-country', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

// GCT function
        add_action( 'wp_ajax_gt', 'gt' );//admin
        add_action('wp_ajax_nopriv_gt', 'gt');//frontend
    function gt() {
        include_once 'includes/getjtc.php';
        $c3 = $_GET['c3'];
        $jsond = array();
        $jsct = new gct('tas', $c3);
        $jsond['tas'] = $jsct->getgtc();
        $jscp = new gct('pr', $c3);
        $jsond['pr'] = $jscp->getgtc();
        $jsond['prt'] = __('Precipitation', 'cc-by-country');
        $jsond['tast'] = __('Temperature', 'cc-by-country');
        $jsond['tity'] = __('Year', 'cc-by-country');
        wp_send_json(json_encode($jsond));
    }
   
//Creating the shortcode and showing the graphs
function cc_bc_gc ($atts) {
    
    function get_f_content( $file_path ) {
        ob_start();
        include $file_path;
        $contents = ob_get_clean();
    return $contents;
    }

$precv = array ('prec', 'Prec', 'pr', 'Precipitation');
 
$atts = shortcode_atts( // Defaults include trends and links to ClimaRisk post 
        ['ctitle' => 'true', // Including a title - Default true
	 'cclink' => 'true', // Including a link to Climaisk post - Default true
         'ctemp' => 'true', // Including the Temperature chart - Default true
         'cprec' => 'true', // Including the Precipitation chart - Default true
                        ], $atts, 'cc-by-country' );
		
	//Shortcode options
	$ctitle = ($atts['ctitle'] === false) ? 'false' : $atts['ctitle'];
	$cclink = ($atts['cclink'] === false) ? 'false' : $atts['cclink'];
        $ctemp = ($atts['ctemp'] === false) ? 'false' : $atts['ctemp'];
        $cprec = ($atts['cprec'] === false) ? 'false' : $atts['cprec'];
        
        
                
//$mvar = 'tas';
// Selecting c2
if (filter_input(INPUT_POST, 'country2')) $c2 = $_POST['country2'];  else  {
    include_once "includes/country_ip.php";
    $c2d = new country_ip();
    $c2 = $c2d->getC2(); }

// Estimating c3
    include_once 'includes/convC3.php';
    $c3d = new convC3($c2);
    $c3 = $c3d->getC3($c2);
                


include_once "includes/cctitle.php";
  $sci = '<div class="row"><div class="col-md-8">';
  $sci .= new cctitle($c2, $c3);
  $sci .= '</div><div class="col-md-4">';
    if ($cclink != 'false') { //Not set false the link
	$clink = 'http://climarisk.com/'. __("en/climate-change-effects-country/", "cc-by-country");
        $infop = plugin_dir_url( __FILE__ ).'img/icon_info.gif';
	$sci .= '<a href="'.$clink.'" target="_blank">
	<img class="align-top" src="'.$infop.'">'.__("More information", "cc-by-country").'</a>';
	}
	$sci .= '</div></div>';
                
    // Enqueue the registered scripts and draw
        wp_enqueue_script('google-jsapi','https://www.google.com/jsapi'); 
        wp_enqueue_script( 'gct' );   
    // Form    
        $scf = '<form id="fms" class="form-inline" method="POST" action="'.get_permalink().'#ccg"><div class="form-group">';
        $scf .= '<select class="custom-select" id="country2" name="country2"><option selected value="US">'.__('Select another country....', 'cc-by-country').'</option>';
        $scf .= get_f_content('includes/country_select.html');
        $scf .= '</div><button type="submit" class="btn btn-primary ml-1">'.__("Submit", "cc-by-country").'</button>';
        $scf .= '</form>';
        
    //Drawing charts
            $gc = '<div id="bgc"><h4>'.__('Drawing the charts', 'cc-by-country').'.....</h4></div>';
            if ($ctemp != 'false' or $cprec === 'false') {
            $gc .= '<div id = "gctas"></div>'; }
            if ($cprec != 'false') {
            $gc .= '<div id = "gcpr"></div>'; }
            //$imess = ;
            wp_localize_script( 'gct', 'gct',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'c3' => $c3, 'fc' => $scf, 
                'ctemp' => $ctemp, 'cprec' => $cprec));
        
    
     $sf = '<div id="cf"></div>';  
    
       
return $sci.$gc.$sf;	
	
}  

add_shortcode('cc_by_country', 'cc_bc_gc')	;
