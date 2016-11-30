

<html>
<head>
<title>Download File From MySQL</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];
  $db = new PDO($dsn);

$query = "SELECT name, type, size, content FROM upload";
$result = $db->query($query) or die('Error, query failed');

  
pg_query('SET bytea_output = "escape";');
$lquery ="select content from upload";
$lq = pg_query($lquery) or die(pg_last_error());
$lqq=pg_fetch_row($lq,'content');
header("conent-type:image");
echo pg_unescape_bytea($lqq[0]);  
  
  
  
  
if($result == 0)
{
  echo "Database is empty <br>";
}
else
{
  echo "<table>";
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    //echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>";
      header("Content-length: " . $row['size']);
      header("Content-type: " . $row['type']);
      //header("Content-Disposition: attachment; filename=" . $row['name']);
      //echo pg_unescape_bytea($row['content']);
    echo "</td>";
    
    echo "</tr>";
  }
  echo "</table>";
  
  
  
}
$result->closeCursor();
?>



