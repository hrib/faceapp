<?php
    
    $token = getenv('INS_APP_TOKEN');
    $userID = '2988722378';
    $action = 'follow';
 
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

    

?>
