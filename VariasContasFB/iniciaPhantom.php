<?php
session_start();

echo 'form action="sql.php" method="post">';
echo 'SQL <br>  <textarea name="query" cols="80" rows="5"></textarea>';
echo '<input type="submit">';
echo '</form>';

echo 'Iniciando Phantom. </br>';

include 'GeraNome.php';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fbdesktop.js';

$nome_gerado = GeraNome();
echo $nome_gerado['firstname'] . ' | ' . $nome_gerado['lastname'] . ' | ' . $nome_gerado['sex'] . '<br>';

$nome = $nome_gerado['firstname'];
$sobrenome = $nome_gerado['lastname'];
$email = getenv('email');
$pass = getenv('pass');
$day = mt_rand(1,28);
$month = mt_rand(1,12);
$year = mt_rand(1970,1994);
$sex = $nome_gerado['sex']; // male|female
$signtype = 'signin'; // signup|signin
$anotherURL = 'https://www.facebook.com/profile.php?id=100009466980633'; // URL da wall para dar like no post
?>



<?php

$stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
echo '<br>PhantomJS v.' . $stdOutv . '<br/>';

//$stdOut = exec(sprintf('%s %s %s %s %s %s %s %s %s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $nome, $sobrenome, $email, $pass, $day, $month, $year, $sex, $signtype, $anotherURL), $out);
//echo $stdOut;

echo '</br>Fim Phantom</br>';  

echo '<br>sign</br><img src="sign.png" style="width:250px;height:250px;">';

//echo '<br>myprofile</br><img src="myprofile.png" style="width:250px;height:250px;">';
//echo '<br>click_input</br><img src="click_input.png" style="width:250px;height:250px;">';
//echo '<br>input_image</br><img src="input_image.png" style="width:250px;height:250px;">';
//echo '<br>submit_image</br><img src="submit_image.png" style="width:250px;height:250px;">';

echo '<br>browse_another_wall</br><img src="browse_another_wall.png" style="width:250px;height:250px;">';
echo '<br>like_post_on_another_wall</br><img src="like_post_on_another_wall.png" style="width:250px;height:250px;">';

echo '<br>fim</br><img src="fim.png" style="width:250px;height:250px;">';



?>
