<?php
    
    $token = getenv('INS_APP_TOKEN');
    $id_to_get_followers = 'self';
    
    for ($x = 0; $x <= 10; $x++) {
        $url = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/follows?access_token='.$token.'&count=100&cursor='.$next_cursor; //.'&count=50'
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $resjson = json_decode($response);
        $next_cursor = $resjson->pagination->next_cursor
        //var_dump($resjson); 
        echo '<table border="1">';
        $conta = 0;
        foreach($resjson->data as $follower){
            $acao = '-';
            if(($relacionamento == 'none') AND ($conta < 10)){
                //set_time_limit(10); 
                //sleep(2);
                //$acao = modificaRelacao($follower->id, $token, 'follow'); 
                //$acao = 'fakefollow';
                //$conta = $conta + 1;
                //sleep(2);
            }
            echo '<tr>';
            echo '<td>'. $x .'</td>';
            echo '<td>'. $follower->username .'</td>';
            echo '<td>'. $follower->id .'</td>';
            //echo '<td>'. $relacionamento .'</td>';
            //echo '<td>'. $acao .'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    function modificaRelacao($userID, $token, $action){
        echo $userID;
        $id_to_follow = $userID;
        $url = 'https://api.instagram.com/v1/users/'.$id_to_follow.'/relationship';
        $data = array('action' => $action, 'access_token' => $token);
        
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */ }
        echo '<br>';
        echo '<br>';
        var_dump($result);
        echo '<br>';
        $resjson = json_decode($result);
        return $resjson->data->outgoing_status;
    }

    

?>
