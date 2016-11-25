<?php
echo 'oi';
$pathToPhatomJs = 'bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fb.js';
$varin1 = getenv('email');
$varin2 = getenv('pass');
$stdOut = exec(sprintf('%s %s %s %s', $pathToPhatomJs,  $pathToJsScript, $varin1, $varin2), $out);
//$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
echo $stdOut;
    
    
    
?>
