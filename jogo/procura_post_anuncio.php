<?php
session_start();
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = '232959010414896';
$app_secret = '80c616ceee375dfa9d564b33d4e1d451';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
$lista_de_pages = array('theballisonthetable','798157940318724');
foreach($lista_de_pages as $page){
  $response = $fb->get('/'.$page.'?fields=feed');
  $graphNode = $response->getGraphNode();
  foreach ($graphNode['feed'] as $key => $value) {
    echo '<br>' .$page.':'. $key . ':' . $value['id'] . ':' . $value['message'] . '<br>';
    echo '___________________________________________________';
    if (strpos($value['message'], '#apostinha') !== false) {
      echo '<br>Achou Post #apostinha<br>';    
      $response = $fb->get($value['id'].'?fields=comments.limit(999)');
      //var_dump($response->getDecodedBody());
      $graphNode = $response->getGraphNode();
      //echo $graphNode['feed'][0]['message'] . '<br><br>';
      foreach ($graphNode['comments'] as $key => $comentario) {
          echo '<br>' . $key .  ':' . $comentario['message'] . '<br>';
          //echo '<br>' . $key .  ':' . $comentario['created_time'] . '<br>';
          echo '<br>' . $key .  ':' . $comentario['from']['name'] . '<br>';
          echo '<br>' . $key .  ':' . $comentario['from']['id'] . '<br>';
      }
    }
  }
}

echo '<br>fim<br>';
?>
