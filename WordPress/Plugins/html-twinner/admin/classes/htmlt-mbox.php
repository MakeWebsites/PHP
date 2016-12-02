<?php
class htmlt_mb {

	private $_htmltd;
	
	public function __construct () {
	add_action( 'add_meta_boxes', array($this, 'htmlt_create' )); // Creating the metabox at each post or page to process data and start copying/pasting
	}

	public function setHtmltd($htmltd) {
	$this->_htmltd = $htmltd; }
	
	public function getHtmltd() {
	return $this->_htmltd; }
	
		public function htmlt_create() { //create the HTML-Twinner meta box at each page or post
		add_meta_box( 'htmlt-meta', 'HTML twinner', array($this, 'htmlt_mbf'), array('page', 'post'), 'normal', 'high' );
		}

		public function htmlt_mbf( $post) { //Displays the metabox and retrieves the path
			
			// Path to file 
			$optn = 'html_twinner_path';
			//retrieve the path to the workin directory from plugin option (if exists) or creating a custom path
			$htmlt_d = /*(empty (get_option($optn)))?*/ 'C:\\HTML-twinner\\'.strtolower(str_replace(" ", "-", get_bloginfo())).'\\' /*: get_option($optn)*/; 
			$cdp = 'C:/HTML-twinner/'.strtolower(str_replace(" ", "-", get_bloginfo()));
			if (!is_dir($cdp)) // Creates the custom directory if it does not exist
			mkdir($cdp, 0777, true);
			
			

			$mesd = (empty($htmlt_d))? "Create " : "Edit "; // Message if Directory exists or not
			
			echo '<h4>Path directory to create HTML file with post content or to retrieve post content from:</h4>';
	?>
			<p>Current Path: <span class="dest"><?php if (!empty ($htmlt_d)) echo $htmlt_d; else echo " <span class='errorm'>Empty path settings</span> ";
			echo '</span>';
			if (current_user_can('manage_options')) { // Gives to user the option to create or to change the path
			echo '<a class="boton" href="'.plugins_url().'html-twinner"'.$mesd.'>Path in the Plugin seetings options</a>';
			}
			
				elseif (empty($htmlt_d) || !is_dir($htmlt_d)) { // User can't access to plugin administration and htmld does not exists or not valid. Create an alternative directory
					$html_d = 'C:\\HTML-twinner\\'.bloginfo('name');
				mkdir($htmlt_d); }
			 
			
			update_option ($optn, $htmlt_d); // Updates plugin option with new directory
			/* if ( isset( $_POST['file_d'] )) {
					$provd = $_POST['file_d'];
					echo 'Provd es '.$provd;
					if (wp_verify_nonce( $_POST['htmltd'], 'htmltdc' ) && is_dir($provd));
				$htmlt_d = (validate_file($provd))? $provd : NULL; }
			else {
				echo 'No hay post recibido'; */
			?>
			<!--<p class="boton"><?php echo $mesd ?>Path directory to HTML file to store post content or to retrieve post content from</p>
			<p>Current Path: <?php if (!empty ($htmlt_d)) echo esc_attr( $html_d ); else echo " <span class='errorm'>Empty path settings</span> ";?></p>		
			
			<form method="post">
				<input type="text" name="file_d" size="110" />
				<input class="primary-button" type="submit" name="select" value="Select Folder" />
				<?php //wp_nonce_field( 'htmltdc', 'htmltd' ); ?>
			</form>-->
			<?php
			/* }	
			 				
			echo '(Copy the path and paste here)';			
			update_option($optn, $htmlt_d);
			
			return $htmlt_d;  */
		}

}