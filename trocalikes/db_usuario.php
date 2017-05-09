<?php
$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    
global $db = new PDO($dsn);


function db_usuario($user_id, $user_name){

    $query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
    $result = $db->query($query);
    $query = "SELECT pagina FROM tl_cadastro WHERE user_id = '" . $user_id . "';";
    $result = $db->query($query);
    $retorno = $result->fetch();
    return $retorno["pagina"];
    
}
?>
