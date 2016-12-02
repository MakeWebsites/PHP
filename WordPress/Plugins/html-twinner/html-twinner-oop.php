<?php
/*
Plugin Name: html-twinner
Description: Copy from/to WordPress posts to/from html files
Version: 1.0
Author: Make-Websites 
Author URI: http://make-websites.co.uk
License: GPLv2
*/


include_once('/classes/htmlt_loader.php');




//Creating the plugin menu
add_action( 'admin_menu', 'htmlt_menu' );
function htmlt_menu() {
	//Create submenu under Settings
	add_options_page('HTML Twinner Options','HTML twinner','manage_options','HTML-twinner-settings.php', 'htmlt_settings_page');
}
	function htmlt_settings_page () {
		?>
		<h1 class="boton">HTML Twinner Options</h1>
		<p>Path directory to create HTML file with post content or to retrieve post content from</p>
		<form>Current Path: <input <input type="text" name="htmltd" size="110">
		<input type="submit" value="Submit">
		</form>
<?php	}

		function htmltd_create() { 
			if (isset($_POST['htmlt_file'])) { // Form to upload path ?>
				<form action="options.php">
				<input type="file" name="file_d" />
				<input type="submit" name="select" value="Select Folder" />
				</form>
		<?php }
		else  // Path to file must be retrieved
			return $_FILES['file_d']['tmp_name'];
		}
		



function html_fc() { //Saves the WP post-page content in a file named according to the post-page title
$post = get_post();
	$fn = fopen("C:\\Users\\AUtset\\OneDrive\\Make-Websites\\MW-GitHub\\Prueba-html\\".$post->post_title.'.html', "w+" );
	fwrite($fn, $post->post_content );
	fclose($fn);
}
add_action( 'save_post', 'html_fc' );


?>
