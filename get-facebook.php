<?php
echo 'oi';
$pathToPhatomJs = 'bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fb.js';
$varin = 'qq';
$stdOut = exec(sprintf('%s %s %s', $pathToPhatomJs,  $pathToJsScript, $varin), $out);

//$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
echo $stdOut;
    
    
    
?>
