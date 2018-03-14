<?php
class gcm { 
    private $_titlect;
    private $_dmv;
    
public function __construct($c3, $mvar) {

    switch ($mvar){
        case 'tas': $title = __('Temperature', 'cc-by-country').' (&deg;C)';
                    $fd = 'getDatct.php';				
            break;
        case 'pr': $title = __('Precipitation', 'cc-by-country'). ' (mm)';
                   $fd = 'getDatcp.php';
            break;
    }
    $dmv = 'c'.$mvar;
  $this->_dmv = $dmv;
  $xtitle = __('Year', 'cc-by-country');
  
  $fd = plugin_dir_url( __FILE__ ) . 'gDat/'.$fd;
	wp_enqueue_script('charts', 'https://www.gstatic.com/charts/loader.js' );
	wp_enqueue_script('gcm', plugin_dir_url( __FILE__ ) . 'js/gcm.js');
    wp_localize_script('gcm', 'gcmv', array( 'mtitle' => $title, 'fd' => $fd, 'dmv' => $dmv, 'xtitle' => $xtitle ));
	
}
    
    public function gDmv () {
        return $this->_dmv;
    }
    
    public function gTitlect () {
        return $this->_titlect;
    }
}
