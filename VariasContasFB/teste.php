<?php
echo 'Iniciando Phantom. </br>';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';

$varin1 = getenv('email');
$varin2 = getenv('pass');

$stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
echo $stdOutv . "<br/>";

$pathToJsScript = dirname(__FILE__). '/teste1.js';
$stdOut = exec(sprintf('%s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $varin1, $varin2), $out);
echo $stdOut;
echo '</br>Fim Phantom</br>';   
?>
