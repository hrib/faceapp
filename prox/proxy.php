<?php
echo $_GET['site'] . '<br>';





if(isset($_GET['site'])){
  header('Content-Type: text/html');
  $string = file_get_contents($_GET['site']);
  echo $string;
}
?>
