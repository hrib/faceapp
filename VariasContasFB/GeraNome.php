<?php

function GeraNome(){
  $rand = mt_rand(1,2);
  if($rand == 1){
    $nome['sex'] = 'male';
  } else {
    $nome['sex'] = 'female';
  }
  
  $query = "SELECT nome FROM bercario WHERE tipo_nome = '$sex' ORDER BY RANDOM() LIMIT 1";
  $retorno_firstname = SQLquery($query);
  //$nome['firstname'] = $retorno_firstname[mt_rand(0, count($retorno_firstname) - 1)];
  $nome['firstname'] = $retorno_firstname;
  echo $nome['firstname'];
  $query = "SELECT nome FROM bercario WHERE tipo_nome = 'sobrenome' ORDER BY RANDOM() LIMIT 1";
  $retorno_lastname = SQLquery($query);
  //$nome['lastname'] = $retorno_lastname[mt_rand(0, count($retorno_lastname) - 1)];
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
  $retorno = $result['nome'];
  echo $retorno;
  $result->closeCursor();
  return $retorno;
}


?>
