<?php

class cctitle {
    private $_cct;
    
    public function __construct($c2, $c3, $mvar) {
	
    $flag = plugins_url( 'banderas/'.strtolower ($c2).'.png', __FILE__ );
		switch ($mvar) {
		case 'tas': $metv = __("Temperature", 'cc-by-country');
					break;
		case 'pr':  $metv = __("Precipitation", 'cc-by-country');
					break;
			}
	$cct = '<h3>'.__('Climate Data for ', 'cc-by-country').$c3.'<img style="padding-left:1%; margin-top:-1%" src="'.$flag.'"/></h3>';
	$cct .= '<h4>'.$metv.'</h4>';
	$this ->_cct = $cct;
	}
	
	public function __toString()
    {
        return $this->_cct;
    }
	
}