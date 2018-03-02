<?php
if(isset($_GET['site'])){
  $f = fopen($_GET['site'], 'r');
  $html = '';
  while (!feof($f)) {
    $html .= fread($f, 24000);
  }
  fclose($f);
  echo $html;
}
?>
