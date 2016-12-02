<?php
session_start();
//
include 'GeraNome.php';
$pathToPhatomJs = dirname(__FILE__). '/../bin/phantomjs';
$pathToJsScript = dirname(__FILE__). '/browser_fbdesktop.js';

echo '<form action="sql.php" method="post">';
echo 'SQL<br><textarea name="query" cols="80" rows="5"></textarea>';
echo '<br><input type="submit">';
echo '</form></br>';


echo "<a href='?signup=true'>Sign Up</a></br>";
if (isset($_GET['signup'])) {
  $nome_gerado = GeraNome();
  echo $nome_gerado['firstname'] . ' | ' . $nome_gerado['lastname'] . ' | ' . $nome_gerado['sex'] . '<br>';
  
  $nome = $nome_gerado['firstname'];
  $sobrenome = $nome_gerado['lastname'];
  $email = strip_punctuation($nome_gerado['firstname']).mt_rand(0,9) . '.' . strip_punctuation($nome_gerado['lastname']).mt_rand(0,9) . '@gmail.com' ;
  //$email = 'meuhmail1232@gmail.com';
  echo $email . '<br>';
  $pass = ucfirst(substr(strip_punctuation($nome), 1, 3)).substr(strip_punctuation($sobrenome), 1, 3).mt_rand(10,99);
  echo $pass . '<br>';
  $day = mt_rand(1,28);
  $month = mt_rand(1,12);
  $year = mt_rand(1970,1994);
  $sex = $nome_gerado['sex']; // male|female
  $signtype = 'signup'; // signup|signin
  //$anotherURL = 'https://www.facebook.com/profile.php?id=100009466980633'; // URL da wall para dar like no post
  $Tempo = TempoAgora();
  //$Tempo = 'tempoqq';
  $query = "INSERT INTO cadastro (email, passw, nome, sobrenome, day, month, year, sex, ultimo_acesso, status) VALUES ('$email', '$pass', '$nome', '$sobrenome', $day, $month, $year, '$sex', '$Tempo', 'ativo');";
  echo $query;
  QueryGeraNome($query);




  echo '<br> Iniciando Phantom. </br>';

  $stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
  echo '<br>PhantomJS v.' . $stdOutv . '<br/>';

  $stdOut = exec(sprintf('%s %s %s %s %s %s %s %s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $nome, $sobrenome, $email, $pass, $day, $month, $year, $sex, $signtype), $out);
  echo $stdOut;

  echo '</br>Fim Phantom</br>';  

  echo '<br>sign</br><img src="sign.png" style="width:250px;height:250px;">';

  echo '<br>browse_myprofile</br><img src="browse_myprofile.png" style="width:250px;height:250px;">';
  echo '<br>click_change_myprofilepic</br><img src="click_change_myprofilepic.png" style="width:250px;height:250px;">';
  echo '<br>input_change_myprofilepic</br><img src="input_change_myprofilepic.png" style="width:250px;height:250px;">';
  echo '<br>submit_change_myprofilepic</br><img src="submit_change_myprofilepic.png" style="width:250px;height:250px;">';

  //echo '<br>browse_another_wall</br><img src="browse_another_wall.png" style="width:250px;height:250px;">';
  //echo '<br>like_post_on_another_wall</br><img src="like_post_on_another_wall.png" style="width:250px;height:250px;">';

  echo '<br>fim</br><img src="fim.png" style="width:250px;height:250px;">';
  
  //QueryGeraNome($query);
  
}
  
function strip_punctuation($string) {
    $string = strtolower($string);
    $string  = rtrim($string);
    $string = preg_replace('/[^a-z]+/i', 'a', $string); 
    return $string;
}

function TempoAgora(){
  $t=time();
  $retorno = date("Y-m-d h:i:sa",$t);
  return $retorno;
}

?>
