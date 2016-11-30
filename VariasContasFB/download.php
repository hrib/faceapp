

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
 
if($result == 0)
{
  echo "Database is empty <br>";
}
else
{
  echo "<table>";
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>";
      header("Content-length: $size");
      header("Content-type: $type");
      header("Content-Disposition: attachment; filename=$name");
      echo $content;
    echo "</td>";
    
    echo "</tr>";
  }
  echo "</table>";
  
  
  
}
$result->closeCursor();
?>



