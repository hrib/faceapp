<?php
session_start(); 
require_once('my_queries.php');
//echo 'fim';   
$user_name = $_SESSION["user_name"];
$user_id = $_SESSION["user_id"];
$accessToken = $_SESSION["token"];


        require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
        $app_id = getenv('FB_APP_ID');
        $app_secret = getenv('FB_APP_SECRET');
        $fb = new Facebook\Facebook([
          'app_id' => $app_id,
          'app_secret' => $app_secret,
          'default_graph_version' => 'v2.9',
          ]);

//VERIFICACAO
//Verifica se cada "esperando" foi ou nao clicado, mudando para "clicado" 
//cancela alocados com tempo > 30min
$retorno = sql_query("SELECT * FROM tl_cliques WHERE clicker_check = 'esperando' ORDER BY id;"); 
  //echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
      //echo "<tr>";
      foreach($row as $item) {
        //echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      $check_inicial = checa_clique_post($row['id'], $row['tempo_update'], $row['dono_post'], $row['clicker_id'], $fb, $accessToken);	
      //echo "<td>" . $check_inicial[0] . "</td>";	
      //echo "<td>" . $check_inicial[1] . "</td>";
      //echo "<td>" . $check_inicial[2] . "</td>";
      //echo "</tr>";
  }
  //echo "</table>";
$retorno->closeCursor();

//echo 'aqui6<br>';


//LIMPEZA
//Cancela todos os cliques "esperando" do cliente
sql_query("UPDATE tl_cliques SET clicker_check = 'cancelado' WHERE clicker_id = '" . $_SESSION['user_id'] . "' AND clicker_check = 'esperando';"); 

//echo 'aqui7<br>';


//CALCULO
//recalcula todos os creditos e cria novos "gerados"
$sobra = sql_query("SELECT coalesce(T1.clicker_id,  T2.dono_id) as usuario, (COALESCE(T1.n_creditos,0)) as Creditos, (COALESCE(T2.n_usados_prontos,0)) as Alocados, (COALESCE(T1.n_creditos,0) + COALESCE(T2.n_usados_prontos, 0)) as Sobra FROM (SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id) AS T1 FULL OUTER JOIN (SELECT dono_id, -COUNT(*) as n_usados_prontos FROM tl_cliques  WHERE clicker_check = 'gerado' OR clicker_check = 'esperando' OR clicker_check = 'clicado' GROUP BY dono_id) AS T2 ON T1.clicker_id = T2.dono_id;"); 
  //echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $sobra->fetch(PDO::FETCH_ASSOC)) {
      //echo "<tr>";
      foreach($row as $item) {
        //echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      //echo "</tr>";
      gerador_de_posts($fb, $accessToken, $row['usuario'], $row['sobra']);	  
  }
  //echo "</table>";
$sobra->closeCursor();


  


//ALOCACAO
//Seleciona os IDs das linhas "GERADO" e nao "ALOCADAS", mas que cliente NAO e' DONO e NAO clicou em post igual.
//Tb NAO seleciona linhas com o mesmo POST
$ids_selecionados = "SELECT id FROM (SELECT min(id) as id, min(tempo) as tempo, post_gerado FROM (SELECT id, post_gerado, tempo FROM (SELECT id, dono_post as post_gerado, tempo FROM tl_cliques WHERE  clicker_id IS NULL  AND clicker_check = 'gerado' AND dono_id <> '" . $_SESSION["user_id"] . "') AS T1 FULL OUTER JOIN  (SELECT dono_post as post_clicado FROM tl_cliques WHERE  clicker_id = '" . $_SESSION["user_id"] . "' AND clicker_check = 'clicado' GROUP BY dono_post) AS T2 ON post_gerado = post_clicado WHERE post_clicado IS NULL) AS TA GROUP BY post_gerado ORDER BY tempo LIMIT 10) FINAL";
sql_query("UPDATE tl_cliques SET clicker_id = '" . $_SESSION["user_id"] . "', clicker_check = 'esperando', tempo_update = now() FROM (" . $ids_selecionados . ") AS T WHERE tl_cliques.id = T.id;");

//echo 'aqui8<br>';



//echo 'aqui9<br>';



//PROPAGANDA
//Cria frames de acordo com oq foi alocado "ESPERANDO"
$frames = sql_query("SELECT dono_post FROM tl_cliques WHERE clicker_id = '" . $_SESSION["user_id"] . "' AND clicker_check = 'esperando';");
  echo '<br><br><table align="center" border="1" style="font-family:arial; font-size:7px;">';
  $z = 0;
  while ($row = $frames->fetch(PDO::FETCH_ASSOC)) {
      if($z == 0){echo "<tr>";}
      foreach($row as $item) {
        //echo "<td>" . htmlspecialchars($item) . "</td>";
	$page_esperando_id = stristr($item,'_',true) ;
	$post_esperando_id = substr(stristr($item,'_',false),1);
	//echo "<td>" . htmlspecialchars($page_esperando_id) . "</td>";
	//echo "<td>" . htmlspecialchars($post_esperando_id) . "</td>";
	echo "<td><iframe src='https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F" . $page_esperando_id . "%2Fposts%2F" . $post_esperando_id . "&width=500'  width='500' height='720' style='border:none' scrolling='yes' frameborder='0'></iframe></td>";
      }
      if($z == 1){echo "</tr>";}
      $z = $z + 1;
      if($z == 2){$z = 0;}	      
  }
  echo "</table>";
$frames->closeCursor();

?>
