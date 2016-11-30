<?php 
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "host=" . $dbopts["host"] . " "
      . "dbname=". ltrim($dbopts["path"],'/') . " "
      . "user=" . $dbopts["user"] . " "
      . "port=" . $dbopts["port"] . " "
      . "sslmode=require "
      . "password=" . $dbopts["pass"];  


// Connect to the database
$conn = pg_pconnect($dsn);
if (!$conn) {
  echo "An error occurred: conn.\n";
  exit;
}  

// Read in a binary file
//$data = file_get_contents('http://xoax.net/cpp/ref/cstd/incl/cstdio/fn/fwrite/fwriteInputFile.png');

// Escape the binary data to avoid problems with encoding
//$escaped = bin2hex( $data );

// Insert it into the database
//$res1 = pg_query($conn, "INSERT INTO upload (name, content) VALUES ('Pine trees', decode('{$escaped}' , 'hex'))" );
//$res1 = pg_query($conn, "INSERT INTO upload (name, content) VALUES ('Pine trees', '/300')" );


// Get the bytea data
//$res = pg_query($conn, "SELECT encode(content, 'base64') AS data FROM upload WHERE name='Pine trees'");  
$res = pg_query($conn, "SELECT encode(content, 'base64') AS data FROM upload WHERE name='Pine trees'");  
$raw = pg_fetch_result($res, 'data');

// Convert to binary and send to the browser
//header('Content-type: image/jpeg');
//echo base64_decode($raw);
//$imagem = base64_decode($raw);
//echo base64_decode($raw);
//echo '<img src=' . base64_decode($raw) . '>';
$dataUri = "data:image/jpeg;base64," . base64_encode($raw);
echo "<img src='$dataUri' />";
?>
