<?php
/*
Plugin Name: html-twinner
Description: Copy from/to WordPress posts to/from html files
Version: 1.0
Author: Make-Websites 
Author URI: http://make-websites.co.uk
License: GPLv2
*/

//Custom style
add_action( 'admin_enqueue_scripts', 'htmlt_style' );

function htmlt_style() {
	wp_register_style( 'htmlt-style', plugins_url('css/htmlt.css', __FILE__ ));
    wp_enqueue_style( 'htmlt-style' );
} 

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
		</div>
<?php	}

		function htmltd_create() { 
			if (isset($_POST['htmlt_file'])) { // Form to upload path ?>
				<form>
				<input type="file" name="file_d" />
				<input type="submit" name="select" value="Select Folder" />
				</form>
		<?php }
		else  // Path to file must be retrieved
			return $_FILES['file_d']['tmp_name'];
		}
		
add_action( 'add_meta_boxes', 'htmlt_create' ); // Creating the metabox at each post or page to process data and start copying/pasting

function htmlt_create() { //create the meta box
	add_meta_box( 'htmlt-meta', 'HTML twinner', 'htmlt_mbf', array('page', 'post'), 'normal', 'high' );
}

function htmlt_mbf( $post) {
 $optn = 'html_twinner_path';

// Path to file 
$htmlt_d = get_option($optn); //retrieve the plugin option

	$mesd = (empty($htmlt_d))? "Create " : "Edit "; // Directory exists or not
	
	echo 'Path directory to create HTML file with post content or to retrieve post content from:';
	?>
	<p>Current Path: <?php if (!empty ($htmlt_d)) echo esc_attr( $html_d ); else echo " <span class='errorm'>Empty path settings</span> ";
	if (user_can('manage_options') { // Gives to user the option to create or to change the path
	echo '<a class="boton" href="'.pugins_url().'html-twinner"'.$mesd.'>Path in the Plugin seetings options</a>';
	}
	
		elseif (empty($htmlt_d) || !is_dir($htmlt_d)) { // User can't access to plugin administration and htmld does not exists or not valid. Create an alternative directory
			$html_d = 'C:\\HTML-twinner\\'.bloginfo('name');
		mkdir($htmlt_d); }
	 
	
	update_option ($optn, $htmlt_d); // Updates plugin option with new directory
	//$htmlt_path = $htmlt_d.$post->post_title.'.html'; // Path to file to copy to/from 
	
}


function html_fc() { //Saves the WP post-page content in a file named according to the post-page title
$post = get_post();
	$fn = fopen("C:\\Users\\AUtset\\OneDrive\\Make-Websites\\MW-GitHub\\Prueba-html\\".$post->post_title.'.html', "w+" );
	fwrite($fn, $post->post_content );
	fclose($fn);
}
add_action( 'save_post', 'html_fc' );


?>
