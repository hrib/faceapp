<h2>Input</h2>
<form action="/trocalikes/gerencia.php" method="post">
  <div><textarea name="content" rows="5" cols="100">DELETE FROM tl_cadastro WHERE id = 1; &#13;&#10CREATE TABLE tl_cadastro (id SERIAL, user_id VARCHAR(30), user_name VARCHAR(50), pagina VARCHAR(80)); &#13;&#10DROP TABLE tl_cadastro &#13;&#10SELECT * FROM tl_cadastro ORDER BY id &#13;&#10SELECT * FROM tl_cadastro; </textarea></div>
  <div><textarea name="sql" rows="5" cols="100">select * from tl_cadastro order by id</textarea></div>
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
