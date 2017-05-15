function calcula_creditos_individual($user_id, $fb, $accessToken){
  //VERIFICACAO
  $retorno = sql_query("SELECT * FROM tl_cliques WHERE clicker_check = 'esperando' ORDER BY id;"); 
  while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
      $check_inicial = checa_clique_post($row['id'], $row['tempo_update'], $row['dono_post'], $row['clicker_id'], $fb, $accessToken);	
  }
  $retorno->closeCursor();
    
  //CALCULO
  $creditos_cliente = sql_query("SELECT creditos, usados, saldo FROM (SELECT coalesce(T1.clicker_id,  T2.dono_id) as usuario, (COALESCE(T1.n_creditos,0)) as Creditos, (COALESCE(T2.n_usados,0)) as Usados, (COALESCE(T1.n_creditos,0) + COALESCE(T2.n_usados, 0)) as Saldo FROM (SELECT clicker_id, COUNT(*) as n_creditos FROM tl_cliques WHERE clicker_check = 'clicado' GROUP BY clicker_id) AS T1 FULL OUTER JOIN (SELECT dono_id, -COUNT(*) as n_usados FROM tl_cliques  WHERE clicker_check = 'clicado' GROUP BY dono_id) AS T2 ON T1.clicker_id = T2.dono_id) FINAL WHERE usuario = '" . $user_id ."';");
  while ($row = $creditos_cliente->fetch(PDO::FETCH_ASSOC)) {
        $creditos = $row['creditos'];
        $usados = -$row['usados'];
        $saldo = $row['saldo'];
  }
  $creditos_cliente->closeCursor();
  return array($creditos, $usados, $saldo);
}
