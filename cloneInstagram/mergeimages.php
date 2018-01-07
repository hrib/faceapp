<?php
$src = imagecreatefrompng('https://github.com/hrib/faceapp/raw/master/cloneInstagram/IMG-2976.PNG');
$dest = imagecreatefromjpeg('https://www.thesun.co.uk/wp-content/uploads/2016/06/nintchdbpict000247118702.jpg?w=475');

list($width, $height) = getimagesize('https://www.thesun.co.uk/wp-content/uploads/2016/06/nintchdbpict000247118702.jpg?w=475');
$dimensao = min($width,$height);
$diff_width = $width - $dimensao;
$diff_height = $height - $dimensao;
echo '' . $diff_width . ', ' .  $diff_height . ', ' .  0 . ', ' .  0 . ', ' .  $dimensao . ', ' .  $dimensao . ', ' .  1470 . ', ' .  1470 . '<br><br>';
//imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
//imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, 1470, 1470);
imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, 1470, 1470);


$media = 'media.jpg';
imagejpeg($dest, $media);  
echo '<img src="http://apostagol.herokuapp.com/cloneInstagram/media.jpg" >';

imagedestroy($dest);
imagedestroy($src);
?>
