<?php
    require __DIR__.'/../Instagram/src/Instagram.php';
    //CompartilhaMedia('3111227949'); 


function CompartilhaMedia($userid){    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = true;
    
    $media_id = '1258383939186778883_3235184663';
    $recipients = Array($userid);
    //$text = 'I would like to invite you to check my instagram. 30% discount for new clients. :)';
    $text = 'Have you seen this?';

    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    try {
        $i->direct_share($media_id, $recipients, $text);
    } catch (Exception $e) {
        $e->getMessage();
    }
}
?>
