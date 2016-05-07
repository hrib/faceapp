<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
//require_once '../src/Facebook/autoload.php';
$app_id = '606368529464047';
$app_secret = 'be1d03810b35a38264d20dd3517f6415';
$access_token = 'CAAInfSzNOu8BAAfXYZBrfWnxMSB7uQ63ZBOFhIu1S7EbZAVF5ZBZCtdf07uR4no01ZCoVP0r47jVtZANiTZB0z84I4X8UqNvFjriZBE7RY9kFDZAeT4oX7ZAU2ehXYVY0jKjf7MQTMZAW7c3hCyz1q4MZBhdYIJRvWA6ZCLsQCHO1a8j2rTXH2S99T8u0O8HXhnQHdOwlGT6hhdOcpTgZDZD';
$myalbumid = '1466932153632337';
//$groupid = array('561826547222009','1439965572953215','229780477119126','301278086667948','657208374311730','842223955817133','298375840323419','622510464471215','437963806283720','260802810696610','755714287874029','1617322898556878','106242386136663','1679744542276823','1602088460111493','125530347511585','303578036343144');
$groupid = array('842223955817133','298375840323419','301278086667948','229780477119126','1439965572953215','561826547222009','1679744542276823','622510464471215','106242386136663','1020175684706954','437963806283720');

//$busca_array = array('selfie gostosa','selfie girls underboobs','Large Underboob Selfies','Wet Underboob','No Bra Selfie','Cougar Selfies','Slutty Selfies','Dirty Selfies iPhone','Selfie Hot But','selfie lingerie','Bikini Selfie','Hot Selfies');
//$busca_array = array('asian selfie girls','selfie girls underboobs asian','elly tran selfie','elly tran lingerie','anri sugihara hot','anri sugihara lingerie','asian girl hot selfie','No Bra asian Selfie','Elly Tran Ha Instagram');
$busca_array = array('elly tran selfie','anri sugihara hot','asian boobs','No Bra asian Selfie');

$busca = $busca_array[mt_rand(0, sizeof($busca_array)-1)];
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
PostCloneUser($fb, $myalbumid, $groupid, $access_token, $bingurl);
echo '</tr>';
echo '</table>';

function BingSearch($busca){
    $url = 'https://api.datamarket.azure.com/Bing/Search/';
    $accountkey = '4bsI4zHy6e5Tr1IcXdYobAQ4gCujDVZ2fi0nXO7sdRk';
    $searchUrl = $url.'Image?$format=json&Adult="Moderate"&Query=';
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

    $resultado = $jsonobj->d->results;
    $valor = $resultado[mt_rand(0,24)];
    echo '<br>';
    echo '<img src="' . $valor->MediaUrl . '">';
    echo '<br> ________________ <br>';
    echo('<ul ID="resultList">');
    foreach($jsonobj->d->results as $value){                        
        echo('<li class="resultlistitem"><a href="' . $value->MediaUrl . '">');
        echo('<img src="' . $value->Thumbnail->MediaUrl. '"></li>');
    }
    echo("</ul>");
    //return $value->MediaUrl;
    return $valor->MediaUrl;
}




function PostCloneUser($fb, $myalbumid, $groupid, $access_token, $bingurl){
  
  $textos = array("pegaria? :*","pega ou passa? :*","o que acharam? :*","to sem ideia pra foto... ajuda ai.. :*","oq vcs estao fazendo agora hein? :*","essa ficou show! :*","que nota vc da? :*","qual seu signo? :*","De 1 a 10, oq acha? :*","entediada aqui.. alguem online? :*","vamos conversar? comenta seu whatsapp ai! :*","deixa seu whatsapp no comentario!","oi! Add?", "add ou follow?", "adiciona ou segue?", "adiciona?", "me segue", "follow me", "quem me add?", "quem me segue?", "oi! Add? :) ", "add ou follow? :) ", "adiciona ou segue? :) ", "adiciona? :) ", "me segue :) ", "follow me :) ", "quem me add? :) ", "quem me segue? :) ", "oi! Add? :* ", "add ou follow? :* ", "adiciona ou segue? :* ", "adiciona? :* ", "me segue :* ", "follow me :* ", "quem me add? :* ", "quem me segue? :* "); 
  $message = $textos[mt_rand(0,sizeof($textos)-1)];
  $message_wall = $textos[mt_rand(0,sizeof($textos)-1)];
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $header = file_get_contents($bingurl, FALSE, $context);
  $image_filename = 'image' . $myalbumid . '.jpg';
  file_put_contents($image_filename, $header);
  
  $target = '/' . $myalbumid . '/photos';
  $linkData = [
    'source' => $fb->fileToUpload($image_filename),
    'message' => $message_wall,
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
