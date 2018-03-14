<?php
session_start();
include_once 'json/GetJsc.php';

$c3 = $_SESSION['c3'];
$dat = new GetJsc('pr', $c3);
$data = $dat->getDat();
echo json_encode($data);
    
