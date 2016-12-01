<?php

function GeraNome(){
  $rand = mt_rand(1,2);
  if($rand == 1){
    $nome['sex'] = 'male';
  } else {
    $nome['sex'] = 'female';
  }
  
  $query = "SELECT nome FROM bercario WHERE tipo_nome = '$nome['sex']' ORDER BY RANDOM() LIMIT 1";
  echo $query;
  $retorno_firstname = SQLquery($query);
  echo $retorno_firstname['nome'];
  $nome['firstname'] = $retorno_firstname['nome'];
  $query = "SELECT nome FROM bercario WHERE tipo_nome = 'sobrenome' ORDER BY RANDOM() LIMIT 1";
  $retorno_lastname = SQLquery($query);
  $nome['lastname'] = $retorno_lastname['nome'];
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
  $retorno = $result->fetch(PDO::FETCH_ASSOC);
  //var_dump($retorno);
  //echo $retorno;
  $result->closeCursor();
  return $retorno;
}


?>
