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


$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
  )
);


$context = stream_context_create($options);

// Open the file using the HTTP headers set above
$file = file_get_contents($Url, false, $context);
echo $file;


?>
