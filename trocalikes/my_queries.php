<?php

function sql_query($query){
    
$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    
$db = new PDO($dsn);
$result = $db->query($query);  

return $result;    
    
}

function db_usuario($user_id, $user_name){
    
    
    $query = "INSERT INTO tl_cadastro(tempo, user_id, user_name) SELECT now(), '" . $user_id . "', '" . $user_name . "' where not exists (select id from tl_cadastro where user_id = '" . $user_id . "') RETURNING id;";
    $result = sql_query($query);
    $result->closeCursor();
    
    $query = "SELECT pagina FROM tl_cadastro WHERE user_id = '" . $user_id . "';";
    $result = sql_query($query);
    $retorno = $result->fetch();
    return $retorno["pagina"];
    
}

function checa_clique_post($id, $tempo_update, $dono_post, $clicker_id, $fb, $accessToken){

try {  
  $response = $fb->get('/'. $dono_post .'?fields=likes.limit(1000){id}', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 // When Graph returns an error
 console.log($dono_post . ': Graph returned an error: ' . $e->getMessage());
 //exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 // When validation fails or other local issues
 console.log($dono_post . ': Facebook SDK returned an error: ' . $e->getMessage());
 //exit;
}
  
$graphNode = $response->getGraphNode();
//echo '<table border="1" style="font-family:arial; font-size:9px;">';
$check_click = "nao clicado";
foreach ($graphNode['likes'] as $likes) {
    if( $likes['id'] == $clicker_id)
    {
        $check_click = "clicado";
        sql_query("UPDATE tl_cliques SET clicker_check = 'clicado' WHERE id = " . $id . ";"); 
        break;
    }
    //echo '<tr>';
    //echo '<td>' . $likes['id'] . '</td>';
    //echo '</tr>';
} 
$tempo_now = date("Y-m-d H:i:s");
$diff_tempo = round((strtotime($tempo_now) - strtotime($tempo_update)) / 60,0);  
//echo '</table>';
if( ($diff_tempo > 30) AND ($check_click == 'nao clicado'))
{
    sql_query("UPDATE tl_cliques SET clicker_check = 'cancelado' WHERE id = " . $id . ";");   
}
  
   
return array($check_click, $tempo_now, $diff_tempo);
}

function gerador_de_posts($fb, $accessToken, $usuario, $gera_n){

    if( $gera_n > 0)
    {
 
        $result = sql_query("SELECT pagina FROM tl_cadastro where user_id = '" . $usuario . "'");
        $retorno = $result->fetch();
        $paginaID = $retorno["pagina"];
        $result->closeCursor();


        //echo 'Gerando posts para: ' . $usuario . ':' . $paginaID . ':';
        $paginaID = substr($paginaID, 25, strlen($paginaID) - 26);
        //echo 'Gerando posts para: ' . $usuario . ':' . $paginaID . ':';

        try {  
          $response = $fb->get('/'. $paginaID .'/?fields=posts.limit(50){id}', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
         // When Graph returns an error
         console.log($paginaID . ': Gerador de Posts > Graph returned an error: ' . $e->getMessage());
         return;
         //exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
         // When validation fails or other local issues
         console.log($paginaID . ': Gerador de Posts > Facebook SDK returned an error: ' . $e->getMessage());
         return;
         //exit;
        }

        $graphNode = $response->getGraphNode();
        //$contador = 1;
        $n_posts = count($graphNode['posts']);
       
        //$gera_n = 99999;
        $query = "INSERT INTO tl_cliques (tempo , dono_id , dono_page , dono_post, clicker_check) VALUES ";
        //echo '<table border="1" style="font-family:arial; font-size:9px;">';
        //foreach ($graphNode['posts'] as $posts) {
            //echo '<tr>';
            //echo '<td>' . $posts['id'] . '</td>';
            //echo '</tr>';
            for ($x = 1; $x <= $gera_n; $x++) {
                $randomico = mt_rand (0, $n_posts - 1);
                $postid = $graphNode['posts'][$randomico]['id'];
                //echo $n_posts;
                $query = $query . " ( now(), '" . $usuario . "', '" . $paginaID . "', '" .  $postid . "', 'gerado'),";
            } 
        
            //if( $contador > $gera_n)
            //{
            //    break;
            //}
            
            //$contador = $contador + 1;
            

        //} 
        //echo '</table>';

        $query = substr($query, 0, strlen($query) - 1);
        sql_query($query);
    }
    
}



?>
