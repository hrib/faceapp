<?php
session_start(); 
require_once('download_media_fb.php');


$pageOriginal = '1582615585402238';  //pagina que contem as midias
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');

$textos = Array('#massage','#sensual','#book');
$sorteio_texto = mt_rand(0, sizeof($textos) - 1);
$texto = $textos[$sorteio_texto];
echo '<br>'.$texto.'<br>';

$retorno_media = Download_Media_fb($pageOriginal, $app_id, $app_secret);
$media = dirname(__FILE__).'/'.$retorno_media[0];
$tipo_media = $retorno_media[1];
echo '<br>'.$media.'<br>';

if($tipo_media = 'jpg'){
  require_once('../Instagram/uploadPhoto.php');
  Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
}else{
  require_once('../Instagram/uploadVideo.php');
  Instagram_UploadVideo($Insta_username, $Insta_passw, $media, $texto);
}

?>
