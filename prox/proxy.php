<?php
echo $_GET['site'] . '<br>';


$Url = $_GET['site'];

if (!function_exists('curl_init')){
    die('CURL is not installed!');
}
$ch = curl_init($Url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // add this one, it seems to spawn redirect 301 header
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'); // spoof
$output = curl_exec($ch);
curl_close($ch);

echo $output; // use echo to show contents


?>
