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


$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Cookie: foo=bar\r\n" .
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n" .
            "Accept-Language:en-US,en;q=0.8\r\n" .
            "Cache-Control:max-age=0\r\n" .
            "Connection:keep-alive\r\n" .
            "User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36\r\n"        
    ]
];

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$file = file_get_contents($Url, false, $context);
echo $file;


?>
