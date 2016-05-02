<?php
session_start();

echo 'oi';
require_once 'src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1011974285544429',
  'app_secret' => '9b28ee403af9889f18c3fd6f3b9135c8',
  'default_graph_version' => 'v2.5',
  //'default_access_token' => '', // optional
]);


echo '2';

$helper = $fb->getRedirectLoginHelper();
echo '222';
try {
echo '222b';
  $accessToken = $helper->getAccessToken();
echo '222c';
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

echo '3';

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // OAuth 2.0 client handler
$oAuth2Client = $fb->getOAuth2Client();

// Exchanges a short-lived access token for a long-lived one
$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);


// Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($longLivedAccessToken);

try {
  $response = $fb->get('/me?fields=name,email');
  //$userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

//echo 'Logged in as ' . $userNode->getName();

$graphObject = $response->getGraphObject();
$name = $graphObject->getProperty('name');
$email = $graphObject->getProperty('email');
echo '<br>';
echo $name;
echo '<br>';
echo $email; 
echo '<br>';

}


echo '4';

?>
