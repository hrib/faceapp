<?php
$target = 'http://the-ark.org/wp-content/uploads/2011/08/Interior-Design.jpg';
$newcopy = 'image.jpg';
$w = 400;
$h = 400;
$ext = 'jpg';
ak_img_resize($target, $newcopy, $w, $h, $ext);
echo '<img src="' . $newcopy . '">';

//$im = new imagick($target);
//$imageprops = $im->getImageGeometry();
//$width = $imageprops['width'];
//$height = $imageprops['height'];
//if($width > $height){
//    $newHeight = 80;
//    $newWidth = (80 / $height) * $width;
//}else{
//    $newWidth = 80;
//    $newHeight = (80 / $width) * $height;
//}
//$im->resizeImage($newWidth,$newHeight, imagick::FILTER_LANCZOS, 0.9, true);
//$im->cropImage (80,80,0,0);
//$im->writeImage( "image.jpg" );
//echo '<img src="image.jpg">';






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
