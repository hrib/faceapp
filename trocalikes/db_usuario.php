<?php



function db_usuario($user_id, $user_name){
$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    
$db = new PDO($dsn);

    
    $query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' where not exists (select id from tl_cadastro where user_id = '" . $user_id . "') RETURNING id;";
    $result = $db->query($query);
    
    $query = "SELECT pagina FROM tl_cadastro WHERE user_id = '" . $user_id . "';";
    $result = $db->query($query);
    $retorno = $result->fetch();
    echo $retorno["pagina"] . '<br>';
    return $retorno["pagina"];
    
}
?>
