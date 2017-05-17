

<h2>Input</h2>
<form action="/trocalikes/gerenciateste2.php" method="post" enctype="multipart/form-data">
  <div>
    <textarea name="content" rows="10" cols="200">
SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id
    </textarea></div>
  <div><textarea name="sql" rows="5" cols="200"><?php //echo $query; ?></textarea></div>
  <div><input type="submit" value="Input"></div>
</form>
