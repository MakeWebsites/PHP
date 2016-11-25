<?php
/*
Plugin Name: Dashboard-Customize
Description: Customizing dashoboard for authors in MW Genesis sites
Version: 1.0
Author: Angel Utset - Make-Websites
License: GPLv2
*/

add_action('init','clean_d');
function clean_d(){
if (!current_user_can('manage_options'))
include_once( 'clean-dashboard.php'); }

