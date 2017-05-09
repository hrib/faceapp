<?php


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

$query = "UPDATE tl_cadastro SET pagina = $_POST['new_user_page'] WHERE user_id = '" . $user_id . "';";
$result = $db->query($query);
echo "<script>window.top.location.href='https://apps.facebook.com/trocalikes'</script>";   
    

?>
