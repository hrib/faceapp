<?php
session_start(); 
$url = 'https://www.whatismyip.net/';
function proxyRequest($url) {
  $fixieUrl = getenv("FIXIE_URL");
  $parsedFixieUrl = parse_url($fixieUrl);
  $proxy = $parsedFixieUrl['host'].":".$parsedFixieUrl['port'];
  $proxyAuth = $parsedFixieUrl['user'].":".$parsedFixieUrl['pass'];
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_PROXY, $proxy);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
  $server_output = curl_exec($ch);
  curl_close($ch);
  return $server_output;
}
function MEUproxyRequest($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_PROXY, '46.101.72.93:80');
  $server_output = curl_exec($ch);
  curl_close($ch);
  return $server_output;
}
function NOproxyRequest($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec($ch);
  curl_close($ch);
  return $server_output;
}
echo 'fixie';
$response = proxyRequest($url);
print_r($response);
echo 'meu';
$response = MEUproxyRequest($url);
print_r($response);
echo 'sem proxy';
$response = NOproxyRequest($url);
print_r($response);
echo 'fim';
?>
