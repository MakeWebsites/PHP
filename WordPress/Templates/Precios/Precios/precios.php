
<?php

if (is_page(257)) // SEO updating required
require('servicio-seo.php');
	elseif (is_page(259))  // Spanish website required
	require('ingles-w.php'); 
		elseif (is_page(455))  // Wordpress website required
		require('wp-w.php'); 


?>