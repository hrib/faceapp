<?php
session_start(); 
set_time_limit(100);
ini_set('max_execution_time', 100);



$curtidores = array('adrianoimpe1', 'adrianoimperador1', 'brmayfair', 'elly.tess7');
$curtidos = array('brmayfair', 'elly.tess7');

$curtidor = mt_rand(0, sizeof($curtidores) - 1);
$curtidor_passw = getenv('INSTA_PSW_LONDONFORHER');


$curtido = mt_rand(0, sizeof($curtidos) - 1);
$original_usernameName = $curtido;
//$originaluserid = 6859005418; // @brmayfair
$commentText = ':)';

var_dump($curtidor);
var_dump($original_usernameName);

require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($curtidor, $curtidor_passw, $debug = false);
    try {
        $i->login();
    } catch (InstagramException $e) {
        echo $e->getMessage();
        exit();
    }


    try {
        $originaluserid  = $i->searchUsername($original_usernameName);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    var_dump($originaluserid);


    try {
        $ret_originalfeed  = $i->getUserFeed($originaluserid);
    } catch (Exception $e) {
        echo $e->getMessage();
    }




$originalpost = PegaPosts($ret_originalfeed);
    $texto =  $originalpost[0]; 
    $texto = str_replace("@","#", $texto);
    $tipo = $originalpost[1];
    $media_url = $originalpost[2];
    $mediaId =  $originalpost[3];



try {
    $curtir = $i->like($mediaId);
} catch (Exception $e) {
    echo $e->getMessage();
}
var_dump($curtir);


try {
    $comentar = $i->comment($mediaId, $commentText);
} catch (Exception $e) {
    echo $e->getMessage();
}
var_dump($comentar);




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
