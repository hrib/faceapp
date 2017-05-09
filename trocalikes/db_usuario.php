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

$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT " . $user_id . ", '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = " . $user_id . ");";
$result = $db->query($query);

    
//    INSERT INTO table (id, field, field2)
//       SELECT 3, 'C', 'Z'
//       WHERE NOT EXISTS (SELECT 1 FROM table WHERE id=3);

//insert into company (unique_id, company_name)
//select 42, 'New Company Name'
//from company
//where not exists (select 1 from company where unique_id = 42);
}
?>
