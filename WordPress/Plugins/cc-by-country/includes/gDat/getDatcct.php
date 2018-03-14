<?php
session_start();
include_once 'json/GetJscc.php';

$c3 = $_SESSION['c3'];
$dat = new GetJscc('tas', $c3);
$data = $dat->getDat();
echo json_encode($data);
    
