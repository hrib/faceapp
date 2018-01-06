<?php
$dest = imagecreatefrompng('https://quique123.files.wordpress.com/2013/03/screen-shot-2013-03-02-at-11-40-03-am.png');
$src = imagecreatefromjpeg('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');
//header('Content-Type: image/png');
//imagepng($dest);
//header('Content-Type: image/jpeg');
//imagejpeg($src);


imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 0, 0, 0, 0, 550, 367, 100); //have to play with these numbers for it to work for you, etc.

header('Content-Type: image/png');
imagepng($dest);

imagedestroy($dest);
imagedestroy($src);
?>
