<?php
session_start();

$query = $_POST["query"];
echo $query;
SQLquery($query);

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
  
  echo '<br><br>';
  echo var_dump($result->fetch(PDO::FETCH_ASSOC));
  echo '<br><br>';
  
  
  echo "<table>";
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . $row["passw"] . "</td>";
    echo "<td>" . $row["nome"] . "</td>";
    echo "<td>" . $row["sobrenome"] . "</td>";
    echo "<td>" . $row["day"] . "</td>";
    echo "<td>" . $row["month"] . "</td>";
    echo "<td>" . $row["year"] . "</td>";
    echo "<td>" . $row["sex"] . "</td>";
    echo "<td>" . $row["ultimo_acesso"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  $result->closeCursor();

  
}


function CreateTable(){
  
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];

  $db = new PDO($dsn);

  $query = "DROP TABLE Users";
  $result = $db->query($query);
  echo var_dump($result);
  echo '<br><br>';
  
  
  
  $query = "CREATE TABLE Users ("
      . "email VARCHAR(30),"
      . "passw VARCHAR(10),"
      . "nome VARCHAR(20),"
      . "sobrenome VARCHAR(20),"
      . "day VARCHAR(2),"
      . "month VARCHAR(2),"
      . "year VARCHAR(4),"
      . "sex VARCHAR(10),"
      . "ultimo_acesso VARCHAR(30),"
      . "status VARCHAR(30)"
      . ");";
  $result = $db->query($query);
  echo var_dump($result);
}

?>
