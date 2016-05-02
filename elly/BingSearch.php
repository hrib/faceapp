<?php
session_start();
$url = 'https://api.datamarket.azure.com/Bing/Search/';
$accountkey = '4bsI4zHy6e5Tr1IcXdYobAQ4gCujDVZ2fi0nXO7sdRk';
$searchUrl = $url.'Image?$format=json&Query=';
$queryItem = 'selfie gostosa';
$context = stream_context_create(array(
    'http' => array(
    'request_fulluri' => true,
    'header'  => "Authorization: Basic " . base64_encode($accountkey . ":" . $accountkey)
    )
));
$request = $searchUrl . urlencode( '\'' . $queryItem . '\'');
echo($request);
$response = file_get_contents($request, 0, $context);
$jsonobj = json_decode($response);
echo('<ul ID="resultList">');
foreach($jsonobj->d->results as $value){                        
    echo('<li class="resultlistitem"><a href="' . $value->MediaUrl . '">');
    echo('<img src="' . $value->Thumbnail->MediaUrl. '"></li>');
}
echo("</ul>");
?>
