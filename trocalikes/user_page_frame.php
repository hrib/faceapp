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
//echo "<script>window.top.location.href='user_page_frame.php'</script>";   
}
    
?>

