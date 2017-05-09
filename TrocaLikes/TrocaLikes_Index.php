<?php
session_start(); 

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
  
  
try {
  $response = $fb->post($target, $data, $page_access_token);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
   // When Graph returns an error
   echo 'Graph returned an error: ' . $e->getMessage();
   //exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
   // When validation fails or other local issues
   echo 'Facebook SDK returned an error: ' . $e->getMessage();
   //exit;
}

?>
