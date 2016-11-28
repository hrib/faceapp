<?php
echo 'Iniciando Phantom. </br>';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_SignUpteste.js';

$nome = 'Marculano'
$sobrenome = 'Silvatal'
$email = getenv('email');
$pass = getenv('pass');
$day = '01';
$month = '10';
$year = '1985';
$sex = 'male'; // male|female
$singtype = 'singin'; // singup|singin

$stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
echo $stdOutv . "<br/>";

$stdOut = exec(sprintf('%s %s %s %s %s %s %s %s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $nome, $sobrenome, $email, $pass, $day, $month, $year, $sex, $singtype), $out);
echo $stdOut;

echo '</br>Fim Phantom</br>';   
?>
