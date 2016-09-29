<?php
session_start(); 

    try {
        $comenta = $i->getHashtagFeed($hashtagString, $maxid = null);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    var_dump($comenta);




?>
