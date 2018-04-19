<?php
$src_urls = array('https://wildtrails.in/wp-content/uploads/2015/06/Tiger-transparent.png',
             'https://i2.wp.com/freepngimages.com/wp-content/uploads/2018/04/transparent-background-eraser.png',
             'https://cdna.4imprint.com/prod/700/440.jpg',
             'http://goinkscape.com/wp-content/uploads/2015/04/transparent-5.png'
            );
$dest_urls = array('https://www.swiss-image.ch/fileadmin/_processed_/csm_Swiss_Image_sts8595_788cf78097.jpg',
              'https://i.pinimg.com/originals/41/8c/3c/418c3cdb8fe52098e025e15c76d46eff.jpg',
              'https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg',
              'http://keenthemes.com/preview/metronic/theme/assets/global/plugins/jcrop/demos/demo_files/image1.jpg',
              'http://www.our3dvr.com/data/wallpapers/57/WDF_1034875.jpg'
             );
foreach($dest_urls as $dest_url){
  foreach($src_urls as $src_url){
    $src = imagecreatefrompng($src_url);
    $dest = imagecreatefromjpeg($dest_url);

    //list($width, $height) = getimagesize('https://scontent-lht6-1.cdninstagram.com/vp/6f963c462b785c34af0325ea26e68095/5B56B7C0/t51.2885-15/e35/29717837_1713263295379805_3593801708695715840_n.jpg');
    list($src_width, $src_height) = getimagesize($src_url);
    $dimensao_src = min($src_width,$src_height);
    list($width, $height) = getimagesize($dest_url);
    $dimensao = min($width,$height);
    $diff_width = $width - $dimensao;
    $diff_height = $height - $dimensao;
    echo '' . $width . ', ' .  $height . ', ' .  $src_width . ', ' .  $src_height .'<br><br>';

    echo '' . $diff_width . ', ' .  $diff_height . ', ' .  0 . ', ' .  0 . ', ' .  $dimensao . ', ' .  $dimensao . ', ' .  $dimensao_src . ', ' .  $dimensao_src . '<br><br>';
    //imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
    imagecopyresampled($dest, $src, $diff_width, $diff_height, 0, 0, $dimensao, $dimensao, $src_width, $src_height);


    $media = 'media.jpg';
    imagejpeg($dest, $media);  
    echo '<img src="http://apostagol.herokuapp.com/cloneInstagram/media.jpg" ><br>';


    imagedestroy($dest);
    imagedestroy($src);
  }
}
?>
