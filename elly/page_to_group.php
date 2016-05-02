<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
//require_once '../src/Facebook/autoload.php';

$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAFQlIs4qKKn0VYIPB2eH36bZBSSyt6787TuFSWPHZAcd2RE2KAtpcBsc8oy7cPyO6lOXEsvcvyySsfojeE6o7x8YHGqBKyAZAEeDC1GSDqRdXKVYSvR97rpmvxX9pvYi7xkJapycq84ZC5ZBhVUYZD';
$myalbumid = '187737951614546';

$groupid = array("211312725908106", "643876078994477", "766144473504153", "1108998679119682");
$pages_to_copy = array('Anonimasgostosasbr','804933709548543','GostosaD');
$rb = mt_rand(0,2);
$rc = mt_rand(0,2);
$pageOriginal = $pages_to_copy[$rb] . ',' . $pages_to_copy[$rc];

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);

echo '<table border="1" style="font-family:arial; font-size:7px;">';
$response = $fb->get('/?ids='. $pageOriginal .'&fields=name,posts.limit(2){message,link,full_picture,created_time}');
$graphNode = $response->getGraphNode();
foreach ($graphNode as $pagina) {
    foreach ($pagina['posts'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $key . ':' . $pagina['name'] . '</td>';
      echo '<td>' . $value['message'] . '</td>';
      echo '<td>' . $value['link'] . '</td>';
      echo '<td>' . $value['full_picture'] . '</td>';
      echo '<td>' . var_dump($value['created_time']) . '</td>'; //precisa disso pra funcionar
      $created_timeSTR = $value['created_time']->date;
      $created_time = strtotime($created_timeSTR);  //unix
      echo '<td>' . $key . ':' . $created_timeSTR . '</td>';
      $tempo = time();
      $diffunix = $tempo - $created_time;
      echo '<td> diff tempo:' . $diffunix . '</td>';
      if($diffunix < (3600 * 24 * 1)){
        PostCloneUser($fb, $myalbumid, $groupid, $access_token, $value['message'], $value['link'], $value['full_picture']);
      }else{
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        //echo '<td></td>';
      }
      echo '</tr>';
    }
}
echo '</table>';

function PostCloneUser($fb, $myalbumid, $groupid, $access_token, $message, $link, $picture){
  
  $textos = array("oi! Add?", "add ou follow?", "adiciona ou segue?", "adiciona?", "me segue", "follow me", "quem me add?", "quem me segue?", "oi! Add? :) ", "add ou follow? :) ", "adiciona ou segue? :) ", "adiciona? :) ", "me segue :) ", "follow me :) ", "quem me add? :) ", "quem me segue? :) ", "oi! Add? :* ", "add ou follow? :* ", "adiciona ou segue? :* ", "adiciona? :* ", "me segue :* ", "follow me :* ", "quem me add? :* ", "quem me segue? :* "); 
  $message = $textos[mt_rand(0,sizeof($textos)-1)];
  file_put_contents("image.jpg", file_get_contents($picture));
  if ((strpos($picture, 'https://scontent') !== false)  AND (strpos($link, '/videos/') == false)  ) {
    //imagem interna, posta como imagem
    echo '<td>Imagem interna</td>';
    $target = '/' . $myalbumid . '/photos';
    $linkData = [
      'source' => $fb->fileToUpload('image.jpg'),
      'message' => $message,
    ];
  } else {
    //imagem externa(link), video ou sem imagem e link, posta link/nada
    echo '<td>Link externo/nada</td>';
    $target = '/me/feed';
    $linkData = [
      'link' => $link,
      'message' => $message,
    ];
  }
  echo '<td>' . $target . '</td>';

  try {
    $response = $fb->post($target, $linkData, $access_token);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
  }
  sleep(5);
  //echo '<br>postou no user<br>';
  
  $userNode = $response->getGraphUser();
  //var_dump($userNode->getId());
  $link_post = 'https://www.facebook.com/' . $userNode['id'];
  //echo $link_post . '<br>';
  
  $up = sizeof($groupid) - 1;
  $ra = mt_rand(0,$up);
  $group_rand = $groupid[$ra];
  echo '<td>'. $group_rand .'</td>';
  
  $linkData = [
    'link' => $link_post,
    'message' => $message,
  ];
  
  try {
    $response = $fb->post('/' . $group_rand . '/feed', $linkData, $access_token);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
  }
  set_time_limit(25); 
  sleep(10);

  
}


?>
