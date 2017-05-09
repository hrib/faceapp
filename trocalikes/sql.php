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
$query = "DROP TABLE tl_cadastro";
$result = $db->query($query);
//echo var_dump($result);
echo 'aqui<br><br>';
$query = "CREATE TABLE tl_cadastro ("
    . "id SERIAL, "
    . "user_id VARCHAR(30), "
    . "user_name VARCHAR(50), "
    . "pagina VARCHAR(80) "
    . ");";
$result = $db->query($query);
//echo var_dump($result);
echo 'aqui<br><br>';
$query = "INSERT INTO tl_cadastro(user_id, user_name, pagina) VALUES('12345678901234567890', 'fulano de tal2', 'http://facebook.com/rconstantinoliberal/');";

//$query = "UPDATE dados SET id2 = '121011974285544429' , id3 = '129b28ee403af9889f18c3fd6f3b9135c8', id4 = 'E12AAOYYpZCPyZB0BALd0WuUAuWTWKHIUCGzvCiB8jY3RwLZAUpdpvb7d7tmhIbmNcZAuIxX1vYsZAQQkSuHQ3TknkLDGHLQcnJ2oyVJZCtaRXPqCmblfcNjy3S5ZCgw574urWAggppaIKCP6rpQvD0ObUKh8pnnH7KOzo2352mZCHuzgZDZD' WHERE id1 = 'xmassage'; ";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$user_id = "4";
$user_name = "quatroA";

$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
$result = $db->query($query);

$user_id = "4";
$user_name = "quantroB";

$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
$result = $db->query($query);

$user_id = "5";
$user_name = "cinco";

$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
$result = $db->query($query);

$user_id = "6";
$user_name = "seis";

$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
$result = $db->query($query);

//$user_id = '6';
//$user_name = "seis";

//$query = "INSERT INTO tl_cadastro(user_id, user_name) SELECT '" . $user_id . "', '" . $user_name . "' FROM tl_cadastro where not exists (select 1 from tl_cadastro where user_id = '" . $user_id . "');";
//$result = $db->query($query);

//    $query = "SELECT user_name FROM tl_cadastro WHERE user_id = '" . $user_id . "';";
//    $result = $db->query($query);
//    $row = $result->fetch();
//    echo $row["user_name"];




$query = "SELECT id, user_id, user_name, pagina FROM tl_cadastro;";
$result = $db->query($query);
//echo var_dump($result);
//echo 'aqui resultados<br><br>';

echo '<table border="1" style="font-family:arial; font-size:7px;">';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["user_name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["pagina"]) . "</td>";
    echo "</tr>";
}
echo "</table>";
$result->closeCursor();
//$app->register(new Herrera\Pdo\PdoServiceProvider(), $zica);
echo 'aqui<br><br>';
?>
