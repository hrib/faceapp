<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('sql_queries.php');

$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$app_name = 'trocalikes';

$paginaID = 'rconstantinoliberal';

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


try {  
  $response = $fb->get('/'. $paginaID .'?fields=posts{likes{id,name}}', $accessToken);
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
echo '<table border="1" style="font-family:arial; font-size:9px;">';
foreach ($graphNode['posts'] as $posts) {
  foreach ($posts['likes'] as $likes) {
    echo '<tr>';
    echo '<td>' . $posts['id'] . '</td>';
    echo '<td>' . $likes['name'] . '</td>';
    echo '<td>' . $likes['id'] . '</td>';
    echo '</tr>';
  }
} 
echo '</table>';


$retorno = sql_query("SELECT * FROM tl_cliques WHERE clicker_check = 'esperando' ORDER BY id;"); 

  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      foreach($row as $item) {
        echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      echo "</tr>";
  }
  echo "</table>";
$retorno->closeCursor();


?>
  
iframe1
<br>
<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FHugoMayfair%2Fposts%2F1686406321664768&width=500" width="500" height="232" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<br>
iframe2
<br>
<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Frconstantinoliberal%2Fposts%2F1172633986198400&width=500" width="500" height="462" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<br>
fim iframe
<style>
html { 
  background: url("http://www.planwallpaper.com/static/images/Alien_Ink_2560X1600_Abstract_Background_1.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
