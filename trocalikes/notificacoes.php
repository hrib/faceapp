<?php
session_start(); 

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9',
  ]);
  
  $accessToken = $app_id . '|' . $app_secret;

$data = array(
    'href'=> 'https://apps.facebook.com/trocalikes/',
    'access_token'=> $accessToken,
    'template'=> 'Voce precisa cadastrar sua pagina para comecar a ganhar likes!'
);
//$sendnotification = $facebook->api('/USER_ID/notifications', 'post', $data);



try {  
  //$response = $fb->post('/1580952695552959/notifications?access_token=' . $accessToken .' &href=?retorno=123&template=Voce precisa cadastrar sua pagina para comecar a ganhar likes!', $accessToken);
  $response = $fb->post('/1580952695552959/notifications', $data);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
 // When Graph returns an error
 echo 'Graph returned an error: ' . $e->getMessage();
 exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 // When validation fails or other local issues
 echo 'Facebook SDK returned an error: ' . $e->getMessage();
 exit;
}
$graphNode = $response->getGraphNode();
print_r($graphNode );

?>
