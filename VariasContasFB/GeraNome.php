<?php

function GeraNome(){
  
  if(mt_rand(1,2) = 1){
    $nome['sex'] = 'male'
  }else {
    $nome['sex'] = 'female'
  }
  
  $query = "SELECT nome from BERCARIO where TIPO_NOME = '$sex'";
  $nome['firstname'] = SQLquery($query);
  $query = "SELECT nome from BERCARIO where TIPO_NOME = 'sobrenome'";
  $nome['lastname'] = SQLquery($query);
  return $nome; 
}

function SQLquery($query){
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];
  $db = new PDO($dsn);
  $result = $db->query($query);
  //$result->closeCursor();
  return $result
}


?>
