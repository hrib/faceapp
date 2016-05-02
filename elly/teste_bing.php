<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
//require_once '../src/Facebook/autoload.php';
$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAFQlIs4qKKn0VYIPB2eH36bZBSSyt6787TuFSWPHZAcd2RE2KAtpcBsc8oy7cPyO6lOXEsvcvyySsfojeE6o7x8YHGqBKyAZAEeDC1GSDqRdXKVYSvR97rpmvxX9pvYi7xkJapycq84ZC5ZBhVUYZD';
$myalbumid = '187737951614546';
$groupid = array("211312725908106", "643876078994477", "766144473504153", "1108998679119682");
$busca = 'modern interior design ';
//$pages_to_copy = array('Anonimasgostosasbr','804933709548543','GostosaD');
//$rb = rand(0,2);
//$rc = rand(0,2);
//$pageOriginal = $pages_to_copy[$rb] . ',' . $pages_to_copy[$rc];
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
echo '<table border="1" style="font-family:arial; font-size:7px;">';
echo '<tr>';
$bingurl = BingSearch($busca);
//PostCloneUser($fb, $myalbumid, $groupid, $access_token, $bingurl);
echo '</tr>';
echo '</table>';

function BingSearch($busca){
    $url = 'https://api.datamarket.azure.com/Bing/Search/';
    //$url = 'https://bingapis.azure-api.net/api/v5/images/search/';
    $accountkey = '4bsI4zHy6e5Tr1IcXdYobAQ4gCujDVZ2fi0nXO7sdRk';
    $searchUrl = $url.'Image?$format=json&Adult=%27Moderate%27&Query=';
    $queryItem = $busca;
    $context = stream_context_create(array(
        'http' => array(
        'request_fulluri' => true,
        'header'  => "Authorization: Basic " . base64_encode($accountkey . ":" . $accountkey)
        )
    ));
    $request = $searchUrl . urlencode( '\'' . $queryItem . '\'');
    echo($request);
    $response = file_get_contents($request, 0, $context);
    $jsonobj = json_decode($response);
    var_dump($jsonobj);
    $resultado = $jsonobj->d->results;
    echo '<br>';
    echo '<br>';
    var_dump($resultado[0]);
    echo '<br>';
    echo '<br>';
    $valor = $resultado[rand(0,49)];
    echo '<br>';
    echo '<img src="' . $valor->MediaUrl . '">';
    echo '<br> ________________ <br>';
    echo('<ul ID="resultList">');
    foreach($jsonobj->d->results as $value){                        
        echo('<li class="resultlistitem"><a href="' . $value->MediaUrl . '">');
        echo('<img src="' . $value->Thumbnail->MediaUrl. '"></li>');
        echo '<br>';
        echo($value->Title);
        echo '<br>';
    }
    echo("</ul>");
    return $value->MediaUrl;
}




function PostCloneUser($fb, $myalbumid, $groupid, $access_token, $bingurl){
  
  $textos = array("oi! Add?", "add ou follow?", "adiciona ou segue?", "adiciona?", "me segue", "follow me", "quem me add?", "quem me segue?", "oi! Add? :) ", "add ou follow? :) ", "adiciona ou segue? :) ", "adiciona? :) ", "me segue :) ", "follow me :) ", "quem me add? :) ", "quem me segue? :) ", "oi! Add? :* ", "add ou follow? :* ", "adiciona ou segue? :* ", "adiciona? :* ", "me segue :* ", "follow me :* ", "quem me add? :* ", "quem me segue? :* "); 
  $message = $textos[rand(0,sizeof($textos)-1)];

  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $header = file_get_contents($bingurl, FALSE, $context);
  file_put_contents("image.jpg", $header);
  
  $target = '/' . $myalbumid . '/photos';
  $linkData = [
    'source' => $fb->fileToUpload('image.jpg'),
    'message' => $message,
  ];

  echo '<td>' . $bingurl . '</td>';
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
  $ra = rand(0,$up);
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
