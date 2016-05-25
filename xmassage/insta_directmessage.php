<?php
    require __DIR__.'/../src/Instagram.php';
    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = false;

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
