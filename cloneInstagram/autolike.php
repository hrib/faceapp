<?php
session_start(); 
set_time_limit(100);
ini_set('max_execution_time', 100);

$Insta_username_antiblock = 'adrianoimpe1';
$Insta_passw_antiblock = getenv('INSTA_PSW_LONDONFORHER');
$originaluserid = 6859005418; // @raissaralves

require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($Insta_username_antiblock, $Insta_passw_antiblock, $debug = false);
    try {
        $i->login();
    } catch (InstagramException $e) {
        echo $e->getMessage();
        exit();
    }
    
    try {
        $ret_originalfeed  = $i->getUserFeed($originaluserid);
    } catch (Exception $e) {
        echo $e->getMessage();
    }


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


?>
