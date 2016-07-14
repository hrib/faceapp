<?php

$pathToPhatomJs = 'bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fb.js';
$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
echo $stdOut;
    
    
    
?>
