<?php
session_start(); 
$pagina = $_POST['new_user_page'];
if (isset($pagina )) { 

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

echo $user_id . " : " . $pagina ;
$query = "UPDATE tl_cadastro SET pagina = '" . $pagina  . "' WHERE user_id = '" . $user_id . "';";
$result = $db->query($query);

echo $query;
$_POST['new_user_page'] = NULL;
echo "<script>window.top.location.href='user_page_frame.php'</script>";   
}
    
?>


<div class="dentro">
  <form action="user_page_frame.php" method="post">
      <table  border="0">
        <tr valign="middle">
          <td><font style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size:16px;"><b>Digite a URL da sua página nesse iframe: </b></font></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input type="text" name="new_user_page" style="font-family:arial; font-size:12px; width: 380px; margin-left: 0px; margin-top: 0px;"></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input type="submit"></td>
        </tr>        
      </table>
  </form>
</div>
