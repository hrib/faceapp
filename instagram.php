<?php

function TransformaImg($target){
    //$target = 'https://media4.giphy.com/media/l41lZMjgleWARCZwI/200_s.gif';
    $filename = 'imagesqr'.mt_rand(1,1000)*mt_rand(1,1000).'.jpg';
    $filenamecrop = 'imagecrop'.mt_rand(1,1000)*mt_rand(1,1000).'.jpg';
    $filenamepreto = 'imagepreto'.mt_rand(1,1000)*mt_rand(1,1000).'.jpg';
    $ext = 'jpg';
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } else { 
      $img = imagecreatefromjpeg($target);
    }
    
    //crop metade do erro
    $image = $img;
    //$filename = 'image2.jpg';
    $width = imagesx($image);
    $height = imagesy($image);
    $thumb_width = $width;
    $thumb_height = $height;
    if($width>$height){$thumb_width = ($height+($width-$height)/2);}else{$thumb_height = ($width+($height-$width)/2);}
    
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
    imagejpeg($thumb, $filenamecrop, 80);
    echo '<br><img src="' . $filenamecrop . '">crop'. imagesx(imagecreatefromjpeg($filenamecrop)) .'x'. imagesy(imagecreatefromjpeg($filenamecrop));






    
    
    //preenche de preto a outra metade do erro
    if($width/$height > 1.20 OR $width/$height < 0.80){
        $im = imagecreatefromjpeg($filenamecrop);
        $width=ImageSX($im); $height=ImageSY($im); 
        if($width>$height){$ratio=1.20;}else{$ratio=0.80;}
        $width_out=$width; $height_out=$height;
        if ($height_out*$ratio<$width_out) {$height_out=floor($width_out/$ratio);} else {$width_out=floor($height_out*$ratio);}
        $left=round(($width_out-$width)/2);
        $top=round(($height_out-$height)/2);    
        $image_out = imagecreatetruecolor($width_out,$height_out);
        $bg_color = ImageColorAllocate ($image_out, 0, 0, 0);
        imagefill($image_out,0,0,$bg_color);
        imagecopy($image_out, $im, $left, $top, 0, 0, $width,$height);
        imagejpeg($image_out, $filenamepreto);
        echo '<br><img src="' . $filenamepreto . '">preto '. imagesx(imagecreatefromjpeg($filenamepreto)) .'x'. imagesy(imagecreatefromjpeg($filenamepreto));
        $novaimg = $filenamepreto;
    } else{
        $novaimg = $filenamecrop;
    }
    //se muito grande, resize
    $NovaW = imagesx(imagecreatefromjpeg($novaimg));
    $NovaH = imagesy(imagecreatefromjpeg($novaimg));
    $ratio = $NovaW/$NovaH;
    if($NovaH > 900 OR $NovaW > 900){
        echo '<br>'.$NovaW.' ou '.$NovaH.' >900';
        $tci = imagecreatetruecolor(750, 750*$ratio);
        imagecopyresampled($tci, $image_out, 0, 0, 0, 0, 750, 750*$ratio, $NovaW, $NovaH);
        imagejpeg($tci, $filename);
    } else{
        $filename = $novaimg;
    }
    
    echo '<br><img src="' . $filename . '">final ' . imagesx(imagecreatefromjpeg($filename)) .'x'. imagesy(imagecreatefromjpeg($filename));
    return $filename;
}



