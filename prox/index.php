<?php
$proxied_headers = array('Set-Cookie', 'Content-Type', 'Cookie', 'Location');

$proxy_request_url = str_replace('"', "", $_GET['link']);
echo $proxy_request_url . '<br>';
//$proxy_request_url = urlencode($proxy_request_url);
//echo $proxy_request_url . '<br>';
/* Init CURL */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $proxy_request_url);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
/* Collect and pass client request headers */
if(isset($_SERVER['HTTP_COOKIE']))     
{ 
    $hdrs[]="Cookie: " . $_SERVER['HTTP_COOKIE'];        
}
if(isset($_SERVER['HTTP_USER_AGENT'])) 
{ 
    $hdrs[]="User-Agent: " . $_SERVER['HTTP_USER_AGENT']; 
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrs);
/* pass POST params */
if( sizeof($_POST) > 0 )
{ 
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST)); 
}
$res = curl_exec($ch);
curl_close($ch);
/* parse response */
list($headers, $body) = explode("\r\n\r\n", $res, 2);
$headers = explode("\r\n", $headers);
$hs = array();
foreach($headers as $header)
{
    if( false !== strpos($header, ':') )
    {
        list($h, $v) = explode(':', $header);
        $hs[$h][] = $v;
    }
    else 
    {
        $header1  = $header;
    }
}
/* set headers */
list($proto, $code, $text) = explode(' ', $header1);
header($_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $text);
foreach($proxied_headers as $hname)
{
    if( isset($hs[$hname]) )
    {
        foreach( $hs[$hname] as $v )
        {
            if( $hname === 'Set-Cookie' ) 
            {
                header($hname.": " . $v, false);
            }
            else
            {
                header($hname.": " . $v);
            }
        }
    }
}

echo '<br><br>**************************************************************<br><br>';
echo '<iframe srcdoc="' . die($body) . '" width="1000" height="800" scrolling="yes"></iframe>';
//var_dump($body);

//echo '<br><br>**************************************************************<br><br>';
//var_dump($body);
//echo '<br><br>**************************************************************<br><br>';
//echo '<div>';
//die($body);
//echo '</div>';
