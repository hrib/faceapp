<?php
    echo 'oi';
//    $phantom_script= dirname(__FILE__). '/get-website.js'; 
//    echo $phantom_script;
//    $response =  exec ('bin/phantomjs ' . $phantom_script);
//    echo  htmlspecialchars($response);
//set_time_limit(60); 
//$pathToPhatomJs = 'bin/phantomjs';
$pathToPhatomJs = dirname(__FILE__). '/bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/wapp/browser.js';
$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
echo $stdOut;
    
    
    
?>