function PegaImagem(){
    $busca_array = array('elly tran hot','anri sugihara hot','asian boobs','hot asian girl', 'sexy asian female');
    $busca = $busca_array[mt_rand(0, sizeof($busca_array)-1)];
    $fileurl = BingSearch($busca);
    //$fileurl = 'http://i.imgur.com/FCnKV5M.jpg';
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $header = file_get_contents($fileurl, FALSE, $context);
    $image_filename = 'image'. mt_rand(0,1000) .'.jpg';
    echo '<br>' . $image_filename . '<br>';
    file_put_contents($image_filename, $header);
    return $image_filename;
}
function PegaTexto(){
    $textos = array("pegaria? :* ","pega ou passa? :*","o que acharam? :*","to sem ideia pra foto... ajuda ai.. :*","oq vcs estao fazendo agora hein? :*","essa ficou show! :*","que nota vc da? :*","qual seu signo? :*","De 1 a 10, oq acha? :*","entediada aqui.. alguem online? :*","vamos conversar? comenta seu whatsapp ai! :*","deixa seu whatsapp no comentario!","oi! Add?", "add ou follow?", "adiciona ou segue?", "adiciona?", "me segue", "follow me", "quem me add?", "quem me segue?", "oi! Add? :) ", "add ou follow? :) ", "adiciona ou segue? :) ", "adiciona? :) ", "me segue :) ", "follow me :) ", "quem me add? :) ", "quem me segue? :) ", "oi! Add? :* ", "add ou follow? :* ", "adiciona ou segue? :* ", "adiciona? :* ", "me segue :* ", "follow me :* ", "quem me add? :* ", "quem me segue? :* "); 
    $message = $textos[mt_rand(0,sizeof($textos)-1)];
    $taglist = array(' #20likes',' #all_shots',' #amazing',' #baby',' #beautiful',' #beauty',' #bestoftheday',' #bored',' #colorful',' #cool',' #cute',' #eyes',' #face',' #fashion',' #follow',' #follow4follow',' #followme',' #food',' #friends',' #fun',' #funny',' #girl',' #girls',' #guy',' #hair',' #handsome',' #hot',' #igdaily',' #igers',' #instacool',' #instadaily',' #instafollow',' #instago',' #instagood',' #instagramers',' #instalike',' #instalove',' #instamood',' #instaselfie',' #iphoneonly',' #iphonesia',' #kik',' #lady',' #life',' #like4like',' #look',' #love',' #me',' #photo',' #photooftheday',' #picoftheday',' #portrait',' #pretty',' #selfie',' #selfienation',' #selfies',' #selfietime',' #shamelessselefie',' #smile',' #style',' #swag',' #sweet',' #TagsForLikes',' #TagsForLikesApp',' #TFLers',' #tweegram',' #webstagram',' #london',' #UK',' #Brasil',' #brasileira',' #londres',' #gata',' #gostosa',' #novinha',' #linda',' #biquini',' #delicia',' #piriguete',' #praia',' #corpo',' #sarada',' #bunda');
    $message = $message . ' ' . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)] . $taglist[mt_rand(0,sizeof($taglist)-1)];
    return $message;
}
function BingSearch($busca){
    $url = 'https://api.datamarket.azure.com/Bing/Search/';
    $accountkey = '4bsI4zHy6e5Tr1IcXdYobAQ4gCujDVZ2fi0nXO7sdRk';
    $searchUrl = $url.'Image?$format=json&Query=';
    $queryItem = $busca;
    $context = stream_context_create(array(
        'http' => array(
        'request_fulluri' => true,
        'header'  => "Authorization: Basic " . base64_encode($accountkey . ":" . $accountkey)
        )
    ));
    $request = $searchUrl . urlencode( '\'' . $queryItem . '\'').'&Adult=%27Moderate%27&$skip=' . mt_rand(0,99); //&ImageFilters=%27Aspect%3ASquare%2BSize%3ALarge%27
    echo($request);
    $response = file_get_contents($request, 0, $context);
    $jsonobj = json_decode($response);
    $resultado = $jsonobj->d->results;
    $valor = $resultado[mt_rand(0,49)];
    echo '<br>';
    echo '<img src="' . $valor->MediaUrl . '">';
    TransformaImg($valor->MediaUrl);
    echo '<br> ________________ <br>';
    echo('<ul ID="resultList">');
    foreach($jsonobj->d->results as $value){                        
        echo('<li class="resultlistitem"><a href="' . $value->MediaUrl . '">');
        echo('<img src="' . $value->Thumbnail->MediaUrl. '"></li>');
        TransformaImg($value->Thumbnail->MediaUrl);
    }
    echo("</ul>");
    //return $value->MediaUrl;
    return $valor->MediaUrl;
}



function SendRequest($url, $post, $post_data, $user_agent, $cookies) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://i.instagram.com/api/v1/'.$url);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);

    if($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }

    if($cookies) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');            
    } else {
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    }

    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

   return array($http, $response);
}

function GenerateGuid() {
     return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(16384, 20479), 
            mt_rand(32768, 49151), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535));
}

function GenerateUserAgent() {  
     $resolutions = array('720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320');
     $versions = array('GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100');
     $dpis = array('120', '160', '320', '240');

     $ver = $versions[array_rand($versions)];
     $dpi = $dpis[array_rand($dpis)];
     $res = $resolutions[array_rand($resolutions)];

     return 'Instagram 4.'.mt_rand(1,2).'.'.mt_rand(0,2).' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi.'; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';
 }

function GenerateSignature($data) {
     return hash_hmac('sha256', $data, 'b4a23f5e39b5929e0666ac5de94c89d1618a2916');
}

function GetPostData($filename) {
    if(!$filename) {
        echo "The image doesn't exist ".$filename;
    } else {
        $post_data = array('device_timestamp' => time(), 
                        'photo' => new CURLFile($filename));
                        //'photo' => '@'.$filename);
        return $post_data;
    }
}


// Set the username and password of the account that you wish to post a photo to
$username = 'elly.tess7';
$password = 'wsimetria1';

//$username = 'london_for_her';
//$password = 'wwwwwwwwwsimetria1';

