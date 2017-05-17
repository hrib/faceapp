<?php
  
//$query = $_POST['sql'];
//$query2 = $_POST['sql2'];
//echo $query;
?>

<h2>Input</h2>
<form action="/trocalikes/gerenciateste.php" method="post">
  <div>
    <textarea name="content" rows="10" cols="200">
DELETE FROM tl_cadastro WHERE id = 1; 
CREATE TABLE tl_cadastro (id SERIAL, tempo TIMESTAMP, user_id VARCHAR(30), user_name VARCHAR(50), pagina VARCHAR(80)); 
DROP TABLE tl_cadastro; 
SELECT * FROM tl_cadastro ORDER BY id; 
CREATE TABLE tl_cliques (id SERIAL, tempo TIMESTAMP, dono_id VARCHAR(30), dono_page VARCHAR(80), dono_post VARCHAR(100), clicker_id VARCHAR(30), clicker_check VARCHAR(15));
INSERT INTO tl_cliques (tempo , dono_id , dono_page , dono_post , clicker_id , clicker_check) VALUES (now(), 'dono id 123', 'dono page site', 'dono post postagem', 'click erid identidade', 'esperando');  
    </textarea></div>
  <div><textarea name="sql" rows="5" cols="200"><?php //echo $query; ?></textarea></div>
  <div><input type="submit" value="Input"></div>
</form>

<form action="/trocalikes/gerenciateste.php" method="post">
  <div><textarea name="sql2" rows="5" cols="200">SELECT * FROM tl_cadastro ORDER BY id</textarea></div>
  <div><input type="submit" value="Lista Cadastro"></div>
</form>


<form action="/trocalikes/gerenciateste.php" method="post">
  <div><textarea name="sql2" rows="5" cols="200">SELECT * FROM ((SELECT coalesce(T1.clicker_id,  T2.dono_id) as usuario, (COALESCE(T1.n_creditos,0)) as Creditos, (COALESCE(T2.n_usados,0)) as Usados, (COALESCE(T1.n_creditos,0) + COALESCE(T2.n_usados, 0)) as Sobra FROM (SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id) AS T1 FULL OUTER JOIN (SELECT dono_id, -COUNT(*) as n_usados FROM tl_cliques  WHERE clicker_check = 'clicado' GROUP BY dono_id) AS T2 ON T1.clicker_id = T2.dono_id) AS TA FULL OUTER JOIN (SELECT user_id, user_name FROM tl_cadastro) AS TB ON TA.usuario = TB.user_id)</textarea></div>
  <div><input type="submit" value="Creditos"></div>
</form>
