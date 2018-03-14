<?php

class country_ip {
    private $_c2;
    
    public function __construct() {
    
       // Selecting c2
		if(filter_has_var(INPUT_POST, 'country2')) { // Selection by form
			$this->_c2 = filter_input(INPUT_POST, 'country2'); 
			} 
		elseif (isset($_SESSION['c2'])) {
			$this->_c2 = $_SESSION['c2'];
		}
		else { // Selection by IP 
            //Obtaining ip
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = @$_SERVER['REMOTE_ADDR'];
                if(filter_var($client, FILTER_VALIDATE_IP)){
                $ip = $client;
                }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
                $ip = $forward;
                }else{
                $ip = $remote;
                 }
            
            //Obtaining country from geoplugin
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
            $c2p = $ip_data->geoplugin_countryCode;
        (isset ($c2p))? $this ->_c2 = $c2p : $this ->_c2 = "US";    }
	}
     
    public function getC2() {
    return $this->_c2; }
}
