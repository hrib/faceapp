<?php
session_start();
echo '<br>1<br>';
require_once 'src/Facebook/autoload.php';
echo '<br>2<br>';

$app_id = '1011974285544429';
$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
echo '<br>3<br>';

$response = $fb->get('204223673035117_364562457001237?fields=comments.limit(999)');
//var_dump($response->getDecodedBody());
echo '<br>4<br>';    
$graphNode = $response->getGraphNode();
//echo $graphNode['feed'][0]['message'] . '<br><br>';
foreach ($graphNode['comments'] as $key => $value) {
    //echo '<br>' . $key .  '>>>' . $value['message'] . '<br>';
    //echo '<br>' . $key .  '>>>' . $value['created_time'] . '<br>';
    echo $key .  '>>>' . $value['from']['name'] . '<br>';
    //echo '<br>' . $key .  '>>>' . $value['from']['id'] . '<br>';
}




echo '<br>6<br>';
?>
