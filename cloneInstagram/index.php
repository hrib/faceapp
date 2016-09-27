<?php
session_start(); 
$aleatorio = mt_rand(0, 23);
if($aleatorio < 21){
 echo $aleatorio . " fim";  
 exit;
}
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('download_media_fb.php');
require_once('post_media_fb.php');

$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');

$retorno_media = Download_Media_fb($pageOriginal, $app_id, $app_secret);
$media = $retorno_media[0];
$tipo_media = $retorno_media[1];

echo '<br>'.$media.'<br>';
echo '<br><img src="'.$retorno_media[0].'"><br>';


if($tipo_media == 'foto'){
  echo '<br>JPG<br>';
  require_once('/app/Instagram/uploadPhoto.php');
  Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
}else{
  echo '<br>MP4<br>';
  $resizemedia = 'resize'.$media;
  shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
  echo $resizemedia;
  require_once('/app/Instagram/uploadVideo.php');
  Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
}
?>
