<?php
class htmlt_mb {

	private $_htmltd;
	
	public function __construct () {
	add_action( 'add_meta_boxes', array($this, 'boj_mbe_create' )); // Creating the metabox at each post or page to process data and start copying/pasting
	add_action( 'save_post', array($this, 'boj_mbe_save_meta') );
	}

	function boj_mbe_create() {

	//create a custom meta box
	add_meta_box( 'boj-meta', 'My Custom Meta Box', array($this, 'boj_mbe_function'), 'post', 'normal', 'high' );

}

	function boj_mbe_function( $post ) {

		//retrieve the meta data values if they exist
		$boj_mbe_name = get_post_meta( $post->ID, '_boj_mbe_name', true );
		$boj_mbe_costume = get_post_meta( $post->ID, '_boj_mbe_costume', true );

		echo 'Please fill out the information below';
		?>
		<p>Name: <input type="text" name="boj_mbe_name" value="<?php echo esc_attr( $boj_mbe_name ); ?>" /></p>
		<p>Costume: 
		<select name="boj_mbe_costume">
			<option value="vampire" <?php selected( $boj_mbe_costume, 'vampire' ); ?>>Vampire</option>
			<option value="zombie" <?php selected( $boj_mbe_costume, 'zombie' ); ?>>Zombie</option>
			<option value="smurf" <?php selected( $boj_mbe_costume, 'smurf' ); ?>>Smurf</option>
		</select>
		</p>
		<?php
}

	function boj_mbe_save_meta( $post_id ) {

		//verify the meta data is set
		if ( isset( $_POST['boj_mbe_name'] ) ) {
		
			//save the meta data
			update_post_meta( $post_id, '_boj_mbe_name', strip_tags( $_POST['boj_mbe_name'] ) );
			update_post_meta( $post_id, '_boj_mbe_costume', strip_tags( $_POST['boj_mbe_costume'] ) );
		
			}

	}
//hook to save the meta box data


}