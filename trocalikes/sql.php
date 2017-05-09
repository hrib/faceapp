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
    . "zz INT, "
    . "zzz INT, "
    . "user_id INT, "
    . "user_name VARCHAR(50), "
    . "pagina VARCHAR(50) "
    . ");";
$result = $db->query($query);
//echo var_dump($result);
echo 'aqui<br><br>';
$query = "INSERT INTO tl_cadastro(zz, zzz, user_id, user_name, pagina) VALUES(2, 3, 4, 'fulano de tal', 'http://facebook.com/rconstantinoliberal/');";

//$query = "UPDATE dados SET id2 = '121011974285544429' , id3 = '129b28ee403af9889f18c3fd6f3b9135c8', id4 = 'E12AAOYYpZCPyZB0BALd0WuUAuWTWKHIUCGzvCiB8jY3RwLZAUpdpvb7d7tmhIbmNcZAuIxX1vYsZAQQkSuHQ3TknkLDGHLQcnJ2oyVJZCtaRXPqCmblfcNjy3S5ZCgw574urWAggppaIKCP6rpQvD0ObUKh8pnnH7KOzo2352mZCHuzgZDZD' WHERE id1 = 'xmassage'; ";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';
$query = "SELECT ID, zz, zzz, user_id, user_name, pagina FROM tl_cadastro;";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui resultados<br><br>';

echo '<table border="1" style="font-family:arial; font-size:7px;">';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["zz"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["zzz"]) . "</td>";
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
