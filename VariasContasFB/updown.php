<?php 

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
$data = file_get_contents('http://xoax.net/cpp/ref/cstd/incl/cstdio/fn/fwrite/fwriteInputFile.png');

// Escape the binary data to avoid problems with encoding
$escaped = bin2hex( $data );

// Insert it into the database
$res1 = pg_query($conn, "INSERT INTO upload (name, content) VALUES ('Pine trees', decode('{$escaped}' , 'hex'))" );

// Get the bytea data
$res = pg_query($conn, "SELECT encode(data, 'base64') AS data FROM upload WHERE name='Pine trees'");  
$raw = pg_fetch_result($res, 'data');

// Convert to binary and send to the browser
header('Content-type: image/jpeg');
echo base64_decode($raw);
?>
