<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('my_queries.php');
?>
<style>
html { 
  background: url("fundo.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
	
#user_page_frame {
  position: fixed;
  z-index: 999;

}
	
</style>
<meta property="og:image" content="http://apostagol.herokuapp.com/trocalikes/icone.jpg" />
<meta property="og:description" content="TROCA LIKES: Aplicativo para troca de likes de forma JUSTA" />




<?php

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
//$helper = $fb->getRedirectLoginHelper();
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
  sql_query("INSERT INTO tl_acessos (tempo) VALUES (now())");
  //echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['public_profile']; // optionnal
  $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $app_name . '/', $permissions);
  //$loginUrl = $helper->getLoginUrl('https://m.facebook.com/apps/' . $app_name . '/', $permissions);	
  //$loginUrl = $helper->getLoginUrl('https://apostagol.herokuapp.com/' . $app_name . '/', $permissions);	
  //confirme que essa url de login esta autorizada no aplicativo
  echo '<br><br><br><br><br><br><br>';
  echo "<script>function logar(){window.top.location.href='".$loginUrl."';}</script>";
  echo "<div align='center' valign='middle' >";
  //echo "<input type='image' src='facebook-login.png'  width='400' height='50' value='' onClick='logar();'>";
  echo "<input type='button' style='background: url(facebook-login.png); width:400px; height:50px; background-size: 396px 46px; background-repeat: no-repeat; '  value='' onClick='logar();'>";
  //echo "<input type='button' src='facebook-login.png'  value='Login' onClick='logar();'>";
  echo "</div>";
  echo '<br><br><br><br><br><br><br><br><br><br>';	
  echo '<div align="center" id="instrucoes" style="background-color:white;">';
  echo '  <font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:13px;">';
  echo 'Based on your profile we suggest posts you might enjoy!<br>';
  echo 'Baseado no seu perfil, sugerimos posts que voce poderá gostar!';
 
	// echo '<b>TROCA LIKES</b></font><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"> é um aplicativo GRATUITO para aumentar o número de curtidas nos posts de sua página no Facebook.<br><br>';
 // echo 'Ao logar, o aplicativo mostrará uma lista de posts para você curtir e ganhar créditos para cada LIKE que der.<br>'; 
 // echo 'Esses créditos são convertidos em LIKES de outros usuários para sua própria página.<br><br>';
 // echo 'O aplicativo checa automaticamente se cada usário realmente curtiu o post para merecer o crédito.<br>';
 // echo 'Dessa forma, oferecemos uma troca JUSTA e GARANTIDA entre todos os participantes.';
  echo '  </font>';
  echo '</div>';
  echo '';
	
  echo '<div align="center" id="final" >';
  echo '<font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">';
  echo '<br><br><br>Troca Likes App - Todos os Direitos Reservados ::  <a href="privacy_policy.html">Privacy Policy</a> ::  <a href="privacy_policy.html">Terms of Service</a>';
  echo '</font></div>';
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

sql_query("INSERT INTO tl_acessos (tempo, user_id, user_name) VALUES (now(), '". $_SESSION['user_id'] . "', '" . $_SESSION['user_name'] . "')");
  
//echo 'aqui5<br>';

//require_once('lista_rodrigo.php');
//require_once('lista_IE.php');
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
   loadQueryResults();
	
$("#atualiza").click(function(){
   loadQueryResults();
	});


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
	
	
	
  function loadQueryResults() {
    $('#DisplayDiv').load('bloco.php');
    consulta_credito();
    return false;
  }
	
	
 function consulta_credito(){	

		$.ajax({
			url: 'consulta_credito.php',
			type: 'POST',
			//dataType: 'text',
			dataType: 'json',
			//data: {new_user_page: novapagina},
		})
		.done(function(data) {
			console.log(JSON.stringify(data));
			document.getElementById("creditos").innerHTML = data.creditos;
			document.getElementById("usados").innerHTML = data.usados;
			document.getElementById("saldo").innerHTML = data.saldo;
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
  	 
  }
	
	
});
</script> 



<div align="center" id="user_page_frame" >
      <table  border="0" style="background-color:white;">
        <tr valign="middle">
          <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><b><span id="nome"><?php echo $_SESSION["user_name"] . "        "; ?></span></b></font></td>
	  <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td align="right"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="texto_pagina">Minha Página:</span></font></td>
          <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">https://www.facebook.com/<input type="text" id="form_user_page" value="<?php echo $user_page; ?>"  style="font-family:arial; font-size:12px; width: 280px; margin-left: 0px; margin-top: 0px;">/</font></td>
          <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><input type="submit" id="botao_pagina" value="Botao"></font></td>
          <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
		<td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
	  <!-- 
	  <td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">Cliques Efetuados: <b><span id="creditos"></span></b></font></td>
-->
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
	  <!-- 
	  
		<td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">Cliques Recebidos: <b><span id="usados"></span></b></font></td>
-->	

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
	<!--   
		<td align="left"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">Saldo: <b><span id="saldo"></span></b></font></td>
-->
	</tr>
      </table>
</div>
<br><br><br><br>
<div align="left" id="instrucoes_na_tela" style="background-color:white;">
      <table  border="0">
        <tr valign="middle">
		<!-- 
          <td align="center"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="nome">Curta os POSTS abaixo para ganhar créditos e ter os posts da sua página divulgados para outros usuários</span></font></td>
	-->
          <td align="center"><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;"><span id="nome">O que acha dos Posts abaixo?</span></font></td>
	

         </tr>
      </table>
</div>

<div id='DisplayDiv'>
</div>

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
<input type="button" value="Mais Posts >>" onClick="window.location=window.location;">
-->
<font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">
<br>
<div align="center" >
<font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:11px;">
<input type="submit" id="atualiza" value="Mais Posts >>">
</font>
</div>
<br>
<br>
Troca Likes App - Todos os Direitos Reservados ::  <a href="privacy_policy.html">Privacy Policy</a> ::  <a href="privacy_policy.html">Terms of Service</a> 
</font>

