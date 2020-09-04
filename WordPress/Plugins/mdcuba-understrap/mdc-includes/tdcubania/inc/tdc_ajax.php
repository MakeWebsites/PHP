<?php
$wpl_path = $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
require ($wpl_path);
global $wpdb;
include_once 'ipdata.php';

$ipdat = new ipdata();
$ip = $ipdat->gip();

$fecha = current_time( 'mysql' );
$tablename = $wpdb->prefix.'tdcubania';

$data = json_decode(file_get_contents("php://input"));

// Add record

	$result = $data->result;
	$wpdb->query($wpdb->prepare("INSERT INTO ".$tablename."(pciento, ip_address, fecha) VALUES('".$result."', '".$ip."', '".$fecha."')"));


	exit;
