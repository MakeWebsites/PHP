<?php
for ($nc=0; $nc<10; $nc++){

    // delay just to test

    // send message to browser
    ob_start();
    print '<p>Update '.$nc.'</p>';
    ob_end_flush();
    flush();
}
?>