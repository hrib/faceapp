<?php
echo 'Iniciando Phantom. </br>';
$pathToPhatomJs = '../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_SignUp.js';

echo '</br>' . $pathToJsScript . '</br>';

//$varin1 = getenv('email');
//$varin2 = getenv('pass');
$varin1 = 'meuemail';
$varin2 = 'meupass';

$stdOut = exec(sprintf('%s %s %s %s', $pathToPhatomJs,  $pathToJsScript, $varin1, $varin2), $out);
echo $stdOut;
echo '</br>Fim Phantom</br>';   
?>
