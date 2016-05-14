<?php
session_start();

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = '232959010414896';
$app_secret = '80c616ceee375dfa9d564b33d4e1d451';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6',
  'default_access_token' => $app_id . '|' . $app_secret
]);

$lista_de_pages = array('theballisonthetable','798157940318724');

echo '<table border="1" style="font-family:arial; font-size:7px;">';
foreach($lista_de_pages as $page){
  $response = $fb->get('/'.$page.'?fields=feed.limit(100)');
  $graphNode = $response->getGraphNode();
  foreach ($graphNode['feed'] as $key => $value) {
    echo '<tr>';
    echo '<td>' .$page.':'. $key . ':' . $value['id'] . ':' . $value['message'] . '</td>';
    echo '</tr>';
    if (strpos($value['message'], '#apostinha') !== false) {
      $response = $fb->get($value['id'].'?fields=comments.limit(999)');
      $graphNode = $response->getGraphNode();
      foreach ($graphNode['comments'] as $key => $comentario) {
          echo '<tr>';
          echo '<td>' . $key .  ':' . $comentario['message'] . '</td>';
          echo '<td>' . $key .  ':' . $comentario['from']['name'] . '</td>';
          echo '<td>' . $key .  ':' . $comentario['from']['id'] . '</td>';
          $myDate = $comentario['created_time'];
          $created_timeSTR = $myDate->format('Y-m-d H:i:s'); 
          $created_time = strtotime($created_timeSTR); //unix
          echo '<td>' . $key . ':' . $created_timeSTR . '</td>';
          echo '</tr>';
      }
    }
  }
}
echo '</table>';
echo '<br>fim<br>';
?>
