<?php
class gcc { 
    private $_dmv;
    
public function __construct($c3, $mvar) {

    switch ($mvar){
        case 'tas': $title = __('Temperature', 'cc-by-country').' (&deg;C)';
                    $fd = 'getDatcct.php';
			break;
        case 'pr': $title = __('Precipitation', 'cc-by-country'). ' (mm)';
                   $fd = 'getDatccp.php';
			break;
    }
    $dmv = 'cc'.$mvar;
  $this->_dmv = $dmv;
  $xtitle = __('Period', 'cc-by-country');
  
  $fd = plugin_dir_url( __FILE__ ) . 'gDat/'.$fd;
	wp_enqueue_script('charts', 'https://www.gstatic.com/charts/loader.js' );
	wp_enqueue_script('gcc', plugin_dir_url( __FILE__ ) . 'js/gcc.js');
    wp_localize_script('gcc', 'gccv', array( 'mtitle' => $title, 'fd' => $fd, 'dmv' => $dmv, 'xtitle' => $xtitle));
     
    }
    
    public function gDmv () {
        return $this->_dmv;
    }
	
	public function gTitlect () {
        return $this->_titlect;
    }
    
}

