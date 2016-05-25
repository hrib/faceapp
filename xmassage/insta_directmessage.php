<?php
    require __DIR__.'/../Instagram/src/Instagram.php';
    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = true;
    $media_id = '1258212803463406564_3235184663';
    
    $recipients = Array('185121648');

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
