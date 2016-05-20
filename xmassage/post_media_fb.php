<?php

function Post_Media_fb($app_id, $app_secret, $page_access_token, $media, $texto, $pageTarget, $albumTarget){
    
  $fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.6', // change to 2.5
    'default_access_token' => $app_id . '|' . $app_secret
  ]);

  if (strpos($media, 'mp4') !== false){
    $target = '/' . $pageTarget . '/videos';
    $data = [
      'title' => $texto,
      'description' => $texto,
      'source' => $fb->videoToUpload($media),
      'message' => $texto,
    ];
  }else{
    $target = '/' . $albumTarget . '/photos';
    $data = [
      'source' => $fb->fileToUpload($media),
      'message' => $texto,
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
}



?>
