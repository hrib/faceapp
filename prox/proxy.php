<?php
echo $_GET['site'] . '<br>';

$context = stream_context_create([
    'http' => [
        'user_agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
    ],
]);
$html = file_get_contents($_GET['site'], false, $context);

print_r($http_response_header); // see response headers
echo $html;
?>
