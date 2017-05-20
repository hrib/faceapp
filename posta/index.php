<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$userToken = getenv('FB_TESTE_HM_USERTOKEN');

$agora = date("Y-m-d");
$chaves = array('divulgacao','gastronima', 'restaurante', 'clinica', 'viagem', 'dicas', 'modelo', 'arquitetura', 'nutricao');
$chave = $chaves[mt_rand(0, sizeof($chaves) - 1)];

$limite = mt_rand(1000, 5000);

$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.9', // change to 2.5
    'default_access_token' => $app_id . '|' . $app_secret
  ]);


try {
   $response = $fb->get('/search?q='.$chave.'&type=page&fields=id,name,fan_count,posts.limit(1)', $userToken);
 } catch(Facebook\Exceptions\FacebookResponseException $e) {
   // When Graph returns an error
   echo 'Graph returned an error: ' . $e->getMessage();
   //exit;
 } catch(Facebook\Exceptions\FacebookSDKException $e) {
   // When validation fails or other local issues
   echo 'Facebook SDK returned an error: ' . $e->getMessage();
   //exit;
 }

$graphNode = $response->getGraphEdge();
echo '<table border="1" style="font-family:arial; font-size:9px;">';
while($graphNode) {
        foreach ($graphNode as $pagina) {
            echo '<tr>';
            echo '<td>' . $pagina['id'] . '</td>';
            echo '<td>' . $pagina['name'] . '</td>';
            echo '<td>' . $pagina['fan_count'] . '</td>';
            echo '<td>' . $pagina['posts'][0]['id'] . '</td>';
            echo '<td>' . date_format($pagina['posts'][0]['created_time'], 'Y-m-d') . '</td>';
            echo '<td>' . $pagina['posts'][0]['story'] . '</td>';
            if((date_format($pagina['posts'][0]['created_time'], 'Y-m-d') == $agora) AND ($pagina['fan_count'] > ($limite - 1000)) AND ($pagina['fan_count'] < $limite)){
                $retorno = pagina_post_comenta($fb, $pagina['posts'][0]['id'], $userToken);
                echo '<td>'.$retorno.'</td>';
                $sqlretorno = SalvaSQL("INSERT INTO post_comenta (tempo, page, post, retorno) VALUES (now(),'".$pagina['id']."','".$pagina['posts'][0]['id']."','".$retorno."');");
                echo '<td>'.$sqlretorno.'</td>';
                
            } else {
                echo '<td>-</td>';
                echo '<td>-</td>';
            }
            echo '</tr>';
            
        }
        $graphNode = $fb->next($graphNode);
}
echo '</table>';
echo '<br><br>';



exit;  

function pagina_post_comenta($fb, $postid, $userToken){
    $texto = 'Oi colega, queria te dar uma dica par voce ganhar mais likes aqui. Experimente esse aplicativo de troca de curtidas.
    Cada usuario curte a pagina do outro e todo mundo ganha.
    Abs. 
    
    ';
    $media = 'https://apostagol.herokuapp.com/posta/maislikeslink.jpg';

    
    $data = [
      'source' => $fb->fileToUpload($media),
      'message' => $texto,
    ];

    $target = '/' . $postid . '/comments';

    try {
       $response = $fb->post($target, $data, $userToken);
       $resposta = $response->fetchAll();
     } catch(Facebook\Exceptions\FacebookResponseException $e) {
       // When Graph returns an error
       $resposta =  'Posta: Graph returned an error: ' . $e->getMessage();
       //exit;
     } catch(Facebook\Exceptions\FacebookSDKException $e) {
       // When validation fails or other local issues
       $resposta =  'Posta: Facebook SDK returned an error: ' . $e->getMessage();
       //exit;
     }
    return $resposta;
}

function SalvaSQL($query){
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
  //$result->fetchAll();
  return $result;     
}
 ?>
