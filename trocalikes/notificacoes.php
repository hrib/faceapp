<?php
session_start(); 

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'accessToken' => ,
  'default_graph_version' => 'v2.9',
  ]);
  
  

try {  
  $response = $fb->post('/{recipient_userid}/notifications?access_token=&href=?retorno=123&template=Voce precisa cadastrar sua pagina para comecar a ganhar likes!', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 // When Graph returns an error
 echo 'Graph returned an error: ' . $e->getMessage();
 exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 // When validation fails or other local issues
 echo 'Facebook SDK returned an error: ' . $e->getMessage();
 exit;
}

POST /{recipient_userid}/notifications?access_token=&href=?retorno=123&template=Voce precisa cadastrar sua pagina para comecar a ganhar likes!


?>
