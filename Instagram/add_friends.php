<?php

    require 'src/Instagram.php';
    
    $username = getenv('INSTA_USR_LONDONFORHER');
    $password = getenv('INSTA_PSW_LONDONFORHER');
    $debug = true;

    $i = new Instagram($username, $password, $debug);
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->modifyRelationship('follow', 1574083);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

?>
