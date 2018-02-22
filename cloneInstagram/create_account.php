<?php
session_start(); 
set_time_limit(100);
ini_set('max_execution_time', 100);

$user_name = 'adrianoimperador2';
$user_name = getenv('INSTA_PSW_LONDONFORHER');

require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($user_name, $user_passw, $debug = false);

try {
    $i->login();
} catch (InstagramException $e) {
    echo $e->getMessage();
    exit();
}

?>
