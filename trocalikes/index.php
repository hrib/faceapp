<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('db_usuario.php');

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$app_name = 'trocalikes';

$paginaID = 'rconstantinoliberal';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9',
  ]);

$helper = $fb->getCanvasHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  //echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['public_profile']; // optionnal
  $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $app_name . '/', $permissions);
  //confirme que essa url de login esta autorizada no aplicativo
  echo "<script>window.top.location.href='".$loginUrl."'</script>";
  
  exit;
}

// Logged in
//echo '<h3>Signed Request</h3>';
//var_dump($helper->getSignedRequest());

//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());


$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9', // change to 2.5
]);


try {  
  $response = $fb->get('/me?fields=id,name', $accessToken);
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
$user_name = $graphNode['name'];
echo $user_name . '<br>';
$user_id = $graphNode['id'];
echo $user_id . '<br>';

$user_id = '12345678901234567890';
$user_page = db_usuario($user_id, $user_name);
echo $user_page . '<br>';

try {  
  $response = $fb->get('/'. $paginaID .'?fields=posts{likes{id,name}}', $accessToken);
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
echo '<table border="1" style="font-family:arial; font-size:9px;">';
foreach ($graphNode['posts'] as $posts) {
  foreach ($posts['likes'] as $likes) {
    echo '<tr>';
    echo '<td>' . $posts['id'] . '</td>';
    echo '<td>' . $likes['name'] . '</td>';
    echo '<td>' . $likes['id'] . '</td>';
    echo '</tr>';
  }
} 
echo '</table>';

?>

<style>
html { 
  background: url("http://www.planwallpaper.com/static/images/Alien_Ink_2560X1600_Abstract_Background_1.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
<div class="dentro">
  <form action="save_userpage_url.php" method="post">
      <table  border="0">
        <tr valign="middle">
          <td><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:16px;"><b>Digite a URL da sua página: </b></font></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input type="text" name="userpage_url" style="font-family:arial; font-size:12px; width: 380px; margin-left: 0px; margin-top: 0px;"></td>
        </tr>
      </table>
  </form>
</div>
