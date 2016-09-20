<?php
    echo 'oi';
//    $phantom_script= dirname(__FILE__). '/get-website.js'; 
//    echo $phantom_script;
//    $response =  exec ('bin/phantomjs ' . $phantom_script);
//    echo  htmlspecialchars($response);
//set_time_limit(60); 
$pathToPhatomJs = 'bin/phantomjs';
$pathToJsScript = 'browser_wapp.js';

//$pathToPhatomJs = '../bin/phantomjs';
//$pathToJsScript = '../wapp/browser.js';

$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
echo $stdOut;
    
    
    
?>
