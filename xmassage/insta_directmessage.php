<?php
    
 //   $token = getenv('INS_APP_TOKEN');
    direct_share($media_id, $recipients, $text = null)
    
   /////// CONFIG ///////
    //$username = '';
    //$password = '';
    $debug = false;
    
    //echo '<br>aqui: '.$video.'<br>';
    
    //$videoteste = $video;
    //$out = 'imgout2.jpg';
    //$command = '/app/vendor/ffmpeg/ffmpeg  -i "'.$videoteste.'" -f mjpeg -ss 00:00:03 -vframes 1 "'.$out.'" 2>&1';
    //@exec($command);
    //echo '<br>comando2 uploadvideo:<img src="'.$out.'"><br>';
    //echo imagesx(imagecreatefromjpeg('http://apostagol.herokuapp.com/xmassage/imgout2.jpg')).':'.imagesy(imagecreatefromjpeg('http://apostagol.herokuapp.com/xmassage/imgout2.jpg')).'<br>';
    //echo imagesx(imagecreatefromjpeg('http://apostagol.herokuapp.com/imgout2.jpg')).':'.imagesy(imagecreatefromjpeg('http://apostagol.herokuapp.com/imgout2.jpg')).'<br>';
  
    
    
    
    //$video = 'http://ak3.picdn.net/shutterstock/videos/7764553/preview/stock-footage-electronic-recycling-plant-pov-cart-p-h-mp-pov-point-of-view-continuous-shot-of-cell-ph.mp4';     // path to the video
    //$caption = 'zzzzzzzzzzzzzzzzzzzzzzzz';     // caption
    //////////////////////
    
    $i = new Instagram($username, $password, $debug);
    
    try {
        $i->login();
    } catch (InstagramException $e) {
        $e->getMessage();
        exit();
    }
    
    try {
        $i->uploadVideo($video, $caption);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}    
    

    

?>
