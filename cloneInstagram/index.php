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
$originaluserid = 2071958799; //35380841; //3505274959; //

$retorno = MediaRecente($originaluserid, $token);
$mediaID = $retorno[3];
$ret_comments = CommentsMediaRecente($mediaID, $token);
preg_match_all("/(#\w+)/", $ret_comments, $matches);
//$meus_comments = $matches[0] . ' ' . $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5] . ' ' . $matches[6] . ' ' . $matches[7] . ' ' . $matches[8] . ' ' . $matches[9] . ' ' . $matches[10] . ' ' . $matches[11] . ' ' . $matches[12] . ' ' . $matches[13] . ' ' . $matches[14] . ' ' . $matches[15] . ' ' . $matches[16] . ' ' . $matches[17] . ' ' . $matches[18] . ' ' . $matches[19] . ' ' . $matches[20] ;
$meus_comments = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2] . ' ' . $matches[0][3] . ' ' . $matches[0][4] . ' ' . $matches[0][5] . ' ' . $matches[0][6] . ' ' . $matches[0][7] . ' ' . $matches[0][8] . ' ' . $matches[0][9] . ' ' . $matches[0][10] . ' ' . $matches[0][11] . ' ' . $matches[0][12] . ' ' . $matches[0][13] . ' ' . $matches[0][14] . ' ' . $matches[0][15] . ' ' . $matches[0][16] . ' ' . $matches[0][17] . ' ' . $matches[0][18] . ' ' . $matches[0][19] . ' ' . $matches[0][20] ;

echo '<br><br>comment = '. $meus_comments .'<br><br>';
//var_dump( $matches );



function MediaRecente($originaluserid, $token){
    $url = 'https://api.instagram.com/v1/users/'.$originaluserid.'/media/recent/?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    echo '<br>';
    echo '<table border="1">';
    $count = 0;
    $randnum = mt_rand(1,10);
    foreach($resjson->data as $media){
        echo '<tr>';
        echo '<td>'. $media->caption->text .'</td>';
        echo '<td>'. $media->id .'</td>';
        echo '<td>'. $media->type .'</td>';
        if($media->type == 'image'){
          $media_url = $media->images->standard_resolution->url;
        }else{
          $media_url = $media->videos->standard_resolution->url;
        }
        echo '<td>'. $media_url .'</td>';
        echo '<td><img src="'.$media_url.'"></td>';
        echo '</tr>';

        $media_text = $media->caption->text;
        $media_tipo = $media->type;
        $media_id = $media->id;
        
        $mediadata = [$media_text, $media_tipo, $media_url, $media_id];
        
        $count = $count + 1;
        $ultimoid = $media->id;
        if($count >= $randnum){break;}
    }
    echo '</table>';
    return $mediadata;
}

function CommentsMediaRecente($mediaID, $token){
    $url = 'https://api.instagram.com/v1/media/'.$mediaID.'/comments?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    echo '<br>';
    echo '<table border="1">';
    foreach($resjson->data as $comment){
        echo '<tr>';
        echo '<td>'. $comment->text .'</td>';
        echo '</tr>';
        $texto_acumulado = $texto_acumulado . ' ' . $comment->text;
    }
    echo '</table>';
    return $texto_acumulado;
}




$texto = $retorno[0];
$texto = str_replace("@","#", $texto);
$tipo = $retorno[1];
$media_url = $retorno[2];

echo '<br>'.$texto.'<br>';
echo '<br>'.$tipo.'<br>';
echo '<br><img src="'.$media_url.'"><br>';


if($tipo == 'image'){
  echo '<br>JPG<br>';
  $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.jpg';
  file_put_contents($media, file_get_contents($media_url));
  require_once('/app/Instagram/uploadPhoto.php');
  $ret_upload = Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
  //echo '<br>retorno = ' . var_dump($ret_upload) . '<br>';
}else{
  echo '<br>MP4<br>';
  $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.mp4';
  file_put_contents($media, file_get_contents($media_url));
  $resizemedia = 'resize'.$media;
  shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
  echo $resizemedia;
  require_once('/app/Instagram/uploadVideo.php');
  $ret_upload = Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
}
$mediaId = $ret_upload->media->id;


require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($Insta_username, $Insta_passw, $debug = false);

    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->comment($mediaId, $meus_comments);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
 
 

?>
