<?php
    require __DIR__.'/../Instagram/src/Instagram.php';

function CompartilhaMedia($userid){    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = true;
    
    $media_id = '1258212803463406564_3235184663';
    $recipients = Array($userid);
    $text = 'I would like to invite you to check my instagram. 30% discount for new clients. :)';

    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->direct_share($media_id, $recipients, $text);
    } catch (Exception $e) {
        //echo $e->getMessage();
    }
}
?>
