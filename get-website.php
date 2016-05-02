<?php
    echo 'oi';
    $phantom_script= dirname(__FILE__). '/get-website.js'; 
    echo $phantom_script;
    $response =  exec ('bin/phantomjs ' . $phantom_script);
    echo  htmlspecialchars($response);
?>
