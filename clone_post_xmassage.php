<?php
session_start();
require_once 'src/Facebook/autoload.php';

$mypageid = '1325563600793849';
$myalbumid = '1330244656992410';
//$pageOriginal = 'mblivre';
$pageOriginal = $mypageid;


$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
$db = new PDO($dsn);
$query = "SELECT id1, id2, id3, id4 FROM dados WHERE id1 = 'xmassage'";
$result = $db->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$result->closeCursor();

$app_id = $row["id2"];
$app_secret = $row["id3"];
$page_access_token = $row["id4"];

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
    $sorteio = mt_rand(round($n_posts/2,0), $n_posts - 1);
    $sorteio = 0;
    $sorteio_texto = mt_rand(round($n_posts/2,0), $n_posts - 1);
    
    //foreach ($pagina['posts'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $sorteio . ':'. $sorteio_texto .'</td>';
      echo '<td>' . $pagina['posts'][$sorteio]['source'] . '</td>';
      echo '<td>' . $pagina['posts'][$sorteio]['full_picture'] . '</td>';
      echo '<td>' . $pagina['posts'][$sorteio_texto]['message'] . '</td>';
      echo '<td>';
      file_put_contents("video".$mypageid.".mp4", file_get_contents($pagina['posts'][$sorteio]['source']));
      file_put_contents("image".$mypageid.".jpg", file_get_contents($pagina['posts'][$sorteio]['full_picture']));
      
      if($pagina['posts'][$sorteio]['source']<>""){
        $target = '/' . $mypageid . '/videos';
        $data = [
          'title' => $pagina['posts'][$sorteio_texto]['message'],
          'description' => $pagina['posts'][$sorteio_texto]['message'],
          'source' => $fb->videoToUpload('video'.$mypageid.'.mp4'),
          'message' => $pagina['posts'][$sorteio_texto]['message'],
        ];
      }else{
        $target = '/' . $myalbumid . '/photos';
        $data = [
          'source' => $fb->fileToUpload('image'.$mypageid.'.jpg'),
          'message' => $pagina['posts'][$sorteio_texto]['message'],
        ];
      }
        
        try {
          $response = $fb->post($target, $data, $page_access_token);
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
        var_dump($graphNode);
        echo 'Video ID: ' . $graphNode['id'];
      
      echo '</tr>';
}
echo '</table>';



?>
