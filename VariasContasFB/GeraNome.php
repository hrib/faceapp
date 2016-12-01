<?php

function GeraNome(){
  
  if(mt_rand(1,2) = 1){
    $nome['sex'] = 'male';
  } else {
    $nome['sex'] = 'female';
  }
  
  $query = "SELECT nome FROM bercario WHERE tipo_nome = '$sex'";
  $retorno_firstname = SQLquery($query);
  $nome['firstname'] = retorno_firstname[mt_rand(0, count(retorno_firstname) - 1)];
  $query = "SELECT nome FROM bercario WHERE tipo_nome = 'sobrenome'";
  $retorno_lastname = SQLquery($query);
  $nome['lastname'] = retorno_lastname[mt_rand(0, count(retorno_lastname) - 1)];
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
  return $result;
}


?>
