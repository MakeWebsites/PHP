<?php
class htmlt_mb {

	private $_htmltd;
	
	public function __construct () {
	add_action( 'add_meta_boxes', array($this, 'htmlt_create' )); // Creating the metabox at each post or page to process data and start copying/pasting
	add_action( 'save_post', array($this,'htmlt_save_meta' )); //Saves the meta data and performs the copy or paste actions
	}

		public function htmlt_create() { //create the HTML-Twinner meta box at each page or post
		add_meta_box( 'htmlt-meta', 'HTML twinner', array($this, 'htmlt_mbf'), array('page', 'post'), 'normal', 'high' );
		}

		public function htmlt_mbf() { //Displays the metabox and retrieves the path
		$post = get_post();
		$ptitle = strtolower(str_replace(" ", "-", $post->post_title)).'.html';
		$pid = $post->ID;
			
			
			// Path to file 
			$optn = 'htmltd';
			//retrieve the path to the workin directory from plugin option (if exists) or creating a custom path
			$htmlt_d = (empty (get_option($optn)))? 'C:\\HTML-twinner\\'.strtolower(str_replace(" ", "-", get_bloginfo())).'\\' : get_option($optn); 
			$cdp = 'C:/HTML-twinner/'.strtolower(str_replace(" ", "-", get_bloginfo()));
			if (!is_dir($cdp)) // Creates the custom directory if it does not exist
			mkdir($cdp, 0777, true);
			
			

			$mesd = (empty($htmlt_d))? "Create " : "Edit "; // Message if Directory exists or not
			
			echo '<h4>Path directory to create HTML file with post content or to retrieve post content from:</h4>';
			$urlp = admin_url("options-general.php?page=html-twinner");
			
			?>
			<p>Current Path: <span class="dest"><?php if (!empty ($htmlt_d)) echo $htmlt_d; else echo " <span class='errorm'>Empty path settings</span> ";
			echo '</span>';
			if (current_user_can('manage_options')) { // Gives to user the option to create or to change the path since can access to plugin's page
			echo '<a class="boton" href="'.$urlp.'" >'.$mesd.' Path in the Plugin seetings options</a>';
			}
			
				elseif (empty($htmlt_d) || !file_exists($htmlt_d)) { // User can't access to plugin administration and htmld does not exists or not valid. Create an alternative directory
					$html_d = 'C:\\HTML-twinner\\'.bloginfo('name');
					mkdir($htmlt_d); 
					}
			update_option ($optn, $htmlt_d); // Updates plugin option with new directory
			
			$fpath = $htmlt_d.'\\'.$ptitle; // Full path to HTML file
			
			//Retrieve the post-meta data
			$faction = get_post_meta( $pid, '_htmlt_action', true );
			
			echo '<br>Faction vale '.$faction
												
			// Create buttons for Copy and Paste options ?>
			<p>Action to be conducted after saving/updating this post:</p>
			<table width="80%">
			<tr>
			<td><input type="radio" name="htmlt_action" value="copy" <?php checked( $faction, "copy" ); ?>> 
			Copy post content to file <span class="dest"><?php echo $ptitle ?></span></td>
			<?php if(file_exists($fpath)) { // File exists, hence pasting from it is possible ?>
				<td><input type="radio" name="htmlt_action" value="paste" <?php checked( $faction, "paste" ); ?>> 
				Replace post content from content of file <span class="dest"><?php echo $ptitle ?></span></td>
			<?php } 
			if (!empty($faction)) { // Some action has been choosen, hence we give the possibility to undo it  ?>
				<td><input type="radio" name="htmlt_action" value="none"> 
				No action at all</td>
			<?php } ?>
			</tr>
			</table>
			
		<?php	
		return $fpath;
		}
		
		public function htmlt_save_meta( $pid ) {
			//verify the meta data is set
			if ( isset( $_POST['htmlt_action'] )) {
				if ( $_POST['htmlt_action'] == 'none' ) $_POST['htmlt_action'] = null;
			update_post_meta( $pid, '_htmlt_action', ( $_POST['htmlt_action'] ) ); }
		}
		
}