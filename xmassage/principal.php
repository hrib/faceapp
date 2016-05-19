<?php
session_start(); 
require_once('download_media_fb.php');


$pageOriginal = '1582615585402238';  //pagina que contem as midias
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$media = Download_Media_fb($pageOriginal, $app_id, $app_secret);
echo $media;

?>
