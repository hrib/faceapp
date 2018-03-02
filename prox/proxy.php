<?php
echo $_GET['site'] . '<br>';


$Url = $_GET['site'];


$header=array('GET /1575051 HTTP/1.1',
'Host: adfoc.us',
'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language:en-US,en;q=0.8',
'Cache-Control:max-age=0',
'Connection:keep-alive',
'Host:adfoc.us',
'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
);



if (!function_exists('curl_init')){
    die('CURL is not installed!');
}



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $Url);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // add this one, it seems to spawn redirect 301 header
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36'); // spoof
$output = curl_exec($ch);
curl_close($ch);

echo $output; // use echo to show contents


?>
