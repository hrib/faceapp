<?php
$src = imagecreatefrompng('https://github.com/hrib/faceapp/raw/master/cloneInstagram/IMG-2975.PNG');
$dest = imagecreatefromjpeg('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');

list($width, $height) = getimagesize('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');
imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, 1470, 1471);


$media = 'media.jpg';
imagejpeg($dest, $media);  


imagedestroy($dest);
imagedestroy($src);
?>
