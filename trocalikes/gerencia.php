<h2>Input</h2>
<form action="/trocalikes/gerencia.php" method="post">
  <div><textarea name="content" value="SELECT * FROM tl_cadastro 'r 2"  rows="5" cols="20"></textarea>SELECT * FROM tl_cadastro &#13;&#10 SELECT * FROM tl_cadastro; </div>
  <div><textarea name="sql" rows="5" cols="100">SELECT * FROM tl_cadastro</textarea></div>
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

  print_r($result);
  
  echo '<table border="1" style="font-family:arial; font-size:7px;">';
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      foreach($row as $item) {
        echo "<td>" . htmlspecialchars($item) . "</td>";
      }
      echo "</tr>";
  }
  echo "</table>";
  $result->closeCursor();
}



?>
