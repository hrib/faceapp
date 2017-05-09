<?php
session_start(); 

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$paginaID = 'rconstantinoliberal';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
  

try {
  $response = $fb->get('/'. $paginaID .'?fields=feed');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 // When Graph returns an error
 echo 'Graph returned an error: ' . $e->getMessage();
 //exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 // When validation fails or other local issues
 echo 'Facebook SDK returned an error: ' . $e->getMessage();
 //exit;
}

$graphNode = $response->getGraphNode();
echo '<table border="1" style="font-family:arial; font-size:9px;">';
foreach ($graphNode['feed'] as $key => $value) {
  echo '<tr>';
  echo '<td>' . $key . ':' . $value['message'] . '</td>';
  echo '</tr>';
}
echo '</table>';
echo '<br><br>';
  
$response = $fb->get('/'. $paginaID .'?fields=posts{comments}');
$graphNode = $response->getGraphNode();
echo '<table border="1" style="font-family:arial; font-size:9px;">';
foreach ($graphNode['posts'] as $key => $value) {
  foreach ($value['comments'] as $key2 => $value2) {
    echo '<tr>';
    echo '<td>' . $key . ':' . $key2 . '>>>' . $value2['message'] . '</td>';
    echo '<td>' . $key . ':' . $key2 . '>>>' . $value2['from']['name'] . '</td>';
    echo '<td>' . $key . ':' . $key2 . '>>>' . $value2['from']['id'] . '</td>';
    echo '</tr>';
  }
} 
echo '</table>';

?>
