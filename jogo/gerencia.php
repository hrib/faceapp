<html>
 <body>
  <h2>Entries</h2>
<?php
  
$query = $_POST['sql'];
  
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}
$pg_conn = pg_connect(pg_connection_string_from_database_url());
$result = pg_query($pg_conn, $query);
var_dump($result);
echo '<br>';
while ($row = pg_fetch_row($result)) { 
    foreach($row as $valor)
    {
      print("$valor :");
    }
    echo '<br>';
}

?>

  <h2>Input</h2>
  <form action="/jogo/gerencia.php" method="post">
    <div><textarea name="name" rows="1" cols="20"></textarea></div>
    <div><textarea name="content" rows="1" cols="20"></textarea></div>
    <div><textarea name="sql" rows="5" cols="100"></textarea></div>
    <div><input type="submit" value="Input"></div>
  </form>
  </body>
</html>
