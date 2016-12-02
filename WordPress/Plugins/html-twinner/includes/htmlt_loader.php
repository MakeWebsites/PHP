<?php

include_once HTMLTP.'\admin\classes\htmlt-mbox.php';
include_once HTMLTP.'\admin\classes\htmlt-admin-menu.php';


//Custom style
add_action( 'admin_enqueue_scripts', 'htmlt_style' );

function htmlt_style() {
	wp_register_style( 'htmlt-style', plugins_url('../admin/css/htmlt.css', __FILE__ ));
    wp_enqueue_style( 'htmlt-style' );
} 

new htmlt_mb;
new htmlt_admin_menu;
