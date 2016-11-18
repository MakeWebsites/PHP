<?php
/**
 * This file adds the Precios template to the Executive Pro Theme in Make-Websites.
 *
  */

/*
Template Name: Precios
*/

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//remove_action('genesis_loop', 'genesis_do_loop');

//if (!defined('precios'))
//define( 'precios', ABSPATH.'precios/' );

// Add our custom loop
add_action( 'genesis_loop', 'precios_loop' );

function precios_loop() {
require_once( 'Precios/precios.php');
}


//* Run the Genesis loop
genesis();
