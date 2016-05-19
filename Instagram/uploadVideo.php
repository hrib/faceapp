<?php

require '/src/Instagram.php';

/////// CONFIG ///////
$username = 'xmassageuk';
$password = 'wsimetria1';
$debug = true;


//$urlvideo = 'https://video.xx.fbcdn.net/v/t43.1792-2/13185023_1122006934530084_2137460055_n.mp4?efg=eyJybHIiOjE1MDAsInJsYSI6MTAyNCwidmVuY29kZV90YWciOiJzdmVfaGQifQ%3D%3D&rl=1500&vabr=167&oh=d513940abd35bcd3f52cf8235a64be0e&oe=573D2C6B';
//$filename = "video.mp4";
//file_put_contents($filename, file_get_contents($urlvideo));

$video = 'http://ak3.picdn.net/shutterstock/videos/7764553/preview/stock-footage-electronic-recycling-plant-pov-cart-p-h-mp-pov-point-of-view-continuous-shot-of-cell-ph.mp4';     // path to the video
//$video = 'http://scontent.cdninstagram.com/t50.2886-16/13248122_273519396328112_1078893652_s.mp4';
$caption = 'zzzzzzzzzzzzzzzzzzzzzzzz';     // caption
//////////////////////

$i = new Instagram($username, $password, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}

try {
    $i->uploadVideo($video, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}
