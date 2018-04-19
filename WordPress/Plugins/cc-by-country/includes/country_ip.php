<?php

class country_ip {
    private $_c2;
    
    public function __construct() {
    
       // Selecting c2
		if(filter_has_var(INPUT_POST, 'country2')) { // Selection by form
			$this->_c2 = filter_input(INPUT_POST, 'country2'); 
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
          $ip_request = wp_remote_get("http://ip-api.com/json/".$ip);
           $ip_data = json_decode(wp_remote_retrieve_body($ip_request));
           $this ->_c2 = isset($ip_data->countryCode) ? $ip_data->countryCode : "US";           
	}
    }
     
    public function getC2() {
    return $this->_c2; }
}
