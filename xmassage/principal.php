<?php
session_start(); 
require_once('download_media_fb.php');


$pageOriginal = '1582615585402238';  //pagina que contem as midias
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');

$t1 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t2 = 'The Legs “Move up the legs in long, smooth strokes, using the full surface of your palm and keeping your fingers together. The purpose of sensual massage is to build excitement, so stroke over her buttocks.
You could at this point stroke gently down between her legs and gently excite her with your fingers. It’s very important to always maintain a very gentle touch." ';
$t3 = 'For women who want to enjoy the firm yet the tender touch of a man without the need to perform or give back sexually. ';
$t4 = 'This can be you. Book your sensual massage and enjoy yourself. ';
$t5 = 'The therapy will take you into the heart and bloom of the flower of your femininity. An orgasm is not the goal, but rather sexual healing in whatever form it is expressed. The therapy is an opportunity to receive without any expectations. It is the absolute opportunity to experience the beauty and pleasure of sensual touch from another - totally as the receiver. Orgasmic delight is often experienced and has been described as ‘riding the wave’. ';
$t6 = 'Enjoy your body! Book a sensual massage. ';
$t7 = 'Sensual Massage is a wonderful way in which therapeutic Massage is blended with eroticism and allows ladies to release daily stresses, emotional and physical tensions away. ';
$t8 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t9 = 'The #female clients that come to see me are of course are all #attractive, but attractiveness is not just about the #physical. The #women I see for #sensual #massage come in all #shapes and sizes and from all age groups. The most frequent age group I see is between 30 years and 55 years, but I have also given a sensual massage to women aged from 18 years to women in their 70’s. I see women from all #cultures and #nationalities, many of who live in the UK but also many who are #visiting #London and the UK on #business or for #pleasure who want to take the #opportunity to #explore their #sensuality away from the #sensitivity of their home. ';
$t10 = 'The goal of the Yoni massage is not solely to achieve orgasm, although orgasm is often a pleasant and welcome side effect. The goal can be as simple as to pleasure and massage the Yoni. From this perspective both receiver and giver can relax, and do not have to worry about achieving any particular goal. When orgasm does occur it is usually more expanded, more intense and more satisfying. It`s also helpful for the giver to not expect anything in return, but simply allow the receiver to enjoy the massage and to relax into herself. ';
$t11 = 'Would you like a sensual massage? ';
$t12 = 'Don`t tell anyone! ;) Book your sensual massage today. ';
$t13 = 'Tag a friend who needs a massage ';
$t14 = 'Did you have time to enjoy yourself this week? Book a sensual massage! ';


$textos = Array($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $t13, $t14);
$textos_hashtags = array(' #spa',' #massage',' #sensual',' #tantric',' #tantra',' #relax',' #pleasure',' #oil',' #oilmassage',' #meditation',' #vibe',' #enjoy',' #skin',' #touch',' #forher',' #her',' #therapy',' #london',' #power',' #positive',' #life',' #connection',' #health',' #vibe',' #happyness');

$sorteio_texto = mt_rand(0, sizeof($textos) - 1);
$texto = $textos[$sorteio_texto] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)];
echo '<br>'.$texto.'<br>';

$retorno_media = Download_Media_fb($pageOriginal, $app_id, $app_secret);
$media = dirname(__FILE__).'/'.$retorno_media[0];

$tipo_media = $retorno_media[1];
echo '<br>'.$media.'<br>';
echo '<br><img src="'.$retorno_media[0].'"><br>';

$url = $retorno_media[2];
$image2 = 'imagex.jpg';
file_put_contents($image2, file_get_contents($url));
echo '<br><img src="'.$image2.'"><br>';
$media = dirname(__FILE__).'/'.$image2;
$media = $image2;

echo imagesx(imagecreatefromjpeg($retorno_media[0])).':'.imagesy(imagecreatefromjpeg($retorno_media[0])).'<br>';
echo imagesx(imagecreatefromjpeg($image2)).':'.imagesy(imagecreatefromjpeg($image2)).'<br>';
echo imagesx(imagecreatefromjpeg($media)).':'.imagesy(imagecreatefromjpeg($media)).'<br>';


//$media = 'http://i.dailymail.co.uk/i/pix/2014/04/13/article-2603599-00F50A9D00000578-962_634x750.jpg';

if($tipo_media == 'foto'){
  echo '<br>JPG<br>';
  //require_once('../Instagram/uploadPhoto.php');
  require_once('/app/Instagram/uploadPhoto.php');
  Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
}else{
  echo '<br>MP4<br>';
  $resizemedia = dirname(__FILE__).'/resize'.$retorno_media[0];
  shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
  echo $resizemedia;

  require_once('/app/Instagram/uploadVideo.php');
  Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
}

?>
