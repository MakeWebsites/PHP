<?php
session_start();

function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
} // Fin de la funcion 


	if (!isset($_SESSION['pais']))
	$_SESSION['pais'] = $_POST['pais'];
	else {
		if (!isset($_SESSION['lugar']))
		$_SESSION['lugar'] = $_POST['lugar'];
				else {
						if (!isset($_SESSION['categoria'])) 
						$_SESSION['categoria'] = $_POST['categoria'];
						else {
						if (!isset($_SESSION['freekeyw'])) {
						if (strlen($_POST['freekeyw'])<31)
						$_SESSION['freekeyw'] = $_POST['freekeyw'];
						else
						$_SESSION['mens'] = 'fkw'; }
							else {
							if (!isset($_SESSION['salario'])) {
								if (ctype_digit($_POST['salario']))
								$_SESSION['salario'] = $_POST['salario']; 
								else
								$_SESSION['mens'] = 'sal'; }
								else  {
								if (!isset($_SESSION['descripcion'])) 
								$_SESSION['descripcion'] = $_POST['descripcion'];
									else  {
									if (!isset($_SESSION['contacto'])) 
									$_SESSION['contacto'] = $_POST['contacto'];
										else {
										if (!isset($_SESSION['email'])) {
										if (check_email_address($_POST['email']))
										$_SESSION['email'] = $_POST['email']; 
										else
										$_SESSION['mens'] = 'eml'; }
											else {
											if (!isset($_SESSION['publicar']))
											$_SESSION['publicar'] = $_POST['publicar'];
			}}}}}}}}

header ("location:".$_SESSION['url_ofertas']."/wp-admin/index.php"); 
?>
