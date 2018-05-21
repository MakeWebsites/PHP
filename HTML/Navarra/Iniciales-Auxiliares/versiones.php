/*switch ($cropn) {

case acelga:
$fs = "01-mar-";
$fc = "25-may-";
$cropr = 50;
case ajo:
$fs = "10-feb-";
$fc = "20-jul-";
$cropr = 50;
case albaricoquero:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Alcachofa:
$fs = "01-aug-";
$fc = "30-jun-";
$cropr = 50;
case alfalfa:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 50;
case Almendro:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case apio:
$fs = "15-sep-";
$fc = "05-mar-";
$cropr = 50;
case Arroz:
$fs = "01-may-";
$fc = "30-sep-";
$cropr = 30;
case avena:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case Berenjena:
$fs = "01-may-";
$fc = "30-sep-";
$cropr = 50;
case berza:
$fs = "01-aug-";
$fc = "31-dec-";
$cropr = 30;
case Broculi:
$fs = "01-feb-";
$fc = "31-may-";
$cropr = 30;
case Calabazaycalabacin:
$fs = "01-may-";
$fc = "31-aug-";
$cropr = 50;
case Cardo:
$fs = "01-jun-";
$fc = "31-mar-";
$cropr = 50;
case Cebada:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case cebolla:
$fs = "01-feb-";
$fc = "30-sep-";
$cropr = 30;
case cebolleta:
$fs = "01-feb-";
$fc = "30-sep-";
$cropr = 30;
case centeno:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case cerezo:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case ciruelo:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Coliflor:
case Colyrepollo:
case escarola:
case Esparrago:
case espinaca:
case girasol:
case Guisanteseco:
case Guisantesverdes:
case Habassecas:
case Habasverdes:
case judiassecas;:
case Judiasverdes:
case lechuga:
case Maizgrano:
case manzano:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case melocotonero:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case melon:
case membrillero:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case nispero:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case No_aplica:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 20;
case nogal:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Olivar(aderezo):
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Otrasgramineas:
case otrashortalizas:
case otrasleguminosas:
case otros:
case otroscereales:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case otrosfrutales:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case otrostubeculos:
case Pastico_lechuga:
case Pastico_tomate:
case Patata:
case Peral:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Pimiento:
case Plastico_guindilla:
case Plastico_otrashortalizas:
case puerro:
case remolacha:
case sorgo:
case Tomate:
case trigoblando:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case trigoduro:
$fs = "10-nov-";
$fc = "30-jun-";
$cropr = 50;
case triticale:
case Uvademesa:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case Uvaparavino:
$fs = "01-jan-";
$fc = "31-dec-";
$cropr = 300;
case vezaforrajera:
case vezagrano:
case zanahoria:
*/

/*function asig_fc($cropn, $year) { // Asigna la fecha de siembra

$years = $year;
$yeara = $year - 1;

$cult_anual = array("albaricoquero", "Almendro", "cerezo", "ciruelo", "manzano", "melocotonero", "Olivar(aderezo)", "otrosfrutales", "Peral", "Uvaparavino", "Uvademesa", "Alfalfa");

$c_inv = array("avena", "Cebada", "centeno", "otroscereales", "trigoblando", "trigoduro");

$veg = array("Broculi", "lechuga", "otrashortalizas", "Colyrepollo");

$c_ver = array("Maizgrano", "Otrasgramineas", "sorgo", "Tomate", "Pastico_tomate");

if (in_array($cropn, $cult_anual))
$fc = "01-jan-" . strval($years); //Cultivo anual
	elseif (in_array($cropn, $c_inv))
	$fc = "01-nov-" . strval($yeara); //año anterior
		elseif (in_array($cropn, $veg))
		$fc = "01-feb-" . strval($years);
			elseif (in_array($cropn, $c_ver))
			$fc = "01-may-" . strval($years);
				else
				switch ($cropn) {
				case "Alcachofa":
				$fc = "01-aug-" . strval($yeara); //año anterior
				case "Espárrago":
				$fc = "01-jun-" . strval($years);
				case "otrostubérculos":
				case "Patata":
				$fc = "01-mar-" . strval($years); } // Fin del switch

return $fs; } // Fin de asig_fs

function asig_fc($cropn, $year) { // Asigna la fecha de siembra

$years = $year;

$cult_anual = array("albaricoquero", "Almendro", "cerezo", "ciruelo", "manzano", "melocotonero", "Olivar(aderezo)", "otrosfrutales", "Peral", "Uvaparavino", "Uvademesa", "Alfalfa");

$c_inv = array("avena", "Cebada", "centeno", "otroscereales", "trigoblando", "trigoduro");

$veg = array("Broculi", "lechuga", "otrashortalizas", "Colyrepollo");

$c_ver = array("Maizgrano", "Otrasgramineas", "sorgo", "Tomate", "Pastico_tomate");

if (in_array($cropn, $cult_anual))
$fc = "31-dec-" . strval($years); //Cultivo anual
	elseif (in_array($cropn, $c_inv))
	$fc = "30-jun-" . strval($years); //año anterior
		elseif (in_array($cropn, $veg))
		$fc = "30-may-" . strval($years);
			elseif (in_array($cropn, $c_ver))
			$fc = "30-sep-" . strval($years);
				else
				switch ($cropn) {
				case "Alcachofa":
				$fc = "30-jun-" . strval($yeara); //año anterior
				case "Espárrago":
				$fc = "30-oct-" . strval($years);
				case "otrostubérculos":
				case "Patata":
				$fc = "31-aug-" . strval($years); } // Fin del switch

return $fc; } // Fin de asig_fc*/