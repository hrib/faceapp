<?php
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
