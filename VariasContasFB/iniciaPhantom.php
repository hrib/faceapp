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


CreateTable();

$stdOutv = exec(sprintf('%s %s', $pathToPhatomJs, '--version'), $out);
echo $stdOutv . "<br/>";

$stdOut = exec(sprintf('%s %s %s %s %s %s %s %s %s %s %s %s %s', $pathToPhatomJs, '--ssl-protocol=any --ignore-ssl-errors=yes', $pathToJsScript, $nome, $sobrenome, $email, $pass, $day, $month, $year, $sex, $signtype, $anotherURL), $out);
echo $stdOut;

echo '</br>Fim Phantom</br>';  

echo '<br>sign</br><img src="sign.png" style="width:250px;height:250px;">';

//echo '<br>myprofile</br><img src="myprofile.png" style="width:250px;height:250px;">';
//echo '<br>click_input</br><img src="click_input.png" style="width:250px;height:250px;">';
//echo '<br>input_image</br><img src="input_image.png" style="width:250px;height:250px;">';
//echo '<br>submit_image</br><img src="submit_image.png" style="width:250px;height:250px;">';

echo '<br>browse_another_wall</br><img src="browse_another_wall.png" style="width:250px;height:250px;">';
echo '<br>like_post_on_another_wall</br><img src="like_post_on_another_wall.png" style="width:250px;height:250px;">';

echo '<br>fim</br><img src="fim.png" style="width:250px;height:250px;">';

function CreateTable(){
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];

  $db = new PDO($dsn);

  $query = "CREATE TABLE Users ("
      . "email VARCHAR(30),"
      . "passw VARCHAR(10),"
      . "nome VARCHAR(20),"
      . "sobrenome VARCHAR(20),"
      . "day VARCHAR(2),"
      . "month VARCHAR(2),"
      . "year VARCHAR(4),"
      . "sex VARCHAR(10),"
      . "ultimo_acesso VARCHAR(30),"
      . "status VARCHAR(30)"
      . ");";
  $result = $db->query($query);
  echo var_dump($result);
}

?>
