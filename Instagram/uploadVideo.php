<?php

require 'src/Instagram.php';

function Instagram_UploadVideo($username, $password, $video, $caption){
    
    /////// CONFIG ///////
    //$username = '';
    //$password = '';
    $debug = true;
    
    $video = 'http://ak3.picdn.net/shutterstock/videos/7764553/preview/stock-footage-electronic-recycling-plant-pov-cart-p-h-mp-pov-point-of-view-continuous-shot-of-cell-ph.mp4';     // path to the video
    //$caption = 'zzzzzzzzzzzzzzzzzzzzzzzz';     // caption
    //////////////////////
    
    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->uploadVideo($video, $caption);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
