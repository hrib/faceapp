<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('my_queries.php');
// AO MUDAR A PAGINA NO CADASTRO, TEM QUE RESETAR OS POST GERADOS EM ABERTO DO USUARIO
// SHARED VIDEOS mostram post da pagina original no iframe. Bloquear shared video
// Limite para checar likes = 1000 likes
// iframes tem que auto-atualizar a cada 30min, que e' o tempo para expiracao do 'esperando'.

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$app_name = 'trocalikes';


$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9',
  ]);

$helper = $fb->getCanvasHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  //echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['public_profile']; // optionnal
  $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $app_name . '/', $permissions);
  //confirme que essa url de login esta autorizada no aplicativo
  echo "<script>window.top.location.href='".$loginUrl."'</script>";
  
  exit;
}


try {  
  $response = $fb->get('/me?fields=id,name', $accessToken);
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
$_SESSION["user_name"]  = $graphNode['name'];
echo $_SESSION["user_name"] . '<br>';
$_SESSION["user_id"] = $graphNode['id'];
echo $_SESSION["user_id"] . '<br>';

$user_page = db_usuario($_SESSION["user_id"], $_SESSION["user_name"]);

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
   novapagina = document.getElementById("form_user_page").value;	
   if (novapagina == "") {
	document.getElementById("form_user_page").disabled = false;
	document.getElementById("botao_pagina").value = "Salvar";
        document.getElementById("texto_pagina").innerHTML="Digite a URL da sua página: ";
   } else {
	document.getElementById("form_user_page").disabled = true;
	document.getElementById("botao_pagina").value = "Editar";
	document.getElementById("texto_pagina").innerHTML="Sua página: ";   
   }
	
 $("#botao_pagina").click(function(){
   	novapagina = document.getElementById("form_user_page").value;
   
	if (document.getElementById("form_user_page").disabled) {
		document.getElementById("form_user_page").disabled = false; 
		document.getElementById("botao_pagina").value = "Salvar";
		document.getElementById("texto_pagina").innerHTML="Digite a URL da sua página: ";

   	} else {
		$.ajax({
			url: 'user_page_frame.php',
			type: 'POST',
			dataType: 'text',
			data: {new_user_page: novapagina},
		})
		.done(function(data) {
			console.log(data);
			document.getElementById("form_user_page").value = data;
			document.getElementById("form_user_page").disabled = true;
			document.getElementById("botao_pagina").value = "Editar";
			document.getElementById("texto_pagina").innerHTML="Sua página: ";   
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
   
   	} 
 });
});
</script> 



<div align="left" id="user_page_frame">
      <table  border="0">
        <tr valign="middle">
          <td><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:16px;"><b><span id="texto_pagina">URL</span></b></font></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input type="text" id="form_user_page" value="<?php echo $user_page; ?>"  style="font-family:arial; font-size:12px; width: 380px; margin-left: 0px; margin-top: 0px;"></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input type="submit" id="botao_pagina" value="Botao"></td>
        </tr>        
      </table>
</div>

<?php


//require_once('lista_rodrigo.php');
//require_once('lista_IE.php');

$retorno = sql_query("SELECT * FROM tl_cliques WHERE clicker_check = 'esperando' ORDER BY id;"); 

  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      foreach($row as $item) {
        echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      $check_inicial = checa_clique_post($row['id'], $row['tempo'], $row['dono_post'], $row['clicker_id'], $fb, $accessToken);	
      echo "<td>" . $check_inicial[0] . "</td>";	
      echo "<td>" . $check_inicial[1] . "</td>";
      echo "<td>" . $check_inicial[2] . "</td>";
      //echo "<td>" . htmlspecialchars($check_face) . "</td>";	
      echo "</tr>";
  }
  echo "</table>";
$retorno->closeCursor();

sql_query("UPDATE tl_cliques SET clicker_check = 'cancelado' WHERE clicker_id = '" . $_SESSION['user_id'] . "' AND clicker_check = 'esperando';"); 

$sobra = sql_query("SELECT T1.clicker_id, (T1.n_creditos - T2.n_usados_prontos) AS sobra FROM (SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id) AS T1 JOIN (SELECT dono_id, COUNT(*) as n_usados_prontos FROM tl_cliques WHERE clicker_check = 'gerado' OR clicker_check = 'esperando' OR clicker_check = 'clicado' GROUP BY dono_id) AS T2 ON T1.clicker_id = T2.dono_id;"); 
  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $sobra->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      foreach($row as $item) {
        echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      echo "</tr>";
      gerador_de_posts($fb, $accessToken, $row['clicker_id'], $row['sobra']);	  
  }
  echo "</table>";
$sobra->closeCursor();


sql_query("UPDATE tl_cliques SET clicker_id = '" . $_SESSION["user_id"] . "', clicker_check = 'esperando' FROM (SELECT id FROM tl_cliques WHERE  clicker_id = ''  AND clicker_check = 'gerado' ORDER BY tempo LIMIT 9) AS T WHERE tl_cliques.id = T.id;");
$frames = sql_query("SELECT dono_post FROM tl_cliques WHERE clicker_id = '" . $_SESSION["user_id"] . "' AND clicker_check = 'esperando';");
  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $frames->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      foreach($row as $item) {
        echo "<td>" . htmlspecialchars($item) . "</td>";
	$page_esperando_id = stristr($item,'_',true) ;
	$post_esperando_id = substr(stristr($item,'_',false),1);
	echo "<td>" . htmlspecialchars($page_esperando_id) . "</td>";
	echo "<td>" . htmlspecialchars($post_esperando_id) . "</td>";
	echo "<td><iframe src='https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F" . $page_esperando_id . "%2Fposts%2F" . $post_esperando_id . "&width=500' width='500' height='700' style='border:none;overflow:hidden' scrolling='yes' frameborder='0' allowTransparency='false'></iframe></td>";
      }
      echo "</tr>";
  }
  echo "</table>";
$frames->closeCursor();

?>
<!--  
iframe1
<br>
<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FHugoMayfair%2Fposts%2F1686406321664768&width=500" width="500" height="232" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<br>
iframe2
<br>
<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Frconstantinoliberal%2Fposts%2F1172633986198400&width=500" width="500" height="462" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<br>
iframe3
<br>
<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3D1072132882921227%26id%3D798157940318724&width=500" width="500" height="305" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<br>
fim iframe
-->
<style>
html { 
  background: url("http://www.planwallpaper.com/static/images/Alien_Ink_2560X1600_Abstract_Background_1.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
