<?php

require 'src/Instagram.php';

function Instagram_UploadPhoto($username, $password, $photo, $caption){
    

    echo imagesx(imagecreatefromjpeg($photo)).':'.imagesy(imagecreatefromjpeg($photo)).'<br>';
    
    
    
    /////// CONFIG ///////
    //$username = '';
    //$password = '';
    $debug = false;
    
    //$photo = 'http://s.libertaddigital.com/fotos/galerias/brasilenos-neymar-barcelona-campnou/romario.jpg';     // path to the photo
    //$caption = 'phpteste';     // caption
    //////////////////////
    
    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->uploadPhoto($photo, $caption);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    return $e->getMessage();
}
