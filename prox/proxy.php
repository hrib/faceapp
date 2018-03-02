<?php
echo $_GET['site'] . '<br>';

if(isset($_GET['site'])){
  $f = fopen($_GET['site'], 'r');
  echo var_dump($f) . '<br>';
  $html = '';
  while (!feof($f)) {
    $html .= fread($f, 24000);
  }
  fclose($f);
  echo $html;
}
?>
