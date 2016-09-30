<?php
session_start(); 

$aleatorio = mt_rand(1, 12);
if($aleatorio < 4){
$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');
$originaluserid = 2071958799; //manda..  carro
}else if($aleatorio < 7){
$Insta_username = getenv('INSTA_USR_2');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 1443400890; // fashionzine
}else if($aleatorio < 10){
$Insta_username = getenv('INSTA_USR_3');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 43175003; // @louisewawrzynska  
}else {
$Insta_username = getenv('INSTA_USR_4');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 3674749893; // @1lifeforyou  
}


require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($Insta_username, $Insta_passw, $debug = false);
    try {
        $i->login();
    } catch (InstagramException $e) {
        echo $e->getMessage();
        exit();
    }
    
    try {
        $ret_myfeed = $i->getSelfUserFeed();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    try {
        $ret_originalfeed  = $i->getUserFeed($originaluserid);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $mypost = PegaPosts($ret_myfeed);

    $originalpost = PegaPosts($ret_originalfeed);
        $texto =  $originalpost[0];   
        $texto = str_replace("@","#", $texto);
        $tipo = $originalpost[1];
        $media_url = $originalpost[2];
        $mediaId =  $originalpost[3];

    if($texto == $mypost[0]){exit;}



    try {
        $ret_mediacomments  = $i->getMediaComments($mediaId);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    //var_dump($ret_mediacomments);

    $TOPcomment = $ret_mediacomments["comments"][0]["text"] . $ret_mediacomments["comments"][1]["text"] . $ret_mediacomments["comments"][2]["text"] . ' #instagram ' ;
    preg_match_all("/(#\w+)/", $TOPcomment, $matches);
    //$meus_comments = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2] . ' ' . $matches[0][3] . ' ' . $matches[0][4] . ' ' . $matches[0][5] . ' ' . $matches[0][6] . ' ' . $matches[0][7] . ' ' . $matches[0][8] . ' ' . $matches[0][9] . ' ' . $matches[0][10] . ' ' . $matches[0][11] . ' ' . $matches[0][12] . ' ' . $matches[0][13] . ' ' . $matches[0][14] . ' ' . $matches[0][15] . ' ' . $matches[0][16] . ' ' . $matches[0][17] . ' ' . $matches[0][18] . ' ' . $matches[0][19] . ' ' . $matches[0][20] ;
    $meus_comments = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2] . ' ' . $matches[0][3] . ' ' . $matches[0][4] . ' ' . $matches[0][5] . ' ' . $matches[0][6] . ' ' . $matches[0][7] . ' ' . $matches[0][8] . ' ' . $matches[0][9] . ' ' . $matches[0][10] ;
        
    echo '<br><br> Top comment = ' . $TOPcomment . '<br>';
    echo '<br><br> Meus comments = ' . $meus_comments . '<br>';

    if($tipo == 1){
      echo '<br>JPG<br>';
      $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.jpg';
      file_put_contents($media, file_get_contents($media_url));
        
            try {
                $ret_upload = $i->uploadPhoto($media, $texto);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

      //require_once('/app/Instagram/uploadPhoto.php');
      //$ret_upload = Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
    }else{
      echo '<br>MP4<br>';
      $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.mp4';
      file_put_contents($media, file_get_contents($media_url));
      $resizemedia = 'resize'.$media;
      shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
      echo $resizemedia;
        
            try {
                $ret_upload = $i->uploadVideo($resizemedia, $texto);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
        
        
      //require_once('/app/Instagram/uploadVideo.php');
      //$ret_upload = Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
    }
    echo '<br>retorno = ' . var_dump($ret_upload) . '<br>';
    $mediaId_posted = $ret_upload['media']['id'];
    echo '<br>mediaid = ' . $mediaId_posted . '<br>';
    
    try {
        $comenta = $i->comment($mediaId_posted, $meus_comments);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    //$comenta = $i->comment($mediaId_posted, $meus_comments);
    var_dump($comenta);
 

function PegaPosts($feed){
    //$resjson = json_decode($feed);
    //var_dump($resjson);    
    echo '<br>';
    echo '<table border="1">';
    foreach($feed["items"] as $media){
        echo '<tr>';
        echo '<td>'. $media["caption"]["text"] .'</td>';
        echo '<td>'. $media["id"] .'</td>';
        echo '<td>'. $media["media_type"] .'</td>';
        if($media["media_type"]  == 1){
          $media_url = $media["image_versions2"]["candidates"][0]["url"];
        }else{
          $media_url = $media["video_versions"][0]["url"];
        }
        echo '<td>'. $media_url .'</td>';
        echo '<td><img src="'.$media_url.'"></td>';
        echo '</tr>';

        $media_text = $media["caption"]["text"];
        $media_tipo = $media["media_type"];
        $media_id = $media["id"];
        
        $mediadata = [$media_text, $media_tipo, $media_url, $media_id];
        break; //pega so TOP post
    }
    echo '</table>';
    return $mediadata;
}

require_once('ComentaByTag.php');

exit;



?>
