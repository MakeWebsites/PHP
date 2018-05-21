<?php

function progressBar($current, $total, $label) {

$percent = number_format($current*100/total, 0);
$long = strlen ($percent);
 
    // This function assumes that you start with completion of 0%. 
     
    // If the first time you call this function is with 1% 
    // completion, you will delete the last 106 characters of 
    // output from your program. 
     
    // If this is the case, simply call this function before with 
    // a hard coded 0. 
     
    // check to see if this is the first go-round 
    if ($current == 0) 
    { 
        // this is the first time so output the progess bar label 
        if ($label == "") 
            echo "Progress: "; 
        else if ($label != "none") 
            echo $label; 
         
        // start the bar with a nice edge 
        echo "|"; 
    } 
    else 
    { 
        // this isn't the first time so remove the previous percent 
        for ($place = $long +1 ; $place >= 0; $place--) 
        { 
            // echo a backspace to remove the previous character 
            echo "\010"; 
        } 
    } 
     
    echo $percent.'%';
     
    // check to see if this is the last go-round 
    if ($current == $total) 
    { 
        // this is the end of the progress bar, output an end of line 
        echo "\n"; 
    } 
}  