<?php
$dono_post = 135158248503;

try {  
  $response = $fb->get('/'. $dono_post .'?fields=likes.limit(25){id}', $accessToken);
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
foreach ($graphNode['likes'] as $likes) {
    echo '<tr>';
    echo '<td>' . $likes['id'] . '</td>';
    echo '</tr>';
} 
echo '</table>';
?>
