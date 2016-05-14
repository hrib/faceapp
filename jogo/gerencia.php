<html>
 <body>
  <h2>Entries</h2>
  <?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/consultadb.php');
 
  $varum = $_POST['name'];
  $vardois = $_POST['content'];
  $sqltodo = $_POST['sql'];
  
  //$sqltodo = "INSERT INTO person (FNAME, LNAME) VALUES ('um','dois')";
  //$sqltodo = "DELETE from person WHERE ID > 4";
  
  
  echo $sqltodo;
  //funciona: $retorno = (new minhaclasse())->usaDB('ALTER TABLE person add column Id INT NOT NULL AUTO_INCREMENT FIRST, ADD primary KEY Id(Id)');
  //funciona: $retorno = (new minhaclasse())->usaDB("UPDATE person SET FNAME='91560115454240194', LNAME='ze9b7a69cc961d012592996b2dd540e3a' LIMIT 1" );
  echo '<br>'; 
  //$retorno = (new minhaclasse())->usaDB("INSERT INTO person (FNAME, LNAME) VALUES ('$varum','$vardois')" );
  echo '<br>';
  $retorno = (new minhaclasse())->usaDB("$sqltodo");
  foreach($retorno as $row) {
  echo "<div>" . $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4] . " | " . $row[5] . " | " . $row[6] . " | " . $row[7] . " | " . $row[8] . " | " . $row[9] . " | " . $row[10] . " | " . $row[11] . " | " . $row[12] . "</div>";
  }
  echo '<br>';
 
  //$retorno = (new minhaclasse())->usaDB('SELECT * from person');
  //foreach($retorno as $row) {
  //echo "<div>" . $row['FNAME'] . " " . $row['LNAME'] . " " . $row['Id'] . "</div>";
  //}
  ?>



  <h2>Input</h2>
  <form action="/gerencia.php" method="post">
    <div><textarea name="name" rows="1" cols="20"></textarea></div>
    <div><textarea name="content" rows="1" cols="20"></textarea></div>
    <div><textarea name="sql" rows="5" cols="100"></textarea></div>
    <div><input type="submit" value="Input"></div>
  </form>
  </body>
</html>
