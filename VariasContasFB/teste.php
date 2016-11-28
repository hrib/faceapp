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

  
echo '</br>inicio</br><img src="inicio.png" style="width:128px;height:128px;">';
echo '</br>logou</br><img src="logou.png" style="width:128px;height:128px;">';
echo '</br>finished</br><img src="finished.png" style="width:128px;height:128px;">';
echo '</br>fim</br><img src="fim.png" style="width:128px;height:128px;">';
?>
