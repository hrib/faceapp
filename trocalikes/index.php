<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('my_queries.php');

// AO MUDAR A PAGINA NO CADASTRO, TEM QUE RESETAR OS POST GERADOS EM ABERTO DO USUARIO

// SHARED VIDEOS mostram post da pagina original no iframe. Bloquear shared video

// Limite para checar likes = 1000 likes

// iframes tem que auto-atualizar a cada 30min, que e' o tempo para expiracao do 'esperando'.

// se for gerado um post_id que o cliente ja clicou, esse post_id nunca sera oferecido ate um novo usuario aparecer.
//Isso vai congelar o credito do cliente por algum tempo. Possivel solucao: expirar o "gerado" para liberar o credito

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$app_name = 'trocalikes';

//echo 'aqui1<br>';
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

//echo 'aqui2<br>';
if (! isset($accessToken)) {
  //echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['public_profile']; // optionnal
  $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $app_name . '/', $permissions);
  //confirme que essa url de login esta autorizada no aplicativo
  echo "<script>window.top.location.href='".$loginUrl."'</script>";
  
  exit;
}

//echo 'aqui3<br>';

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
//echo 'aqui4<br>';

$graphNode = $response->getGraphNode();
$_SESSION["user_name"]  = $graphNode['name'];
//echo $_SESSION["user_name"] . '<br>';
$_SESSION["user_id"] = $graphNode['id'];
//echo $_SESSION["user_id"] . '<br>';
$_SESSION["token"] = (string) $accessToken; 


$user_page = db_usuario($_SESSION["user_id"], $_SESSION["user_name"]);
$user_page = substr($user_page, 25, strlen($user_page) - 26);


//echo 'aqui5<br>';

//require_once('lista_rodrigo.php');
//require_once('lista_IE.php');

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


$creditos_cliente = sql_query("SELECT creditos, usados, saldo FROM (SELECT coalesce(T1.clicker_id,  T2.dono_id) as usuario, (COALESCE(T1.n_creditos,0)) as Creditos, (COALESCE(T2.n_usados,0)) as Usados, (COALESCE(T1.n_creditos,0) + COALESCE(T2.n_usados, 0)) as Saldo FROM (SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id) AS T1 FULL OUTER JOIN (SELECT dono_id, -COUNT(*) as n_usados FROM tl_cliques  WHERE clicker_check = 'clicado' GROUP BY dono_id) AS T2 ON T1.clicker_id = T2.dono_id) FINAL WHERE usuario = '" . $_SESSION["user_id"] ."';");
while ($row = $creditos_cliente->fetch(PDO::FETCH_ASSOC)) {
    $creditos = $row['creditos'];
    $usados = -$row['usados'];
    $saldo = $row['saldo'];
}
$creditos_cliente->closeCursor();
  


//ALOCACAO
//Seleciona os IDs das linhas "GERADO" e nao "ALOCADAS", mas que cliente NAO e' DONO e NAO clicou em post igual.
//Tb NAO seleciona linhas com o mesmo POST
$ids_selecionados = "SELECT id FROM (SELECT min(id) as id, min(tempo) as tempo, post_gerado FROM (SELECT id, post_gerado, tempo FROM (SELECT id, dono_post as post_gerado, tempo FROM tl_cliques WHERE  clicker_id IS NULL  AND clicker_check = 'gerado' AND dono_id <> '" . $_SESSION["user_id"] . "') AS T1 FULL OUTER JOIN  (SELECT dono_post as post_clicado FROM tl_cliques WHERE  clicker_id = '" . $_SESSION["user_id"] . "' AND clicker_check = 'clicado' GROUP BY dono_post) AS T2 ON post_gerado = post_clicado WHERE post_clicado IS NULL) AS TA GROUP BY post_gerado ORDER BY tempo LIMIT 10) FINAL";
sql_query("UPDATE tl_cliques SET clicker_id = '" . $_SESSION["user_id"] . "', clicker_check = 'esperando', tempo_update = now() FROM (" . $ids_selecionados . ") AS T WHERE tl_cliques.id = T.id;");

//echo 'aqui8<br>';


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  


	
$(document).ready(function(){
   //alert('ready');	
   novapagina = document.getElementById("form_user_page").value;	
   if (novapagina == "") {
	document.getElementById("form_user_page").disabled = false;
	document.getElementById("botao_pagina").value = "Salvar";
        document.getElementById("resposta").innerHTML="Digite o nome ou ID da sua página";
   } else {
	document.getElementById("form_user_page").disabled = true;
	document.getElementById("botao_pagina").value = "Editar";
	document.getElementById("resposta").innerHTML="";   
   }

 $("#botao_pagina").click(function(){
   	novapagina = document.getElementById("form_user_page").value;
        //alert('clicado');
	if (document.getElementById("form_user_page").disabled) {
		document.getElementById("form_user_page").disabled = false; 
		document.getElementById("botao_pagina").value = "Salvar";
		document.getElementById("resposta").innerHTML="Digite o nome ou ID da sua página";

   	} else {
		$.ajax({
			url: 'user_page_frame.php',
			type: 'POST',
			//dataType: 'text',
			dataType: 'json',
			data: {new_user_page: novapagina},
		})
		.done(function(data) {
			console.log(JSON.stringify(data));
			document.getElementById("form_user_page").value = data.pagina;
			document.getElementById("resposta").innerHTML = data.texto;
			//document.getElementById("resposta").style.display = "inline"; 
			document.getElementById("form_user_page").disabled = true;
			document.getElementById("botao_pagina").value = "Editar";
			//document.getElementById("resposta").innerHTML="Sua página: ";   
			setTimeout(function(){ 
				document.getElementById("resposta").innerHTML = ''; 
				//document.getElementById("resposta").style.display = "none"; 
			}, 15000);
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



<div align="left" id="user_page_frame" style="background-color:white;">
      <table  border="0">
        <tr valign="middle">
          <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><b><span id="nome"><?php echo $_SESSION["user_name"] . "        "; ?></span></b></font></td>
	  <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td align="right"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="texto_pagina">Minha Página:</span></font></td>
          <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">https://www.facebook.com/<input type="text" id="form_user_page" value="<?php echo $user_page; ?>"  style="font-family:arial; font-size:12px; width: 280px; margin-left: 0px; margin-top: 0px;">/</font></td>
          <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><input type="submit" id="botao_pagina" value="Botao"></font></td>
          <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  
	  <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="creditos">Cliques Efetuados: <b><?php echo $creditos; ?></b></span></font></td>
	</tr>
	<tr>
	  <td> </td>
	  <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td align="center" ><font style="font-family: Arial; color:red; font-size:12px;"><span id="resposta"></span></font></td>
	  <td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  
		<td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="usados">Cliques Recebidos: <b><?php echo $usados; ?></b></span></font></td>

	</tr>
	<tr>
	  <td> </td>
	  <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td> </td>
	  <td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  
		<td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="usados">Saldo: <b><?php echo $saldo; ?></b></span></font></td>

	</tr>
      </table>
</div>

<?php





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
<font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">
<br>
<div align="center" >
<input type="button" value="Mais Posts >>" onClick="window.location=window.location;">
</div>
<br>
<br>
Troca Likes App - Todos os Direitos Reservados
</font>
<style>
html { 
  background: url("fundo.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
