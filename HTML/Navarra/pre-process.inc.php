<?php
function ademas ($casod) {

switch ($casod) {

	case 'Todos los datos':
        $adem = "";
		break;
	case 'Zonas Vulnerables a Nitratos':
	// Se ha seleccionado por zona vulnerable
		$zns = $_SESSION['zns'];
		switch ($zns) {
    		case 'Ebro Tudela Alagon':
				$adem = " and `ZNV` = 'Ebro Tudela_Alag'";
				break;
			case 'Rioja Mendavia':
				$adem = " and `ZNV` = 'Rioja_Mendavia'";
				break;
			case 'Cidacos':
				$adem = " and `ZNV` = 'Cidacos'";
				break;
			case 'Zonas no vulnerables':
				$adem = " and `ZNV` = 'NO'";
				break; 	}
		break;
	case 'Sectores':
	// Se ha seleccionado por zona vulnerable
		$sector = $_SESSION['sector'];
		switch ($sector) {
    		case 1:
				$adem = " and `Sector` = 1";
				break;
			case 2:
				$adem = " and `Sector` = 2";
				break;	
			case 3:
				$adem = " and `Sector` = 3";
				break;
			case 4:
				$adem = " and `Sector` = 4";
				break;	
			case 5:
				$adem = " and `Sector` = 5";
				break;
			case 6:
				$adem = " and `Sector` = 6";
				break;			
				}
		break;
} // Fin del switch casod	

return $adem; } // Fin de function adem

function mensz ($casod) {

switch ($casod) {

	case 'Todos los datos':
		$mensz = ' toda la zona de estudio';
        break;
	case 'Zonas Vulnerables a Nitratos':
	// Se ha seleccionado por zona vulnerable
		$zns = $_SESSION['zns'];
		switch ($zns) {
    		case 'Ebro Tudela Alagon':
				$mensz = ' la zona vulnerable a nitratos de Ebro Tudela Alagon';
				break;
			case 'Rioja Mendavia';
				$mensz = ' la zona vulnerable a nitratos de Rioja Mendavia';
				break;
			case 'Cidacos':
				$mensz = ' la zona vulnerable a nitratos de Cidacos';
				break;
			case 'Zonas no vulnerables':
				$mensz = ' las parcelas que no est&aacute;n dentro de zonas vulnerables a nitratos';
				break; 	}
		break;
	case 'Sectores':
	// Se ha seleccionado por zona vulnerable
		$sector = $_SESSION['sector'];
		switch ($sector) {
    		case 1:
				$mensz = ' sector Viana-Mendavia';
				break;
			case 2:
				$mensz = ' sector Lodosa-Azagra';
				break;	
			case 3:
				$mensz = ' sector Azagra-Tudela';
				break;
			case 4:
				$mensz = ' sector Aluvial Arag&oacute;n';
				break;	
			case 5:
				$mensz = ' sector Tudela-Cortes';
				break;
			case 6:
				$mensz = ' sector Cidacos';
				break;			
				}
		break;
} // Fin del switch casod	

return $mensz } // Fin de function adem

function datcult ($nomt, $cropn) {
global $wpdb;
$dcults = array();
$meses = array("oct", "nov", "dic", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep");

$dcs = $wpdb->get_results ('SELECT * FROM `'.$wpdb->prefix . $nomt.'` where `idc`= "'.$cropn'"');

	foreach ($meses as $mes)
	$dcults[$mes] = $dcs->$mes;
	
	if (isset($dcs->frecuencia))
	$dcults['f'] = $dcs->frecuencia;
	
return $dcults; } // Fin de la funcion datcult
	


