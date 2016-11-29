<?php
echo 'Iniciando Phantom. </br>';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fbdesktop.js';

$nome = 'Marculano';
$sobrenome = 'Silvatal';
$email = getenv('email');
$pass = getenv('pass');
$day = '01';
$month = '10';
$year = '1985';
$sex = 'male'; // male|female
$signtype = 'signin'; // signup|signin
$anotherURL = 'https://www.facebook.com/profile.php?id=100009466980633'; // URL da wall para dar like no post

$stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
echo $stdOutv . "<br/>";

$stdOut = exec(sprintf('%s %s %s %s %s %s %s %s %s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $nome, $sobrenome, $email, $pass, $day, $month, $year, $sex, $signtype, $anotherURL), $out);
echo $stdOut;

echo '</br>Fim Phantom</br>';  

echo '<br>sign</br><img src="sign.png" style="width:250px;height:250px;">';
echo '<br>myprofile</br><img src="myprofile.png" style="width:250px;height:250px;">';
echo '<br>click_input</br><img src="click_input.png" style="width:250px;height:250px;">';
echo '<br>input_image</br><img src="input_image.png" style="width:250px;height:250px;">';
echo '<br>submit_image</br><img src="submit_image.png" style="width:250px;height:250px;">';
echo '<br>fim</br><img src="fim.png" style="width:250px;height:250px;">';
?>
