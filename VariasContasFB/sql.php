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
  
  //$conn = pg_pconnect($dsn);
  //if (!$conn) {
    //echo "An error occurred: conn.\n";
    //exit;
  //}  
  //$result = pg_query($conn, "SELECT encode(content, 'base64') AS data FROM upload WHERE name='Pine trees'");  

  $result = $db->query($query);
  
  $result1 = $result->fetch(PDO::FETCH_ARRAY);
  print_r($result1);
  echo "<table>";

  foreach($result1 as $key => $value){
    foreach($value as $key2 => $value2){
      echo "<tr>";
      echo "<td>" . $key . $key2 . $value2 . "</td>";
      //print "$key $key2 => $value2\n<br />\n";
      echo "</tr>";

    }
  }
  echo "</table>";

  
  
  //echo '<br><br>';
  //echo var_dump($result);
  //echo '<br><br>';
  
  //$all = $result->fetch(PDO::FETCH_ASSOC);
  //echo "<table>";
  //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   // echo "<tr>";
    //echo "<td>" . $row["tipo_nome"] . "</td>";
    //echo "<td>" . $row["nome"] . "</td>";
    //echo "<td>" . $row[0] . "</td>";
    //echo "<td>" . $row["sobrenome"] . "</td>";
    //echo "<td>" . $row[1] . "</td>";
    //echo "<td>" . $row["day"] . "</td>";
    //echo "<td>" . $row["month"] . "</td>";
    //echo "<td>" . $row["year"] . "</td>";
    //echo "<td>" . $row["sex"] . "</td>";
    //echo "<td>" . $row["ultimo_acesso"] . "</td>";
    //echo "<td>" . $row["status"] . "</td>";
    //echo "<td>" . $row["name"] . "</td>";
    //echo "<td>content: " . $row["content"] . "</td>";
     //echo "<td>content: " . pg_unescape_bytea($row["content"]) . "</td>";
     //echo "<td>content: " . pg_escape_bytea($row["content"]) . "</td>";
        //$raw = base64_encode($row["content"]);
    //echo "<td>encode: " . $raw . "</td>";
        //$dataUri = "data:image/jpeg;base64," . $raw;
        //echo "<td>image: <img src='$dataUri' /></td>";
        //$dataUri = "data:image/jpeg;base64," . $row["data"];
        //echo "<td><img src='$dataUri' /></td>";
    
    //echo "</tr>";
  //}
  //echo "</table>";
  //$result->closeCursor();

  
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
