<?php
class gct {
   private $_data;
   
    public function __construct($var, $c3) {
    $url = "http://climatedataapi.worldbank.org/climateweb/rest/v1/country/cru/".$var."/year/".$c3;
    $jsonf = wp_remote_retrieve_body( wp_remote_get($url)); // 
    $json = json_decode($jsonf); 
	

    $dataTable = array(
        'cols' => array(
             array('type' => 'number', 'label' => '', 'id' => ''), 
             array('type' => 'number', 'label' => '', 'id' => '')
        )
    );
        foreach ($json as $caso) { 
            $dataTable['rows'][] = array(
            'c' => array (
                 array('v' => $caso->year), 
                 array('v' => $caso->data)
             )
        );
       $this->_data = $dataTable;
       
        }
    }
    
    public function getgtc () {
        return $this->_data;
    }
   }
