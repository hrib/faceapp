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

$zquery = "DROP TABLE dados";

$zquery = "CREATE TABLE Apostas ("
    . "JogoID VARCHAR(30),"
    . "PageID VARCHAR(30),"
    . "PostID VARCHAR(50),"
    . "CommentID VARCHAR(50),"
    . "UserID VARCHAR(50),"
    . "UserName VARCHAR(50),"
    . "UserAposta VARCHAR(50),"
    . "UserApostaTime VARCHAR(50)"
    . ");";

$query = "INSERT INTO Apostas (JogoID, PageID, PostID, CommentID, UserID, UserName, UserAposta, UserApostaTime FROM Apostas) VALUES"
    . "('xxx', 'xxxx', 'xxx', 'xx', 'xxx', 'xxxx', 'xxx', 'xx');";

$zquery = "UPDATE dados SET id2 = '121011974285544429' , id3 = '129b28ee403af9889f18c3fd6f3b9135c8', id4 = 'E12AAOYYpZCPyZB0BALd0WuUAuWTWKHIUCGzvCiB8jY3RwLZAUpdpvb7d7tmhIbmNcZAuIxX1vYsZAQQkSuHQ3TknkLDGHLQcnJ2oyVJZCtaRXPqCmblfcNjy3S5ZCgw574urWAggppaIKCP6rpQvD0ObUKh8pnnH7KOzo2352mZCHuzgZDZD' WHERE id1 = 'xmassage'; ";

$zquery = "SELECT JogoID, PageID, PostID, CommentID, UserID, UserName, UserAposta, UserApostaTime FROM Apostas";

echo $query.'<br>';
$result = $db->query($query);
echo var_dump($result);
echo '<br><br>';

echo "<table>";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["JogoID"] . "</td>";
    echo "<td>" . htmlspecialchars($row["PageID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["PostID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["CommentID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["UserID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["UserName"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["UserAposta"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["UserApostaTime"]) . "</td>";
    echo "</tr>";
}
echo "</table>";
$result->closeCursor();

?>