// Set the path to the file that you wish to post.
// This must be jpeg format and it must be a perfect square
$filename = PegaImagem(); //salva imagem crua orginal
$filename = TransformaImg($filename); //transforma imagem em quadrado
list($w_orig, $h_orig) = getimagesize($filename);
echo '<br>' . $w_orig . 'x' . $h_orig . '<br>';
$factor = $w_orig/$h_orig > 1 ? round($w_orig/$h_orig,7) : round($h_orig/$w_orig,7);
//$factor = 1.2005470;
//$fbtoken = 'EAABwzLixnjYBAFo1iDGTMIHaZBbrGulCliqx8IRoR6QZCtmax2MBukdJtrPqoMZBfkJNqaBqXUdaRVwexcVaVM5ZAzz27EcVZATaiZBE3NnZAsMdF4l9ZCqzjcwaJCFZBgKNndLkuZAwbx0LdhQvGpnZAkyoLPTvdHyAWBhz1UC0f31cySHjbyZAts7r2SVSVsCPZC5sZD';
//$fbtoken = 'EAABwzLixnjYBAMXFS65Oio2bQq6KtDe0TBSUZBzfzZAaML5b2cb65vtaQaAV9ZAHCyGmMYA3iZCzV5j1Om5GtY0wnwqdGbjmcruD1frErXSzXAHcxrsRqycZBoPvpBBixzcCLH6ZCHXWwLXiZCTlbJtwLXbebHyE1pP5ihrUgjfWA0iXggg0gxZC6h39zDS3ypEZD';
$fbtoken = 'EAABwzLixnjYBAJbATMzvNrXQ2TgOUZAZBVGHWjDZAlZCtajF5oZBRCCLVoGZCnwyjdfXJp1ePwqkmxtBqN4FXKiPGhV9yyI8D1Ab8ZBPPDV0RqZBhJRtkjUqCAdKi1S21tl5c4k9ZCJs04ekaqzgd8FLBgRl4pvgWU03CmGiTGZAuSo73d5wN0NndaTZAJwEftdAMcZD';

// Set the caption for the photo
$caption = PegaTexto();

// Define the user agent
$agent = GenerateUserAgent();

// Define the GuID
$guid = GenerateGuid();

// Set the devide ID
$device_id = "android-".$guid;

/* LOG IN */
// You must be logged in to the account that you wish to post a photo too
// Set all of the parameters in the string, and then sign it with their API key using SHA-256
$data ='{"device_id":"'.$device_id.'","guid":"'.$guid.'","username":"'.$username.'","password":"'.$password.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
$sig = GenerateSignature($data);
$data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=4';
$login = SendRequest('accounts/login/', true, $data, $agent, false);

if(strpos($login[1], "Sorry, an error occurred while processing this request.")) {
    echo "Request failed, there's a chance that this proxy/ip is blocked";
} else {            
    if(empty($login[1])) {
        echo "Empty response received from the server while trying to login";
    } else {            
        // Decode the array that is returned
        $obj = @json_decode($login[1], true);
        var_dump($obj);
        echo '<br>';
        if(empty($obj)) {
            echo "Could not decode the response: ".$body;
        } else {
            // Post the picture
            $data = GetPostData($filename);
            $post = SendRequest('media/upload/', true, $data, $agent, true);
            var_dump($post);
            echo '<br>';
            if(empty($post[1])) {
                 echo "Empty response received from the server while trying to post the image";
            } else {
                // Decode the response 
                $obj = @json_decode($post[1], true);

                if(empty($obj)) {
                    echo "Could not decode the response";
                } else {
                    $status = $obj['status'];

                    if($status == 'ok') {
                        // Remove and line breaks from the caption
                        $caption = preg_replace("/\r|\n/", "", $caption);

                        $media_id = $obj['media_id'];
                        $device_id = "android-".$guid;
                        $data = '{"share_to_facebook":"1","fb_access_token":"'.$fbtoken.'","edits":{"crop_original_size":['.$w_orig.','.$h_orig.'],"crop_zoom":'.$factor.',"crop_center":[0.0,-0.0]},"extra":{"source_width":'.$w_orig.',"source_height":'.$h_orig.'},"device_id":"'.$device_id.'","guid":"'.$guid.'","media_id":"'.$media_id.'","caption":"'.trim($caption).'","device_timestamp":"'.time().'","source_type":"5","filter_type":"0","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';   
                        echo '<br>'.$data.'<br>';
                        $sig = GenerateSignature($data);
                        $new_data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=4';

                       // Now, configure the photo
                       $conf = SendRequest('media/configure/', true, $new_data, $agent, true);

                       if(empty($conf[1])) {
                           echo "Empty response received from the server while trying to configure the image";
                       } else {
                           if(strpos($conf[1], "login_required")) {
                                echo "You are not logged in. There's a chance that the account is banned";
                            } else {
                                $obj = @json_decode($conf[1], true);
                                $status = $obj['status'];

                                if($status != 'fail') {
                                    echo "Success";
                                } else {
                                    echo 'Fail';
                                }
                            }
                        }
                    } else {
                        echo "Status isn't okay";
                    }
                }
            }
        }
    }
}

?>
