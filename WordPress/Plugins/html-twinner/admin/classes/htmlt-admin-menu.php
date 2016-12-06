<?php

class htmlt_admin_menu {
	// Declaring private variables
	private $_htmltd;
	
	public function __construct() { // Hooks to create menu and register options 
	add_action('admin_menu', array($this, 'htmlt_menu'));
	add_action('admin_init', array($this, 'htmlt_admin_init'));
	}
	
	public function htmlt_menu() { // Adding the options
	add_options_page('HTML Twinner Settings','HTML twinner','manage_options','html-twinner', array ($this, 'htmlt_settings_page'));
	}
	
	public function htmlt_settings_page() {
		?>
	<div class="wrap">
		<h2>HTML Twinner Settings</h2>
		<div class="settings-container">
		<form action="options.php" method="POST">
			<?php settings_fields('htmlt_options'); ?>
			<?php do_settings_sections('html-twinner'); ?>
			<input class="button-primary" name="Submit" type="submit" value="Save Changes" />
		</form>
		</div>
	</div>
	
	<?php
	}
	
	// Registering options
	public function htmlt_admin_init() {
		register_setting(
			'htmlt_options',
			'htmltd',
			array($this, 'htmltd_validation')
		);
		add_settings_section(
			'htmlt_admin_main',
			'HTML-Twinner Working Directory',
			array ($this, 'htmlt_section_text'),
			'html-twinner'
		);
		add_settings_field(
			'htmlt_htmltd',
			'Current Path:',
			array ($this, 'htmltd_input'),
			'html-twinner',
			'htmlt_admin_main'
		);
	}
	
	// Draw the section header
	public function htmlt_section_text() {
		echo '<p>Path directory to create HTML file with post content or to retrieve post content from</br>';
		echo 'Paste or write the path in the box</p>'; 
		}

	// Display and fill the htmltd form field
	public function htmltd_input() {
		// get path option from the database
		$optn = esc_attr(get_option('htmltd')); // get options array of the plugin
		$htmltd = (empty ($optn))? "Value not set" : $optn ; //retrieves the path to the working directory from plugin option (if exists)
		echo "<input id='' name='htmltd' type='text' value='$htmltd' size='110'/>";
		}
		
	//Validating 
	function htmltd_validation($input) {
		$valid = (file_exists($input) && !(is_file($input)))? $input : null;
		if (empty($valid)) { //Not existing directory
			$valid = null;
			add_settings_error(
			'htmlt_htmltd',
			'htmltd_error',
			'Directory does not exist!',
			'error'
			);	}	 
		return $valid; 
		} 
}