<?php
session_start(); 
//echo 'fim';   
$pagina = $_POST['new_user_page'];
if (isset($pagina )) { 
//echo $pagina;
$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    
$db = new PDO($dsn);
$user_name = $_SESSION["user_name"];
$user_id = $_SESSION["user_id"];
    
        
        require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
        $app_id = getenv('FB_APP_ID');
        $app_secret = getenv('FB_APP_SECRET');
        $fb = new Facebook\Facebook([
          'app_id' => $app_id,
          'app_secret' => $app_secret,
          'default_graph_version' => 'v2.9',
          ]);
    
        $helper = $fb->getCanvasHelper();
        try {
          $accessToken = $helper->getToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
    
        
        $paginaID = substr($pagina, 25, strlen($pagina) - 26);
        echo "page:".$paginaID;
        echo "token:".$accessToken;
        echo "token2:". $fb->getToken();
        try {  
          $response = $fb->get('/'. $paginaID .'/?fields=posts.limit(50){id}', $accessToken);
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
        $n_posts = count($graphNode['posts']);
        echo $n_posts;
    
//echo $user_id . " : " . $pagina ;
$query = "UPDATE tl_cadastro SET pagina = '" . $pagina  . "' WHERE user_id = '" . $user_id . "';";
$result = $db->query($query);

//echo $query;
$_POST['new_user_page'] = NULL;
//echo "<script>window.top.location.href='user_page_frame.php'</script>"; 
echo $pagina;
}

?>

