<h2>Input</h2>
<form action="/trocalikes/gerencia.php" method="post">
  <div><textarea name="name" rows="1" cols="20"></textarea></div>
  <div><textarea name="content" rows="1" cols="20"></textarea></div>
  <div><textarea name="sql" rows="5" cols="100"></textarea></div>
  <div><input type="submit" value="Input"></div>
</form>

<h2>Entries</h2>
  
  
<?php
  
$query = $_POST['sql'];
  
if (isset($query)) {  
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

  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $result->fetch(PDO::FETCH_BOTH)) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["user_name"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["pagina"]) . "</td>";
      echo "<td>" . htmlspecialchars($row[0]) . "</td>";
      echo "<td>" . htmlspecialchars($row[1]) . "</td>";
      echo "<td>" . htmlspecialchars($row[2]) . "</td>";
      echo "<td>" . htmlspecialchars($row[3]) . "</td>";
      echo "</tr>";
  }
  echo "</table>";
  $result->closeCursor();
}



?>
