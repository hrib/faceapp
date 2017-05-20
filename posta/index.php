<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$userToken = getenv('FB_TESTE_HM_USERTOKEN');

$postid = '1717137268528382_1934505183458255';
$texto = '!';
$media = 'https://www.clipartsgram.com/image/347684311-14-like-symbol-on-facebook-free-cliparts-that-you-can-download-to-you-0wvbv9-clipart.jpg';


$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.9', // change to 2.5
    'default_access_token' => $app_id . '|' . $app_secret
  ]);





$limit = 25;
try {
   $response = $fb->get('/search?q=divulgacao&type=page&fields=id,name,fan_count,posts.limit(1)&limit='.$limit.'', $userToken);
 } catch(Facebook\Exceptions\FacebookResponseException $e) {
   // When Graph returns an error
   echo 'Graph returned an error: ' . $e->getMessage();
   //exit;
 } catch(Facebook\Exceptions\FacebookSDKException $e) {
   // When validation fails or other local issues
   echo 'Facebook SDK returned an error: ' . $e->getMessage();
   //exit;
 }

 $graphNode = $response->getGraphEdge();
  
  echo '<table border="1" style="font-family:arial; font-size:9px;">';
  foreach ($graphNode as $pagina) {
        echo '<tr>';
        echo '<td>' . $pagina['id'] . '</td>';
        echo '<td>' . $pagina['name'] . '</td>';
        echo '<td>' . $pagina['fan_count'] . '</td>';
        echo '<td>' . $pagina['posts'][0]['id'] . '</td>';
        echo '<td>' . date_format($pagina['posts'][0]['created_time'], 'Y-m-d') . '</td>';
        echo '<td>' . $pagina['posts'][0]['story'] . '</td>';
        echo '</tr>';
  }
  echo '</table>';

echo '<br>.<br>';
echo $graphNode['paging']['next'];
echo '<br>.<br>';
echo $graphNode[1]['next'];

while(($graphNode['paging']) && array_key_exists("next", $graphNode["paging"])) {
        $response = $fb->get('/search?q=divulgacao&type=page&fields=id,name,fan_count,posts.limit(1)&limit='.$limit.'&offset='.$offset.'', $userToken);
        $graphNode = $response->getGraphEdge();
        $offset += $limit;
        echo '<table border="1" style="font-family:arial; font-size:9px;">';
        foreach ($graphNode as $pagina) {
            echo '<tr>';
            echo '<td>' . $pagina['id'] . '</td>';
            echo '<td>' . $pagina['name'] . '</td>';
            echo '<td>' . $pagina['fan_count'] . '</td>';
            echo '<td>' . $pagina['posts'][0]['id'] . '</td>';
            echo '<td>' . date_format($pagina['posts'][0]['created_time'], 'Y-m-d') . '</td>';
            echo '<td>' . $pagina['posts'][0]['story'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
}
 
echo '<br><br>';
 
  print_r($graphNode);
  exit;  


$data = [
  'source' => $fb->fileToUpload($media),
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
