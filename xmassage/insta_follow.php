<?php
    
    $token = getenv('INS_APP_TOKEN');
    //$id_to_get_followers = '327771661';
    $tag = 'London';
    //FollowSeguidoresdoUsuario($id_to_get_followers, $token);
    $ultimoid = UsuariosQuePostaramTag($tag, $token);
    $sigoid = QuemSigo($token);   
    $mediaid = MediaRecente($token);   
    
    require_once 'insta_directmessage.php';
    //CompartilhaMedia($ultimoid);
    CompartilhaMedia($sigoid, $mediaid);



function MediaRecente($token){
    $url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    
    echo '<table border="1">';
    $count = 0;
    $randnum = mt_rand(1,20);
    foreach($resjson->data as $media){
        echo '<tr>';
        echo '<td>'. $media->caption->text .'</td>';
        echo '<td>'. $media->id .'</td>';
        echo '</tr>';
        $count = $count + 1;
        $ultimoid = $media->id;
        if($count >= $randnum){break;}
    }
    echo '</table>';
    return $ultimoid;
}



function QuemSigo($token){
    $url = 'https://api.instagram.com/v1/users/self/follows?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    
    echo '<table border="1">';
    $count = 0;
    $randnum = mt_rand(1,20);
    foreach($resjson->data as $sigo){
        echo '<tr>';
        echo '<td>'. $sigo->username .'</td>';
        echo '<td>'. $sigo->id .'</td>';
        echo '</tr>';
        $count = $count + 1;
        $ultimoid = $sigo->id;
        if($count >= $randnum){break;}
    }
    echo '</table>';
    return $ultimoid;
}




function UsuariosQuePostaramTag($tag, $token){
    $url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?access_token='.$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    
    echo '<table border="1">';
    $count = 0;
    foreach($resjson->data as $post){
        set_time_limit(10); 
        sleep(2);
        $acao = modificaRelacaoCURL($post->caption->from->id, $token, 'follow'); 
        echo '<tr>';
        echo '<td>'. $post->caption->from->username .'</td>';
        echo '<td>'. $post->caption->from->id .'</td>';
        echo '<td>'. $acao .'</td>';
        //echo '<td><img src="'. $post->images->thumbnail->url .'"></td>';
        echo '</tr>';
        $count = $count + 1;
        $ultimoid = $post->caption->from->id;
        if($count >= 2){break;}
    }
    echo '</table>';
    return $ultimoid;
}


    
    
function FollowSeguidoresdoUsuario($id_to_get_followers, $token){
    $url = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_token='.$token.'&count=50';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    //var_dump($resjson);    
    
    echo '<table border="1">';
    $conta = 0;
    foreach($resjson->data as $follower){
        $relacionamento = checaRelacao($follower->id, $token);
        $acao = '-';
        if(($relacionamento == 'none') AND ($conta < 10)){
            set_time_limit(10); 
            sleep(2);
            $acao = modificaRelacao($follower->id, $token, 'follow'); 
            //$acao = 'fakefollow';
            $conta = $conta + 1;
            sleep(2);
        }
        echo '<tr>';
        echo '<td>'. $follower->username .'</td>';
        echo '<td>'. $follower->id .'</td>';
        echo '<td>'. $relacionamento .'</td>';
        echo '<td>'. $acao .'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
 
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
    
    function modificaRelacaoCURL($userID, $token, $action){
        echo $userID;
        $id_to_follow = $userID;
        $url = 'https://api.instagram.com/v1/users/'.$id_to_follow.'/relationship';
        //$headerData = array('Accept: application/json');
        $headerData = array('Content-type: application/x-www-form-urlencoded\r\n');
        $data = array('action' => $action, 'access_token' => $token);
        $paramString = '&' . http_build_query($data);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
        
        
        $jsonData = curl_exec($ch);
        
        
        echo '<br>';
        echo '<br>';
        var_dump($jsonData);
        echo '<br>';

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($jsonData, 0, $header_size);
        $body = substr($jsonData, $header_size);
        curl_close($ch);
        echo '<br>';
        //var_dump($header);
        echo '<br>';        
        echo '<br>';
        //var_dump($body);
        echo '<br>';


        $resjson = json_decode($body);
        //var_dump(json_last_error($jsonData));
        //var_dump($resjson);
        echo '<br>';
        echo '<br>';
        return $resjson->data->outgoing_status;
    }

    

?>
