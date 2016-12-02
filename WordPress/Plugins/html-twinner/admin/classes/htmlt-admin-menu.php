<?php

class htmlt_admin_menu {
	// Declaring private variables
	private $_htmltd;
	
	public function __construct() { // Hooks to create menu and register options 
	add_action('admin_menu', array($this, 'htmlt_menu'));
	add_action('admin_init', array($this, 'htmlt_admin_init'));
	}
	
	/* public function setHtmltd($htmltd) {
	$this->_htmltd = $htmltd; }
	
	public function getHtmltd() {
	return $this->_htmltd; } */
	
	public function htmlt_menu() { // Adding the options
	add_options_page('<div class="boton">HTML Twinner Options</div>','HTML twinner','manage_options','html-twinner', array ($this, 'htmlt_settings_page'));
	}
	
	public function htmlt_settings_page() {
		?>
	<div class="wrap">
		<h2>HTML Twinner Options</h2>
		<div class="settings-container">
		<form action="options.php" method="post">
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
			'htmlt_d',
			'htmltd_valid'
		);
		add_settings_section(
			'htmlt_admin_main',
			'HTML-Twinner Settings',
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
		echo '<p>Path directory to create HTML file with post content or to retrieve post content from</p>';
		}

	// Display and fill the htmltd form field
	public function htmltd_input() {
		// get path option from the database
		$hmtlt_optn = get_option('html_twinner_path'); //retrieves the path to the working directory from plugin option (if exists)
		if ( isset( $_POST['file_d'] )) {
					$provd = $_POST['file_d'];
					echo 'Provd es '.$provd;
					if (wp_verify_nonce( $_POST['htmltd'], 'htmltdc' ) && is_dir($provd));
						$htmlt_d = (validate_file($provd))? $provd : NULL; ?>
						<div class="notice notice-success is-dismissible"> 
						<p><strong>Settings saved.</strong></p> 
						</div> 
			<?php } else {
				//echo 'No hay post recibido'; ?>
		<!--<input id='htmltd' type='file' name='htmld'/>-->
		<form method="post">
			<input type="text" name="file_d" size="110" />
			<input class="primary-button" type="submit" name="select" value="Select Folder" />
			<?php //wp_nonce_field( 'htmltdc', 'htmltd' ); ?>
			</form>
			
<?php		}
		
	//Validating 
	function htmltd_valid($htmltd) {
		return (validate_file( $htmltd) == 0);
		}
	}

}