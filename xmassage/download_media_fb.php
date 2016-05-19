<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");


$pageOriginal = '1582615585402238';  //pagina que contem as midias


$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
$response = $fb->get('/?ids='. $pageOriginal .'&fields=posts.limit(100){source,full_picture,message}');
$graphNode = $response->getGraphNode();

echo '<table border="1" style="font-family:arial; font-size:7px;">';
foreach ($graphNode as $pagina) {
    $n_posts =  sizeof($pagina['posts']);
    $sorteio_media = mt_rand(0, $n_posts - 1);
    $textos = Array('#massage','#sensual','#book');
    $sorteio_texto = mt_rand(0, sizeof($textos) - 1);
    $rand_name = mt_rand(1,999) * mt_rand(1,999);
    file_put_contents("video".$rand_name.".mp4", file_get_contents($pagina['posts'][$sorteio_media]['source']));
    file_put_contents("image".$rand_name.".jpg", file_get_contents($pagina['posts'][$sorteio_media]['full_picture']));
    if($pagina['posts'][$sorteio]['source']<>""){
      $tipo_media = 'video';
    }else{
      $tipo_media = 'foto';
    }
      echo '<tr>';
      echo '<td>' . $sorteio_media . ':'. $sorteio_texto .'</td>';
      echo '<td>' . $pagina['posts'][$sorteio_media]['source'] . '</td>';
      echo '<td>' . $pagina['posts'][$sorteio_media]['full_picture'] . '</td>';
      echo '<td>' . $pagina['posts'][$sorteio_texto]['message'] . '</td>';
      echo '<td>';
      echo '</tr>';
}
echo '</table>';

?>
