<?php
    
    $token = getenv('INS_APP_TOKEN');
    $id_to_get_followers = '327771661';
    


    
    
    $url = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_token='.$token;
    // Initialize session and set URL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
    // Get the response and close the channel.
    $response = curl_exec($ch);
    curl_close($ch);
    
    $resjson = json_decode($response);
    var_dump($resjson);    
    
    foreach($resjson->data as $follower){
        echo $follower->username;
        echo '<br>';
    }
 
    
    
    
    $id_to_follow = '40911127';
    $url = 'https://api.instagram.com/v1/users/'.$id_to_follow.'/relationship';
    $data = array('action' => 'follow', 'access_token' => $token);
    
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
    echo $result;
    echo '<br>';

    $resjson = json_decode($result);

    

?>
