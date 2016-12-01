<?php


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
  echo var_dump($result);
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
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>content: " . $row["content"] . "</td>";
     echo "<td>content: " . pg_unescape_bytea($row["content"]) . "</td>";
     echo "<td>content: " . pg_escape_bytea($row["content"]) . "</td>";
        $raw = base64_encode($row["content"]);
    echo "<td>encode: " . $raw . "</td>";
        $dataUri = "data:image/jpeg;base64," . $raw;
        echo "<td>image: <img src='$dataUri' /></td>";
        //$dataUri = "data:image/jpeg;base64," . $row["data"];
        //echo "<td><img src='$dataUri' /></td>";
    
    echo "</tr>";
  }
  echo "</table>";
  $result->closeCursor();
  
}



?>
