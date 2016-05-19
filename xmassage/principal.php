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
//$media = 'http://ak3.picdn.net/shutterstock/videos/7764553/preview/stock-footage-electronic-recycling-plant-pov-cart-p-h-mp-pov-point-of-view-continuous-shot-of-cell-ph.mp4';

$tipo_media = $retorno_media[1];
echo '<br>'.$media.'<br>';


        $preview = 'resultado.mp4';
        $command = '/app/vendor/ffmpeg/ffmpeg -i "'.$media.' -vf "scale=iw*min(405/iw\,320/ih):ih*min(405/iw\,320/ih),pad=405:320:(405-iw)/2:(320-ih)/2" '.$preview.'" 2>&1';
        @exec($command);


if($tipo_media == 'jpg'){
  echo '<br>JPG<br>';
  require_once('../Instagram/uploadPhoto.php');
  Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
}else{
  echo '<br>MP4<br>';
  require_once('../Instagram/uploadVideo.php');
  Instagram_UploadVideo($Insta_username, $Insta_passw, $media, $texto);
}

?>
