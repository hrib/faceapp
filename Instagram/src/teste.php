<?php



$file = 'http://scontent.cdninstagram.com/t50.2886-16/13263135_582356541932632_1625233560_n.mp4';
$output_filename = 'imagem.jpg';
$output_filename2 = 'imagem2.jpg';


$output = shell_exec("ffmpeg -i ".$file);
var_dump($output);
//preg_match('/Duration: ([0-9]{2}):([0-9]{2}):([^ ,])+/', $output, $matches);
//$time = str_replace('Duration: ', '', $matches[0]);
//$time_breakdown = explode(":", $time);
//$total_seconds = round(($time_breakdown[0]*60*60) + ($time_breakdown[1]*60) + $time_breakdown[2]);
shell_exec("/app/vendor/ffmpeg/ffmpeg -y  -i ".$file." -f mjpeg -vframes 1 -ss 1 -s 640x640 " . $output_filename);
echo '<br>'.$total_seconds.'<img src="'.$output_filename.'"><br>';

shell_exec("/app/vendor/ffmpeg/ffmpeg -y  -i ".$file." -f mjpeg -vframes 1 -ss 3 -s 640x640 " . $output_filename2);
echo '<br>'.$total_seconds.'<img src="'.$output_filename2.'"><br>';

shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$file.' -vf scale=480:480 out.mp4');
echo 'out.mp4';


shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$file.' -vf "scale=iw*min(640/iw\,320/ih):ih*min(640/iw\,320/ih),pad=640:320:(640-iw)/2:(320-ih)/2" outb.mp4');
echo 'outb.mp4';



  
    @exec('/app/vendor/ffmpeg/ffmpeg -version 2>&1', $output, $returnvalue);
    if ($returnvalue === 0) {
        echo '5ffmpeg';
    }

echo 'fim';

//$teste = checkFFMPEG();
//echo $teste;

//createVideoIcon($file);

function checkFFMPEG()
{
    @exec('/vendor/bin/ffmpeg -version 2>&1', $output, $returnvalue);
    if ($returnvalue === 0) {
        return 'ffmpeg';
    }
    @exec('avconv -version 2>&1', $output, $returnvalue);
    if ($returnvalue === 0) {
        return 'avconv';
    }
    //return 'ffmpeg'; //forca que seja reconhecido
    return 'false';
}

function createVideoIcon($file)
{
    /* should install ffmpeg for the method to work successfully  */
    $ffmpeg = checkFFMPEG();
    echo '<br>AQUI FFMPEG:'.$ffmpeg.'<br>';
    if ($ffmpeg) {
        //generate thumbnail
        //$preview = sys_get_temp_dir().'/'.md5($file).'.jpg';
        $preview = 'imagem.jpg';
        @unlink($preview);

        //capture video preview
        $command = $ffmpeg.' -i "'.$file.'" -f mjpeg -ss 00:00:05 -vframes 1 "'.$preview.'" 2>&1';
        $command = $ffmpeg.' -itsoffset -1 -i '.$file.' -vframes 1 -filter:v '.$preview;
        @exec($command);
        echo '<br>DENTRO<br>';
        echo '<br>'.$command.'<br>';
        echo '<br><img src="'.$preview.'"><br>';
        return createIconGD($preview);
    }
    echo '<br>FORA<br>';
    return createIconGD('http://www.depositonaweb.com.br/wp-content/uploads/romario.jpg');
}

function createIconGD($file, $size = 100, $raw = true)
{
    list($width, $height) = getimagesize($file);
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }

    $image_p = imagecreatetruecolor($size, $size);
    $image = imagecreatefromstring(file_get_contents($file));

    imagecopyresampled($image_p, $image, 0, 0, $x, $y, $size, $size, $smallestSide, $smallestSide);
    ob_start();
    imagejpeg($image_p, null, 95);
    $i = ob_get_contents();
    ob_end_clean();

    //imagedestroy($image);
    //imagedestroy($image_p);
    echo '<br><img src="'.$image.'"><br>';
    echo '<br><img src="'.$image_p.'"><br>';
    return $i;
}


?>
