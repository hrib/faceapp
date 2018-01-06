<?php
$src = imagecreatefrompng('http://78.media.tumblr.com/caf79905a6fc06b378bee73ad0d87368/tumblr_oi1eqkSvdL1vl7x77o1_1280.png');
$dest = imagecreatefromjpeg('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');
//header('Content-Type: image/png');
//imagepng($dest);
//header('Content-Type: image/jpeg');
//imagejpeg($src);


//imagealphablending($dest, false);
//imagesavealpha($dest, true);

//imagecopyresampled($dest, $src, $src2x, $src2y, 0, 0, $src2w, $src2h, $src2w, $src2h);
imagecopyresampled($dest, $src, 0, 0, 0, 0, 550, 367, 680, 680);

//imagecopymerge($src, $dest, 0, 0, 0, 0, 550, 367, 100); //have to play with these numbers for it to work for you, etc.


//header('Content-Type: image/png');
//imagepng($dest);

header('Content-Type: image/jpeg');
imagejpeg($dest);


imagedestroy($dest);
imagedestroy($src);
?>
