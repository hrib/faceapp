<?php
$src = imagecreatefrompng('https://wildtrails.in/wp-content/uploads/2015/06/Tiger-transparent.png');
$dest = imagecreatefromjpeg('https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg');

//list($width, $height) = getimagesize('https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg');
list($src_width, $src_height) = getimagesize($src);
$dimensao_src = min($src_width,$src_height);
list($width, $height) = getimagesize($dest);
$dimensao = min($width,$height);
$diff_width = $width - $dimensao;
$diff_height = $height - $dimensao;
echo '' . $width . ', ' .  $height . ', ' .  $src_width . ', ' .  $src_height .'<br><br>';

echo '' . $diff_width . ', ' .  $diff_height . ', ' .  0 . ', ' .  0 . ', ' .  $dimensao . ', ' .  $dimensao . ', ' .  $dimensao_src . ', ' .  $dimensao_src . '<br><br>';
//imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, $dimensao_src, $dimensao_src);


$media = 'media.jpg';
imagejpeg($dest, $media);  
echo '<img src="http://apostagol.herokuapp.com/cloneInstagram/media.jpg" ><br>';


imagedestroy($dest);
imagedestroy($src);
?>
