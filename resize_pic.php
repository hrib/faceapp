<?php
$target = 'https://media4.giphy.com/media/l41lZMjgleWARCZwI/200_s.gif';
$ext = 'gif';
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } else { 
      $img = imagecreatefromjpeg($target);
    }


//$im=imagecreatefromjpeg ($imgPath);
$filename = 'image3.jpg';
$im = $img;
$width=ImageSX($im); $height=ImageSY($im); $ratio=16/9;
$width_out=$width; $height_out=$height;
if ($height_out*$ratio<$width_out) {$height_out=floor($width_out/$ratio);} else {$width_out=floor($height_out*$ratio);}
$left=round(($width_out-$width)/2);
$top=round(($height_out-$height)/2);
$image_out = imagecreatetruecolor($width_out,$height_out);
$bg_color = ImageColorAllocate ($image_out, 0, 0, 0);
imagefill($image_out,0,0,$bg_color);
imagecopy($image_out, $im, $left, $top, 0, 0, $width,$height);
//imagejpeg($image_out);
imagejpeg($image_out, $filename);
echo '<br><img src="' . $filename . '">';



//$image = imagecreatefromjpeg($_GET[$target]);
$image = $img;

$filename = 'image2.jpg';

$thumb_width = 200;
$thumb_height = 150;

$width = imagesx($image);
$height = imagesy($image);

$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;

if ( $original_aspect >= $thumb_aspect )
{
   // If image is wider than thumbnail (in aspect ratio sense)
   $new_height = $thumb_height;
   $new_width = $width / ($height / $thumb_height);
}
else
{
   // If the thumbnail is wider than the image
   $new_width = $thumb_width;
   $new_height = $height / ($width / $thumb_width);
}

$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

// Resize and crop
imagecopyresampled($thumb,
                   $image,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);
imagejpeg($thumb, $filename, 80);
echo '<br><img src="' . $filename . '">';










$target = 'https://media4.giphy.com/media/l41lZMjgleWARCZwI/200_s.gif';
$newcopy = 'image.gif';
$w = 250;
$h = 250;
$ext = 'gif';
ak_img_resize($target, $newcopy, $w, $h, $ext);
echo '<img src="' . $newcopy . '">';


function ak_img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } else { 
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}

?>
