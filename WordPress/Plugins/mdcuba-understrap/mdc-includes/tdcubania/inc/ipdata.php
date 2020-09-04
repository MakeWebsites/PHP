<?php

include_once 'curlexec.php';

class ipdata {
    private $_ip;
	private $_country;
    private $_region;
    private $_city;
    
        
    public function __construct() {
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
            $this->_ip = $ip;
            //Obtaining ipdata from ipstack
           $url = "http://api.ipstack.com/".$ip."?access_key=8c5501598df9076e1df4a58f30373fe5";
           $ip_dat = new curlexec($url);
           $ip_dat = $ip_dat->get_res();
           $this ->_country = isset($ip_dat->country_code) ? $ip_dat->country_code : "0";
           $this ->_region = isset($ip_dat->region_code) ? $ip_dat->region_code : "0";
           $this ->_city = isset($ip_dat->city) ? $ip_dat->city : "0";                
        } 
     
    public function gip() {
    return $this->_ip; }
	
	public function gcountry() {
    return $this->_country; }
    
    public function gregion() {
    return $this->_region; }
    
    public function gcity() {
    return $this->_city; }   
}

