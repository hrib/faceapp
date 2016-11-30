

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

$query = "SELECT id, name FROM upload";
$result = $db->query($query) or die('Error, query failed');
 
if($result == 0)
{
  echo "Database is empty <br>";
}
else
{
  while ($row = $result->fetch(PDO::FETCH_ASSOC)){
  {
    ?>
    <a href="download.php?id=<?php=$row['id'];?>"><?php=$row['name'];?></a> <br>
    <?php
  }
}
$result->closeCursor();
?>
</body>
</html>
