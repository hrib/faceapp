<?php
echo 'Iniciando Phantom. </br>';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_SignUpteste.js';

//$varin1 = getenv('email');
//$varin2 = getenv('pass');
$varin1 = 'meuemail';
$varin2 = 'meupass';

$stdOut = exec(sprintf('%s %s %s %s %s', $pathToPhatomJs, '--ignore-ssl-errors=yes', $pathToJsScript, $varin1, $varin2), $out);
echo $stdOut;
echo '</br>Fim Phantom</br>';   
?>
