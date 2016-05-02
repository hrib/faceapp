<?php
    $echo 'oi';
    $phantom_script= dirname(__FILE__). '/get-website.js'; 
    $response =  exec ('phantomjs ' . $phantom_script);
    echo  htmlspecialchars($response);
?>
