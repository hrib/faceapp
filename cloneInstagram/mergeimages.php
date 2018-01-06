<?php
$src = imagecreatefrompng('https://seeklogo.com/images/C/Clube_de_Regatas_do_Flamengo-logo-4F9152B932-seeklogo.com.png');
$dest = imagecreatefromjpeg('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');
//header('Content-Type: image/png');
//imagepng($dest);
//header('Content-Type: image/jpeg');
//imagejpeg($src);


//imagealphablending($dest, false);
//imagesavealpha($dest, true);

//imagecopyresampled($dest, $src, $src2x, $src2y, 0, 0, $src2w, $src2h, $src2w, $src2h);
imagecopyresampled($dest, $src, 0, 0, 0, 0, 550, 367, 550, 367);

//imagecopymerge($src, $dest, 0, 0, 0, 0, 550, 367, 100); //have to play with these numbers for it to work for you, etc.


//header('Content-Type: image/png');
//imagepng($dest);

header('Content-Type: image/jpeg');
imagejpeg($dest);


imagedestroy($dest);
imagedestroy($src);
?>
