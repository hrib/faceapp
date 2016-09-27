<?php
session_start(); 
$aleatorio = mt_rand(0, 23);
if($aleatorio < 21){
 echo $aleatorio . " fim";  
 //exit;
}

$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');
$token = getenv('INS_APP_TOKEN');
$originaluserid = 35380841;

$retorno = MediaRecente($originaluserid, $token);
function MediaRecente($originaluserid, $token){
    $url = 'https://api.instagram.com/v1/users/'.$originaluserid.'/media/recent/?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    var_dump($resjson);    
    echo '<br>';
    echo '<table border="1">';
    $count = 0;
    $randnum = mt_rand(1,20);
    foreach($resjson->data as $media){
        echo '<tr>';
        echo '<td>'. $media->caption->text .'</td>';
        echo '<td>'. $media->id .'</td>';
        echo '</tr>';
        $count = $count + 1;
        $ultimoid = $media->id;
        if($count >= $randnum){break;}
    }
    echo '</table>';
    return $ultimoid;
}


//echo '<br>'.$media.'<br>';
//echo '<br><img src="'.$retorno_media[0].'"><br>';


if($tipo_media == 'foto'){
  echo '<br>JPG<br>';
  require_once('/app/Instagram/uploadPhoto.php');
  Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
//}else{
  echo '<br>MP4<br>';
  $resizemedia = 'resize'.$media;
  shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
  echo $resizemedia;
  require_once('/app/Instagram/uploadVideo.php');
  Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
}
?>
