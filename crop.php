<?
function load_file_from_url($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $str = curl_exec($curl);
    curl_close($curl);
    return $str;
}

class cropImage{
 var $imgSrc,$myImage,$thumb;
 function setImage($image) {
       //Your Image
         $this->imgSrc = $image; 

       //create image from the jpeg
         $this->myImage = imagecreatefromstring($this->imgSrc) or die("Error: Cannot find image!"); 
         $this->thumb = imagecreatetruecolor(200, 112);
     imagecopyresampled($this->thumb, $this->myImage, 0, 0, 0, 45, 200, 112, 480, 270);       
    }
    function renderImage()
    {                            
         header('Content-type: image/jpeg');
         imagejpeg($this->thumb);
         imagedestroy($this->thumb); 
         //imagejpeg($this->myImage);
         //imagedestroy($this->myImage); 
    }
}  

    $image = new cropImage;
    $image->setImage(load_file_from_url($_GET['http://i.imgur.com/FCnKV5M.jpg']));
    $image->renderImage();

?>
