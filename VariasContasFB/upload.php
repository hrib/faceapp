<form method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr>
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile">
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>

<?php
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
  $fileName = $_FILES['userfile']['name'];
  $tmpName  = $_FILES['userfile']['tmp_name'];
  $fileSize = $_FILES['userfile']['size'];
  $fileType = $_FILES['userfile']['type'];

  $fp      = fopen($tmpName, 'r');
  $content = fread($fp, filesize($tmpName));
  $content = addslashes($content);
  fclose($fp);

  if(!get_magic_quotes_gpc())
  {
      $fileName = addslashes($fileName);
  }

  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];
  $db = new PDO($dsn);

  $query = "INSERT INTO upload (name, size, type, content ) VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
  $result = $db->query($query);

  echo '<br><br>';
  echo var_dump($result->fetch(PDO::FETCH_ASSOC));
  echo '<br><br>';

  $result->closeCursor();
  echo "<br>File $fileName uploaded<br>";
}
?>
