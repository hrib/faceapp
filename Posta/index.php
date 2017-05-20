<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$userToken = getenv('FB_TESTE_HM_USERTOKEN');

$postid = '1092972697443376_1485285631545412';
$texto = '!';
    
$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.6', // change to 2.5
    'default_access_token' => $app_id . '|' . $app_secret
  ]);

$data = [
  'message' => $texto,
];

$target = '/' . $postid . '/comments';
 
try {
   $response = $fb->post($target, $data, $userToken);
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
