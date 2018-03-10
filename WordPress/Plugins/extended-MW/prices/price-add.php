<?php
class price_add {
	
	private $_price, $_page;
	
	public function __construct($npages, $pcase) {
		
switch ($pcase) {
		case 'ml': $price = 450; $page = 'multi-language-prices'; break;
		case 'wp': $price = 450; $page = 'wordpress-prices'; break;
		case 'seo': $price = 390; $page = 'seo-prices'; break; }
	
	// Price adds	
	($npages > 3) ? $npages_ad = ($_POST['npages'] - 3) * 50 : $npages_ad = 0;
	(filter_has_var(INPUT_POST, 'nsite')) ? $nsite_ad = $_POST['nsite'] : $nsite_ad = 0;
	(filter_has_var(INPUT_POST, 'posting')) ? $posting_ad = $_POST['posting'] : $posting_ad = 0;
	(filter_has_var(INPUT_POST, 'npics')) ? $npics_ad = $_POST['npics'] : $npics_ad = 0;
	(filter_has_var(INPUT_POST, 'smedia')) ? $smedia_ad = $_POST['smedia'] : $smedia_ad = 0;
	(filter_has_var(INPUT_POST, 'ecommerce')) ? $ecommerce_ad = $_POST['ecommerce'] : $ecommerce_ad = 0;
	(filter_has_var(INPUT_POST, 'cphp')) ? $cphp_ad = $_POST['cphp'] : $cphp_ad = 0;
	
	$this->_price = $price + $npages_ad + $nsite_ad + $posting_ad + $npics_ad + $smedia_ad + $ecommerce_ad + $cphp_ad;
	$this->_page = $page;
	}
	
	public function __toString()
    {
        return $this->_page;
    }
    
    public function get_page() {
    return $this->_page; }
	
	public function get_price() {
    return $this->_price; }
	
}