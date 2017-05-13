<?php
session_start(); 
require_once('my_queries.php');
//echo 'fim';   
$pagina = str_replace('/', '' , $_POST['new_user_page']);


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
    
        $accessToken = $_SESSION["token"];
        
        //$paginaID = substr($pagina, 25, strlen($pagina) - 26);
        $paginaID = $pagina;
        $paginaFull = 'https://www.facebook.com/'. $paginaID .'/';
        $erro = 'Salvo com sucesso';
        try {  
          $response = $fb->get('/'. $paginaID .'/?fields=posts.limit(50){id}', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
         // When Graph returns an error
         $erro = 'Graph returned an error: ' . $e->getMessage();
         //exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
         // When validation fails or other local issues
         $erro = 'Facebook SDK returned an error: ' . $e->getMessage();
         //exit;
        }
    
        //echo $n_posts;
        if(($erro == 'Salvo com sucesso'))
        {
            
            //$graphNode = $response->getGraphNode();
            //$n_posts = count($graphNode['posts']);
            //$erro = 'n'.$n_posts;
            //if(isset($n_posts))
            //{
                $query = "UPDATE tl_cadastro SET pagina = '" . $paginaFull  . "' WHERE user_id = '" . $user_id . "';";
                $result = $db->query($query);
            //}
        }else {
            $erro = $paginaID . ': ERRO. Utilize o nome ou ID da sua página, não são aceitos perfis pessoais.';
            //$erro = $paginaID . ': ERRO. Utilize o nome ou ID da sua página, não são aceitos perfis pessoais. <br><br> (' . $erro .')';
        }
//echo $user_id . " : " . $pagina ;


//echo $query;
$_POST['new_user_page'] = NULL;
//echo "<script>window.top.location.href='user_page_frame.php'</script>"; 
$paginaGravada = db_usuario($_SESSION["user_id"], $_SESSION["user_name"]);   
$paginaGravada = substr($paginaGravada, 25, strlen($paginaGravada) - 26);
        $data = array(
            "pagina"     => $paginaGravada,
            "texto"  => $erro
        );
        echo json_encode($data);    
    
    
    
//echo $pagina;
}

?>

