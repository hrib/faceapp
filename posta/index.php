<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$userToken = getenv('FB_TESTE_HM_USERTOKEN');

$postid = '1717137268528382_1934505183458255';

$agora = date("Y-m-d");
$chaves = array('divulgacao','blog+pessoal');
$chaves = array('blog+pessoal');
$chave = $chaves[mt_rand(0, sizeof($chaves) - 1)] 

$limite = mt_rand(1000, 5000);

$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.9', // change to 2.5
    'default_access_token' => $app_id . '|' . $app_secret
  ]);


try {
   $response = $fb->get('/search?q='.$chave.'&type=page&fields=id,name,fan_count,posts.limit(1)', $userToken);
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
while($graphNode) {
        foreach ($graphNode as $pagina) {
            echo '<tr>';
            echo '<td>' . $pagina['id'] . '</td>';
            echo '<td>' . $pagina['name'] . '</td>';
            echo '<td>' . $pagina['fan_count'] . '</td>';
            echo '<td>' . $pagina['posts'][0]['id'] . '</td>';
            echo '<td>' . date_format($pagina['posts'][0]['created_time'], 'Y-m-d') . '</td>';
            echo '<td>' . $pagina['posts'][0]['story'] . '</td>';
            if((date_format($pagina['posts'][0]['created_time'], 'Y-m-d') == $agora) AND ($pagina['fan_count'] > ($limite - 1000)) AND ($pagina['fan_count'] < $limite)){
                echo '<td>X</td>';
                pagina_post_comenta($fb, $pagina['posts'][0]['id'], $userToken);
            } else {
                echo '<td>-</td>';   
            }
            echo '</tr>';
            
        }
        $graphNode = $fb->next($graphNode);
}
echo '</table>';
echo '<br><br>';



exit;  

function pagina_post_comenta($fb, $postid, $userToken){
    $texto = 'Oi colega, queria te dar uma dica par voce ganhar mais likes aqui. Experimente esse aplicativo de troca de curtidas. 
    Cada usuario curte a pagina do outro e todo mundo ganha. 
    Abs. 
    
    https://trocalikes.herokuapp.com/';
    $media = 'https://apostagol.herokuapp.com/posta/maislikes.jpg';

    
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
}
 ?>
