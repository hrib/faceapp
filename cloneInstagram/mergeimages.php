<?php
$src = imagecreatefrompng('https://github.com/hrib/faceapp/raw/master/cloneInstagram/IMG-2975.PNG');
$dest = imagecreatefromjpeg('http://www.aliciafashionista.com/wp-content/uploads/2016/12/IMG_5867.jpg');

list($width, $height) = getimagesize('https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg');
$dimensao = min($width,$height);
$diff_width = $width - $dimensao;
$diff_$height = $height - $dimensao;

//imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
//imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, 1470, 1470);
imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, 1470, 1470);


$media = 'media.jpg';
imagejpeg($dest, $media);  
echo '<img src="http://apostagol.herokuapp.com/cloneInstagram/media.jpg" >';

imagedestroy($dest);
imagedestroy($src);
?>
