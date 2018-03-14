<?php
class GetJscc {
   private $_data;
      
    public function __construct($var, $c3) {
        
        
            $inicio = array('2020', '2040', '2060', '2080');
            $fin = array('2039', '2059', '2079', '2099');
            $data = array();
            
            $dataTable = array(
                'cols' => array(
                array('type' => 'string', 'label' => 'Period', 'id' => ''),
                array('type' => 'number', 'label' => 'A2', 'id' => ''),
                array('type' => 'number', 'label' => 'B1', 'id' => ''),
                   )
                );
            
            unset($data);
    
            for ($i = 0; $i<4; $i++) { // Calcula los periodos
            $url = "http://climatedataapi.worldbank.org/climateweb/rest/v1/country/annualanom/ensemble/50/".$var."/".$inicio[$i]."/".$fin[$i]."/".$c3;
            $jsonf = file_get_contents($url);
            $json = json_decode($jsonf);
            
            
                foreach ($json as &$caso) {
                    $sc = $caso->scenario;
                    switch ($sc) {
                        case 'a2': $data['A2'][$i] = $caso->annualVal;
                            break;
                        case 'b1': $data['B1'][$i] = $caso->annualVal;
                            break;
                    }
               }
    
         
            $dataTable['rows'][] = array(
            'c' => array (
                    array('v' => $inicio[$i]."-".$fin[$i]), 
                    array('v' => $data['A2'][$i]),
                    array('v' => $data['B1'][$i])
                          )
        );
             }

       $this->_data = $dataTable;
       
        }
        
    public function getDat () {
        return $this->_data;
    }
    
    
   }
