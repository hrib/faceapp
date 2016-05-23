<?php
    
    $token = getenv('INS_APP_TOKEN');
    $id_to_get_followers = '2988722378';
    
    $url = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_token='.$token.'&count=10';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    
    echo '<table border="1">';
    foreach($resjson->data as $follower){
        $relacionamento = checaRelacao($follower->id, $token);
        $acao = '-';
        if($relacionamento == 'none'){
            //modificaRelacao($follower->id, $token, 'follow'); 
            $acao = 'follow';
            //set_time_limit(10); 
            //sleep(5);
        }
        echo '<tr>';
        echo '<td>'. $follower->username .'</td>';
        echo '<td>'. $follower->id .'</td>';
        echo '<td>'. $relacionamento .'</td>';
        echo '<td>'. $acao .'</td>';
        echo '</tr>';
    }
    echo '</table>';
    modificaRelacao($follower->id, $token, 'follow');
 
    function checaRelacao($userID, $token){
        $id_to_follow = $userID;
        $url = 'https://api.instagram.com/v1/users/'.$id_to_follow.'/relationship?access_token='.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $resjson = json_decode($response);
        return $resjson->data->outgoing_status;
    }
    
    
    
    function modificaRelacao($userID, $token, $action){
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
        var_dump $result;
        echo '<br>';
        $resjson = json_decode($result);
    }

    

?>
