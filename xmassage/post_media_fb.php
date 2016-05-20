<?php
session_start();
require_once 'src/Facebook/autoload.php';

function Download_Media_fb($pageOriginal, $app_id, $app_secret){
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);


      
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
        
}



?>
