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
    'href'=> '?texto=123',
    'access_token'=> $accessToken,
    'template'=> 'Você precisa cadastrar sua página para começar a ganhar likes'
);
//$sendnotification = $facebook->api('/USER_ID/notifications', 'post', $data);

$usuarios = array(1869740359960179, 1460453394021295, 282726058864346, 1198054596988388, 1861316050788025, 991497887654243, 1818953811754608, 734170893416116, 781786731995164);
foreach($usuarios as $item) {

    try {  
      //$response = $fb->post('/1580952695552959/notifications?access_token=' . $accessToken .' &href=?retorno=123&template=Voce precisa cadastrar sua pagina para comecar a ganhar likes!', $accessToken);
      $response = $fb->post('/'.$item.'/notifications', $data);

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
    echo $item. '<br>';
    print_r($graphNode );
    echo '<br><br><br>';
}

?>
