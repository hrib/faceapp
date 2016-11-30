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
  $data = fread($fp, filesize($tmpName));
  //$content = addslashes($content);
  $content = pg_escape_bytea($data); 
  fclose($fp);

  if(!get_magic_quotes_gpc())
  {
      $fileName = addslashes($fileName);
  }
  
  
  //$fi =  $_FILES['thumbnail']['tmp_name'];
  //$p=fopen($fi,'r');
  //$data=fread($p,filesize($fi));
  //$data=addslashes($data);
  //$dat= pg_escape_bytea($data); 
  //$q="update userinfo set image='{$dat}' where email='$user'";
  //$e=pg_query($q)or die(pg_last_error());
  
  

  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];
  $db = new PDO($dsn);

  $query = "INSERT INTO upload (id, name, size, type, content) VALUES (1, '$fileName', '$fileSize', '$fileType', '$content')";
  echo '<br>' . $query . '<br>';
  $result = $db->query($query);

  echo '<br><br>';
  echo var_dump($result->fetch(PDO::FETCH_ASSOC));
  echo '<br><br>';

  $result->closeCursor();
  echo "<br>File $fileName uploaded<br>";
}
?>
