<?php

require '../src/Instagram.php';

/////// CONFIG ///////
$username = 'xmassageuk';
$password = 'wsimetria1';
$debug = true;

$photo = 'http://s.libertaddigital.com/fotos/galerias/brasilenos-neymar-barcelona-campnou/romario.jpg';     // path to the photo
$caption = 'phpteste';     // caption
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
