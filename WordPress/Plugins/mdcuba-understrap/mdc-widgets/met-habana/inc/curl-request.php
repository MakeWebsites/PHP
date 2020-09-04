<?php

$curlSession = curl_init();
$url = 'https://worldweather.wmo.int/en/json/280_en.json';
    curl_setopt($curlSession, CURLOPT_URL, $url);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsond = curl_exec($curlSession);
    
   curl_close($curlSession);
   
   echo($jsond);
   
   