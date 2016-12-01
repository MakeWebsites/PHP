<?php
/**
 * This file adds the Landing template to the Executive Pro Theme.
 *
 * @author StudioPress
 * @package Executive Pro
 * @subpackage Customizations
 */

/*
Template Name: simulador
*/

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//remove_action('genesis_loop', 'genesis_do_loop');

if (!defined('RESULTS'))
define( 'RESULTS', get_stylesheet_directory().'/results/' );

// Add our custom loop
add_action( 'genesis_loop', 'results_loop' );

function results_loop() {
include( RESULTS.'simular.php');
}


//* Run the Genesis loop
genesis();



