<h2>Input</h2>
<form action="/trocalikes/gerencia.php" method="post">
  <div>
    <textarea name="content" rows="10" cols="180">
DELETE FROM tl_cadastro WHERE id = 1; 
CREATE TABLE tl_cadastro (id SERIAL, user_id VARCHAR(30), user_name VARCHAR(50), pagina VARCHAR(80)); 
DROP TABLE tl_cadastro; 
SELECT * FROM tl_cadastro ORDER BY id; 
CREATE TABLE tl_cliques (id SERIAL, tempo TIMESTAMP, dono_id VARCHAR(30), dono_page VARCHAR(80), dono_post VARCHAR(100), clicker_id VARCHAR(30), clicker_check INT);
INSERT INTO tl_cliques (tempo , dono_id , dono_page , dono_post , clicker_id , clicker_check) VALUES (now(), 'dono id 123', 'dono page site', 'dono post postagem', 'click erid identidade', 0);  
    </textarea></div>
  <div><textarea name="sql" rows="5" cols="180">select * from tl_cadastro order by id</textarea></div>
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
