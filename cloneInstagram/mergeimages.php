<?php
$src = imagecreatefrompng('https://github.com/hrib/faceapp/raw/master/cloneInstagram/Adobe_20180412_110534.png');
$dest = imagecreatefromjpeg('https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg');

list($width, $height) = getimagesize('https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg');
$dimensao = min($width,$height);
$diff_width = $width - $dimensao;
$diff_height = $height - $dimensao;
echo '' . $diff_width . ', ' .  $diff_height . ', ' .  0 . ', ' .  0 . ', ' .  $dimensao . ', ' .  $dimensao . ', ' .  654 . ', ' .  654 . '<br><br>';
//imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
//imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, 1470, 1470);
imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, 905, 905);


$media = 'media.jpg';
imagejpeg($dest, $media);  
echo '<img src="http://apostagol.herokuapp.com/cloneInstagram/media.jpg" ><br>';


imagedestroy($dest);
imagedestroy($src);
?>
