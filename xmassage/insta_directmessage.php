<?php
    require __DIR__.'/../Instagram/src/Instagram.php';
    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = false;
    $media_id = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    
    $recipients = Array('204879346');

    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->direct_share($media_id, $recipients, $text = null);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

?>
