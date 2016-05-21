<?php

    require 'src/Instagram.php';

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
