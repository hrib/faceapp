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

$query = "INSERT INTO tl_cadastro(user_id, user_name) VALUES('.$user_id.', '.$user_name.');";
$result = $db->query($query);


insert into company (unique_id, company_name)
select 42, 'New Company Name'
from company
where not exists (select 1 from company where unique_id = 42);
}
?>
