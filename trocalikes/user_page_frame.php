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
    
        $paginaID = substr($pagina, 25, strlen($pagina) - 26);
        echo $paginaID;
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

